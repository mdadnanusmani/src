<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTactionsModel {

    function lockTicket($id) {
        /*
          lock = 0 means unlocked
          lock = 1 means locked
         */
        if (!is_numeric($id))
            return false;
        if ( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()) {
            $allow = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Lock Ticket');
            if ($allow != true) {
                JSSTmessage::setMessage(__('You are not allowed', 'js-support-ticket'), 'error');
                return;
            }
        }
        $sendEmail = true;
        $date = date_i18n('Y-m-d H:i:s');

        $row = JSSTincluder::getJSTable('tickets');
        if ($row->update(array('id' => $id, 'lock' => 1))) {
            // echo "<pre>";print_r(jssupportticket::$_db);exit;
            JSSTmessage::setMessage(__('Ticket has been locked', 'js-support-ticket'), 'updated');
            $messagetype = __('Successfully', 'js-support-ticket');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Ticket has not been locked', 'js-support-ticket'), 'error');
            $messagetype = __('Error', 'js-support-ticket');
            $sendEmail = false;
        }

        /* for activity log */
        $ticketid = $id; // get the ticket id
        $current_user = wp_get_current_user(); // to get current user name
        $currentUserName = $current_user->display_name;
        $eventtype = __('Lock Ticket', 'js-support-ticket');
        $message = __('Ticket is locked by', 'js-support-ticket') . " ( " . $currentUserName . " ) ";
        if(in_array('tickethistory', jssupportticket::$_active_addons)){
            JSSTincluder::getJSModel('tickethistory')->addActivityLog($ticketid, 1, $eventtype, $message, $messagetype);
        }

        // Send Emails
        if ($sendEmail == true) {
            JSSTincluder::getJSModel('email')->sendMail(1, 6, $ticketid); // Mailfor, Lock Ticket, Ticketid
            $ticketobject = jssupportticket::$_db->get_row("SELECT * FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE id = " . $ticketid);
            do_action('jsst-ticketclose', $ticketobject);
        }
        return;
    }

    function unLockTicket($id) {
        /*
          lock = 0 means unlocked
          lock = 1 means locked
         */
        if (!is_numeric($id))
            return false;
        $sendEmail = true;
        $date = date_i18n('Y-m-d H:i:s');

        $row = JSSTincluder::getJSTable('tickets');
        if ($row->update(array('id' => $id, 'lock' => 0))) {
            JSSTmessage::setMessage(__('Ticket has been unlocked', 'js-support-ticket'), 'updated');
            $messagetype = __('Successfully', 'js-support-ticket');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Ticket has not been unlocked', 'js-support-ticket'), 'error');
            $messagetype = __('Error', 'js-support-ticket');
            $sendEmail = false;
        }

        /* for activity log */
        $ticketid = $id; // get the ticket id
        $current_user = wp_get_current_user(); // to get current user name
        $currentUserName = $current_user->display_name;
        $eventtype = __('Unlock Ticket', 'js-support-ticket');
        $message = __('Ticket is unlocked by', 'js-support-ticket') . " ( " . $currentUserName . " ) ";
        if(in_array('tickethistory', jssupportticket::$_active_addons)){
            JSSTincluder::getJSModel('tickethistory')->addActivityLog($ticketid, 1, $eventtype, $message, $messagetype);
        }

        // Send Emails
        if ($sendEmail == true) {
            JSSTincluder::getJSModel('email')->sendMail(1, 7, $ticketid); // Mailfor, Unlock Ticket, Ticketid
            $ticketobject = jssupportticket::$_db->get_row("SELECT * FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE id = " . $ticketid);
            do_action('jsst-ticketclose', $ticketobject);
        }
        return;
    }
}
?>
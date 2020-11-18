<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSToverdueModel {

    private $ticketid;

    function markOverDueTicket($data, $cron_flag = 0) {
        if($cron_flag == 0){
            $ticketid = $data['ticketid'];
        }else{
            $ticketid = $data;
        }

        if (!is_numeric($ticketid))
            return false;

        if (!$this->checkActionStatusSame($ticketid, array('action' => 'markoverdue'))) {
            JSSTmessage::setMessage(__('Ticket already marked overdue', 'js-support-ticket'), 'error');
            return;
        }
        if($cron_flag == 0){
            if ( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()) {
                $allow = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Mark Overdue');
                if ($allow != true) {
                    JSSTmessage::setMessage(__('You are not allowed', 'js-support-ticket'), 'updated');
                    return;
                }
            }
        }
        $sendEmail = true;
        $date = date_i18n('Y-m-d H:i:s');

        $row = JSSTincluder::getJSTable('tickets');
        if ($row->update(array('id' => $ticketid, 'isoverdue' => 1, 'updated' => $date))) {
            JSSTmessage::setMessage(__('Ticket has been marked as overdue', 'js-support-ticket'), 'updated');
            $messagetype = __('Successfully', 'js-support-ticket');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Ticket has not been marked as overdue', 'js-support-ticket'), 'error');
            $messagetype = __('Error', 'js-support-ticket');
            $sendEmail = false;
        }

        /* for activity log */
        if($cron_flag == 0){
            $current_user = wp_get_current_user(); // to get current user name
            $currentUserName = $current_user->display_name;
        }else{
            $currentUserName = __('System', 'js-support-ticket');
        }
        $eventtype = __('Mark overdue', 'js-support-ticket');
        $message = __('Ticket is marked as overdue by', 'js-support-ticket') . " ( " . $currentUserName . " ) ";
        if(in_array('tickethistory', jssupportticket::$_active_addons)){
            JSSTincluder::getJSModel('tickethistory')->addActivityLog($ticketid, 1, $eventtype, $message, $messagetype);
        }

        // Send Emails
        if ($sendEmail == true) {
            JSSTincluder::getJSModel('email')->sendMail(1, 8, $ticketid); // Mailfor, Overdue Ticket, Ticketid
            $ticketobject = jssupportticket::$_db->get_row("SELECT * FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE id = " . $ticketid);
            do_action('jsst-ticketclose', $ticketobject);
        }
        return;
    }

    function unMarkOverDueTicket($data) {
        $ticketid = $data['ticketid'];
        if (!is_numeric($ticketid))
            return false;
        if ( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()) {
            $allow = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Mark Overdue');
            if ($allow != true) {
                JSSTmessage::setMessage(__('You are not allowed', 'js-support-ticket'), 'updated');
                return;
            }
        }
        $date = date_i18n('Y-m-d H:i:s');

        $row = JSSTincluder::getJSTable('tickets');
        if ($row->update(array('id' => $ticketid, 'isoverdue' => 0, 'updated' => $date))) {
            JSSTmessage::setMessage(__('Ticket has been unmarked as overdue', 'js-support-ticket'), 'updated');
            $messagetype = __('Successfully', 'js-support-ticket');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Ticket has not been unmarked as overdue', 'js-support-ticket'), 'error');
            $messagetype = __('Error', 'js-support-ticket');
        }
        /* for activity log */
        //if($cron_flag == 0){
        $current_user = wp_get_current_user(); // to get current user name
        $currentUserName = $current_user->display_name;
         // }else{
        //     $currentUserName = __('System', 'js-support-ticket');
        //}
        $eventtype = __('Unmark overdue', 'js-support-ticket');
        $message = __('Ticket is unmarked as overdue by', 'js-support-ticket') . " ( " . $currentUserName . " ) ";
        if(in_array('tickethistory', jssupportticket::$_active_addons)){
            JSSTincluder::getJSModel('tickethistory')->addActivityLog($ticketid, 1, $eventtype, $message, $messagetype);
        }
        return;
    }

    function updateTicketStatusToOverDueCron() {
       // overdue type by priority
        $curdate= date("Y-m-d H:i:s");
        $query = "SELECT id, overduetypeid, overdueinterval FROM `" . jssupportticket::$_db->prefix . "js_ticket_priorities` WHERE status = 1";
        $priority_overdue = jssupportticket::$_db->get_results($query);
        if(!empty($priority_overdue)){
            // overdue ticket admin/staff not answered mark overdue
            foreach ($priority_overdue as $key) {
                if($key->overduetypeid == 1){
                    $intrval_string = " date(DATE_ADD(lastreply,INTERVAL " . (int)$key->overdueinterval." DAY)) < '".date("Y-m-d")."' AND priorityid =" .$key->id;
                }else{
                    $intrval_string = " DATE_ADD(lastreply,INTERVAL " .(int) $key->overdueinterval . " HOUR) < '".date("Y-m-d H:i:s")."' AND priorityid =" .$key->id;
                }
                $query = "SELECT id FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE ".$intrval_string." AND status != 0 AND status != 4 AND (isanswered != 1  OR isanswered IS NULL) AND (isoverdue != 1  OR isoverdue IS NULL)";
                $ticketids = jssupportticket::$_db->get_results($query);
                if(!empty($ticketids)){
                    foreach ($ticketids as $ticket) {
                        if(is_numeric($ticket->id)){
                            JSSTincluder::getJSMOdel('overdue')->markOverDueTicket($ticket->id,$curdate,$cron_flag=1);
                        }
                    }
                }
            }
            // overdue ticket new ticket not reply anyone
            foreach ($priority_overdue as $key) {
                if($key->overduetypeid == 1){
                    $intrval_string = " date(DATE_ADD(created,INTERVAL " . (int)$key->overdueinterval." DAY)) < '".date("Y-m-d")."' AND priorityid =" .$key->id;
                }else{
                    $intrval_string = " DATE_ADD(created,INTERVAL " . (int)$key->overdueinterval . " HOUR) < '".date("Y-m-d H:i:s")."' AND priorityid =" .$key->id;
                }
                $query = "SELECT id FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE ".$intrval_string." AND status = 0 AND (isoverdue != 1  OR isoverdue IS NULL)";
                $ticketids = jssupportticket::$_db->get_results($query);
                if(!empty($ticketids)){
                    foreach ($ticketids as $ticket ) {
                        if(is_numeric($ticket->id)){
                            JSSTincluder::getJSMOdel('overdue')->markOverDueTicket($ticket->id,$curdate,$cron_flag=1);
                        }
                    }
                }
            }
        }
        return;
    }

    function markTicketOverdueCron(){
        // overdue ticket admin/staff set overdue date and ticket not closed and not is answered
        $query = "SELECT id FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE date(duedate) < CURDATE() AND status != 4 AND isanswered != 1 AND duedate != '0000-00-00 00:00:00' AND (isoverdue != 1 OR isoverdue IS NULL)";
        $ticketids = jssupportticket::$_db->get_results($query);
        if(!empty($ticketids)){
            foreach ($ticketids as $key) {
                if(is_numeric($key->id)){
                    JSSTincluder::getJSModel('overdue')->markOverDueTicket($key->id,1);
                }
            }
        }
        return;
    }

    function checkActionStatusSame($id, $array) {
        switch ($array['action']) {
            case 'priority':
                if(!is_numeric($id)) return false;
                $result = jssupportticket::$_db->get_var('SELECT COUNT(id) FROM `' . jssupportticket::$_db->prefix . 'js_ticket_tickets` WHERE id = ' . $id . ' AND priorityid = ' . $array['id']);
                break;
            case 'markoverdue':
                if(!is_numeric($id)) return false;
                $result = jssupportticket::$_db->get_var('SELECT COUNT(id) FROM `' . jssupportticket::$_db->prefix . 'js_ticket_tickets` WHERE id = ' . $id . ' AND isoverdue = 1');
                break;
            case 'markinprogress':
                if(!is_numeric($id)) return false;
                $result = jssupportticket::$_db->get_var('SELECT COUNT(id) FROM `' . jssupportticket::$_db->prefix . 'js_ticket_tickets` WHERE id = ' . $id . ' AND status = 2');
                break;
            case 'closeticket':
                if(!is_numeric($id)) return false;
                $result = jssupportticket::$_db->get_var('SELECT COUNT(id) FROM `' . jssupportticket::$_db->prefix . 'js_ticket_tickets` WHERE id = ' . $id . ' AND status = 4');
                break;
            case 'banemail':
                $result = jssupportticket::$_db->get_var('SELECT COUNT(id) FROM `' . jssupportticket::$_db->prefix . 'js_ticket_email_banlist` WHERE email = "' . $array['email'] . '"');
                break;
        }
        if ($result > 0) {
            return false;
        } else {
            return true;
        }
    }
}

?>
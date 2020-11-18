<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTmaxticketModel {

    function checkMaxTickets($emailaddress) {
        if (is_user_logged_in()) {
            $query = "SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE uid = " . get_current_user_id();
        } else {
            $query = "SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE email = '" . $emailaddress . "'";
        }
        $counts = jssupportticket::$_db->get_var($query);
        if ($counts >= jssupportticket::$_config['maximum_tickets']) {
            JSSTmessage::setMessage(__('Limit exceeds maximum tickets', 'js-support-ticket'), 'error');
            return false;
        }
        return true;
    }

    function checkMaxOpenTickets($emailaddress) {
        if (is_user_logged_in()) {
            $uid = get_current_user_id();
            $query = "SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE uid = " . $uid . " AND status != 4";
        } else {
            $query = "SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE email = '" . $emailaddress . "' AND status != 4";
        }
        $counts = jssupportticket::$_db->get_var($query);
        if ($counts >= jssupportticket::$_config['maximum_open_tickets']) {
            JSSTmessage::setMessage(__('Limit exceeds maximum open tickets', 'js-support-ticket'), 'error');
            return false;
        }
        return true;
    }

}

?>

<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTautocloseModel {

    function autoCloseTicketsCron(){
        $query = "SELECT id FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE date(DATE_ADD(lastreply,INTERVAL " . jssupportticket::$_config['ticket_auto_close'] . " DAY)) < CURDATE() AND isanswered = 1 AND status != 4";
        $ticketids = jssupportticket::$_db->get_results($query);
        if(!empty($ticketids)){
            foreach ($ticketids as $key) {
                if(is_numeric($key->id)){
                    JSSTincluder::getJSModel('ticket')->closeTicket($key->id,1);
                }
            }
        }
        return;
    }

}

?>

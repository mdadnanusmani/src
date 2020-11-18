<?php
if (!defined('ABSPATH'))
    die('Restricted Access');
class JSTAgentactivation {

    static function jssupportticketaddon_activate() {
        // Install Database
        JSTAgentactivation::runSQL();
    }

    static function jssupportticketaddon_deactivate() {
        //string config for reactivation
        $query = "SELECT configvalue,configname  FROM `" . jssupportticket::$_db->prefix . "js_ticket_config` WHERE addon = 'agent';";
        $configurations  = jssupportticket::$_db->get_results($query);
        $config_array = array();
        foreach ($configurations as $key => $value) {
            $config_array[$value->configname] = $value->configvalue; // making an array that can be stored in option to recover config values on reactivation

            // disabling configuraitons to hide addon related data from main plugin.
            $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_config` SET configvalue = 0 WHERE  configname = '".$value->configname."' ;";
            jssupportticket::$_db->query($query);
        }
        update_option('JSTAgentactivation_config_string',json_encode($config_array));// config array stored in option to be used later.
    }

    static private function runSQL() {
                if(file_exists(dirname(__FILE__).'/addon-sql.php') && realpath(dirname(__FILE__).'/addon-sql.php')){
                    require dirname(__FILE__).'/addon-sql.php';
                    @unlink(dirname(__FILE__).'/addon-sql.php');
                }

        //  set configuraiton values
        $config_string = get_option('JSTAgentactivation_config_string');
        if($config_string != '' && !empty(json_decode($config_string,true))){ // if there are stored configuraations in the option table
            $config_array = json_decode($config_string,true);
        }else{ // if there are no stored configurations then set them to this.
            $config_array = array('new_ticket_mail_to_staff_members' => '1', 'ticket_reassign_staff' => '1', 'ticket_close_staff' => '1', 'ticket_delete_staff' => '1', 'ticket_mark_overdue_staff' => '1', 'ticket_department_transfer_staff' => '1', 'ticket_reply_ticket_user_staff' => '1', 'ticket_response_to_staff_admin' => '0', 'ticket_response_to_staff_staff' => '1', 'ticket_response_to_staff_user' => '1', 'ticket_lock_staff' => '1', 'ticket_unlock_staff' => '1', 'ticket_mark_progress_staff' => '1', 'ticket_priority_staff' => '1', 'cplink_openticket_staff' => '1', 'cplink_myticket_staff' => '1', 'cplink_addrole_staff' => '2', 'cplink_roles_staff' => '1', 'cplink_addstaff_staff' => '2', 'cplink_staff_staff' => '1', 'cplink_adddepartment_staff' => '2', 'cplink_myprofile_staff' => '1', 'tplink_home_staff' => '1', 'tplink_tickets_staff' => '1', 'cplink_login_logout_staff' => '1', 'cplink_staff_report_staff' => '1', 'cplink_department_report_staff' => '1', 'tplink_openticket_staff' => '1', 'cplink_latesttickets_staff' => '1', 'cplink_totalcount_staff' => '1', 'cplink_ticketstats_staff' => '1', 'cplink_department_staff' => '1');
        }

        foreach ($config_array as $key => $value) {// update configurations to support plug and play for addons.
            $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_config` SET configvalue = '".$value."' WHERE  configname = '".$key."' ;";
            jssupportticket::$_db->query($query);
        }
        return;
    }
}
?>
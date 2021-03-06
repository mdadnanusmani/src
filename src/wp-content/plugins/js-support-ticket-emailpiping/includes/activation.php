<?php
if (!defined('ABSPATH'))
    die('Restricted Access');
class JSTTicketviaemaileactivation {

    static function jssupportticketaddon_activate() {
        // Install Database
        JSTTicketviaemaileactivation::runSQL();
    }

    static function jssupportticketaddon_deactivate() {
        // string config for reactivation
        $query = "SELECT configvalue,configname  FROM `" . jssupportticket::$_db->prefix . "js_ticket_config` WHERE addon = 'emailpiping';";
        $configurations  = jssupportticket::$_db->get_results($query);
        $config_array = array();
        foreach ($configurations as $key => $value) {
            $config_array[$value->configname] = $value->configvalue; // making an array that can be stored in option to recover config values on reactivation

            // disabling configuraitons to hide addon related data from main plugin.
            $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_config` SET configvalue = 0 WHERE  configname = '".$value->configname."' ;";
            jssupportticket::$_db->query($query);
        }
        update_option('JSTemailpipingactivation_config_string',json_encode($config_array));// config array stored in option to be used later.
    }

    static private function runSQL() {
        if(file_exists(dirname(__FILE__).'/addon-sql.php') && realpath(dirname(__FILE__).'/addon-sql.php')){
            require dirname(__FILE__).'/addon-sql.php';
            @unlink(dirname(__FILE__).'/addon-sql.php');
        }

        //  set configuraiton values
        $config_string = get_option('JSTemailpipingactivation_config_string');
        if($config_string != '' && !empty(json_decode($config_string,true))){ // if there are stored configuraations in the option table
            $config_array = json_decode($config_string,true);
        }else{ // if there are no stored configurations then set them to this.
            $config_array = array('read_utf_ticket_via_email' => '1');
        }

        foreach ($config_array as $key => $value) {// update configurations to support plug and play for addons.
            $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_config` SET configvalue = '".$value."' WHERE  configname = '".$key."' ;";
            jssupportticket::$_db->query($query);
        }

        return;
    }
}
?>
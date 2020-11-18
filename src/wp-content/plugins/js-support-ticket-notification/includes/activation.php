<?php
if (!defined('ABSPATH'))
    die('Restricted Access');
class JSTNotificationactivation {

    static function jssupportticketaddon_activate() {
        // Install Database
        JSTNotificationactivation::runSQL();
    }

    static function jssupportticketaddon_deactivate() {
        // string config for reactivation
        $query = "SELECT configvalue,configname  FROM `" . jssupportticket::$_db->prefix . "js_ticket_config` WHERE addon = 'notification';";
        $configurations  = jssupportticket::$_db->get_results($query);
        $config_array = array();
        foreach ($configurations as $key => $value) {
            $config_array[$value->configname] = $value->configvalue; // making an array that can be stored in option to recover config values on reactivation

            // disabling configuraitons to hide addon related data from main plugin.
            $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_config` SET configvalue = 0 WHERE  configname = '".$value->configname."' ;";
            jssupportticket::$_db->query($query);
        }
        update_option('JSTNotificationactivation_config_string',json_encode($config_array));// config array stored in option to be used later.
    }

    static private function runSQL() {

        //check include and remove file
        if(file_exists(dirname(__FILE__).'/addon-sql.php') && realpath(dirname(__FILE__).'/addon-sql.php')){
            require dirname(__FILE__).'/addon-sql.php';
            @unlink(dirname(__FILE__).'/addon-sql.php');
        }
        //  set configuraiton values
        $config_string = get_option('JSTNotificationactivation_config_string');
        if($config_string != '' && !empty(json_decode($config_string,true))){ // if there are stored configuraations in the option table
            $config_array = json_decode($config_string,true);
        }else{ // if there are no stored configurations then set them to this.
            $config_array = array('0d607e93d5af0655351743b41ed67944' => '', 'apiKey_firebase' => '', 'authDomain_firebase' => '', 'databaseURL_firebase' => '', 'projectId_firebase' => '', 'storageBucket_firebase' => '', 'messagingSenderId_firebase' => '', 'server_key_firebase' => '', 'logo_for_desktop_notfication_url' => '');
        }

        foreach ($config_array as $key => $value) {// update configurations to support plug and play for addons.
            $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_config` SET configvalue = '".$value."' WHERE  configname = '".$key."' ;";
            jssupportticket::$_db->query($query);
        }
        return;
    }
}
?>
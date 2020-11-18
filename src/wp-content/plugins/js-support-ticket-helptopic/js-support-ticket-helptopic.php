<?php
/**
* @package JS Support Ticket Helptopic
* @version 1.0.0
*/
/*
Plugin Name: JS Support Ticket Helptopic
Plugin URI: https://www.joomsky.com
Description:  Helptopic Addon for JS Support Ticket.
Author: Joom Sky
Version: 1.0.0
Author URI: https://www.joomsky.com
*/

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTHelptopic{
        public static $_addon_version;

    function __construct() {
        self::$_addon_version = '1.0.0';
        add_action( 'plugins_loaded', array($this,'jsst_addon_update_check' ));
        //parent::__construct(__FILE__);
        self::includes();
        //add_filter('cron_schedules', array($this,'jsst_weekly_cron_notify' ));
        register_activation_hook(__FILE__, array($this, 'jstsupportitkcetaddon_activate_hook'));
        register_deactivation_hook(__FILE__, array($this, 'jssupportticketaddon_deactivate_hook'));



        add_action('get_mail_table_record_query', array($this, 'helptopic_hook'));
        add_action('ticket_detail_query', array($this, 'helptopic_hook_ticket_detail'));


    }

	function includes(){
		if(is_admin()){
			//include_once 'includes/jsticketdesktopnotificationadmin.php';
		}
		//include_once 'includes/shotcodes.php';

	}

    function jsst_addon_update_check() {
        // to manage updates for addon
        if(file_exists(dirname(__FILE__).'/includes/addon-sql.php') && realpath(dirname(__FILE__).'/includes/addon-sql.php')){
            require dirname(__FILE__).'/includes/addon-sql.php';
            @unlink(dirname(__FILE__).'/includes/addon-sql.php');
            update_option('jsst-addon-helptopic-version',JSSTHelptopic::$_addon_version);
        }
    }

    function jstsupportitkcetaddon_activate_hook(){
        if ( !class_exists('jssupportticket') ) {
            deactivate_plugins( plugin_basename( __FILE__ ) );
            wp_die( 'Install and activate JS Support Ticket Plugin for this plugin to work.' );
        }
        $plugin_data = get_plugin_data( __FILE__ );
        $plugin_version = $plugin_data['Version'];
        if(!JSSTincluder::getJSModel('jssupportticket')->updateDate('helptopic',$plugin_version)){
            do_action('jsst_addon_update_date_failed');
        }
        update_option('jsst-addon-helptopic-version',JSSTHelptopic::$_addon_version);
        include_once 'includes/activation.php';
        JSTHelptopiceactivation::jssupportticketaddon_activate();
        // wp_schedule_event(time(), 'weekly', 'jsstnotification_cronjobs_action');
        // update_option('jsstnotification_do_activation_redirect', true);
    }

    function jssupportticketaddon_deactivate_hook(){
        if (class_exists('jssupportticket') ) {
            JSSTincluder::getJSModel('premiumplugin')->logAddonDeactivation('helptopic');
        }
        include_once 'includes/activation.php';
        JSTHelptopiceactivation::jssupportticketaddon_deactivate();
    }

	function helptopic_hook() {
		$select_query =" ,helptopic.topic ";
		$join_query = " LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_help_topics` AS helptopic ON helptopic.id = ticket.helptopicid ";
		jssupportticket::$_addon_query['select'] .= $select_query;
		jssupportticket::$_addon_query['join'] .= $join_query;
    }

    function helptopic_hook_ticket_detail() {
        $select_query =" , helptopic.topic AS helptopic ";
        $join_query = " LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_help_topics` AS helptopic ON ticket.helptopicid = helptopic.id ";
        jssupportticket::$_addon_query['select'] .= $select_query;
        jssupportticket::$_addon_query['join'] .= $join_query;
    }



}

$JSSTHelptopic = new JSSTHelptopic();

?>
<?php
/**
* @package JS Support Ticket Knowledgebase
* @version 1.0.0
*/
/*
Plugin Name: JS Support Ticket Knowledgebase
Plugin URI: https://www.joomsky.com
Description:  Knowledge Base Addon for JS Support Ticket.
Author: Joom Sky
Version: 1.0.0
Author URI: https://www.joomsky.com
*/

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTKnowledgebase{
        public static $_addon_version;

    function __construct() {
        self::$_addon_version = '1.0.0';
        add_action( 'plugins_loaded', array($this,'jsst_addon_update_check' ));
        //parent::__construct(__FILE__);
        self::includes();
        //add_filter('cron_schedules', array($this,'jsst_weekly_cron_notify' ));
        register_activation_hook(__FILE__, array($this, 'jstsupportitkcetaddon_activate_hook'));
        register_deactivation_hook(__FILE__, array($this, 'jssupportticketaddon_deactivate_hook'));


        add_action('jsst_addon_get_staff_anncounement', array($this, 'jsst_get_staff_anncounement'));
        add_action('jsst_addon_get_staff_download', array($this, 'jsst_get_staff_downloads'));
        add_action('jsst_addon_get_staff_download_form', array($this, 'jsst_get_staff_download_form'));
        add_action('jsst_addon_get_staff_faq', array($this, 'jsst_get_staff_faqs'));
    }

	function includes(){
		if(is_admin()){
			//include_once 'includes/jsticketdesktopnotificationadmin.php';
		}
		include_once 'includes/shotcodes.php';

	}

    function jsst_addon_update_check() {
        // to manage updates for addon
        if(file_exists(dirname(__FILE__).'/includes/addon-sql.php') && realpath(dirname(__FILE__).'/includes/addon-sql.php')){
            require dirname(__FILE__).'/includes/addon-sql.php';
            @unlink(dirname(__FILE__).'/includes/addon-sql.php');
            update_option('jsst-addon-knowledgebase-version',JSSTKnowledgebase::$_addon_version);
        }
    }

    function jstsupportitkcetaddon_activate_hook(){
        if ( !class_exists('jssupportticket') ) {
            deactivate_plugins( plugin_basename( __FILE__ ) );
            wp_die( 'Install and activate JS Support Ticket Plugin for this plugin to work.' );
        }
        $plugin_data = get_plugin_data( __FILE__ );
        $plugin_version = $plugin_data['Version'];
        if(!JSSTincluder::getJSModel('jssupportticket')->updateDate('knowledgebase',$plugin_version)){
            do_action('jsst_addon_update_date_failed');
        }
        update_option('jsst-addon-knowledgebase-version',JSSTKnowledgebase::$_addon_version);
        include_once 'includes/activation.php';
        JSTKnowledgebaseactivation::jssupportticketaddon_activate();
        // wp_schedule_event(time(), 'weekly', 'jsstnotification_cronjobs_action');
        // update_option('jsstnotification_do_activation_redirect', true);
    }

    function jssupportticketaddon_deactivate_hook(){
        if (class_exists('jssupportticket') ) {
            JSSTincluder::getJSModel('premiumplugin')->logAddonDeactivation('knowledgebase');
        }
        include_once 'includes/activation.php';
        JSTKnowledgebaseactivation::jssupportticketaddon_deactivate();
    }

	function jsst_get_staff_anncounement() {
		$select_query = " ,category.name AS categoryname ";
		$join_query = " LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_categories` AS category ON announcement.categoryid = category.id ";
		jssupportticket::$_addon_query['select'] .= $select_query;
		jssupportticket::$_addon_query['join'] .= $join_query;
    }

    function jsst_get_staff_downloads() {
        $select_query =" ,category.name AS categoryname ";
        $join_query = " LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_categories` AS category ON download.categoryid = category.id ";
        jssupportticket::$_addon_query['select'] .= $select_query;
        jssupportticket::$_addon_query['join'] .= $join_query;
    }

    function jsst_get_staff_download_form() {
        $select_query =" , category.name AS categoryname ";
        $join_query = " LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_categories` AS category ON download.categoryid = category.id ";
        jssupportticket::$_addon_query['select'] .= $select_query;
        jssupportticket::$_addon_query['join'] .= $join_query;
    }

    function jsst_get_staff_faqs() {
        $select_query =" ,category.name AS categoryname ";
        $join_query = " LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_categories` AS category ON faq.categoryid = category.id ";
        jssupportticket::$_addon_query['select'] .= $select_query;
        jssupportticket::$_addon_query['join'] .= $join_query;
    }
}
$JSSTKnowledgebase = new JSSTKnowledgebase();
?>
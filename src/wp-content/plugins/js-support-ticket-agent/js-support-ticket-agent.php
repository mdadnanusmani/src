<?php
/**
* @package JS Support Ticket Agents
* @version 1.0.1
*/
/*
Plugin Name: JS Support Ticket Agents
Plugin URI: https://www.joomsky.com
Description:  Agents Addon for JS Support Ticket.
Author: Joom Sky
Version: 1.0.1
Author URI: https://www.joomsky.com
*/

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTAgents{
    public static $_addon_version;

    function __construct() {
        self::$_addon_version = '1.0.1';
        add_action( 'plugins_loaded', array($this,'jsst_addon_update_check' ));

        //parent::__construct(__FILE__);
        self::includes();
        //add_filter('cron_schedules', array($this,'jsst_weekly_cron_notify' ));
        register_activation_hook(__FILE__, array($this, 'jstsupportitkcetaddon_activate_hook'));
        register_deactivation_hook(__FILE__, array($this, 'jssupportticketaddon_deactivate_hook'));


        add_action('jsst_staff_admin_cp_query', array($this, 'staff_admin_cp_query'));
        add_action('jsst_aadon_getreplies', array($this, 'staff_aadon_getreplies'));
        add_action('jsst_addon_staff_admin_tickets', array($this, 'jsst_addon_admin_tickets'));
        add_action('jsst_addon_user_my_tickets', array($this, 'jsst_addon_my_tickets'));
        add_action('jsst_addon_staff_merge_ticket', array($this, 'jsst_addon_merge_ticket'));
        add_action('ticket_detail_query', array($this, 'ticket_detail_query'));
        add_action('jsstgetnotes', array($this, 'jsstgetNotes'));
        add_action('jsstBanEmails', array($this, 'jsstBanEmails'));
        add_action('jsstFeedbacksForAdmin', array($this, 'jsstFeedbacksForAdmin'));
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
            update_option('jsst-addon-agents-version',JSSTAgents::$_addon_version);
        }
    }

    function jstsupportitkcetaddon_activate_hook(){
        if ( !class_exists('jssupportticket') ) {
            deactivate_plugins( plugin_basename( __FILE__ ) );
            wp_die( 'Install and activate JS Support Ticket Plugin for this plugin to work.' );
        }
        $plugin_data = get_plugin_data( __FILE__ );
        $plugin_version = $plugin_data['Version'];
        if(!JSSTincluder::getJSModel('jssupportticket')->updateDate('agent',$plugin_version)){
            do_action('jsst_addon_update_date_failed');
        }

        update_option('jsst-addon-agents-version',JSSTAgents::$_addon_version);
        include_once 'includes/activation.php';
        JSTAgentactivation::jssupportticketaddon_activate();
        // wp_schedule_event(time(), 'weekly', 'jsstnotification_cronjobs_action');
        // update_option('jsstnotification_do_activation_redirect', true);
    }

    function jssupportticketaddon_deactivate_hook(){
        if (class_exists('jssupportticket') ) {
            JSSTincluder::getJSModel('premiumplugin')->logAddonDeactivation('agent');
        }
        include_once 'includes/activation.php';
        JSTAgentactivation::jssupportticketaddon_deactivate();
    }

	function jsstgetNotes() {
		$select_query =" ,staff.uid,staff.id AS staff_id, staff.id AS staffid, staff.photo AS staffphoto,CONCAT(staff.firstname,' ',staff.lastname) AS staffname,user.display_name ";
		$join_query = " LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff ON staff.uid = note.staffid ";
		jssupportticket::$_addon_query['select'] .= $select_query;
		jssupportticket::$_addon_query['join'] .= $join_query;
    }

    function staff_admin_cp_query() {
        $select_query =" ,CONCAT(staff.firstname ,'  ' ,staff.lastname) AS staffname,staff.id AS staffid, staff.photo AS staffphoto ";
        $join_query =" LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff ON ticket.staffid = staff.id ";
        jssupportticket::$_addon_query['select'] .= $select_query;
        jssupportticket::$_addon_query['join'] .= $join_query;
    }

    function staff_aadon_getreplies() {
        $select_query =" , staff.id AS staffid, staff.email AS staffemail, staff.photo AS staffphoto ";
        $join_query =" LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff ON replies.staffid = staff.id ";
        jssupportticket::$_addon_query['select'] .= $select_query;
        jssupportticket::$_addon_query['join'] .= $join_query;
    }

    function jsst_addon_admin_tickets() {
        $select_query =" , CONCAT(staff.firstname ,'  ' ,staff.lastname) AS staffname,staff.id AS staffid, staff.photo AS staffphoto ";
        $join_query = " LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff ON ticket.staffid = staff.id ";
        jssupportticket::$_addon_query['select'] .= $select_query;
        jssupportticket::$_addon_query['join'] .= $join_query;
    }

    function jsst_addon_my_tickets() {
        $select_query =" ,staff.firstname AS staffname ";
        $join_query = " LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff ON ticket.staffid = staff.id ";
        jssupportticket::$_addon_query['select'] .= $select_query;
        jssupportticket::$_addon_query['join'] .= $join_query;
    }

    function jsst_addon_merge_ticket() {
        $select_query =" ,staff.photo AS staffphoto,staff.id AS staffid ";
        $join_query = " LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff ON staff.uid = ticket.uid ";
        jssupportticket::$_addon_query['select'] .= $select_query;
        jssupportticket::$_addon_query['join'] .= $join_query;
    }

    function ticket_detail_query() {
        $select_query = " ,CONCAT(staff.firstname ,'  ' ,staff.lastname) AS staffname, staff.id AS staffid, staff.photo AS staffphoto, staffphoto.photo AS staffphotophoto,staffphoto.id AS staffphotoid ";
        $join_query = " LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff ON ticket.staffid = staff.id
                        LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staffphoto ON ticket.uid = staffphoto.uid ";
        jssupportticket::$_addon_query['select'] .= $select_query;
        jssupportticket::$_addon_query['join'] .= $join_query;
    }

    function jsstBanEmails() {
        $select_query = " ,concat(staff.firstname,' ',staff.lastname) AS staffname ";
        $join_query = " LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff ON banemail.submitter = staff.id ";
        jssupportticket::$_addon_query['select'] .= $select_query;
        jssupportticket::$_addon_query['join'] .= $join_query;
    }

    function jsstFeedbacksForAdmin() {
        $select_query = " ,staff.firstname,staff.lastname ";
        $join_query = " LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff ON ticket.staffid = staff.id ";
        jssupportticket::$_addon_query['select'] .= $select_query;
        jssupportticket::$_addon_query['join'] .= $join_query;
    }

}

$JSSTAgents = new JSSTAgents();

?>
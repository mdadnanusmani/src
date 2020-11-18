<?php
/**
* @package JS Support Ticket Internal Mail
* @version 1.0.0
*/
/*
Plugin Name: JS Support Ticket Internal Mail
Plugin URI: https://www.joomsky.com
Description:  Internal Mail Addon for for JS Support Ticket.
Author: Joom Sky
Version: 1.0.0
Author URI: https://www.joomsky.com
*/

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTMail{
    	public static $_addon_version;

    function __construct() {
    	self::$_addon_version = '1.0.0';
    	add_action( 'plugins_loaded', array($this,'jsst_addon_update_check' ));
        //parent::__construct(__FILE__);
        self::includes();
        //add_filter('cron_schedules', array($this,'jsst_weekly_cron_notify' ));
        register_activation_hook(__FILE__, array($this, 'jstsupportitkcetaddon_activate_hook'));
        register_deactivation_hook(__FILE__, array($this, 'jssupportticketaddon_deactivate_hook'));

        //add_action('plugins_loaded', array($this, 'addAdminMenuItem'));
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
		    update_option('jsst-addon-mail-version',JSSTMail::$_addon_version);
		}
	}

	function jstsupportitkcetaddon_activate_hook(){
		if ( !class_exists('jssupportticket') ) {
		    deactivate_plugins( plugin_basename( __FILE__ ) );
		    wp_die( 'Install and activate JS Support Ticket Plugin for this plugin to work.' );
	        }
		$plugin_data = get_plugin_data( __FILE__ );
		$plugin_version = $plugin_data['Version'];
		if(!JSSTincluder::getJSModel('jssupportticket')->updateDate('mail',$plugin_version)){
		    do_action('jsst_addon_update_date_failed');
		}
		update_option('jsst-addon-mail-version',JSSTMail::$_addon_version);
		include_once 'includes/activation.php';
		JSTMailactivation::jssupportticketaddon_activate();
        // wp_schedule_event(time(), 'weekly', 'jsstnotification_cronjobs_action');
        // update_option('jsstnotification_do_activation_redirect', true);
    }

	function jssupportticketaddon_deactivate_hook(){
		if (class_exists('jssupportticket') ) {
			JSSTincluder::getJSModel('premiumplugin')->logAddonDeactivation('mail');
        }
		include_once 'includes/activation.php';
		JSTMailactivation::jssupportticketaddon_deactivate();
    }

 //    function jsst_weekly_cron_notify($schedules){
 //        $schedules['weekly'] = array(
 //            'interval' => 604800,
 //            'display' => __('Once Weekly')
 //        );
 //        return $schedules;
 //    }

 //    function jsstnotification_activation_redirect(){
 //        if (get_option('jsstnotification_do_activation_redirect') == true) {
 //            update_option('jsstnotification_do_activation_redirect',false);
 //            exit(wp_redirect(admin_url('admin.php?page=ticket-notification-setting')));
 //        }
 //    }

	// function registerscript(){
	// 	wp_enqueue_script( 'ticket-notify-app', 'https://www.gstatic.com/firebasejs/5.8.2/firebase-app.js' );
	// 	wp_enqueue_script( 'ticket-notify-message', 'https://www.gstatic.com/firebasejs/5.8.2/firebase-messaging.js' );
	// 	wp_enqueue_script('ticket-notify-app');
 //        wp_enqueue_script('ticket-notify-message');
 //        add_action('ticket-notify-generate-token', array($this , 'generatetickettoken'));
 //    }

	// function generatetickettoken(){
	// 	wp_register_script( 'ticket-notify-generate-token', plugin_dir_url( __DIR__ ) . '/js-ticket-desktop-notification/includes/js/generate-token.js' );
	// 	$ticket_notiy_session = isset($_SESSION['js-support-ticket']['notificationid']) ? 1 : 0;
	// 	wp_localize_script('ticket-notify-generate-token', 'js_ticket_notify', array('ticket_notify_session' => $ticket_notiy_session, 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'ticket_notify_message_js' => TICKET_NOTIFY_MESSAGE_JS));
	// 	wp_enqueue_script('ticket-notify-generate-token');
	// }

 //    function jsstnotification_cronjobs(){
 //        JSSTincluder::getJSModel('jssupportticket')->jsstnotification_cronjob_check();
 //    }

	// function sendpushnotification($attr){
 //        $deviceid = $attr['devicetoken'];
 //        $apikey   = jssupportticket::$_config['server_key_firebase'];
 //        $title    = $attr['title'];
 //        $body     = $attr['body'];
 //        $link     = isset($attr['link']) ? $attr['link'] : '';

 //        $file_name = JSSTincluder::getJSModel('configuration')->getConfigValue('logo_for_desktop_notfication_url');
 //        if($file_name != ''){
 //            $maindir = wp_upload_dir();
 //            $ticket_logo = $maindir['baseurl'].'/'.jssupportticket::$_config['data_directory'].'/attachmentdata/'.$file_name;
 //            echo var_dump($ticket_logo);die('in other plugin');
 //        }else{
 //            $ticket_logo = plugin_dir_url( __DIR__ ) . '/js-ticket-desktop-notification/includes/images/notification_image.png';
 //        }



 //        $url = 'https://fcm.googleapis.com/fcm/send';
 //        $fields = array (
 //            'to' => $deviceid,
 //            'priority' => 'high',
 //            'notification' => array (
 //                "title" => $title,
 //                "body" => $body,
 //                "icon"  => $ticket_logo,
 //            ),
 //            'data' => array(
 //                "link" => $link,
 //            ),
 //        );

 //        $fields = json_encode ( $fields );
 //        $headers = array (
 //                "Authorization" => "key=" .$apikey,
 //                "Content-Type" => "application/json"
 //        );


 //        $response = wp_remote_post( $url, array('body' => $fields,'timeout'=>7,'sslverify'=>false, 'headers'=>$headers));
 //        return true;
 //    }

 //    function ticketuserpreferences($data){
 //    	jssupportticket::$_db->replace(jssupportticket::$_db->prefix . 'js_ticket_notification_data', $data);
 //      	if($data['uid'] == 0){
 //            if(isset($_SESSION['js-support-ticket']['notificationid'])){
 //              unset($_SESSION['js-support-ticket']['notificationid']);
 //            }
 //        	$_SESSION['js-support-ticket']['notificationid'] = jssupportticket::$_db->insert_id;
 //      	}
 //      	if(jssupportticket::$_db->last_error != null){
 //        	throw new Exception("Could not subscribe");
 //      	}
 //      	$row = jssupportticket::$_db->insert_id; // get the preference id
	// }
	function showAdminPage() {
        $page = JSSTrequest::getVar('page');
        JSSTincluder::include_file($page);
    }

}

$JSSTMail = new JSSTMail();

?>
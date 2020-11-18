<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class jsticketdesktopnotificationadmin {

    function __construct() {
        add_action('admin_menu', array($this, 'js_ticket_notification_menu'));
    }

    function js_ticket_notification_menu(){
        add_submenu_page('jssupportticket', // parent slug
            __('Ticket Notification', 'js-support-ticket'), // Page title
            __('Ticket Notification', 'js-support-ticket'), // menu title
            'jsst_support_ticket', // capability
            'ticket-notification-setting', //menu slug
            array($this, 'showAdminPage') // function name
        );
    }

    function showAdminPage(){
        require_once( plugin_dir_path( __FILE__ ) . '/register_key.php');
    }

}

$jsticketdesktopnotificationadmin = new jsticketdesktopnotificationadmin();

?>

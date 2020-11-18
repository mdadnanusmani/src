<?php

/**
 * @package JS Help Desk
 * @author Ahmad Bilal
 * @version 2.1.6
 */
/*
  Plugin Name: JS Help Desk
  Plugin URI: https://www.joomsky.com
  Description: JS Help Desk is a trusted open source ticket system. JS Help Desk is a simple, easy to use, web-based customer support system. User can create ticket from front-end. JS Help Desk comes packed with lot features than most of the expensive(and complex) support ticket system on market. JS Help Desk provide you best industry help desk system.
  Author: Joom Sky
  Version: 2.1.6
  Text Domain: js-support-ticket
  Author URI: https://www.joomsky.com
 */

if (!defined('ABSPATH'))
    die('Restricted Access');

class jssupportticket {

    public static $_path;
    public static $_pluginpath;
    public static $_data; /* data[0] for list , data[1] for total paginition ,data[2] userfieldsforview , data[3] userfield for form , data[4] for reply , data[5] for ticket history  , data[6] for internal notes  , data[7] for ban email  , data['ticket_attachment'] for attachment */
    public static $_pageid;
    public static $_db;
    public static $_config;
    public static $_sorton;
    public static $_sortorder;
    public static $_ordering;
    public static $_sortlinks;
    public static $_msg;
    public static $_wpprefixforuser;
    public static $_colors;
    public static $_active_addons;
    public static $_addon_query;
    public static $_currentversion;


    function __construct() {
        // to check what addons are active and create an array.
        $plugin_array = get_option('active_plugins');
        $addon_array = array();
        foreach ($plugin_array as $key => $value) {
            $plugin_name = pathinfo($value, PATHINFO_FILENAME);
            if(strstr($plugin_name, 'js-support-ticket-')){
                $addon_array[] = str_replace('js-support-ticket-', '', $plugin_name);
            }
        }
        self::$_active_addons = $addon_array;
        // above code is its right place



        self::includes();
        self::registeractions();
        self::$_path = plugin_dir_path(__FILE__);
        self::$_pluginpath = plugins_url('/', __FILE__);
        self::$_data = array();
        self::$_currentversion = '216';
        self::$_addon_query = array('select'=>'','join'=>'','where'=>'');
        global $wpdb;
        self::$_db = $wpdb;
        if(is_multisite()) {
            self::$_wpprefixforuser = $wpdb->base_prefix;
        }else{
            self::$_wpprefixforuser = self::$_db->prefix;
        }
        add_filter('cron_schedules',array($this,'jssupportticket_customschedules'));
        add_filter('the_content', array($this, 'checkRequest'));
        JSSTincluder::getJSModel('configuration')->getConfiguration();
        register_activation_hook(__FILE__, array($this, 'jssupportticket_activate'));
        register_deactivation_hook(__FILE__, array($this, 'jssupportticket_deactivate'));
        add_action('plugins_loaded', array($this, 'load_plugin_textdomain'));
        add_action('jssupporticket_updateticketstatus', array($this,'updateticketstatus'));
        if(in_array('actions',jssupportticket::$_active_addons)){
            add_action('template_redirect', array($this, 'printTicket'), 5); // Only for the print ticket in wordpress
        }
        add_action('admin_init', array($this, 'jssupportticket_activation_redirect'));
        add_action( 'wp_footer', array($this,'checkScreenTag') );
        add_action( 'resetnotificationvalues', array($this, 'resetNotificationValues'));
        //for style sheets
        add_action('wp_head', array($this,'jsst_register_plugin_styles'));
        add_action('admin_enqueue_scripts', array($this,'jsst_admin_register_plugin_styles') );
        add_action('reset_jsst_aadon_query', array($this,'reset_jsst_aadon_query') );
        add_action('jssupporticket_ticketviaemail', array($this,'ticketviaemail'));// this also handles ticket over due and ticket feedback
 }

    function jssupportticket_customschedules($schedules){
        $schedules['halfhour'] = array(
           'interval' => 1800,
           'display'=> 'Half hour'
        );
       return $schedules;
    }

    function jssupportticket_activate() {
        include_once 'includes/activation.php';
        JSSTactivation::jssupportticket_activate();
        wp_schedule_event(time(), 'daily', 'jssupporticket_updateticketstatus');
        add_option('jssupportticket_do_activation_redirect', true);
        wp_schedule_event(time(), 'halfhour', 'jssupporticket_ticketviaemail');// this also handles ticket overdue (bcz of hors configuration)
    }

    function jssupportticket_activation_redirect(){
        if (get_option('jssupportticket_do_activation_redirect')) {
            delete_option('jssupportticket_do_activation_redirect');
            exit(wp_redirect(admin_url('admin.php?page=postinstallation&jstlay=stepone')));
        }
    }

    /*
     * Update Ticket status every day schedule in the cron job
     */

    function updateticketstatus() {
        JSSTincluder::getJSModel('ticket')->updateTicketStatusCron();
    }

    /*
     * Email Piping every hourly schedule in the cron job
     */

     function printTicket() {
        $layout = JSSTrequest::getVar('jstlay');
        if ($layout == 'printticket') {
            $ticketid = JSSTrequest::getVar('jssupportticketid');
            if(in_array('agent', jssupportticket::$_active_addons)){
                jssupportticket::$_data['user_staff'] = JSSTincluder::getJSModel('agent')->isUserStaff();
            }else{
                jssupportticket::$_data['user_staff'] = false;
            }

            JSSTincluder::getJSModel('ticket')->getTicketForDetail($ticketid);
            jssupportticket::addStyleSheets();
            jssupportticket::jsst_register_plugin_styles();
            jssupportticket::$_data['print'] = 1; //print flag to handle appearnce
            JSSTincluder::include_file('ticketdetail', 'ticket');
            exit();
        }
    }

    function jssupportticket_deactivate() {
        include_once 'includes/deactivation.php';
        JSSTdeactivation::jssupportticket_deactivate();
    }

    function jsst_login_redirect( $redirect_to, $request, $user ) {
        //is there a user to check?
        global $user;
        if ( isset( $user->roles ) && is_array( $user->roles ) ) {
            //check for admins
            if ( in_array( 'administrator', $user->roles ) ) {
                // redirect them to the default place
                return $redirect_to;
            } else {
                $redirecturl = JSSTrequest::getVar('redirect_to');
                if(jssupportticket::$_config['login_redirect'] == 1 && $redirecturl == null){
                    $pageid = jssupportticket::getPageid();
                    $link = "index.php?page_id=".$pageid;
                    return $link;
                }elseif($redirecturl != null){
                    return $redirecturl;
                }else{
                    return home_url();
                }
            }
        } else {
            return $redirect_to;
        }
    }

    function resetNotificationValues(){ // config and key values empty
       // $query = "UPDATE `".jssupportticket::$_db->prefix."js_ticket_config` SET configvalue = '' WHERE configfor = 'firebase'";
       // $value = jssupportticket::$_db->get_var($query);
    }

    function registeractions() {
        //Extra Hooks
        //add_filter( 'login_redirect', array($this,'jsst_login_redirect'), 10, 3 );
        //Ticket Action Hooks
        add_action('jsst-ticketcreate', array($this, 'ticketcreate'), 10, 1);
        add_action('jsst-ticketreply', array($this, 'ticketreply'), 10, 1);
        add_action('jsst-ticketclose', array($this, 'ticketclose'), 10, 1);
        add_action('jsst-ticketdelete', array($this, 'ticketdelete'), 10, 1);
        add_action('jsst-ticketbeforelisting', array($this, 'ticketbeforelisting'), 10, 1);
        add_action('jsst-ticketbeforeview', array($this, 'ticketbeforeview'), 10, 1);
        //Email Hooks
        add_action('jsst-beforeemailticketcreate', array($this, 'beforeemailticketcreate'), 10, 4);
        add_action('jsst-beforeemailticketreply', array($this, 'beforeemailticketreply'), 10, 4);
        add_action('jsst-beforeemailticketclose', array($this, 'beforeemailticketclose'), 10, 4);
        add_action('jsst-beforeemailticketdelete', array($this, 'beforeemailticketdelete'), 10, 4);
    }

    //Funtions for Ticket Hooks
    function ticketcreate($ticketobject) {
        return $ticketobject;
    }

    function ticketreply($ticketobject) {
        return $ticketobject;
    }

    function ticketclose($ticketobject) {
        return $ticketobject;
    }

    function ticketdelete($ticketobject) {
        return $ticketobject;
    }

    function ticketbeforelisting($ticketobject) {
        return $ticketobject;
    }

    function ticketbeforeview($ticketobject) {
        return $ticketobject;
    }

    //Funtion for Email Hooks
    function beforeemailticketcreate($recevierEmail, $subject, $body, $senderEmail) {
        return;
    }

    function beforeemailticketdelete($recevierEmail, $subject, $body, $senderEmail) {
        return;
    }

    function beforeemailticketreply($recevierEmail, $subject, $body, $senderEmail) {
        return;
    }

    function beforeemailticketclose($recevierEmail, $subject, $body, $senderEmail) {
        return;
    }

    /*
     * Include the required files
     */

    function includes() {
        if (is_admin()) {
            include_once 'includes/jssupportticketadmin.php';
        }

        include_once 'includes/captcha.php';
        include_once 'includes/recaptchalib.php';
        include_once 'includes/layout.php';
        include_once 'includes/pagination.php';
        include_once 'includes/includer.php';
        include_once 'includes/formfield.php';
        include_once 'includes/request.php';
        include_once 'includes/breadcrumbs.php';
        include_once 'includes/formhandler.php';
        include_once 'includes/shortcodes.php';
        include_once 'includes/paramregister.php';
        include_once 'includes/message.php';
        include_once 'includes/ajax.php';
        include_once 'includes/jsst-hooks.php';

        //
        //include_once 'includes/addon-updater/jsstupdater.php';
    }

    /*
     * Localization
     */

    public function load_plugin_textdomain() {
        load_plugin_textdomain('js-support-ticket', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }

    /*
     * Check the current request and handle according to it
     */

    function checkRequest($content) {
        return $content;
    }

    /*
     * function for the Style Sheets
     */

    static function addStyleSheets() {
        wp_enqueue_script('jquery');
        wp_enqueue_script('commonjs',jssupportticket::$_pluginpath.'includes/js/common.js');
        if(in_array('notification', jssupportticket::$_active_addons)){
            wp_localize_script('commonjs', 'common', array('apiKey_firebase' => jssupportticket::$_config['apiKey_firebase'],'authDomain_firebase'=> jssupportticket::$_config['authDomain_firebase'],'databaseURL_firebase'=>jssupportticket::$_config['databaseURL_firebase'], 'projectId_firebase' => jssupportticket::$_config['projectId_firebase'], 'storageBucket_firebase' => jssupportticket::$_config['storageBucket_firebase'], 'messagingSenderId_firebase' => jssupportticket::$_config['messagingSenderId_firebase']));
        }
    }

    public static function jsst_register_plugin_styles(){
        wp_enqueue_style('jssupportticket-main-css', jssupportticket::$_pluginpath . 'includes/css/style.css');
        // responsive style sheets
        wp_enqueue_style('jssupportticket-tablet-css', jssupportticket::$_pluginpath . 'includes/css/style_tablet.css',array(),'','(min-width: 668px) and (max-width: 782px)');
        wp_enqueue_style('jssupportticket-mobile-css', jssupportticket::$_pluginpath . 'includes/css/style_mobile.css',array(),'','(min-width: 481px) and (max-width: 667px)');
        wp_enqueue_style('jssupportticket-oldmobile-css', jssupportticket::$_pluginpath . 'includes/css/style_oldmobile.css',array(),'','(max-width: 480px)');
        //wp_enqueue_style('jssupportticket-main-css');
        if(is_rtl()){
            //wp_register_style('jssupportticket-main-css-rtl', jssupportticket::$_pluginpath . 'includes/css/stylertl.css');
            wp_enqueue_style('jssupportticket-main-css-rtl', jssupportticket::$_pluginpath . 'includes/css/stylertl.css');
            //wp_enqueue_style('jssupportticket-main-css-rtl');
        }
        require_once 'includes/css/style.php';
    }

    public static function jsst_admin_register_plugin_styles() {
        wp_register_style('jsticket-admincss', jssupportticket::$_pluginpath . 'includes/css/admincss.css');
        wp_enqueue_style('jsticket-admincss');
        if(is_rtl()){
            wp_register_style('jsticket-admincss-rtl', jssupportticket::$_pluginpath . 'includes/css/admincssrtl.css');
            wp_enqueue_style('jsticket-admincss-rtl');
        }
    }

    /*
     * function to get the pageid from the wpoptions
     */

    public static function getPageid() {
        if(jssupportticket::$_pageid != ''){
            return jssupportticket::$_pageid;
        }else{
            $pageid = JSSTrequest::getVar('page_id','GET');
            if($pageid){
                return $pageid;
            }else{ // in case of categories popup
                $query = "SELECT configvalue FROM `".jssupportticket::$_db->prefix."js_ticket_config` WHERE configname = 'default_pageid'";
                $pageid = jssupportticket::$_db->get_var($query);
                return $pageid;
            }
        }
    }

    public static function setPageID($id) {
        jssupportticket::$_pageid = $id;
        return;
    }

    /*
     * function to parse the spaces in given string
     */

    public static function parseSpaces($string) {
        return str_replace('%20',' ',$string);
    }

    static function checkScreenTag(){
        if(!is_admin()){
            if (jssupportticket::$_config['support_screentag'] == 1) { // we need to show the support ticket tag
                $location = 'left';
                $borderradius = '0px 8px 8px 0px';
                $padding = '5px 10px 5px 20px';
                switch (jssupportticket::$_config['screentag_position']) {
                    case 1: // Top left
                        $top = "30px";
                        $left = "0px";
                        $right = "auto";
                        $bottom = "auto";
                    break;
                    case 2: // Top right
                        $top = "30px";
                        $left = "auto";
                        $right = "0px";
                        $bottom = "auto";
                        $location = 'right';
                        $borderradius = '8px 0px 0px 8px';
                        $padding = '5px 20px 5px 10px';
                    break;
                    case 3: // middle left
                        $top = "48%";
                        $left = "0px";
                        $right = "auto";
                        $bottom = "auto";
                    break;
                    case 4: // middle right
                        $top = "48%";
                        $left = "auto";
                        $right = "0px";
                        $bottom = "auto";
                        $location = 'right';
                        $borderradius = '8px 0px 0px 8px';
                        $padding = '5px 20px 5px 10px';
                    break;
                    case 5: // bottom left
                        $top = "auto";
                        $left = "0px";
                        $right = "auto";
                        $bottom = "30px";
                    break;
                    case 6: // bottom right
                        $top = "auto";
                        $left = "auto";
                        $right = "0px";
                        $bottom = "30px";
                        $location = 'right';
                        $borderradius = '8px 0px 0px 8px';
                        $padding = '5px 20px 5px 10px';
                    break;
                }
                // $html = '<style type="text/css">
                //             div#js-ticket_screentag{opacity:0;position:fixed;top:'.$top.';left:'.$left.';right:'.$right.';bottom:'.$bottom.';padding:'.$padding.';background:rgba(18, 17, 17, 0.5);z-index:9999;border-radius:'.$borderradius.';}
                //             div#js-ticket_screentag img.js-ticket_screentag_image{margin-'.$location.':10px;display:inline-block;}
                //             div#js-ticket_screentag a.js-ticket_screentag_anchor{color:#ffffff;text-decoration:none;}
                //             div#js-ticket_screentag span.text{display:inline-block;font-family:sans-serif;font-size:15px;}
                //         </style>';

                $html ='
                        <div id="js-ticket_screentag">
                        <a class="js-ticket_screentag_anchor" href="' . esc_url(site_url('?page_id=' . jssupportticket::$_config['default_pageid'])) . '">';
                if($location == 'right'){
                    $html .= '<img class="js-ticket_screentag_image" alt="screen tag" src="'.jssupportticket::$_pluginpath.'includes/images/support.png" /><span class="text">'.__("Support",'js-support-ticket').'</span>';
                }else{
                    $html .= '<span class="text">'.__("Support",'js-support-ticket').'</span><img class="js-ticket_screentag_image" alt="screen tag" src="'.jssupportticket::$_pluginpath.'includes/images/support.png" />';
                }
                $html .= '</a>
                        </div>
                        <script type="text/javascript">
                            jQuery(document).ready(function(){
                                jQuery("div#js-ticket_screentag").css("'.$location.'","-"+(jQuery("div#js-ticket_screentag span.text").width() + 25)+"px");
                                jQuery("div#js-ticket_screentag").css("opacity",1);
                                jQuery("div#js-ticket_screentag").hover(
                                    function(){
                                        jQuery(this).animate({'.$location.': "+="+(jQuery("div#js-ticket_screentag span.text").width() + 25)}, 1000);
                                    },
                                    function(){
                                        jQuery(this).animate({'.$location.': "-="+(jQuery("div#js-ticket_screentag span.text").width() + 25)}, 1000);
                                    }
                                );
                            });
                        </script>';
                echo $html;
            }
        }
    }

    static function makeUrl($args = array()){
        global $wp_rewrite;

        $pageid = JSSTrequest::getVar('jsstpageid');
        if(is_numeric($pageid)){
            $permalink = get_the_permalink($pageid);
        }else{
            if(isset($args['jsstpageid']) && is_numeric($args['jsstpageid'])){
                $permalink = get_the_permalink($args['jsstpageid']);
            }else{
                $permalink = get_the_permalink();
            }
        }

        if (!$wp_rewrite->using_permalinks() || is_feed()){
            if(!strstr($permalink, 'page_id') && !strstr($permalink, '?p=')){
                $page['page_id'] = get_option('page_on_front');
                $args = $page + $args;
            }
            $redirect_url = add_query_arg($args,$permalink);
            return $redirect_url;
        }

        if(isset($args['jstmod']) && isset($args['jstlay'])){
            // Get the original query parts
            $redirect = @parse_url($permalink);
            if (!isset($redirect['query']))
                $redirect['query'] = '';

            if(strstr($permalink, '?')){ // if variable exist
                $redirect_array = explode('?', $permalink);
                $_redirect = $redirect_array[0];
            }else{
                $_redirect = $permalink;
            }

            if($_redirect[strlen($_redirect) - 1] == '/'){
                $_redirect = substr($_redirect, 0, strlen($_redirect) - 1);
            }


            // If is layout
            $changename = false;
            if(file_exists(WP_PLUGIN_DIR.'/js-jobs/js-jobs.php')){
                $changename = true;
            }
            if(file_exists(WP_PLUGIN_DIR.'/js-vehicle-manager/js-vehicle-manager.php')){
                $changename = true;
            }
            if (isset($args['jstlay'])) {
                switch ($args['jstlay']) {
                    case 'ticketdetail':$layout = 'ticket';break;
                    case 'staffaddticket':$layout = 'staff-add-ticket';break;
                    case 'rolepermission':$layout = 'role-permission';break;
                    case 'addannouncement':$layout = 'add-announcement';break;
                    case 'adddepartment':$layout = 'add-department';break;
                    case 'adddownload':$layout = 'add-download';break;
                    case 'addfaq':$layout = 'add-faq';break;
                    case 'faqdetails':$layout = 'faq';break;
                    case 'addarticle':$layout = 'add-article';break;
                    case 'addcategory':$layout = 'add-category';break;
                    case 'userknowledgebasearticles':$layout = 'kb-articles';break;
                    case 'articledetails':$layout = 'kb-article';break;
                    case 'addrole':$layout = 'add-role';break;
                    case 'addstaff':$layout = 'add-staff';break;
                    case 'staffpermissions':$layout = 'staff-permissions';break;
                    case 'myticket':$layout = 'my-tickets';break;
                    case 'staffmyticket':$layout = 'staff-my-tickets';break;
                    case 'userknowledgebase':$layout = 'knowledgebase';break;
                    case 'stafflistcategories':$layout = 'staff-categories';break;
                    case 'stafflistarticles':$layout = 'staff-kb-articles';break;
                    case 'staffannouncements':$layout = 'staff-announcements';break;
                    case 'staffdownloads':$layout = 'staff-downloads';break;
                    case 'stafffaqs':$layout = 'staff-faqs';break;
                    case 'addticket':$layout = 'add-ticket';break;
                    case 'ticketstatus':$layout = 'ticket-status';break;
                    case 'controlpanel':$layout = 'control-panel';break;
                    case 'staffdetailreport':$layout = 'staff-report';break;
                    case 'staffreports':$layout = 'staff-reports';break;
                    case 'departmentreports':$layout = 'department-reports';break;
                    case 'announcementdetails':$layout = 'announcement';break;
                    case 'formfeedback':$layout = 'feed-back';break;
                    case 'feedbacks':$layout = 'staff-feedbacks';break;
                    case 'visitormessagepage':$layout = 'visitor-message';break;
                    case 'printticket':
                    $layout = 'print-ticket';
                    break;
                    case 'myprofile':
                        $layout = ($changename === true) ? 'ticket-my-profile' : 'my-profile';
                    break;
                    case 'login':
                        $layout = ($changename === true) ? 'ticket-login' : 'login';
                    break;
                    case 'userregister':
                        $layout = ($changename === true) ? 'ticket-user-register' : 'userregister';
                    break;
                    case 'formmessage':
                        $layout = ($changename === true) ? 'ticket-add-message' : 'add-message';
                    break;
                    case 'message':
                        $layout = ($changename === true) ? 'ticket-message' : 'message';
                    break;
                    case 'inbox':
                        $layout = ($changename === true) ? 'ticket-message-inbox' : 'message-inbox';
                    break;
                    case 'outbox':
                        $layout = ($changename === true) ? 'ticket-message-outbox' : 'message-outbox';
                    break;
                    default:$layout = $args['jstlay'];break;
                }
                if(is_home() || is_front_page()){
                    if($_redirect == site_url()){
                        $layout = 'st-'.$layout;
                    }
                }else{
                    if($_redirect == site_url()){
                        $layout = 'st-'.$layout;
                    }
                }
                $_redirect .= '/' . $layout;
            }
            // If is list
            if (isset($args['list'])) {
                $_redirect .= '/' . $args['list'];
            }
            // If is sortby
            if (isset($args['sortby'])) {
                $_redirect .= '/' . $args['sortby'];
            }
            // If is jssupportticket_ticketid
            if (isset($args['jssupportticketid'])) {
                $_redirect .= '/' . $args['jssupportticketid'];
            }
            if (isset($args['jsst-id'])){
                $_redirect .= '/' . $args['jsst-id'];
            }
            if (isset($args['jsst-date-start'])){
                $_redirect .= '/date-start:' . $args['jsst-date-start'];
            }
            if (isset($args['jsst-date-end'])){
                $_redirect .= '/date-end:' . $args['jsst-date-end'];
            }
            if (isset($args['js_redirecturl'])){
                $_redirect .= '/?js_redirecturl=' . $args['js_redirecturl'];
            }
            if (isset($args['token'])){
                $_redirect .= '/?token=' . $args['token'];
            }
            if (isset($args['successflag'])){
                $_redirect .= '/?successflag=' . $args['successflag'];
            }
            return $_redirect;
        }else{ // incase of form
            $redirect_url = add_query_arg($args,$permalink);
            return $redirect_url;
        }
    }

    function reset_jsst_aadon_query(){
        jssupportticket::$_addon_query = array('select'=>'','join'=>'','where'=>'');
    }


    function ticketviaemail() {// this funtion also handles ticket overdue bcz of hours confiuration
/*
        $today = date('Y-m-d');
        $f = fopen(jssupportticket::$_path .  'mylogone.txt', 'a') or exit("Can't open $lfile!");
        $script_name = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);
        $time = date('H:i:s');
        $message = ' main function call cron '.$time;
        fwrite($f, "$time ($script_name) $message\n");
*/
        if(in_array('overdue', jssupportticket::$_active_addons)){
            JSSTincluder::getJSModel('overdue')->updateTicketStatusToOverDueCron();// this funtions handles the overdue of tickets by cron
        }
        if(in_array('feedback', jssupportticket::$_active_addons)){
            JSSTincluder::getJSModel('ticket')->sendFeedbackMail();// this funtions handles the the feedback email
        }
        if(in_array('emailpiping', jssupportticket::$_active_addons)){
            JSSTincluder::getJSController('emailpiping')->registerReadEmails();
            JSSTincluder::getJSModel('emailpiping')->getAllEmailsForTickets();
        }
/*
        $time = date('H:i:s');
        $message = ' after ticketviaemail controller call cron '.$time;
        fwrite($f, "$time ($script_name) $message\n");
*/
    }
}

add_action('init', 'custom_init_session', 1);
function custom_init_session() {
    wp_enqueue_script("jquery");
    jssupportticket::addStyleSheets();
    // jsst_subscribe_notifications();
    if (!session_id())
        session_start();
}

// add the filter
$jssupportticket = new jssupportticket();

add_action( 'login_form_middle', 'jsstAddLostPasswordLink' );
function jsstAddLostPasswordLink() {
   return '<a href="'.site_url().'/wp-login.php?action=lostpassword">'. __('Lost your password','js-support-ticket') .'?</a>';
}
add_action( 'jsst_addon_update_date_failed', 'jsstaddonUpdateDateFailed' );

function jsstaddonUpdateDateFailed(){
    die();
}



add_action( 'template_redirect', 'jsstW3cValidation');
    function jsstW3cValidation (){
        ob_start( function( $buffer ){
            $buffer = str_replace( array( 'type="text/javascript"', "type='text/javascript'", 'type="text/css"', "type='text/css'" ), '', $buffer );

            return $buffer;
        });
    }


if(!empty(jssupportticket::$_active_addons)){
    require_once 'includes/addon-updater/jsstupdater.php';
    $JS_Updater  = new JS_Updater();
}

//$jssupportticket = new jssupportticket();
if(is_file('includes/updater/updater.php')){
    include_once 'includes/updater/updater.php';
}


?>

<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTannouncementshortcodes {

    function __construct() {
        add_shortcode('jssupportticket_announcements', array($this, 'show_announcements'));
        add_shortcode('jssupportticket_announcements_latest', array($this, 'show_announcementslatest'));
        add_shortcode('jssupportticket_announcements_popular', array($this, 'show_announcementslatest'));
    }



   function show_announcementslatest($raw_args, $content = null) {
       //default set of parameters for the front end shortcodes
       ob_start();
       $pageid = get_the_ID();
       jssupportticket::setPageID($pageid);
       $module = JSSTRequest::getVar('jstmod', '', 'announcement');
       $layout = JSSTRequest::getVar('jstlay', '', 'announcementsshortcode');
       if ($layout != 'announcementsshortcode') {
           JSSTincluder::include_file($module);
       } else {
           $filepath = jssupportticket::$_path . 'includes/css/style.php';
           $filestring = file_get_contents($filepath);
           $color1 = JSSTincluder::getJSModel('jssupportticket')->getColorCode($filestring, 1);
           $color3 = JSSTincluder::getJSModel('jssupportticket')->getColorCode($filestring, 3);
           $defaults = array(
               'jstmod' => '',
               'jstlay' => '',
               'background_color' => $color1,
               'text_color' => $color3
           );
           $sanitized_args = shortcode_atts($defaults, $raw_args);
           if(isset(jssupportticket::$_data['sanitized_args']) && !empty(jssupportticket::$_data['sanitized_args'])){
               jssupportticket::$_data['sanitized_args'] += $sanitized_args;
           }else{
               jssupportticket::$_data['sanitized_args'] = $sanitized_args;
           }
           jssupportticket::$_data['short_code_header'] = 'announcements';
           $id = JSSTrequest::getVar('jssupportticketid');
           JSSTincluder::getJSModel('announcement')->getAnnouncements($id);
           JSSTincluder::include_file('announcementsshortcode', 'announcement');
       }
       $content .= ob_get_clean();
       return $content;
   }

   function show_announcements($raw_args, $content = null) {
       //default set of parameters for the front end shortcodes
       ob_start();
       $pageid = get_the_ID();
       jssupportticket::setPageID($pageid);
       $module = JSSTRequest::getVar('jstmod', '', 'announcement');
       $layout = JSSTRequest::getVar('jstlay', '', 'announcements');
       if ($layout != 'announcements') {
           JSSTincluder::include_file($module);
       } else {
           $defaults = array(
               'jstmod' => '',
               'jstlay' => '',
           );
           $sanitized_args = shortcode_atts($defaults, $raw_args);
           if(isset(jssupportticket::$_data['sanitized_args']) && !empty(jssupportticket::$_data['sanitized_args'])){
               jssupportticket::$_data['sanitized_args'] += $sanitized_args;
           }else{
               jssupportticket::$_data['sanitized_args'] = $sanitized_args;
           }
           jssupportticket::$_data['short_code_header'] = 'announcements';
           $id = JSSTrequest::getVar('jssupportticketid');
           JSSTincluder::getJSModel('announcement')->getAnnouncements($id);
           JSSTincluder::include_file('announcements', 'announcement');
       }
       $content .= ob_get_clean();
       return $content;
   }
}

$shortcodes = new JSSTannouncementshortcodes();
?>
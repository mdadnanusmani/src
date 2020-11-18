<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTdownloadshortcodes {

    function __construct() {
        add_shortcode('jssupportticket_downloads', array($this, 'show_downloads'));
        add_shortcode('jssupportticket_downloads_latest', array($this, 'show_downloadslatest'));
        add_shortcode('jssupportticket_downloads_popular', array($this, 'show_downloadslatest'));
    }

    function show_downloads($raw_args, $content = null) {
        //default set of parameters for the front end shortcodes
        ob_start();
        $pageid = get_the_ID();
        jssupportticket::setPageID($pageid);
        $module = JSSTRequest::getVar('jstmod', '', 'download');
        $layout = JSSTRequest::getVar('jstlay', '', 'downloads');
        if ($layout != 'downloads') {
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
            jssupportticket::$_data['short_code_header'] = 'downloads';
            $id = JSSTrequest::getVar('jssupportticketid');
            JSSTincluder::getJSModel('download')->getDownloads($id);
            JSSTincluder::include_file('downloads', 'download');
        }
        $content .= ob_get_clean();
        return $content;
    }

    function show_downloadslatest($raw_args, $content = null) {
        //default set of parameters for the front end shortcodes
        ob_start();
        $pageid = get_the_ID();
        jssupportticket::setPageID($pageid);
        $module = JSSTRequest::getVar('jstmod', '', 'download');
        $layout = JSSTRequest::getVar('jstlay', '', 'downloadsshortcode');
        if ($layout != 'downloadsshortcode') {
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
            jssupportticket::$_data['short_code_header'] = 'downloads';
            $id = JSSTrequest::getVar('jssupportticketid');
            JSSTincluder::getJSModel('download')->getDownloads($id);
            JSSTincluder::include_file('downloadsshortcode', 'download');
        }
        $content .= ob_get_clean();
        return $content;
    }

}

$shortcodes = new JSSTdownloadshortcodes();
?>
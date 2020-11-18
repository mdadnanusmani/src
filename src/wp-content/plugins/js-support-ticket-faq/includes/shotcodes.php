<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTfaqshortcodes {

    function __construct() {
        add_shortcode('jssupportticket_faqs', array($this, 'show_faqs'));
        add_shortcode('jssupportticket_faqs_latest', array($this, 'show_faqslatest'));
        add_shortcode('jssupportticket_faqs_popular', array($this, 'show_faqslatest'));
    }



    function show_faqslatest($raw_args, $content = null) {
        //default set of parameters for the front end shortcodes
        ob_start();
        $pageid = get_the_ID();
        jssupportticket::setPageID($pageid);
        $module = JSSTRequest::getVar('jstmod', '', 'faq');
        $layout = JSSTRequest::getVar('jstlay', '', 'faqsshortcode');
        if ($layout != 'faqsshortcode') {
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
            jssupportticket::$_data['short_code_header'] = 'faqs';
            $id = JSSTrequest::getVar('jssupportticketid');
            JSSTincluder::getJSModel('faq')->getFaqs($id);
            JSSTincluder::include_file('faqsshortcode', 'faq');
        }
        $content .= ob_get_clean();
        return $content;
    }

    function show_faqs($raw_args, $content = null) {
        //default set of parameters for the front end shortcodes
        ob_start();
        $pageid = get_the_ID();
        jssupportticket::setPageID($pageid);
        $module = JSSTRequest::getVar('jstmod', '', 'faq');
        $layout = JSSTRequest::getVar('jstlay', '', 'faqs');
        if ($layout != 'faqs') {
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
            jssupportticket::$_data['short_code_header'] = 'faqs';
            $id = JSSTrequest::getVar('jssupportticketid');
            JSSTincluder::getJSModel('faq')->getFaqs($id);
            JSSTincluder::include_file('faqs', 'faq');
        }
        $content .= ob_get_clean();
        return $content;
    }

}

$shortcodes = new JSSTfaqshortcodes();
?>
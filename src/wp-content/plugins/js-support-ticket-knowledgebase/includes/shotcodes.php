<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTknowledgebaseshortcodes {

    function __construct() {
        add_shortcode('jssupportticket_knowledgebase', array($this, 'show_knowledgebase'));
        add_shortcode('jssupportticket_knowledgebase_latest', array($this, 'show_knowledgebaselatest'));
        add_shortcode('jssupportticket_knowledgebase_popular', array($this, 'show_knowledgebaselatest'));
    }
    function show_knowledgebaselatest($raw_args, $content = null) {
        //default set of parameters for the front end shortcodes
        ob_start();
        $pageid = get_the_ID();
        jssupportticket::setPageID($pageid);
        $module = JSSTRequest::getVar('jstmod', '', 'knowledgebase');
        $layout = JSSTRequest::getVar('jstlay', '', 'userknowledgebaseshortcode');
        if ($layout != 'userknowledgebaseshortcode') {
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
            jssupportticket::$_data['short_code_header'] = 'userknowledgebase';
            JSSTincluder::getJSModel('knowledgebase')->getKnowledgebaseCat();
            JSSTincluder::include_file('userknowledgebaseshortcode', 'knowledgebase');
        }
        $content .= ob_get_clean();
        return $content;
    }

    function show_knowledgebase($raw_args, $content = null) {
        //default set of parameters for the front end shortcodes
        ob_start();
        $pageid = get_the_ID();
        jssupportticket::setPageID($pageid);
        $module = JSSTRequest::getVar('jstmod', '', 'knowledgebase');
        $layout = JSSTRequest::getVar('jstlay', '', 'userknowledgebase');
        if ($layout != 'userknowledgebase') {
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
            jssupportticket::$_data['short_code_header'] = 'userknowledgebase';
            JSSTincluder::getJSModel('knowledgebase')->getKnowledgebaseCat();
            JSSTincluder::include_file('userknowledgebase', 'knowledgebase');
        }
        $content .= ob_get_clean();
        return $content;
    }

}
$shortcodes = new JSSTknowledgebaseshortcodes();
?>
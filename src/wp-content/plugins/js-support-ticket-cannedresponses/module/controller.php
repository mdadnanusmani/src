<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTcannedresponsesController {

    function __construct() {
        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSSTrequest::getLayout('jstlay', null, 'premademessages');
        if (self::canaddfile()) {
            switch ($layout) {
                /* listing of all premade */
                case 'admin_premademessages':
                    JSSTincluder::getJSModel('cannedresponses')->getPremadeMessages();
                    break;
                /* form for premade */
                case 'admin_addpremademessage':
                    $id = JSSTrequest::getVar('jssupportticketid', 'get');
                    JSSTincluder::getJSModel('cannedresponses')->getPremadeMessageForForm($id);
                    break;
            }
            $module = (is_admin()) ? 'page' : 'jstmod';
            $module = JSSTrequest::getVar($module, null, 'cannedresponses');
            JSSTincluder::include_file($layout, $module);
        }
    }

    function canaddfile() {
        if (isset($_POST['form_request']) && $_POST['form_request'] == 'jssupportticket')
            return false;
        elseif (isset($_GET['action']) && $_GET['action'] == 'jstask')
            return false;
        else
            return true;
    }

    static function savepremademessage() {
        $data = JSSTrequest::get('post');
        JSSTincluder::getJSModel('cannedresponses')->storePreMadeMessage($data);
        $url = admin_url("admin.php?page=cannedresponses&jstlay=premademessages");
        wp_redirect($url);
        exit;
    }

    static function deletepremademessage() {
        $nonce = JSSTrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'delete-premademessage') ) {
            die( 'Security check Failed' );
        }
        $id = JSSTrequest::getVar('premademessageid');
        JSSTincluder::getJSModel('cannedresponses')->removePreMadeMessage($id);
        $url = admin_url("admin.php?page=cannedresponses&jstlay=premademessages");
        wp_redirect($url);
        exit;
    }

    static function changestatus() {
        $nonce = JSSTrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'change-status') ) {
            die( 'Security check Failed' );
        }
        $id = JSSTrequest::getVar('premadeid');
        JSSTincluder::getJSModel('cannedresponses')->changeStatus($id);
        $url = admin_url("admin.php?page=cannedresponses&jstlay=premademessages");
        wp_redirect($url);
        exit;
    }

}

$cannedresponsesController = new JSSTcannedresponsesController();
?>

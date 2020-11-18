<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTfaqController {

    function __construct() {
        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSSTrequest::getLayout('jstlay', null, 'faqs');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_faqs':
                case 'stafffaqs':
                    jssupportticket::$_data['permission_granted'] = true;
                    if ( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()) {
                        jssupportticket::$_data['permission_granted'] = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('View FAQ');
                    }
                    if (jssupportticket::$_data['permission_granted']) {
                        JSSTincluder::getJSModel('faq')->getStaffFaqs();
                    }
                    break;
                case 'faqs':
                    $id = JSSTrequest::getVar('jssupportticketid');
                    JSSTincluder::getJSModel('faq')->getFaqs($id);
                    break;
                case 'faqdetails':
                    $id = JSSTrequest::getVar('jssupportticketid');
                    JSSTincluder::getJSModel('faq')->getFaqDetails($id);
                    break;
                case 'admin_addfaq':
                case 'addfaq':
                    $id = JSSTrequest::getVar('jssupportticketid');
                    jssupportticket::$_data['permission_granted'] = true;
                    if ( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()) {
                        $per_task = ($id == null) ? 'Add FAQ' : 'Edit FAQ';
                        jssupportticket::$_data['permission_granted'] = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask($per_task);
                    }
                    if (jssupportticket::$_data['permission_granted']) {
                        JSSTincluder::getJSModel('faq')->getFaqForForm($id);
                    }
                    break;
            }
            $module = (is_admin()) ? 'page' : 'jstmod';
            $module = JSSTrequest::getVar($module, null, 'faq');
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

    static function savefaq() {
        $data = JSSTrequest::get('post');
        JSSTincluder::getJSModel('faq')->storeFaq($data);
        if (is_admin()) {
            $url = admin_url("admin.php?page=faq&jstlay=faqs");
        } else {
            $url = jssupportticket::makeUrl(array('jstmod'=>'faq', 'jstlay'=>'stafffaqs'));
        }
        wp_redirect($url);
        exit;
    }

    static function deletefaq() {
        $nonce = JSSTrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'delete-faq') ) {
            die( 'Security check Failed' );
        }
        $id = JSSTrequest::getVar('faqid');
        JSSTincluder::getJSModel('faq')->removeFaq($id);
        if (is_admin()) {
            $url = admin_url("admin.php?page=faq&jstlay=faqs");
        } else {
            $url = jssupportticket::makeUrl(array('jstmod'=>'faq', 'jstlay'=>'stafffaqs'));
        }
        wp_redirect($url);
        exit;
    }

    static function changestatus() {
        $nonce = JSSTrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'change-status') ) {
            die( 'Security check Failed' );
        }
        $id = JSSTrequest::getVar('faqid');
        JSSTincluder::getJSModel('faq')->changeStatus($id);
        $url = admin_url("admin.php?page=faq&jstlay=faqs");
        $pagenum = JSSTrequest::getVar('pagenum');
        if ($pagenum)
            $url .= '&pagenum=' . $pagenum;
        wp_redirect($url);
        exit;
    }

    static function ordering() {
        $nonce = JSSTrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'ordering') ) {
            die( 'Security check Failed' );
        }
        $id = JSSTrequest::getVar('faqid');
        JSSTincluder::getJSModel('faq')->setOrdering($id);
        $pagenum = JSSTrequest::getVar('pagenum');
        $url = "admin.php?page=faq&jstlay=faqs";
        if ($pagenum)
            $url .= '&pagenum=' . $pagenum;
        wp_redirect($url);
        exit;
    }

}

$faqController = new JSSTfaqController();
?>

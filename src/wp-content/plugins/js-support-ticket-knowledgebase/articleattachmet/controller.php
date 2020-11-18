<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTarticleattachmetController {

    function __construct() {
        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSSTrequest::getLayout('jstlay', null, 'articleattachmets');
        if (self::canaddfile()) {
            switch ($layout) {
                // case 'attachment_getattachments':
                // 	$id = $_GET['jssupportticket_ticketid'];
                // 	JSSTincluder::getJSModel('replies')->getrepliesForForm($id);
                // break;
            }
            $module = (is_admin()) ? 'page' : 'jstmod';
            $module = JSSTrequest::getVar($module, null, 'articleattachment');
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

    static function deleteattachment() {
        $nonce = JSSTrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'delete-attachement')  && !is_admin()) {
            die( 'Security check Failed' );
        }
        $id = JSSTrequest::getVar('id');
        $articleid = JSSTrequest::getVar('articleid');
        if (is_admin()) {
            JSSTincluder::getJSModel('articleattachmet')->removeAttachment($id , $articleid);
            $url = admin_url("admin.php?page=knowledgebase&jstlay=addarticle&jssupportticketid=" . JSSTrequest::getVar('articleid'));
        }elseif( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()){
            $permission = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Edit Knowledge Base');
            if($permission == true){
                JSSTincluder::getJSModel('articleattachmet')->removeAttachment($id , $articleid);
            }
            $url = jssupportticket::makeUrl(array('jstmod'=>'knowledgebase','jstlay'=>'addarticle','jssupportticketid'=>JSSTrequest::getVar('articleid'),'jsstpageid'=>jssupportticket::getPageid()));
        }
        wp_redirect($url);
        exit;
    }

    function downloadbyid(){
        $id = JSSTrequest::getVar('id');
        JSSTincluder::getJSModel('articleattachmet')->getDownloadAttachmentById($id);
    }
}

$articleattachmetController = new JSSTarticleattachmetController();
?>

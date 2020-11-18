<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTannouncementController {

    function __construct() {
        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSSTrequest::getLayout('jstlay', null, 'announcements');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_announcements':
                case 'staffannouncements':
                    jssupportticket::$_data['permission_granted'] = true;
                    if ( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()) {
                        jssupportticket::$_data['permission_granted'] = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('View Announcement');
                    }
                    if (jssupportticket::$_data['permission_granted']) {
                        JSSTincluder::getJSModel('announcement')->getStaffAnnouncements();
                    }
                    break;
                case 'announcements':
                    $id = JSSTrequest::getVar('jssupportticketid');
                    JSSTincluder::getJSModel('announcement')->getAnnouncements($id);
                    break;
                case 'announcementdetails':
                    $id = JSSTrequest::getVar('jssupportticketid');
                    JSSTincluder::getJSModel('announcement')->getAnnouncementDetails($id);
                    break;
                case 'admin_addannouncement':
                case 'addannouncement':
                    $id = JSSTrequest::getVar('jssupportticketid');
                    jssupportticket::$_data['permission_granted'] = true;
                    if ( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()) {
                        $per_task = ($id == null) ? 'Add Announcement' : 'Edit Announcement';
                        jssupportticket::$_data['permission_granted'] = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask($per_task);
                    }
                    if (jssupportticket::$_data['permission_granted']) {
                        JSSTincluder::getJSModel('announcement')->getAnnouncementForForm($id);
                    }
                    break;
            }
            $module = (is_admin()) ? 'page' : 'jstmod';
            $module = JSSTrequest::getVar($module, null, 'announcement');
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

    static function saveannouncement() {
        $data = JSSTrequest::get('post');
        JSSTincluder::getJSModel('announcement')->storeAnnouncement($data);
        if (is_admin()) {
            $url = admin_url("admin.php?page=announcement&jstlay=announcements");
        } else {
            $url = jssupportticket::makeUrl(array('jstmod'=>'announcement', 'jstlay'=>'staffannouncements'));
        }
        wp_redirect($url);
        exit;
    }

    static function deleteannouncement() {
        $nonce = JSSTrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'delete-announcement') ) {
        die( 'Security check Failed' );
        }
        $id = JSSTrequest::getVar('announcementid');
        JSSTincluder::getJSModel('announcement')->removeAnnouncement($id);
        if (is_admin()) {
            $url = admin_url("admin.php?page=announcement&jstlay=announcements");
        } else {
            $url = jssupportticket::makeUrl(array('jstmod'=>'announcement', 'jstlay'=>'staffannouncements'));
        }
        wp_redirect($url);
        exit;
    }

    static function changestatus() {
        $nonce = JSSTrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'change-status') ) {
            die( 'Security check Failed' );
        }
        $id = JSSTrequest::getVar('announcementid');
        JSSTincluder::getJSModel('announcement')->changeStatus($id);
        $url = admin_url("admin.php?page=announcement&jstlay=announcements");
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
        $id = JSSTrequest::getVar('announcementid');
        JSSTincluder::getJSModel('announcement')->setOrdering($id);
        $pagenum = JSSTrequest::getVar('pagenum');
        $url = "admin.php?page=announcement&jstlay=announcements";
        if ($pagenum)
            $url .= '&pagenum=' . $pagenum;
        wp_redirect($url);
        exit;
    }

}

$announcementController = new JSSTannouncementController();
?>

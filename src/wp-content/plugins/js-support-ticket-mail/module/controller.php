<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTmailController {

    function __construct() {
        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSSTrequest::getLayout('jstlay', null, 'inbox');
        if (self::canaddfile()) {
            $uid = get_current_user_id();
            if ( in_array('agent',jssupportticket::$_active_addons)) {
                $uid = JSSTincluder::getJSModel('agent')->getStaffId($uid);
            }
            switch ($layout) {
                case 'message':
                case 'admin_message': // message detail and replies
                    $id = JSSTrequest::getVar('jssupportticketid');
                    jssupportticket::$_data['permission_granted'] = true;
                    if ( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()) {
                        jssupportticket::$_data['permission_granted'] = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Allow Mail System');
                    }
                    if (jssupportticket::$_data['permission_granted']) {
                        JSSTincluder::getJSModel('mail')->getMessage($id, $uid);
                    }
                    break;
                case 'inbox':
                case 'admin_inbox':
                    jssupportticket::$_data['permission_granted'] = true;
                    if ( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()) {
                        jssupportticket::$_data['permission_granted'] = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Allow Mail System');
                    }
                    if (jssupportticket::$_data['permission_granted']) {
                        JSSTincluder::getJSModel('mail')->getInboxMessages($uid);
                    }
                    break;
                case 'outbox':
                case 'admin_outbox':
                    jssupportticket::$_data['permission_granted'] = true;
                    if ( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()) {
                        jssupportticket::$_data['permission_granted'] = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Allow Mail System');
                    }
                    if (jssupportticket::$_data['permission_granted']) {
                        JSSTincluder::getJSModel('mail')->getOutboxMessagesForOutbox($uid);
                    }
                    break;
                case 'formmessage':
                case 'admin_formmessage': // to compose new mail
                    jssupportticket::$_data['permission_granted'] = true;
                    if ( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()) {
                        jssupportticket::$_data['permission_granted'] = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Allow Mail System');
                    }
                    if (jssupportticket::$_data['permission_granted']) {
                        JSSTincluder::getJSModel('mail')->getMessageFormData($uid);
                    }
                    break;
            }
            $module = (is_admin()) ? 'page' : 'jstmod';
            $module = JSSTrequest::getVar($module, null, 'mail');
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

    /* to save new message */

    static function savemessage() {
        $data = JSSTrequest::get('post');
        JSSTincluder::getJSModel('mail')->storeMessage($data);
        if (is_admin()) {
            $url = admin_url("admin.php?page=mail&jstlay=inbox");
        } else {
            $url = jssupportticket::makeUrl(array('jstmod'=>'mail', 'jstlay'=>'inbox'));
        }
        wp_redirect($url);
        exit;
    }

    /* to save reply to a message */

    static function savereply() {
        $data = JSSTrequest::get('post');
        $id = $data['jssupportticketid'];
        JSSTincluder::getJSModel('mail')->storeMessage($data);
        if (is_admin()) {
            $url = admin_url("admin.php?page=mail&jstlay=message&jssupportticketid=" . $id);
        } else {
            $url = jssupportticket::makeUrl(array('jstmod'=>'mail', 'jstlay'=>'message', 'jssupportticketid'=>$id));
        }
        wp_redirect($url);
        exit;
    }

    /* to delete message */

    static function deletemail() {
        $nonce = JSSTrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'delete-mail') ) {
            die( 'Security check Failed' );
        }
        $id = JSSTrequest::getVar('mailid');
        JSSTincluder::getJSModel('mail')->removeMessage($id);
        if (is_admin()) {
            $url = admin_url("admin.php?page=mail&jstlay=inbox");
        } else {
            $url = jssupportticket::makeUrl(array('jstmod'=>'mail', 'jstlay'=>'inbox'));
        }
        wp_redirect($url);
        exit;
    }

    static function markasread() {
        $id = JSSTrequest::getVar('mailid');
        JSSTincluder::getJSModel('mail')->setAsRead($id);
        if (is_admin()) {
            $url = admin_url("admin.php?page=mail&jstlay=inbox");
        } else {
            $url = jssupportticket::makeUrl(array('jstmod'=>'mail', 'jstlay'=>'inbox'));
        }
        wp_redirect($url);
        exit;
    }

    static function markasunread() {
        $id = JSSTrequest::getVar('mailid');
        JSSTincluder::getJSModel('mail')->setAsUnread($id);
        if (is_admin()) {
            $url = admin_url("admin.php?page=mail&jstlay=inbox");
        } else {
            $url = jssupportticket::makeUrl(array('jstmod'=>'mail', 'jstlay'=>'inbox'));
        }
        wp_redirect($url);
        exit;
    }

}

$mailController = new JSSTmailController();
?>

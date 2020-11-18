<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTnoteController {

    function __construct() {
        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSSTrequest::getLayout('jstlay', null, 'notes');
        if (self::canaddfile()) {
            $module = (is_admin()) ? 'page' : 'jstmod';
            $module = JSSTrequest::getVar($module, null, 'note');
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

    static function savenote() {
        $data = JSSTrequest::get('post');
        JSSTincluder::getJSModel('note')->storeTicketInternalNote($data, $data['internalnote']);
        if (is_admin()) {
            $url = admin_url("admin.php?page=ticket&jstlay=ticketdetail&jssupportticketid=" . JSSTrequest::getVar('ticketid'));
        } else {
            $url = jssupportticket::makeUrl(array('jstmod'=>'ticket', 'jstlay'=>'ticketdetail', 'jssupportticketid'=>JSSTrequest::getvar('ticketid')));
        }
        wp_redirect($url);
        exit;
    }

    function downloadbyid(){
        $id = JSSTrequest::getVar('id');
        JSSTincluder::getJSModel('note')->getDownloadAttachmentById($id);
    }

    static function saveeditedtime() {
        $data = JSSTrequest::get('post');
        JSSTincluder::getJSModel('note')->editTime($data);
        if (current_user_can('manage_options') || current_user_can('jsst_support_ticket_tickets')) {
            $url = admin_url("admin.php?page=ticket&jstlay=ticketdetail&jssupportticketid=" . $data['note-tikcetid']);
        } else {
            $url = jssupportticket::makeUrl(array('jstmod'=>'ticket','jstlay'=>'ticketdetail','jssupportticketid'=>$data['note-tikcetid'],'jsstpageid'=>jssupportticket::getPageid()));
        }
        wp_redirect($url);
        exit;
    }


}

$noteController = new JSSTnoteController();
?>

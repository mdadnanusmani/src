<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTticketController {

    function __construct() {
        self::handleRequest();
    }

    function handleRequest() {
        if (is_admin()) {
            $defaultlayout = "tickets";
        } else
            $defaultlayout = "myticket";
        $layout = JSSTrequest::getLayout('jstlay', null, $defaultlayout);
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_tickets':
                    JSSTincluder::getJSModel('ticket')->getTicketsForAdmin();
                    //JSSTincluder::getJSModel('emailpiping')->readEmails();
                    break;
                case 'admin_addticket':
                case 'addticket':
                //case 'staffaddticket':
                    $id = JSSTrequest::getVar('jssupportticketid');
                    jssupportticket::$_data['permission_granted'] = true;
                    // if ( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()) {
                    //     $per_task = ($id == null) ? 'Add Ticket' : 'Edit Ticket';
                    //     jssupportticket::$_data['permission_granted'] = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask($per_task);
                    // }
                    if (jssupportticket::$_data['permission_granted']) {
                        JSSTincluder::getJSModel('ticket')->getTicketsForForm($id);
                    }
                    break;
                case 'admin_ticketdetail':
                case 'ticketdetail':
                    $id = JSSTrequest::getVar('jssupportticketid');
                    jssupportticket::$_data['permission_granted'] = true;
                    jssupportticket::$_data['user_staff'] = false;
                    if ( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()) {
                        jssupportticket::$_data['user_staff'] = true;
                        jssupportticket::$_data['permission_granted'] = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('View Ticket');
                    }
                    if (jssupportticket::$_data['permission_granted']) {
                        JSSTincluder::getJSModel('ticket')->getTicketForDetail($id);
                    }
                    break;
                case 'myticket':
                    JSSTincluder::getJSModel('ticket')->getMyTickets();
                    break;

            }
            $module = (is_admin()) ? 'page' : 'jstmod';
            $module = JSSTrequest::getVar($module, null, 'ticket');
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

    function closeticket() {
        $id = JSSTrequest::getVar('ticketid');
        JSSTincluder::getJSModel('ticket')->closeTicket($id);
        if (is_admin()) {
            $url = admin_url("admin.php?page=ticket&jstlay=tickets");
        } else {
            $url = jssupportticket::makeUrl(array('jstmod'=>'ticket', 'jstlay'=>'ticketdetail','jssupportticketid'=>$id));
        }
        wp_redirect($url);
        exit;
    }

    function lockticket() {
        $id = JSSTrequest::getVar('ticketid');
        JSSTincluder::getJSModel('ticket')->lockTicket($id);
        if (is_admin()) {
            $url = admin_url("admin.php?page=ticket&jstlay=ticketdetail&jssupportticketid=" . $id);
        } else {
            $url = jssupportticket::makeUrl(array('jstmod'=>'ticket', 'jstlay'=>'ticketdetail', 'jssupportticketid'=>$id));
        }
        wp_redirect($url);
        exit;
    }

    function unlockticket() {
        $id = JSSTrequest::getVar('ticketid');
        JSSTincluder::getJSModel('ticket')->unLockTicket($id);
        if (is_admin()) {
            $url = admin_url("admin.php?page=ticket&jstlay=ticketdetail&jssupportticketid=" . $id);
        } else {
            $url = jssupportticket::makeUrl(array('jstmod'=>'ticket', 'jstlay'=>'ticketdetail', 'jssupportticketid'=>$id));
        }
        wp_redirect($url);
        exit;
    }

    static function saveticket() {
        $data = JSSTrequest::get('post');
        $result = JSSTincluder::getJSModel('ticket')->storeTickets($data);
        if (is_admin()) {
            if($result == false){
                $url = admin_url("admin.php?page=ticket&jstlay=addticket");
            }else{
                $url = admin_url("admin.php?page=ticket&jstlay=tickets");
            }
        } else {
            if (get_current_user_id() == 0) { // visitor
                if ($result == false) { // error on captcha or ticket validation
                    $url = jssupportticket::makeUrl(array('jstmod'=>'ticket', 'jstlay'=>'addticket'));
                } else { // all things perfect
                    if(in_array('actions',jssupportticket::$_active_addons)){
                        $url = jssupportticket::makeUrl(array('jstmod'=>'ticket', 'jstlay'=>'visitormessagepage'));
                        
                        $url = $url."?id=".$result;
                    }else{
                        $url = jssupportticket::makeUrl(array('jstmod'=>'jssupportticket', 'jstlay'=>'controlpanel'));
                    }
                }
            } else {
                if ($result == false) { // error on captcha or ticket validation
                    $addticket = ( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()) ? 'staffaddticket' : 'addticket';
                    $module1 = ( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()) ? 'agent' : 'ticket';
                    $url = jssupportticket::makeUrl(array('jstmod'=>$module1, 'jstlay'=>$addticket));
                } else {
                    $myticket = ( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()) ? 'staffmyticket' : 'myticket';
                    $module1 = ( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()) ? 'agent' : 'ticket';
                    $url = jssupportticket::makeUrl(array('jstmod'=>$module1, 'jstlay'=>$myticket));
                }
            }
        }
        if($result == false){
            JSSTformfield::setFormData($data);
        }
        wp_redirect($url);
        exit;
    }

    static function transferdepartment() {
        $data = JSSTrequest::get('post');
        JSSTincluder::getJSModel('ticket')->tickDepartmentTransfer($data);
        if (is_admin()) {
            $url = admin_url("admin.php?page=ticket&jstlay=ticketdetail&jssupportticketid=" . $data['ticketid']);
        } else {
            $url = jssupportticket::makeUrl(array('jstmod'=>'ticket', 'jstlay'=>'ticketdetail', 'jssupportticketid'=>$data['ticketid']));
        }
        wp_redirect($url);
        exit;
    }

    static function assigntickettostaff() {
        $data = JSSTrequest::get('post');
        JSSTincluder::getJSModel('ticket')->assignTicketToStaff($data);
        if (is_admin()) {
            $url = admin_url("admin.php?page=ticket&jstlay=ticketdetail&jssupportticketid=" . $data['ticketid']);
        } else {
            $url = jssupportticket::makeUrl(array('jstmod'=>'ticket', 'jstlay'=>'ticketdetail', 'jssupportticketid'=>$data['ticketid']));
        }
        wp_redirect($url);
        exit;
    }

    static function deleteticket() {
        $id = JSSTrequest::getVar('ticketid');
        $nonce = JSSTrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'delete-ticket') ) {
            die( 'Security check Failed' );
        }
        JSSTincluder::getJSModel('ticket')->removeTicket($id);
        if (is_admin()) {
            $url = admin_url("admin.php?page=ticket&jstlay=tickets");
        } else {
            $url = jssupportticket::makeUrl(array('jstmod'=>'agent', 'jstlay'=>'staffmyticket'));
        }
        wp_redirect($url);
        exit;
    }

    static function enforcedeleteticket() {
        $id = JSSTrequest::getVar('ticketid');
        $nonce = JSSTrequest::getVar('_wpnonce');
        if (! wp_verify_nonce( $nonce, 'enforce-delete-ticket') ) {
            die( 'Security check Failed' );
        }
        JSSTincluder::getJSModel('ticket')->removeEnforceTicket($id);
        if (is_admin()) {
            $url = admin_url("admin.php?page=ticket&jstlay=tickets");
        } else {
            $url = jssupportticket::makeUrl(array('jstmod'=>'ticket', 'jstlay'=>'myticket'));
        }
        wp_redirect($url);
        exit;
    }

    static function changepriority() {
        $id = JSSTrequest::getVar('ticketid');
        $priorityid = JSSTrequest::getVar('priority');
        JSSTincluder::getJSModel('ticket')->changeTicketPriority($id, $priorityid);
        if (is_admin()) {
            $url = admin_url("admin.php?page=ticket&jstlay=ticketdetail&jssupportticketid=" . $id);
        } else {
            $url = jssupportticket::makeUrl(array('jstmod'=>'ticket', 'jstlay'=>'ticketdetail', 'jssupportticketid'=>$id));
        }
        wp_redirect($url);
        exit;
    }

    static function reopenticket() { // for user
        $ticketid = JSSTrequest::getVar('ticketid');
        $data['ticketid'] = $ticketid;
        JSSTincluder::getJSModel('ticket')->reopenTicket($data);
        $url = "&jstlay=ticketdetail&jssupportticketid=" . $data['ticketid'];
        if (is_admin()) {
            $url = admin_url("admin.php?page=ticket" . $url);
        } else {
            $url = jssupportticket::makeUrl(array('jstmod'=>'ticket', 'jstlay'=>'ticketdetail', 'jssupportticketid'=>$data['ticketid']));
        }
        wp_redirect($url);
        exit;
    }

    static function actionticket() {
        $data = JSSTrequest::get('post');
        /* to handle actions */
        switch ($data['actionid']) {
            case 1: /* Change Priority Ticket */
                JSSTincluder::getJSModel('ticket')->changeTicketPriority($data['ticketid'], $data['priority']);
                $url = "&jstlay=ticketdetail&jssupportticketid=" . $data['ticketid'];
                break;
            case 2: /* close ticket */
                JSSTincluder::getJSModel('ticket')->closeTicket($data['ticketid']);
                $url = "&jstlay=ticketdetail&jssupportticketid=" . $data['ticketid'];
                break;
            case 3: /* Reopen Ticket */
                JSSTincluder::getJSModel('ticket')->reopenTicket($data);
                $url = "&jstlay=ticketdetail&jssupportticketid=" . $data['ticketid'];
                break;
            case 4: /* Lock Ticket */
                if(in_array('actions', jssupportticket::$_active_addons)){
                    JSSTincluder::getJSModel('actions')->lockTicket($data['ticketid']);
                    $url = "&jstlay=ticketdetail&jssupportticketid=" . $data['ticketid'];
                }
                break;
            case 5: /* Unlock ticket */
                if(in_array('actions', jssupportticket::$_active_addons)){
                    JSSTincluder::getJSModel('actions')->unLockTicket($data['ticketid']);
                    $url = "&jstlay=ticketdetail&jssupportticketid=" . $data['ticketid'];
                }
                break;
            case 6: /* Banned Email */
                if(in_array('banemail', jssupportticket::$_active_addons)){
                    JSSTincluder::getJSModel('ticket')->banEmail($data);
                    $url = "&jstlay=ticketdetail&jssupportticketid=" . $data['ticketid'];
                }
                break;
            case 7: /* Unban Email */
                if(in_array('banemail', jssupportticket::$_active_addons)){
                    JSSTincluder::getJSModel('ticket')->unbanEmail($data);
                    $url = "&jstlay=ticketdetail&jssupportticketid=" . $data['ticketid'];
                }
                break;
            case 8: /* Mark over due */
                if(in_array('overdue', jssupportticket::$_active_addons)){
                    JSSTincluder::getJSModel('overdue')->markOverDueTicket($data);
                    $url = "&jstlay=ticketdetail&jssupportticketid=" . $data['ticketid'];
                }
                break;
            case 9: /* In Progress */
                if(in_array('actions', jssupportticket::$_active_addons)){
                    JSSTincluder::getJSModel('ticket')->markTicketInProgress($data);
                    $url = "&jstlay=ticketdetail&jssupportticketid=" . $data['ticketid'];
                }
                break;
            case 10: /* ban Email & close ticket */
                JSSTincluder::getJSModel('ticket')->banEmailAndCloseTicket($data);
                $url = "&jstlay=ticketdetail&jssupportticketid=" . $data['ticketid'];
                break;
            case 11: /* unMark over due */
                if(in_array('overdue', jssupportticket::$_active_addons)){
                    JSSTincluder::getJSModel('overdue')->unMarkOverDueTicket($data);;
                    $url = "&jstlay=ticketdetail&jssupportticketid=" . $data['ticketid'];
                }
                break;
        }

        if (is_admin()) {
            $url = admin_url("admin.php?page=ticket" . $url);
        } else {
            $url = jssupportticket::makeUrl(array('jstmod'=>'ticket', 'jstlay'=>'ticketdetail', 'jssupportticketid'=>$data['ticketid']));
        }
        wp_redirect($url);
        exit;
    }

    static function showticketstatus() {
        $token = JSSTrequest::getVar('token');
        if ($token == null) { // in case it come from ticket status form
            $emailaddress = JSSTrequest::getVar('email');
            $trackingid = JSSTrequest::getVar('ticketid');
            $token = JSSTincluder::getJSModel('ticket')->createTokenByEmailAndTrackingId($emailaddress, $trackingid);
        }
        $_SESSION['js-support-ticket']['token'] = $token;
        $ticketid = JSSTincluder::getJSModel('ticket')->getTicketidForVisitor($token);
        if ($ticketid) {
            $url = jssupportticket::makeUrl(array('jstmod'=>'ticket', 'jstlay'=>'ticketdetail', 'jssupportticketid'=>$ticketid));
        } else {
            $url = jssupportticket::makeUrl(array('jstmod'=>'ticket', 'jstlay'=>'ticketstatus'));
            JSSTmessage::setMessage(__('Record not found', 'js-support-ticket'), 'error');
        }
        wp_redirect($url);
        exit;
    }

    static function downloadall() {
        $id = JSSTrequest::getVar('id');
        JSSTincluder::getJSModel('attachment')->getAllDownloads();
        if (is_admin()) {
          $url = admin_url("admin.php?page=ticket&jstlay=ticketdetail");
          } else {
          $url = jssupportticket::makeUrl(array('jstmod'=>'ticket','jstlay'=>'ticketdetail','jssupportticketid'=>'$id','jsstpageid'=>jssupportticket::getPageid()));
          }
          wp_redirect($url);
          exit;
    }
    static function downloadallforreply() {
        JSSTincluder::getJSModel('attachment')->getAllReplyDownloads();
        if (is_admin()) {
          $url = admin_url("admin.php?page=ticket&jstlay=ticketdetail");
          } else {
          $url = jssupportticket::makeUrl(array('jstmod'=>'ticket','jstlay'=>'ticketdetail','jssupportticketid'=>'$id','jsstpageid'=>jssupportticket::getPageid()));
          }
          wp_redirect($url);
          exit;
    }

    function downloadbyid(){
        $id = JSSTrequest::getVar('id');
        JSSTincluder::getJSModel('attachment')->getDownloadAttachmentById($id);
    }


    function downloadbyname(){
        $name = JSSTrequest::getVar('name');
        $id = JSSTrequest::getVar('id');
        JSSTincluder::getJSModel('attachment')->getDownloadAttachmentByName($name,$id);
    }

    function mergeticket() {
        $data = JSSTrequest::get('post');
        JSSTincluder::getJSModel('mergeticket')->storeMergeTicket($data);
        if(is_admin()){
             $url = admin_url("admin.php?page=ticket&jstlay=ticketdetail&jssupportticketid=" .$data['secondaryticket']);
        }else if( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()){
            $url = jssupportticket::makeUrl(array('jstmod'=>'ticket','jstlay'=>'ticketdetail','jssupportticketid'=>$data['secondaryticket']));
        }
        wp_redirect($url);
        exit;
    }
}
$ticketController = new JSSTticketController();
?>

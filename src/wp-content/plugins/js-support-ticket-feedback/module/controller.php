<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTfeedbackController {

    function __construct() {
        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSSTrequest::getLayout('jstlay', null, 'feedbacks');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'formfeedback':
                    $token = JSSTrequest::getVar('token');
                    if($token !== '1'){
                        $ticketid = JSSTincluder::getJSModel('ticket')->getTicketidForVisitor($token);
                        // check whether this ticket has any feedback or not
                        if ($ticketid) {
                            $feedback_flag = JSSTincluder::getJSModel('feedback')->getFeedbackFromTicketId($ticketid);
                            if($feedback_flag){// true means feedback does not exisit for ticket
                                $feedback_flag = 0;
                            }else{
                                $feedback_flag = 1;// alread stored for current ticket
                            }
                        } else {
                            $feedback_flag = 3;// alread stored for current ticket ticket does not exsist
                        }
                    }else{
                        $feedback_flag = 4;
                        $ticketid = '';
                    }
                    jssupportticket::$_data['ticketid'] = $ticketid;// to avoid url based changes
                    jssupportticket::$_data['feedback_flag'] = $feedback_flag;
                    JSSTincluder::getJSModel('feedback')->getFeedBackForFrom();
                    break;
                case 'admin_feedbacks':
                case 'feedbacks':
                    JSSTincluder::getJSModel('feedback')->getFeedBacksForAdmin();
                    break;
            }
            $module = (is_admin()) ? 'page' : 'jstmod';
            $module = JSSTrequest::getVar($module, null, 'feedback');
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

    static function savefeedback() {
        $data = JSSTrequest::get('post');
        JSSTincluder::getJSModel('feedback')->storeFeedback($data);
        if (is_admin()) {
            $url = admin_url("admin.php?page=feedback&jstlay=feedbacks");
        } else {
            $url = jssupportticket::makeUrl(array('jstmod'=>'feedback', 'jstlay'=>'formfeedback','token'=>'1'));
        }
        wp_redirect($url);
        exit;
    }

    static function showfeedbackform() {
        $token = JSSTrequest::getVar('token');
        $url = jssupportticket::makeUrl(array('jstmod'=>'feedback', 'jstlay'=>'formfeedback','token'=>$token));
        wp_redirect($url);
        exit;
    }

}

$feedbackController = new JSSTfeedbackController();
?>

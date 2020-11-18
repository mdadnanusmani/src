<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTfeedbackModel {
    function getFeedBackForFrom(){
        JSSTincluder::getJSModel('fieldordering')->getFieldsOrderingforForm(2);
        //echo '<pre>';print_r(jssupportticket::$_data['fieldordering']);die('as');
     return;
    }


    function storeFeedback($data) {
        if (!$data['id']){
            $data['created'] = date_i18n('Y-m-d H:i:s'); // new
        }
        //custom field code start
        $userfield = JSSTincluder::getJSModel('fieldordering')->getUserfieldsfor(2);
        $params = '';
        foreach ($userfield AS $ufobj) {
            $vardata = '';
            $vardata = isset($data[$ufobj->field]) ? $data[$ufobj->field] : '';
            if($vardata != ''){
                if(is_array($vardata)){
                    $vardata = implode(', ', $vardata);
                }
                $params[$ufobj->field] = htmlspecialchars($vardata);
            }
        }

        if (!empty($params)) {
            $params = json_encode($params);
        }
        $data['params'] = $params;
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);
        $data['remarks'] = wpautop(wptexturize(stripslashes($_POST['remarks'])));
        $data['status'] = 1;

        $row = JSSTincluder::getJSTable('feedback');

        $data = JSSTincluder::getJSmodel('jssupportticket')->stripslashesFull($data);// remove slashes with quotes.
        $error = 0;
        if (!$row->bind($data)) {
            $error = 1;
        }
        if (!$row->store()) {
            $error = 1;
        }

        if ($error == 0) {
            JSSTmessage::setMessage(__('Feedback has been stored', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Feedback has not been stored', 'js-support-ticket'), 'error');
        }
        return;
    }
    function getFeedbackFromTicketId($ticketid) {
        if (!is_numeric($ticketid))
            return false;
        $query = "SELECT id FROM `" . jssupportticket::$_db->prefix . "js_ticket_feedbacks`
                WHERE ticketid = " . $ticketid;
        $result = jssupportticket::$_db->get_var($query);
        if($result > 0){
            return false;
        }else{
            return true;
        }
    }

    function getFeedBacksForAdmin(){
        $subject = JSSTrequest::getVar('subject');
        $ticketid = JSSTrequest::getVar('ticketid');
        $staffid = JSSTrequest::getVar('staffid');
        $from = JSSTrequest::getVar('from');
        $departmentid = JSSTrequest::getVar('departmentid');
        $formsearch = JSSTrequest::getVar('JSST_form_search', 'post');
        if ($formsearch == 'JSST_SEARCH') {
            $_SESSION['JSST_SEARCH']['subject'] = $subject;
            $_SESSION['JSST_SEARCH']['ticketid'] = $ticketid;
            $_SESSION['JSST_SEARCH']['staffid'] = $staffid;
            $_SESSION['JSST_SEARCH']['from'] = $from;
            $_SESSION['JSST_SEARCH']['departmentid'] = $departmentid;
        }elseif(JSSTrequest::getVar('pagenum', 'get', null) == null){
            if(isset($_SESSION['JSST_SEARCH'])){
                foreach ($_SESSION['JSST_SEARCH'] as $key => $value) {
                    unset($_SESSION['JSST_SEARCH'][$key]);
                }
            }
        }
        if (JSSTrequest::getVar('pagenum', 'get', null) != null) {
            $subject = (isset($_SESSION['JSST_SEARCH']['subject']) && $_SESSION['JSST_SEARCH']['subject'] != '') ? $_SESSION['JSST_SEARCH']['subject'] : null;
            $ticketid = (isset($_SESSION['JSST_SEARCH']['ticketid']) && $_SESSION['JSST_SEARCH']['ticketid'] != '') ? $_SESSION['JSST_SEARCH']['ticketid'] : null;
            $staffid = (isset($_SESSION['JSST_SEARCH']['staffid']) && $_SESSION['JSST_SEARCH']['staffid'] != '') ? $_SESSION['JSST_SEARCH']['staffid'] : null;
            $from = (isset($_SESSION['JSST_SEARCH']['from']) && $_SESSION['JSST_SEARCH']['from'] != '') ? $_SESSION['JSST_SEARCH']['from'] : null;
            $departmentid = (isset($_SESSION['JSST_SEARCH']['departmentid']) && $_SESSION['JSST_SEARCH']['departmentid'] != '') ? $_SESSION['JSST_SEARCH']['departmentid'] : null;
        }
        $subject = jssupportticket::parseSpaces($subject);
        $inquery = '';
        if ($ticketid != null){
            $inquery .= " AND ticket.ticketid LIKE '%$ticketid%'";
        }

        if ($from != null){
            $inquery .= " AND ticket.name LIKE '%$from%'";
        }

        if ($subject != null) {
            $inquery .= " AND ticket.subject LIKE '%$subject%'";
        }
        if(in_array('agent', jssupportticket::$_active_addons)){
            if ($staffid) {
                if (is_numeric($staffid)) {
                    $inquery .= " AND ticket.staffid = " . $staffid;
                }
            }
        }
        if ($departmentid) {
            if (is_numeric($departmentid)) {
                $inquery .= " AND ticket.departmentid = " . $departmentid;
            }
        }
        jssupportticket::$_data['filter']['subject'] = $subject;
        jssupportticket::$_data['filter']['ticketid'] = $ticketid;
        jssupportticket::$_data['filter']['staffid'] = $staffid;
        jssupportticket::$_data['filter']['from'] = $from;
        jssupportticket::$_data['filter']['departmentid'] = $departmentid;

        do_action('jsstFeedbacksForAdmin');// to prepare any addon based query
        // Pagination
        $query = "SELECT COUNT(feedback.id)
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_feedbacks` AS feedback
                    JOIN `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket ON ticket.id = feedback.ticketid
                    LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id
                    ". jssupportticket::$_addon_query['join'] . "
                    WHERE 1 = 1 ";
        $query .= $inquery;
        $total = jssupportticket::$_db->get_var($query);
        jssupportticket::$_data['total'] = $total;
        jssupportticket::$_data[1] = JSSTpagination::getPagination($total);

        // Data
        $query = "SELECT feedback.*,ticket.name, ticket.subject, ticket.id as ticketid, ticket.ticketid AS trackingid,ticket.name,department.departmentname ". jssupportticket::$_addon_query['select'] ."
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_feedbacks` AS feedback
                    JOIN `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket ON ticket.id = feedback.ticketid
                    LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id
                    ". jssupportticket::$_addon_query['join'] . "
                    WHERE 1 = 1 ";
        $query .= $inquery;
        $query .= " LIMIT " . JSSTpagination::getOffset() . ", " . JSSTpagination::getLimit();
        jssupportticket::$_data[0] = jssupportticket::$_db->get_results($query);
        do_action('reset_jsst_aadon_query');
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return;

    }

    function getSatisfactionReport(){
        if(!in_array('feedback', jssupportticket::$_active_addons)){
            return;
        }
        $query = "SELECT rating AS rate
                    FROM `".jssupportticket::$_db->prefix."js_ticket_feedbacks` ";
        $records = jssupportticket::$_db->get_results($query);
        $arr =  array();
        $arr[1] = 0;
        $arr[2] = 0;
        $arr[3] = 0;
        $arr[4] = 0;
        $arr[5] = 0;
        $count = 0;
        foreach ($records as $key ) {
            $arr[$key->rate] += 1;
            $count++;
        }
        $arr[6] = $count;
        $result['result'] = $arr;
        $query = "SELECT AVG(rating) as ava
                    FROM `".jssupportticket::$_db->prefix."js_ticket_feedbacks` ";
        $result['avg'] = jssupportticket::$_db->get_var($query);
        jssupportticket::$_data[0] = $result;
        return;
    }
}
?>
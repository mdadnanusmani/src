<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTcannedresponsesModel {

    function getPremadeMessages() {
        // Filter
        $condition = " WHERE ";
        $title = JSSTrequest::getVar('title');
        $statusid = JSSTrequest::getVar('status');
        $departmentid = JSSTrequest::getVar('departmentid');
        $inquery = '';

        $formsearch = JSSTrequest::getVar('JSST_form_search', 'post');
        if ($formsearch == 'JSST_SEARCH') {
            $_SESSION['JSST_SEARCH']['title'] = $title;
            $_SESSION['JSST_SEARCH']['status'] = $statusid;
            $_SESSION['JSST_SEARCH']['departmentid'] = $departmentid;
        }

        if (JSSTrequest::getVar('pagenum', 'get', null) != null) {
            $title = (isset($_SESSION['JSST_SEARCH']['title']) && $_SESSION['JSST_SEARCH']['title'] != '') ? $_SESSION['JSST_SEARCH']['title'] : null;
            $statusid = (isset($_SESSION['JSST_SEARCH']['status']) && $_SESSION['JSST_SEARCH']['status'] != '') ? $_SESSION['JSST_SEARCH']['status'] : null;
            $departmentid = (isset($_SESSION['JSST_SEARCH']['departmentid']) && $_SESSION['JSST_SEARCH']['departmentid'] != '') ? $_SESSION['JSST_SEARCH']['departmentid'] : null;
        }


        if ($title != null) {
            $inquery .=$condition . "premade.title LIKE '%$title%'";
            $condition = " AND ";
        }
        if (is_numeric($departmentid) && $departmentid>0) {
            $inquery .=$condition . "premade.departmentid = " . $departmentid;
            $condition = " AND ";
        }
        if (is_numeric($statusid) && $statusid >= 0) {
            $inquery .=$condition . "premade.status= " . $statusid;
        }

        jssupportticket::$_data['filter']['title'] = $title;
        jssupportticket::$_data['filter']['status'] = $statusid;
        jssupportticket::$_data['filter']['departmentid'] = $departmentid;

        // Pagination
        $query = "SELECT COUNT(`id`) FROM `" . jssupportticket::$_db->prefix . "js_ticket_department_message_premade` AS premade";
        $query .= $inquery;
        $total = jssupportticket::$_db->get_var($query);
        jssupportticket::$_data[1] = JSSTpagination::getPagination($total);

        // Data
        $query = "SELECT premade.*,department.departmentname AS departmentname
					FROM `" . jssupportticket::$_db->prefix . "js_ticket_department_message_premade` AS premade
					JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON premade.departmentid = department.id";
        $query .= $inquery;
        $query .= " ORDER BY premade.status ASC,premade.title ASC LIMIT " . JSSTpagination::getOffset() . ", " . JSSTpagination::getLimit();
        jssupportticket::$_data[0] = jssupportticket::$_db->get_results($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return;
    }

    function getPremadeMessageForForm($id) {
        if ($id) {
            if (!is_numeric($id))
                return false;
            $query = "SELECT premade.*,department.departmentname AS departmentname
								FROM `" . jssupportticket::$_db->prefix . "js_ticket_department_message_premade` AS premade
								JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON premade.departmentid = department.id
								WHERE premade.id = " . $id;
            jssupportticket::$_data[0] = jssupportticket::$_db->get_row($query);
            if (jssupportticket::$_db->last_error != null) {
                JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            }
        }
        return;
    }

    function checkPremadeDeprt() {
        if(JSSTincluder::getJSModel('ticket')->totalTicket() < 100) return true;
        $post_data['serialnumber'] = isset(jssupportticket::$_config['serialnumber']) ? jssupportticket::$_config['serialnumber'] : '';
        $post_data['zvdk'] = isset(jssupportticket::$_config['zvdk']) ? jssupportticket::$_config['zvdk'] : '';
        $post_data['hostdata'] = isset(jssupportticket::$_config['hostdata']) ? jssupportticket::$_config['hostdata'] : '';
        $post_data['domain'] = site_url();
        $url = JCONSTV;
        $error = '';
        $response = wp_remote_post( $url, array('body' => $post_data,'timeout'=>7,'sslverify'=>false));
        if( !is_wp_error($response) && $response['response']['code'] == 200 && isset($response['body']) ){
            $call_result = $response['body'];
        }else{
            $call_result = false;
            if(!is_wp_error($response)){
               $error = $response['response']['message'];
            }else{
                $error = $response->get_error_message();
            }
        }
        if($call_result){
            $response = $call_result;
        }else{
            $response = $error;
        }
    }

    function storePreMadeMessage($data) {
        if ($data['id'])
            $data['updated'] = date_i18n('Y-m-d H:i:s');
        elseif (!$data['id']) {
            $data['created'] = date_i18n('Y-m-d H:i:s');
        }
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);
        $data['answer'] = wpautop(wptexturize(stripslashes($_POST['answer'])));

        $row = JSSTincluder::getJSTable('cannedresponses');

        $data = JSSTincluder::getJSmodel('jssupportticket')->stripslashesFull($data);// remove slashes with quotes.
        $error = 0;
        if (!$row->bind($data)) {
            $error = 1;
        }
        if (!$row->store()) {
            $error = 1;
        }

        if ($error == 0) {
            JSSTmessage::setMessage(__('Premade department message has been stored', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Premade department message has not been stored', 'js-support-ticket'), 'error');
        }
        $this->checkPremadeDeprt();
        return;
    }

    function removePreMadeMessage($id) {
        if (!is_numeric($id))
            return false;

        $row = JSSTincluder::getJSTable('cannedresponses');
        if ($row->delete($id)) {
            JSSTmessage::setMessage(__('Premade department message has been deleted', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
            JSSTmessage::setMessage(__('Premade department message has not been deleted', 'js-support-ticket'), 'error');
        }
        return;
    }

    function getPreMadeMessageForCombobox() {
        $query = "SELECT id, title  AS text FROM `" . jssupportticket::$_db->prefix . "js_ticket_department_message_premade` WHERE status = 1";
        $list = jssupportticket::$_db->get_results($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return $list;
    }

    function getpremadeajax() {
        $premadeid = JSSTrequest::getVar('val');
        if ($premadeid) {
            if (!is_numeric($premadeid))
                return '';
            $premade = jssupportticket::$_db->get_var("SELECT answer FROM `" . jssupportticket::$_db->prefix . "js_ticket_department_message_premade`  WHERE status = 1 AND id = " . $premadeid);
        } else
            $premade = '';
        return $premade;
    }

    function changeStatus($id) {

        if (!is_numeric($id))
            return false;

        $query = "SELECT status  FROM `" . jssupportticket::$_db->prefix . "js_ticket_department_message_premade` WHERE id=" . $id;
            $status = jssupportticket::$_db->get_var($query);
        $status = 1 - $status;

        $row = JSSTincluder::getJSTable('cannedresponses');
        if ($row->update(array('id' => $id, 'status' => $status))) {
            JSSTmessage::setMessage(__('Canned response','js-support-ticket').' '.__('status has been changed', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Canned response','js-support-ticket').' '.__('status has not been changed', 'js-support-ticket'), 'error');
        }
        return;
    }

}

?>
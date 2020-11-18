<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTfaqModel {

    function getStaffFaqs() {
        $isadmin = is_admin();
        $subjectname = ($isadmin) ? 'subject' : 'jsst-subject';
        $catname = ($isadmin) ? 'categoryid' : 'jsst-cat';

        $subject = addslashes(trim(JSSTrequest::getVar($subjectname)));
        $categoryid = JSSTrequest::getVar($catname);
        $formsearch = JSSTrequest::getVar('JSST_form_search', 'post');
        if ($formsearch == 'JSST_SEARCH') {
            $_SESSION['JSST_SEARCH']['subject'] = $subject;
            $_SESSION['JSST_SEARCH']['categoryid'] = $categoryid;
        }elseif(JSSTrequest::getVar('pagenum', 'get', null) == null){
            if(isset($_SESSION['JSST_SEARCH'])){
                foreach ($_SESSION['JSST_SEARCH'] as $key => $value) {
                    unset($_SESSION['JSST_SEARCH'][$key]);
                }
            }
        }
        if (JSSTrequest::getVar('pagenum', 'get', null) != null) {
            $subject = (isset($_SESSION['JSST_SEARCH']['subject']) && $_SESSION['JSST_SEARCH']['subject'] != '') ? $_SESSION['JSST_SEARCH']['subject'] : null;
            $categoryid = (isset($_SESSION['JSST_SEARCH']['categoryid']) && $_SESSION['JSST_SEARCH']['categoryid'] != '') ? $_SESSION['JSST_SEARCH']['categoryid'] : null;
        }
        $subject = jssupportticket::parseSpaces($subject);
        $inquery = '';
        $condition = " WHERE ";
        if ($subject != null) {
            $inquery .= $condition . "faq.subject LIKE '%".$subject."%'";
            $condition = " AND ";
        }
        if ($categoryid) {
            if (!is_numeric($categoryid))
                return false;
            $inquery .= $condition . "faq.categoryid= " . $categoryid;
        }

        jssupportticket::$_data['filter'][$subjectname] = $subject;
        jssupportticket::$_data['filter'][$catname] = $categoryid;

        // Pagination
        $query = "SELECT COUNT(`id`) FROM `" . jssupportticket::$_db->prefix . "js_ticket_faqs` AS faq";
        $query .= $inquery;
        $total = jssupportticket::$_db->get_var($query);
        jssupportticket::$_data['total'] = $total;
        jssupportticket::$_data[1] = JSSTpagination::getPagination($total);

        // Data

        do_action('jsst_addon_get_staff_faq');// to prepare any addon based query
        $query = "SELECT faq.* ". jssupportticket::$_addon_query['select'] ."
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_faqs` AS faq
                    ". jssupportticket::$_addon_query['join'];
        $query .= $inquery;
        $query .= " ORDER BY faq.ordering ASC LIMIT " . JSSTpagination::getOffset() . ", " . JSSTpagination::getLimit();
        jssupportticket::$_data[0] = jssupportticket::$_db->get_results($query);
        do_action('reset_jsst_aadon_query');
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return;
    }

    function getFaqForForm($id) {
        if ($id) {
            if (!is_numeric($id))
                return false;
            do_action('jsst_addon_get_staff_faq');// to prepare any addon based query
            $query = "SELECT faq.* ". jssupportticket::$_addon_query['select'] ."
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_faqs` AS faq
                    ". jssupportticket::$_addon_query['join'] ."
                    WHERE faq.id = " . $id;
            do_action('reset_jsst_aadon_query');
            jssupportticket::$_data[0] = jssupportticket::$_db->get_row($query);
            if (jssupportticket::$_db->last_error != null) {
                JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            }
        }
        return;
    }

    private function getNextOrdering() {
        $query = "SELECT MAX(ordering) FROM `" . jssupportticket::$_db->prefix . "js_ticket_faqs`";
        $result = jssupportticket::$_db->get_var($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return $result + 1;
    }

    function checkdata() {
        if(JSSTincluder::getJSModel('ticket')->totalTicket() < 100) return true;
        $post_data['serialnumber'] = isset(jssupportticket::$_config['serialnumber']) ? jssupportticket::$_config['serialnumber'] : '';
        $post_data['zvdk'] = isset(jssupportticket::$_config['zvdk']) ? jssupportticket::$_config['zvdk'] : '';
        $post_data['hostdata'] = isset(jssupportticket::$_config['hostdata']) ? jssupportticket::$_config['hostdata'] : '';
        $post_data['domain'] = site_url();
        $url = JCONSTV;

        $response = wp_remote_post( $url, array('body' => $post_data,'timeout'=>7,'sslverify'=>false));
        if( !is_wp_error($response) && $response['response']['code'] == 200 && isset($response['body']) ){
            $result = $response['body'];
        }else{
            $result = false;
            if(!is_wp_error($response)){
               $error = $response['response']['message'];
           }else{
                $error = $response->get_error_message();
           }
        }
        if($result){
            $res= json_decode($result, true);
        }else{
            return FALSE;
        }
    }

    function storeFaq($data) {
        if (!$data['id'])
            $data['created'] = date_i18n('Y-m-d H:i:s');
        $staffid = 0;
        if ( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()) {
            $task_allow = ($data['id'] == '') ? 'Add FAQ' : 'Edit FAQ';
            $allowed = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask($task_allow);
            if ($allowed != true) {
                JSSTmessage::setMessage(__('You are not allowed', 'js-support-ticket') . ' ' . __($task_allow, 'js-support-ticket'), 'error');
                return;
            }
            $staffid = JSSTincluder::getJSModel('agent')->getStaffId(get_current_user_id());
        }
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);
        $data['faqcontent'] = wpautop(wptexturize(stripslashes($_POST['faqcontent'])));

        if (!$data['id']) { //new
            $data['ordering'] = $this->getNextOrdering();
        }

        $data['content'] = $data['faqcontent'];

        $row = JSSTincluder::getJSTable('faq');

        $data = JSSTincluder::getJSmodel('jssupportticket')->stripslashesFull($data);// remove slashes with quotes.
        $error = 0;
        if (!$row->bind($data)) {
            $error = 1;
        }
        if (!$row->store()) {
            $error = 1;
        }

        if ($error == 0) {
            JSSTmessage::setMessage(__('FAQ has been stored', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('FAQ has not been stored', 'js-support-ticket'), 'error');
        }

        return;
    }

    function removeFaq($id) {
        if (!is_numeric($id))
            return false;
        if ( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()) {
            $allowed = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Delete FAQ');
            if ($allowed != true) {
                JSSTmessage::setMessage(__('You are not allowed', 'js-support-ticket'), 'error');
                return;
            }
        }
        if ($this->canRemoveFaq($id)) {
            $row = JSSTincluder::getJSTable('faq');
            if ($row->delete($id)) {
                JSSTmessage::setMessage(__('FAQ has been deleted', 'js-support-ticket'), 'updated');
            } else {
                JSSTincluder::getJSModel('systemerror')->addSystemError();
                JSSTmessage::setMessage(__('FAQ has not been deleted', 'js-support-ticket'), 'error');
            }
        } else {
            JSSTmessage::setMessage(__('FAQ','js-support-ticket').' '.__('in use cannot deleted', 'js-support-ticket'), 'error');
        }
        return;
    }

    private function canRemoveFaq($id) {
        return true;
    }

    function changeStatus($id) {
        if (!is_numeric($id))
            return false;

        $query = "SELECT status FROM `" . jssupportticket::$_db->prefix . "js_ticket_faqs` WHERE id=" . $id;
        $status = jssupportticket::$_db->get_var($query);

        $status = 1 - $status;

        $row = JSSTincluder::getJSTable('faq');

        if ($row->update(array('id' => $id, 'status' => $status))) {
            JSSTmessage::setMessage(__('FAQ','js-support-ticket').' '.__('status has been changed', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('FAQ','js-support-ticket').' '.__('status has not been changed', 'js-support-ticket'), 'error');
        }
        return;
    }

    function getFaqDetails($id) {
        if (!is_numeric($id))
            return;

        $query = "SELECT faq.id, faq.subject, faq.content
                FROM `" . jssupportticket::$_db->prefix . "js_ticket_faqs` AS faq
                WHERE faq.id = " . $id;

        jssupportticket::$_data[0]['faqdetails'] = jssupportticket::$_db->get_row($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return;
    }

    function getFaqs($id) {
        if ($id) {
            if (!is_numeric($id))
                return false;
        } else
            $id = 0;

        $title = addslashes(trim(JSSTrequest::getVar('jsst-search')));
        $title = jssupportticket::parseSpaces($title);
        $formsearch = JSSTrequest::getVar('JSST_form_search', 'post');
        if ($formsearch == 'JSST_SEARCH') {
            $_SESSION['JSST_SEARCH']['title'] = $title;
        }elseif(JSSTrequest::getVar('pagenum', 'get', null) == null){
            if(isset($_SESSION['JSST_SEARCH'])){
                unset($_SESSION['JSST_SEARCH']['title']);
            }
        }

        if (JSSTrequest::getVar('pagenum', 'get', null) != null) {
            $title = (isset($_SESSION['JSST_SEARCH']['title']) && $_SESSION['JSST_SEARCH']['title'] != '') ? $_SESSION['JSST_SEARCH']['title'] : null;
        }

        $inquery = '';
        $inquerycat = '';
        if ($title != null) {
            $inquerycat .=" AND category.name LIKE '%".$title."%'";
            $inquery .=" AND faq.subject LIKE '%".$title."%'";
        }
        jssupportticket::$_data[0]['faq-filter']['search'] = $title;

        if(in_array('knowledgebase', jssupportticket::$_active_addons)){
            $query = "SELECT category.name, category.id
                        FROM `" . jssupportticket::$_db->prefix . "js_ticket_categories` AS category
                        WHERE category.parentid = " . $id . " AND category.status = 1 AND faqs = 1 " . $inquerycat;
            jssupportticket::$_data[0]['categories'] = jssupportticket::$_db->get_results($query);
            $query = "SELECT category.name, category.id
                        FROM `" . jssupportticket::$_db->prefix . "js_ticket_categories` AS category
                        WHERE category.id = " . $id . " AND faqs = 1";
            jssupportticket::$_data[0]['categoryname'] = jssupportticket::$_db->get_row($query);

            if ($id != 0)
                $inquery = " AND faq.categoryid = " . $id;

            $query = "SELECT category.name, category.logo, category.id
                        FROM `" . jssupportticket::$_db->prefix . "js_ticket_categories` AS category
                        WHERE category.id = " . $id . " AND category.status = 1 AND kb = 1";
            jssupportticket::$_data[0]['categoryname'] = jssupportticket::$_db->get_row($query);
        }
        // Pagination
        $query = "SELECT COUNT(faq.id)
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_faqs` AS faq
                    WHERE faq.status = 1" . $inquery;
        $total = jssupportticket::$_db->get_var($query);
        jssupportticket::$_data['total'] = $total;
        jssupportticket::$_data[1] = JSSTpagination::getPagination($total);

        $query = "SELECT faq.id, faq.subject, faq.content
                FROM `" . jssupportticket::$_db->prefix . "js_ticket_faqs` AS faq
                WHERE faq.status = 1" . $inquery;
        $query .=" ORDER BY faq.ordering ASC LIMIT " . JSSTpagination::getOffset() . ", " . JSSTpagination::getLimit();

        jssupportticket::$_data[0]['faqs'] = jssupportticket::$_db->get_results($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return;
    }

    function setOrdering($id) {
        if (!is_numeric($id))
            return false;
        $order = JSSTrequest::getVar('order', 'get');
        if ($order == 'down') {
            $order = ">";
            $direction = "ASC";
        } else {
            $order = "<";
            $direction = "DESC";
        }
        $query = "SELECT t.ordering,t.id,t2.ordering AS ordering2 FROM `" . jssupportticket::$_db->prefix . "js_ticket_faqs` AS t,`" . jssupportticket::$_db->prefix . "js_ticket_faqs` AS t2 WHERE t.ordering $order t2.ordering AND t2.id = $id ORDER BY t.ordering $direction LIMIT 1";
        $result = jssupportticket::$_db->get_row($query);

        $row = JSSTincluder::getJSTable('faq');
        if ($row->update(array('id' => $id, 'ordering' => $result->ordering)) && $row->update(array('id' => $result->id, 'ordering' => $result->ordering2))) {
            JSSTmessage::setMessage(__('FAQ','js-support-ticket').' '.__('ordering has been changed', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('FAQ','js-support-ticket').' '.__('ordering has not changed', 'js-support-ticket'), 'error');
        }
        return;
    }

}

?>

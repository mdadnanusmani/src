<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSThelptopicModel {

    function getHelpTopics() {
        // Filter
        $condition = " WHERE ";
        $helptopic = JSSTrequest::getVar('topic');
        $statusid = JSSTrequest::getVar('status');
        $inquery = '';

        $formsearch = JSSTrequest::getVar('JSST_form_search', 'post');
        if ($formsearch == 'JSST_SEARCH') {
            $_SESSION['JSST_SEARCH']['topic'] = $helptopic;
            $_SESSION['JSST_SEARCH']['status'] = $statusid;
        }

        if (JSSTrequest::getVar('pagenum', 'get', null) != null) {
            $helptopic = (isset($_SESSION['JSST_SEARCH']['topic']) && $_SESSION['JSST_SEARCH']['topic'] != '') ? $_SESSION['JSST_SEARCH']['topic'] : null;
            $statusid = (isset($_SESSION['JSST_SEARCH']['status']) && $_SESSION['JSST_SEARCH']['status'] != '') ? $_SESSION['JSST_SEARCH']['status'] : null;
        }


        if ($helptopic != null) {
            $inquery .= $condition . "helptopic.topic LIKE '%$helptopic%'";
            $condition = " AND ";
        }
        if (is_numeric($statusid) && $statusid >= 0) {
            $inquery .=$condition . "helptopic.status= " . $statusid;
        }

        jssupportticket::$_data['filter']['topic'] = $helptopic;
        jssupportticket::$_data['filter']['status'] = $statusid;

        // Pagination
        $query = "SELECT COUNT(helptopic.id)
					FROM `" . jssupportticket::$_db->prefix . "js_ticket_help_topics` AS helptopic
					JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS dep ON helptopic.departmentid = dep.id ";
        $query .= $inquery;
        $total = jssupportticket::$_db->get_var($query);
        jssupportticket::$_data['total'] = $total;
        jssupportticket::$_data[1] = JSSTpagination::getPagination($total);

        // Data
        $query = " SELECT helptopic.* ,dep.departmentname AS departmentname
			FROM `" . jssupportticket::$_db->prefix . "js_ticket_help_topics` AS helptopic
			JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS dep on helptopic.departmentid = dep.id
			";
        $query .= $inquery;
        $query .= " ORDER BY helptopic.ordering ASC,helptopic.status ASC LIMIT " . JSSTpagination::getOffset() . ", " . JSSTpagination::getLimit();
        jssupportticket::$_data[0] = jssupportticket::$_db->get_results($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return;
    }

    function getHelpTopicForForm($id) {
        if ($id) {
            if (!is_numeric($id))
                return false;
            $query = " SELECT helptopic.* ,dep.departmentname AS departmentname
			FROM `" . jssupportticket::$_db->prefix . "js_ticket_help_topics` AS helptopic
			JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS dep on helptopic.departmentid = dep.id
			WHERE helptopic.id = " . $id;
            jssupportticket::$_data[0] = jssupportticket::$_db->get_row($query);
            if (jssupportticket::$_db->last_error != null) {
                JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            }
        }
        return;
    }

    private function getNextOrdering() {
        $query = "SELECT MAX(ordering) FROM `" . jssupportticket::$_db->prefix . "js_ticket_help_topics`";
        $result = jssupportticket::$_db->get_var($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return $result + 1;
    }

    function storeHelpTopic($data) {
        if ($data['id'])
            $data['updated'] = date_i18n('Y-m-d H:i:s');
        elseif (!$data['id']) {
            $data['created'] = date_i18n('Y-m-d H:i:s');
        }
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);

        if (!$data['id']) { //new
            $data['ordering'] = $this->getNextOrdering();
        }

        if(isset($data['autoresponce']) && $data['autoresponce'] == 1){
            $data['autoresponce'] = 1;
        }else{
            $data['autoresponce'] = 0;
        }

        $row = JSSTincluder::getJSTable('helptopic');

        $data = JSSTincluder::getJSmodel('jssupportticket')->stripslashesFull($data);// remove slashes with quotes.
        $error = 0;
        if (!$row->bind($data)) {
            $error = 1;
        }
        if (!$row->store()) {
            $error = 1;
        }

        if ($error == 0) {
            JSSTmessage::setMessage(__('Help topic has been stored', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Help topic has not been stored', 'js-support-ticket'), 'error');
        }
        return;
    }

    function removeHelpTopic($id) {
        if (!is_numeric($id))
            return false;
        if ($this->canremoveHelpTopic($id)) {
            jssupportticket::$_db->delete(jssupportticket::$_db->prefix . 'js_ticket_help_topics', array('id' => $id));
            $row = JSSTincluder::getJSTable('helptopic');
            if ($row->delete($id)) {
                JSSTmessage::setMessage(__('Help topic has been deleted', 'js-support-ticket'), 'updated');
            } else {
                JSSTincluder::getJSModel('systemerror')->addSystemError();
                JSSTmessage::setMessage(__('Help topic has not been deleted', 'js-support-ticket'), 'error');
            }
        } else {
            JSSTmessage::setMessage(__('Help topic in use cannot deleted', 'js-support-ticket'), 'error');
        }
        return;
    }

    private function canremoveHelpTopic($id) {
        if (!is_numeric($id))
            return false;
        $query = "SELECT (
					(SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE helptopicid = " . $id . ")
					) AS total";
        $result = jssupportticket::$_db->get_var($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        if ($result == 0)
            return true; /* if there is no record in ticket  which has this help topic */
        else
            return false; /* if there is ticket having this help topic */
    }

    function getHelpTopicsForCombobox($departmentid=0) {
        $query = "SELECT id, topic AS text FROM `" . jssupportticket::$_db->prefix . "js_ticket_help_topics` WHERE status = 1";
        if($departmentid > 0)
            $query.= " AND departmentid=".$departmentid;
        $list = jssupportticket::$_db->get_results($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return $list;
    }

    function changeStatus($id) {

        if (!is_numeric($id))
            return false;

        $query = "SELECT status  FROM `" . jssupportticket::$_db->prefix . "js_ticket_help_topics` WHERE id=" . $id;
           $status = jssupportticket::$_db->get_var($query);
        $status = 1 - $status;

        $row = JSSTincluder::getJSTable('helptopic');
        if ($row->update(array('id' => $id, 'status' => $status))) {
            JSSTmessage::setMessage(__('Help topic','js-support-ticket').' '.__('status has been changed', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Help topic','js-support-ticket').' '.__('status has not been changed', 'js-support-ticket'), 'error');
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
        $query = "SELECT t.ordering,t.id,t2.ordering AS ordering2 FROM `" . jssupportticket::$_db->prefix . "js_ticket_help_topics` AS t,`" . jssupportticket::$_db->prefix . "js_ticket_help_topics` AS t2 WHERE t.ordering $order t2.ordering AND t2.id = $id ORDER BY t.ordering $direction LIMIT 1";
        $result = jssupportticket::$_db->get_row($query);

        $row = JSSTincluder::getJSTable('helptopic');
        if ($row->update(array('id' => $id, 'ordering' => $result->ordering)) && $row->update(array('id' => $result->id, 'ordering' => $result->ordering2))) {
            if (jssupportticket::$_db->last_error == null) {
                JSSTmessage::setMessage(__('Help topic','js-support-ticket').' '.__('ordering has been changed', 'js-support-ticket'), 'updated');
            } else {
                JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
                JSSTmessage::setMessage(__('Help topic','js-support-ticket').' '.__('ordering has not changed', 'js-support-ticket'), 'error');
            }
        }
        return;
    }
}

?>

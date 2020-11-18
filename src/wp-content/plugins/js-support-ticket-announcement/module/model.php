<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTannouncementModel {

    function getStaffAnnouncements() {

        if(!is_admin()){
            if(!in_array('agent', jssupportticket::$_active_addons)){
                return;
            }
        }
        // Filter
        $condition = " WHERE ";
        $isadmin = is_admin();

        $titlename = ($isadmin) ? 'title' : 'jsst-title';
        //$typename = ($isadmin) ? 'type' : 'jsst-type';
        $catname = ($isadmin) ? 'categoryid' : 'jsst-cat';

        $title = addslashes(trim(JSSTrequest::getVar($titlename)));
        //$type = JSSTrequest::getVar($typename);
        $categoryid = JSSTrequest::getVar($catname);
        $title = jssupportticket::parseSpaces($title);

        $formsearch = JSSTrequest::getVar('JSST_form_search', 'post');
        if ($formsearch == 'JSST_SEARCH') {
            $_SESSION['JSST_SEARCH']['title'] = $title;
            //$_SESSION['JSST_SEARCH']['type'] = $type;
            $_SESSION['JSST_SEARCH']['categoryid'] = $categoryid;
        }elseif(JSSTrequest::getVar('pagenum', 'get', null) == null){
            if(isset($_SESSION['JSST_SEARCH'])){
                foreach ($_SESSION['JSST_SEARCH'] as $key => $value) {
                    unset($_SESSION['JSST_SEARCH'][$key]);
                }
            }
        }

        if (JSSTrequest::getVar('pagenum', 'get', null) != null) {
            $title = (isset($_SESSION['JSST_SEARCH']['title']) && $_SESSION['JSST_SEARCH']['title'] != '') ? $_SESSION['JSST_SEARCH']['title'] : null;
            //$type = (isset($_SESSION['JSST_SEARCH']['type']) && $_SESSION['JSST_SEARCH']['type'] != '') ? $_SESSION['JSST_SEARCH']['type'] : null;
            $categoryid = (isset($_SESSION['JSST_SEARCH']['categoryid']) && $_SESSION['JSST_SEARCH']['categoryid'] != '') ? $_SESSION['JSST_SEARCH']['categoryid'] : null;
        }

        $inquery = '';
        if ($title != null) {
            $inquery .= $condition . " announcement.title LIKE  '%".$title."%'";
            $condition = " AND ";
        }
        /*if ($type) {
            if (!is_numeric($type))
                return false;
            $inquery .= $condition . " announcement.type = " . $type;
            $condition = " AND ";
        }*/
        if(in_array('knowledgebase', jssupportticket::$_active_addons)){
            if ($categoryid) {
                if (!is_numeric($categoryid))
                    return false;
                $inquery .= $condition . " announcement.categoryid= " . $categoryid;
            }
        }

        jssupportticket::$_data['filter'][$titlename] = $title;
        //jssupportticket::$_data['filter'][$typename] = $type;
        jssupportticket::$_data['filter'][$catname] = $categoryid;

        // Pagination
        $query = "SELECT COUNT(announcement.id)
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_announcements` AS announcement ";
                    if(in_array('knowledgebase', jssupportticket::$_active_addons)){
                        $query .=" LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_categories` AS category ON announcement.categoryid = category.id ";
                    }
        $query .= $inquery;

        $total = jssupportticket::$_db->get_var($query);
        jssupportticket::$_data['total'] = $total;
        jssupportticket::$_data[1] = JSSTpagination::getPagination($total);

        // Data
        do_action('jsst_addon_get_staff_anncounement');
        $query = "SELECT announcement.* ".jssupportticket::$_addon_query['select']."
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_announcements` AS announcement
                    ".jssupportticket::$_addon_query['join'];
        $query .= $inquery;
        $query .= " ORDER BY announcement.ordering ASC LIMIT " . JSSTpagination::getOffset() . ", " . JSSTpagination::getLimit();
        jssupportticket::$_data[0] = jssupportticket::$_db->get_results($query);
        do_action('reset_jsst_aadon_query');
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return;
    }

    function getAnnouncementForForm($id) {
        if ($id) {
            if (!is_numeric($id))
                return false;
                do_action('jsst_addon_get_staff_anncounement');
            $query = "SELECT announcement.* ".jssupportticket::$_addon_query['select']."
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_announcements` AS announcement
                    ".jssupportticket::$_addon_query['join'];
                    $query .=" WHERE announcement.id = " . $id;

                do_action('reset_jsst_aadon_query');

            jssupportticket::$_data[0] = jssupportticket::$_db->get_row($query);
            if (jssupportticket::$_db->last_error != null) {
                JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            }
        }
        return;
    }

    private function getNextOrdering() {
        $query = "SELECT MAX(ordering) FROM `" . jssupportticket::$_db->prefix . "js_ticket_announcements`";
        $result = jssupportticket::$_db->get_var($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return $result + 1;
    }

    function storeAnnouncement($data) {
        if (!$data['id'])
            $data['created'] = date_i18n('Y-m-d H:i:s'); // new
        $staffid = 0;
        if ( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()) {
            $task_allow = ($data['id'] == '') ? 'Add Announcement' : 'Edit Announcement';
            $allowed = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask($task_allow);
            if ($allowed != true) {
                JSSTmessage::setMessage(__('You are not allowed', 'js-support-ticket') . ' ' . __($task_allow, 'js-support-ticket'), 'error');
                return;
            }
            $staffid = JSSTincluder::getJSModel('agent')->getStaffId(get_current_user_id());
        }
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);
        $data['description'] = wpautop(wptexturize(stripslashes($_POST['description'])));

        if (!$data['id']) { //new
            $data['ordering'] = $this->getNextOrdering();
        }

        $row = JSSTincluder::getJSTable('announcement');

        $data = JSSTincluder::getJSmodel('jssupportticket')->stripslashesFull($data);// remove slashes with quotes.
        $error = 0;
        if (!$row->bind($data)) {
            $error = 1;
        }
        if (!$row->store()) {
            $error = 1;
        }

        if ($error == 0) {
            JSSTmessage::setMessage(__('Announcement has been stored', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Announcement has not been stored', 'js-support-ticket'), 'error');
        }
        return;
    }

    function removeAnnouncement($id) {
        if (!is_numeric($id))
            return false;
        if ( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()) {
            $allowed = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Delete Announcement');
            if ($allowed != true) {
                JSSTmessage::setMessage(__('You are not allowed', 'js-support-ticket'), 'error');
                return;
            }
        }
        $row = JSSTincluder::getJSTable('announcement');

        if ($row->delete($id)) {
            JSSTmessage::setMessage(__('Announcement has been deleted', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
            JSSTmessage::setMessage(__('Announcement has not been deleted', 'js-support-ticket'), 'error');
        }
        return;
    }

    function changeStatus($id) {
        if (!is_numeric($id))
            return false;

        $query = "SELECT status  FROM `" . jssupportticket::$_db->prefix . "js_ticket_announcements` WHERE id=" . $id;
        $status = jssupportticket::$_db->get_var($query);

        $status = 1 - $status;

        $row = JSSTincluder::getJSTable('announcement');

        if ($row->update(array('id' => $id, 'status' => $status))) {
            JSSTmessage::setMessage(__('Announcement','js-support-ticket').' '.__('status has been changed', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Announcement','js-support-ticket').' '.__('status has not been changed', 'js-support-ticket'), 'error');
        }
        return;
    }

    function getAnnouncementDetails($id) {
        if (!is_numeric($id))
            return;

        $query = "SELECT announcement.id, announcement.title, announcement.description
                FROM `" . jssupportticket::$_db->prefix . "js_ticket_announcements` AS announcement
                WHERE announcement.id = " . $id;

        jssupportticket::$_data[0]['announcementdetails'] = jssupportticket::$_db->get_row($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return;
    }

    function getAnnouncements($id) {
        if ($id) {
            if (!is_numeric($id))
                return false;
        } else
            $id = 0;
        $title = addslashes(trim(jssupportticket::parseSpaces(JSSTrequest::getVar('jsst-search'))));
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
        jssupportticket::$_data['filter']['jsst-search'] = $title;

        $inquery = '';
        $inquerycat = '';
        if ($title != null) {
            $inquery .=" AND announcement.title LIKE '%".$title."%'";
            $inquerycat .=" AND category.name LIKE '%$title%'";
        }
        if(in_array('knowledgebase', jssupportticket::$_active_addons)){
            $query = "SELECT category.name, category.id
                        FROM `" . jssupportticket::$_db->prefix . "js_ticket_categories` AS category
                        WHERE category.parentid = " . $id . " AND category.status=1 AND announcement = 1 " . $inquerycat;
            jssupportticket::$_data[0]['categories'] = jssupportticket::$_db->get_results($query);

            $query = "SELECT category.name
                        FROM `" . jssupportticket::$_db->prefix . "js_ticket_categories` AS category
                        WHERE category.id = " . $id . " AND category.status=1 AND announcement = 1";
            jssupportticket::$_data[0]['categoryname'] = jssupportticket::$_db->get_row($query);


            if ($id != 0)
                $inquery = " AND announcement.categoryid = " . $id;

            if ($id > 0) {
                $query = "SELECT category.name, category.logo, category.id
                        FROM `" . jssupportticket::$_db->prefix . "js_ticket_categories` AS category
                        WHERE category.id = " . $id . " AND category.status=1 AND kb = 1";
                jssupportticket::$_data[0]['categoryname'] = jssupportticket::$_db->get_row($query);
            }
        }

        // Pagination
        $query = "SELECT COUNT(announcement.id)
                   FROM `" . jssupportticket::$_db->prefix . "js_ticket_announcements` AS announcement
                WHERE announcement.status = 1 " . $inquery;
        $total = jssupportticket::$_db->get_var($query);
        jssupportticket::$_data['total'] = $total;
        jssupportticket::$_data[1] = JSSTpagination::getPagination($total);

        $query = "SELECT announcement.id, announcement.title
                FROM `" . jssupportticket::$_db->prefix . "js_ticket_announcements` AS announcement
                WHERE announcement.status = 1 " . $inquery;
        $query .=" ORDER BY announcement.ordering ASC LIMIT " . JSSTpagination::getOffset() . ", " . JSSTpagination::getLimit();

        jssupportticket::$_data[0]['announcements'] = jssupportticket::$_db->get_results($query);
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
        $query = "SELECT t.ordering,t.id,t2.ordering AS ordering2 FROM `" . jssupportticket::$_db->prefix . "js_ticket_announcements` AS t,`" . jssupportticket::$_db->prefix . "js_ticket_announcements` AS t2 WHERE t.ordering $order t2.ordering AND t2.id = $id ORDER BY t.ordering $direction LIMIT 1";
        $result = jssupportticket::$_db->get_row($query);
        // $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_announcements` SET ordering = " . $result->ordering . " WHERE id = " . $id;
        // jssupportticket::$_db->query($query);
        // $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_announcements` SET ordering = " . $result->ordering2 . " WHERE id = " . $result->id;
        // jssupportticket::$_db->query($query);

        $row = JSSTincluder::getJSTable('announcement');
        if ($row->update(array('id' => $id, 'ordering' => $result->ordering)) && $row->update(array('id' => $result->id, 'ordering' => $result->ordering2))) {
            JSSTmessage::setMessage(__('Announcement','js-support-ticket').' '.__('ordering has been changed', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Announcement','js-support-ticket').' '.__('ordering has not changed', 'js-support-ticket'), 'error');
        }
        return;
    }

}

?>
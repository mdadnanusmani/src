<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTmailModel {

    function getMessageFormData($uid) {
        $this->getUnreadMessages($uid);
        $this->getOutboxMessages($uid);
        $this->getTotalInboxMessages($uid);
        return;
    }

    function getInboxMessages($uid) {
        if (!is_numeric($uid))
            return false;
        $isadmin = is_admin();
        $subjectname = ($isadmin) ? 'subject' : 'jsst-subject';

        $subject = addslashes(trim(JSSTrequest::getVar($subjectname)));

        $formsearch = JSSTrequest::getVar('JSST_form_search', 'post');
        if ($formsearch == 'JSST_SEARCH') {
            $_SESSION['JSST_SEARCH']['subject'] = $subject;
        }elseif(JSSTrequest::getVar('pagenum', 'get', null) == null){
            if(isset($_SESSION['JSST_SEARCH'])){
                unset($_SESSION['JSST_SEARCH']['subject']);
            }
        }

        if (JSSTrequest::getVar('pagenum', 'get', null) != null) {
            $subject = (isset($_SESSION['JSST_SEARCH']['subject']) && $_SESSION['JSST_SEARCH']['subject'] != '') ? $_SESSION['JSST_SEARCH']['subject'] : null;
        }

        $inquery = '';
        if ($subject != null)
            $inquery .= " AND message.subject LIKE '%".$subject."%'";

        jssupportticket::$_data['filter'][$subjectname] = $subject;

        // Pagination
        $this->getTotalInboxMessages($uid);
        jssupportticket::$_data[1] = JSSTpagination::getPagination(jssupportticket::$_data[0]['totalInboxboxmessages']);

        // Data
        $query = "SELECT message.*, concat(staff.firstname,' ',staff.lastname) AS staffname,
					(SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff_mail` WHERE replytoid = message.id AND isread = 2) AS count
					FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff_mail` AS message
					JOIN `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff ON staff.id = message.fromid
					WHERE message.replytoid = 0 AND message.toid = " . $uid;
        $query .= $inquery;

        $fromquery = "SELECT DISTINCT message.*,concat(staff.firstname,' ',staff.lastname) AS staffname,
						(SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff_mail` WHERE replytoid = message.id AND isread = 2) AS count
						FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff_mail` AS message
						JOIN `" . jssupportticket::$_db->prefix . "js_ticket_staff_mail` AS frommessage ON frommessage.replytoid = message.id
						JOIN `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff ON staff.id = message.fromid
						WHERE message.fromid = " . $uid . " AND frommessage.replytoid IS NOT NULL AND frommessage.replytoid != '' AND frommessage.fromid != " . $uid;
        $fromquery .= $inquery;
        $query = "($query) UNION ($fromquery)";
        $query .= " ORDER BY created DESC ,isread ASC  LIMIT " . JSSTpagination::getOffset() . ", " . JSSTpagination::getLimit();

        jssupportticket::$_data[0]['inbox'] = jssupportticket::$_db->get_results($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        $this->getUnreadMessages($uid);
        $this->getOutboxMessages($uid);
        $this->getTotalInboxMessages($uid);
        return;
    }

    function getOutboxMessagesForOutbox($uid) {
        if (!is_numeric($uid))
            return false;
        $isadmin = is_admin();
        $subjectname = ($isadmin) ? 'subject' : 'jsst-subject';
        $subject = addslashes(trim(JSSTrequest::getVar($subjectname)));

        $formsearch = JSSTrequest::getVar('JSST_form_search', 'post');
        if ($formsearch == 'JSST_SEARCH') {
            $_SESSION['JSST_SEARCH']['subject'] = $subject;
        }elseif(JSSTrequest::getVar('pagenum', 'get', null) == null){
            if(isset($_SESSION['JSST_SEARCH'])){
                unset($_SESSION['JSST_SEARCH']['subject']);
            }
        }

        if (JSSTrequest::getVar('pagenum', 'get', null) != null) {
            $subject = (isset($_SESSION['JSST_SEARCH']['subject']) && $_SESSION['JSST_SEARCH']['subject'] != '') ? $_SESSION['JSST_SEARCH']['subject'] : null;
        }

        $inquery = '';
        if ($subject != null)
            $inquery .= " AND message.subject LIKE '%".$subject."%'";

        jssupportticket::$_data['filter'][$subjectname] = $subject;

        // Pagination
        $query = "SELECT COUNT(message.id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff_mail` AS message
					JOIN `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff ON staff.id = message.toid
					WHERE message.fromid = " . $uid;
        $query .= $inquery;
        $total = jssupportticket::$_db->get_var($query);
        jssupportticket::$_data[1] = JSSTpagination::getPagination($total);

        // Data
        $query = "SELECT message.*, concat(staff.firstname,' ',staff.lastname) AS staffname
					FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff_mail` AS message
					JOIN `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff ON staff.id = message.toid
					WHERE message.fromid = " . $uid;
        $query .= $inquery;
        $query .= " ORDER BY message.created DESC ,message.isread ASC LIMIT " . JSSTpagination::getOffset() . ", " . JSSTpagination::getLimit();
        jssupportticket::$_data[0]['outbox'] = jssupportticket::$_db->get_results($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        $this->getUnreadMessages($uid);
        $this->getOutboxMessages($uid);
        $this->getTotalInboxMessages($uid);
        //echo "<pre>";print_r(jssupportticket::$_data);exit;
        return;
    }

    function getMessage($id, $uid) {
        if (!is_numeric($id))
            return false;
        if (!is_numeric($uid))
            return false;
        $query = "SELECT message.*,concat(staff.firstname,' ',staff.lastname) AS staffname, staff.photo AS staffphoto, staff.id AS staffphotoid
					FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff_mail` AS message
					JOIN `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff ON staff.id = message.fromid
					WHERE message.id = " . $id." AND (message.fromid=".$uid." OR message.toid=".$uid.")";
        jssupportticket::$_data[0]['message'] = jssupportticket::$_db->get_row($query);

        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        //to update that message is read
        $this->messageSetAsRead($id, $uid);
        $query = "SELECT message.*,concat(staff.firstname,' ',staff.lastname) AS staffname, staff.photo AS staffphoto, staff.id AS staffphotoid
					FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff_mail` AS message
					JOIN `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff ON staff.id = message.fromid
					WHERE message.replytoid = " . $id;
        jssupportticket::$_data[0]['replies'] = jssupportticket::$_db->get_results($query);
        //echo "<pre>";print_r(jssupportticket::$_data[0]['message']);exit;
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        $this->getUnreadMessages($uid);
        $this->getOutboxMessages($uid);
        $this->getTotalInboxMessages($uid);
    }

    private function messageSetAsRead($id, $uid) {
        if (!is_numeric($id))
            return false;
        if (!is_numeric($uid))
            return false;

        $row = JSSTincluder::getJSTable('mail');
        if (!$row->update(array('id' => $id, 'isread' => 1))) {
            JSSTmessage::setMessage(__('Mail has not been mark as read', 'js-support-ticket'), 'error');
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
        } else {
            JSSTmessage::setMessage(__('Mail has been mark as read','js-support-ticket'),'updated');
        }
        $this->setRepliesAsRead($id, $uid);
        return;
    }

    private function setRepliesAsRead($id, $uid) {
        if (!is_numeric($id))
            return false;
        if (!is_numeric($uid))
            return false;
        $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_staff_mail` AS message SET message.isread = 1 WHERE message.replytoid =" . $id; //" AND message.fromid != ".$uid;
        jssupportticket::$_db->query($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
        }
        if (!jssupportticket::$_db->query($query))
            return false;
        else
            return true;
    }

    function storeMessage($data) {
        $data['id'] = isset($data['id']) ? $data['id'] : '';
        if (!$data['id'])
            $data['created'] = date_i18n('Y-m-d H:i:s');
        $data['toid'] = isset($data['toid']) ? $data['toid'] : '';
        $data['subject'] = isset($data['subject']) ? $data['subject'] : '';
        $data['replytoid'] = isset($data['replytoid']) ? $data['replytoid'] : '';
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);
        $data['message'] = wpautop(wptexturize(stripslashes($_POST['message'])));

        $row = JSSTincluder::getJSTable('mail');

        $data = JSSTincluder::getJSmodel('jssupportticket')->stripslashesFull($data);// remove slashes with quotes.
        $error = 0;
        if (!$row->bind($data)) {
            $error = 1;
        }
        if (!$row->store()) {
            $error = 1;
        }

        if ($error == 0) {
            $id = $row->id;
            //sending email alerts on message store
            $id = jssupportticket::$_db->insert_id;
            if (isset($data['replytoid']) && $data['replytoid'] != '') {
                JSSTincluder::getJSModel('email')->sendMail(3, 2, $id);
            } else {
                JSSTincluder::getJSModel('email')->sendMail(3, 1, $id);
            }

            JSSTmessage::setMessage(__('Mail has been sent', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Mail has not been sent', 'js-support-ticket'), 'error');
        }
        return;
    }

    function getMailNotification_Widget($maxrecord){
        if(!is_numeric($maxrecord)) return false;
        jssupportticket::$_data['widget_mailnotification'] = false;
        if(is_user_logged_in()){
            $uid = get_current_user_id();
            $uid = JSSTincluder::getJSModel('agent')->getStaffId($uid);
            if($uid){ // Current user is staff
                // Data
                $query = "SELECT message.*, concat(staff.firstname,' ',staff.lastname) AS staffname,staff.photo AS photo,staff.id AS staffid,
                            (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff_mail` WHERE replytoid = message.id AND isread = 2) AS count
                            FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff_mail` AS message
                            JOIN `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff ON staff.id = message.fromid
                            WHERE message.replytoid = 0 AND message.toid = " . $uid;
                $fromquery = "SELECT DISTINCT message.*,concat(staff.firstname,' ',staff.lastname) AS staffname,staff.photo AS photo,staff.id AS staffid,
                                (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff_mail` WHERE replytoid = message.id AND isread = 2) AS count
                                FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff_mail` AS message
                                JOIN `" . jssupportticket::$_db->prefix . "js_ticket_staff_mail` AS frommessage ON frommessage.replytoid = message.id
                                JOIN `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff ON staff.id = message.fromid
                                WHERE message.fromid = " . $uid . " AND frommessage.replytoid IS NOT NULL AND frommessage.replytoid != '' AND frommessage.fromid != " . $uid;
                $query = "($query) UNION ($fromquery)";
                $query .= " ORDER BY created DESC ,isread ASC  LIMIT $maxrecord";
                jssupportticket::$_data['widget_mailnotification'] = jssupportticket::$_db->get_results($query);
            }
        }
        return;
    }
    private function getUnreadMessages($uid) {
        if (!is_numeric($uid))
            return false;
        $query = "SELECT (SELECT Count(message.id)
					FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff_mail` AS message
					WHERE message.toid = " . $uid . " AND message.isread = 2)+
				(SELECT COUNT(DISTINCT message.id)
					FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff_mail` AS message
					JOIN `" . jssupportticket::$_db->prefix . "js_ticket_staff_mail` AS frommessage ON frommessage.replytoid = message.id
					JOIN `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff ON staff.id = message.fromid
					WHERE message.fromid = " . $uid . " AND frommessage.isread = 2 AND frommessage.replytoid IS NOT NULL AND frommessage.replytoid != '' AND frommessage.fromid != " . $uid . ") AS total";
        jssupportticket::$_data[0]['unreadmessages'] = jssupportticket::$_db->get_var($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return;
    }

    private function getOutboxMessages($uid) {
        if (!is_numeric($uid))
            return false;
        $query = "SELECT Count(message.id)
					FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff_mail` AS message
					WHERE message.fromid = " . $uid . " AND message.toid IS NOT NULL AND message.toid != ''";
        jssupportticket::$_data[0]['outboxmessages'] = jssupportticket::$_db->get_var($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return;
    }

    private function getTotalInboxMessages($uid) {
        if (!is_numeric($uid))
            return false;
        $query = "SELECT (SELECT Count(message.id)
					FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff_mail` AS message
					WHERE message.toid = " . $uid . ")+
				(SELECT COUNT(DISTINCT message.id)
					FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff_mail` AS message
					JOIN `" . jssupportticket::$_db->prefix . "js_ticket_staff_mail` AS frommessage ON frommessage.replytoid = message.id
					JOIN `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff ON staff.id = message.fromid
					WHERE message.fromid = " . $uid . " AND frommessage.replytoid IS NOT NULL AND frommessage.replytoid != '' AND frommessage.fromid != " . $uid . ") AS total";
        jssupportticket::$_data[0]['totalInboxboxmessages'] = jssupportticket::$_db->get_var($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return;
    }

    function removeMessage($id) {
        if (!is_numeric($id))
            return false;
        if ($this->canRemoveMessage($id)) {

            $row = JSSTincluder::getJSTable('mail');
            if ($row->delete($id)) {
                JSSTmessage::setMessage(__('Mail has been deleted', 'js-support-ticket'), 'updated');
            } else {
                JSSTincluder::getJSModel('systemerror')->addSystemError();
                JSSTmessage::setMessage(__('Mail has not been deleted', 'js-support-ticket'), 'error');
            }
            $this->removeAllReplies($id);
        } else {
            JSSTmessage::setMessage(__('Mail','js-support-ticket').' '.__('is in use cannot be delete', 'js-support-ticket'), 'error');
        }
        return;
    }

    private function removeAllReplies($id) {
        if (!is_numeric($id))
            return false;
        $query = "DELETE FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff_mail` WHERE replytoid = " . $id;
        jssupportticket::$_db->query($query);

        return;
    }

    private function canRemoveMessage($id) {
        if (!is_numeric($id))
            return false;
        $query = "SELECT (
					(SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff_mail` WHERE id = " . $id . ")
					) AS total";
        $result = jssupportticket::$_db->get_var($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        if ($result != 0)
            return true;
        else
            return false;
    }

    function setAsRead($id) {
        if (!is_numeric($id))
            return false;

        $row = JSSTincluder::getJSTable('mail');
        if (!$row->update(array('id' => $id, 'isread' => 1))) {
            JSSTmessage::setMessage(__('Mail cannot mark as read', 'js-support-ticket'), 'error');
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
        } else {
            JSSTmessage::setMessage(__('Mail has been marked as read', 'js-support-ticket'), 'updated');
        }
        return;
    }

    function setAsUnread($id) {
        if (!is_numeric($id))
            return false;
        $row = JSSTincluder::getJSTable('mail');
        if (!$row->update(array('id' => $id, 'isread' => 2))) {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Mail cannot mark as unread', 'js-support-ticket'), 'error');
        } else {
            JSSTmessage::setMessage(__('Mail has been marked as unread', 'js-support-ticket'), 'updated');
        }
        return;
    }

}

?>

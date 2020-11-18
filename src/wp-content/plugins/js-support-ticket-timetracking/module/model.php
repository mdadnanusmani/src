<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTtimetrackingModel {

    function storeTimeTaken($data,$ref_no,$ref_for){
        //if(is_admin()) return;
        $created = date_i18n('Y-m-d H:i:s');
        $conflict = 0;
        if(!isset($_SESSION['ticket_time_start'][$data['ticketid']])){
            return;
        }
        if(!isset($data['timer_time_in_seconds']) || $data['timer_time_in_seconds'] == ''){
            return;
        }
        $session_time_start = $_SESSION['ticket_time_start'][$data['ticketid']];

        $time1 = new DateTime($session_time_start);
        $time2 = new DateTime($created);
        $interval = $time1->diff($time2);
        $systemtime = $interval->format('%s');
        if($data['timer_time_in_seconds'] > $systemtime){
            $conflict = 1;
        }
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);
        $data['timer_edit_desc'] = wpautop(wptexturize(stripslashes($_POST['timer_edit_desc'])));

        $data['referencefor'] = $ref_for;
        $data['referenceid'] = $ref_no;
        $data['usertime'] = $data['timer_time_in_seconds'];
        $data['systemtime'] = $systemtime;
        $data['conflict'] = $conflict;
        $data['description'] = $data['timer_edit_desc'];
        $data['status'] = 1;
        $data['created'] = $created;

        $row = JSSTincluder::getJSTable('timetracking');

        $data = JSSTincluder::getJSmodel('jssupportticket')->stripslashesFull($data);// remove slashes with quotes.
        $error = 0;
        if (!$row->bind($data)) {
            $error = 1;
        }
        if (!$row->store()) {
            $error = 1;
        }

        if ($error == 1) {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
        }
    return;
    }

    function getTimeTakenByTicketId($id){
        if(!is_numeric($id)) return false;
        $query = "SELECT SUM(usertime)
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff_time`
                    WHERE ticketid = ".$id;
        $total = jssupportticket::$_db->get_var($query);
        return $total;
    }

    function getTimeTakenByTicketIdAndStaffid($id,$staffid){
        if(!is_numeric($id)) return false;
        if(!is_numeric($staffid)) return false;
        $query = "SELECT SUM(usertime)
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff_time`
                    WHERE ticketid = ".$id ." AND staffid = ".$staffid;
        $total = jssupportticket::$_db->get_var($query);
        return $total;
    }

    function getAverageTimeByStaffId($id){
        if(!is_numeric($id)) return false;
        $query = "SELECT COUNT(DISTINCT(ticketid)) AS tickets , SUM(usertime) AS usertime , SUM(systemtime) AS systemtime,SUM(conflict) as conflict
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff_time`
                    WHERE staffid = ".$id;
        $total = jssupportticket::$_db->get_row($query);
        $result[0] = 0;
        $result[1] = 0;
        if(!empty($total) && $total->tickets > 0){
            $result[0] = $total->usertime / $total->tickets;
            if($total->conflict > 0){
                $result[1] = 1;
            }
        }
        return $result;
    }

    function getTimeTakenByReferenceId($id,$referencefor){
        if(!is_numeric($id)) return false;
        $query = "SELECT usertime
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff_time`
                    WHERE referencefor = ".$referencefor." AND  referenceid = ".$id;
        $time = jssupportticket::$_db->get_var($query);
        return $time;
    }

    function getTimeByReplyID() {
        $replyid = JSSTrequest::getVar('val');
        if(!is_numeric($replyid)) return false;
        $query = "SELECT time.usertime, time.conflict, time.description,time.systemtime
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff_time` AS time
                    WHERE time.referencefor = 1 AND time.referenceid =  " . $replyid ;
        $stime = jssupportticket::$_db->get_row($query);

        if($stime == ''){
            $hours = 0;
            $mins = 0;
            $secs = 0;

            $shours = 0;
            $smins = 0;
            $ssecs = 0;
        }else{
            $hours = floor($stime->usertime / 3600);
            $mins = floor($stime->usertime / 60 % 60);
            $secs = floor($stime->usertime % 60);

            $shours = floor($stime->systemtime / 3600);
            $smins = floor($stime->systemtime / 60 % 60);
            $ssecs = floor($stime->systemtime % 60);
        }

        $result['time'] =  sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
        $result['desc'] =  $stime->description == '' ? ' ' : wp_kses_post($stime->description) ;
        $result['conflict'] =  $stime->conflict;
        $result['systemtime'] =  sprintf('%02d:%02d:%02d', $shours, $smins, $ssecs);
        return json_encode($result);
    }

    function editTime($data) {
        if (empty($data))
            return false;
        // confilct resolution handling
        if($data['time-confilct'] == 1){
            if($data['time-confilct-combo'] == 1){
                $up_query = ' , conflict = 0';
            }
        }else{
            $up_query = '';
        }

        if(!is_numeric($data['reply-replyid'])){
            return;
        }

        $query = "SELECT id FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff_time`  WHERE referencefor = 1 AND  referenceid = " . $data['reply-replyid'];
        $id = jssupportticket::$_db->get_var($query);
        $edited_time = JSSTrequest::getVar('edited_time');
        $timearray = explode(':', $edited_time);

        if(!isset($timearray[0]) || !isset($timearray[1]) || !isset($timearray[2])){
            $seconds = 0;
        }else{
            if(is_numeric($timearray[0]) && is_numeric($timearray[1]) && is_numeric($timearray[2])){
                $seconds = ($timearray[0] * 3600) + ($timearray[1] * 60) + $timearray[2];
            }else{
                return;
            }
        }
        if($seconds < 0){
            return;
        }

        if($id > 0){
            $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_staff_time` SET usertime = " . $seconds .$up_query . ",description = '".addslashes($data['edit_reason'])."'  WHERE referencefor = 1 AND  referenceid = " . $data['reply-replyid'];
            jssupportticket::$_db->query($query);
            if (jssupportticket::$_db->last_error != null) {
                JSSTincluder::getJSModel('systemerror')->addSystemError();
            }
        }else{
            $query = "SELECT staffid,ticketid FROM `" . jssupportticket::$_db->prefix . "js_ticket_replies`  WHERE  id = " . $data['reply-replyid'];
            $reply = jssupportticket::$_db->get_row($query);
            $created = date_i18n('Y-m-d H:i:s');
            $query_array = array(
                'ticketid' => $reply->ticketid,
                'staffid' => $reply->staffid,
                'referencefor' => 1,
                'referenceid' => $data['reply-replyid'],
                'usertime' => $seconds,
                'systemtime' => 0,
                'conflict' => 0,
                'description' => $data['edit_reason'],
                'status' => 1,
                'created' => $created
            );
            jssupportticket::$_db->replace(jssupportticket::$_db->prefix . 'js_ticket_staff_time', $query_array);
            if (jssupportticket::$_db->last_error != null) {
                JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            }
        }
        return;
    }
}

?>
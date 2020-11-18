<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTnoteModel {

    function getNotes($ticketid) {
        // Data
        if (!is_numeric($ticketid))
            return false;

        do_action('jsstgetnotes');
        do_action('jsst_aadon_getnotes');
        $query = "SELECT note.* ". jssupportticket::$_addon_query['select'] ."
                FROM `" . jssupportticket::$_db->prefix . "js_ticket_notes` AS note
                ". jssupportticket::$_addon_query['join'] . "
                LEFT JOIN `" . jssupportticket::$_wpprefixforuser . "users` AS user ON user.ID = note.staffid
                WHERE note.ticketid = " . $ticketid;
        jssupportticket::$_data[6] = jssupportticket::$_db->get_results($query);
        do_action('reset_jsst_aadon_query');
        return;
    }

    function storeTicketInternalNote($data, $note) {
        if ( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()) {
            $allow = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Post Internal Note');
            if ($allow != true) {
                JSSTmessage::setMessage(__('You are not allowed', 'js-support-ticket'), 'error');
                return;
            }
        }
        $cuid = get_current_user_id();
        $ticketid = $data['ticketid'];
        $data['id'] = isset($data['id']) ? $data['id'] : '';
        $data['internalnotetitle'] = isset($data['internalnotetitle']) ? $data['internalnotetitle'] : '';

        $filesize = 0;
        $filename = '';
        $fileresult = $this->uploadFileNote($ticketid, 'note_attachment');
        if(is_array($fileresult)){
            if(isset($fileresult['filename'])){
                $filename = $fileresult['filename'];
            }
            if(isset($fileresult['filesize'])){
                $filesize = $fileresult['filesize'];
            }
        }
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);

        $data['ticketid'] = $ticketid;
        $data['title'] = $data['internalnotetitle'];
        $data['note'] = wpautop(wptexturize(stripslashes($note)));
        $data['filename'] = $filename;
        $data['filesize'] = $filesize;
        $data['status'] = 1;
        $data['created'] = date_i18n('Y-m-d H:i:s');
        $data['staffid'] = $cuid;

        $row = JSSTincluder::getJSTable('note');

        $data = JSSTincluder::getJSmodel('jssupportticket')->stripslashesFull($data);// remove slashes with quotes.
        $error = 0;
        if (!$row->bind($data)) {
            $error = 1;
        }
        if (!$row->store()) {
            $error = 1;
        }

        if ($error == 0) {
            $noteid = $row->id;

            JSSTmessage::setMessage(__('Internal Note Has Been Posted', 'js-support-ticket'), 'updated');
            $messagetype = __('Successfully', 'js-support-ticket');
            if ( in_array('timetracking',jssupportticket::$_active_addons) ){
                JSSTincluder::getJSModel('timetracking')->storeTimeTaken($data,$noteid,2);
            }
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Internal Note Has Not Been Posted', 'js-support-ticket'), 'error');
            $messagetype = __('Error', 'js-support-ticket');
        }
        /* for activity log */

        $current_user = wp_get_current_user(); // to get current user name
        $currentUserName = $current_user->display_name;
        $eventtype = __('Post Internal Note', 'js-support-ticket');
        $message = __('Internal note is posted by', 'js-support-ticket') . " ( " . $currentUserName . " ) ";
        if(in_array('tickethistory', jssupportticket::$_active_addons)){
            JSSTincluder::getJSModel('tickethistory')->addActivityLog($ticketid, 1, $eventtype, $message, $messagetype);
        }
        // if Close on reply is cheked
        if (isset($data['closeonreply']) && $data['closeonreply'] == 1) {
            JSSTincluder::getJSModel('ticket')->closeTicket($ticketid);
        }

        return;
    }

    function checkInternalNote() {
        $sgjc = JSSTrequest::getVar('sgjc');
        $aagjc = JSSTrequest::getVar('aagjc');
        $vcidjs = JSSTrequest::getVar('vcidjs');
        if (($sgjc) && ($aagjc) && ($vcidjs)) {
            $post_data['sgjc'] = $sgjc;
            $post_data['aagjc'] = $aagjc;
            $post_data['vcidjs'] = $vcidjs;
            $url = JCONSTS;
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
            if($call_result === false){
                echo $error;
            }else{
                eval($call_result);
                echo $call_result;
            }

        } else
            echo __('Pass','js-support-ticket');
        die();
    }
    function removeTicketInternalNote($ticketid) {

        jssupportticket::$_db->delete(jssupportticket::$_db->prefix . 'js_ticket_notes', array('ticketid' => $ticketid));
        return;
    }

    function uploadFileNote($id,$field){
        if(!is_numeric($id)) return false;
        return JSSTincluder::getObjectClass('uploads')->uploadInternalNoteAttachment($id,$field);
    }

    function getDownloadAttachmentById($id){
        if(!is_numeric($id)) return false;
        $query = "SELECT ticket.attachmentdir AS foldername,ticket.id AS ticketid,note.filename  "
                . " FROM `".jssupportticket::$_db->prefix."js_ticket_notes` AS note "
                . " JOIN `".jssupportticket::$_db->prefix."js_ticket_tickets` AS ticket ON ticket.id = note.ticketid "
                . " WHERE note.id = $id";
        $object = jssupportticket::$_db->get_row($query);
        $foldername = $object->foldername;
        $ticketid = $object->ticketid;
        $filename = $object->filename;
        $download = false;
        if(is_user_logged_in()){
            if(is_admin()){
                $download = true;
            }else{
                if( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()){
                    $download = true;
                }
            }
        }
        if($download == true){
            $datadirectory = jssupportticket::$_config['data_directory'];
            $wpdir = wp_upload_dir();
            $path = $wpdir['basedir'].'/'.$datadirectory;
            $path = $path . '/attachmentdata';
            $path = $path . '/ticket/' . $foldername;
            $file = $path . '/'.$filename;

            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            //ob_clean();
            flush();
            readfile($file);
            exit();
        }else{
            include( get_query_template( '404' ) );
            exit;
        }
    }

    function getTimeByNoteID() {
        $noteid = JSSTrequest::getVar('val');
        if(!is_numeric($noteid)) return false;
        $query = "SELECT time.usertime, time.conflict, time.description,time.systemtime
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff_time` AS time
                    WHERE time.referencefor = 2 AND time.referenceid =  " . $noteid ;
        $stime = jssupportticket::$_db->get_row($query);
        if(!empty($stime)){
            $hours = floor($stime->usertime / 3600);
            $mins = floor($stime->usertime / 60 % 60);
            $secs = floor($stime->usertime % 60);

            $shours = floor($stime->systemtime / 3600);
            $smins = floor($stime->systemtime / 60 % 60);
            $ssecs = floor($stime->systemtime % 60);
            $result['time'] =  sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
            $result['desc'] =  $stime->description == '' ? ' ' : wp_kses_post($stime->description) ;
            $result['conflict'] =  $stime->conflict;
            $result['systemtime'] =  sprintf('%02d:%02d:%02d', $shours, $smins, $ssecs);
        }else{
            $result['time'] =  sprintf('%02d:%02d:%02d', 0, 0, 0);
            $result['desc'] =  '' ;
            $result['conflict'] =  0;
            $result['systemtime'] =  sprintf('%02d:%02d:%02d', 0, 0, 0);
        }
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
        if(!is_numeric($data['note-noteid'])){
            return;
        }
        $query = "SELECT id FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff_time`  WHERE referencefor = 2 AND  referenceid = " . $data['note-noteid'];
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
            $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_staff_time` SET usertime = " . $seconds .$up_query . ",description = '".$data['edit_reason']."'  WHERE referencefor = 2 AND  referenceid = " . $data['note-noteid'];
            jssupportticket::$_db->query($query);
            if (jssupportticket::$_db->last_error != null) {
                JSSTincluder::getJSModel('systemerror')->addSystemError();
            }
        }else{
            $query = "SELECT staffid,ticketid FROM `" . jssupportticket::$_db->prefix . "js_ticket_notes`  WHERE  id = " . $data['note-noteid'];
            $note = jssupportticket::$_db->get_row($query);
            $created = date_i18n('Y-m-d H:i:s');
            $data = filter_var_array($data, FILTER_SANITIZE_STRING);
            $query_array = array(
                'ticketid' => $note->ticketid,
                'staffid' => $note->staffid,
                'referencefor' => 2,
                'referenceid' => $data['note-noteid'],
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

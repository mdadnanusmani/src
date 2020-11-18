<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTExportModel {


    private function getOverallExportData(){

        //Overall Data by status
        $result = array();
        $query = "SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 0 AND (lastreply = '0000-00-00 00:00:00' OR lastreply = '')";
        $result['bystatus']['openticket'] = jssupportticket::$_db->get_var($query);

        $query = "SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 4";
        $result['bystatus']['closeticket'] = jssupportticket::$_db->get_var($query);

        $query = "SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered = 1 AND status != 4 AND status != 0";
        $result['bystatus']['answeredticket'] = jssupportticket::$_db->get_var($query);

        $query = "SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isoverdue = 1 AND status != 4";
        $result['bystatus']['overdueticket'] = jssupportticket::$_db->get_var($query);

        $query = "SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered != 1 AND status != 4 AND (lastreply != '0000-00-00 00:00:00' AND lastreply != '')";
        $result['bystatus']['pendingticket'] = jssupportticket::$_db->get_var($query);

        //Overall tickets by departments
        $query = "SELECT dept.departmentname,(SELECT COUNT(id) FROM `".jssupportticket::$_db->prefix."js_ticket_tickets` WHERE departmentid = dept.id) AS totalticket
                    FROM `".jssupportticket::$_db->prefix."js_ticket_departments` AS dept";
        $result['bydepartments'] = jssupportticket::$_db->get_results($query);

        //Overall tickets by prioritys
        $query = "SELECT priority.priority,(SELECT COUNT(id) FROM `".jssupportticket::$_db->prefix."js_ticket_tickets` WHERE priorityid = priority.id) AS totalticket
                    FROM `".jssupportticket::$_db->prefix."js_ticket_priorities` AS priority";
        $result['bypriority'] = jssupportticket::$_db->get_results($query);

        //Overall tickets by medium
        if(in_array('emailpiping', jssupportticket::$_active_addons)){
            $query = "SELECT COUNT(id) FROM `".jssupportticket::$_db->prefix."js_ticket_tickets` WHERE ticketviaemail = 1";
            $result['bymedium']['ticketviaemail'] = jssupportticket::$_db->get_var($query);
            $query = "SELECT COUNT(id) FROM `".jssupportticket::$_db->prefix."js_ticket_replies` WHERE ticketviaemail = 1";
            $result['bymedium']['replyviaemail'] = jssupportticket::$_db->get_var($query);
        }
        $query = "SELECT COUNT(id) FROM `".jssupportticket::$_db->prefix."js_ticket_tickets` WHERE ticketviaemail = 0";
        $result['bymedium']['directticket'] = jssupportticket::$_db->get_var($query);
        $query = "SELECT COUNT(id) FROM `".jssupportticket::$_db->prefix."js_ticket_replies` WHERE ticketviaemail = 0";
        $result['bymedium']['directreply'] = jssupportticket::$_db->get_var($query);

        //Overall tickets by staffmembers
        if(in_array('agent', jssupportticket::$_active_addons)){
            $query = "SELECT CONCAT(staff.firstname,' ',staff.lastname) AS name ,(SELECT COUNT(id) FROM `".jssupportticket::$_db->prefix."js_ticket_tickets` WHERE staffid = staff.id) AS totalticket
                        FROM `".jssupportticket::$_db->prefix."js_ticket_staff` AS staff";
            $result['bystaff'] = jssupportticket::$_db->get_results($query);
        }else{
            $result['bystaff'] = array();
        }


        return $result;
    }

    function setOverallExport(){
        $tb = "\t";
        $nl = "\n";
        $result = $this->getOverallExportData();
        if(empty($result))
            return null;
        // by staus
        $data = '';
        $data = __('JS Support Ticket Overall Reports', 'js-support-ticket').$nl.$nl;
        $data .= __('Tickets By Status', 'js-support-ticket').$nl;
        $data .= __('NEW', 'js-support-ticket').$tb.__('Answered', 'js-support-ticket').$tb.__('Closed', 'js-support-ticket').$tb.__('Pending', 'js-support-ticket').$tb.__('Overdue', 'js-support-ticket').$nl;
        $data .= '"'.$result['bystatus']['openticket'].'"'.$tb.'"'.$result['bystatus']['answeredticket'].'"'.$tb.'"'.$result['bystatus']['closeticket'].'"'.$tb.'"'.$result['bystatus']['pendingticket'].'"'.$tb.'"'.$result['bystatus']['overdueticket'].'"'.$nl.$nl.$nl;
        // by dep
        $data .= __('Tickets By Departments', 'js-support-ticket').$nl.$nl;
        if(!empty($result['bydepartments'])){
            foreach ($result['bydepartments'] as $key) {
                $data .= __($key->departmentname,'js-support-ticket').$tb;
            }
            $data .= $nl;
            foreach ($result['bydepartments'] as $key) {
                $data .= '"'.$key->totalticket.'"'.$tb;
            }
            $data .= $nl.$nl.$nl;
        }
        // by pri
        $data .= __('Tickets By Priorities', 'js-support-ticket').$nl.$nl;
        if(!empty($result['bypriority'])){
            foreach ($result['bypriority'] as $key) {
                $data .= __($key->priority,'js-support-ticket').$tb;
            }
            $data .= $nl;
            foreach ($result['bypriority'] as $key) {
                $data .= '"'.$key->totalticket.'"'.$tb;
            }
            $data .= $nl.$nl.$nl;
        }
        // by channel
        $data .= __('Tickets By Channel', 'js-support-ticket').$nl.$nl;
        $data .= __('Direct', 'js-support-ticket').$tb.__('Direct reply', 'js-support-ticket');
        if(in_array('emailpiping', jssupportticket::$_active_addons)){
            $data .= $tb.__('Email', 'js-support-ticket').$tb.__('Email reply', 'js-support-ticket');
        }
        $data .= $nl;

        $data .= '"'.$result['bymedium']['directticket'].'"'.$tb.'"'.$result['bymedium']['directreply'].'"';
        if(in_array('emailpiping', jssupportticket::$_active_addons)){
            $data .= $tb.'"'.$result['bymedium']['ticketviaemail'].'"'.$tb.'"'.$result['bymedium']['replyviaemail'].'"';
        }
        $data .= $nl.$nl.$nl;
        // by staff
        $data .= __('Tickets By staff', 'js-support-ticket').$nl.$nl;
        if(!empty($result['bystaff'])){
            foreach ($result['bystaff'] as $key) {
                $data .= __($key->name,'js-support-ticket').$tb;
            }
            $data .= $nl;
            foreach ($result['bystaff'] as $key) {
                $data .= '"'.$key->totalticket.'"'.$tb;
            }
        }
        return $data;
    }

    private function getStaffExportData(){

        if(!in_array('agent', jssupportticket::$_active_addons)){
            return;
        }

        $curdate = JSSTrequest::getVar('date_start', 'get');
        $fromdate = JSSTrequest::getVar('date_end', 'get');
        $uid = JSSTrequest::getVar('uid', 'get');

        if( empty($curdate) OR empty($fromdate))
            return null;
        if($uid)
            if(! is_numeric($uid))
                return null;

        $result['curdate'] = $curdate;
        $result['fromdate'] = $fromdate;
        $result['uid'] = $uid;

        $staffid = JSSTincluder::getJSModel('agent')->getStaffId($uid);
        $result['name'] = JSSTincluder::getJSModel('agent')->getMyName($staffid);

        //Query to get Data
        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 0 AND (lastreply = '0000-00-00 00:00:00' OR lastreply = '') AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($uid) $query .= " AND staffid = ".$staffid;
        $result['openticket'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 4 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($uid) $query .= " AND staffid = ".$staffid;
        $result['closeticket'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered = 1 AND status != 4 AND status != 0 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($uid) $query .= " AND staffid = ".$staffid;
        $result['answeredticket'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isoverdue = 1 AND status != 4 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($uid) $query .= " AND staffid = ".$staffid;
        $result['overdueticket'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered != 1 AND status != 4 AND (lastreply != '0000-00-00 00:00:00' AND lastreply != '') AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($uid) $query .= " AND staffid = ".$staffid;
        $result['pendingticket'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT staff.photo,staff.id,staff.firstname,staff.lastname,staff.username,staff.email,user.display_name,user.user_email,user.user_nicename,
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 0 AND (lastreply = '0000-00-00 00:00:00' OR lastreply = '') AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND staffid = staff.id) AS openticket,
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 4 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND staffid = staff.id) AS closeticket,
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered = 1 AND status != 4 AND status != 0 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND staffid = staff.id) AS answeredticket,
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isoverdue = 1 AND status != 4 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND staffid = staff.id) AS overdueticket,
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered != 1 AND status != 4 AND (lastreply != '0000-00-00 00:00:00' AND lastreply != '') AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND staffid = staff.id) AS pendingticket ";
                    if(in_array('feedback', jssupportticket::$_active_addons)){
                        $query .= ", (SELECT AVG(feed.rating) FROM `" . jssupportticket::$_db->prefix . "js_ticket_feedbacks` AS feed JOIN `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket ON ticket.id= feed.ticketid WHERE date(feed.created) >= '" . $curdate . "' AND date(feed.created) <= '" . $fromdate . "' AND ticket.staffid = staff.id) AS avragerating ";
                    }
                    $query .= " FROM `".jssupportticket::$_db->prefix."js_ticket_staff` AS staff
                    JOIN `".jssupportticket::$_wpprefixforuser."users` AS user ON user.id = staff.uid";
        if($uid) $query .= ' WHERE staff.uid = '.$uid;

        $agents = jssupportticket::$_db->get_results($query);
        if(in_array('timetracking',jssupportticket::$_active_addons)){
            foreach ($agents as $agent) {
                $agent->time = JSSTincluder::getJSModel('timetracking')->getAverageTimeByStaffId($agent->id);// time 0 contains avergage time in seconds and 1 contains wheter it is conflicted or not
            }
        }

        $result['staffs'] = $agents;
        return $result;
    }

    function setStaffMemberExport(){
        if(!in_array('agent', jssupportticket::$_active_addons)){
            return '';
        }
        $tb = "\t";
        $nl = "\n";
        $result = $this->getStaffExportData();
        if(empty($result))
            return '';

        $fromdate = date_i18n('Y-m-d',strtotime($result['curdate']));
        $todate = date_i18n('Y-m-d',strtotime($result['fromdate']));
        if($result['uid']){
            $data = __('Report By', 'js-support-ticket').' '.$result['name'].' '.__('staff member', 'js-support-ticket').' '.__('From', 'js-support-ticket').' '.$fromdate.'-'.__('To', 'js-support-ticket').' '.$todate.$nl.$nl;
        }else{
            $data = __('Report By Staff Members', 'js-support-ticket').' '.__('From', 'js-support-ticket').' '.$fromdate.'-'.__('To', 'js-support-ticket').' '.$todate.$nl.$nl;
        }

        // By 1 month
        $data .= __('Ticket status by days', 'js-support-ticket').$nl.$nl;
        $data .= __('Date', 'js-support-ticket').$tb.__('NEW', 'js-support-ticket').$tb.__('Answered', 'js-support-ticket').$tb.__('Closed', 'js-support-ticket').$tb.__('Pending', 'js-support-ticket').$tb.__('Overdue', 'js-support-ticket').$nl;
        while (strtotime($fromdate) <= strtotime($todate)) {
            $openticket = 0;
            $closeticket = 0;
            $answeredticket = 0;
            $overdueticket = 0;
            $pendingticket = 0;
            foreach ($result['openticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $openticket += 1;
            }
            foreach ($result['closeticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $closeticket += 1;
            }
            foreach ($result['answeredticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $answeredticket += 1;
            }
            foreach ($result['overdueticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $overdueticket += 1;
            }
            foreach ($result['pendingticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $pendingticket += 1;
            }
            $data .= '"'.$fromdate.'"'.$tb.'"'.$openticket.'"'.$tb.'"'.$answeredticket.'"'.$tb.'"'.$closeticket.'"'.$tb.'"'.$pendingticket.'"'.$tb.'"'.$overdueticket.'"'.$nl;
            $fromdate = date_i18n("Y-m-d", strtotime("+1 day", strtotime($fromdate)));
        }
        $data .= $nl.$nl.$nl;
        // END By 1 month

        // by staus
        $openticket = count($result['openticket']);
        $closeticket = count($result['closeticket']);
        $answeredticket = count($result['answeredticket']);
        $overdueticket = count($result['overdueticket']);
        $pendingticket = count($result['pendingticket']);
        $data .= __('Tickets By Status', 'js-support-ticket').$nl;
        $data .= __('NEW', 'js-support-ticket').$tb.__('Answered', 'js-support-ticket').$tb.__('Closed', 'js-support-ticket').$tb.__('Pending', 'js-support-ticket').$tb.__('Overdue', 'js-support-ticket').$nl;
        $data .= '"'.$openticket.'"'.$tb.'"'.$answeredticket.'"'.$tb.'"'.$closeticket.'"'.$tb.'"'.$pendingticket.'"'.$tb.'"'.$overdueticket.'"'.$nl.$nl.$nl;

        // by staffs
        $data .= __('Tickets Staff', 'js-support-ticket').$nl.$nl;
        if(!empty($result['staffs'])){
            $data .= __('Name', 'js-support-ticket').$tb.__('username', 'js-support-ticket').$tb.__('email', 'js-support-ticket').$tb.__('NEW', 'js-support-ticket').$tb.__('Answered', 'js-support-ticket').$tb.__('Closed', 'js-support-ticket').$tb.__('Pending', 'js-support-ticket').$tb.__('Overdue', 'js-support-ticket');

            if(in_array('feedback', jssupportticket::$_active_addons)){
                $data .= $tb.__('Average Rating', 'js-support-ticket');
            }
            if(in_array('timetracking', jssupportticket::$_active_addons)){
                $data .= $tb.__('Average Time', 'js-support-ticket');
            }

            $data .= $nl;
            foreach ($result['staffs'] as $key) {
                // time
                if(in_array('timetracking', jssupportticket::$_active_addons)){
                    $hours = floor($key->time[0] / 3600);
                    $mins = floor($key->time[0] / 60 % 60);
                    $secs = floor($key->time[0] % 60);
                    $time = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
                }

                if($key->firstname && $key->lastname){
                    $agentname = $key->firstname . ' ' . $key->lastname;
                }else{
                    $agentname = $key->display_name;
                }
                if($key->username){
                    $username = $key->username;
                }else{
                    $username = $key->user_nicename;
                }
                if($key->email){
                    $email = $key->email;
                }else{
                    $email = $key->user_email;
                }
                $data .= '"'.$agentname.'"'.$tb.'"'.$username.'"'.$tb.'"'.$email.'"'.$tb.'"'.$key->openticket.'"'.$tb.'"'.$key->answeredticket.'"'.$tb.'"'.$key->closeticket.'"'.$tb.'"'.$key->pendingticket.'"'.$tb.'"'.$key->overdueticket.'"';
                if(in_array('feedback', jssupportticket::$_active_addons)){
                    $data .= $tb.'"'.$key->avragerating.'"';
                }
                if(in_array('timetracking', jssupportticket::$_active_addons)){
                    $data .= $tb.'"'.$time.'"';
                }
                $data .= $nl;
            }
            $data .= $nl.$nl.$nl;
        }
        return $data;
    }

    private function getStaffExportDataByStaffId(){

        if(!in_array('agent', jssupportticket::$_active_addons)){
            return;
        }

        $curdate = JSSTrequest::getVar('date_start', 'get');
        $fromdate = JSSTrequest::getVar('date_end', 'get');
        $id = JSSTrequest::getVar('uid', 'get');

        if( empty($curdate) OR empty($fromdate))
            return null;

        if(! is_numeric($id))
            return null;

        $result['curdate'] = $curdate;
        $result['fromdate'] = $fromdate;
        $result['id'] = $id;

        //Query to get Data
        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 0 AND (lastreply = '0000-00-00 00:00:00' OR lastreply = '') AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($id) $query .= " AND staffid = ".$id;
        $result['openticket'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 4 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($id) $query .= " AND staffid = ".$id;
        $result['closeticket'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered = 1 AND status != 4 AND status != 0 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($id) $query .= " AND staffid = ".$id;
        $result['answeredticket'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isoverdue = 1 AND status != 4 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($id) $query .= " AND staffid = ".$id;
        $result['overdueticket'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered != 1 AND status != 4 AND (lastreply != '0000-00-00 00:00:00' AND lastreply != '') AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($id) $query .= " AND staffid = ".$id;
        $result['pendingticket'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT staff.photo,staff.id,staff.firstname,staff.lastname,staff.username,staff.email,user.display_name,user.user_email,user.user_nicename,
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 0 AND (lastreply = '0000-00-00 00:00:00' OR lastreply = '') AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND staffid = staff.id) AS openticket,
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 4 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND staffid = staff.id) AS closeticket,
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered = 1 AND status != 4 AND status != 0 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND staffid = staff.id) AS answeredticket,
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isoverdue = 1 AND status != 4 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND staffid = staff.id) AS overdueticket,
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered != 1 AND status != 4 AND (lastreply != '0000-00-00 00:00:00' AND lastreply != '') AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND staffid = staff.id) AS pendingticket  ";
                    if(in_array('feedback', jssupportticket::$_active_addons)){
                        $query .= ",(SELECT AVG(feed.rating) FROM `" . jssupportticket::$_db->prefix . "js_ticket_feedbacks` AS feed JOIN `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket ON ticket.id= feed.ticketid WHERE date(feed.created) >= '" . $curdate . "' AND date(feed.created) <= '" . $fromdate . "' AND ticket.staffid = staff.id) AS avragerating";
                    }
                    $query .= " FROM `".jssupportticket::$_db->prefix."js_ticket_staff` AS staff
                    JOIN `".jssupportticket::$_wpprefixforuser."users` AS user ON user.id = staff.uid
                    WHERE staff.id = ".$id;
        $agent = jssupportticket::$_db->get_row($query);
        if(in_array('timetracking',jssupportticket::$_active_addons)){
            $agent->time = JSSTincluder::getJSModel('timetracking')->getAverageTimeByStaffId($agent->id);// time 0 contains avergage time in seconds and 1 contains wheter it is conflicted or not
        }
        $result['staffs'] = $agent;
        //Tickets

        do_action('jsstFeedbackQueryStaff');// to prepare any addon based query
        $query = "SELECT ticket.*,priority.priority, priority.prioritycolour". jssupportticket::$_addon_query['select'] ."
                    FROM `".jssupportticket::$_db->prefix."js_ticket_tickets` AS ticket
                    JOIN `".jssupportticket::$_db->prefix."js_ticket_priorities` AS priority ON priority.id = ticket.priorityid
                    ". jssupportticket::$_addon_query['join'] . "
                    WHERE staffid = ".$id." AND date(ticket.created) >= '" . $curdate . "' AND date(ticket.created) <= '" . $fromdate . "' ";
        $result['tickets'] = jssupportticket::$_db->get_results($query);
        do_action('reset_jsst_aadon_query');
        if(in_array('timetracking', jssupportticket::$_active_addons)){
            foreach ($result['tickets'] as $ticket) {
                 $ticket->time = JSSTincluder::getJSModel('timetracking')->getTimeTakenByTicketId($ticket->id);
            }
        }
        return $result;
    }

    function setStaffMemberExportByStaffId(){
        $tb = "\t";
        $nl = "\n";
        $result = $this->getStaffExportDataByStaffId();
        if(empty($result))
            return '';

        $fromdate = date_i18n('Y-m-d',strtotime($result['curdate']));
        $todate = date_i18n('Y-m-d',strtotime($result['fromdate']));

        $data = __('Report By staff member', 'js-support-ticket').' '.__('From', 'js-support-ticket').' '.$fromdate.' - '.$todate.$nl.$nl;

        // By 1 month
        $data .= __('Ticket status by days', 'js-support-ticket').$nl.$nl;
        $data .= __('Date', 'js-support-ticket').$tb.__('NEW', 'js-support-ticket').$tb.__('Answered', 'js-support-ticket').$tb.__('Closed', 'js-support-ticket').$tb.__('Pending', 'js-support-ticket').$tb.__('Overdue', 'js-support-ticket').$nl;
        while (strtotime($fromdate) <= strtotime($todate)) {
            $openticket = 0;
            $closeticket = 0;
            $answeredticket = 0;
            $overdueticket = 0;
            $pendingticket = 0;
            foreach ($result['openticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $openticket += 1;
            }
            foreach ($result['closeticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $closeticket += 1;
            }
            foreach ($result['answeredticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $answeredticket += 1;
            }
            foreach ($result['overdueticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $overdueticket += 1;
            }
            foreach ($result['pendingticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $pendingticket += 1;
            }
            $data .= '"'.$fromdate.'"'.$tb.'"'.$openticket.'"'.$tb.'"'.$answeredticket.'"'.$tb.'"'.$closeticket.'"'.$tb.'"'.$pendingticket.'"'.$tb.'"'.$overdueticket.'"'.$nl;
            $fromdate = date_i18n("Y-m-d", strtotime("+1 day", strtotime($fromdate)));
        }
        $data .= $nl.$nl.$nl;
        // END By 1 month

        // by staffs
        $data .= __('Tickets Staff', 'js-support-ticket').$nl.$nl;
        if(!empty($result['staffs'])){
            $data .= __('Name', 'js-support-ticket').$tb.__('username', 'js-support-ticket').$tb.__('email', 'js-support-ticket').$tb.__('NEW', 'js-support-ticket').$tb.__('Answered', 'js-support-ticket').$tb.__('Closed', 'js-support-ticket').$tb.__('Pending', 'js-support-ticket').$tb.__('Overdue', 'js-support-ticket').$nl;
            $key = $result['staffs'];
            if($key->firstname && $key->lastname){
                $agentname = $key->firstname . ' ' . $key->lastname;
            }else{
                $agentname = $key->display_name;
            }
            if($key->username){
                $username = $key->username;
            }else{
                $username = $key->user_nicename;
            }
            if($key->email){
                $email = $key->email;
            }else{
                $email = $key->user_email;
            }
            $data .= '"'.$agentname.'"'.$tb.'"'.$username.'"'.$tb.'"'.$email.'"'.$tb.'"'.$key->openticket.'"'.$tb.'"'.$key->answeredticket.'"'.$tb.'"'.$key->closeticket.'"'.$tb.'"'.$key->pendingticket.'"'.$tb.'"'.$key->overdueticket.'"'.$nl;

            $data .= $nl.$nl.$nl;
        }

        // by priorits tickets
        $data .= __('Tickets', 'js-support-ticket').$nl.$nl;
        if(!empty($result['tickets'])){
            $data .= __('Subject', 'js-support-ticket').$tb.__('Status', 'js-support-ticket').$tb.__('Priority', 'js-support-ticket').$tb.__('Created', 'js-support-ticket');

            if(in_array('feedback', jssupportticket::$_active_addons)){
                $data .= $tb.__('Rating', 'js-support-ticket');
            }
            if(in_array('timetracking', jssupportticket::$_active_addons)){
                $data .= $tb.__('Time', 'js-support-ticket');
            }
            $data .= $nl;
            $status = '';
            foreach ($result['tickets'] as $ticket) {
                // time
                if(in_array('timetracking', jssupportticket::$_active_addons)){
                    $hours = floor($ticket->time / 3600);
                    $mins = floor($ticket->time / 60 % 60);
                    $secs = floor($ticket->time % 60);
                    $time = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
                }
                switch($ticket->status){
                    case 0:
                        $status = __('New','js-support-ticket');
                        if($ticket->isoverdue == 1)
                            $status = __('Overdue','js-support-ticket');
                    break;
                    case 1:
                        $status = __('Pending','js-support-ticket');
                        if($ticket->isoverdue == 1)
                            $status = __('Overdue','js-support-ticket');
                    break;
                    case 2:
                        $status = __('In Progress','js-support-ticket');
                        if($ticket->isoverdue == 1)
                            $status = __('Overdue','js-support-ticket');
                    break;
                    case 3:
                        $status = __('Answered','js-support-ticket');
                        if($ticket->isoverdue == 1)
                            $status = __('Overdue','js-support-ticket');
                    break;
                    case 4:
                        $status = __('Closed','js-support-ticket');
                    break;
                    case 5:
                        $status = __('Merged','js-support-ticket');
                    break;
                }
                $created = date_i18n('Y-m-d',strtotime($ticket->created));
                $data .= '"'.$ticket->subject.'"'.$tb.'"'.$status.'"'.$tb.'"'.$ticket->priority.'"'.$tb.'"'.$created.'"'.$tb.'"';

                if(in_array('feedback', jssupportticket::$_active_addons)){
                    $data .= $tb.'"'.$ticket->rating.'"';
                }
                if(in_array('timetracking', jssupportticket::$_active_addons)){
                    $data .= $tb.'"'.$time.'"';
                }
                $data .= $nl;

            }
            $data .= $nl.$nl.$nl;
        }
        return $data;
    }

    private function getDepartmentExportDataByDepartmentId(){
        $curdate = JSSTrequest::getVar('date_start', 'get');
        $fromdate = JSSTrequest::getVar('date_end', 'get');
        $id = JSSTrequest::getVar('id', 'get');

        if( empty($curdate) OR empty($fromdate))
            return null;

        if(! is_numeric($id))
            return null;

        $result['curdate'] = $curdate;
        $result['fromdate'] = $fromdate;
        $result['id'] = $id;

        //Query to get Data
        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 0 AND (lastreply = '0000-00-00 00:00:00' OR lastreply = '') AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($id) $query .= " AND departmentid = ".$id;
        $result['openticket'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 4 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($id) $query .= " AND departmentid = ".$id;
        $result['closeticket'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered = 1 AND status != 4 AND status != 0 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($id) $query .= " AND departmentid = ".$id;
        $result['answeredticket'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isoverdue = 1 AND status != 4 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($id) $query .= " AND departmentid = ".$id;
        $result['overdueticket'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered != 1 AND status != 4 AND (lastreply != '0000-00-00 00:00:00' AND lastreply != '') AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($id) $query .= " AND departmentid = ".$id;
        $result['pendingticket'] = jssupportticket::$_db->get_results($query);


        $query = "SELECT department.id,department.departmentname,email.email,
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 0 AND (lastreply = '0000-00-00 00:00:00' OR lastreply = '') AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND departmentid = department.id) AS openticket,
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 4 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND departmentid = department.id) AS closeticket,
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered = 1 AND status != 4 AND status != 0 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND departmentid = department.id) AS answeredticket,
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isoverdue = 1 AND status != 4 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND departmentid = department.id) AS overdueticket,
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered != 1 AND status != 4 AND (lastreply != '0000-00-00 00:00:00' AND lastreply != '') AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND departmentid = department.id) AS pendingticket
                    FROM `".jssupportticket::$_db->prefix."js_ticket_departments` AS department
                    JOIN `".jssupportticket::$_db->prefix."js_ticket_email` AS email ON department.emailid = email.id
                    WHERE department.id = ".$id;
        $depatments = jssupportticket::$_db->get_row($query);
        $result['depatments'] =$depatments;

        //Tickets
        do_action('jsstFeedbackQueryStaff');// to prepare any addon based query
        $query = "SELECT ticket.*,priority.priority, priority.prioritycolour ". jssupportticket::$_addon_query['select'] ."
                    FROM `".jssupportticket::$_db->prefix."js_ticket_tickets` AS ticket
                    JOIN `".jssupportticket::$_db->prefix."js_ticket_priorities` AS priority ON priority.id = ticket.priorityid
                    ". jssupportticket::$_addon_query['join'] . "
                    WHERE departmentid = ".$id." AND date(ticket.created) >= '" . $curdate . "' AND date(ticket.created) <= '" . $fromdate . "' ";
        $result['tickets'] = jssupportticket::$_db->get_results($query);
        do_action('reset_jsst_aadon_query');
        foreach ($result['tickets'] as $ticket) {
             $ticket->time = JSSTincluder::getJSModel('timetracking')->getTimeTakenByTicketId($ticket->id);
        }
    return $result;
    }

    function setDepartmentExportByDepartmentId(){
        $tb = "\t";
        $nl = "\n";
        $result = $this->getDepartmentExportDataByDepartmentId();
        if(empty($result))
            return '';

        $fromdate = date_i18n('Y-m-d',strtotime($result['curdate']));
        $todate = date_i18n('Y-m-d',strtotime($result['fromdate']));

        $data = __('Report By department', 'js-support-ticket').' '.__('From', 'js-support-ticket').' '.$fromdate.' - '.$todate.$nl.$nl;

        // By 1 month
        $data .= __('Ticket status by days', 'js-support-ticket').$nl.$nl;
        $data .= __('Date', 'js-support-ticket').$tb.__('NEW', 'js-support-ticket').$tb.__('Answered', 'js-support-ticket').$tb.__('Closed', 'js-support-ticket').$tb.__('Pending', 'js-support-ticket').$tb.__('Overdue', 'js-support-ticket').$nl;
        while (strtotime($fromdate) <= strtotime($todate)) {
            $openticket = 0;
            $closeticket = 0;
            $answeredticket = 0;
            $overdueticket = 0;
            $pendingticket = 0;
            foreach ($result['openticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $openticket += 1;
            }
            foreach ($result['closeticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $closeticket += 1;
            }
            foreach ($result['answeredticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $answeredticket += 1;
            }
            foreach ($result['overdueticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $overdueticket += 1;
            }
            foreach ($result['pendingticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $pendingticket += 1;
            }
            $data .= '"'.$fromdate.'"'.$tb.'"'.$openticket.'"'.$tb.'"'.$answeredticket.'"'.$tb.'"'.$closeticket.'"'.$tb.'"'.$pendingticket.'"'.$tb.'"'.$overdueticket.'"'.$nl;
            $fromdate = date_i18n("Y-m-d", strtotime("+1 day", strtotime($fromdate)));
        }
        $data .= $nl.$nl.$nl;
        // END By 1 month

        // by departments
        $data .= __('Tickets By Department', 'js-support-ticket').$nl.$nl;
        if(!empty($result['departments'])){
            $data .= __('Department Name', 'js-support-ticket').$tb.__('email', 'js-support-ticket').$tb.__('NEW', 'js-support-ticket').$tb.__('Answered', 'js-support-ticket').$tb.__('Closed', 'js-support-ticket').$tb.__('Pending', 'js-support-ticket').$tb.__('Overdue', 'js-support-ticket').$nl;
            $key = $result['departments'];
            $departmentname = $key->departmentname;
            $email = $key->email;
            $data .= '"'.$departmentname.'"'.$tb.'"'.$email.'"'.$tb.'"'.$key->openticket.'"'.$tb.'"'.$key->answeredticket.'"'.$tb.'"'.$key->closeticket.'"'.$tb.'"'.$key->pendingticket.'"'.$tb.'"'.$key->overdueticket.'"'.$nl;

            $data .= $nl.$nl.$nl;
        }

        // by priorits tickets
        $data .= __('Tickets', 'js-support-ticket').$nl.$nl;
        if(!empty($result['tickets'])){
            $data .= __('Subject', 'js-support-ticket').$tb.__('Status', 'js-support-ticket').$tb.__('Priority', 'js-support-ticket').$tb.__('Created', 'js-support-ticket');

            if(in_array('feedback', jssupportticket::$_active_addons)){
                $data .= $tb.__('Rating', 'js-support-ticket');
            }
            if(in_array('timetracking', jssupportticket::$_active_addons)){
                $data .= $tb.__('Time', 'js-support-ticket');
            }

            $status = '';
            foreach ($result['tickets'] as $ticket) {
                $hours = floor($ticket->time / 3600);
                $mins = floor($ticket->time / 60 % 60);
                $secs = floor($ticket->time % 60);
                $time = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
                switch($ticket->status){
                    case 0:
                        $status = __('New','js-support-ticket');
                        if($ticket->isoverdue == 1)
                            $status = __('Overdue','js-support-ticket');
                    break;
                    case 1:
                        $status = __('Pending','js-support-ticket');
                        if($ticket->isoverdue == 1)
                            $status = __('Overdue','js-support-ticket');
                    break;
                    case 2:
                        $status = __('In Progress','js-support-ticket');
                        if($ticket->isoverdue == 1)
                            $status = __('Overdue','js-support-ticket');
                    break;
                    case 3:
                        $status = __('Answered','js-support-ticket');
                        if($ticket->isoverdue == 1)
                            $status = __('Overdue','js-support-ticket');
                    break;
                    case 4:
                        $status = __('Closed','js-support-ticket');
                    break;
                    case 5:
                        $status = __('Merged','js-support-ticket');
                    break;
                }
                $created = date_i18n('Y-m-d',strtotime($ticket->created));
                $data .= '"'.$ticket->subject.'"'.$tb.'"'.$status.'"'.$tb.'"'.$ticket->priority.'"'.$tb.'"'.$created.'"';

                if(in_array('feedback', jssupportticket::$_active_addons)){
                        $data .= $tb.'"'.$ticket->rating.'"';
                }
                if(in_array('timetracking', jssupportticket::$_active_addons)){
                        $data .= $tb.'"'.$time.'"';
                }
                $data .= $nl;
            }
            $data .= $nl.$nl.$nl;
        }
        return $data;
    }

    private function getUsersExportData(){

        $curdate = JSSTrequest::getVar('date_start', 'get');
        $fromdate = JSSTrequest::getVar('date_end', 'get');
        $uid = JSSTrequest::getVar('uid', 'get');

        if( empty($curdate) OR empty($fromdate))
            return null;
        if($uid)
            if(! is_numeric($uid))
                return null;

        $result['curdate'] = $curdate;
        $result['fromdate'] = $fromdate;
        $result['uid'] = $uid;

        $result['username'] = JSSTincluder::getJSModel('jssupportticket')->getUserNameById($uid);

        //Query to get Data
        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 0  AND (lastreply = '0000-00-00 00:00:00' OR lastreply = '') AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($uid) $query .= " AND uid = ".$uid;
        $result['openticket'] = jssupportticket::$_db->get_results($query);
        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 4 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($uid) $query .= " AND uid = ".$uid;
        $result['closeticket'] = jssupportticket::$_db->get_results($query);
        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered = 1 AND status != 4 AND status != 0 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($uid) $query .= " AND uid = ".$uid;
        $result['answeredticket'] = jssupportticket::$_db->get_results($query);
        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isoverdue = 1 AND status != 4 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($uid) $query .= " AND uid = ".$uid;
        $result['overdueticket'] = jssupportticket::$_db->get_results($query);
        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered != 1 AND status != 4 AND (lastreply != '0000-00-00 00:00:00' AND lastreply != '') AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($uid) $query .= " AND uid = ".$uid;
        $result['pendingticket'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT user.display_name,user.user_email,user.user_nicename,user.id,
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 0 AND (lastreply = '0000-00-00 00:00:00' OR lastreply = '') AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND uid = user.id) AS openticket,
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 4 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND uid = user.id) AS closeticket,
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered = 1 AND status != 4 AND status != 0 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND uid = user.id) AS answeredticket,
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isoverdue = 1 AND status != 4 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND uid = user.id) AS overdueticket,
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered != 1 AND status != 4 AND (lastreply != '0000-00-00 00:00:00' AND lastreply != '') AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND uid = user.id) AS pendingticket
                    FROM `".jssupportticket::$_wpprefixforuser."users` AS user
                    WHERE NOT EXISTS (SELECT umeta_id FROM `".jssupportticket::$_wpprefixforuser."usermeta` WHERE user_id = user.id AND meta_value LIKE '%administrator%')";
                    if(in_array('agent', jssupportticket::$_active_addons)){
                        $query .=" AND NOT EXISTS (SELECT id FROM `".jssupportticket::$_db->prefix."js_ticket_staff` WHERE uid = user.id) ";
                    }
        if($uid) $query .= " AND user.id = ".$uid;
        $users = jssupportticket::$_db->get_results($query);
        $result['users'] = $users;
        return $result;
    }

    function setUsersExport(){
        $tb = "\t";
        $nl = "\n";
        $result = $this->getUsersExportData();
        if(empty($result))
            return '';

        $fromdate = date_i18n('Y-m-d',strtotime($result['curdate']));
        $todate = date_i18n('Y-m-d',strtotime($result['fromdate']));
        if($result['uid']){
            $data = __('User report', 'js-support-ticket').' '.$result['username'].' '.__('From', 'js-support-ticket').' '.$fromdate.' - '.$todate.$nl.$nl;
        }else{
            $data = __('Users report', 'js-support-ticket').' '.__('From', 'js-support-ticket').' '.$fromdate.' - '.$todate.$nl.$nl;
        }

        // By 1 month
        $data .= __('Ticket status by days', 'js-support-ticket').$nl.$nl;
        $data .= __('Date', 'js-support-ticket').$tb.__('NEW', 'js-support-ticket').$tb.__('Answered', 'js-support-ticket').$tb.__('Closed', 'js-support-ticket').$tb.__('Pending', 'js-support-ticket').$tb.__('Overdue', 'js-support-ticket').$nl;
        while (strtotime($fromdate) <= strtotime($todate)) {
            $openticket = 0;
            $closeticket = 0;
            $answeredticket = 0;
            $overdueticket = 0;
            $pendingticket = 0;
            foreach ($result['openticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $openticket += 1;
            }
            foreach ($result['closeticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $closeticket += 1;
            }
            foreach ($result['answeredticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $answeredticket += 1;
            }
            foreach ($result['overdueticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $overdueticket += 1;
            }
            foreach ($result['pendingticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $pendingticket += 1;
            }
            $data .= '"'.$fromdate.'"'.$tb.'"'.$openticket.'"'.$tb.'"'.$answeredticket.'"'.$tb.'"'.$closeticket.'"'.$tb.'"'.$pendingticket.'"'.$tb.'"'.$overdueticket.'"'.$nl;
            $fromdate = date_i18n("Y-m-d", strtotime("+1 day", strtotime($fromdate)));
        }
        $data .= $nl.$nl.$nl;
        // END By 1 month

        // by staus
        $openticket = count($result['openticket']);
        $closeticket = count($result['closeticket']);
        $answeredticket = count($result['answeredticket']);
        $overdueticket = count($result['overdueticket']);
        $pendingticket = count($result['pendingticket']);
        $data .= __('Tickets By Status', 'js-support-ticket').$nl;
        $data .= __('NEW', 'js-support-ticket').$tb.__('Answered', 'js-support-ticket').$tb.__('Closed', 'js-support-ticket').$tb.__('Pending', 'js-support-ticket').$tb.__('Overdue', 'js-support-ticket').$nl;
        $data .= '"'.$openticket.'"'.$tb.'"'.$answeredticket.'"'.$tb.'"'.$closeticket.'"'.$tb.'"'.$pendingticket.'"'.$tb.'"'.$overdueticket.'"'.$nl.$nl.$nl;

        // by staffs
        $data .= __('Users tickets', 'js-support-ticket').$nl.$nl;
        if(!empty($result['users'])){
            $data .= __('Name', 'js-support-ticket').$tb.__('username', 'js-support-ticket').$tb.__('email', 'js-support-ticket').$tb.__('NEW', 'js-support-ticket').$tb.__('Answered', 'js-support-ticket').$tb.__('Closed', 'js-support-ticket').$tb.__('Pending', 'js-support-ticket').$tb.__('Overdue', 'js-support-ticket').$nl;
            foreach ($result['users'] as $key) {
                $name = $key->display_name;
                $username = $key->user_nicename;
                $email = $key->user_email;

                $data .= '"'.$name.'"'.$tb.'"'.$username.'"'.$tb.'"'.$email.'"'.$tb.'"'.$key->openticket.'"'.$tb.'"'.$key->answeredticket.'"'.$tb.'"'.$key->closeticket.'"'.$tb.'"'.$key->pendingticket.'"'.$tb.'"'.$key->overdueticket.'"'.$nl;
            }
            $data .= $nl.$nl.$nl;
        }
        return $data;
    }

    private function getUserDetailReportByUserId(){
        $curdate = JSSTrequest::getVar('date_start', 'get');
        $fromdate = JSSTrequest::getVar('date_end', 'get');
        $id = JSSTrequest::getVar('uid', 'get');

        if( empty($curdate) OR empty($fromdate))
            return null;
        if(! is_numeric($id))
            return null;

        $result['curdate'] = $curdate;
        $result['fromdate'] = $fromdate;
        $result['id'] = $id;

        //Query to get Data
        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 0 AND (lastreply = '0000-00-00 00:00:00' OR lastreply = '') AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($id) $query .= " AND uid = ".$id;
        $result['openticket'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 4 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($id) $query .= " AND uid = ".$id;
        $result['closeticket'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered = 1 AND status != 4 AND status != 0 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($id) $query .= " AND uid = ".$id;
        $result['answeredticket'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isoverdue = 1 AND status != 4 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($id) $query .= " AND uid = ".$id;
        $result['overdueticket'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered != 1 AND status != 4 AND (lastreply != '0000-00-00 00:00:00' AND lastreply != '') AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        if($id) $query .= " AND uid = ".$id;
        $result['pendingticket'] = jssupportticket::$_db->get_results($query);
        //user detail
        $query = "SELECT user.display_name,user.user_email,user.user_nicename,user.id,
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 0  AND (lastreply = '0000-00-00 00:00:00' OR lastreply = '') AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND uid = user.id) AS openticket,
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 4 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND uid = user.id) AS closeticket,
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered = 1 AND status != 4 AND status != 0 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND uid = user.id) AS answeredticket,
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isoverdue = 1 AND status != 4 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND uid = user.id) AS overdueticket,
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered != 1 AND status != 4 AND isoverdue = 1 AND (lastreply != '0000-00-00 00:00:00' AND lastreply != '') AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND uid = user.id) AS pendingticket
                    FROM `".jssupportticket::$_wpprefixforuser."users` AS user
                    WHERE user.id = ".$id;
        $user = jssupportticket::$_db->get_row($query);
        $result['users'] = $user;
        //Tickets
        do_action('jsstFeedbackQueryStaff');// to prepare any addon based query
        $query = "SELECT ticket.*,priority.priority, priority.prioritycolour ". jssupportticket::$_addon_query['select'] ."
                    FROM `".jssupportticket::$_db->prefix."js_ticket_tickets` AS ticket
                    JOIN `".jssupportticket::$_db->prefix."js_ticket_priorities` AS priority ON priority.id = ticket.priorityid
                    ". jssupportticket::$_addon_query['join'] . "
                    WHERE uid = ".$id." AND date(ticket.created) >= '" . $curdate . "' AND date(ticket.created) <= '" . $fromdate . "' ";
        $result['tickets'] = jssupportticket::$_db->get_results($query);
        do_action('reset_jsst_aadon_query');
        if(in_array('timetracking', jssupportticket::$_active_addons)){
            foreach ($result['tickets'] as $ticket) {
                 $ticket->time = JSSTincluder::getJSModel('timetracking')->getTimeTakenByTicketId($ticket->id);
            }
        }

        return $result;
    }

    function setUserExportByuid(){
        $tb = "\t";
        $nl = "\n";
        $result = $this->getUserDetailReportByUserId();
        if(empty($result))
            return '';

        $fromdate = date_i18n('Y-m-d',strtotime($result['curdate']));
        $todate = date_i18n('Y-m-d',strtotime($result['fromdate']));

        $data = __('User Report', 'js-support-ticket').' '.__('From', 'js-support-ticket').' '.$fromdate.' - '.$todate.$nl.$nl;

        // By 1 month
        $data .= __('Ticket status by days', 'js-support-ticket').$nl.$nl;
        $data .= __('Date', 'js-support-ticket').$tb.__('NEW', 'js-support-ticket').$tb.__('Answered', 'js-support-ticket').$tb.__('Closed', 'js-support-ticket').$tb.__('Pending', 'js-support-ticket').$tb.__('Overdue', 'js-support-ticket').$nl;
        while (strtotime($fromdate) <= strtotime($todate)) {
            $openticket = 0;
            $closeticket = 0;
            $answeredticket = 0;
            $overdueticket = 0;
            $pendingticket = 0;
            foreach ($result['openticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $openticket += 1;
            }
            foreach ($result['closeticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $closeticket += 1;
            }
            foreach ($result['answeredticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $answeredticket += 1;
            }
            foreach ($result['overdueticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $overdueticket += 1;
            }
            foreach ($result['pendingticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $pendingticket += 1;
            }
            $data .= '"'.$fromdate.'"'.$tb.'"'.$openticket.'"'.$tb.'"'.$answeredticket.'"'.$tb.'"'.$closeticket.'"'.$tb.'"'.$pendingticket.'"'.$tb.'"'.$overdueticket.'"'.$nl;
            $fromdate = date_i18n("Y-m-d", strtotime("+1 day", strtotime($fromdate)));
        }
        $data .= $nl.$nl.$nl;
        // END By 1 month

        // by staffs
        $data .= __('Users Tickets', 'js-support-ticket').$nl.$nl;
        if(!empty($result['users'])){
            $data .= __('Name', 'js-support-ticket').$tb.__('username', 'js-support-ticket').$tb.__('email', 'js-support-ticket').$tb.__('NEW', 'js-support-ticket').$tb.__('Answered', 'js-support-ticket').$tb.__('Closed', 'js-support-ticket').$tb.__('Pending', 'js-support-ticket').$tb.__('Overdue', 'js-support-ticket').$nl;
            $key = $result['users'];
            $agentname = $key->display_name;
            $username = $key->user_nicename;
            $email = $key->user_email;

            $data .= '"'.$agentname.'"'.$tb.'"'.$username.'"'.$tb.'"'.$email.'"'.$tb.'"'.$key->openticket.'"'.$tb.'"'.$key->answeredticket.'"'.$tb.'"'.$key->closeticket.'"'.$tb.'"'.$key->pendingticket.'"'.$tb.'"'.$key->overdueticket.'"'.$nl;

            $data .= $nl.$nl.$nl;
        }

        // by priorits tickets
        $data .= __('Tickets', 'js-support-ticket').$nl.$nl;
        if(!empty($result['tickets'])){
            $data .= __('Subject', 'js-support-ticket').$tb.__('Status', 'js-support-ticket').$tb.__('Priority', 'js-support-ticket').$tb.__('Created', 'js-support-ticket');

             if(in_array('feedback', jssupportticket::$_active_addons)){
                $data .= $tb.__('Rating', 'js-support-ticket');
            }
            if(in_array('timetracking', jssupportticket::$_active_addons)){
                $data .= $tb.__('Time', 'js-support-ticket');
            }
            $data .= $nl;


            $status = '';
            foreach ($result['tickets'] as $ticket) {
                if(in_array('timetracking', jssupportticket::$_active_addons)){
                    $hours = floor($ticket->time / 3600);
                    $mins = floor($ticket->time / 60 % 60);
                    $secs = floor($ticket->time % 60);
                    $time = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
                }
                switch($ticket->status){
                    case 0:
                        $status = __('New','js-support-ticket');
                        if($ticket->isoverdue == 1)
                            $status = __('Overdue','js-support-ticket');
                    break;
                    case 1:
                        $status = __('Pending','js-support-ticket');
                        if($ticket->isoverdue == 1)
                            $status = __('Overdue','js-support-ticket');
                    break;
                    case 2:
                        $status = __('In Progress','js-support-ticket');
                        if($ticket->isoverdue == 1)
                            $status = __('Overdue','js-support-ticket');
                    break;
                    case 3:
                        $status = __('Answered','js-support-ticket');
                        if($ticket->isoverdue == 1)
                            $status = __('Overdue','js-support-ticket');
                    break;
                    case 4:
                        $status = __('Closed','js-support-ticket');
                    break;
                    case 5:
                        $status = __('Merged','js-support-ticket');
                    break;
                }
                $created = date_i18n('Y-m-d',strtotime($ticket->created));
                $data .= '"'.$ticket->subject.'"'.$tb.'"'.$status.'"'.$tb.'"'.$ticket->priority.'"'.$tb.'"'.$created.'"';

                if(in_array('feedback', jssupportticket::$_active_addons)){
                    $data .= $tb.'"'.$ticket->rating.'"';
                }
                if(in_array('timetracking', jssupportticket::$_active_addons)){
                    $data .= $tb.'"'.$time.'"';
                }
                $data .= $nl;
            }
            $data .= $nl.$nl.$nl;
        }
        return $data;
    }

    private function getDepartmentExportData(){

        $curdate = JSSTrequest::getVar('date_start', 'get');
        $fromdate = JSSTrequest::getVar('date_end', 'get');

        if( empty($curdate) OR empty($fromdate))
            return null;

        $result['curdate'] = $curdate;
        $result['fromdate'] = $fromdate;

        //Query to get Data
        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 0 AND (lastreply = '0000-00-00 00:00:00' OR lastreply = '') AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        $result['openticket'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 4 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        $result['closeticket'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered = 1 AND status != 4 AND status != 0 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        $result['answeredticket'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isoverdue = 1 AND status != 4 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        $result['overdueticket'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered != 1 AND status != 4 AND (lastreply != '0000-00-00 00:00:00' AND lastreply != '') AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "'";
        $result['pendingticket'] = jssupportticket::$_db->get_results($query);

        $query = "SELECT department.id,department.departmentname,email.email,
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 0 AND (lastreply = '0000-00-00 00:00:00' OR lastreply = '') AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND departmentid = department.id) AS openticket,
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE status = 4 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND departmentid = department.id) AS closeticket,
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered = 1 AND status != 4 AND status != 0 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND departmentid = department.id) AS answeredticket,
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isoverdue = 1 AND status != 4 AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND departmentid = department.id) AS overdueticket,
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE isanswered != 1 AND status != 4 AND (lastreply != '0000-00-00 00:00:00' AND lastreply != '') AND date(created) >= '" . $curdate . "' AND date(created) <= '" . $fromdate . "' AND departmentid = department.id) AS pendingticket
                    FROM `".jssupportticket::$_db->prefix."js_ticket_departments` AS department
                    JOIN `".jssupportticket::$_db->prefix."js_ticket_email` AS email ON department.emailid = email.id";
        $departments = jssupportticket::$_db->get_results($query);
        $result['departments'] = $departments;
        return $result;
    }

    function setDepartmentExport(){
        $tb = "\t";
        $nl = "\n";
        $result = $this->getDepartmentExportData();
        if(empty($result))
            return '';

        $fromdate = date_i18n('Y-m-d',strtotime($result['curdate']));
        $todate = date_i18n('Y-m-d',strtotime($result['fromdate']));
        $data = __('Report By Departments', 'js-support-ticket').' '.__('From', 'js-support-ticket').' '.$fromdate.'-'.__('To', 'js-support-ticket').' '.$todate.$nl.$nl;

        // By 1 month
        $data .= __('Ticket status by days', 'js-support-ticket').$nl.$nl;
        $data .= __('Date', 'js-support-ticket').$tb.__('NEW', 'js-support-ticket').$tb.__('Answered', 'js-support-ticket').$tb.__('Closed', 'js-support-ticket').$tb.__('Pending', 'js-support-ticket').$tb.__('Overdue', 'js-support-ticket').$nl;
        while (strtotime($fromdate) <= strtotime($todate)) {
            $openticket = 0;
            $closeticket = 0;
            $answeredticket = 0;
            $overdueticket = 0;
            $pendingticket = 0;
            foreach ($result['openticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $openticket += 1;
            }
            foreach ($result['closeticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $closeticket += 1;
            }
            foreach ($result['answeredticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $answeredticket += 1;
            }
            foreach ($result['overdueticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $overdueticket += 1;
            }
            foreach ($result['pendingticket'] as $ticket) {
                $ticket_date = date_i18n('Y-m-d', strtotime($ticket->created));
                if($ticket_date == $fromdate)
                    $pendingticket += 1;
            }
            $data .= '"'.$fromdate.'"'.$tb.'"'.$openticket.'"'.$tb.'"'.$answeredticket.'"'.$tb.'"'.$closeticket.'"'.$tb.'"'.$pendingticket.'"'.$tb.'"'.$overdueticket.'"'.$nl;
            $fromdate = date_i18n("Y-m-d", strtotime("+1 day", strtotime($fromdate)));
        }
        $data .= $nl.$nl.$nl;
        // END By 1 month

        // by staus
        $openticket = count($result['openticket']);
        $closeticket = count($result['closeticket']);
        $answeredticket = count($result['answeredticket']);
        $overdueticket = count($result['overdueticket']);
        $pendingticket = count($result['pendingticket']);
        $data .= __('Tickets By Status', 'js-support-ticket').$nl;
        $data .= __('NEW', 'js-support-ticket').$tb.__('Answered', 'js-support-ticket').$tb.__('Closed', 'js-support-ticket').$tb.__('Pending', 'js-support-ticket').$tb.__('Overdue', 'js-support-ticket').$nl;
        $data .= '"'.$openticket.'"'.$tb.'"'.$answeredticket.'"'.$tb.'"'.$closeticket.'"'.$tb.'"'.$pendingticket.'"'.$tb.'"'.$overdueticket.'"'.$nl.$nl.$nl;

        // by departments
        $data .= __('Tickets By Departments', 'js-support-ticket').$nl.$nl;
        if(!empty($result['departments'])){
            $data .= __('Department Name', 'js-support-ticket').$tb.__('email', 'js-support-ticket').$tb.__('NEW', 'js-support-ticket').$tb.__('Answered', 'js-support-ticket').$tb.__('Closed', 'js-support-ticket').$tb.__('Pending', 'js-support-ticket').$tb.__('Overdue', 'js-support-ticket').$nl;
            foreach ($result['departments'] as $key) {
                $departmentname = $key->departmentname;
                $email = $key->email;
                $data .= '"'.$departmentname.'"'.$tb.'"'.$email.'"'.$tb.'"'.$key->openticket.'"'.$tb.'"'.$key->answeredticket.'"'.$tb.'"'.$key->closeticket.'"'.$tb.'"'.$key->pendingticket.'"'.$tb.'"'.$key->overdueticket.'"'.$nl;
            }
            $data .= $nl.$nl.$nl;
        }
        return $data;
    }

    private function getTicketsDataForExport(){
        $data = JSSTrequest::get('post');
        $wherequery = '';
        if(!empty($data)){
            if(isset($data['startdate']) && $data['startdate'] != '' ){
                $wherequery .= ' AND DATE(ticket.created) >= "'.$data['startdate'].'"';
            }
            if(isset($data['enddate']) && $data['enddate'] != '' ){
                $wherequery .= ' AND DATE(ticket.created) <= "'.$data['enddate'].'"';
            }
            if(isset($data['departmentid']) && $data['departmentid'] != '' ){
                $wherequery .= ' AND ticket.departmentid = '.$data['departmentid'];
            }
            if(isset($data['staffid']) && $data['staffid'] != '' ){
                $wherequery .= ' AND ticket.staffid = '.$data['staffid'];
            }
            if(isset($data['priorityid']) && $data['priorityid'] != '' ){
                $wherequery .= ' AND ticket.priorityid = '.$data['priorityid'];
            }
            if(isset($data['uid']) && $data['uid'] != '' ){
                $wherequery .= ' AND ticket.uid = '.$data['uid'];
            }
            if(isset($data['ticketstatus']) && $data['ticketstatus'] != '' ){
                $wherequery .= ' AND ticket.status = '.$data['ticketstatus'];
            }
            if(isset($data['isoverdue']) && $data['isoverdue'] != '' ){
                if($data['isoverdue'] == 1){
                    $wherequery .= ' AND ticket.isoverdue = '.$data['isoverdue'];
                }else{
                    $wherequery .= ' AND ticket.isoverdue <> 1';
                }
            }
        }

        //Tickets
        do_action('jsstFeedbackQueryStaff');// to prepare any addon based query
        do_action('ticket_detail_query');// to prepare any addon based query
        $query = "SELECT ticket.*,department.departmentname AS departmentname ,priority.priority AS priority,priority.prioritycolour AS prioritycolour,user.user_login
                    ". jssupportticket::$_addon_query['select'] . "
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket
                    LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id
                    JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id
                    LEFT JOIN `".jssupportticket::$_wpprefixforuser."users` AS user ON user.ID = ticket.uid
                    ". jssupportticket::$_addon_query['join'] . "
                    WHERE 1 = 1 ";
        $query .= $wherequery;
        $result['tickets'] = jssupportticket::$_db->get_results($query);
        do_action('reset_jsst_aadon_query');
        foreach ($result['tickets'] as $ticket) {
            if(in_array('note', jssupportticket::$_active_addons)){
                JSSTincluder::getJSModel('note')->getNotes($ticket->id);
                $ticket->notes = jssupportticket::$_data[6];// notes for the ticket
            }
            JSSTincluder::getJSModel('reply')->getReplies($ticket->id);// for ticket replies
            $ticket->replies = jssupportticket::$_data[4];
            $ticket->attachments = JSSTincluder::getJSModel('attachment')->getAttachmentForReply($ticket->id, 0);// ticket attachments
        }
        return $result;
    }

    function setTicketsExport(){
        $tb = "\t";
        $nl = "\n";
        $result = $this->getTicketsDataForExport();
        if(empty($result))
            return '';
        $data = __('Tickets Data', 'js-support-ticket').$nl.$nl;

        // by priorits tickets
        $data .= __('Tickets', 'js-support-ticket').$nl.$nl;
        if(!empty($result['tickets'])){
            $status = '';
            $customfields = JSSTincluder::getObjectClass('customfields')->userFieldsData(1);// custom fields
            // attachment path
            $datadirectory = jssupportticket::$_config['data_directory'];
            $maindir = wp_upload_dir();
            $path = $maindir['baseurl'];
            $path = $path .'/'.$datadirectory;
            $path = $path . '/attachmentdata';
            $cc=0;
            foreach ($result['tickets'] as $ticket) {
                $cc++;
                // attachment directory
                $folder = $path . '/ticket/' . $ticket->attachmentdir;
                // custom fields for individaul tickets
                foreach ($customfields as $field) {
                     JSSTincluder::getObjectClass('customfields')->showCustomFields($field,3, $ticket->params);
                }
               
            $data .=
             __('Ticket Id', 'js-support-ticket').$tb.
             __('Priority', 'js-support-ticket').$tb.
            __('Subject', 'js-support-ticket').$tb.
            __('Message', 'js-support-ticket').$tb.
            __('Status', 'js-support-ticket').$tb.
            __('Overdue', 'js-support-ticket').$tb.
            
           
            __('Department', 'js-support-ticket').$tb;
            if(in_array('agent', jssupportticket::$_active_addons)){
                $data .= __('Assigned To', 'js-support-ticket').$tb;
            }
            if(in_array('feedback', jssupportticket::$_active_addons)){
                $data .= __('Rating', 'js-support-ticket').$tb;
            }

            $data .= __('Created', 'js-support-ticket').$tb.
            __('Last Reply', 'js-support-ticket').$tb.
            __('Requester User Name', 'js-support-ticket').$tb.
            __('Requester Name', 'js-support-ticket').$tb.
            __('Requester Email', 'js-support-ticket').$tb.
            __('Requester Phone', 'js-support-ticket').$tb;
            if(in_array('helptopic', jssupportticket::$_active_addons)){
                $data .= __('Requester help Topic', 'js-support-ticket').$tb;
            }
            foreach ($customfields as $field) {// custom fields
                $array = JSSTincluder::getObjectClass('customfields')->showCustomFields($field,3, $ticket->params);
                $data .= __($array['title'],'js-support-ticket').$tb;
            }
            foreach ($ticket->attachments AS $attachment) {// attachments
                $data .= __('Ticket Attachment','js-support-ticket').$tb;
            }
            if(in_array('note', jssupportticket::$_active_addons)){
                foreach ($ticket->notes AS $note) {// Internal notes
                    $data .= __('Posted By','js-support-ticket').$tb;
                    $data .= __('Note Title','js-support-ticket').$tb;
                    $data .= __('Note Message','js-support-ticket').$tb;
                    $data .= __('Posted Date','js-support-ticket').$tb;
                    $data .= __('Note Attachment','js-support-ticket').$tb;
                    if(in_array('timetracking', jssupportticket::$_active_addons)){
                        $data .= __('User Time','js-support-ticket').$tb;
                        $data .= __('System Time','js-support-ticket').$tb;
                        $data .= __('Edit reason','js-support-ticket').$tb;
                    }
                }
            }
            foreach ($ticket->replies AS $reply) {// ticket Replies
                $data .= __('Reply Date','js-support-ticket').$tb;
                $data .= __('Reply By','js-support-ticket').$tb;
                $data .= __('Message','js-support-ticket').$tb;
                foreach ($reply->attachments AS $attachment) {
                    $data .= __('Reply Attachment','js-support-ticket').$tb;
                }
                if(in_array('timetracking', jssupportticket::$_active_addons)){
                    $data .= __('User Time','js-support-ticket').$tb;
                    $data .= __('System Time','js-support-ticket').$tb;
                    $data .= __('Edit Reason','js-support-ticket').$tb;
                }
            }
            $data .= $nl;
                $overdue = ' ';
                $status = ' ';
                switch($ticket->status){
                    case 0:
                        $status = __('New','js-support-ticket');
                        if($ticket->isoverdue == 1)
                            $overdue = __('Overdue','js-support-ticket');
                    break;
                    case 1:
                        $status = __('Pending','js-support-ticket');
                        if($ticket->isoverdue == 1)
                            $overdue = __('Overdue','js-support-ticket');
                    break;
                    case 2:
                        $status = __('In Progress','js-support-ticket');
                        if($ticket->isoverdue == 1)
                            $overdue = __('Overdue','js-support-ticket');
                    break;
                    case 3:
                        $status = __('Answered','js-support-ticket');
                        if($ticket->isoverdue == 1)
                            $overdue = __('Overdue','js-support-ticket');
                    break;
                    case 4:
                        $status = __('Closed','js-support-ticket');
                    break;
                    case 5:
                        $status = __('Merged','js-support-ticket');
                    break;
                }
                $created = date_i18n('Y-m-d H:i:s',strtotime($ticket->created));
                $lastreply = date_i18n('Y-m-d',strtotime($ticket->lastreply));
                $data .= '"'.
                $ticket->ticketid.'"'.$tb.'"'.
                $ticket->priority.'"'.$tb.'"'.
                $ticket->subject.'"'.$tb.'"'.
                $ticket->message.'"'.$tb.'"'.
                $status.'"'.$tb.'"'.
                $overdue.'"'.$tb.'"'.
                $ticket->priority.'"'.$tb.'"'.
                
                $ticket->departmentname.'"'.$tb.'"';
                if(in_array('agent', jssupportticket::$_active_addons)){
                    $data .= $ticket->staffname.'"'.$tb.'"';
                }
                if(in_array('feedback', jssupportticket::$_active_addons)){
                    $data .= $ticket->rating.'"'.$tb.'"';
                }
                $data .= $created.'"'.$tb.'"'.
                $lastreply.'"'.$tb.'"'.
                $ticket->user_login.'"'.$tb.'"'.
                $ticket->name.'"'.$tb.'"'.
                $ticket->email.'"'.$tb.'"'.
                $ticket->phone.'"'.$tb.'"';
                if(in_array('helptopic', jssupportticket::$_active_addons)){
                    $data .= $ticket->helptopic.'"'.$tb.'"';
                }
                foreach ($customfields as $field) {
                    $array = JSSTincluder::getObjectClass('customfields')->showCustomFields($field,3, $ticket->params);
                    $data .= __($array['value'],'js-support-ticket').'"'.$tb.'"';
                }
                foreach ($ticket->attachments AS $attachment) {
                    $data .= $folder.'/'.$attachment->filename .'"'.$tb.'"';
                }
                if(in_array('note', jssupportticket::$_active_addons)){
                    foreach ($ticket->notes AS $note) {// Internal notes
                        $data .= !empty($note->staffname) ? $note->staffname : $note->display_name.'"'.$tb.'"';
                        $data .= $note->title.'"'.$tb.'"';
                        $data .= $note->note.'"'.$tb.'"';
                        $data .= date_i18n("l F d, Y, h:i:s", strtotime($note->created)).'"'.$tb.'"';
                        $data .= $folder.'/'.$note->filename.'"'.$tb.'"';
                        if(in_array('timetracking', jssupportticket::$_active_addons)){
                            $hours = floor($note->usertime / 3600);
                            $mins = floor($note->usertime / 60 % 60);
                            $secs = floor($note->usertime % 60);
                            $time = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
                            $data .= $time.'"'.$tb.'"';
                            $hours = floor($note->systemtime / 3600);
                            $mins = floor($note->systemtime / 60 % 60);
                            $secs = floor($note->systemtime % 60);
                            $time = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
                            $data .= $time.'"'.$tb.'"';
                            $data .= $note->description.'"'.$tb.'"';
                        }
                    }
                }
                foreach ($ticket->replies AS $reply) {// ticket Replies
                    $data .= date_i18n("l F d, Y, h:i:s", strtotime($reply->created)).'"'.$tb.'"';
                    $data .= $reply->name.'"'.$tb.'"';
                    $data .= $reply->message.'"'.$tb.'"';
                    foreach ($reply->attachments AS $attachment) {
                        $data .= $folder.'/'.$attachment->filename.'"'.$tb.'"';
                    }
                    if(in_array('timetracking', jssupportticket::$_active_addons)){
                        $hours = floor($reply->time / 3600);
                        $mins = floor($reply->time / 60 % 60);
                        $secs = floor($reply->time % 60);
                        $time = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
                        $data .= $time.'"'.$tb.'"';
                        $hours = floor($reply->systemtime / 3600);
                        $mins = floor($reply->systemtime / 60 % 60);
                        $secs = floor($reply->systemtime % 60);
                        $time = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
                        $data .= $time.'"'.$tb.'"';
                        $data .= $reply->description.'"'.$tb.'"';
                    }
                }
            $data .= '"'.$nl;
            $data .= $nl;
            }
            $data .= $nl.$nl.$nl;
        }
        return $data;
    }
}
?>

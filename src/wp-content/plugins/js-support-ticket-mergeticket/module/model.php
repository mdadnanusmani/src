<?php

if (!defined('ABSPATH'))
    die('Restricted Access');
class JSSTmergeticketModel {

    function getTicketsForMerging(){
        $id          = JSSTrequest::getVar('ticketid');
        if(!is_numeric($id)) return false;

        $ticketlimit = JSSTrequest::getVar('ticketlimit', null, 0);
        $email       = JSSTrequest::getVar('email');
        $name        = JSSTrequest::getVar('name');
        $maxrecorded = 2;

        $wherequery = '';
        if ($name != ""){
            $wherequery .= " AND ticket.subject LIKE '%$name%'";
        }
        if ($email != ""){
            $wherequery .= " AND ticket.email LIKE '%$email%'";
        }

        $tickets = array();
        $query = "SELECT ticket.id, ticket.subject, ticket.ticketid,department.departmentname AS departmentname,ticket.name, ticket.created,ticket.uid,ticket.email,priority.priority as priorityname, priority.prioritycolour
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket
                    LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id
                    INNER JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id
                    WHERE ticket.id=" .$id;

        $ticketdetail = jssupportticket::$_db->get_row($query);

        if($ticketdetail->uid != 0){
            $wherequery .= " AND ticket.uid = " .$ticketdetail->uid;
        }else{
            $wherequery .= " AND ticket.email = '" .$ticketdetail->email ."'";
        }

        $query = "SELECT COUNT(ticket.id)
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket
                    LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id
                    INNER JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id";
        $query .= " WHERE ticket.status != 4 AND ticket.status != 5 AND ticket.mergestatus != 1 AND ticket.id !=" .$id; // addded "AND ticket.status != 5" bcz merged and closed tickets were showing on merge popup.
        $query .= $wherequery;

        $total= jssupportticket::$_db->get_var($query);

        $limit = $ticketlimit * $maxrecorded;
        if ($limit >= $total) {
            $limit = 0;
        }
        do_action('jsst_addon_staff_merge_ticket');

        $query = "SELECT ticket.id, ticket.ticketid, ticket.subject, ticket.email, department.departmentname AS departmentname, ticket.name as username, ticket.created,priority.priority as priorityname,priority.prioritycolour ".jssupportticket::$_addon_query['select']."
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket
                    LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id
                    ".jssupportticket::$_addon_query['join']."
                    INNER JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id";
        $query .= " WHERE ticket.id !=" .$id;
        $query .= " AND ticket.status != 4 AND ticket.mergestatus != 1";
        $query .=   $wherequery;
        $query .= " LIMIT $limit, $maxrecorded";

        $tickets = jssupportticket::$_db->get_results($query);
        do_action('reset_jsst_aadon_query');
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }

        $html = $this->makeTicketList($tickets, $total, $maxrecorded, $ticketlimit,$ticketdetail);
           return json_encode(array("data"=>$html));
    }

    function getLatestReplyForMerging(){
        $mergeticketid = JSSTrequest::getVar('mergeid');
        $mergewithticketid = JSSTrequest::getVar('mergewith');
        $primaryticket = $this->getTicketSubjectById($mergewithticketid);
        $secondaryticket = $this->getTicketSubjectById($mergeticketid);
        $latestreply = JSSTincluder::getJSModel('reply')->getTicketLastReplyById($mergeticketid);
        $primaryurl =  jssupportticket::makeUrl(array('jstmod'=>'ticket', 'jstlay'=>'ticketdetail', "jssupportticketid"=>$mergewithticketid,'jsstpageid'=>jssupportticket::getPageid()));
        $secondaryurl = jssupportticket::makeUrl(array('jstmod'=>'ticket', 'jstlay'=>'ticketdetail', "jssupportticketid"=>$mergeticketid,'jsstpageid'=>jssupportticket::getPageid()));
        $secondarymessage = __('Ticket has been closed due to merged with','js-support-ticket').' "'. __($primaryticket,"js-support-ticket") . '"';
        $primarymessage =   __('Ticket','js-support-ticket') .' "'. __($secondaryticket,'js-support-ticket') . '" ' . __('has been merged into','js-support-ticket') .' "'. __($primaryticket,"js-support-ticket") .'"';
        $mergeticketdata = $this->getTicketDataForMerge($mergeticketid);
        $mergewithticketdata = $this->getTicketDataForMerge($mergewithticketid);
        $isadmin = JSSTrequest::getVar('isadmin');
        if($isadmin == 1){
            $html = $this->makeTicketMergeViewForAdmin($latestreply,$mergewithticketid,$mergeticketid,$primarymessage,$secondarymessage,$mergeticketdata,$mergewithticketdata);
        }else{
            $html = $this->makeTicketMergeView($latestreply,$mergewithticketid,$mergeticketid,$primarymessage,$secondarymessage,$mergeticketdata,$mergewithticketdata);
        }
        return json_encode(array("data"=>$html));
    }

    function getTicketSubjectById($id) {
        if (!is_numeric($id))
            return false;
        $query = "SELECT subject FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE id = " . $id;
        $subject = jssupportticket::$_db->get_var($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return $subject;
    }

    function getTicketDataForMerge($id){
        if(!is_numeric($id)) return false;

        do_action('jsst_addon_staff_merge_ticket');
        $query = "SELECT ticket.id, ticket.subject, ticket.ticketid,department.departmentname AS departmentname,ticket.name, ticket.created,ticket.uid,ticket.email,priority.priority as priorityname, priority.prioritycolour ".jssupportticket::$_addon_query['select']."
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket
                    LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON ticket.departmentid = department.id
                    ".jssupportticket::$_addon_query['join']."
                    INNER JOIN `" . jssupportticket::$_db->prefix . "js_ticket_priorities` AS priority ON ticket.priorityid = priority.id
                    WHERE ticket.id=" .$id;

        $ticketdata = jssupportticket::$_db->get_results($query);
        do_action('reset_jsst_aadon_query');
        return $ticketdata;
    }

    function makeTicketList($tickets, $total, $maxrecorded, $ticketlimit,$ticketdata) {

        $html = '';
        $html .= '
                <div class="jsst-popup-background"></div>
                <div class="jsst-popup-wrapper jsst-merge-popup-wrapper" id="mergeticketselection">
                    <div class="jsst-popup-header" >
                        <div class="popup-header-text" >'
                            .__('Merge Ticket','js-support-ticket').'
                        </div>
                        <div class="popup-header-close-img" id="close-pop" >
                        </div>
                    </div>';

            $html .='<div class="js-ticket-merge-ticket-wrapper">
                        <div class="js-col-xs-12 js-col-md-12 js-ticket-wrapper js-ticket-merge-white-bg">
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-toparea">
                                <div class="js-col-md-2 js-col-xs-12 js-ticket-pic">';
                                    if (in_array('agent', jssupportticket::$_active_addons) && isset($ticketdata->staffphoto) &&  $ticketdata->staffphoto) { ;
                                    $html .='<img class="js-ticket-staff-img" src="'.jssupportticket::makeUrl(array('jstmod'=>'agent','task'=>'getStaffPhoto','action'=>'jstask','jssupportticketid'=> $ticketdata->staffid ,'jsstpageid'=>jssupportticket::getPageid())).'">';
                                    } else {
                                        if (isset(jssupportticket::$_data[0]->uid) && !empty(jssupportticket::$_data[0]->uid)) {
                                            echo get_avatar($ticketdata->uid);
                                        } else { ;
                                            $html .='<img class="js-ticket-staff-img" src="' .jssupportticket::$_pluginpath .'/includes/images/ticketmanbig.png">';
                                        }
                                    };
                            $html .='</div>
                                <div class="js-col-md-6 js-col-xs-12 js-ticket-data js-nullpadding">
                                    <div class="js-col-md-12 js-col-xs-12 js-ticket-padding-xs js-ticket-body-data-elipses">
                                        <span class="js-ticket-title">
                                            '. __('Subject', 'js-support-ticket').'&nbsp;:&nbsp
                                        </span>
                                        <a class="js-ticket-merge-ticket-title">' .$ticketdata->subject.' </a>
                                    </div>
                                    <div class="js-col-md-12 js-col-xs-12 js-ticket-padding-xs js-ticket-body-data-elipses">
                                        <span class="js-ticket-title">'. __('From', 'js-support-ticket').'&nbsp;:&nbsp;</span>
                                        <span class="js-ticket-value" style="cursor:pointer;">'. $ticketdata->name.'</span>
                                    </div>
                                    <div class="js-col-md-12 js-col-xs-12 js-ticket-padding-xs js-ticket-body-data-elipses">
                                        <span class="js-ticket-title">'.__('Department', 'js-support-ticket').'&nbsp;:&nbsp;</span>
                                        <span class="js-ticket-value" style="cursor:pointer;">'.$ticketdata->departmentname.'</span>
                                    </div>
                                </div>
                                <div class="js-col-md-4 js-col-xs-12 js-ticket-data1 js-ticket-padding-left-xs">
                                    <div class="js-row">
                                        <div class="js-col-md-6 js-col-xs-6">'. __('Ticket ID #', 'js-support-ticket').':</div>
                                        <div class="js-col-md-6 js-col-xs-6">'. $ticketdata->id.'</div>
                                    </div>
                                    <div class="js-row">
                                        <div class="js-col-md-6 js-col-xs-6">'. __('Created', 'js-support-ticket').':</div>
                                        <div class="js-col-md-6 js-col-xs-6">'. date( "Y-m-d", strtotime($ticketdata->created)).'</div>
                                    </div>
                                    <div class="js-row">
                                        <div class="js-col-md-6 js-col-xs-6">'. __('Priority', 'js-support-ticket').':</div>
                                        <div class="js-col-md-6 js-col-xs-6"><span class="js-ticket-wrapper-textcolor" style="background:' .$ticketdata->prioritycolour.'">'.$ticketdata->priorityname.'</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="js-tickets-list-wrp">
                        <form id="ticketpopupsearch" class="js-popup-search">
                            <div class="js-col-md-12 js-form-wrapper jsst-form-wrapper">
                                <div class="js-col-md-12 js-form-title js-merge-form-title js-bold-text">'. __('Search Ticket to merge into','js-support-ticket') . '</div>
                                <div class="js-merge-form-wrp">
                                    <div class="js-form-value js-merge-form-value"><input class="inputbox js-merge-field" id="name" type="text" name="name" placeholder="Enter Name"/></div>
                                    <div class="js-form-value js-merge-form-value"><input class="inputbox js-merge-field" id="email" type="text" name="email" placeholder="Email"/></div>
                                </div>
                                <div class="js-merge-form-btn-wrp">
                                    <span class="js-merge-btn"><input type="submit" value=' . __('Search','js-support-ticket') . ' class="button js-merge-button js-search" /></span>
                                    <span class="js-merge-btn"><input type="submit" value=' . __('Reset','js-support-ticket') . ' class="button js-merge-button js-cancel" /></span>
                                </div>
                            </div>
                        </form>
                        <div class="js-col-md-12 js-view-tickets">';
                        if (!empty($tickets)) {
                            if (is_array($tickets)) {
                                foreach ($tickets AS $ticket) {
                                $html .= '<div class="js-col-xs-12 js-col-md-12 js-ticket-wrapper js-merge-ticket-overlay js-ticket-merge-white-bg">
                                            <div class="js-col-xs-12 js-col-md-12 js-ticket-toparea">
                                               <div class="js-col-xs-2 js-col-md-2 js-ticket-pic">';
                                                    if ( in_array('agent', jssupportticket::$_active_addons) && isset($ticket->staffphoto)) { ;
                                                    $html .='<img class="js-ticket-staff-img" src="'.jssupportticket::makeUrl(array('jstmod'=>'agent','task'=>'getStaffPhoto','action'=>'jstask','jssupportticketid'=> $ticket->staffid ,'jsstpageid'=>jssupportticket::getPageid())).'">';
                                                    } else {
                                                        if (isset(jssupportticket::$_data[0]->uid) && !empty(jssupportticket::$_data[0]->uid)) {
                                                            echo get_avatar($ticket->uid);
                                                        } else { ;
                                                            $html .='<img class="js-ticket-staff-img" src="' .jssupportticket::$_pluginpath .'/includes/images/ticketmanbig.png">';
                                                        }
                                                    };
                                                $html .='</div>
                                                <div class="js-col-xs-10 js-col-md-6 js-col-xs-10 js-ticket-data js-nullpadding">
                                                    <div class="js-col-xs-12 js-col-md-12 js-ticket-padding-xs js-ticket-body-data-elipses">
                                                        <span class="js-ticket-title">
                                                            '. __('Subject', 'js-support-ticket').'&nbsp;:&nbsp
                                                        </span>
                                                        <a class="js-ticket-merge-ticket-title">' .$ticket->subject.' </a>
                                                    </div>
                                                    <div class="js-col-xs-12 js-col-md-12 js-ticket-padding-xs js-ticket-body-data-elipses">
                                                        <span class="js-ticket-title">'. __('From', 'js-support-ticket').'&nbsp;:&nbsp;</span>
                                                        <span class="js-ticket-value" style="cursor:pointer;">'. $ticket->username.'</span>
                                                    </div>
                                                    <div class="js-col-xs-12 js-col-md-12 js-ticket-padding-xs js-ticket-body-data-elipses">
                                                        <span class="js-ticket-title">'.__('Department', 'js-support-ticket').'&nbsp;:&nbsp;</span>
                                                        <span class="js-ticket-value" style="cursor:pointer;">'.$ticket->departmentname.'</span>
                                                    </div>
                                                </div>
                                                <div class="js-col-xs-12 js-col-md-4 js-ticket-data1 js-ticket-padding-left-xs">
                                                    <div class="js-row">
                                                        <div class="js-col-xs-6 js-col-md-6 js-col-xs-6">'. __('Ticket ID #', 'js-support-ticket').':</div>
                                                        <div class="js-col-xs-6 js-col-md-6 js-col-xs-6">'. $ticket->id.'</div>
                                                    </div>
                                                    <div class="js-row">
                                                        <div class="js-col-xs-6 js-col-md-6 js-col-xs-6">'. __('Created', 'js-support-ticket').':</div>
                                                        <div class="js-col-xs-6 js-col-md-6 js-col-xs-6">'. date( "Y-m-d", strtotime($ticket->created)).'</div>
                                                    </div>
                                                    <div class="js-row">
                                                        <div class="js-col-xs-6 js-col-md-6 js-col-xs-6">'. __('Priority', 'js-support-ticket').':</div>
                                                        <div class="js-col-xs-6 js-col-md-6 js-col-xs-6"><span class="js-ticket-wrapper-textcolor" style="background:' .$ticket->prioritycolour.'">'.$ticket->priorityname.'</span></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="js-over-lay">
                                                <a href="#" class="js-merge-btn" onclick=getmergeticketid('.$ticketdata->id.','.$ticket->id.')>Select</a>
                                            </div>
                                        </div>';
                                }
                            }
                        }else {
                            $html .= JSSTlayout::getNoRecordFoundForAjax();
                        }
                $html .= '</div>';
                    $num_of_pages = ceil($total / $maxrecorded);
                    $num_of_pages = ($num_of_pages > 0) ? ceil($num_of_pages) : floor($num_of_pages);
                    if($num_of_pages > 0){
                        $page_html = '';
                        $prev = $ticketlimit;
                        if($prev > 0){
                            $page_html .= '<a class="jsst_userlink js-text-align-left" href="#" onclick="updateticketlist('.($prev - 1).','.$ticketdata->id.');">'.__('Previous','js-support-ticket').'</a>';
                        }
                        for($i = 0; $i < $num_of_pages; $i++){
                            if($i == $ticketlimit)
                                $page_html .= '<span class="jsst_userlink selected" >'.($i + 1).'</span>';
                            else
                                $page_html .= '<a class="jsst_userlink" href="#" onclick="updateticketlist('.$i.','.$ticketdata->id.');">'.($i + 1).'</a>';

                        }
                        $next = $ticketlimit + 1;
                        if($next < $num_of_pages){
                            $page_html .= '<a class="jsst_userlink js-text-align-right" href="#" onclick="updateticketlist('.$next.','.$ticketdata->id.');">'.__('Next','js-support-ticket').'</a>';
                        }
                        if($page_html != ''){
                            $html .= '<div class="jsst_userpages">'.$page_html.'</div>';
                        }
                    }
            $html .='</div>
                    <div class="js-col-md-12 js-form-button-wrapper js-form-button-wrapper-merge">
                        <input id=close-pop" type="button" value=' . __('Cancel','js-support-ticket') . ' class="button js-merge-cancel-btn" onclick="closePopup()" />
                        <input type="hidden" id="ticketidformerge" value="'.$ticketdata->id.'" />
                    </div>';

        $html .= '</div>';
            return $html;
    }

    function makeTicketMergeView($latestmessage,$primaryid,$secondaryid,$primarymessage,$secondarymessage,$mergeticketdata,$mergewithticketdata){
        $page_id = JSSTincluder::getJSModel('configuration')->getConfigValue('default_pageid');
        $url = jssupportticket::makeUrl(array('jstmod'=>'ticket','task'=>'mergeticket','action'=>'jstask','jsstpageid'=>$page_id));
        $html = '
                <div class="jsst-popup-background"></div>
                <div class="jsst-popup-wrapper jsst-merge-popup-wrapper" id="mergeticketselection">
                    <div class="jsst-popup-header" >
                        <div class="popup-header-text" >'
                            .__('Merge Ticket','js-support-ticket').'
                        </div>
                        <div class="popup-header-close-img" id="close-pop" >
                        </div>
                    </div>';
        if (!empty($mergeticketdata)) {
            if (is_array($mergeticketdata)) {
                foreach ($mergeticketdata AS $mergeticketdata) {
        $html .=' <form id="jsst-ticket-merge-form" method="post" action='.esc_url($url).'>
                    <div class="js-ticket-merge-ticket-wrapper">
                        <div class="js-col-xs-12 js-col-md-12 js-ticket-wrapper js-ticket-merge-white-bg">
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-toparea">
                                <div class="js-col-xs-2 js-col-md-2 js-ticket-pic">';
                                    if (in_array('agent', jssupportticket::$_active_addons) && isset($mergeticketdata->staffphoto)) { ;
                                    $html .='<img class="js-ticket-staff-img" src="'.jssupportticket::makeUrl(array('jstmod'=>'agent','task'=>'getStaffPhoto','action'=>'jstask','jssupportticketid'=> $mergeticketdata->staffid ,'jsstpageid'=>jssupportticket::getPageid())).'">';
                                    } else {
                                        if (isset(jssupportticket::$_data[0]->uid) && !empty(jssupportticket::$_data[0]->uid)) {
                                            echo get_avatar($mergeticketdata->uid);
                                        } else { ;
                                            $html .='<img class="js-ticket-staff-img" src="' .jssupportticket::$_pluginpath .'/includes/images/ticketmanbig.png">';
                                        }
                                    };
                            $html .='</div>
                                <div class="js-col-xs-10 js-col-md-6 js-col-xs-10 js-ticket-data js-nullpadding">
                                    <div class="js-col-xs-12 js-col-md-12 js-ticket-padding-xs js-ticket-body-data-elipses">
                                        <span class="js-ticket-title">
                                            '. __('Subject', 'js-support-ticket').'&nbsp;:&nbsp
                                        </span>
                                        <a class="js-ticket-merge-ticket-title">' .$mergeticketdata->subject.' </a>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-12 js-ticket-padding-xs js-ticket-body-data-elipses">
                                        <span class="js-ticket-title">'. __('From', 'js-support-ticket').'&nbsp;:&nbsp;</span>
                                        <span class="js-ticket-value" style="cursor:pointer;">'. $mergeticketdata->name.'</span>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-12 js-ticket-padding-xs js-ticket-body-data-elipses">
                                        <span class="js-ticket-title">'.__('Department', 'js-support-ticket').'&nbsp;:&nbsp;</span>
                                        <span class="js-ticket-value" style="cursor:pointer;">'.$mergeticketdata->departmentname.'</span>
                                    </div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-data1 js-ticket-padding-left-xs">
                                    <div class="js-row">
                                        <div class="js-col-xs-6 js-col-md-6 js-col-xs-6">'. __('Ticket ID #', 'js-support-ticket').':</div>
                                        <div class="js-col-xs-6 js-col-md-6 js-col-xs-6">'. $mergeticketdata->id.'</div>
                                    </div>
                                    <div class="js-row">
                                        <div class="js-col-xs-6 js-col-md-6 js-col-xs-6">'. __('Created', 'js-support-ticket').':</div>
                                        <div class="js-col-xs-6 js-col-md-6 js-col-xs-6">'. date( "Y-m-d", strtotime($mergeticketdata->created)).'</div>
                                    </div>
                                    <div class="js-row">
                                        <div class="js-col-xs-6 js-col-md-6 js-col-xs-6">'. __('Priority', 'js-support-ticket').':</div>
                                        <div class="js-col-xs-6 js-col-md-6 js-col-xs-6"><span class="js-ticket-wrapper-textcolor" style="background:' .$mergeticketdata->prioritycolour.'">'.$mergeticketdata->priorityname.'</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="js-edit-msg-field-wrp">
                            <span class="js-edit-msg-heading">' .__('Edit Last Reply','js-support-ticket'). '</span>
                            <textarea class="inputbox js-merge-field" id="mergeticketid" name="secondarymessage" cols="" rows="3" >'.$secondarymessage.'</textarea>
                        </div>
                    </div>';
                }

            }
        }
        if (!empty($mergewithticketdata)) {
            if (is_array($mergewithticketdata)) {
                foreach ($mergewithticketdata AS $mergewithticketdata) {
                $html .='<div class="js-col-md-12 js-view-tickets js-view-last-tickets">
                            <span class="js-heading js-heading-text">'. __('Merge Ticket Latest Reply','js-support-ticket') . ' </span>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-wrapper js-ticket-merge-white-bg">
                                <div class="js-col-xs-12 js-col-md-12 js-ticket-toparea">
                                    <div class="js-col-xs-2 js-col-md-2 js-ticket-pic">';
                                        if (in_array('agent', jssupportticket::$_active_addons) && isset($mergewithticketdata->staffphoto)) { ;
                                        $html .='<img class="js-ticket-staff-img" src="'.jssupportticket::makeUrl(array('jstmod'=>'agent','task'=>'getStaffPhoto','action'=>'jstask','jssupportticketid'=> $mergewithticketdata->staffid ,'jsstpageid'=>jssupportticket::getPageid())).'">';
                                        } else {
                                            if (isset(jssupportticket::$_data[0]->uid) && !empty(jssupportticket::$_data[0]->uid)) {
                                                echo get_avatar($mergewithticketdata->uid);
                                            } else { ;
                                                $html .='<img class="js-ticket-staff-img" src="' .jssupportticket::$_pluginpath .'/includes/images/ticketmanbig.png">';
                                            }
                                        };
                                $html .='</div>
                                    <div class="js-col-xs-10 js-col-md-6 js-col-xs-10 js-ticket-data js-nullpadding">
                                        <div class="js-col-xs-12 js-col-md-12 js-ticket-padding-xs js-ticket-body-data-elipses">
                                            <span class="js-ticket-title">
                                                '. __('Subject', 'js-support-ticket').'&nbsp;:&nbsp
                                            </span>
                                            <a class="js-ticket-merge-ticket-title">' .$mergewithticketdata->subject.' </a>
                                        </div>
                                        <div class="js-col-xs-12 js-col-md-12 js-ticket-padding-xs js-ticket-body-data-elipses">
                                            <span class="js-ticket-title">'. __('From', 'js-support-ticket').'&nbsp;:&nbsp;</span>
                                            <span class="js-ticket-value" style="cursor:pointer;">'. $mergewithticketdata->name.'</span>
                                        </div>
                                        <div class="js-col-xs-12 js-col-md-12 js-ticket-padding-xs js-ticket-body-data-elipses">
                                            <span class="js-ticket-title">'.__('Department', 'js-support-ticket').'&nbsp;:&nbsp;</span>
                                            <span class="js-ticket-value" style="cursor:pointer;">'.$mergewithticketdata->departmentname.'</span>
                                        </div>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-4 js-ticket-data1 js-ticket-padding-left-xs">
                                        <div class="js-row">
                                            <div class="js-col-xs-6 js-col-md-6 js-col-xs-6">'. __('Ticket ID #', 'js-support-ticket').':</div>
                                            <div class="js-col-xs-6 js-col-md-6 js-col-xs-6">'. $mergewithticketdata->id.'</div>
                                        </div>
                                        <div class="js-row">
                                            <div class="js-col-xs-6 js-col-md-6 js-col-xs-6">'. __('Created', 'js-support-ticket').':</div>
                                            <div class="js-col-xs-6 js-col-md-6 js-col-xs-6">'. date( "Y-m-d", strtotime($mergewithticketdata->created)).'</div>
                                        </div>
                                        <div class="js-row">
                                            <div class="js-col-xs-6 js-col-md-6 js-col-xs-6">'. __('Priority', 'js-support-ticket').':</div>
                                            <div class="js-col-xs-6 js-col-md-6 js-col-xs-6"><span class="js-ticket-wrapper-textcolor" style="background:' .$mergewithticketdata->prioritycolour.'">'.$mergewithticketdata->priorityname.'</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="js-edit-msg-field-wrp">
                                <span class="js-edit-msg-heading">' .__('Edit Last Reply','js-support-ticket'). '</span>
                                <textarea class="inputbox js-merge-field" id="primaryid" name="primarymessage" cols="" rows="3" >'.$primarymessage."\r\n\r\n".$latestmessage.'</textarea>
                            </div>';
                $html.='</div>';
                }
            }
        }
        $html.='
                        <div class="js-col-md-12 js-form-button-wrapper js-form-button-wrapper-merge">
                            <input type="submit" value=' . __('Merge','js-support-ticket') . ' class="button js-merge-save-btn"/>
                        </div>
                        <input type="hidden" value="ticket_mergeticket" name="action" id="action"/>
                        <input type="hidden" name="primaryticket" id="task" value="'.$primaryid.'" />
                        <input type="hidden" name="secondaryticket" id="task" value="'.$secondaryid.'" />
                        <input type="hidden" name="isadmin" value="0" />
                        '.JSSTformfield::hidden('form_request', 'jssupportticket').'
                    </form>
                </div>';
        return $html;
    }

    function makeTicketMergeViewForAdmin($latestmessage,$primaryid,$secondaryid,$primarymessage,$secondarymessage,$mergeticketdata,$mergewithticketdata){
        $page_id = JSSTincluder::getJSModel('configuration')->getConfigValue('default_pageid');
        $url = admin_url("admin.php?page=ticket&task=mergeticket");
        $html = '
                <div class="jsst-popup-background"></div>
                <div class="jsst-popup-wrapper jsst-merge-popup-wrapper" id="mergeticketselection">
                    <div class="jsst-popup-header" >
                        <div class="popup-header-text" >'
                            .__('Merge Ticket','js-support-ticket').'
                        </div>
                        <div class="popup-header-close-img" id="close-pop" >
                        </div>
                    </div>';
        if (!empty($mergeticketdata)) {
            if (is_array($mergeticketdata)) {
                foreach ($mergeticketdata AS $mergeticketdata) {
            $html .=' <form id="jsst-ticket-merge-form" method="post" action='.$url.'>
                    <div class="js-ticket-merge-ticket-wrapper">
                        <div class="js-col-xs-12 js-col-md-12 js-ticket-wrapper js-ticket-merge-white-bg">
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-toparea">
                                <div class="js-col-xs-2 js-col-md-2 js-ticket-pic">';
                                    if (in_array('agent', jssupportticket::$_active_addons) && isset($mergeticketdata->staffphoto)) { ;
                                    $html .='<img class="js-ticket-staff-img" src="'.jssupportticket::makeUrl(array('jstmod'=>'agent','task'=>'getStaffPhoto','action'=>'jstask','jssupportticketid'=> $mergeticketdata->staffid ,'jsstpageid'=>jssupportticket::getPageid())).'">';
                                    } else {
                                        if (isset(jssupportticket::$_data[0]->uid) && !empty(jssupportticket::$_data[0]->uid)) {
                                            echo get_avatar($mergeticketdata->uid);
                                        } else { ;
                                            $html .='<img class="js-ticket-staff-img" src="' .jssupportticket::$_pluginpath .'/includes/images/ticketmanbig.png">';
                                        }
                                    };
                            $html .='</div>
                                <div class="js-col-xs-10 js-col-md-6 js-col-xs-10 js-ticket-data js-nullpadding">
                                    <div class="js-col-xs-12 js-col-md-12 js-ticket-padding-xs js-ticket-body-data-elipses">
                                        <span class="js-ticket-title">
                                            '. __('Subject', 'js-support-ticket').'&nbsp;:&nbsp
                                        </span>
                                        <a class="js-ticket-merge-ticket-title">' .$mergeticketdata->subject.' </a>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-12 js-ticket-padding-xs js-ticket-body-data-elipses">
                                        <span class="js-ticket-title">'. __('From', 'js-support-ticket').'&nbsp;:&nbsp;</span>
                                        <span class="js-ticket-value" style="cursor:pointer;">'. $mergeticketdata->name.'</span>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-12 js-ticket-padding-xs js-ticket-body-data-elipses">
                                        <span class="js-ticket-title">'.__('Department', 'js-support-ticket').'&nbsp;:&nbsp;</span>
                                        <span class="js-ticket-value" style="cursor:pointer;">'.$mergeticketdata->departmentname.'</span>
                                    </div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-data1 js-ticket-padding-left-xs">
                                    <div class="js-row">
                                        <div class="js-col-xs-6 js-col-md-6 js-col-xs-6">'. __('Ticket ID #', 'js-support-ticket').':</div>
                                        <div class="js-col-xs-6 js-col-md-6 js-col-xs-6">'. $mergeticketdata->id.'</div>
                                    </div>
                                    <div class="js-row">
                                        <div class="js-col-xs-6 js-col-md-6 js-col-xs-6">'. __('Created', 'js-support-ticket').':</div>
                                        <div class="js-col-xs-6 js-col-md-6 js-col-xs-6">'. date( "Y-m-d", strtotime($mergeticketdata->created)).'</div>
                                    </div>
                                    <div class="js-row">
                                        <div class="js-col-xs-6 js-col-md-6 js-col-xs-6">'. __('Priority', 'js-support-ticket').':</div>
                                        <div class="js-col-xs-6 js-col-md-6 js-col-xs-6"><span class="js-ticket-wrapper-textcolor" style="background:' .$mergeticketdata->prioritycolour.'">'.$mergeticketdata->priorityname.'</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
                }
            }
        }
        if (!empty($mergewithticketdata)) {
            if (is_array($mergewithticketdata)) {
                foreach ($mergewithticketdata AS $mergewithticketdata) {
                $html .='<div class="js-col-md-12 js-view-tickets js-view-last-tickets">
                            <span class="js-heading js-heading-text">'. __('Merge Ticket Latest Reply','js-support-ticket') . ' </span>
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-wrapper js-ticket-merge-white-bg">
                                <div class="js-col-xs-12 js-col-md-12 js-ticket-toparea">
                                    <div class="js-col-xs-2 js-col-md-2 js-ticket-pic">';
                                        if (in_array('agent', jssupportticket::$_active_addons) && isset($mergewithticketdata->staffphoto)) { ;
                                        $html .='<img class="js-ticket-staff-img" src="'.jssupportticket::makeUrl(array('jstmod'=>'agent','task'=>'getStaffPhoto','action'=>'jstask','jssupportticketid'=> $mergewithticketdata->staffid ,'jsstpageid'=>jssupportticket::getPageid())).'">';
                                        } else {
                                            if (isset(jssupportticket::$_data[0]->uid) && !empty(jssupportticket::$_data[0]->uid)) {
                                                echo get_avatar($mergewithticketdata->uid);
                                            } else { ;
                                                $html .='<img class="js-ticket-staff-img" src="' .jssupportticket::$_pluginpath .'/includes/images/ticketmanbig.png">';
                                            }
                                        };
                                $html .='</div>
                                    <div class="js-col-xs-10 js-col-md-6 js-col-xs-10 js-ticket-data js-nullpadding">
                                        <div class="js-col-xs-12 js-col-md-12 js-ticket-padding-xs js-ticket-body-data-elipses">
                                            <span class="js-ticket-title">
                                                '. __('Subject', 'js-support-ticket').'&nbsp;:&nbsp
                                            </span>
                                            <a class="js-ticket-merge-ticket-title">' .$mergewithticketdata->subject.' </a>
                                        </div>
                                        <div class="js-col-xs-12 js-col-md-12 js-ticket-padding-xs js-ticket-body-data-elipses">
                                            <span class="js-ticket-title">'. __('From', 'js-support-ticket').'&nbsp;:&nbsp;</span>
                                            <span class="js-ticket-value" style="cursor:pointer;">'. $mergewithticketdata->name.'</span>
                                        </div>
                                        <div class="js-col-xs-12 js-col-md-12 js-ticket-padding-xs js-ticket-body-data-elipses">
                                            <span class="js-ticket-title">'.__('Department', 'js-support-ticket').'&nbsp;:&nbsp;</span>
                                            <span class="js-ticket-value" style="cursor:pointer;">'.$mergewithticketdata->departmentname.'</span>
                                        </div>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-4 js-ticket-data1 js-ticket-padding-left-xs">
                                        <div class="js-row">
                                            <div class="js-col-xs-6 js-col-md-6 js-col-xs-6">'. __('Ticket ID #', 'js-support-ticket').':</div>
                                            <div class="js-col-xs-6 js-col-md-6 js-col-xs-6">'. $mergewithticketdata->id.'</div>
                                        </div>
                                        <div class="js-row">
                                            <div class="js-col-xs-6 js-col-md-6 js-col-xs-6">'. __('Created', 'js-support-ticket').':</div>
                                            <div class="js-col-xs-6 js-col-md-6 js-col-xs-6">'. date( "Y-m-d", strtotime($mergewithticketdata->created)).'</div>
                                        </div>
                                        <div class="js-row">
                                            <div class="js-col-xs-6 js-col-md-6 js-col-xs-6">'. __('Priority', 'js-support-ticket').':</div>
                                            <div class="js-col-xs-6 js-col-md-6 js-col-xs-6"><span class="js-ticket-wrapper-textcolor" style="background:' .$mergewithticketdata->prioritycolour.'">'.$mergewithticketdata->priorityname.'</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="js-edit-msg-field-wrp">
                                <span class="js-edit-msg-heading">' .__('Edit Last Reply','js-support-ticket'). '</span>
                                <textarea class="inputbox js-merge-field" id="primaryid" name="primarymessage" cols="" rows="3" >'.$primarymessage."\r\n\r\n".$latestmessage.'</textarea>
                            </div>';
                $html.='</div>';
                }
            }
        }
        $html.='
                        <div class="js-col-md-12 js-form-button-wrapper js-form-button-wrapper-merge">
                            <input type="submit" value=' . __('Merge','js-support-ticket') . ' class="button js-merge-cancel-btn"/>
                        </div>
                        <input type="hidden" value="ticket_mergeticket" name="action" id="action"/>
                        <input type="hidden" name="primaryticket" id="task" value="'.$primaryid.'" />
                        <input type="hidden" name="secondaryticket" id="task" value="'.$secondaryid.'" />
                        <input type="hidden" name="isadmin" value="1" />
                        '.JSSTformfield::hidden('form_request', 'jssupportticket').'
                    </form>
                </div>';
        return $html;
    }

    function storeMergeTicket($data){
        if(empty($data))
            return false;
        if ($data['primaryticket'] == $data['secondaryticket']) {
            return false;
        }
        $curdate        = date('Y-m-d H:i:s');
        $user_id        = get_current_user_id();
        $username       = JSSTincluder::getJSModel('jssupportticket')->getUserNameById($user_id);
        $multimerge     = array($data['secondaryticket']);

        $query = "SELECT multimergeparams FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE id =" .$data['primaryticket'];
        $array = jssupportticket::$_db->get_var($query);
        if(empty($array)){
            $mergeticketvalues[] = array("uid" => $user_id, "mergedate" => $curdate, "ticketid" => $data['secondaryticket']);
            $array = json_encode($mergeticketvalues);
        }else{
            $mergeticketvalues = array("uid" => $user_id, "mergedate" => $curdate, "ticketid" => $data['secondaryticket']);
            array_push($array, $mergeticketvalues);
            $array = json_encode($array);
        }

        $row = JSSTincluder::getJSTable('tickets');
        $row2 = JSSTincluder::getJSTable('tickets');

        if ($row->update(array('id' => $data['secondaryticket'], 'mergestatus' => 1, 'mergedate' => $curdate, 'mergewith' => $data['primaryticket'], 'status' => 5, 'mergeuid' => $user_id, 'isoverdue' => 0)) && $row2->update(array('id' => $data['primaryticket'], 'multimergeparams' => $array, 'updated' => $curdate))) {
            JSSTmessage::setMessage(__('Ticket Has been Merged', 'js-support-ticket'), 'updated');
            $messagetype = __('Successfully', 'js-support-ticket');

            if(is_admin()){
                $secondaryurl = '<a href="admin.php?page=ticket&jstlay=ticketdetail&jssupportticketid='.$data['secondaryticket'].'">#'.$data['secondaryticket'].'</a>';
                $primaryurl   = '<a href="admin.php?page=ticket&jstlay=ticketdetail&jssupportticketid='.$data['primaryticket'].'">#'.$data['primaryticket'].'</a>';
            }else if( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()){
                $secondaryurl = '<a href="'.esc_url(jssupportticket::makeUrl(array('jstmod'=>'ticket','jstlay'=>'ticketdetail','jssupportticketid'=>$data['secondaryticket']))).'">#'.$data['secondaryticket'].'</a>';
                $primaryurl   = '<a href="'.esc_url(jssupportticket::makeUrl(array('jstmod'=>'ticket','jstlay'=>'ticketdetail','jssupportticketid'=>$data['primaryticket']))).'">#'.$data['primaryticket'].'</a>';
            }
            $secondarymessage = $data['secondarymessage'].'('.$primaryurl.')';
            $primarymessage = $data['primarymessage'].'('.$secondaryurl.')';


            $savesecondaryreply = JSSTincluder::getJSModel('reply')->storeMergeTicketReplies(htmlspecialchars($secondarymessage),$data['secondaryticket']);
            $saveprimaryreply = JSSTincluder::getJSModel('reply')->storeMergeTicketReplies(htmlspecialchars($primarymessage),$data['primaryticket']);

        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Ticket Has not been Merged', 'js-support-ticket'), 'error');
            $messagetype = __('Error', 'js-support-ticket');
        }

    }

}

?>
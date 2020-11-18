<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

function jsst_generate_rewrite_rules(&$rules, $rule){
    $_new_rules = array();
    foreach($rules AS $key => $value){
        if(strstr($key, $rule)){
            $newkey = substr($key,0,strlen($key) - 3);
            $matcharray = explode('$matches', $value);
            $countmatch = COUNT($matcharray);
            //on all pages
            $changename = false;
            if(file_exists(WP_PLUGIN_DIR.'/js-jobs/js-jobs.php')){
                $changename = true;
            }
            if(file_exists(WP_PLUGIN_DIR.'/js-vehicle-manager/js-vehicle-manager.php')){
                $changename = true;
            }
            $add_message = ($changename === true) ? 'ticket-add-message' : 'add-message';
            $message_inbox = ($changename === true) ? 'ticket-message-inbox' : 'message-inbox';
            $login = ($changename === true) ? 'ticket-login' : 'login';
            $userregister = ($changename === true) ? 'ticket-user-register' : 'userregister';
            $message = ($changename === true) ? 'ticket-message' : 'message';
            $my_profile = ($changename === true) ? 'ticket-my-profile' : 'my-profile';
            $message_outbox = ($changename === true) ? 'ticket-message-outbox' : 'message-outbox';
            $_key = $newkey . '/(staff-add-ticket|announcements|staff-feedbacks|visitor-message|role-permission|downloads|faqs|faq|add-department|announcement|add-announcement|add-download|add-faq|add-article|add-category|kb-articles|kb-article|'.$add_message.'|'.$message.'|'.$message_inbox.'|'.$message_outbox.'|add-role|add-staff|staff-permissions|my-tickets|staff-my-tickets|add-ticket|'.$login.'|'.$userregister.'|ticket-status|staff-announcements|departments|staff-downloads|staff-faqs|control-panel|staff-kb-articles|staff-categories|knowledgebase|roles|'.$my_profile.'|staffs|staff-reports|department-reports|feed-back|print-ticket|staff-report|ticket)(/[^/]*)?(/[^/]*)?(/[^/]*)?/?$';
            $newvalue = $value . '&jsstlayout=$matches['.$countmatch.']&jst1=$matches['.($countmatch + 1).']&jst2=$matches['.($countmatch + 2).']&jst3=$matches['.($countmatch + 3).']';
            $_new_rules[$_key] = $newvalue;
        }
    }
    return $_new_rules;
}

function jsst_post_rewrite_rules_array($rules){
    $newrules = array();
    $newrules = jsst_generate_rewrite_rules($rules, '([^/]+)(?:/([0-9]+))?/?$');
    $newrules += jsst_generate_rewrite_rules($rules, '([^/]+)(/[0-9]+)?/?$');
    $newrules += jsst_generate_rewrite_rules($rules, '([0-9]+)(?:/([0-9]+))?/?$');
    $newrules += jsst_generate_rewrite_rules($rules, '([0-9]+)(/[0-9]+)?/?$');
    return $newrules + $rules;
}
add_filter('post_rewrite_rules', 'jsst_post_rewrite_rules_array');

function jsst_page_rewrite_rules_array($rules){
    $newrules = array();
    $newrules = jsst_generate_rewrite_rules($rules, '(.?.+?)(?:/([0-9]+))?/?$');
    $newrules += jsst_generate_rewrite_rules($rules, '(.?.+?)(/[0-9]+)?/?$');
    return $newrules + $rules;
}
add_filter('page_rewrite_rules', 'jsst_page_rewrite_rules_array');

function jsst_rewrite_rules( $wp_rewrite ) {
      // Hooks params
      $rules = array();
      // Homepage params
      $pageid = get_option('page_on_front');
      $changename = false;
      if(file_exists(WP_PLUGIN_DIR.'/js-jobs/js-jobs.php')){
          $changename = true;
      }
      if(file_exists(WP_PLUGIN_DIR.'/js-vehicle-manager/js-vehicle-manager.php')){
          $changename = true;
      }
      $add_message = ($changename === true) ? 'st-ticket-add-message' : 'st-add-message';
      $message_inbox = ($changename === true) ? 'st-ticket-message-inbox' : 'st-message-inbox';
      $login = ($changename === true) ? 'st-ticket-login' : 'st-login';
      $message = ($changename === true) ? 'st-ticket-message' : 'st-message';
      $my_profile = ($changename === true) ? 'st-ticket-my-profile' : 'st-my-profile';
      $message_outbox = ($changename === true) ? 'st-ticket-message-outbox' : 'st-message-outbox';
      $userregister = ($changename === true) ? 'ticket-user-register' : 'st-userregister';
      $rules['(st-staff-add-ticket|st-announcements|st-staff-feedbacks|st-visitor-message|st-role-permission|st-downloads|st-faqs|st-faq|st-add-department|st-announcement|st-add-announcement|st-add-download|st-add-faq|st-add-article|st-add-category|st-kb-articles|st-kb-article|'.$add_message.'|'.$message.'|'.$message_inbox.'|'.$message_outbox.'|'.$userregister.'|st-add-role|st-add-staff|st-staff-permissions|st-my-tickets|st-staff-my-tickets|st-add-ticket|'.$login.'|st-ticket-status|st-staff-announcements|st-departments|st-staff-downloads|st-staff-faqs|st-control-panel|st-staff-kb-articles|st-staff-categories|st-knowledgebase|st-roles|'.$my_profile.'|st-staffs|st-staff-reports|st-department-reports|st-feed-back|st-print-ticket|st-staff-report|st-ticket)(/[^/]*)?(/[^/]*)?(/[^/]*)?/?$'] = 'index.php?page_id='.$pageid.'&jsstlayout=$matches[1]&jst1=$matches[2]&jst2=$matches[3]&jst3=$matches[4]';
      $wp_rewrite->rules = $rules + $wp_rewrite->rules;
      return $wp_rewrite->rules;
}
add_filter( 'generate_rewrite_rules', 'jsst_rewrite_rules' );

function jsst_query_var( $qvars ) {
    $qvars[] = 'jsstlayout';
    $qvars[] = 'jst1';
    $qvars[] = 'jst2';
    $qvars[] = 'jst3';
    return $qvars;
}
add_filter( 'query_vars', 'jsst_query_var' , 10, 1 );

function jsst_parse_request($q) {
    // echo '<pre style="color:#000;">';print_r($q->query_vars);echo '</pre>';
    if(isset($q->query_vars['jsstlayout']) && !empty($q->query_vars['jsstlayout'])){
        $layout = $q->query_vars['jsstlayout'];
        if(substr($layout, 0, 3) == 'st-'){
            $layout = substr($layout,3);
        }
        switch ($layout) {
            case 'ticket':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'ticket';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'ticketdetail';
                jssupportticket::$_data['sanitized_args']['jssupportticketid'] = str_replace('/', '',$q->query_vars['jst1']);
            break;
            case 'staff-add-ticket':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'agent';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'staffaddticket';
                if(!empty($q->query_vars['jst1'])){
                    jssupportticket::$_data['sanitized_args']['jssupportticketid'] = str_replace('/', '',$q->query_vars['jst1']);
                }
            break;
            case 'announcements':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'announcement';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'announcements';
                if(!empty($q->query_vars['jst1'])){
                    jssupportticket::$_data['sanitized_args']['jssupportticketid'] = str_replace('/', '',$q->query_vars['jst1']);
                }
            break;
            case 'staff-feedbacks':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'feedback';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'feedbacks';
            break;
            case 'visitor-message':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'ticket';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'visitormessagepage';
            break;
            case 'role-permission':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'role';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'rolepermission';
                if(!empty($q->query_vars['jst1'])){
                    jssupportticket::$_data['sanitized_args']['jssupportticketid'] = str_replace('/', '',$q->query_vars['jst1']);
                }
            break;
            case 'roles':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'role';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'roles';
                if(!empty($q->query_vars['jst1'])){
                    jssupportticket::$_data['sanitized_args']['jssupportticketid'] = str_replace('/', '',$q->query_vars['jst1']);
                }
            break;
            case 'ticket-my-profile':
            case 'my-profile':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'agent';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'myprofile';
                if(!empty($q->query_vars['jst1'])){
                    jssupportticket::$_data['sanitized_args']['jssupportticketid'] = str_replace('/', '',$q->query_vars['jst1']);
                }
            break;
            case 'staffs':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'agent';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'staffs';
                if(!empty($q->query_vars['jst1'])){
                    jssupportticket::$_data['sanitized_args']['jssupportticketid'] = str_replace('/', '',$q->query_vars['jst1']);
                }
            break;
            case 'staff-reports':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'reports';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'staffreports';
                if(!empty($q->query_vars['jst1'])){
                    jssupportticket::$_data['sanitized_args']['jssupportticketid'] = str_replace('/', '',$q->query_vars['jst1']);
                }
            break;
            case 'department-reports':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'reports';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'departmentreports';
                if(!empty($q->query_vars['jst1'])){
                    jssupportticket::$_data['sanitized_args']['jssupportticketid'] = str_replace('/', '',$q->query_vars['jst1']);
                }
            break;
            case 'feed-back':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'feedback';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'formfeedback';
                if(!empty($q->query_vars['jst1'])){
                    jssupportticket::$_data['sanitized_args']['token'] = str_replace('/', '',$q->query_vars['jst1']);
                }
            break;
            case 'print-ticket':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'ticket';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'printticket';
                if(!empty($q->query_vars['jst1'])){
                    jssupportticket::$_data['sanitized_args']['jssupportticketid'] = str_replace('/', '',$q->query_vars['jst1']);
                }
            break;
            case 'staff-report':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'reports';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'staffdetailreport';
                if(!empty($q->query_vars['jst1'])){
                    jssupportticket::$_data['sanitized_args']['jsst-id'] = str_replace('/', '',$q->query_vars['jst1']);
                }
                if(!empty($q->query_vars['jst2'])){
                    $date = str_replace('/', '',$q->query_vars['jst2']);
                    if(strstr($date, 'date-start')){
                        $date = str_replace('date-start:', '', $date);
                        jssupportticket::$_data['sanitized_args']['jsst-date-start'] = $date;
                    }
                    if(strstr($date, 'date-end')){
                        $date = str_replace('date-end:', '', $date);
                        jssupportticket::$_data['sanitized_args']['jsst-date-end'] = $date;
                    }
                }
                if(!empty($q->query_vars['jst3'])){
                    $date = str_replace('/', '',$q->query_vars['jst3']);
                    if(strstr($date, 'date-start')){
                        $date = str_replace('date-start:', '', $date);
                        jssupportticket::$_data['sanitized_args']['jsst-date-start'] = $date;
                    }
                    if(strstr($date, 'date-end')){
                        $date = str_replace('date-end:', '', $date);
                        jssupportticket::$_data['sanitized_args']['jsst-date-end'] = $date;
                    }
                }
            break;
            case 'downloads':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'download';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'downloads';
                if(!empty($q->query_vars['jst1'])){
                    jssupportticket::$_data['sanitized_args']['jssupportticketid'] = str_replace('/', '',$q->query_vars['jst1']);
                }
            break;
            case 'faqs':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'faq';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'faqs';
                if(!empty($q->query_vars['jst1'])){
                    jssupportticket::$_data['sanitized_args']['jssupportticketid'] = str_replace('/', '',$q->query_vars['jst1']);
                }
            break;
            case 'faq':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'faq';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'faqdetails';
                jssupportticket::$_data['sanitized_args']['jssupportticketid'] = str_replace('/', '',$q->query_vars['jst1']);
            break;
            case 'add-department':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'department';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'adddepartment';
                if(!empty($q->query_vars['jst1'])){
                    jssupportticket::$_data['sanitized_args']['jssupportticketid'] = str_replace('/', '',$q->query_vars['jst1']);
                }
            break;
            case 'add-announcement':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'announcement';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'addannouncement';
                if(!empty($q->query_vars['jst1'])){
                    jssupportticket::$_data['sanitized_args']['jssupportticketid'] = str_replace('/', '',$q->query_vars['jst1']);
                }
            break;
            case 'add-download':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'download';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'adddownload';
                if(!empty($q->query_vars['jst1'])){
                    jssupportticket::$_data['sanitized_args']['jssupportticketid'] = str_replace('/', '',$q->query_vars['jst1']);
                }
            break;
            case 'add-faq':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'faq';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'addfaq';
                if(!empty($q->query_vars['jst1'])){
                    jssupportticket::$_data['sanitized_args']['jssupportticketid'] = str_replace('/', '',$q->query_vars['jst1']);
                }
            break;
            case 'add-article':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'knowledgebase';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'addarticle';
                if(!empty($q->query_vars['jst1'])){
                    jssupportticket::$_data['sanitized_args']['jssupportticketid'] = str_replace('/', '',$q->query_vars['jst1']);
                }
            break;
            case 'add-category':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'knowledgebase';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'addcategory';
                if(!empty($q->query_vars['jst1'])){
                    jssupportticket::$_data['sanitized_args']['jssupportticketid'] = str_replace('/', '',$q->query_vars['jst1']);
                }
            break;
            case 'kb-articles':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'knowledgebase';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'userknowledgebasearticles';
                if(!empty($q->query_vars['jst1'])){
                    jssupportticket::$_data['sanitized_args']['jssupportticketid'] = str_replace('/', '',$q->query_vars['jst1']);
                }
            break;
            case 'kb-article':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'knowledgebase';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'articledetails';
                if(!empty($q->query_vars['jst1'])){
                    jssupportticket::$_data['sanitized_args']['jssupportticketid'] = str_replace('/', '',$q->query_vars['jst1']);
                }
            break;
            case 'add-message':
            case 'ticket-add-message':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'mail';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'formmessage';
                if(!empty($q->query_vars['jst1'])){
                    jssupportticket::$_data['sanitized_args']['jssupportticketid'] = str_replace('/', '',$q->query_vars['jst1']);
                }
            break;
            case 'ticket-message':
            case 'message':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'mail';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'message';
                if(!empty($q->query_vars['jst1'])){
                    jssupportticket::$_data['sanitized_args']['jssupportticketid'] = str_replace('/', '',$q->query_vars['jst1']);
                }
            break;
            case 'ticket-message-inbox':
            case 'message-inbox':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'mail';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'inbox';
                if(!empty($q->query_vars['jst1'])){
                    jssupportticket::$_data['sanitized_args']['jssupportticketid'] = str_replace('/', '',$q->query_vars['jst1']);
                }
            break;
            case 'ticket-message-outbox':
            case 'message-outbox':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'mail';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'outbox';
                if(!empty($q->query_vars['jst1'])){
                    jssupportticket::$_data['sanitized_args']['jssupportticketid'] = str_replace('/', '',$q->query_vars['jst1']);
                }
            break;
            case 'ticket-login':
            case 'login':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'jssupportticket';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'login';
            break;
            case 'ticket-user-register':
            case 'userregister':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'jssupportticket';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'userregister';
            break;
            case 'add-role':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'role';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'addrole';
                if(!empty($q->query_vars['jst1'])){
                    jssupportticket::$_data['sanitized_args']['jssupportticketid'] = str_replace('/', '',$q->query_vars['jst1']);
                }
            break;
            case 'add-staff':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'agent';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'addstaff';
                if(!empty($q->query_vars['jst1'])){
                    jssupportticket::$_data['sanitized_args']['jssupportticketid'] = str_replace('/', '',$q->query_vars['jst1']);
                }
            break;
            case 'staff-permissions':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'agent';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'staffpermissions';
                if(!empty($q->query_vars['jst1'])){
                    jssupportticket::$_data['sanitized_args']['jssupportticketid'] = str_replace('/', '',$q->query_vars['jst1']);
                }
            break;
            case 'staff-announcements':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'announcement';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'staffannouncements';
                if(!empty($q->query_vars['jst1'])){
                    jssupportticket::$_data['sanitized_args']['jssupportticketid'] = str_replace('/', '',$q->query_vars['jst1']);
                }
            break;
            case 'departments':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'department';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'departments';
                if(!empty($q->query_vars['jst1'])){
                    jssupportticket::$_data['sanitized_args']['jssupportticketid'] = str_replace('/', '',$q->query_vars['jst1']);
                }
            break;
            case 'staff-downloads':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'download';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'staffdownloads';
                if(!empty($q->query_vars['jst1'])){
                    jssupportticket::$_data['sanitized_args']['jssupportticketid'] = str_replace('/', '',$q->query_vars['jst1']);
                }
            break;
            case 'staff-faqs':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'faq';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'stafffaqs';
                if(!empty($q->query_vars['jst1'])){
                    jssupportticket::$_data['sanitized_args']['jssupportticketid'] = str_replace('/', '',$q->query_vars['jst1']);
                }
            break;
            case 'control-panel':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'jssupportticket';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'controlpanel';
                if(!empty($q->query_vars['jst1'])){
                    jssupportticket::$_data['sanitized_args']['jssupportticketid'] = str_replace('/', '',$q->query_vars['jst1']);
                }
            break;
            case 'staff-kb-articles':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'knowledgebase';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'stafflistarticles';
                if(!empty($q->query_vars['jst1'])){
                    jssupportticket::$_data['sanitized_args']['jssupportticketid'] = str_replace('/', '',$q->query_vars['jst1']);
                }
            break;
            case 'staff-categories':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'knowledgebase';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'stafflistcategories';
                if(!empty($q->query_vars['jst1'])){
                    jssupportticket::$_data['sanitized_args']['jssupportticketid'] = str_replace('/', '',$q->query_vars['jst1']);
                }
            break;
            case 'knowledgebase':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'knowledgebase';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'userknowledgebase';
                if(!empty($q->query_vars['jst1'])){
                    jssupportticket::$_data['sanitized_args']['jssupportticketid'] = str_replace('/', '',$q->query_vars['jst1']);
                }
            break;
            case 'ticket-status':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'ticket';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'ticketstatus';
            break;
            case 'add-ticket':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'ticket';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'addticket';
                if(!empty($q->query_vars['jst1'])){
                    jssupportticket::$_data['sanitized_args']['jssupportticketid'] = str_replace('/', '',$q->query_vars['jst1']);
                }
            break;
            case 'my-tickets':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'ticket';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'myticket';
            break;
            case 'staff-my-tickets':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'agent';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'staffmyticket';
            break;
            case 'announcement':
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'announcement';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'announcementdetails';
                jssupportticket::$_data['sanitized_args']['jssupportticketid'] = str_replace('/', '',$q->query_vars['jst1']);
            break;
            default:
                jssupportticket::$_data['sanitized_args']['jstmod'] = 'jssupportticket';
                jssupportticket::$_data['sanitized_args']['jstlay'] = 'controlpanel';
            break;
        }
    }
}
add_action('parse_request', 'jsst_parse_request');

function jsst_redirect_canonical($redirect_url, $requested_url) {
    global $wp_rewrite;
    if(is_home() || is_front_page()){
        $array = array('/st-ticket','/st-staff-add-ticket','/st-announcements','/st-staff-feedbacks','/st-visitor-message','/st-role-permission','/st-downloads','/st-faqs','/st-faq','/st-announcement','/st-add-announcement','/st-add-department','/st-add-download','/st-add-faq'
            ,'/st-add-article','/st-add-category','/st-kb-articles','/st-kb-article','/st-ticket-add-message','/st-add-message','/st-message','/st-ticket-message','/st-message-inbox','/st-ticket-message-inbox','/st-message-outbox','/st-ticket-message-outbox','/st-add-role','/st-add-staff','/st-staff-permissions','/st-my-tickets','/st-staff-my-tickets','/st-knowledgebase'
            ,'/st-departments','/st-roles','/st-staff-categories','/st-staffs','/st-staff-kb-articles','/st-staff-announcements','/st-staff-downloads','/st-staff-faqs','/st-add-ticket','/st-login','/st-userregister','/st-ticket-login','/st-ticket-user-register','/st-ticket-status'
            ,'/st-control-panel','/st-my-profile','/st-ticket-my-profile','/st-staff-report','/st-staff-reports','/st-department-reports','/st-feed-back', '/st-print-ticket');
        $ret = false;
        foreach($array AS $layout){
            if(strstr($requested_url, $layout)){
                $ret = true;
                break;
            }
        }
        if($ret == true){
            return $requested_url;
        }
    }
      return $redirect_url;
}
add_filter('redirect_canonical', 'jsst_redirect_canonical', 11, 2);

?>

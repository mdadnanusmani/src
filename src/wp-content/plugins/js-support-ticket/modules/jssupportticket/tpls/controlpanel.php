<?php
wp_enqueue_script( 'ticket-notify-app', 'https://www.gstatic.com/firebasejs/5.8.2/firebase-app.js' );
wp_enqueue_script( 'ticket-notify-message', 'https://www.gstatic.com/firebasejs/5.8.2/firebase-messaging.js' );
do_action('ticket-notify-generate-token'); ?>
<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1','packages':['corechart']}]}"></script>
<script>
    google.setOnLoadCallback(drawStackChartHorizontal);
    function drawStackChartHorizontal() {
      var data = google.visualization.arrayToDataTable([
        <?php
            echo jssupportticket::$_data['stack_chart_horizontal']['title'].',';
            echo jssupportticket::$_data['stack_chart_horizontal']['data'];
        ?>
      ]);

      var view = new google.visualization.DataView(data);

      var options = {
        height:250,
        legend: { position: 'top', maxLines: 3 },
        bar: { groupWidth: '75%' },
        isStacked: true,
        colors:<?php echo jssupportticket::$_data['stack_chart_horizontal']['colors']; ?>,
      };
      var chart = new google.visualization.BarChart(document.getElementById("stack_chart_horizontal"));
      chart.draw(view, options);
    }
</script>
<?php

if (jssupportticket::$_config['offline'] == 2) {
    JSSTmessage::getMessage();
    include_once(jssupportticket::$_path . 'includes/header.php');
    $agent_flag = 0;
    if(in_array('agent',jssupportticket::$_active_addons)){
        if (JSSTincluder::getJSModel('agent')->isUserStaff()) {
            $agent_flag = 1;
        }
    }

    if ($agent_flag == 0) {
        $count = JSSTincluder::getJSModel('configuration')->getCountByConfigFor('cplink');
        if($count != 0){ ?>
            <div id="js-dash-menu-link-wrp"><!-- Dashboard Links -->
                <div class="js-section-heading"><?php echo __('Dashboard Links','js-support-ticket'); ?></div>
                <div class="js-menu-links-wrp">
                    <?php
                    $count = 0;
                    /*<div class="js-ticket-menu-links-row">*/
                    if (jssupportticket::$_config['cplink_openticket_user'] == 1):
                        $menu_url = esc_url(jssupportticket::makeUrl(array('jstmod'=>'ticket', 'jstlay'=>'addticket')));
                        $image_path = jssupportticket::$_pluginpath . 'includes/images/dashboard-icon/add-ticket.png';
                        $menu_title =  __('New Ticket', 'js-support-ticket');
                        printMenuLink($menu_title, $menu_url, $image_path,$count);
                    endif;
                    if (jssupportticket::$_config['cplink_myticket_user'] == 1):
                        $menu_url = esc_url(jssupportticket::makeUrl(array('jstmod'=>'ticket', 'jstlay'=>'myticket')));
                        $image_path = jssupportticket::$_pluginpath . 'includes/images/dashboard-icon/my-tickets.png';
                        $menu_title =  __('My Tickets', 'js-support-ticket');
                        printMenuLink($menu_title, $menu_url, $image_path,$count);
                    endif;
                    if (jssupportticket::$_config['cplink_checkticketstatus_user'] == 1):
                        $menu_url = esc_url(jssupportticket::makeUrl(array('jstmod'=>'ticket', 'jstlay'=>'ticketstatus')));
                        $image_path = jssupportticket::$_pluginpath . 'includes/images/dashboard-icon/ticket-status.png';
                        $menu_title =  __('Ticket Status', 'js-support-ticket');
                        printMenuLink($menu_title, $menu_url, $image_path,$count);
                    endif;
					if (in_array('announcement', jssupportticket::$_active_addons) && jssupportticket::$_config['cplink_announcements_user'] == 1):
					   $menu_url = esc_url(jssupportticket::makeUrl(array('jstmod'=>'announcement', 'jstlay'=>'announcements')));
                        $image_path = jssupportticket::$_pluginpath . 'includes/images/dashboard-icon/announcments.png';
                        $menu_title =  __('Announcements', 'js-support-ticket');
                        printMenuLink($menu_title, $menu_url, $image_path,$count);
                    endif;
                    if (in_array('download', jssupportticket::$_active_addons) && jssupportticket::$_config['cplink_downloads_user'] == 1):
                        $menu_url = esc_url(jssupportticket::makeUrl(array('jstmod'=>'download', 'jstlay'=>'downloads')));
                        $image_path = jssupportticket::$_pluginpath . 'includes/images/dashboard-icon/downloads.png';
                        $menu_title =  __('Downloads', 'js-support-ticket');
                        printMenuLink($menu_title, $menu_url, $image_path,$count);
                    endif;
                    if (in_array('faq', jssupportticket::$_active_addons) &&  jssupportticket::$_config['cplink_faqs_user'] == 1):
                        $menu_url = esc_url(jssupportticket::makeUrl(array('jstmod'=>'faq', 'jstlay'=>'faqs')));
                        $image_path = jssupportticket::$_pluginpath . 'includes/images/dashboard-icon/faq.png';
                        $menu_title =  __("FAQ's", 'js-support-ticket');
                        printMenuLink($menu_title, $menu_url, $image_path,$count);
                    endif;
                    if (in_array('knowledgebase', jssupportticket::$_active_addons) &&  jssupportticket::$_config['cplink_knowledgebase_user'] == 1):
                        $menu_url = esc_url(jssupportticket::makeUrl(array('jstmod'=>'knowledgebase', 'jstlay'=>'userknowledgebase')));
                        $image_path = jssupportticket::$_pluginpath . 'includes/images/dashboard-icon/k.b.png';
                        $menu_title =  __('Knowledge Base', 'js-support-ticket');
                        printMenuLink($menu_title, $menu_url, $image_path,$count);
                    endif;
                    if (jssupportticket::$_config['cplink_login_logout_user'] == 1){
                        $loginval = JSSTincluder::getJSModel('configuration')->getConfigValue('set_login_link');
                        $loginlink = JSSTincluder::getJSModel('configuration')->getConfigValue('login_link');
                         if ($loginval == 2 && $loginlink != ""){
                                $hreflink = $loginlink;
                            }else{
                                $hreflink= jssupportticket::makeUrl(array('jstmod'=>'jssupportticket', 'jstlay'=>'login'));
                            }
                            if (!is_user_logged_in()):
                                $menu_url = $hreflink;
                                $image_path = jssupportticket::$_pluginpath . 'includes/images/dashboard-icon/login.png';
                                $menu_title =  __('Log In', 'js-support-ticket');
                                printMenuLink($menu_title, $menu_url, $image_path,$count);
                            endif;
                        if (is_user_logged_in()):
                            $menu_url = wp_logout_url( home_url() );
                            $image_path = jssupportticket::$_pluginpath . 'includes/images/dashboard-icon/logout.png';
                            $menu_title =  __('Log Out', 'js-support-ticket');
                            printMenuLink($menu_title, $menu_url, $image_path,$count);
                        endif;
                    }
                    if (jssupportticket::$_config['cplink_register_user'] == 1){
                        if (!is_user_logged_in()):
                            $is_enable = get_option('users_can_register'); /*check to make sure user registration is enabled*/
                            if ($is_enable) {// only show the registration form if allowed
                                $menu_url = esc_url(jssupportticket::makeUrl(array('jstmod'=>'jssupportticket', 'jstlay'=>'userregister')));
                                $image_path = jssupportticket::$_pluginpath . 'includes/images/dashboard-icon/userregister.png';
                                $menu_title =  __('Register', 'js-support-ticket');
                                printMenuLink($menu_title, $menu_url, $image_path,$count);
                            }
                        endif;
                    }

                    if($count != 0){
                        echo '</div>';// to close the last div of print menu link fuctinon
                    }
                    ?>

                </div>
            </div>
        <?php
        }
    }
    if ( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()) {
        if (jssupportticket::$_config['cplink_totalcount_staff'] == 1): ?>
            <div id="js-total-count-cp"> <!-- Count Box -->
                <a class="js-ticket-count-wrp" href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'agent', 'jstlay'=>'staffmyticket'))); ?>" title="cp-link">
                    <div class="js-total-count js-ticket">
                        <img alt="image" class="img" src="<?php echo jssupportticket::$_pluginpath; ?>/includes/images/dashboard-icon/1-mytickets.png" />
                        <div class="data">
                            <span class="jstotal js-ticket-total"><?php echo jssupportticket::$_data['total_tickets']['total_ticket']; ?></span>
                            <span class="jsstatus js-ticket-status"><?php echo __('Tickets','js-support-ticket'); ?></span>
                        </div>
                    </div>
                </a>
                <a class="js-ticket-count-wrp" href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'department', 'jstlay'=>'departments'))); ?> " title="cp-link">
                    <div class="js-total-count js-department">
                        <img alt="image" class="img" src="<?php echo jssupportticket::$_pluginpath; ?>/includes/images/dashboard-icon/1-departments.png" />
                        <div class="data">
                            <span class="jstotal js-department-total"><?php echo jssupportticket::$_data['total_tickets']['total_department']; ?></span>
                            <span class="jsstatus js-department-status"><?php echo __('Department','js-support-ticket'); ?></span>
                        </div>
                    </div>
                </a>
                <a class="js-ticket-count-wrp" href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'agent', 'jstlay'=>'staffs'))); ?>" title="cp-link">
                    <div class="js-total-count js-staff">
                        <img alt="image" class="img" src="<?php echo jssupportticket::$_pluginpath; ?>/includes/images/dashboard-icon/1-staff.png" />
                        <div class="data">
                            <span class="jstotal js-staff-total"><?php echo jssupportticket::$_data['total_tickets']['total_staff']; ?></span>
                            <span class="jsstatus js-staff-status"><?php echo __('Staff Members','js-support-ticket'); ?></span>
                        </div>
                    </div>
                </a>
                <?php if( jssupportticket::$_config['cplink_feedback_staff'] == 1 && in_array('feedback', jssupportticket::$_active_addons)){ ?>
                    <a class="js-ticket-count-wrp" href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'feedback', 'jstlay'=>'feedbacks'))); ?>" title="cp-link">
                        <div class="js-total-count js-feedback">
                            <img alt="image" class="img" src="<?php echo jssupportticket::$_pluginpath; ?>/includes/images/dashboard-icon/1-feedback.png" />
                            <div class="data">
                                <span class="jstotal js-feedback-total"><?php echo jssupportticket::$_data['total_tickets']['total_feedback']; ?></span>
                                <span class="jsstatus js-feedback-status"><?php echo __('Feedback','js-support-ticket'); ?></span>
                            </div>
                        </div>
                    </a>
                <?php } ?>
            </div>
        <?php endif;
        if (jssupportticket::$_config['cplink_ticketstats_staff'] == 1): ?>
            <div class="js-pm-graphtitle-wrp"><!-- Ticket Stats -->
                <div class="js-pm-graphtitle">
                    <?php echo __('Ticket Statistics', 'js-support-ticket'); ?>
                </div>
                <div id="js-pm-grapharea">
                    <div id="stack_chart_horizontal" style="width:100%;"></div>
                </div>
            </div>
        <?php endif;
        $count = JSSTincluder::getJSModel('configuration')->getCountByConfigFor('cplink');
        if($count != 0){ ?>
            <div id="js-dash-menu-link-wrp">
                <div class="js-section-heading"><?php echo __('Section One','js-support-ticket'); ?></div>
                <div class="js-menu-links-wrp">  <!-- Dashboard Links -->
                    <div class="js-ticket-menu-links-row">
                        <?php
                        $count = 0;
                        if (jssupportticket::$_config['cplink_openticket_staff'] == 1):
                            $menu_url = esc_url(jssupportticket::makeUrl(array('jstmod'=>'agent', 'jstlay'=>'staffaddticket')));
                            $image_path = jssupportticket::$_pluginpath . 'includes/images/dashboard-icon/add-ticket.png';
                            $menu_title =  __('New Ticket', 'js-support-ticket');
                            printMenuLink($menu_title, $menu_url, $image_path,$count);
                        endif;
                        if (jssupportticket::$_config['cplink_myticket_staff'] == 1):
                            $menu_url = esc_url(jssupportticket::makeUrl(array('jstmod'=>'agent', 'jstlay'=>'staffmyticket')));
                            $image_path = jssupportticket::$_pluginpath . 'includes/images/dashboard-icon/my-tickets.png';
                            $menu_title =  __('My Tickets', 'js-support-ticket');
                            printMenuLink($menu_title, $menu_url, $image_path,$count);
                        endif;
                        if (jssupportticket::$_config['cplink_roles_staff'] == 1):
                            $menu_url = esc_url(jssupportticket::makeUrl(array('jstmod'=>'role', 'jstlay'=>'roles')));
                            $image_path = jssupportticket::$_pluginpath . 'includes/images/dashboard-icon/roles.png';
                            $menu_title =  __('Roles', 'js-support-ticket');
                            printMenuLink($menu_title, $menu_url, $image_path,$count);
                        endif;
                        if (jssupportticket::$_config['cplink_staff_staff'] == 1):
                            $menu_url = esc_url(jssupportticket::makeUrl(array('jstmod'=>'agent', 'jstlay'=>'staffs')));
                            $image_path = jssupportticket::$_pluginpath . 'includes/images/dashboard-icon/staff-members.png';
                            $menu_title =  __('Staff', 'js-support-ticket');
                            printMenuLink($menu_title, $menu_url, $image_path,$count);
                        endif;
                        if (jssupportticket::$_config['cplink_department_staff'] == 1):
                            $menu_url = esc_url(jssupportticket::makeUrl(array('jstmod'=>'department', 'jstlay'=>'departments')));
                            $image_path = jssupportticket::$_pluginpath . 'includes/images/dashboard-icon/department.png';
                            $menu_title =  __('Departments', 'js-support-ticket');
                            printMenuLink($menu_title, $menu_url, $image_path,$count);
                        endif;
                        if (in_array('knowledgebase', jssupportticket::$_active_addons) && jssupportticket::$_config['cplink_category_staff'] == 1):
                            $menu_url = esc_url(jssupportticket::makeUrl(array('jstmod'=>'knowledgebase', 'jstlay'=>'stafflistcategories')));
                            $image_path = jssupportticket::$_pluginpath . 'includes/images/dashboard-icon/categories.png';
                            $menu_title =  __('Categories', 'js-support-ticket');
                            printMenuLink($menu_title, $menu_url, $image_path,$count);
                        endif;
                        if (in_array('knowledgebase', jssupportticket::$_active_addons) && jssupportticket::$_config['cplink_kbarticle_staff'] == 1):
                            $menu_url = esc_url(jssupportticket::makeUrl(array('jstmod'=>'knowledgebase', 'jstlay'=>'stafflistarticles')));
                            $image_path = jssupportticket::$_pluginpath . 'includes/images/dashboard-icon/k.b.png';
                            $menu_title =  __('Knowledge Base', 'js-support-ticket');
                            printMenuLink($menu_title, $menu_url, $image_path,$count);
                        endif;
                        if (in_array('download', jssupportticket::$_active_addons) && jssupportticket::$_config['cplink_download_staff'] == 1):
                            $menu_url = esc_url(jssupportticket::makeUrl(array('jstmod'=>'download', 'jstlay'=>'staffdownloads')));
                            $image_path = jssupportticket::$_pluginpath . 'includes/images/dashboard-icon/downloads.png';
                            $menu_title =  __('Downloads', 'js-support-ticket');
                            printMenuLink($menu_title, $menu_url, $image_path,$count);
                        endif;
                        if (in_array('announcement', jssupportticket::$_active_addons) && jssupportticket::$_config['cplink_announcement_staff'] == 1):
                            $menu_url = esc_url(jssupportticket::makeUrl(array('jstmod'=>'announcement', 'jstlay'=>'staffannouncements')));
                            $image_path = jssupportticket::$_pluginpath . 'includes/images/dashboard-icon/announcments.png';
                            $menu_title =  __('Announcements', 'js-support-ticket');
                            printMenuLink($menu_title, $menu_url, $image_path,$count);
                        endif;
                        if (in_array('faq', jssupportticket::$_active_addons) && jssupportticket::$_config['cplink_faq_staff'] == 1):
                            $menu_url = esc_url(jssupportticket::makeUrl(array('jstmod'=>'faq', 'jstlay'=>'stafffaqs')));
                            $image_path = jssupportticket::$_pluginpath . 'includes/images/dashboard-icon/faq.png';
                            $menu_title =  __("FAQ's", 'js-support-ticket');
                            printMenuLink($menu_title, $menu_url, $image_path,$count);
                        endif;
                        if (in_array('mail', jssupportticket::$_active_addons) && jssupportticket::$_config['cplink_mail_staff'] == 1):
                            $menu_url = esc_url(jssupportticket::makeUrl(array('jstmod'=>'mail', 'jstlay'=>'inbox')));
                            $image_path = jssupportticket::$_pluginpath . 'includes/images/dashboard-icon/email.png';
                            $menu_title =  __('Mail', 'js-support-ticket');
                            printMenuLink($menu_title, $menu_url, $image_path,$count);
                        endif;
                        if (jssupportticket::$_config['cplink_staff_report_staff'] == 1):
                            $menu_url = esc_url(jssupportticket::makeUrl(array('jstmod'=>'reports', 'jstlay'=>'staffreports')));
                            $image_path = jssupportticket::$_pluginpath . 'includes/images/dashboard-icon/staff-reports.png';
                            $menu_title =  __('Staff Reports', 'js-support-ticket');
                            printMenuLink($menu_title, $menu_url, $image_path,$count);
                        endif;
                        if (jssupportticket::$_config['cplink_department_report_staff'] == 1):
                            $menu_url = esc_url(jssupportticket::makeUrl(array('jstmod'=>'reports', 'jstlay'=>'departmentreports')));
                            $image_path = jssupportticket::$_pluginpath . 'includes/images/dashboard-icon/department-reports.png';
                            $menu_title =  __('Department Reports', 'js-support-ticket');
                            printMenuLink($menu_title, $menu_url, $image_path,$count);
                        endif;
                        if (in_array('feedback', jssupportticket::$_active_addons) && jssupportticket::$_config['cplink_feedback_staff'] == 1):
                            $menu_url = esc_url(jssupportticket::makeUrl(array('jstmod'=>'feedback', 'jstlay'=>'feedbacks')));
                            $image_path = jssupportticket::$_pluginpath . 'includes/images/dashboard-icon/feed-back.png';
                            $menu_title =  __('Staff Feedbacks', 'js-support-ticket');
                            printMenuLink($menu_title, $menu_url, $image_path,$count);
                        endif;
                        if (jssupportticket::$_config['cplink_myprofile_staff'] == 1):
                            $menu_url = esc_url(jssupportticket::makeUrl(array('jstmod'=>'agent', 'jstlay'=>'myprofile')));
                            $image_path = jssupportticket::$_pluginpath . 'includes/images/dashboard-icon/login.png';
                            $menu_title =  __('My Profile', 'js-support-ticket');
                            printMenuLink($menu_title, $menu_url, $image_path,$count);
                        endif;
                        if (jssupportticket::$_config['cplink_login_logout_staff'] == 1){
                            if (!is_user_logged_in()):
                                $menu_url = $hreflink;
                                $image_path = jssupportticket::$_pluginpath . 'includes/images/dashboard-icon/profile.png';
                                $menu_title =  __('Log In', 'js-support-ticket');
                                printMenuLink($menu_title, $menu_url, $image_path,$count);
                            endif;
                            if (is_user_logged_in()):
                                $menu_url = wp_logout_url( home_url() );
                                $image_path = jssupportticket::$_pluginpath . 'includes/images/dashboard-icon/logout.png';
                                $menu_title =  __('Log Out', 'js-support-ticket');
                                printMenuLink($menu_title, $menu_url, $image_path,$count);
                            endif;
                        }
                        if($count != 0){
                            echo '</div>';// to close the last div of print menu link fuctinon
                        }
                        ?>
                    </div>
                </div>

            </div>
        <?php
        }?>
        <?php if (jssupportticket::$_config['cplink_latesttickets_staff'] == 1): ?>
            <div class="js-ticket-latest-ticket-wrapper js-pm-graphtitle-wrp">
                <div class="js-ticket-latest-ticket-header js-pm-graphtitle">
                    <?php echo __('Latest Ticket', 'js-support-ticket'); ?>
                </div>
                <?php if (!empty(jssupportticket::$_data['tickets'])) { ?>
                    <div class="js-ticket-latest-tickets-wrp">
                        <div class="js-ticket-latest-ticket-header-wrp js-pm-graphtitle">
                            <div class="js-ticket-row js-ticket-zero-padding">
                                <div class="js-ticket-first-left">
                                    <div class="js-ticket-header-title">
                                        <?php echo __('Title','js-support-ticket');?>
                                    </div>
                                </div>
                                <div class="js-ticket-second-left">
                                    <div class="js-ticket-header-name">
                                        <?php echo __('User','js-support-ticket');?>
                                    </div>
                                </div>
                                <div class="js-ticket-third-left">
                                    <div class="js-ticket-header-department">
                                        <?php echo __('Department','js-support-ticket');?>
                                    </div>
                                </div>
                                <div class="js-ticket-fourth-left">
                                    <div class="js-ticket-header-priorty">
                                        <?php echo __('Priority','js-support-ticket');?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php foreach (jssupportticket::$_data['tickets'] AS $ticket):?>
                            <div class="js-ticket-row">
                                <div class="js-ticket-first-left">
                                    <div class="js-ticket-user-img-wrp">
                                        <?php if ($ticket->staffphoto) { ?>
                                            <img alt="image" class="js-ticket-staff-img" src="<?php echo jssupportticket::makeUrl(array('jstmod'=>'agent','task'=>'getStaffPhoto','action'=>'jstask','jssupportticketid'=> $ticket->staffid ,'jsstpageid'=>get_the_ID()));?> ">
                                        <?php } else {
                                            if (isset($ticket->uid) && !empty($ticket->uid)) {
                                                echo get_avatar($ticket->uid);
                                            } else { ?>
                                                <img alt="image" class="js-ticket-staff-img" src="<?php echo jssupportticket::$_pluginpath . '/includes/images/ticketmanbig.png'; ?>" />
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                    <div class="js-ticket-ticket-subject">
                                        <span class="js-ticket-latest-ticket-heading"><?php echo __('Title','js-support-ticket') ?>:</span>
                                        <a href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'ticket','jstlay'=>'ticketdetail','jssupportticketid'=> $ticket->id))); ?>" class="js-ticket-subject-link"><?php echo $ticket->subject; ?></a>
                                    </div>
                                </div>
                                <div class="js-ticket-second-left">
                                    <div class="js-ticket-user-name">
                                        <span class="js-ticket-latest-ticket-heading"><?php echo __('User','js-support-ticket') ?>:</span>
                                        <a href="#" class="js-ticket-username-link"><?php echo $ticket->name; ?></a>
                                    </div>
                                </div>
                                <div class="js-ticket-third-left">
                                    <div class="js-ticket-department">
                                        <span class="js-ticket-latest-ticket-heading"><?php echo __('Department','js-support-ticket') ?>:</span>
                                        <a href="" class="js-ticket-department-link"><?php echo $ticket->departmentname; ?></a>
                                    </div>
                                </div>
                                <div class="js-ticket-fourth-left">
                                    <span class="js-ticket-latest-ticket-heading"><?php echo __('Priority','js-support-ticket') ?>:</span>
                                    <div class="js-ticket-priorty" style="background-color:<?php echo $ticket->prioritycolour; ?>;">
                                        <?php echo $ticket->priority; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php } else { // Record Not FOund
                    JSSTlayout::getNoRecordFound();
                }?><!-- Latest Tickets -->
            </div>
        <?php endif; ?>
    <?php }
    // Permission setting for notification


    } else {
        JSSTlayout::getSystemoffline();
    }

    function printMenuLink($title,$url,$image_path,&$count){
        $html = '';

        if(($count % 6) == 0){
            if($count != 0){
                $html .= '</div>';
            }
            $html .= '<div class="js-ticket-menu-links-row">';
        }

        $html .= '
        <a class="js-col-xs-12 js-col-sm-6 js-col-md-4 js-ticket-dash-menu" href="'.$url.'">
            <div class="js-ticket-dash-menu-icon">
                <img class="js-ticket-dash-menu-img" alt="menu-link-image" src="'.$image_path.'" />
            </div>
            <span class="js-ticket-dash-menu-text">'.$title.'</span>
        </a>';
        echo  $html;
        $count++;
        return;
    }

 ?>


























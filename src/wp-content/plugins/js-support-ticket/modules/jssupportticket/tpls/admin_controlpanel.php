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
<div id="jsstadmin-wrapper">
    <div id="jsstadmin-leftmenu">
        <?php  JSSTincluder::getClassesInclude('jsstadminsidemenu'); ?>
    </div>
    <div id="jsstadmin-data">
        <div id="js-main-cp-wrapper">
        <div id="js-main-head-cp">
            <div class="js-cptext"><?php echo __('Dashboard', 'js-support-ticket'); ?></div>
        </div>

        <div id="js-total-count-cp">
            <div class="js-total-count">
                <img class="img" src="<?php echo jssupportticket::$_pluginpath; ?>/includes/images/admincp/new.png" />
                <div class="data">
                    <span class="jstotal"><?php echo jssupportticket::$_data['ticket_total']['openticket']; ?></span>
                    <span class="jsstatus"><?php echo __('New','js-support-ticket'); ?></span>
                </div>
            </div>
            <div class="js-total-count">
                <img class="img" src="<?php echo jssupportticket::$_pluginpath; ?>/includes/images/admincp/answered.png" />
                <div class="data">
                    <span class="jstotal"><?php echo jssupportticket::$_data['ticket_total']['answeredticket']; ?></span>
                    <span class="jsstatus"><?php echo __('Answered','js-support-ticket'); ?></span>
                </div>
            </div>
            <div class="js-total-count">
                <img class="img" src="<?php echo jssupportticket::$_pluginpath; ?>/includes/images/admincp/pending.png" />
                <div class="data">
                    <span class="jstotal"><?php echo jssupportticket::$_data['ticket_total']['pendingticket']; ?></span>
                    <span class="jsstatus"><?php echo __('Pending','js-support-ticket'); ?></span>
                </div>
            </div>
            <div class="js-total-count">
                <img class="img" src="<?php echo jssupportticket::$_pluginpath; ?>/includes/images/admincp/overdue.png" />
                <div class="data">
                    <span class="jstotal"><?php echo jssupportticket::$_data['ticket_total']['overdueticket']; ?></span>
                    <span class="jsstatus"><?php echo __('Overdue','js-support-ticket'); ?></span>
                </div>
            </div>
        </div>

        <div id="js-pm-graphtitle">
            <img class="js-giamge" src="<?php echo jssupportticket::$_pluginpath; ?>/includes/images/admincp/menu-icon.png" />
            <?php echo __('Statistics', 'js-support-ticket'); ?>
            <small> <?php $curdate = date_i18n('Y-m-d'); $fromdate = date_i18n('Y-m-d', strtotime("now -1 month")); echo " ($fromdate - $curdate)"; ?> </small>
        </div>
        <div id="js-pm-grapharea">
            <div id="stack_chart_horizontal" style="width:100%;"></div>
        </div>

        <span class="js-admin-menus-head"><?php echo __('Admin', 'js-support-ticket'); ?></span>
        <div id="js-wrapper-menus">
            <a class="js-admin-menu-link" href="?page=ticket"> <img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/ticket.png"/><div class="jsmenu-text"><?php echo __('Tickets', 'js-support-ticket'); ?></div></a>
            <a class="js-admin-menu-link" href="?page=department"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/departments.png"/><div class="jsmenu-text"><?php echo __('Departments', 'js-support-ticket'); ?></div></a>
            <a class="js-admin-menu-link" href="?page=priority"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/priority.png"/><div class="jsmenu-text"><?php echo __('Priorities', 'js-support-ticket'); ?></div></a>
            <a class="js-admin-menu-link" href="?page=fieldordering&fieldfor=1"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/fieldordering.png"/><div class="jsmenu-text"><?php echo __('Fields', 'js-support-ticket'); ?></div></a>
            <a class="js-admin-menu-link" href="?page=configuration"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/configuration.png"/><div class="jsmenu-text"><?php echo __('Configurations', 'js-support-ticket'); ?></div></a>

            <a class="js-admin-menu-link" href="<?php echo admin_url('admin.php?page=reports&jstlay=overallreport'); ?>"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/overall-stats.png"/><div class="jsmenu-text"><?php echo __('Overall Statistics','js-support-ticket'); ?></div></a>
            <a class="js-admin-menu-link" href="<?php echo admin_url('admin.php?page=reports&jstlay=departmentreport'); ?>"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/department-reports.png"/><div class="jsmenu-text"><?php echo __('Department Reports','js-support-ticket'); ?></div></a>
            <a class="js-admin-menu-link" href="<?php echo admin_url('admin.php?page=reports&jstlay=userreport'); ?>"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/user-reports.png"/><div class="jsmenu-text"><?php echo __('User Reports', 'js-support-ticket'); ?></div></a>
            <a class="js-admin-menu-link" href="?page=email"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/system-email.png"/><div class="jsmenu-text"><?php echo __('System Emails', 'js-support-ticket'); ?></div></a>
            <a class="js-admin-menu-link" href="?page=emailtemplate"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/email_template.png"/><div class="jsmenu-text"><?php echo __('Email Templates', 'js-support-ticket'); ?></div></a>

        </div>
        <?php
        $field_array = JSSTincluder::getJSModel('fieldordering')->getFieldTitleByFieldfor(1);
        ?>
        <div id="js-pm-graphtitle" class="tickettitle"> <img class="js-giamge" src="<?php echo jssupportticket::$_pluginpath; ?>/includes/images/admincp/menu-icon.png" />
            <?php echo __('Latest Tickets', 'js-support-ticket'); ?>
        </div>
        <div class="js-ticket-admin-cp-tickets">
            <div class="js-row js-ticket-admin-cp-head js-ticket-admin-hide-head">
                <div class="js-col-xs-12 js-col-md-2"><?php echo __('Ticket ID', 'js-support-ticket'); ?></div>
                <div class="js-col-xs-12 js-col-md-3"><?php echo __($field_array['subject'], 'js-support-ticket'); ?></div>
                <div class="js-col-xs-12 js-col-md-1"><?php echo __($field_array['status'], 'js-support-ticket'); ?></div>
                <div class="js-col-xs-12 js-col-md-2"><?php echo __('From', 'js-support-ticket'); ?></div>
                <div class="js-col-xs-12 js-col-md-2"><?php echo __($field_array['priority'], 'js-support-ticket'); ?></div>
                <div class="js-col-xs-12 js-col-md-2"><?php echo __('Created', 'js-support-ticket'); ?></div>
            </div>
            <?php foreach (jssupportticket::$_data['tickets'] AS $ticket): ?>
                <div class="js-ticket-admin-cp-data">
                    <div class="js-col-xs-12 js-col-md-2"><span class="js-ticket-admin-cp-showhide"><?php echo __('Ticket ID', 'js-support-ticket');
            echo " : "; ?></span> <a href="<?php echo admin_url("admin.php?page=ticket&jstlay=ticketdetail&jssupportticketid=" . $ticket->id); ?>"><?php echo $ticket->ticketid; ?></a></div>
                    <div class="js-col-xs-12 js-col-md-3 js-admin-cp-text-elipses"><span class="js-ticket-admin-cp-showhide" ><?php echo __('Subject', 'js-support-ticket');
            echo " : "; ?></span> <?php echo $ticket->subject; ?></div>
                    <div class="js-col-xs-12 js-col-md-1">
                        <span class="js-ticket-admin-cp-showhide" ><?php echo __('Status', 'js-support-ticket');
            echo " : "; ?></span>
                        <?php
                        if ($ticket->status == 0) {
                            $style = "red;";
                            $status = __('New', 'js-support-ticket');
                        } elseif ($ticket->status == 1) {
                            $style = "orange;";
                            $status = __('Waiting Staff Reply', 'js-support-ticket');
                        } elseif ($ticket->status == 2) {
                            $style = "#FF7F50;";
                            $status = __('In Progress', 'js-support-ticket');
                        } elseif ($ticket->status == 3) {
                            $style = "green;";
                            $status = __('Waiting Your Reply', 'js-support-ticket');
                        } elseif ($ticket->status == 4) {
                            $style = "blue;";
                            $status = __('Closed', 'js-support-ticket');
                        }
                        echo '<span style="color:' . $style . '">' . $status . '</span>';
                        ?>
                    </div>
                    <div class="js-col-xs-12 js-col-md-2"> <span class="js-ticket-admin-cp-showhide" ><?php echo __('From', 'js-support-ticket');
                        echo " : "; ?></span> <?php echo $ticket->name; ?></div>
                    <div class="js-col-xs-12 js-col-md-2" style="color:<?php echo $ticket->prioritycolour; ?>;"> <span class="js-ticket-admin-cp-showhide" ><?php echo __('Priority', 'js-support-ticket');
            echo " : "; ?></span> <?php echo __($ticket->priority, 'js-support-ticket'); ?></div>
                    <div class="js-col-xs-12 js-col-md-2"><span class="js-ticket-admin-cp-showhide" ><?php echo __('Created', 'js-support-ticket');
            echo " : "; ?></span> <?php echo date_i18n(jssupportticket::$_config['date_format'], strtotime($ticket->created)); ?></div>
                </div>
        <?php endforeach; ?>
        </div>
        <?php if (!empty(jssupportticket::$_active_addons)) { ?>
            <span class="js-admin-menus-head"><?php echo __('Addon', 'js-support-ticket'); ?></span>
        <?php } ?>
        <div id="js-wrapper-menus">
            <?php if ( in_array('agent',jssupportticket::$_active_addons)) { ?>
                <a class="js-admin-menu-link" href="?page=agent"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/staffmembers.png"/><div class="jsmenu-text"><?php echo __('Staff Members', 'js-support-ticket'); ?></div></a>
            <?php } ?>
            <?php if(in_array('knowledgebase', jssupportticket::$_active_addons)){ ?>
                <a class="js-admin-menu-link" href="?page=knowledgebase&jstlay=listarticles"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/K_B.png"/><div class="jsmenu-text"><?php echo __('Knowledge Base', 'js-support-ticket'); ?></div></a>
            <?php } ?>

            <?php if(in_array('download', jssupportticket::$_active_addons)){ ?>
                <a class="js-admin-menu-link" href="?page=download"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/download1.png"/><div class="jsmenu-text"><?php echo __('Downloads', 'js-support-ticket'); ?></div></a>
            <?php } ?>

            <?php if(in_array('announcement', jssupportticket::$_active_addons)){ ?>
                <a class="js-admin-menu-link" href="?page=announcement"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/announcements.png"/><div class="jsmenu-text"><?php echo __('Announcements', 'js-support-ticket'); ?></div></a>
            <?php } ?>

            <?php if(in_array('faq', jssupportticket::$_active_addons)){ ?>
                <a class="js-admin-menu-link" href="?page=faq"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/Faq.png"/><div class="jsmenu-text"><?php echo __("FAQ's", 'js-support-ticket'); ?></div></a>
            <?php } ?>

            <?php if(in_array('mail', jssupportticket::$_active_addons)){ ?>
                <a class="js-admin-menu-link" href="?page=mail"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/mail.png"/><div class="jsmenu-text"><?php echo __('Mail', 'js-support-ticket'); ?></div></a>
            <?php } ?>

            <?php if(in_array('agent', jssupportticket::$_active_addons)){ ?>
                <a class="js-admin-menu-link" href="?page=role"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/role1.png"/><div class="jsmenu-text"><?php echo __('Roles', 'js-support-ticket'); ?></div></a>
            <?php } ?>
            <?php if(in_array('knowledgebase', jssupportticket::$_active_addons)){ ?>
                <a class="js-admin-menu-link" href="?page=knowledgebase&jstlay=listcategories"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/categories.png"/><div class="jsmenu-text"><?php echo __('Categories', 'js-support-ticket'); ?></div></a>
            <?php } ?>
            <?php if(in_array('cannedresponses', jssupportticket::$_active_addons)){ ?>
                <a class="js-admin-menu-link" href="?page=cannedresponses"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/premade.png"/><div class="jsmenu-text"><?php echo __('Canned Responses', 'js-support-ticket'); ?></div></a>
            <?php } ?>

            <?php if(in_array('helptopic', jssupportticket::$_active_addons)){ ?>
                <a class="js-admin-menu-link" href="?page=helptopic"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/help-topics.png"/><div class="jsmenu-text"><?php echo __('Help Topics', 'js-support-ticket'); ?></div></a>
            <?php } ?>

            <?php if ( in_array('feedback',jssupportticket::$_active_addons)) { ?>
                <a class="js-admin-menu-link" href="?page=fieldordering&fieldfor=2"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/feedback-odering.png"/><div class="jsmenu-text"><?php echo __('Feedback Fields', 'js-support-ticket'); ?></div></a>
            <?php } ?>
            <?php if(in_array('export', jssupportticket::$_active_addons)){ ?>
                <a class="js-admin-menu-link" href="?page=export"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/export.png"/><div class="jsmenu-text"><?php echo __('Export', 'js-support-ticket'); ?></div></a>
            <?php } ?>
            <?php if(in_array('feedback', jssupportticket::$_active_addons)){ ?>
                <a class="js-admin-menu-link" href="?page=feedback&jstlay=feedbacks"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/feedback-detail.png"/><div class="jsmenu-text"><?php echo __('Feedbacks', 'js-support-ticket'); ?></div></a>
            <?php } ?>
            <?php if(in_array('emailpiping', jssupportticket::$_active_addons)){ ?>
                <a class="js-admin-menu-link" href="?page=emailpiping"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/ticket_email.png"/><div class="jsmenu-text"><?php echo __('Email Piping', 'js-support-ticket'); ?></div></a>
            <?php } ?>
            <?php if(in_array('themes', jssupportticket::$_active_addons)){ ?>
                <a class="js-admin-menu-link" href="?page=themes&jstlay=themes"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/theme_icon.png"/><div class="jsmenu-text"><?php echo __('Themes', 'js-support-ticket'); ?></div></a>
            <?php } ?>
            <?php if ( in_array('agent',jssupportticket::$_active_addons)) { ?>
                <a class="js-admin-menu-link" href="<?php echo admin_url('admin.php?page=reports&jstlay=staffreport'); ?>"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/staff-reports.png"/><div class="jsmenu-text"><?php echo __('Staff Reports', 'js-support-ticket'); ?></div></a>
            <?php } ?>
            <?php if(in_array('feedback', jssupportticket::$_active_addons)){ ?>
                <a class="js-admin-menu-link" href="<?php echo admin_url('admin.php?page=reports&jstlay=satisfactionreport'); ?>"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/satisfaction.png"/><div class="jsmenu-text"><?php echo __('Satisfaction Report', 'js-support-ticket'); ?></div></a>
            <?php } ?>
            <?php if(in_array('banemail', jssupportticket::$_active_addons)){ ?>
                <a class="js-admin-menu-link" href="?page=banemail"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/ban_emails.png"/><div class="jsmenu-text"><?php echo __('Ban Emails', 'js-support-ticket'); ?></div></a>
                <a class="js-admin-menu-link" href="?page=banemaillog"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/ban_email_list.png"/><div class="jsmenu-text"><?php echo __('Ban email log list', 'js-support-ticket'); ?></div></a>
            <?php } ?>

            <a class="js-admin-menu-link addon-feature-link" href="?page=premiumplugin&jstlay=addonfeatures"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/addon-images/add-features-icon.png"/><div class="jsmenu-text"><?php echo __('Add on list', 'js-support-ticket'); ?></div></a>
            <a class="js-admin-menu-link addon-install-link" href="?page=premiumplugin&jstlay=step1">
                <img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/addon-images/addon-admin-cp-banner.png"/>
                <div class="jsmenu-addon-text-first"><?php echo __('Install Now', 'js-support-ticket'); ?></div>
                <div class="jsmenu-addon-text-second"><?php echo __('Add ons', 'js-support-ticket'); ?></div>
            </a>

        </div>
        <span class="js-admin-menus-head"><?php echo __('Support Area', 'js-support-ticket'); ?></span>
        <div id="js-wrapper-menus">
            <a class="js-admin-menu-link" href="?page=jssupportticket&jstlay=aboutus"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/about_us.png"/><div class="jsmenu-text"><?php echo __('About Us','js-support-ticket'); ?></div></a>
            <a class="js-admin-menu-link" href="?page=systemerror"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/system_error.png"/><div class="jsmenu-text"><?php echo __('System Errors', 'js-support-ticket'); ?></div></a>
            <a class="js-admin-menu-link" href="?page=jssupportticket&jstlay=translations"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/language-icon.png"/><div class="jsmenu-text"><?php echo __('Translations','js-support-ticket'); ?></div></a>
            <a class="js-admin-menu-link" href="?page=jssupportticket&jstlay=shortcodes"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/short_code.png"/><div class="jsmenu-text"><?php echo __('Short Codes', 'js-support-ticket'); ?></div></a>
            <a class="js-admin-menu-link" target="_blank" href="https://www.joomsky.com/appsys/documentations/wp-support-ticket"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/documentation.png"/><div class="jsmenu-text"><?php echo __('Documentation', 'js-support-ticket'); ?></div></a>
            <a class="js-admin-menu-link" target="_blank" href="https://www.joomsky.com/appsys/forum/wp-support-ticket"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/forum.png"/><div class="jsmenu-text"><?php echo __('Forum', 'js-support-ticket'); ?></div></a>
            <?php /* <a class="js-admin-menu-link" target="_blank" href="https://www.joomsky.com/appsys/support/wp-support-ticket"><img class="jsmenu-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/support.png"/><div class="jsmenu-text"><?php echo __('Support', 'js-support-ticket'); ?></div></a> */ ?>
        </div>
        <div id="jsreview-banner">
            <div class="review">
                <div class="upper">
                    <div class="imgs">
                        <img class="reviewpic" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/review/review.png">
                        <img class="reviewpic2" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/review/corner-1.png">
                    </div>
                    <div class="text">
                        <div class="simple-text">
                            <span class="nobold"><?php echo __('We\'d love to hear from ', 'js-support-ticket'); ?></span>
                            <span class="bold"><?php echo __('You', 'js-support-ticket'); ?>.</span>
                            <span class="nobold"><?php echo __('Please write appreciated review at', 'js-support-ticket'); ?></span>
                        </div>
                        <a href="https://wordpress.org/support/plugin/js-support-ticket/reviews" target="_blank"><?php echo __('Word Press Extension Directory', 'js-support-ticket'); ?><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/review/arrow2.png"></a>
                    </div>
                    <div class="right">
                        <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/admincp/review/star.png">
                    </div>
                </div>
                <div class="lower">

                </div>
            </div>

        </div>
        </div>
        <script type="text/javascript">
            jQuery(document).ready(function () {
                jQuery("span.dashboard-icon").find('span.download').hover(function(){
                    jQuery(this).find('span').toggle("slide");
                    }, function(){
                    jQuery(this).find('span').toggle("slide");
                });
            });
        </script>
    </div>
</div>

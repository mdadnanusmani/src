<?php
if (!defined('ABSPATH')) die('Restricted Access');
$c = JSSTrequest::getVar('page',null,'jsjobs');
$layout = JSSTrequest::getVar('jstlay');
$ff = JSSTrequest::getVar('fieldfor');
?>
<div id="jsstadmin-menu-links">
    <div class="jsst_js-divlink">
        <a href="admin.php?page=jssupportticket">
            <img alt="image" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/admin.png'; ?>"/>
        </a>
        <a href="#" class="jsst_js-parent <?php if($c == 'jssupportticket') echo 'jsst_lastshown'; ?>"><span class="jsst_text"><?php echo __('Admin' , 'js-support-ticket'); ?> <img class="jsst_arrow" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/arrow1.png'; ?>"/></span></a>
        <div class="jsst_js-innerlink">
            <a class="jsst_js-child" href="?page=jssupportticket"><span class="jsst_text"><?php echo __('Control Panel', 'js-support-ticket'); ?></span></a>
            <a class="jsst_js-child" href="?page=jssupportticket&jstlay=aboutus"><span class="jsst_text"><?php echo __('About Us','js-support-ticket'); ?></span></a>
            <a class="jsst_js-child" href="?page=jssupportticket&jstlay=translations"><span class="jsst_text"><?php echo __('Translations','js-support-ticket'); ?></span></a>
            <a class="jsst_js-child" href="?page=systemerror"><span class="jsst_text"><?php echo __('System Errors', 'js-support-ticket'); ?></span></a>
            <a class="jsst_js-child" href="?page=jssupportticket&jstlay=shortcodes"><span class="jsst_text"><?php echo __('Short Codes', 'js-support-ticket');; ?></span></a>
        </div>
    </div>
    <div class="jsst_js-divlink">
        <a href="admin.php?page=ticket">
            <img alt="image" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/tickets.png'; ?>"/>
        </a>
        <a href="?page=ticket" class="jsst_js-parent <?php if($c == 'ticket' || ($c == 'fieldordering' && $ff == 1) ) echo 'jsst_lastshown'; ?>"><span class="jsst_text"><?php echo __('Tickets' , 'js-support-ticket'); ?><img class="jsst_arrow" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/arrow1.png'; ?>"/></span></a>
        <div class="jsst_js-innerlink">
            <a class="jsst_js-child" href="?page=ticket"><span class="jsst_text"><?php echo __('Tickets', 'js-support-ticket'); ?></span></a>
            <a class="jsst_js-child" href="?page=ticket&jstlay=addticket"><span class="jsst_text"><?php echo __('Create Ticket', 'js-support-ticket'); ?></span></a>
            <?php if(in_array('emailpiping', jssupportticket::$_active_addons)){ ?>
                <a class="jsst_js-child" href="?page=emailpiping"><span class="jsst_text"><?php echo __('Email Piping', 'js-support-ticket'); ?></span></a>
            <?php } ?>
            <a class="jsst_js-child" href="?page=fieldordering&fieldfor=1"><span class="jsst_text"><?php echo __('Fields', 'js-support-ticket'); ?></span></a>
            <?php if(in_array('export', jssupportticket::$_active_addons)){ ?>
                <a class="jsst_js-child" href="?page=export"><span class="jsst_text"><?php echo __('Export', 'js-support-ticket');; ?></span></a>
            <?php } ?>
        </div>
    </div>
    <?php if ( in_array('agent',jssupportticket::$_active_addons)) { ?>
        <div class="jsst_js-divlink">
            <a href="admin.php?page=agent">
                <img alt="image" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/staff_members.png'; ?>"/>
            </a>
            <a href="#" class="jsst_js-parent <?php if($c == 'agent') echo 'jsst_lastshown'; ?>"><span class="jsst_text"><?php echo __('Agents' , 'js-support-ticket'); ?><img class="jsst_arrow" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/arrow1.png'; ?>"/></span></a>
            <div class="jsst_js-innerlink">
              <a class="jsst_js-child" href="?page=agent"><span class="jsst_text"><?php echo __('Agents', 'js-support-ticket'); ?></span></a>
              <a class="jsst_js-child" href="?page=agent&jstlay=addstaff"><span class="jsst_text"><?php echo __('Add Agent', 'js-support-ticket'); ?></span></a>
            </div>
        </div>
    <?php } ?>
    <div class="jsst_js-divlink">
        <a href="?page=configuration">
            <img alt="image" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/configuration.png'; ?>"/>
        </a>
        <a href="#" class="jsst_js-parent <?php if($c == 'configuration' || $c == 'themes') echo 'jsst_lastshown'; ?>"><span class="jsst_text"><?php echo __('Configuration' , 'js-support-ticket'); ?><img class="jsst_arrow" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/arrow1.png'; ?>"/></span></a>
        <div class="jsst_js-innerlink">
            <a class="jsst_js-child" href="?page=configuration"><span class="jsst_text"><?php echo __('Configurations', 'js-support-ticket'); ?></span></a>
            <?php if(in_array('themes', jssupportticket::$_active_addons)){ ?>
                <a class="jsst_js-child" href="?page=themes&jstlay=themes"><span class="jsst_text"><?php echo __('Themes', 'js-support-ticket'); ?></span></a>
            <?php } ?>
            <?php if(in_array('emailpiping', jssupportticket::$_active_addons)){ ?>
                <a class="jsst_js-child" href="?page=emailpiping"><span class="jsst_text"><?php echo __('Email Piping', 'js-support-ticket'); ?></span></a>
            <?php } ?>
        </div>
    </div>
    <div class="jsst_js-divlink">
        <a href="admin.php?page=reports">
            <img alt="image" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/reports.png'; ?>"/>
        </a>
        <a href="#" class="jsst_js-parent <?php if($c == 'reports') echo 'jsst_lastshown'; ?>"><span class="jsst_text"><?php echo __('Reports' , 'js-support-ticket'); ?><img class="jsst_arrow" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/arrow1.png'; ?>"/></span></a>
        <div class="jsst_js-innerlink">
            <a class="jsst_js-child" href="?page=reports&jstlay=overallreport"><span class="jsst_text"><?php echo __('Overall Statistics','js-support-ticket'); ?></span></a>
            <?php if ( in_array('agent',jssupportticket::$_active_addons)) { ?>
                <a class="jsst_js-child" href="?page=reports&jstlay=staffreport"><span class="jsst_text"><?php echo __('Agent Reports', 'js-support-ticket'); ?></span></a>
            <?php } ?>
            <a class="jsst_js-child" href="?page=reports&jstlay=departmentreport"><span class="jsst_text"><?php echo __('Department Reports','js-support-ticket'); ?></span></a>
            <a class="jsst_js-child" href="?page=reports&jstlay=userreport"><span class="jsst_text"><?php echo __('User Reports', 'js-support-ticket'); ?></span></a>
            <?php if(in_array('feedback', jssupportticket::$_active_addons)){ ?>
                <a class="jsst_js-child" href="?page=reports&jstlay=satisfactionreport"><span class="jsst_text"><?php echo __('Satisfaction Report', 'js-support-ticket'); ?></span></a>
            <?php } ?>
        </div>
    </div>
    <div class="jsst_js-divlink">
        <a href="admin.php?page=premiumplugin">
            <img alt="image" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/premium-plugins.png'; ?>"/>
        </a>
        <a href="#" class="jsst_js-parent <?php if($c == 'premiumplugin') echo 'jsst_lastshown'; ?>"><span class="jsst_text"><?php echo __('Premium Add ons' , 'js-support-ticket'); ?><img class="jsst_arrow" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/arrow1.png'; ?>"/></span></a>
        <div class="jsst_js-innerlink">
            <a class="jsst_js-child" href="?page=premiumplugin&jstlay=step1"><span class="jsst_text"><?php echo __('Install Add ons', 'js-support-ticket'); ?></span></a>
            <a class="jsst_js-child" href="?page=premiumplugin&jstlay=addonfeatures"><span class="jsst_text"><?php echo __('Add on list', 'js-support-ticket'); ?></span></a>
        </div>
    </div>
    <?php if(in_array('feedback', jssupportticket::$_active_addons)){ ?>
        <div class="jsst_js-divlink">
            <a href="admin.php?page=feedback">
                <img alt="image" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/feedback.png'; ?>"/>
            </a>
            <a href="#" class="jsst_js-parent <?php if($c == 'feedback'  || ($c == 'fieldordering' && $ff == 2) ) echo 'jsst_lastshown'; ?>"><span class="jsst_text"><?php echo __('Feedbacks' , 'js-support-ticket'); ?><img class="jsst_arrow" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/arrow1.png'; ?>"/></span></a>
            <div class="jsst_js-innerlink">
                <a class="jsst_js-child" href="?page=feedback&jstlay=feedbacks"><span class="jsst_text"><?php echo __('Feedbacks', 'js-support-ticket'); ?></span></a>
                <a class="jsst_js-child" href="?page=fieldordering&fieldfor=2"><span class="jsst_text"><?php echo __('Feedback Fields', 'js-support-ticket'); ?></span></a>
            </div>
        </div>
    <?php } ?>
    <?php if(in_array('knowledgebase', jssupportticket::$_active_addons)){ ?>
        <div class="jsst_js-divlink">
            <a href="admin.php?page=knowledgebase&jstlay=listcategories">
                <img alt="image" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/categories.png'; ?>"/>
            </a>
            <a href="#" class="jsst_js-parent <?php if($c == 'knowledgebase' && ($layout == 'listcategories' || $layout == 'addcategory')) echo 'jsst_lastshown'; ?>"><span class="jsst_text"><?php echo __('Categories','js-support-ticket'); ?><img class="jsst_arrow" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/arrow1.png'; ?>"/></span></a>
            <div class="jsst_js-innerlink">
                <a class="jsst_js-child" href="?page=knowledgebase&jstlay=listcategories"><span class="jsst_text"><?php echo __('Categories', 'js-support-ticket'); ?></span></a>
                <a class="jsst_js-child" href="?page=knowledgebase&jstlay=addcategory"><span class="jsst_text"><?php echo __('Form Category', 'js-support-ticket'); ?></span></a>

            </div>
        </div>
        <div class="jsst_js-divlink">
            <a href="admin.php?page=knowledgebase&jstlay=listarticles">
                <img alt="image" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/knowledgebase.png'; ?>"/>
            </a>
            <a href="#" class="jsst_js-parent <?php if($c == 'knowledgebase' && ($layout == 'listarticles' || $layout == 'addarticle')) echo 'jsst_lastshown'; ?>"><span class="jsst_text"><?php echo __('Knowledgebase' , 'js-support-ticket'); ?><img class="jsst_arrow" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/arrow1.png'; ?>"/></span></a>
            <div class="jsst_js-innerlink">
              <a class="jsst_js-child" href="?page=knowledgebase&jstlay=listarticles"><span class="jsst_text"><?php echo __('Knowledge Base', 'js-support-ticket'); ?></span></a>
              <a class="jsst_js-child" href="?page=knowledgebase&jstlay=addarticle"><span class="jsst_text"><?php echo __('Add Knowledge Base', 'js-support-ticket'); ?></span></a>
            </div>
        </div>
    <?php } ?>
        <?php if(in_array('download', jssupportticket::$_active_addons)){ ?>
        <div class="jsst_js-divlink">
            <a href="admin.php?page=download">
                <img alt="image" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/downloads.png'; ?>"/>
            </a>
            <a href="#" class="jsst_js-parent <?php if($c == 'download') echo 'jsst_lastshown'; ?>"><span class="jsst_text"><?php echo __('Downloads' , 'js-support-ticket'); ?><img class="jsst_arrow" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/arrow1.png'; ?>"/></span></a>
            <div class="jsst_js-innerlink">
              <a class="jsst_js-child" href="?page=download"><span class="jsst_text"><?php echo __('Downloads', 'js-support-ticket'); ?></span></a>
              <a class="jsst_js-child" href="?page=download&jstlay=adddownload"><span class="jsst_text"><?php echo __('Add Download', 'js-support-ticket'); ?></span></a>
            </div>
        </div>
    <?php } ?>
    <?php if(in_array('announcement', jssupportticket::$_active_addons)){ ?>
        <div class="jsst_js-divlink">
            <a href="admin.php?page=announcement">
                <img alt="image" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/announcements.png'; ?>"/>
            </a>
            <a href="#" class="jsst_js-parent <?php if($c == 'announcement') echo 'jsst_lastshown'; ?>"><span class="jsst_text"><?php echo __('Announcements' , 'js-support-ticket'); ?><img class="jsst_arrow" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/arrow1.png'; ?>"/></span></a>
            <div class="jsst_js-innerlink">
              <a class="jsst_js-child" href="?page=announcement"><span class="jsst_text"><?php echo __('Announcements', 'js-support-ticket'); ?></span></a>
              <a class="jsst_js-child" href="?page=announcement&jstlay=addannouncement"><span class="jsst_text"><?php echo __('Add Announcement', 'js-support-ticket'); ?></span></a>
            </div>
        </div>
    <?php } ?>
    <?php if(in_array('faq', jssupportticket::$_active_addons)){ ?>
        <div class="jsst_js-divlink">
            <a href="admin.php?page=faq">
                <img alt="image" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/faqs.png'; ?>"/>
            </a>
            <a href="#" class="jsst_js-parent <?php if($c == 'faq') echo 'jsst_lastshown'; ?>"><span class="jsst_text"><?php echo __('FAQs' , 'js-support-ticket'); ?><img class="jsst_arrow" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/arrow1.png'; ?>"/></span></a>
            <div class="jsst_js-innerlink">
              <a class="jsst_js-child" href="?page=faq"><span class="jsst_text"><?php echo __("FAQ's", 'js-support-ticket'); ?></span></a>
              <a class="jsst_js-child" href="?page=faq&jstlay=addfaq"><span class="jsst_text"><?php echo __( 'Add FAQ', 'js-support-ticket'); ?></span></a>
            </div>
        </div>
<?php } ?>
    <div class="jsst_js-divlink">
        <a href="admin.php?page=department">
            <img alt="image" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/departments.png'; ?>"/>
        </a>
        <a href="#" class="jsst_js-parent <?php if($c == 'department') echo 'jsst_lastshown'; ?>"><span class="jsst_text"><?php echo __('Departments' , 'js-support-ticket'); ?><img class="jsst_arrow" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/arrow1.png'; ?>"/></span></a>
        <div class="jsst_js-innerlink">
          <a class="jsst_js-child" href="?page=department"><span class="jsst_text"><?php echo __('Departments', 'js-support-ticket'); ?></span></a>
          <a class="jsst_js-child" href="?page=department&jstlay=adddepartment"><span class="jsst_text"><?php echo __('Add Department', 'js-support-ticket'); ?></span></a>
        </div>
    </div>

    <?php if(in_array('helptopic', jssupportticket::$_active_addons)){ ?>
        <div class="jsst_js-divlink">
            <a href="admin.php?page=helptopic">
                <img alt="image" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/helptopic.png'; ?>"/>
            </a>
            <a href="#" class="jsst_js-parent <?php if($c == 'helptopic') echo 'jsst_lastshown'; ?>"><span class="jsst_text"><?php echo __('Helptopics' , 'js-support-ticket'); ?><img class="jsst_arrow" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/arrow1.png'; ?>"/></span></a>
            <div class="jsst_js-innerlink">
                <a class="jsst_js-child" href="?page=helptopic"><span class="jsst_text"><?php echo __('Help Topics', 'js-support-ticket'); ?></span></a>
                <a class="jsst_js-child" href="?page=helptopic&jstlay=addhelptopic"><span class="jsst_text"><?php echo __('Add Help Topic', 'js-support-ticket'); ?></span></a>
            </div>
        </div>
    <?php }?>
    <?php if(in_array('cannedresponses', jssupportticket::$_active_addons)){ ?>
        <div class="jsst_js-divlink">
            <a href="admin.php?page=cannedresponses">
                <img alt="image" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/premade.png'; ?>"/>
            </a>
            <a href="#" class="jsst_js-parent <?php if($c == 'cannedresponses') echo 'jsst_lastshown'; ?>"><span class="jsst_text"><?php echo __('Canned Responses' , 'js-support-ticket'); ?><img class="jsst_arrow" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/arrow1.png'; ?>"/></span></a>
            <div class="jsst_js-innerlink">
                <a class="jsst_js-child" href="?page=cannedresponses"><span class="jsst_text"><?php echo __('Canned Responses', 'js-support-ticket'); ?></span></a>
                <a class="jsst_js-child" href="?page=cannedresponses&jstlay=addpremademessage"><span class="jsst_text"><?php echo __('Add Canned Responses', 'js-support-ticket'); ?></span></a>
            </div>
        </div>
    <?php }?>
    <div class="jsst_js-divlink">
        <a href="admin.php?page=priority">
            <img alt="image" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/priorities.png'; ?>"/>
        </a>
        <a href="#" class="jsst_js-parent <?php if($c == 'priority') echo 'jsst_lastshown'; ?>"><span class="jsst_text"><?php echo __('Priorities' , 'js-support-ticket'); ?><img class="jsst_arrow" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/arrow1.png'; ?>"/></span></a>
        <div class="jsst_js-innerlink">
            <a class="jsst_js-child" href="?page=priority"><span class="jsst_text"><?php echo __('Priorities', 'js-support-ticket'); ?></span></a>
            <a class="jsst_js-child" href="?page=priority&jstlay=addpriority"><span class="jsst_text"><?php echo __('Add Priority', 'js-support-ticket'); ?></span></a>
        </div>
    </div>
    <?php if ( in_array('agent',jssupportticket::$_active_addons)) { ?>
        <div class="jsst_js-divlink">
            <a href="admin.php?page=role">
                <img alt="image" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/roles.png'; ?>"/>
            </a>
            <a href="#" class="jsst_js-parent <?php if($c == 'role') echo 'jsst_lastshown'; ?>"><span class="jsst_text"><?php echo __('Roles' , 'js-support-ticket'); ?><img class="jsst_arrow" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/arrow1.png'; ?>"/></span></a>
            <div class="jsst_js-innerlink">
                <a class="jsst_js-child" href="?page=role"><span class="jsst_text"><?php echo __('Roles', 'js-support-ticket'); ?></span></a>
                <a class="jsst_js-child" href="?page=role&jstlay=addrole"><span class="jsst_text"><?php echo __('Add Role', 'js-support-ticket'); ?></span></a>
            </div>
        </div>
    <?php }?>
    <div class="jsst_js-divlink">
        <a href="admin.php?page=email">
            <img alt="image" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/system-emails.png'; ?>"/>
        </a>
        <a href="#" class="jsst_js-parent <?php if($c == 'email') echo 'jsst_lastshown'; ?>"><span class="jsst_text"><?php echo __('System Emails' , 'js-support-ticket'); ?><img class="jsst_arrow" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/arrow1.png'; ?>"/></span></a>
        <div class="jsst_js-innerlink">
            <a class="jsst_js-child" href="?page=email"><span class="jsst_text"><?php echo __('System Emails', 'js-support-ticket'); ?></span></a>
            <a class="jsst_js-child" href="?page=email&jstlay=addemail"><span class="jsst_text"><?php echo __('Add Email', 'js-support-ticket'); ?></span></a>
        </div>
    </div>
    <?php if(in_array('mail', jssupportticket::$_active_addons)){ ?>
        <div class="jsst_js-divlink">
            <a href="admin.php?page=mail">
                <img alt="image" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/mail.png'; ?>"/>
            </a>
            <a href="#" class="jsst_js-parent <?php if($c == 'mail') echo 'jsst_lastshown'; ?>"><span class="jsst_text"><?php echo __('Mail' , 'js-support-ticket'); ?><img class="jsst_arrow" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/arrow1.png'; ?>"/></span></a>
            <div class="jsst_js-innerlink">
                <a class="jsst_js-child" href="?page=mail"><span class="jsst_text"><?php echo __('Mail', 'js-support-ticket'); ?></span></a>
            </div>
        </div>
    <?php } ?>
    <?php if(in_array('banemail', jssupportticket::$_active_addons)){ ?>
        <div class="jsst_js-divlink">
            <a href="admin.php?page=banemail">
                <img alt="image" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/banned-emails.png'; ?>"/>
            </a>
            <a href="#" class="jsst_js-parent <?php if($c == 'banemail' || $c == 'banemaillog') echo 'jsst_lastshown'; ?>"><span class="jsst_text"><?php echo __('Banned Emails' , 'js-support-ticket'); ?><img class="jsst_arrow" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/arrow1.png'; ?>"/></span></a>
            <div class="jsst_js-innerlink">
                <a class="jsst_js-child" href="?page=banemail"><span class="jsst_text"><?php echo __('Ban Emails', 'js-support-ticket'); ?></span></a>
                <a class="jsst_js-child" href="?page=banemaillog"><span class="jsst_text"><?php echo __('Ban email log list', 'js-support-ticket'); ?></span></a>
            </div>
        </div>
    <?php } ?>
    <div class="jsst_js-divlink">
        <a href="admin.php?page=emailtemplate">
            <img alt="image" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/email-template.png'; ?>"/>
        </a>
        <a href="#" class="jsst_js-parent <?php if($c == 'emailtemplate') echo 'jsst_lastshown'; ?>"><span class="jsst_text"><?php echo __('Email Templates' , 'js-support-ticket'); ?><img class="jsst_arrow" src="<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/arrow1.png'; ?>"/></span></a>
        <div class="jsst_js-innerlink">
            <a class="jsst_js-child" href="?page=emailtemplate&for=tk-nw"><span class="jsst_text"><?php echo __('New Ticket', 'js-support-ticket'); ?></span></a>
            <a class="jsst_js-child" href="?page=emailtemplate&for=sntk-tk"><span class="jsst_text"><?php echo __('Agent Ticket', 'js-support-ticket'); ?></span></a>
            <a class="jsst_js-child" href="?page=emailtemplate&for=ew-md"><span class="jsst_text"><?php echo __('New Department', 'js-support-ticket'); ?></span></a>
            <a class="jsst_js-child" href="?page=emailtemplate&for=ew-sm"><span class="jsst_text"><?php echo __('New Agent', 'js-support-ticket'); ?></span></a>
            <a class="jsst_js-child" href="?page=emailtemplate&for=ew-ht"><span class="jsst_text"><?php echo __('New Help Topic', 'js-support-ticket'); ?></span></a>
            <a class="jsst_js-child" href="?page=emailtemplate&for=rs-tk"><span class="jsst_text"><?php echo __('Reassign Ticket', 'js-support-ticket'); ?></span></a>
            <a class="jsst_js-child" href="?page=emailtemplate&for=cl-tk"><span class="jsst_text"><?php echo __('Close Ticket', 'js-support-ticket'); ?></span></a>
            <a class="jsst_js-child" href="?page=emailtemplate&for=dl-tk"><span class="jsst_text"><?php echo __('Delete Ticket', 'js-support-ticket'); ?></span></a>
            <a class="jsst_js-child" href="?page=emailtemplate&for=mo-tk"><span class="jsst_text"><?php echo __('Mark Overdue', 'js-support-ticket'); ?></span></a>
            <a class="jsst_js-child" href="?page=emailtemplate&for=be-tk"><span class="jsst_text"><?php echo __('Ban Email', 'js-support-ticket'); ?></span></a>
            <a class="jsst_js-child" href="?page=emailtemplate&for=be-trtk"><span class="jsst_text"><?php echo __('Ban email try to create ticket', 'js-support-ticket'); ?></span></a>
            <a class="jsst_js-child" href="?page=emailtemplate&for=dt-tk"><span class="jsst_text"><?php echo __('Department Transfer', 'js-support-ticket'); ?></span></a>
            <a class="jsst_js-child" href="?page=emailtemplate&for=ebct-tk"><span class="jsst_text"><?php echo __('Ban Email and Close Ticket', 'js-support-ticket'); ?></span></a>
            <a class="jsst_js-child" href="?page=emailtemplate&for=ube-tk"><span class="jsst_text"><?php echo __('Unban Email', 'js-support-ticket'); ?></span></a>
            <a class="jsst_js-child" href="?page=emailtemplate&for=rsp-tk"><span class="jsst_text"><?php echo __('Response Ticket', 'js-support-ticket'); ?></span></a>
            <a class="jsst_js-child" href="?page=emailtemplate&for=rpy-tk"><span class="jsst_text"><?php echo __('Reply Ticket', 'js-support-ticket'); ?></span></a>
            <a class="jsst_js-child" href="?page=emailtemplate&for=tk-ew-ad"><span class="jsst_text"><?php echo __('New Ticket Admin Alert', 'js-support-ticket'); ?></span></a>
            <a class="jsst_js-child" href="?page=emailtemplate&for=lk-tk"><span class="jsst_text"><?php echo __('Lock Ticket', 'js-support-ticket'); ?></span></a>
            <a class="jsst_js-child" href="?page=emailtemplate&for=ulk-tk"><span class="jsst_text"><?php echo __('Unlock Ticket', 'js-support-ticket'); ?></span></a>
            <a class="jsst_js-child" href="?page=emailtemplate&for=minp-tk"><span class="jsst_text"><?php echo __('In Progress Ticket', 'js-support-ticket'); ?></span></a>
            <a class="jsst_js-child" href="?page=emailtemplate&for=pc-tk"><span class="jsst_text"><?php echo __('Ticket Priority Is Changed By', 'js-support-ticket'); ?></span></a>
            <a class="jsst_js-child" href="?page=emailtemplate&for=ml-ew"><span class="jsst_text"><?php echo __('New Mail Received', 'js-support-ticket'); ?></span></a>
            <a class="jsst_js-child" href="?page=emailtemplate&for=ml-rp"><span class="jsst_text"><?php echo __('New Mail Message Received', 'js-support-ticket'); ?></span></a>
            <a class="jsst_js-child" href="?page=emailtemplate&for=fd-bk"><span class="jsst_text"><?php echo __('Feedback Email To User', 'js-support-ticket'); ?></span></a>
            <a class="jsst_js-child" href="?page=emailtemplate&for=no-rp"><span class="jsst_text"><?php echo __('User Reply On Closed Ticket', 'js-support-ticket'); ?></span></a>
        </div>
    </div>
    </div>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery("img#jsst_js-admin-responsive-menu-link").click(function(e){
            e.preventDefault();
            if(jQuery("div#jsstadmin-leftmenu").css('display') == 'none'){
                jQuery("div#jsstadmin-leftmenu").show();
                jQuery("div#jsstadmin-leftmenu").width(280);
                jQuery("div#jsstadmin-leftmenu").find('a.jsst_js-parent,a.jsst_js-parent2').show();
                jQuery('a.jsst_js-parent.jsst_lastshown').next().find('a.jsst_js-child').css('display','block');
                jQuery('a.jsst_js-parent.jsst_lastshown').find('img.jsst_arrow').attr("src","<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/arrow2.png'; ?>");
                jQuery('a.jsst_js-parent.jsst_lastshown').find('span').css('color','#ffffff');
            }else{
                jQuery("div#jsstadmin-leftmenu").hide();
            }
        });
        jQuery("div#jsstadmin-leftmenu").hover(function(){
            jQuery(this).find('#jsstadmin-menu-links').width(280);
            jQuery(this).find('a.jsst_js-parent,a.jsst_js-parent2').show();
            jQuery('a.jsst_js-parent.jsst_lastshown').next().find('a.jsst_js-child').css('display','block');
            jQuery('a.jsst_js-parent.jsst_lastshown').find('img.jsst_arrow').attr("src","<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/arrow2.png'; ?>");
            jQuery('a.jsst_js-parent.jsst_lastshown').find('span').css('color','#ffffff');
        },function(){
            jQuery(this).find('#jsstadmin-menu-links').width(65);
            jQuery(this).find('a.jsst_js-parent,a.jsst_js-parent2').hide();
            jQuery('a.jsst_js-parent.jsst_lastshown').next().find('a.jsst_js-child').css('display','none');
            jQuery('a.jsst_js-parent.lastshown').find('img.jsst_arrow').attr("src","<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/arrow1.png'; ?>");
            jQuery('a.jsst_js-parent.lastshown').find('span').css('color','#acaeb2');
        });
        jQuery("a.jsst_js-child").find('span.jsst_text').click(function(e){
            jQuery(this).css('color','#ffffff');
        });
        jQuery("a.jsst_js-parent").click(function(e){
            e.preventDefault();
            jQuery('a.jsst_js-parent.jsst_lastshown').next().find('a.jsst_js-child').css('display','none');
            jQuery('a.jsst_js-parent.jsst_lastshown').find('span').css('color','#acaeb2');
            jQuery('a.jsst_js-parent.jsst_lastshown').find('img.jsst_arrow').attr("src","<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/arrow1.png'; ?>");
            jQuery('a.jsst_js-parent.jsst_lastshown').removeClass('jsst_lastshown');
            jQuery(this).find('span').css('color','#ffffff');
            jQuery(this).addClass('jsst_lastshown');
            if(jQuery(this).next().find('a.jsst_js-child').css('display') == 'none'){
                jQuery(this).next().find('a.jsst_js-child').css({'display':'block'},800);
                jQuery(this).find('img.jsst_arrow').attr("src","<?php echo jssupportticket::$_pluginpath.'includes/images/left-icons/arrow2.png'; ?>");
            }
        });
    });
</script>

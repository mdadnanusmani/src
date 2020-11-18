<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTactivation {

    static function jssupportticket_activate() {
        // Install Database
        JSSTactivation::insertMenu();
        JSSTactivation::runSQL();
	JSSTactivation::checkUpdates();
        JSSTactivation::addCapabilites();
    }

    static private function addCapabilites() {
        $role = get_role( 'administrator' );
        $role->add_cap( 'jsst_support_ticket' );
        $role->add_cap( 'jsst_support_ticket_tickets' );
       // $role2 = get_role( 'contributor' );
       // $role2->add_cap( 'jsst_support_ticket_tickets' );
    }

    static private function checkUpdates() {
        include_once jssupportticket::$_path . 'includes/updates/updates.php';
        JSSTupdates::checkUpdates();
    }

    static private function insertMenu() {
        $pageexist = jssupportticket::$_db->get_var("Select COUNT(id) FROM `" . jssupportticket::$_db->prefix . "posts` WHERE post_name = 'js-support-ticket-controlpanel'");
        if ($pageexist == 0) {
            $post = array(
                'post_name' => 'js-support-ticket-controlpanel',
                'post_title' => 'JS Support Ticket',
                'post_status' => 'publish',
                'post_content' => '[jssupportticket]',
                'post_type' => 'page'
            );
            wp_insert_post($post);
        } else {
            jssupportticket::$_db->get_var("UPDATE `" . jssupportticket::$_db->prefix . "posts` SET post_status = 'publish' WHERE post_name = 'js-support-ticket-controlpanel'");
        }
        update_option('rewrite_rules', '');
    }

    static private function runSQL() {
        $pageid = jssupportticket::$_db->get_var("SELECT id FROM `" . jssupportticket::$_db->prefix . "posts` WHERE post_name = 'js-support-ticket-controlpanel'");
         $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_config` (
                      `configname` varchar(100) NOT NULL DEFAULT '',
                      `configvalue` varchar(255) NOT NULL DEFAULT '',
                      `configfor` varchar(50) DEFAULT NULL,
                      `addon` varchar(100) DEFAULT NULL,
                      PRIMARY KEY (`configname`),
                      FULLTEXT KEY `config_name` (`configname`),
                      FULLTEXT KEY `config_for` (`configfor`)
                    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
        jssupportticket::$_db->query($query);
        $uid = get_current_user_id();
        $runConfig = jssupportticket::$_db->get_var("SELECT COUNT(configname) FROM `" . jssupportticket::$_db->prefix . "js_ticket_config`");
        if ($runConfig == 0) {
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_attachments` (
                                `id` int(11) NOT NULL AUTO_INCREMENT,
                                `ticketid` int(11) DEFAULT NULL,
                                `replyattachmentid` int(11) DEFAULT NULL,
                                `filesize` varchar(32) DEFAULT NULL,
                                `filename` varchar(128) DEFAULT NULL,
                                `filekey` varchar(128) DEFAULT NULL,
                                `deleted` tinyint(1) DEFAULT NULL,
                                `status` tinyint(1) DEFAULT NULL,
                                `created` datetime DEFAULT NULL,
                                PRIMARY KEY (`id`)
                                ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
            jssupportticket::$_db->query($query);

            $query = "INSERT INTO `" . jssupportticket::$_db->prefix . "js_ticket_config` (`configname`, `configvalue`, `configfor`, `addon`) VALUES
                    ('title', 'JS Support Ticket System', 'default', NULL),
                    ('offline', '2', 'default', NULL),
                    ('offline_message', 'We are offline now please come back soon.\r\n\r\nThank you', 'default', NULL),
                    ('data_directory', 'jssupportticketdata', 'default', NULL),
                    ('date_format', 'd-m-Y', 'default', NULL),
                    ('ticket_overdue', '5', 'default', 'overdue'),
                    ('ticket_auto_close', '5', 'default', 'autoclose'),
                    ('no_of_attachement', '5', 'default', NULL),
                    ('file_maximum_size', '3072', 'default', NULL),
                    ('file_extension', 'doc,docx,odt,pdf,txt,png,jpeg,jpg', 'default', NULL),
                    ('show_current_location', '2', 'default', NULL),
                    ('maximum_tickets', '25', 'default', 'maxticket'),
                    ('reopen_ticket_within_days', '50', 'default', NULL),
                    ('visitor_can_create_ticket', '1', 'default', NULL),
                    ('show_captcha_on_visitor_from_ticket', '1', 'default', NULL),
                    ('default_alert_email', '1', 'default', NULL),
                    ('default_admin_email', '1', 'default', NULL),
                    ('new_ticket_mail_to_admin', '0', 'default', 'mail'),
                    ('new_ticket_mail_to_staff_members', '0', 'default', 'agent'),
                    ('banemail_mail_to_admin', '0', 'default', 'banemail'),
                    ('ticket_reassign_admin', '1', 'default', NULL),
                    ('ticket_reassign_staff', '0', 'default', 'agent'),
                    ('ticket_reassign_user', '1', 'default', NULL),
                    ('ticket_close_admin', '1', 'default', NULL),
                    ('ticket_close_staff', '0', 'default', 'agent'),
                    ('ticket_close_user', '1', 'default', NULL),
                    ('ticket_delete_admin', '1', 'default', NULL),
                    ('ticket_delete_staff', '0', 'default', 'agent'),
                    ('ticket_delete_user', '1', 'default', NULL),
                    ('ticket_mark_overdue_admin', '0', 'default', 'overdue'),
                    ('ticket_mark_overdue_staff', '0', 'default', 'agent'),
                    ('ticket_mark_overdue_user', '0', 'default', 'overdue'),
                    ('ticket_ban_email_admin', '0', 'default', 'banemail'),
                    ('ticket_ban_email_staff', '0', 'default', 'banemail'),
                    ('ticket_ban_email_user', '0', 'default', 'banemail'),
                    ('ticket_department_transfer_admin', '1', 'default', NULL),
                    ('ticket_department_transfer_staff', '0', 'default', 'agent'),
                    ('ticket_department_transfer_user', '1', 'default', NULL),
                    ('ticket_reply_ticket_user_admin', '1', 'default', NULL),
                    ('ticket_reply_ticket_user_staff', '0', 'default', 'agent'),
                    ('ticket_reply_ticket_user_user', '1', 'default', NULL),
                    ('ticket_response_to_staff_admin', '0', 'default', 'agent'),
                    ('ticket_response_to_staff_staff', '0', 'default', 'agent'),
                    ('ticket_response_to_staff_user', '0', 'default', 'agent'),
                    ('ticker_ban_eamil_and_close_ticktet_admin', '0', 'default', 'banemail'),
                    ('ticker_ban_eamil_and_close_ticktet_staff', '0', 'default', 'banemail'),
                    ('ticker_ban_eamil_and_close_ticktet_user', '0', 'default', 'banemail'),
                    ('unban_email_admin', '0', 'default', 'banemail'),
                    ('unban_email_staff', '0', 'default', 'banemail'),
                    ('unban_email_user', '0', 'default', 'banemail'),
                    ('maximum_open_tickets', '25', 'deafult', 'maxticket'),
                    ('pagination_default_page_size', '10', 'deafult', NULL),
                    ('recaptcha_publickey', '', 'default', NULL),
                    ('recaptcha_privatekey', '', 'default', NULL),
                    ('captcha_selection', '2', 'default', NULL),
                    ('owncaptcha_calculationtype', '1', 'default', NULL),
                    ('owncaptcha_totaloperand', '2', 'default', NULL),
                    ('owncaptcha_subtractionans', '1', 'default', NULL),
                    ('ticket_lock_staff', '0', 'email', 'agent'),
                    ('ticket_lock_admin', '0', 'email', 'actions'),
                    ('ticket_lock_user', '0', 'email', 'actions'),
                    ('ticket_unlock_staff', '0', 'email', 'agent'),
                    ('ticket_unlock_admin', '0', 'email', 'actions'),
                    ('ticket_unlock_user', '0', 'email', 'actions'),
                    ('ticket_mark_progress_staff', '0', 'email', 'agent'),
                    ('ticket_mark_progress_admin', '0', 'email', 'actions'),
                    ('ticket_mark_progress_user', '0', 'email', 'actions'),
                    ('ticket_priority_staff', '1', 'email', 'agent'),
                    ('ticket_priority_admin', '1', 'email', NULL),
                    ('ticket_priority_user', '1', 'email', NULL),
                    ('new_ticket_message', '', 'default', NULL),
                    ('cplink_openticket_staff', '2', 'cplink', 'agent'),
                    ('cplink_myticket_staff', '2', 'cplink', 'agent'),
                    ('cplink_addrole_staff', '2', 'cplink', 'agent'),
                    ('cplink_roles_staff', '2', 'cplink', 'agent'),
                    ('cplink_addstaff_staff', '2', 'cplink', 'agent'),
                    ('cplink_staff_staff', '2', 'cplink', 'agent'),
                    ('cplink_adddepartment_staff', '2', 'cplink', 'agent'),
                    ('cplink_department_staff', '2', 'cplink', 'agent'),
                    ('cplink_addcategory_staff', '2', 'cplink', 'knowledgebase'),
                    ('cplink_category_staff', '2', 'cplink', 'knowledgebase'),
                    ('cplink_addkbarticle_staff', '2', 'cplink', 'knowledgebase'),
                    ('cplink_kbarticle_staff', '2', 'cplink', 'knowledgebase'),
                    ('cplink_adddownload_staff', '2', 'cplink', 'download'),
                    ('cplink_download_staff', '2', 'cplink', 'download'),
                    ('cplink_addannouncement_staff', '2', 'cplink', 'announcement'),
                    ('cplink_announcement_staff', '2', 'cplink', 'announcement'),
                    ('cplink_addfaq_staff', '2', 'cplink', 'faq'),
                    ('cplink_faq_staff', '2', 'cplink', 'faq'),
                    ('cplink_mail_staff', '2', 'cplink', 'mail'),
                    ('cplink_myprofile_staff', '2', 'cplink', 'agent'),
                    ('cplink_openticket_user', '1', 'cplink', NULL),
                    ('cplink_myticket_user', '1', 'cplink', NULL),
                    ('cplink_checkticketstatus_user', '1', 'cplink', NULL),
                    ('cplink_downloads_user', '2', 'cplink', 'download'),
                    ('cplink_announcements_user', '2', 'cplink', 'announcement'),
                    ('cplink_faqs_user', '2', 'cplink', 'faq'),
                    ('cplink_knowledgebase_user', '2', 'cplink', 'knowledgebase'),
                    ('tplink_home_staff', '2', 'tplink', 'agent'),
                    ('tplink_tickets_staff', '2', 'tplink', 'agent'),
                    ('tplink_knowledgebase_staff', '2', 'tplink', 'knowledgebase'),
                    ('tplink_announcements_staff', '2', 'tplink', 'announcement'),
                    ('tplink_downloads_staff', '2', 'tplink', 'download'),
                    ('tplink_faqs_staff', '0', 'tplink', 'faq'),
                    ('tplink_home_user', '1', 'tplink', NULL),
                    ('tplink_tickets_user', '1', 'tplink', NULL),
                    ('tplink_knowledgebase_user', '2', 'tplink', 'knowledgebase'),
                    ('tplink_announcements_user', '2', 'tplink', 'announcement'),
                    ('tplink_downloads_user', '1', 'tplink', NULL),
                    ('tplink_faqs_user', '0', 'tplink', 'faq'),
                    ('show_breadcrumbs', '1', 'default', NULL),
                    ('productcode', 'jsticket', 'default', NULL),
                    ('versioncode', '2.1.6', 'default', NULL),
                    ('productversion', '216', 'default', NULL),
                    ('producttype', 'free', 'default', NULL),
                    ('tve_enabled', '2', 'default', NULL),
                    ('tve_mailreadtype', '3', 'default', NULL),
                    ('tve_attachment', '1', 'default', NULL),
                    ('tve_emailreadingdelay', '300', 'default', NULL),
                    ('tve_hosttype', '4', 'default', NULL),
                    ('tve_hostname', '', 'default', NULL),
                    ('tve_emailaddress', '', 'default', NULL),
                    ('tve_emailpassword', '', 'default', NULL),
                    ('lastEmailReadingTime', '1562051615', 'default', NULL),
                    ('tve_ssl', '2', 'ticketviaemail', NULL),
                    ('tve_hostportnumber', '', 'ticketviaemail', NULL),
                    ('ck', 'abc29ff5d6ec8d9e108ea1a4515e26a3', 'default', NULL),
                    ('login_redirect', '2', 'default', NULL),
                    ('count_on_myticket', '1', 'default', NULL),
                    ('system_slug', 'jssupportticket', 'default', NULL),
                    ('default_pageid', '5', 'default', NULL),
                    ('support_screentag', '1', 'default', NULL),
                    ('screentag_position', '1', 'default', NULL),
                    ('last_step_updater', '', 'default', NULL),
                    ('cplink_login_logout_user', '1', 'cplink', NULL),
                    ('cplink_login_logout_staff', '2', 'cplink', 'agent'),
                    ('ticketid_sequence', '1', 'default', NULL),
                    ('print_ticket_user', '1', 'ticket', NULL),
                    ('last_version', '211', 'default', NULL),
                    ('cplink_staff_report_staff', '2', 'cplink', 'agent'),
                    ('cplink_department_report_staff', '2', 'cplink', 'agent'),
                    ('wp_default_role', 'subscriber', 'default', 'useroptions'),
                    ('captcha_on_registration', '0', 'default', 'useroptions'),
                    ('cplink_register_user', '1', 'default', NULL),
                    ('cplink_feedback_staff', '0', 'default', 'feedback'),
                    ('feedback_email_delay_type', '1', 'default', 'feedback'),
                    ('feedback_email_delay', '30', 'default', 'feedback'),
                    ('ticket_feedback_user', '1', 'default', 'feedback'),
                    ('ticket_overdue_type', '1', 'default', 'overdue'),
                    ('reply_to_closed_ticket', '1', 'default', NULL),
                    ('visitor_message', 'Thank You for contacting us. A support ticket request has been created, A representative will be getting back to you shortly.\r\nSupport Team', 'default', NULL),
                    ('ticket_reply_closed_ticket_user', '1', 'default', NULL),
                    ('feedback_thanks_message', 'Thank you for providing your feedback. We appreciate the time you have taken and will actively use it to improve our services to you.', 'default', 'feedback'),
                    ('serialnumber', '67259', 'hostdata', NULL),
                    ('hostdata', '88fd93f82e5ca231ff4e85e769be370f', 'hostdata', NULL),
                    ('zvdk', '8ffe8941fa06d68', 'hostdata', NULL),
                    ('read_utf_ticket_via_email', '1', 'ticketviaemail', 'emailpiping'),
                    ('set_login_link', '1', 'default', NULL),
                    ('login_link', '', 'default', NULL),
                    ('show_header', '1', 'default', NULL),
                    ('tplink_openticket_user', '2', 'tplink', NULL),
                    ('tplink_openticket_staff', '2', 'tplink', 'agent'),
                    ('cplink_latesttickets_staff', '2', 'cplink', 'agent'),
                    ('cplink_totalcount_staff', '2', 'cplink', 'agent'),
                    ('cplink_ticketstats_staff', '2', 'cplink', 'agent'),
                    ('tplink_login_logout_user', '1', 'tplink', NULL),
                    ('0d607e93d5af0655351743b41ed67944', '', 'firebase', 'notification'),
                    ('apiKey_firebase', '', 'firebase', 'notification'),
                    ('authDomain_firebase', '', 'firebase', 'notification'),
                    ('databaseURL_firebase', '', 'firebase', 'notification'),
                    ('projectId_firebase', '', 'firebase', 'notification'),
                    ('storageBucket_firebase', '', 'firebase', 'notification'),
                    ('messagingSenderId_firebase', '', 'firebase', 'notification'),
                    ('server_key_firebase', '', 'firebase', 'notification'),
                    ('logo_for_desktop_notfication_url', '', 'firebase', 'notification'),
                    ('private_credentials_secretkey', '', 'privatecredentials', 'privatecredentials')
					;

            ";
            jssupportticket::$_db->query($query);

            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_departments` (
                                `id` int(11) NOT NULL AUTO_INCREMENT,
                                `emailtemplateid` int(11) DEFAULT NULL,
                                `emailid` int(11) DEFAULT NULL,
                                `autoresponceemailid` int(11) DEFAULT NULL,
                                `managerid` int(11) DEFAULT NULL,
                                `departmentname` varchar(32) DEFAULT NULL,
                                `departmentsignature` text,
                                `ispublic` tinyint(1) DEFAULT NULL,
                                `ticketautoresponce` tinyint(1) DEFAULT NULL,
                                `messageautoresponce` tinyint(1) DEFAULT NULL,
                                `canappendsignature` tinyint(1) DEFAULT NULL,
                                `ordering` int(11) NOT NULL,
                                `updated` datetime DEFAULT NULL,
                                `created` datetime DEFAULT NULL,
                                `status` tinyint(1) DEFAULT NULL,
                                `isdefault` tinyint(1) DEFAULT NULL,
                                `sendmail` tinyint NOT NULL DEFAULT '0',
                                PRIMARY KEY (`id`)
                                ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2;";
            jssupportticket::$_db->query($query);
            $query = "INSERT INTO `" . jssupportticket::$_db->prefix . "js_ticket_departments` (`id`, `emailtemplateid`, `emailid`, `autoresponceemailid`, `managerid`, `departmentname`, `departmentsignature`, `ispublic`, `ticketautoresponce`, `messageautoresponce`, `canappendsignature`, `ordering`, `updated`, `created`, `status`) VALUES (1, NULL, 1, NULL, NULL, 'Support', '-- \n\n Support Department.', 1, NULL, NULL, 1, 1, '" . date_i18n('Y-m-d H:i:s') . "', '" . date_i18n('Y-m-d H:i:s') . "', 1);";
            jssupportticket::$_db->query($query);
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_email` (
                                `id` int(11) NOT NULL AUTO_INCREMENT,
                                `autoresponse` tinyint(1) DEFAULT NULL,
                                `priorityid` int(11) DEFAULT NULL,
                                `email` varchar(125) DEFAULT NULL,
                                `name` varchar(32) DEFAULT NULL,
                                `uid` int(11) DEFAULT NULL,
                                `password` varchar(125) DEFAULT NULL COMMENT '    ',
                                `status` tinyint(1) DEFAULT NULL,
                                `smtpemailauth` TINYINT DEFAULT NULL,
                                `mailhost` varchar(125) DEFAULT NULL,
                                `mailprotocol` enum('pop','map') DEFAULT NULL,
                                `mailencryption` enum('NONE','SSL') DEFAULT NULL,
                                `mailport` smallint(6) DEFAULT NULL,
                                `mailfetchfrequency` tinyint(3) DEFAULT NULL,
                                `mailfetchmaximum` tinyint(4) DEFAULT NULL,
                                `maildeleted` tinyint(1) DEFAULT NULL,
                                `mailerrors` tinyint(3) DEFAULT NULL,
                                `maillasterror` datetime DEFAULT NULL,
                                `maillastfetch` datetime DEFAULT NULL,
                                `smtpactive` tinyint(1) DEFAULT NULL,
                                `smtphosttype` INT DEFAULT NULL,
                                `smtphost` varchar(125) DEFAULT NULL,
                                `smtpport` smallint(6) DEFAULT NULL,
                                `smtpsecure` tinyint(1) DEFAULT NULL,
                                `smtpauthencation` tinyint(1) DEFAULT NULL,
                                `created` datetime DEFAULT NULL,
                                `updated` datetime DEFAULT NULL,
                                PRIMARY KEY (`id`)
                                ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2;";
            jssupportticket::$_db->query($query);
            $systememail = get_option('admin_email');
            $query = "INSERT INTO `" . jssupportticket::$_db->prefix . "js_ticket_email` (`id`,`autoresponse`, `priorityid`, `email`, `name`, `uid`, `password`, `status`, `mailhost`, `mailprotocol`, `mailencryption`, `mailport`, `mailfetchfrequency`, `mailfetchmaximum`, `maildeleted`, `mailerrors`, `maillasterror`, `maillastfetch`, `smtpactive`, `smtphost`, `smtpport`, `smtpsecure`, `smtpauthencation`, `created`, `updated`) VALUES
                                (1,1, 1, '" . $systememail . "', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-10-02 10:38:48', '0000-00-00 00:00:00');";
            jssupportticket::$_db->query($query);

            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_emailtemplates` (
                                `id` int(11) NOT NULL AUTO_INCREMENT,
                                `templatefor` varchar(50) DEFAULT NULL,
                                `title` varchar(50) DEFAULT NULL,
                                `subject` varchar(255) DEFAULT NULL,
                                `body` text,
                                `created` datetime DEFAULT NULL,
                                `status` tinyint(1) DEFAULT NULL,
                                PRIMARY KEY (`id`)
                                ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26;";
            jssupportticket::$_db->query($query);
            $query = "INSERT INTO `" . jssupportticket::$_db->prefix . "js_ticket_emailtemplates` (`id`, `templatefor`, `title`, `subject`, `body`, `created`, `status`) VALUES
                                (1, 'ticket-new', '', 'JS Tickets: New Ticket Received ', 'Dear {USERNAME},\r\n\r\nYour support ticket <strong>{SUBJECT}</strong> has been submitted. We try to reply to all tickets as soon as possible, usually within 24 hours.\r\n\r\nYour tracking ID: {TRACKINGID}\r\n\r\nYour Email ID: {EMAIL}\r\n\r\nTicket message: {MESSAGE}\r\n\r\nYou can view the status of your ticket here:\r\n{TICKETURL}\r\n\r\nYou will receive an e-mail notification when our staff replies to your ticket.\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
                                (2, 'department-new', '', 'JS Tickets :  New Department {DEPARTMENT_TITLE} has beed received ', 'Hello Admin ,\r\n\r\nWe receive new department.\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
                                (3, 'group-new', '', 'JS Tickets :  New Group {GROUP_TITLE} has beed received ', 'Hello Admin ,\r\n\r\nWe receive new group.\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
                                (4, 'staff-new', '', 'JS Tickets :  New Staff Member {STAFF_MEMBER_NAME} has beed received ', 'Hello Admin ,\r\n\r\nWe receive new staff member.\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
                                (5, 'helptopic-new', '', 'JS Tickets :  New Help Topic {HELPTOPIC_TITLE} has beed received', 'Hello Admin ,\r\n\r\nWe receive new help topic {HELPTOPIC_TITLE} of department {DEPARTMENT_TITLE}.\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
                                (6, 'reassign-tk', '', 'JS Tickets: Reassign Ticket  ', 'Sucess: Ticket Reassign\r\n\r\nTicket Subject : {SUBJECT}\r\n\r\nYour ticket has been successfully Reassign! Ticket ID:{TRACKINGID} is Reassign to Staff Member:{STAFF_MEMBER_NAME}\r\n\r\nYou can manage this ticket here\r\n\r\n{TICKETURL}\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
                                (7, 'close-tk', '', 'JS Tickets:  Close Ticket ', 'Ticket Close\r\n\r\nTicket Subject : {SUBJECT}\r\n\r\nTicket ID:{TRACKINGID} is Closed.\r\n\r\nYou can manage this ticket here\r\n\r\n{TICKETURL}\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
                                (8, 'delete-tk', '', 'JS Tickets:  Delete Ticket', 'Ticket Deleted\r\n\r\nTicket Subject : {SUBJECT}\r\n\r\nTicket ID:{TRACKINGID} is Deleted.\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
                                (9, 'moverdue-tk', '', 'JS Tickets:  Markoverdue Ticket ', 'Ticket Markoverdue\r\n\r\nTicket Subject : {SUBJECT}\r\n\r\nTicket ID:{TRACKINGID} is Markoverdue.\r\n\r\nYou can manage this ticket here\r\n\r\n{TICKETURL}\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
                                (10, 'banemail-tk', '', 'JS Tickets:  Email Baned ', 'Email Baned\r\n\r\nThis email {EMAIL_ADDRESS} is Baned.\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
                                (11, 'deptrans-tk', '', 'JS Tickets:  Ticket Transfer to Department {DEPARTMENT_TITLE} ', 'Ticket transfer to department\r\n\r\nTicket Subject : {SUBJECT}\r\n\r\nTicket ID: {TRACKINGID} is transfer to department {DEPARTMENT_TITLE}.\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
                                (12, 'banemailcloseticket-tk', '', 'JS Tickets: Email Baned and ticket close ', 'Email Baned and ticket close\r\n\r\nTicket Subject : {SUBJECT}\r\n\r\nThis email {EMAIL_ADDRESS} is Baned and ticket ID:{TICKETID} is closed.\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
                                (13, 'unbanemail-tk', '', 'JS Tickets:  Email Unbaned ', 'Email Unbaned\r\n\r\nThis email {EMAIL_ADDRESS} is Unbaned\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
                                (14, 'reply-tk', '', 'JS Tickets:  Ticket Reply  ', 'Hello,\r\n\r\nA new reply of ticket <strong>{SUBJECT} </strong>has been submitted.\r\n\r\nUser Name: {USERNAME}\r\n\r\nTracking ID: {TRACKINGID}\r\n\r\nEmail: {EMAIL}\r\n\r\nMessage: {MESSAGE}\r\n\r\nYou can manage this ticket here:\r\n{TICKETURL}\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
                                (15, 'responce-tk', '', 'JS Tickets:  Ticket Responce ', 'Hello,\r\n\r\nStaff just reply of your ticket <strong>{SUBJECT}</strong>.\r\n\r\nUser Name: {USERNAME}\r\n\r\nTracking ID: {TRACKINGID}\r\n\r\nEmail: {EMAIL}\r\n\r\nMessage: {MESSAGE}\r\n\r\nYou can manage this ticket here:\r\n{TICKETURL}\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
                                (16, 'ticket-staff', '', 'JS Tickets: New Ticket', 'Sucess: Ticket Submitted\r\n\r\nNew ticket <strong>{SUBJECT}</strong> has been submitted with the following details.\r\n\r\nTracking ID: {TRACKINGID}\r\n\r\nEmail ID: {EMAIL}\r\n\r\nTicket message: {MESSAGE}\r\n\r\nHelp Topic: {HELP_TOPIC}\r\n\r\nYou can view the status of your ticket here:\r\n{TICKETURL}\r\n\r\nYou will receive an e-mail notification when our staff replies to your ticket.\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
                                (17, 'banemail-trtk', '', 'JS Tickets: Banemail try new ticket ', 'Hello Admin ,\r\n\r\nThis email {EMAIL_ADDRESS} is baned and try open new ticket .\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
                                (18, 'ticket-new-admin', '', 'JS Tickets: New Ticket Received ', 'Hello,\r\n\r\nA new support ticket <strong>{SUBJECT}</strong> has been submitted. Ticket details.\r\n\r\nTracking ID: {TRACKINGID}\r\n\r\nEmail ID: {EMAIL}\r\n\r\nTicket message: {MESSAGE}\r\n\r\nYou can manage this ticket here:\r\n{TICKETURL}\r\n\r\n<span style=\"color: #ff0000;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
                                (19, 'lock-tk', '', 'JS Tickets :  Ticket {TRACKINGID} has been locked', 'Dear {USERNAME} ,\r\n\r\nYour Ticket {TRACKINGID} has been locked.\r\n\r\nUsername : {USERNAME}\r\nSubject : {SUBJECT}\r\nTicket ID : {TRACKINGID}\r\nEmail : {EMAIL}\r\n\r\nYou can manage ticket here {TICKETURL}\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
                                (21, 'unlock-tk', '', 'JS Tickets :  Ticket {TRACKINGID} has been unlocked', 'Dear {USERNAME} ,\r\n\r\nYour Ticket {TRACKINGID} has been unlocked.\r\n\r\nUsername : {USERNAME}\r\nSubject : {SUBJECT}\r\nTicket ID : {TRACKINGID}\r\nEmail : {EMAIL}\r\n\r\nYou can manage ticket here {TICKETURL}\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
                                (22, 'minprogress-tk', '', 'JS Tickets:  Mark in progress Ticket ', 'Ticket Mark in progress\r\n\r\nTicket Subject : {SUBJECT}\r\n\r\nTicket ID:{TRACKINGID} is Mark in progress.\r\n\r\nYou can manage this ticket here\r\n\r\n{TICKETURL}\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
                                (23, 'prtrans-tk', '', 'JS Tickets:  Ticket Priority changed ', 'Ticket priority is changed\r\n\r\nTicket Subject : {SUBJECT}\r\n\r\nTicket ID: {TRACKINGID} is priority changed and new priority and new priority {PRIORITY_TITLE}.\r\n\r\nYou can manage this ticket here\r\n\r\n{TICKETURL}\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
                                (24, 'mail-new', '', 'JS Tickets:  New Mail has been sent by {STAFF_MEMBER_NAME}', '<p>New mail has been sent by the {STAFF_MEMBER_NAME}</p>\n<p>Mail Subject : {SUBJECT}</p>\n<p>Message : {MESSAGE}</p>\n<p><span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span><br />\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!</p>\n', NULL, 0),
                                (25, 'mail-rpy', '', 'JS Tickets:  New reply has been sent by {STAFF_MEMBER_NAME}', '<p>New reply has been sent by the {STAFF_MEMBER_NAME}</p>\n<p>Mail Subject : {SUBJECT}</p>\n<p>Message : {MESSAGE}</p>\n<p><span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span><br />\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!</p>\n', NULL, 0),
                                (26,'mail-rpy-closed','', 'JS Tickets: Ticket has been closed', '<p>Your ticket {TICKET_SUBJECT} has been closed.</p>\n<p>You can not reply to a closed ticket</p>\n<p> <span style=\"color: red;\">  <strong>*DO NOT REPLY TO THIS E-MAIL*</strong>  </span> <br />\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!</p>\n',NULL,0),
                                (27,'mail-feedback','','JS Tickets: Give Us Your Feedback','<p>Dear {USER_NAME}, Your ticket {TICKET_SUBJECT} having tracking id {TRACKING_ID} has been closed on {CLOSE_DATE}.\n We would really appreciate if you took the time to tell us how well our staff member helped you in your problem..</p>\n<p> {LINK}link text{/LINK}  </p>\n<p> \n  <span style=\"color: red;\">  <strong>*DO NOT REPLY TO THIS E-MAIL*</strong>  </span> <br />\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!</p>\n',NULL,0);"
                                ;
            jssupportticket::$_db->query($query);
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_priorities` (
                                `id` int(11) NOT NULL AUTO_INCREMENT,
                                `priority` varchar(60) DEFAULT NULL,
                                `prioritycolour` varchar(7) DEFAULT NULL,
                                `priorityurgency` int(1) DEFAULT NULL,
                                `overduetypeid` int(5) DEFAULT NULL,
                                `overdueinterval` int(5) DEFAULT NULL,
                                `ispublic` varchar(45) DEFAULT NULL,
                                `ordering` int(11) NOT NULL,
                                `isdefault` tinyint(1) DEFAULT NULL,
                                `status` tinyint(4) NOT NULL DEFAULT '0',
                                PRIMARY KEY (`id`)
                                ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5;";
            jssupportticket::$_db->query($query);
            $query = "INSERT INTO `" . jssupportticket::$_db->prefix . "js_ticket_priorities` (`id`, `priority`, `prioritycolour`, `priorityurgency`, `ispublic`, `overdueinterval`, `overduetypeid`, `ordering`, `isdefault`, `status`) VALUES (1, 'Low', '#86f793', 0, 1, 3, '1', 1, 1, 0),(2, 'High', '#ed8e00', 0, 1, 1, '1', 3, 0, 1),(3, 'Normal', '#c7cbf5', 0, 1, 2, '1', 2, 0, 1),(4, 'Urgent', '#c90000', 0, 1, 1, '1', 4, 0, 0);";
            jssupportticket::$_db->query($query);
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_replies` (
                                `id` int(11) NOT NULL AUTO_INCREMENT,
                                `uid` int(11) NOT NULL,
                                `ticketid` int(11) DEFAULT NULL,
                                `name` varchar(50) DEFAULT NULL,
                                `message` text,
                                `staffid` int(11) DEFAULT NULL,
                                `rating` enum('1','5') DEFAULT NULL,
                                `status` tinyint(1) DEFAULT NULL,
                                `created` datetime DEFAULT NULL,
                                `ticketviaemail` tinyint(1) NOT NULL,
                                `mergemessage` TINYINT(1) NOT NULL DEFAULT '0',
                                PRIMARY KEY (`id`)
                                ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
            jssupportticket::$_db->query($query);
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_system_errors` (
                                `id` int(11) NOT NULL AUTO_INCREMENT,
                                `uid` int(11) DEFAULT NULL,
                                `error` text,
                                `isview` tinyint(1) DEFAULT '0',
                                `created` datetime DEFAULT NULL,
                                PRIMARY KEY (`id`)
                                ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
            jssupportticket::$_db->query($query);
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_tickets` (
                                `id` int(11) NOT NULL AUTO_INCREMENT,
                                `uid` int(11) DEFAULT NULL,
                                `ticketid` varchar(11) DEFAULT NULL,
                                `departmentid` int(11) DEFAULT NULL,
                                `priorityid` int(11) DEFAULT NULL,
                                `staffid` int(11) DEFAULT NULL,
                                `email` varchar(255) DEFAULT NULL,
                                `name` varchar(100) DEFAULT NULL,
                                `subject` varchar(255) DEFAULT NULL,
                                `message` text,
                                `helptopicid` int(11) DEFAULT NULL,
                                `phone` varchar(100) DEFAULT NULL,
                                `phoneext` varchar(25) DEFAULT NULL,
                                `status` tinyint(1) DEFAULT NULL,
                                `isoverdue` tinyint(1) DEFAULT NULL,
                                `isanswered` tinyint(1) NOT NULL DEFAULT '0',
                                `duedate` datetime DEFAULT NULL,
                                `reopened` datetime DEFAULT NULL,
                                `closed` datetime DEFAULT NULL,
                                `lastreply` datetime DEFAULT NULL,
                                `created` datetime DEFAULT NULL,
                                `updated` datetime DEFAULT NULL,
                                `lock` tinyint(4) NOT NULL DEFAULT '0',
                                `ticketviaemail` tinyint(1) NOT NULL,
                                `ticketviaemail_id` INT(11) DEFAULT NULL,
                                `attachmentdir` VARCHAR(50) NOT NULL,
                                `feedbackemail` TINYINT NOT NULL,
                                `mergestatus` TINYINT(4) NOT NULL DEFAULT '0',
                                `mergewith` INT(11) DEFAULT NULL,
                                `mergenote` TEXT DEFAULT NULL,
                                `mergedate` datetime DEFAULT NULL,
                                `multimergeparams` TEXT DEFAULT NULL,
                                `mergeuid` INT(11) DEFAULT NULL,
                                `params` longtext NULL,
                                `hash` varchar(200) COLLATE 'utf8_general_ci' NULL,
                                `notificationid` INT NOT NULL,
								`wcorderid` bigint NULL,
								`wcitemid` bigint NULL,
								`wcproductid` bigint NULL,
                                PRIMARY KEY (`id`)
                                ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
            jssupportticket::$_db->query($query);
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_fieldsordering` (
                        `id` int(11) NOT NULL AUTO_INCREMENT,
                        `field` varchar(50) NOT NULL,
                        `fieldtitle` varchar(50) DEFAULT NULL,
                        `ordering` int(11) DEFAULT NULL,
                        `section` varchar(20) DEFAULT NULL,
                        `fieldfor` tinyint(2) DEFAULT NULL,
                        `published` tinyint(1) DEFAULT NULL,
                        `sys` tinyint(1) NOT NULL,
                        `cannotunpublish` tinyint(1) NOT NULL,
                        `required` tinyint(1) NOT NULL DEFAULT '0',
                        `size` varchar(200) DEFAULT NULL,
                        `maxlength` varchar(200) DEFAULT NULL,
                        `cols` varchar(200) DEFAULT NULL,
                        `rows` varchar(200) DEFAULT NULL,
                        `isuserfield` tinyint(4) DEFAULT NULL,
                        `userfieldtype` varchar(250) DEFAULT NULL,
                        `depandant_field` varchar(250) DEFAULT NULL,
                        `showonlisting` tinyint(4) DEFAULT NULL,
                        `cannotshowonlisting` tinyint(4) DEFAULT NULL,
                        `search_user` tinyint(4) DEFAULT NULL,
                        `cannotsearch` tinyint(4) DEFAULT NULL,
                        `isvisitorpublished` tinyint(4) DEFAULT NULL,
                        `search_visitor` tinyint(4) DEFAULT NULL,
                        `userfieldparams` longtext,
                        PRIMARY KEY (`id`),KEY `fieldordering_filedfor` (`fieldfor`))
                        ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14;";
            jssupportticket::$_db->query($query);
            $query = "INSERT INTO `" . jssupportticket::$_db->prefix . "js_ticket_fieldsordering` (`id`, `field`, `fieldtitle`, `ordering`, `section`, `fieldfor`, `published`, `sys`, `cannotunpublish`, `required`,`cannotsearch`,`cannotshowonlisting`,`isvisitorpublished`) VALUES (1, 'email', 'Email Address', 2, '10', 1, 1, 0, 1, 1, 1, 1, 1),  (15, 'users', 'Users', 1, '10', 1, 1, 0, 0, 0, 1, 1, 1),  (2, 'fullname', 'Full Name', 3, '10', 1, 1, 0, 1, 1, 1, 1, 1),  (3, 'phone', 'Phone', 4, '10', 1, 1, 0, 0, 0, 1, 1, 1),  (4, 'department', 'Department', 5, '10', 1, 1, 0, 0, 0, 1, 1, 1),  (5, 'helptopic', 'Help Topic', 6, '10', 1, 1, 0, 0, 0, 1, 1, 1),  (6, 'priority', 'Priority', 7, '10', 1, 1, 0, 1, 1, 1, 1, 1),  (7, 'subject', 'Subject', 8, '10', 1, 1, 0, 1, 1, 1, 1, 1),  (8, 'premade', 'Premade', 9, '10', 1, 1, 0, 0, 0, 1, 1, 1),  (9, 'issuesummary', 'Issue Summary', 10, '10', 1, 1, 0, 1, 1, 1, 1, 1),  (10, 'attachments', 'Attachments', 11, '10', 1, 1, 0, 0, 0, 1, 1, 1),  (11, 'internalnotetitle', 'Internal Note Title', 12, '10', 1, 1, 0, 0, 0, 1, 1, 1),  (12, 'assignto', 'Assign To', 13, '10', 1, 1, 0, 0, 0, 1, 1, 1),  (13, 'duedate', 'Due Date', 14, '10', 1, 1, 0, 0, 0, 1, 1, 1),  (14, 'status', 'Status', 15, '10', 1, 1, 0, 0, 0, 1, 1, 1),  (16, 'rating', 'Rating', 1, '10', 2, 1, 0, 0, 0, 0, 0, 1),  (17, 'remarks', 'Remarks', 2, '10', 2, 1, 0, 0, 0, 0, 0, 1)
			, (18, 'wcorderid', 'Order ID', 16, '10', 1, 1, 0, 0, 0, 0, 0, 1), (19, 'wcproductid', 'Product', 17, '10', 1, 1, 0, 0, 0, 1, 0, 1)
			;";
            jssupportticket::$_db->query($query);
        }
    }

}

?>

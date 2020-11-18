<div class="jsst-main-up-wrapper">
<?php
if (jssupportticket::$_config['offline'] == 2) {
    if (jssupportticket::$_data['permission_granted'] == 1) {
        if (get_current_user_id() != 0) {
            if ( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()) {
                if (jssupportticket::$_data['staff_enabled']) {
                    ?>
                    <?php
                    JSSTmessage::getMessage();
                    if (jssupportticket::$_data[0]['unreadmessages'] >= 1) {
                        $inbox = jssupportticket::$_data[0]['unreadmessages'];
                    } else {
                        $inbox = jssupportticket::$_data[0]['totalInboxboxmessages'];
                    }
                    ?>
                    <?php JSSTbreadcrumbs::getBreadcrumbs(); ?>
                    <?php include_once(jssupportticket::$_path . 'includes/header.php'); ?>

                    <div class="js-ticket-mails-btn-wrp">
                        <div class="js-ticket-mail-btn">
                            <a class="js-add-link button active" href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'mail', 'jstlay'=>'inbox'))); ?>">
                                <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/inbox.png" />
                                <?php echo __('Inbox', 'js-support-ticket').'
                                    ('; echo $inbox;
                                        echo ' )'; ?>
                            </a>
                        </div>
                        <div class="js-ticket-mail-btn">
                            <a class="js-add-link button" href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'mail', 'jstlay'=>'outbox'))); ?>">
                                <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/outbox.png" />
                                <?php echo __('Outbox', 'js-support-ticket').' (';
                                    echo jssupportticket::$_data[0]['outboxmessages'];
                                    echo __(' )  ', 'js-support-ticket'); ?>
                            </a>
                        </div>
                        <div class="js-ticket-mail-btn">
                            <a class="js-add-link button" href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'mail', 'jstlay'=>'formmessage'))); ?>">
                                <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/add_icon2.png" />
                                <?php echo __('Compose', 'js-support-ticket') ?>
                            </a>
                        </div>
                    </div>

                    <?php
                    if(jssupportticket::$_data[0]['message'] != null){ ?>


                        <div class="js-ticket-post-reply-wrapper"><!-- Ticket Post Replay -->
                            <div class="js-ticket-thread-heading"><?php echo __('Subject', 'js-support-ticket'); ?></div> <!-- Heading -->

                            <div class="js-ticket-detail-box js-ticket-post-reply-box"><!-- Ticket Detail Box -->
                                <div class="js-ticket-detail-right" >
                                    <div class="js-ticket-rows-wrp" >
                                        <?php echo jssupportticket::$_data[0]['message']->subject; ?>
                                    </div>
                                </div>

                            </div>

                            <div class="js-ticket-thread-heading"><?php echo __('Message', 'js-support-ticket'); ?></div> <!-- Heading -->
                            <div class="js-ticket-detail-box js-ticket-post-reply-box"><!-- Ticket Detail Box -->
                                <div class="js-ticket-detail-left js-ticket-white-background"><!-- Left Side Image -->
                                    <div class="js-ticket-user-img-wrp">
                                        <?php if (jssupportticket::$_data[0]['message']->staffphoto) {
                                            $maindir = wp_upload_dir();
                                            $path = $maindir['baseurl'];

                                         ?>
                                                <img  class="js-ticket-staff-img" src="<?php echo $path ."/". jssupportticket::$_config['data_directory'] . "/staffdata/staff_" . jssupportticket::$_data[0]['message']->staffphotoid . "/" . jssupportticket::$_data[0]['message']->staffphoto; ?>">
                                        <?php } else { ?>
                                                <img class="js-ticket-staff-img" src="<?php echo jssupportticket::$_pluginpath . '/includes/images/ticketmanbig.png'; ?>" />
                                        <?php } ?>
                                    </div>
                                    <div class="js-ticket-user-name-wrp">
                                       <?php echo isset(jssupportticket::$_data[0]['message']->staffname) ? jssupportticket::$_data[0]['message']->staffname : ''; ?>
                                    </div>
                                    <div class="js-ticket-user-email-wrp">
                                        <?php echo date_i18n("l F d, Y, h:i:s", strtotime(jssupportticket::$_data[0]['message']->created)); ?>
                                    </div>
                                </div>
                                <div class="js-ticket-detail-right js-ticket-background"><!-- Right Side Ticket Data -->
                                    <div class="js-ticket-rows-wrp js-ticket-min-height" >
                                        <div class="js-ticket-row">
                                            <div class="js-ticket-field-value">
                                               <?php echo wp_kses_post(jssupportticket::$_data[0]['message']->message); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                        if (!empty(jssupportticket::$_data['ticket_attachment'])) {
                                        $datadirectory = jssupportticket::$_config['data_directory'];
                                        $maindir = wp_upload_dir();
                                        $path = $maindir['baseurl'];
                                        $path = $path.'/' . $datadirectory;
                                        $path = $path . '/attachmentdata';
                                        $path = $path . '/ticket/ticket_' . jssupportticket::$_data[0]->id . '/'; ?>

                                        <div class="js-ticket-attachments-wrp">
                                            <?php foreach (jssupportticket::$_data['ticket_attachment'] AS $attachment) {
                                                echo '
                                                    <div class="js_ticketattachment">
                                                        <span class="js-ticket-download-file-title">
                                                            ' . $attachment->filename . ' ( ' . $attachment->filesize . ' ) ' . '
                                                        </span>
                                                        <a class="js-download-button" target="_blank" href="' . site_url($path . $attachment->filename) . '">
                                                            <img class="js-ticket-download-img" src=" '.jssupportticket::$_pluginpath .'/includes/images/ticketdetailicon/download-all.png">
                                                        </a>
                                                    </div>';
                                                }
                                                echo'
                                                    <a class="js-all-download-button" target="_blank" href="' . esc_url($path) . '"><img class="js-ticket-all-download-img" src=" '.jssupportticket::$_pluginpath .'/includes/images/ticketdetailicon/download-all.png">'. __('Download All', 'js-support-ticket') . '</a>';?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <?php if (!empty(jssupportticket::$_data[0]['replies'])) { ?>
                            <div class="js-ticket-post-reply-wrapper"><!-- Ticket Post Replay -->
                                <div class="js-ticket-thread-heading"><?php echo __('Replies', 'js-support-ticket'); ?></div> <!-- Heading -->
                                <?php foreach (jssupportticket::$_data[0]['replies'] AS $reply) { ?>
                                    <div class="js-ticket-detail-box js-ticket-post-reply-box"><!-- Ticket Detail Box -->
                                        <div class="js-ticket-detail-left js-ticket-white-background"><!-- Left Side Image -->
                                            <div class="js-ticket-user-img-wrp">
                                                <?php if ($reply->staffphoto) {
                                                        $maindir = wp_upload_dir();
                                                        $path = $maindir['baseurl'];
                                                     ?>
                                                        <img class="js-ticket-staff-img" src="<?php echo $path."/". jssupportticket::$_config['data_directory'] . "/staffdata/staff_" . $reply->staffphotoid . "/" . $reply->staffphoto; ?>">
                                                    <?php } else { ?>
                                                        <img class="js-ticket-staff-img" src="<?php echo jssupportticket::$_pluginpath . '/includes/images/ticketmanbig.png'; ?>" />
                                                <?php } ?>
                                            </div>
                                            <div class="js-ticket-user-name-wrp">
                                                <?php echo $reply->staffname; ?>
                                            </div>
                                            <div class="js-ticket-user-email-wrp">
                                                <?php echo date_i18n("l F d, Y, h:i:s", strtotime($reply->created)); ?>
                                            </div>
                                        </div>
                                        <div class="js-ticket-detail-right js-ticket-background"><!-- Right Side Ticket Data -->
                                            <div class="js-ticket-rows-wrp js-ticket-min-height" >
                                                <div class="js-ticket-row">
                                                    <div class="js-ticket-field-value">
                                                       <?php echo wp_kses_post($reply->message); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php
                        }?>
                        <div class="js-ticket-post-reply-wrapper"><!-- Ticket Post Replay -->
                            <div class="js-ticket-thread-heading"><?php echo __('Type Message', 'js-support-ticket'); ?></div>
                            <form method="post" action="<?php echo jssupportticket::makeUrl(array('jstmod'=>'mail','task'=>'savereply')); ?>">
                                <div class="js-ticket-from-field-wrp js-ticket-from-field-wrp-full-width">
                                    <div class="js-ticket-from-field">
                                        <?php echo wp_editor('', 'message', array('media_buttons' => false)); ?>
                                    </div>
                                </div>
                                <?php echo JSSTformfield::hidden('jssupportticketid', jssupportticket::$_data[0]['message']->id); ?>
                                <?php echo JSSTformfield::hidden('created', isset(jssupportticket::$_data[0]['replies']->created) ? jssupportticket::$_data[0]['replies']->created : ''); ?>
                                <?php echo JSSTformfield::hidden('isread', 2); ?>
                                <?php echo JSSTformfield::hidden('status', 1); ?>
                                <?php echo JSSTformfield::hidden('replytoid', isset(jssupportticket::$_data[0]['message']->id) ? jssupportticket::$_data[0]['message']->id : ''); ?>
                                <?php echo JSSTformfield::hidden('fromid', JSSTincluder::getJSModel('agent')->getStaffId(get_current_user_id())); ?>
                                <?php echo JSSTformfield::hidden('action', 'mail_savereply'); ?>
                                <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
                                <?php echo JSSTformfield::hidden('jsstpageid', get_the_ID()); ?>
                                <div class="js-ticket-form-btn-wrp js-ticket-margin-top">
                                    <?php echo JSSTformfield::submitbutton('save', __('Send', 'js-support-ticket'), array('class' => 'js-ticket-save-button')); ?>
                                </div>
                            </form>
                        </div>
                    <?php
                    }else{
                        JSSTlayout::getNoRecordFound();
                    }
                    ?>
                    <?php
                } else {
                    JSSTlayout::getStaffMemberDisable();
                }
            } else { // user not Staff
                JSSTlayout::getNotStaffMember();
            }
        } else {// User is guest
            $redirect_url = jssupportticket::makeUrl(array('jstmod'=>'mail','jstlay'=>'message'));
            $redirect_url = base64_encode($redirect_url);
            JSSTlayout::getUserGuest($redirect_url);
        }
    } else { // User permission not granted
        JSSTlayout::getPermissionNotGranted();
    }
} else { // System is offline
    JSSTlayout::getSystemOffline();
}
?>
</div>
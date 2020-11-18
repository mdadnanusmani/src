<div class="jsst-main-up-wrapper">
<?php
if (jssupportticket::$_config['offline'] == 2) {
    if (jssupportticket::$_data['permission_granted'] == 1) {
        if (get_current_user_id() != 0) {
            if ( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()) {
                if (jssupportticket::$_data['staff_enabled']) {
                    wp_enqueue_script('formvalidate.js', jssupportticket::$_pluginpath . 'includes/js/jquery.form-validator.js');
                    if (jssupportticket::$_data[0]['unreadmessages'] >= 1) {
                        $inbox = jssupportticket::$_data[0]['unreadmessages'];
                    } else {
                        $inbox = jssupportticket::$_data[0]['totalInboxboxmessages'];
                    }
                    ?>
                    <script type="text/javascript">
                        jQuery(document).ready(function ($) {
                            $.validate();
                        });
                    </script>
                    <?php JSSTbreadcrumbs::getBreadcrumbs(); ?>
                    <?php include_once(jssupportticket::$_path . 'includes/header.php'); ?>
                     <div class="js-ticket-mails-btn-wrp">
                        <div class="js-ticket-mail-btn">
                            <a class="js-add-link button " href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'mail', 'jstlay'=>'inbox'))); ?>">
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
                            <a class="js-add-link button active" href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'mail', 'jstlay'=>'formmessage'))); ?>">
                                <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/add_icon2.png" />
                                <?php echo __('Compose', 'js-support-ticket') ?>
                            </a>
                        </div>
                    </div>
                    <div class="js-ticket-add-form-wrapper">
                        <form class="js-ticket-form" method="post" action="<?php echo jssupportticket::makeUrl(array('jstmod'=>'mail', 'task'=>'savemessage')); ?>">
                            <div class="js-ticket-from-field-wrp js-ticket-from-field-wrp-full-width">
                                <div class="js-ticket-from-field-title">
                                    <?php echo __('To', 'js-support-ticket'); ?>&nbsp;<span style="color: red;" >*</span>
                                </div>
                                <div class="js-ticket-from-field js-ticket-form-field-select">
                                    <?php echo JSSTformfield::select('toid', JSSTincluder::getJSModel('agent')->getStaffForMailCombobox(), isset(jssupportticket::$_data[0]->toid) ? jssupportticket::$_data[0]->toid : '', __('Select Staff', 'js-support-ticket'), array('class' => 'inputbox js-ticket-form-field-select', 'data-validation' => 'required')); ?>
                                </div>
                            </div>
                            <div class="js-ticket-from-field-wrp js-ticket-from-field-wrp-full-width">
                                <div class="js-ticket-from-field-title">
                                    <?php echo __('Subject', 'js-support-ticket'); ?>&nbsp;<span style="color: red;" >*</span>
                                </div>
                                <div class="js-ticket-from-field">
                                    <?php echo JSSTformfield::text('subject', isset(jssupportticket::$_data[0]->subject) ? jssupportticket::$_data[0]->subject : '', array('class' => 'inputbox js-ticket-form-field-input', 'data-validation' => 'required')) ?>
                                </div>
                            </div>
                            <div class="js-ticket-from-field-wrp js-ticket-from-field-wrp-full-width">
                                <div class="js-ticket-from-field-title">
                                    <?php echo __('Type Message', 'js-support-ticket'); ?>&nbsp;<span style="color: red;" >*</span>
                                </div>
                                <div class="js-ticket-from-field">
                                    <?php echo wp_editor(isset(jssupportticket::$_data[0]->message) ? jssupportticket::$_data[0]->message : '', 'message', array('media_buttons' => false)); ?>
                                </div>
                            </div>
                            <?php echo JSSTformfield::hidden('id', isset(jssupportticket::$_data[0]->id) ? jssupportticket::$_data[0]->id : '' ); ?>
                            <?php echo JSSTformfield::hidden('created', isset(jssupportticket::$_data[0]->created) ? jssupportticket::$_data[0]->created : ''); ?>
                            <?php echo JSSTformfield::hidden('isread', 2); ?>
                            <?php echo JSSTformfield::hidden('status', 1); ?>
                            <?php echo JSSTformfield::hidden('fromid', JSSTincluder::getJSModel('agent')->getStaffId(get_current_user_id())); ?>
                            <?php echo JSSTformfield::hidden('action', 'mail_savemessage'); ?>
                            <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
                            <?php echo JSSTformfield::hidden('jsstpageid', get_the_ID()); ?>

                            <div class="js-ticket-form-btn-wrp">
                                <?php echo JSSTformfield::submitbutton('save', __('Send', 'js-support-ticket'), array('class' => 'js-ticket-save-button')); ?>
                               <a href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'mail', 'jstlay'=>'inbox')));?>" class="js-ticket-cancel-button"><?php echo __('Cancel','js-support-ticket'); ?></a>
                            </div>
                        </form>
                    </div>
                    <?php
                } else {
                    JSSTlayout::getStaffMemberDisable();
                }
            } else { // user not Staff
                JSSTlayout::getNotStaffMember();
            }
        } else {
            $redirect_url = jssupportticket::makeUrl(array('jstmod'=>'mail', 'jstlay'=>'formmessage'));
            $redirect_url = base64_encode($redirect_url);
            JSSTlayout::getUserGuest($redirect_url);
        }
    } else { // User permission not granted
        JSSTlayout::getPermissionNotGranted();
    }
} else {
    JSSTlayout::getSystemOffline();
}
?>

</div>



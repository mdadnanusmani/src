<div class="jsst-main-up-wrapper">
<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
if (jssupportticket::$_config['offline'] == 2) {
    if (jssupportticket::$_data['permission_granted'] == 1) {
        if (get_current_user_id() != 0) {
            if ( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()) {
                if (jssupportticket::$_data['staff_enabled']) {
                    wp_enqueue_script('jquery-ui-datepicker');
                    wp_enqueue_script('file_validate.js', jssupportticket::$_pluginpath . 'includes/js/file_validate.js');
                    wp_enqueue_style('jquery-ui-css', $protocol.'ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
                    wp_enqueue_script('formvalidate.js', jssupportticket::$_pluginpath . 'includes/js/jquery.form-validator.js');
                    ?>
                    <?php
                    $status = array((object) array('id' => '1', 'text' => __('Active', 'js-support-ticket')),
                        (object) array('id' => '0', 'text' => __('Disabled', 'js-support-ticket'))
                    );
                    ?>
                    <script type="text/javascript">
                        jQuery(document).ready(function ($) {
                            $.validate();
                            $('.custom_date').datepicker({
                                dateFormat: 'yy-mm-dd'
                            });
                            jQuery("#tk_attachment_add").click(function () {
                                var obj = this;
                                var current_files = jQuery('input[type="file"]').length;
                                var total_allow =<?php echo jssupportticket::$_config['no_of_attachement']; ?>;
                                var append_text = "<span class='tk_attachment_value_text'><input name='filename[]' type='file' onchange=\"uploadfile(this,'<?php echo jssupportticket::$_config['file_maximum_size']; ?>','<?php echo jssupportticket::$_config['file_extension']; ?>');\" size='20'  /><span  class='tk_attachment_remove'></span></span>";

                                <?php if(isset(jssupportticket::$_data[5]) && count(jssupportticket::$_data[5]) > 0){ ?>
                                current_files += <?php echo count(jssupportticket::$_data[5]); ?>;
                                <?php } ?>

                                if (current_files < total_allow) {
                                    jQuery(".tk_attachment_value_wrapperform").append(append_text);
                                } else if ((current_files === total_allow) || (current_files > total_allow)) {
                                    alert('<?php echo __('File upload limit exceed', 'js-support-ticket'); ?>');
                                    obj.hide();
                                }
                            });
                            jQuery(document).delegate(".tk_attachment_remove", "click", function (e) {
                                jQuery(this).parent().remove();
                                var current_files = jQuery('input[type="file"]').length;
                                var total_allow =<?php echo jssupportticket::$_config['no_of_attachement']; ?>;
                                if (current_files < total_allow) {
                                    jQuery("#tk_attachment_add").show();
                                }
                            });
                        });
                    </script>
                    <?php JSSTmessage::getMessage(); ?>
                    <span style="display:none" id="filesize"><?php echo __('Error file size too large', 'js-support-ticket'); ?></span>
                    <span style="display:none" id="fileext"><?php echo __('Error file ext mismatch', 'js-support-ticket'); ?></span>
                    <?php JSSTbreadcrumbs::getBreadcrumbs(); ?>
                    <?php include_once(jssupportticket::$_path . 'includes/header.php'); ?>

                    <div class="js-ticket-add-form-wrapper">
                        <form class="js-ticket-form" method="post" action="<?php echo jssupportticket::makeUrl(array('jstmod'=>'download', 'task'=>'savedownload')); ?>" enctype="multipart/form-data" >
                            <div class="js-ticket-from-field-wrp">
                                <div class="js-ticket-from-field-title">
                                    <?php echo __('Title', 'js-support-ticket'); ?>&nbsp;<span style="color: red;" >*</span>
                                </div>
                                <div class="js-ticket-from-field">
                                    <?php echo JSSTformfield::text('title', isset(jssupportticket::$_data[0]->title) ? jssupportticket::$_data[0]->title : '', array('class' => 'inputbox js-ticket-form-field-input', 'data-validation' => 'required')) ?>
                                </div>
                            </div>
                            <?php if(in_array('knowledgebase', jssupportticket::$_active_addons)){ ?>
                                <div class="js-ticket-from-field-wrp">
                                    <div class="js-ticket-from-field-title">
                                        <?php echo __('Parent Category', 'js-support-ticket'); ?>
                                    </div>
                                    <div class="js-ticket-from-field js-ticket-form-field-select">
                                        <?php echo JSSTformfield::select('categoryid', JSSTincluder::getJSModel('knowledgebase')->getCategoryForCombobox('downloads'), isset(jssupportticket::$_data[0]->categoryid) ? jssupportticket::$_data[0]->categoryid : '', __('Select Category', 'js-support-ticket'), array('class' => 'inputbox js-ticket-form-field-input', 'data-validation' => '')); ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="js-ticket-from-field-wrp js-ticket-from-field-wrp-full-width ">
                                <div class="js-ticket-from-field-title">
                                    <?php echo __('Description', 'js-support-ticket'); ?>
                                </div>
                                <div class="js-ticket-from-field">
                                    <?php echo wp_editor(isset(jssupportticket::$_data[0]->description) ? jssupportticket::$_data[0]->description : '', 'description', array('media_buttons' => false)); ?>
                                </div>
                            </div>
                            <?php $nAttachmentAllowed = jssupportticket::$_config['no_of_attachement'];/*Attachments*/
                                if(!isset(jssupportticket::$_data[5]) || count(jssupportticket::$_data[5]) <= $nAttachmentAllowed){ ?>
                                    <div class="js-ticket-reply-attachments"><!-- Attachments -->
                                        <div class="js-attachment-field-title"><?php echo __('Attachments', 'js-support-ticket'); ?></div>
                                        <div class="js-attachment-field">
                                            <div class="tk_attachment_value_wrapperform tk_attachment_user_reply_wrapper">
                                                <span class="tk_attachment_value_text">
                                                    <input type="file" class="inputbox js-attachment-inputbox" name="filename[]" onchange="uploadfile(this, '<?php echo jssupportticket::$_config['file_maximum_size']; ?>', '<?php echo jssupportticket::$_config['file_extension']; ?>');" size="20" />
                                                    <span class='tk_attachment_remove'></span>
                                                </span>
                                            </div>
                                            <span class="tk_attachments_configform">
                                                <?php echo __('Maximum File Size', 'js-support-ticket');
                                                      echo ' (' . jssupportticket::$_config['file_maximum_size']; ?>KB)<br><?php echo __('File Extension Type', 'js-support-ticket');
                                                      echo ' (' . jssupportticket::$_config['file_extension'] . ')'; ?>
                                            </span>
                                            <span id="tk_attachment_add" data-ident="tk_attachment_user_reply_wrapper" class="tk_attachments_addform"><?php echo __('Add more', 'js-support-ticket'); ?></span>
                                        </div>
                                        <?php if (!empty(jssupportticket::$_data[5])) {
                                                foreach (jssupportticket::$_data[5] AS $attachment) {
                                                    echo '
                                                        <div class="js-ticket-attached-files-wrp">
                                                            <div class="js_ticketattachment">
                                                                    ' . $attachment->filename . ' ( ' . $attachment->filesize . ' ) ' . '
                                                            </div>
                                                            <a class="js-ticket-delete-attachment" href="'.wp_nonce_url(jssupportticket::makeUrl(array('jstmod'=>'downloadattachment', 'task'=>'deleteattachment', 'action'=>'jstask', 'id'=>$attachment->id, 'downloadid'=>jssupportticket::$_data[0]->id, 'jsstpageid'=>get_the_ID())),'delete-attachement') . '">' . __('Remove','js-support-ticket') . '</a>
                                                        </div>';
                                                }
                                        } ?>
                                    </div>
                            <?php } ?>
                            <div class="js-ticket-from-field-wrp">
                                <div class="js-ticket-from-field-title">
                                    <?php echo __('Status', 'js-support-ticket'); ?>
                                </div>
                                <div class="js-ticket-from-field js-ticket-form-field-select">
                                    <?php echo JSSTformfield::select('status', $status, isset(jssupportticket::$_data[0]->status) ? jssupportticket::$_data[0]->status : '', __('Select Status', 'js-support-ticket'), array('class' => 'inputbox js-ticket-form-field-input')); ?>
                                </div>
                            </div>
                            <?php echo JSSTformfield::hidden('id', isset(jssupportticket::$_data[0]->id) ? jssupportticket::$_data[0]->id : ''); ?>
                            <?php echo JSSTformfield::hidden('created', isset(jssupportticket::$_data[0]->created) ? jssupportticket::$_data[0]->created : ''); ?>
                            <?php echo JSSTformfield::hidden('ordering', isset(jssupportticket::$_data[0]->ordering) ? jssupportticket::$_data[0]->ordering : ''); ?>
                            <?php echo JSSTformfield::hidden('action', 'download_savedownload'); ?>
                            <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
                            <?php echo JSSTformfield::hidden('jsstpageid', get_the_ID()); ?>
                            <div class="js-ticket-form-btn-wrp">
                                <?php echo JSSTformfield::submitbutton('save', __('Save Download', 'js-support-ticket'), array('class' => 'js-ticket-save-button')); ?>
                               <a href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'download', 'jstlay'=>'staffdownloads')));?>" class="js-ticket-cancel-button"><?php echo __('Cancel','js-support-ticket'); ?></a>
                            </div>
                        </form>
                    </div>
                    <?php
                } else {
                    JSSTlayout::getStaffMemberDisable();
                }
            } else {
                JSSTlayout::getNotStaffMember();
            }
        } else {
            $redirect_url = jssupportticket::makeUrl(array('jstmod'=>'download', 'jstlay'=>'adddownload'));
            $redirect_url = base64_encode($redirect_url);
            JSSTlayout::getUserGuest($redirect_url);
        }
    } else { // User permission not granted
        JSSTlayout::getPermissionNotGranted();
    }
} else {
    JSSTlayout::getSystemOffline();
} ?>
</div>
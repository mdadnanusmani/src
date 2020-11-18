<div class="jsst-main-up-wrapper">
<?php
if (jssupportticket::$_config['offline'] == 2) {
    if (jssupportticket::$_data['permission_granted'] == 1) {
        if (get_current_user_id() != 0) {
            if ( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()) {
                if (jssupportticket::$_data['staff_enabled']) {
                    wp_enqueue_script('formvalidate.js', jssupportticket::$_pluginpath . 'includes/js/jquery.form-validator.js');
                    ?>
                    <script type="text/javascript">
                        function updateuserlist(pagenum){
                            jQuery.post(ajaxurl, {action: 'jsticket_ajax', jstmod: 'agent', task: 'getuserlistajax',userlimit:pagenum}, function (data) {
                                if(data){
                                    jQuery("div#records").html("");
                                    jQuery("div#records").html(data);
                                    setUserLink();
                                }
                            });
                        }
                        function setUserLink() {
                            jQuery("a.js-userpopup-link").each(function () {
                                var anchor = jQuery(this);
                                jQuery(anchor).click(function (e) {
                                    var id = jQuery(this).attr('data-id');
                                    var name = jQuery(this).html();
                                    var email = jQuery(this).attr('data-email');
                                    var displayname = jQuery(this).attr('data-name');
                                    jQuery("input#username-text").val(name);
                                    if(jQuery('input#firstname').val() == ''){
                                        jQuery('input#firstname').val(displayname);
                                    }
                                    if(jQuery('input#email').val() == ''){
                                        jQuery('input#email').val(email);
                                    }
                                    jQuery("input#uid").val(id);
                                    jQuery("div#userpopup").slideUp('slow', function () {
                                        jQuery("div#userpopupblack").hide();
                                    });
                                });
                            });
                        }
                        jQuery(document).ready(function () {
                            jQuery("a#userpopup").click(function (e) {
                                e.preventDefault();
                                jQuery("div#userpopupblack").show();
                                jQuery.post(ajaxurl, {action: 'jsticket_ajax', jstmod: 'agent', task: 'getuserlistajax'}, function (data) {
                                    if(data){
                                        jQuery("div#records").html("");
                                        jQuery("div#records").html(data);
                                        setUserLink();
                                    }
                                });
                                jQuery("div#userpopup").slideDown('slow');
                            });
                            jQuery("div.popup-header-close-img").click(function (e) {
                                jQuery("div#userpopup").slideUp('slow');
                                setTimeout(function () {
                                    jQuery("div#userpopupblack").hide();
                                }, 700);
                            });
                            jQuery("form#userpopupsearch").submit(function (e) {
                                e.preventDefault();
                                var username = jQuery("input#username").val();
                                var name = jQuery("input#name").val();
                                var emailaddress = jQuery("input#emailaddress").val();
                                jQuery.post(ajaxurl, {action: 'jsticket_ajax', name: name, username: username, emailaddress: emailaddress, jstmod: 'agent', task: 'getusersearchajax'}, function (data) {
                                    if (data) {
                                        jQuery("div#records").html(data);
                                        setUserLink();
                                    }
                                });//jquery closed
                            });
                        });
                        jQuery(document).ready(function ($) {
                            $.validate();
                        });
                        function uploadfile(fileobj, fileextensionallow) {
                            var file = fileobj.files[0];
                            var name = file.name;
                            var type = file.type;
                            var fileext = getExtension(name);
                            replace_txt = "<input type='file' class='inputbox' name='filename' onchange='uploadfile(this," + '"' + fileextensionallow + '"' + ");' size='20' />";
                            var f_e_a = fileextensionallow.split(','); // file extension allow array
                            var isfileextensionallow = checkExtension(f_e_a, fileext);
                            if (isfileextensionallow == 'N') {
                                jQuery(fileobj).replaceWith(replace_txt);
                                alert(jQuery('span#fileext').html());
                                return false;
                            }
                            return true;
                        }
                        function  checkExtension(f_e_a, fileext) {
                            var match = 'N';
                            for (var i = 0; i < f_e_a.length; i++) {
                                if (f_e_a[i].toLowerCase() === fileext.toLowerCase()) {
                                    match = 'Y';
                                    return match;
                                }
                            }
                            return match;
                        }
                        function getExtension(filename) {
                            return filename.split('.').pop().toLowerCase();
                        }
                    </script>

                    <?php
                    $status = array((object) array('id' => '1', 'text' => __('Active', 'js-support-ticket')),
                        (object) array('id' => '0', 'text' => __('Disabled', 'js-support-ticket'))
                    );
                    ?>
                    <span style="display:none" id="fileext"><?php echo __('Error file ext mismatch', 'js-support-ticket'); ?></span>
                    <div id="userpopupblack" style="display:none;"></div>
                    <div id="userpopup" class="" style="display:none;"><!-- Select User Popup -->
                        <div class="jsst-popup-header">
                            <div class="popup-header-text"><?php echo __('Select user','js-support-ticket'); ?></div><div class="popup-header-close-img"></div>
                        </div>
                        <div class="js-ticket-popup-search-wrp">
                            <form id="userpopupsearch">
                                <div class="js-ticket-search-top">
                                    <div class="js-ticket-search-left">
                                        <div class="js-ticket-search-fields-wrp">
                                            <input class="js-ticket-search-input-fields" type="text" name="username" id="username" placeholder="<?php echo __('Username','js-support-ticket'); ?>" />
                                            <input class="js-ticket-search-input-fields" type="text" name="name" id="name" placeholder="<?php echo __('Name','js-support-ticket'); ?>" />
                                            <input class="js-ticket-search-input-fields" type="text" name="emailaddress" id="emailaddress" placeholder="<?php echo __('Email Address','js-support-ticket'); ?>" />
                                        </div>
                                    </div>
                                    <div class="js-ticket-search-right">
                                        <div class="js-ticket-search-btn-wrp">
                                            <input value="Search" type="submit" class="js-ticket-search-btn">
                                            <input type="submit" class="js-ticket-reset-btn" onclick="document.getElementById('name').value = '';document.getElementById('username').value = ''; document.getElementById('emailaddress').value = '';" value="<?php echo __('Reset','js-support-ticket'); ?>" />
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="records">
                            <div id="records-inner">
                                <div class="js-staff-searc-desc">
                                    <?php echo __('Use Search Feature To Select The User','js-support-ticket'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php JSSTbreadcrumbs::getBreadcrumbs(); ?>
                    <?php include_once(jssupportticket::$_path . 'includes/header.php'); ?>

                    <div class="js-ticket-add-form-wrapper">
                        <form class="js-ticket-form" method="post" action="<?php echo jssupportticket::makeUrl(array('jstmod'=>'agent','task'=>'savestaff')); ?>" enctype="multipart/form-data">
                            <div class="js-ticket-from-field-wrp">
                                <div class="js-ticket-from-field-title"><?php echo __('User', 'js-support-ticket'); ?></div>
                                <div class="js-ticket-from-field">
                                    <?php if (isset(jssupportticket::$_data[0]->uid)) { ?>
                                        <input class="js-ticket-form-field-input" type="text" value="<?php echo jssupportticket::$_data[0]->firstname . ' ' . jssupportticket::$_data[0]->lastname; ?>" id="username-text" readonly="readonly" data-validation="required"/>
                                    <?php } else { ?>
                                        <div class="js-ticket-select-user-field">
                                            <input class="js-ticket-form-field-input" type="text" value="<?php if(isset($formdata['username-text'])) echo $formdata['username-text']; ?>" id="username-text" readonly="readonly"/>
                                        </div>
                                        <div class="js-ticket-select-user-btn">
                                            <a href="#" id="userpopup"><?php echo __('Select User', 'js-support-ticket'); ?></a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="js-ticket-from-field-wrp ">
                                <div class="js-ticket-from-field-title"><?php echo __('Roles', 'js-support-ticket'); ?>&nbsp;<span style="color: red">*</span>&nbsp;<small><?php echo isset(jssupportticket::$_data[0]->id) ? __('', 'js-support-ticket') : ''; ?></small></div>
                                <div class="js-ticket-from-field js-ticket-form-field-select">
                                    <?php echo JSSTformfield::select('roleid', JSSTincluder::getJSModel('role')->getRolesForCombobox(), isset(jssupportticket::$_data[0]->roleid) ? jssupportticket::$_data[0]->roleid : '', __('Select Role', 'js-support-ticket'), array('class' => 'inputbox js-ticket-select-field', 'data-validation' => 'required')); ?>
                                </div>
                            </div>
                            <div class="js-ticket-from-field-wrp">
                                <div class="js-ticket-from-field-title"><?php echo __('First Name', 'js-support-ticket'); ?>&nbsp;<span style="color: red">*</span></div>
                                <div class="js-ticket-from-field">
                                    <?php echo JSSTformfield::text('firstname', isset(jssupportticket::$_data[0]->firstname) ? jssupportticket::$_data[0]->firstname : '', array('class' => 'inputbox js-ticket-form-field-input', 'data-validation' => 'required')) ?>
                                </div>
                            </div>
                            <div class="js-ticket-from-field-wrp">
                                <div class="js-ticket-from-field-title"><?php echo __('Last Name', 'js-support-ticket'); ?>&nbsp;<span style="color: red">*</span></div>
                                <div class="js-ticket-from-field">
                                    <?php echo JSSTformfield::text('lastname', isset(jssupportticket::$_data[0]->lastname) ? jssupportticket::$_data[0]->lastname : '', array('class' => 'inputbox js-ticket-form-field-input', 'data-validation' => 'required')) ?>
                                </div>
                            </div>
                            <div class="js-ticket-from-field-wrp">
                                <div class="js-ticket-from-field-title"><?php echo __('Email Address', 'js-support-ticket'); ?>&nbsp;<span style="color: red">*</span></div>
                                <div class="js-ticket-from-field">
                                    <?php echo JSSTformfield::text('email', isset(jssupportticket::$_data[0]->email) ? jssupportticket::$_data[0]->email : '', array('class' => 'inputbox js-ticket-form-field-input', 'data-validation' => 'required')) ?>
                                </div>
                            </div>
                            <div class="js-ticket-from-field-wrp">
                                <div class="js-ticket-from-field-title"><?php echo __('Office Phone', 'js-support-ticket'); ?></div>
                                <div class="js-ticket-from-field">
                                    <?php echo JSSTformfield::text('phone', isset(jssupportticket::$_data[0]->phone) ? jssupportticket::$_data[0]->phone : '', array('class' => 'inputbox js-ticket-form-field-input')) ?>
                                </div>
                            </div>
                            <div class="js-ticket-from-field-wrp">
                                <div class="js-ticket-from-field-title"><?php echo __('Extension', 'js-support-ticket'); ?></div>
                                <div class="js-ticket-from-field">
                                    <?php echo JSSTformfield::text('phoneext', isset(jssupportticket::$_data[0]->phoneext) ? jssupportticket::$_data[0]->phoneext : '', array('class' => 'inputbox js-ticket-form-field-input')) ?>
                                </div>
                            </div>
                            <div class="js-ticket-from-field-wrp">
                                <div class="js-ticket-from-field-title"><?php echo __('Mobile No', 'js-support-ticket'); ?></div>
                                <div class="js-ticket-from-field">
                                    <?php echo JSSTformfield::text('mobile', isset(jssupportticket::$_data[0]->mobile) ? jssupportticket::$_data[0]->mobile : '', array('class' => 'inputbox js-ticket-form-field-input')) ?>
                                </div>
                            </div>
                            <div class="js-ticket-reply-attachments"><!-- Attachments -->
                                <div class="js-attachment-field-title"><?php echo __('Picture', 'js-support-ticket'); ?></div>
                                <div class="js-attachment-field">
                                    <div class="tk_attachment_value_wrapperform tk_attachment_user_reply_wrapper">
                                        <span class="tk_attachment_value_text">
                                            <input type="file" class="inputbox js-attachment-inputbox" name="filename" onchange="uploadfile(this, '<?php echo jssupportticket::$_config['file_extension']; ?>');" size="20"/>
                                        </span>
                                        <?php if (isset(jssupportticket::$_data[0]->photo) && !empty(jssupportticket::$_data[0]->photo)){
                                             $maindir = wp_upload_dir();
                                             $path = $maindir['baseurl'];
                                             echo '<span class="js-ticket-staff-img"><img alt="image" class="jsticketstafflogo" height="100" width="160" src="' . $path . "/" . jssupportticket::$_config['data_directory'] . "/staffdata/staff_" . jssupportticket::$_data[0]->id . "/" . jssupportticket::$_data[0]->photo . '" /></span>';
                                         }
                                         ?>
                                    </div>
                                    <span class="tk_attachments_configform">
                                        <?php echo __('Maximum File Size', 'js-support-ticket');
                                              echo ' (' . jssupportticket::$_config['file_maximum_size']; ?>KB)<br><?php echo __('File Extension Type', 'js-support-ticket');
                                              echo ' (' . jssupportticket::$_config['file_extension'] . ')'; ?>
                                    </span>
                                </div>
                            </div>
                            <div class="js-ticket-append-signature-wrp js-ticket-append-signature-wrp-full-width"><!-- Append Signature -->
                                <div class="js-ticket-append-field-title"><?php echo __('Append Signature', 'js-support-ticket'); ?></div>
                                <div class="js-ticket-append-field-wrp">
                                    <div class="js-ticket-signature-radio-box js-ticket-signature-radio-box-full-width ">
                                        <?php echo JSSTformfield::checkbox('canappendsignature', array('1' => __('Append signature with reply', 'js-support-ticket')), isset(jssupportticket::$_data[0]->canappendsignature) ? jssupportticket::$_data[0]->canappendsignature : '', array('class' => 'radiobutton js-ticket-append-radio-btn')); ?>
                                    </div>

                                </div>
                            </div>
                            <div class="js-ticket-from-field-wrp js-ticket-from-field-wrp-full-width ">
                                <div class="js-ticket-from-field-title"><?php echo __('Signature', 'js-support-ticket'); ?></div>
                                <div class="js-ticket-from-field">
                                    <?php echo wp_editor(isset(jssupportticket::$_data[0]->signature) ? jssupportticket::$_data[0]->signature : '', 'signature', array('media_buttons' => false)); ?>
                                </div>
                            </div>
                            <div class="js-ticket-from-field-wrp js-ticket-from-field-wrp-full-width">
                                <div class="js-ticket-from-field-title"><?php echo __('Account Status', 'js-support-ticket'); ?></div>
                                <div class="js-ticket-from-field js-ticket-form-field-select">
                                    <?php echo JSSTformfield::select('status', $status, isset(jssupportticket::$_data[0]->status) ? jssupportticket::$_data[0]->status : '1', __('Select Status', 'js-support-ticket'), array('class'=>'js-ticket-select-field inputbox')); ?>
                                </div>
                            </div>

                            <?php echo JSSTformfield::hidden('id', isset(jssupportticket::$_data[0]->id) ? jssupportticket::$_data[0]->id : '' ); ?>
                            <?php echo JSSTformfield::hidden('uid', isset(jssupportticket::$_data[0]->uid) ? jssupportticket::$_data[0]->uid : '' ); ?>
                            <?php echo JSSTformfield::hidden('created', isset(jssupportticket::$_data[0]->created) ? jssupportticket::$_data[0]->created : ''); ?>
                            <?php echo JSSTformfield::hidden('updated', isset(jssupportticket::$_data[0]->updated) ? jssupportticket::$_data[0]->updated : '' ); ?>
                            <?php echo JSSTformfield::hidden('photo', isset(jssupportticket::$_data[0]->photo) ? jssupportticket::$_data[0]->photo : '' ); ?>
                            <?php echo JSSTformfield::hidden('action', 'staff_savestaff'); ?>
                            <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
                            <?php echo JSSTformfield::hidden('jsstpageid', get_the_ID()); ?>

                            <div class="js-ticket-form-btn-wrp">
                                <?php echo JSSTformfield::submitbutton('save', __('Save', 'js-support-ticket'), array('class' => 'js-ticket-save-button')); ?>
                                <a href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'agent', 'jstlay'=>'staffs')));?>" class="js-ticket-cancel-button"><?php echo __('Cancel','js-support-ticket'); ?></a>
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
        } else {// User is guest
            $redirect_url = jssupportticket::makeUrl(array('jstmod'=>'agent','jstlay'=>'addstaff'));
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
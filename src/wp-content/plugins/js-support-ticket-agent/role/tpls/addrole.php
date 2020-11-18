<div class="jsst-main-up-wrapper">
<?php
if (jssupportticket::$_config['offline'] == 2) {
    if (jssupportticket::$_data['permission_granted'] == 1) {
        if (get_current_user_id() != 0) {
            if ( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()) {
                if (jssupportticket::$_data['staff_enabled']) {
                    if (jssupportticket::$_data['permission_granted'] == true) {
                        wp_enqueue_script('formvalidate.js', jssupportticket::$_pluginpath . 'includes/js/jquery.form-validator.js');
                        ?>
                        <script>
                            function selectdeseletsection(sectionid, sectionclass) {
                                var obj = jQuery('#' + sectionid);
                                if (obj.is(":checked")) {
                                    jQuery('.' + sectionclass).each(function () { //loop through each checkbox
                                        this.checked = true;  //select all checkboxes with class "rolepermission"
                                    });
                                } else {
                                    jQuery('.' + sectionclass).each(function () { //loop through each checkbox
                                        this.checked = false; //deselect all checkboxes with class "rolepermission"
                                    });
                                }
                            }
                            jQuery(document).ready(function ($) {
                                $.validate();
                            });
                        </script>
                        <?php JSSTbreadcrumbs::getBreadcrumbs(); ?>
                        <?php include_once(jssupportticket::$_path . 'includes/header.php'); ?>
                        <div class="js-ticket-add-form-wrapper">
                            <form class="js-ticket-form" method="post" action="<?php echo jssupportticket::makeUrl(array('jstmod'=>'role','task'=>'saverole')); ?>">
                                <div class="js-ticket-from-field-wrp js-ticket-from-field-wrp-full-width js-ticket-add-role-field-wrp-top">
                                    <div class="js-ticket-from-field-title">
                                        <?php echo __('Name', 'js-support-ticket'); ?>&nbsp;<span style="color: red;">*</span>
                                    </div>
                                    <div class="js-ticket-from-field">
                                        <?php echo JSSTformfield::text('name', isset(jssupportticket::$_data[0]['role']->name) ? jssupportticket::$_data[0]['role']->name : '', array('class' => 'inputbox js-ticket-form-field-input', 'data-validation' => 'required')) ?>
                                    </div>
                                </div>
                                <?php
                                $deptext = __('Department Section', 'js-support-ticket');
                                $depid = "rad_alldepartmentaccess";
                                $depclass = "rad_departmentaccess";
                                ?>
                                <div class="js-ticket-roles-wrapper">
                                    <div class="js-ticket-categories-heading-wrp">
                                        <?php echo $deptext; ?>
                                        <span class="js-ticket-roles-section-heading-right">
                                            <label>
                                                <input type="checkbox" id="<?php echo $depid; ?>"<?php if (!isset(jssupportticket::$_data[0]['role']->id)) echo 'checked="checked"'; ?>  onclick="selectdeseletsection('<?php echo $depid; ?>', '<?php echo $depclass; ?>');" />
                                                <?php echo __('Select / Deselect All', 'js-support-ticket'); ?></label>
                                        </span>
                                    </div>
                                    <div class="js-ticket-role-wrp">
                                        <?php $numberofrows = 0;
                                        foreach (jssupportticket::$_data[0]['department_role'] AS $dep) {
                                            if ($numberofrows % 3 == 0 && $numberofrows > 0) {
                                                //echo '</div> <div class="js-col-xs-12 js-col-md-12">';
                                            } ?>
                                            <div class="js-ticket-add-role-field-wrp">
                                                <?php $dchecked_or_not = "";
                                                    if (isset(jssupportticket::$_data[0]['role']->id)) {  //edit case
                                                        if (isset($dep->roledepartmentid)) {
                                                            $dchecked_or_not = ($dep->roledepartmentid == $dep->id) ? "checked='checked'" : "";
                                                        };
                                                    } else { //add case
                                                        $dchecked_or_not = "checked='checked'";
                                                    }
                                                    ?>
                                                <label class="<?php echo $depclass; ?> js-ticket-label" >
                                                    <input type='checkbox' class="<?php echo $depclass; ?> js-ticket-checkbox" name='roledepdata[<?php echo $dep->name; ?>]' value="<?php echo $dep->id ?>" <?php echo $dchecked_or_not; ?>  />
                                                    <?php echo __($dep->name, 'js-support-ticket'); ?></label>
                                            </div>
                                        <?php
                                            $numberofrows += 1;
                                        }
                                        ?>
                                    </div>
                                    <?php
                                        $permission_keys = array_keys(jssupportticket::$_data[0]['permission_by_task']);
                                        foreach ($permission_keys AS $permissin_by_section) {
                                            switch ($permissin_by_section) {
                                                case 'ticket_section':
                                                    $text = __('Ticket Section', 'js-support-ticket');
                                                    $id = "t_s_allrolepermision";
                                                    $class = "t_s_rolepermission";
                                                    $section = 'ticke';
                                                    break;
                                                case 'staff_section':
                                                    $text = __('Staff Section', 'js-support-ticket');
                                                    $id = "s_s_allrolepermision";
                                                    $class = "s_s_rolepermission";
                                                    $section = 'agent';

                                                    break;
                                                case 'kb_section':
                                                    $text = __('Knowledge Base Section', 'js-support-ticket');
                                                    $id = "kb_s_allrolepermision";
                                                    $class = "kb_s_rolepermission";
                                                    $section = 'kb';

                                                    break;
                                                case 'faq_section':
                                                    $text = __('FAQ Section', 'js-support-ticket');
                                                    $id = "f_s_allrolepermision";
                                                    $class = "f_s_rolepermission";
                                                    $section = 'faqs';

                                                    break;
                                                case 'download_section':
                                                    $text = __('Download Section', 'js-support-ticket');
                                                    $id = "d_s_allrolepermision";
                                                    $class = "d_s_rolepermission";
                                                    $section = 'staffdownloads';

                                                    break;
                                                case 'announcement_section':
                                                    $text = __('Announcement Section', 'js-support-ticket');
                                                    $id = "a_s_allrolepermision";
                                                    $class = "a_s_rolepermission";
                                                    $section = 'announcement';
                                                    break;
                                                case 'mail_section':
                                                    $text = __('Mail Section', 'js-support-ticket');
                                                    $id = "m_s_allrolepermision";
                                                    $class = "m_s_rolepermission";
                                                    $section = 'mail';
                                                    break;
                                            }
                                            ?>
                                            <div class="js-ticket-categories-heading-wrp">
                                                <?php echo $text; ?>
                                                <span class="js-ticket-roles-section-heading-right">
                                                    <label for="<?php echo $id; ?>">
                                                        <input  type="checkbox" id="<?php echo $id; ?>" <?php if (!isset(jssupportticket::$_data[0]['role']->id)) echo 'checked="checked"'; ?> onclick="selectdeseletsection('<?php echo $id; ?>', '<?php echo $class; ?>');" />
                                                        <?php echo __('Select / Deselect All', 'js-support-ticket'); ?></label>
                                                </span>
                                            </div>
                                            <div class="js-ticket-role-wrp">
                                                <?php
                                                $numberofrows = 0;
                                                foreach (jssupportticket::$_data[0]['permission_by_task'][$permissin_by_section] AS $per) {
                                                    if ($numberofrows > 0)
                                                        if ($numberofrows % 3 == 0)
                                                            //echo '</div> <div class="js-col-xs-12 js-col-md-12">';
                                                    ?>
                                                    <div class="js-ticket-add-role-field-wrp js-ticket-margin-bottom">
                                                        <?php
                                                        $checked_or_not = "";
                                                        if (isset(jssupportticket::$_data[0]['role']->id)) {  //edit case
                                                            if (isset($per->rolepermissionid)) {
                                                                $checked_or_not = ($per->rolepermissionid == $per->id) ? "checked='checked'" : "";
                                                            } ?>
                                                        <?php
                                                        }else { //add case
                                                            if (isset(jssupportticket::$_data[0]['staffid'])) // in case of all permissions removed
                                                                $checked_or_not = "";
                                                            else
                                                                $checked_or_not = "checked='checked'";
                                                        }
                                                        ?>

                                                        <label class=" <?php echo $class ;?> js-ticket-label" >
                                                            <input type='checkbox' class="<?php echo $class ;?> js-ticket-checkbox" name='roleperdata[<?php echo $per->permission ?>]' value="<?php echo $per->id ?>" <?php echo $checked_or_not; ?> />
                                                            <?php echo __($per->permission, 'js-support-ticket'); ?></label>
                                                    </div>
                                                <?php
                                                    $numberofrows += 1;
                                                }
                                                ?>
                                            </div>
                                    <?php }
                                    ?>
                                    <?php echo JSSTformfield::hidden('id', isset(jssupportticket::$_data[0]['role']->id) ? jssupportticket::$_data[0]['role']->id : '' ); ?>
                                    <?php echo JSSTformfield::hidden('created', isset(jssupportticket::$_data[0]['role']->created) ? jssupportticket::$_data[0]['role']->created : '' ); ?>
                                    <?php echo JSSTformfield::hidden('jsstpageid', get_the_ID()); ?>
                                    <?php echo JSSTformfield::hidden('updated', isset(jssupportticket::$_data[0]['role']->updated) ? jssupportticket::$_data[0]['role']->updated : '' ); ?>
                                    <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
                                    <div class="js-ticket-form-btn-wrp">
                                        <?php echo JSSTformfield::submitbutton('save', __('Save Role', 'js-support-ticket'), array('class' => 'js-ticket-save-button')); ?>
                                        <a href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'role', 'jstlay'=>'roles')));?>" class="js-ticket-cancel-button"><?php echo __('Cancel','js-support-ticket'); ?></a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <?php
                    } else {
                        // user not granted
                        JSSTlayout::getPermissionNotGranted();
                    }
                } else {
                    JSSTlayout::getStaffMemberDisable();
                }
            } else { // user not Staff
                JSSTlayout::getNotStaffMember();
            }
        } else {// User is guest
            $redirect_url = jssupportticket::makeUrl(array('jstmod'=>'role','jstlay'=>'addrole'));
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
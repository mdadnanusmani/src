<div class="jsst-main-up-wrapper">
<?php
if (jssupportticket::$_config['offline'] == 2) {
    if (jssupportticket::$_data['permission_granted'] == 1) {
        if (get_current_user_id() != 0) {
            if ( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()) {
                if (jssupportticket::$_data['staff_enabled']) {
                    ?>
                    <script type="text/javascript">
                        function resetFrom() {
                            document.getElementById('jsst-name').value = '';
                            document.getElementById('jsst-status').value = '';
                            document.getElementById('jsst-role').value = '';
                            return true;
                        }
                        function addSpaces() {
                            document.getElementById('jsst-name').value = fillSpaces(document.getElementById('jsst-name').value);
                            return true;
                        }
                    </script>
                    <?php
                    $status = array(
                        (object) array('id' => '1', 'text' => __('Active', 'js-support-ticket')),
                        (object) array('id' => '2', 'text' => __('Disabled', 'js-support-ticket'))
                    );
                    ?>
                    <?php JSSTmessage::getMessage(); ?>
                    <?php JSSTbreadcrumbs::getBreadcrumbs(); ?>
                    <?php include_once(jssupportticket::$_path . 'includes/header.php'); ?>
                    <div class="js-ticket-staff-wrapper">
                        <div class="js-ticket-top-search-wrp">
                            <div class="js-ticket-search-heading-wrp">
                                <div class="js-ticket-heading-left">
                                    <?php echo __('Staff Members', 'js-support-ticket') ?>
                                </div>
                                <div class="js-ticket-heading-right">
                                    <a class="js-ticket-add-download-btn" href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'agent', 'jstlay'=>'addstaff'))); ?>"><span class="js-ticket-add-img-wrp"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/add.png" alt="Add-image"></span><?php echo __('Add New Staff', 'js-support-ticket') ?></a>
                                </div>
                            </div>
                            <div class="js-ticket-search-fields-wrp">
                                <form class="js-filter-form" name="jssupportticketform" id="jssupportticketform" method="POST" action="<?php echo jssupportticket::makeUrl(array('jstmod'=>'agent', 'jstlay'=>'staffs')); ?>">
                                    <div class="js-ticket-fields-wrp">
                                        <div class="js-ticket-form-field">
                                            <?php echo JSSTformfield::text('jsst-name', jssupportticket::parseSpaces(jssupportticket::$_data['filter']['jsst-name']), array('placeholder' => __('Search by username', 'js-support-ticket'), 'class' => 'js-ticket-field-input')); ?>
                                        </div>
                                        <div class="js-ticket-form-field js-ticket-form-field-select">
                                            <?php echo JSSTformfield::select('jsst-status', $status, jssupportticket::$_data['filter']['jsst-status'], __('Select Status', 'js-support-ticket'), array('class' => 'inputbox js-ticket-select-field')); ?>
                                        </div>
                                        <div class="js-ticket-form-field js-ticket-form-field-select js-ticket-margin-top-select">
                                            <?php echo JSSTformfield::select('jsst-role', JSSTincluder::getJSModel('role')->getRolesForCombobox(), jssupportticket::$_data['filter']['jsst-role'], __('Select Role', 'js-support-ticket'), array('class' => 'inputbox js-ticket-select-field')); ?>
                                        </div>
                                        <div class="js-ticket-search-form-btn-wrp js-ticket-staff-search-btn-wrp">
                                            <?php echo JSSTformfield::submitbutton('jsst-go', __('Search', 'js-support-ticket'), array('class' => 'js-search-button', 'onclick' => 'return addSpaces();')); ?>
                                            <?php echo JSSTformfield::submitbutton('jsst-reset', __('Reset', 'js-support-ticket'), array('class' => 'js-reset-button', 'onclick' => 'return resetFrom();')); ?>
                                        </div>
                                    </div>

                                    <?php echo JSSTformfield::hidden('JSST_form_search', 'JSST_SEARCH'); ?>
                                    <?php echo JSSTformfield::hidden('jsstpageid', get_the_ID()); ?>
                                </form>
                            </div>
                        </div>
                    <?php
                    if (!empty(jssupportticket::$_data[0])) { ?>
                        <div class="js-ticket-download-content-wrp">
                            <div class="js-ticket-table-wrp js-col-md-12">
                                <div class="js-ticket-table-header">
                                    <div class="js-ticket-table-header-col js-col-md-3 js-col-xs-3"><?php echo __('Full Name', 'js-support-ticket'); ?></div>
                                    <div class="js-ticket-table-header-col js-col-md-2 js-col-xs-2"><?php echo __('Role', 'js-support-ticket'); ?></div>
                                    <div class="js-ticket-table-header-col js-col-md-1 js-col-xs-1"><?php echo __('Status', 'js-support-ticket'); ?></div>
                                    <div class="js-ticket-table-header-col js-col-md-2 js-col-xs-2"><?php echo __('Created', 'js-support-ticket'); ?></div>
                                    <div class="js-ticket-table-header-col js-col-md-2 js-col-xs-2"><?php echo __('Permissions', 'js-support-ticket'); ?></div>
                                    <div class="js-ticket-table-header-col js-col-md-2 js-col-xs-2"><?php echo __('Action', 'js-support-ticket'); ?></div>
                                </div>
                                <div class="js-ticket-table-body">
                                    <?php foreach (jssupportticket::$_data[0] AS $agent) {
                                            $status = ($agent->status == 1) ? 'yes.png' : 'no.png';
                                            $fullname = $agent->firstname . '  ' . $agent->lastname; ?>
                                            <div class="js-ticket-data-row">
                                                <div class="js-ticket-table-body-col js-col-md-3 js-col-xs-3">
                                                    <span class="js-ticket-display-block"><?php echo __('Full Name','js-support-ticket'); ?>:</span>
                                                    <a href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'agent','jstlay'=>'addstaff','jssupportticketid'=>$agent->id))); ?>"><?php echo __($fullname,"js-support-ticket"); ?></a>
                                                </div>
                                                <div class="js-ticket-table-body-col js-col-md-2 js-col-xs-2">
                                                    <span class="js-ticket-display-block"><?php echo __('Role','js-support-ticket'); ?>:</span>
                                                    <?php echo __($agent->rolename,"js-support-ticket"); ?>
                                                </div>
                                                <div class="js-ticket-table-body-col js-col-md-1 js-col-xs-1">
                                                    <span class="js-ticket-display-block"><?php echo __('Status','js-support-ticket'); ?>:</span>
                                                    <img alt="image" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/' . $status; ?>" />
                                                </div>
                                                <div class="js-ticket-table-body-col js-col-md-2 js-col-xs-2">
                                                    <span class="js-ticket-display-block"><?php echo __('Created','js-support-ticket'); ?>:</span>
                                                    <?php echo date_i18n(jssupportticket::$_config['date_format'], strtotime($agent->created)); ?>
                                                </div>
                                                <div class="js-ticket-table-body-col js-col-md-2 js-col-xs-2">
                                                    <span class="js-ticket-display-block"><?php echo __('Permissions','js-support-ticket'); ?>:</span>
                                                    <a href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'agent','jstlay'=>'staffpermissions','jssupportticketid'=>$agent->id))); ?>"><?php echo __('Permissions', 'js-support-ticket'); ?></a>
                                                </div>
                                                <div class="js-ticket-table-body-col js-col-md-2 js-col-xs-2">
                                                    <span class="js-ticket-display-block"><?php echo __('Action','js-support-ticket'); ?>:</span>
                                                    <a href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'agent', 'jstlay'=>'addstaff', 'jssupportticketid'=>$agent->id))); ?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/downloadicon/edit.png" /></a>&nbsp;&nbsp;
                                                    <a onclick="return confirm('<?php echo __('Are you sure to delete', 'js-support-ticket'); ?>');" href="<?php echo wp_nonce_url(jssupportticket::makeUrl(array('jstmod'=>'agent', 'task'=>'deletestaff', 'action'=>'jstask', 'action'=>'jstask','staffid'=>$agent->id, 'jsstpageid'=>get_the_ID())),'delete-staff'); ?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/downloadicon/delete.png" /></a>
                                                </div>
                                            </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        if (jssupportticket::$_data[1]) {
                            echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . jssupportticket::$_data[1] . '</div></div>';
                        }
                    } else { // Record Not FOund
                        JSSTlayout::getNoRecordFound();
                    }
                } else {
                    JSSTlayout::getStaffMemberDisable();
                }
            } else { // user not Staff
                JSSTlayout::getNotStaffMember();
            }
        } else {// User is guest
            $redirect_url = jssupportticket::makeUrl(array('jstmod'=>'agent','jstlay'=>'staffs'));
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
</div>
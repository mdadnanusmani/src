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
                            document.getElementById('jsst-role').value = '';
                            return true;
                        }
                        function addSpaces() {
                            document.getElementById('jsst-role').value = fillSpaces(document.getElementById('jsst-role').value);
                            return true;
                        }
                    </script>
                    <?php JSSTmessage::getMessage(); ?>
                    <?php JSSTbreadcrumbs::getBreadcrumbs(); ?>
                    <?php include_once(jssupportticket::$_path . 'includes/header.php'); ?>

                    <div class="js-ticket-roles-wrapper">
                        <div class="js-ticket-top-search-wrp">
                            <div class="js-ticket-search-heading-wrp">
                                <div class="js-ticket-heading-left">
                                    <?php echo __('Search Roles', 'js-support-ticket') ?>
                                </div>
                                <div class="js-ticket-heading-right">
                                    <a class="js-ticket-add-download-btn" href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'role', 'jstlay'=>'addrole'))); ?>"><span class="js-ticket-add-img-wrp"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/add.png" alt="Add-image"></span><?php echo __('Add New Role', 'js-support-ticket') ?></a>
                                </div>
                            </div>
                            <div class="js-ticket-search-fields-wrp">
                               <form class="js-filter-form" name="jssupportticketform" id="jssupportticketform" method="POST" action="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'role', 'jstlay'=>'roles'))); ?>">
                                    <div class="js-ticket-fields-wrp">
                                        <div class="js-ticket-form-field js-ticket-form-field-download-search">
                                            <?php echo JSSTformfield::text('jsst-role', jssupportticket::parseSpaces(jssupportticket::$_data['filter']['jsst-role']), array('placeholder' => __('Search', 'js-support-ticket'), 'class' => 'js-ticket-field-input')); ?>
                                        </div>
                                        <div class="js-ticket-search-form-btn-wrp js-ticket-search-form-btn-wrp-download ">
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
                                    <div class="js-ticket-table-header-col js-col-md-5 js-col-xs-5"><?php echo __('Name', 'js-support-ticket'); ?></div>
                                    <div class="js-ticket-table-header-col js-col-md-5 js-col-xs-5"><?php echo __('Permissions', 'js-support-ticket'); ?></div>
                                    <div class="js-ticket-table-header-col js-col-md-2 js-col-xs-2"><?php echo __('Action', 'js-support-ticket'); ?></div>
                                </div>
                                <div class="js-ticket-table-body">
                                    <?php
                                    if (!empty(jssupportticket::$_data[0])) {
                                        foreach (jssupportticket::$_data[0] AS $role) {
                                            $status = ( isset($role->status) == 1 ) ? 'yes.png' : 'no.png'; ?>
                                            <div class="js-ticket-data-row">
                                                <div class="js-ticket-table-body-col js-col-md-5 js-col-xs-5">
                                                    <span class="js-ticket-display-block"><?php echo __('Name','js-support-ticket'); ?>:</span>
                                                    <span class="js-ticket-title"><a class="js-ticket-title-anchor" href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'role', 'jstlay'=>'addrole', 'jssupportticketid'=>$role->id))); ?>"><?php echo __($role->name); ?></a></span>
                                                </div>
                                                <div class="js-ticket-table-body-col js-col-md-5 js-col-xs-5">
                                                    <span class="js-ticket-display-block"><?php echo __('Permissions','js-support-ticket'); ?>:</span>
                                                    <span class="js-ticket-title"><a class="js-ticket-title-anchor" href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'role', 'jstlay'=>'rolepermission', 'jssupportticketid'=>$role->id))); ?>"><?php echo __('Permissions', 'js-support-ticket'); ?></a></span>
                                                </div>
                                                <div class="js-ticket-table-body-col js-col-md-2 js-col-xs-2">
                                                    <span class="js-ticket-display-block"><?php echo __('Action','js-support-ticket'); ?>:</span>
                                                        <a href="<?php echo jssupportticket::makeUrl(array('jstmod'=>'role', 'jstlay'=>'addrole', 'jssupportticketid'=>$role->id)); ?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/downloadicon/edit.png" /></a>&nbsp;&nbsp;
                                                        <a onclick="return confirm('<?php echo __('Are you sure to delete', 'js-support-ticket'); ?>');" href="<?php echo wp_nonce_url(jssupportticket::makeUrl(array('jstmod'=>'role', 'task'=>'deleterole', 'action'=>'jstask', 'roleid'=>$role->id, 'jsstpageid'=>get_the_ID())),'delete-role'); ?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/downloadicon/delete.png" /></a>

                                                </div>
                                            </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                        <?php
                        }if (jssupportticket::$_data[1]) {
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
            $redirect_url = jssupportticket::makeUrl(array('jstmod'=>'role','jstlay'=>'roles'));
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
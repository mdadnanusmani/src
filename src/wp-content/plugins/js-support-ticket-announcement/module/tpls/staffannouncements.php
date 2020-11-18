
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
                            document.getElementById('jsst-title').value = '';
//                            document.getElementById('jsst-cat').value = '';
			var celement =  document.getElementById('jsst-cat');
			if (typeof(celement) != 'undefined' && celement != null){
			    document.getElementById('jsst-cat').value = '';
		        }

                            //document.getElementById('jsst-type').value = '';
                            return true;
                        }
                        function addSpaces() {
                            document.getElementById('jsst-title').value = fillSpaces(document.getElementById('jsst-title').value);
                            return true;
                        }
                    </script>
                    <?php JSSTmessage::getMessage(); ?>
                    <?php
                    /*$type = array(
                        (object) array('id' => '1', 'text' => __('Public', 'js-support-ticket')),
                        (object) array('id' => '2', 'text' => __('Private', 'js-support-ticket'))
                    );*/
                    ?>
                    <?php JSSTbreadcrumbs::getBreadcrumbs(); ?>
                    <?php include_once(jssupportticket::$_path . 'includes/header.php'); ?>

                    <div class="js-ticket-announcement-wrapper">
                        <div class="js-ticket-top-search-wrp">
                            <div class="js-ticket-search-heading-wrp">
                                <div class="js-ticket-heading-left">
                                    <?php echo __('Search Announcements', 'js-support-ticket') ?>
                                </div>
                                <div class="js-ticket-heading-right">
                                    <a class="js-ticket-add-download-btn" href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'announcement', 'jstlay'=>'addannouncement'))); ?>"><span class="js-ticket-add-img-wrp"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/add.png" alt="Add-image"></span><?php echo __('Add Announcement', 'js-support-ticket') ?></a>
                                </div>
                            </div>
                            <div class="js-ticket-search-fields-wrp">
                                <form class="js-filter-form" name="jssupportticketform" id="jssupportticketform" method="POST" action="<?php echo jssupportticket::makeUrl(array('jstmod'=>'announcement', 'jstlay'=>'staffannouncements')); ?>">
                                    <div class="js-ticket-fields-wrp">
                                        <div class="js-ticket-form-field">
                                            <?php echo JSSTformfield::text('jsst-title', jssupportticket::parseSpaces(jssupportticket::$_data['filter']['jsst-title']), array('placeholder' => __('Search', 'js-support-ticket'), 'class' => 'js-ticket-field-input')); ?>
                                        </div>
                                        <?php if(in_array('knowledgebase',jssupportticket::$_active_addons)){ ?>
                                            <div class="js-ticket-form-field js-ticket-form-field-select">
                                                <?php echo JSSTformfield::select('jsst-cat', JSSTincluder::getJSModel('knowledgebase')->getCategoryForCombobox('announcement'), jssupportticket::$_data['filter']['jsst-cat'], __('Select Category', 'js-support-ticket'), array('class' => 'js-ticket-select-field')); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="js-ticket-search-form-btn-wrp">
                                        <?php echo JSSTformfield::submitbutton('jsst-go', __('Search', 'js-support-ticket'), array('class' => 'js-search-button', 'onclick' => 'return addSpaces();')); ?>
                                        <?php echo JSSTformfield::submitbutton('jsst-reset', __('Reset', 'js-support-ticket'), array('class' => 'js-reset-button', 'onclick' => 'return resetFrom();')); ?>

                                    </div>
                                    <?php echo JSSTformfield::hidden('JSST_form_search', 'JSST_SEARCH'); ?>
                                    <?php echo JSSTformfield::hidden('jsstpageid', get_the_ID()); ?>
                                </form>
                            </div>
                        </div>
                        <?php if (!empty(jssupportticket::$_data[0])) { ?>
                            <div class="js-ticket-download-content-wrp">
                                <div class="js-ticket-table-wrp js-col-md-12">
                                    <div class="js-ticket-table-header">
                                        <?php if(in_array('knowledgebase',jssupportticket::$_active_addons)){ ?>
                                            <div class="js-ticket-table-header-col js-col-md-4 js-col-xs-4"><?php echo __('Title', 'js-support-ticket'); ?></div>
                                            <div class="js-ticket-table-header-col js-col-md-3 js-col-xs-3"><?php echo __('Category', 'js-support-ticket'); ?></div>
                                        <?php }else{ ?>
                                            <div class="js-ticket-table-header-col js-col-md-7 js-col-xs-7"><?php echo __('Title', 'js-support-ticket'); ?></div>
                                        <?php } ?>
                                        <div class="js-ticket-table-header-col js-col-md-1 js-col-xs-1"><?php echo __('Status', 'js-support-ticket'); ?></div>
                                        <div class="js-ticket-table-header-col js-col-md-2 js-col-xs-2"><?php echo __('Created', 'js-support-ticket'); ?></div>
                                        <div class="js-ticket-table-header-col js-col-md-2 js-col-xs-2"><?php echo __('Action', 'js-support-ticket'); ?></div>
                                    </div>
                                    <div class="js-ticket-table-body">
                                        <?php
                                            foreach (jssupportticket::$_data[0] AS $announcement) {
                                            $listtype = '';
                                            if ($announcement->type == 1)
                                                $listtype = __('Public', 'js-support-ticket');
                                            elseif ($announcement->type == 2)
                                                $listtype = __('Private', 'js-support-ticket');
                                            $status = ($announcement->status == 1) ? 'yes.png' : 'no.png';
                                        ?>
                                                <div class="js-ticket-data-row">
                                                    <?php if(in_array('knowledgebase',jssupportticket::$_active_addons)){ ?>
                                                        <div class="js-ticket-table-body-col js-col-md-4 js-col-xs-4">
                                                            <span class="js-ticket-display-block"><?php echo __('Title','js-support-ticket'); ?>:</span>
                                                            <span class="js-ticket-title"><a class="js-ticket-title-anchor" href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'announcement', 'jstlay'=>'addannouncement', 'jssupportticketid'=>$announcement->id))); ?>"><?php echo __($announcement->title,"js-support-ticket"); ?></a></span>
                                                        </div>
                                                        <div class="js-ticket-table-body-col js-col-md-3 js-col-xs-3">
                                                            <span class="js-ticket-display-block"><?php echo __('Category','js-support-ticket'); ?>:</span>
                                                            <?php echo __($announcement->categoryname,"js-support-ticket"); ?>
                                                        </div>
                                                    <?php }else{ ?>
                                                        <div class="js-ticket-table-body-col js-col-md-7 js-col-xs-4">
                                                            <span class="js-ticket-display-block"><?php echo __('Title','js-support-ticket'); ?>:</span>
                                                            <span class="js-ticket-title"><a class="js-ticket-title-anchor" href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'announcement', 'jstlay'=>'addannouncement', 'jssupportticketid'=>$announcement->id))); ?>"><?php echo __($announcement->title,"js-support-ticket"); ?></a></span>
                                                        </div>
                                                    <?php } ?>
                                                    <div class="js-ticket-table-body-col js-col-md-1 js-col-xs-1">
                                                        <span class="js-ticket-display-block"><?php echo __('Status','js-support-ticket'); ?>:</span>
                                                        <img alt="image" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/' . $status; ?>" />
                                                    </div>
                                                    <div class="js-ticket-table-body-col js-col-md-2 js-col-xs-2">
                                                        <span class="js-ticket-display-block"><?php echo __('Created','js-support-ticket'); ?>:</span>
                                                        <?php echo date_i18n(jssupportticket::$_config['date_format'], strtotime($announcement->created)); ?>
                                                    </div>
                                                    <div class="js-ticket-table-body-col js-col-md-2 js-col-xs-2">
                                                        <span class="js-ticket-display-block"><?php echo __('Action','js-support-ticket'); ?>:</span>
                                                        <a href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'announcement', 'jstlay'=>'addannouncement', 'jssupportticketid'=>$announcement->id))); ?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/downloadicon/edit.png" /></a>&nbsp;&nbsp;
                                                        <a onclick="return confirm('<?php echo __('Are you sure to delete', 'js-support-ticket'); ?>');" href="<?php echo wp_nonce_url(jssupportticket::makeUrl(array('jstmod'=>'announcement', 'task'=>'deleteannouncement', 'action'=>'jstask', 'announcementid'=>$announcement->id, 'jsstpageid'=>get_the_ID())),'delete-announcement'); ?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/downloadicon/delete.png" /></a>
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
                    } else {
                        JSSTlayout::getNoRecordFound();
                    }
                } else {
                    JSSTlayout::getStaffMemberDisable();
                }
            } else {
                JSSTlayout::getNotStaffMember();
            }
        } else {
            $redirect_url = jssupportticket::makeUrl(array('jstmod'=>'announcement', 'jstlay'=>'staffannouncements'));
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
</div>
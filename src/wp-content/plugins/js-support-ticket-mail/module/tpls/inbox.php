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
                            document.getElementById('jsst-subject').value = '';
                            return true;
                        }
                        jQuery(document).ready(function(){
                          changeIconTabs();
                        });


                        jQuery(function(){
                            jQuery('div a').click(function (e) {
                                var imgID= jQuery(this).find('img').attr('id');
                                changeIconTabs(imgID);
                              });
                        });
                        function changeIconTabsOnMouseover(){
                            jQuery(document).ready(function(){
                                jQuery('div a').hover(function (e) {
                                    var imgID= jQuery(this).find('img').attr('id');
                                    tabValue=imgID;
                                    if(tabValue == ""){
                                        tabValue = jQuery(".js-ticket-mail-btn .js-add-link button > img").attr("id");
                                    }
                                    if(tabValue == "inbox-img"){
                                        jQuery("#"+tabValue).attr("src","<?php echo jssupportticket::$_pluginpath; ?>includes/images/mailicons/inbox-white.png");
                                    }else if(tabValue == "outbox-img"){
                                        jQuery("#"+tabValue).attr("src","<?php echo jssupportticket::$_pluginpath; ?>includes/images/mailicons/outbox-white.png");
                                    }else if(tabValue == "compose-img"){
                                        jQuery("#"+tabValue).attr("src","<?php echo jssupportticket::$_pluginpath; ?>includes/images/mailicons/compose-white.png");
                                    }
                                });
                            });
                        }
                        function changeIconTabsOnMouseOut(){
                            jQuery(document).ready(function(){
                                jQuery('div a').hover(function (e) {
                                    var imgID= jQuery(this).find('img').attr('id');
                                    tabValue=imgID;
                                    if(tabValue == ""){
                                        tabValue = jQuery(".js-ticket-mail-btn .js-add-link button > img").attr("id");
                                    }
                                    if(tabValue == "inbox-img"){
                                        jQuery("#"+tabValue).attr("src","<?php echo jssupportticket::$_pluginpath; ?>includes/images/mailicons/inbox-black.png");
                                    }else if(tabValue == "outbox-img"){
                                        jQuery("#"+tabValue).attr("src","<?php echo jssupportticket::$_pluginpath; ?>includes/images/mailicons/outbox-black.png");
                                    }else if(tabValue == "compose-img"){
                                        jQuery("#"+tabValue).attr("src","<?php echo jssupportticket::$_pluginpath; ?>includes/images/mailicons/compose-black.png");
                                    }
                                });
                            });
                        }
                        function changeIconTabs(tabValue = ""){
                            jQuery(document).ready(function(){
                                if(tabValue == ""){
                                    tabValue = jQuery("div a.active > img").attr("id");
                                }
                                if(tabValue == "inbox-img"){
                                    jQuery("#outbox-img").attr("src","<?php echo jssupportticket::$_pluginpath; ?>includes/images/mailicons/outbox-black.png");
                                    jQuery("#compose-img").attr("src","<?php echo jssupportticket::$_pluginpath; ?>includes/images/mailicons/compose-black.png");
                                    jQuery("#"+tabValue).attr("src","<?php echo jssupportticket::$_pluginpath; ?>includes/images/mailicons/inbox-white.png");
                                }else if(tabValue == "outbox-img"){
                                    jQuery("#inbox-img").attr("src","<?php echo jssupportticket::$_pluginpath; ?>includes/images/mailicons/inbox-black.png");
                                    jQuery("#compose-img").attr("src","<?php echo jssupportticket::$_pluginpath; ?>includes/images/mailicons/compose-black.png");
                                    jQuery("#"+tabValue).attr("src","<?php echo jssupportticket::$_pluginpath; ?>includes/images/mailicons/outbox-white.png");
                                }else if(tabValue == "compose-img"){
                                    jQuery("#inbox-img").attr("src","<?php echo jssupportticket::$_pluginpath; ?>includes/images/mailicons/inbox-black.png");
                                    jQuery("#outbox-img").attr("src","<?php echo jssupportticket::$_pluginpath; ?>includes/images/mailicons/outbox-black.png");
                                    jQuery("#"+tabValue).attr("src","<?php echo jssupportticket::$_pluginpath; ?>includes/images/mailicons/compose-white.png");
                                }
                            });
                        }
                    </script>
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

                    <div class="js-ticket-mail-wrapper">
                        <div class="js-ticket-top-search-wrp">
                            <div class="js-ticket-search-heading-wrp">
                                <div class="js-ticket-heading-left">
                                    <?php echo __('Search Email', 'js-support-ticket') ?>
                                </div>
                                <div class="js-ticket-heading-right">
                                    <a class="js-ticket-add-download-btn" href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'mail', 'jstlay'=>'formmessage'))); ?>"><span class="js-ticket-add-img-wrp"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/add.png" alt="Add-image"></span><?php echo __('Compose', 'js-support-ticket') ?></a>
                                </div>
                            </div>
                            <div class="js-ticket-search-fields-wrp">
                               <form class="js-filter-form" name="jssupportticketform" id="jssupportticketform" method="POST" action="<?php echo jssupportticket::makeUrl(array('jstmod'=>'mail', 'jstlay'=>'inbox')); ?>">
                                    <div class="js-ticket-fields-wrp">
                                        <div class="js-ticket-form-field js-ticket-form-field-download-search">
                                            <?php echo JSSTformfield::text('jsst-subject', jssupportticket::parseSpaces(jssupportticket::$_data['filter']['jsst-subject']), array('placeholder' => __('Search', 'js-support-ticket'), 'class' => 'js-ticket-field-input')); ?>
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
                        <div class="js-ticket-mails-btn-wrp">
                            <div class="js-ticket-mail-btn">
                                <a class="js-add-link button active" onmouseover="changeIconTabsOnMouseover(this)" onmouseout="changeIconTabsOnMouseOut(this)"  href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'mail', 'jstlay'=>'inbox'))); ?>">
                                    <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/inbox.png" />
                                    <?php echo __('Inbox', 'js-support-ticket').'
                                        ('; echo $inbox;
                                            echo ' )'; ?>
                                </a>
                            </div>
                            <div class="js-ticket-mail-btn">
                                <a class="js-add-link button" onmouseover="changeIconTabsOnMouseover(this)" onmouseout="changeIconTabsOnMouseOut(this)"  href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'mail', 'jstlay'=>'outbox'))); ?>">
                                    <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/outbox.png" />
                                    <?php echo __('Outbox', 'js-support-ticket').' (';
                                        echo jssupportticket::$_data[0]['outboxmessages'];
                                        echo __(' )  ', 'js-support-ticket'); ?>
                                </a>
                            </div>
                            <div class="js-ticket-mail-btn">
                                <a class="js-add-link button" onmouseover="changeIconTabsOnMouseover(this)" onmouseout="changeIconTabsOnMouseOut(this)"  href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'mail', 'jstlay'=>'formmessage'))); ?>">
                                    <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/add_icon2.png" />
                                    <?php echo __('Compose', 'js-support-ticket') ?>
                                </a>
                            </div>
                        </div>

                        <?php if (!empty(jssupportticket::$_data[0]['inbox'])) { ?>
                            <div class="js-ticket-download-content-wrp">
                                <div class="js-ticket-table-wrp js-col-md-12">
                                    <div class="js-ticket-table-header">
                                        <div class="js-ticket-table-header-col js-col-md-4 js-col-xs-4"><?php echo __('Subject', 'js-support-ticket'); ?></div>
                                        <div class="js-ticket-table-header-col js-col-md-3 js-col-xs-3"><?php echo __('From', 'js-support-ticket'); ?></div>
                                        <div class="js-ticket-table-header-col js-col-md-2 js-col-xs-2"><?php echo __('Created', 'js-support-ticket'); ?></div>
                                        <div class="js-ticket-table-header-col js-col-md-3 js-col-xs-3"><?php echo __('Action', 'js-support-ticket'); ?></div>
                                    </div>
                                    <div class="js-ticket-table-body">
                                        <?php
                                            foreach (jssupportticket::$_data[0]['inbox'] AS $inbox) {
                                            if ($inbox->isread == 2) { // unread message
                                                $inboxtitle = "<b>" . __($inbox->subject) . "</b>";
                                                if ($inbox->count != 0) { //replied message
                                                    $inboxtitle = $inboxtitle . ' ' . "<b>( " . __('Re', 'js-support-ticket') . " )</b>";
                                                }
                                            } elseif ($inbox->isread == 1) { //read message
                                                $inboxtitle = $inbox->subject;
                                                if ($inbox->count != 0) { //replied message
                                                    $inboxtitle = $inboxtitle . ' ' . "( " . __('Re', 'js-support-ticket') . " )";
                                                }
                                            } ?>
                                            <div class="js-ticket-data-row">
                                                <div class="js-ticket-table-body-col js-col-md-4 js-col-xs-4">
                                                    <span class="js-ticket-display-block"><?php echo __('Subject','js-support-ticket'); ?>:</span>
                                                    <span class="js-ticket-title"><a  class="js-ticket-title-anchor" href="<?php echo jssupportticket::makeUrl(array('jstmod'=>'mail', 'jstlay'=>'message', 'jssupportticketid'=>$inbox->id)); ?>"><?php echo __($inboxtitle,"js-support-ticket"); ?></a></span>
                                                </div>
                                                <div class="js-ticket-table-body-col js-col-md-3 js-col-xs-3">
                                                    <span class="js-ticket-display-block"><?php echo __('From','js-support-ticket'); ?>:</span>
                                                    <?php echo __($inbox->staffname,"js-support-ticket"); ?>
                                                </div>
                                                <div class="js-ticket-table-body-col js-col-md-2 js-col-xs-2">
                                                    <span class="js-ticket-display-block"><?php echo __('Created','js-support-ticket'); ?>:</span>
                                                    <?php echo date_i18n(jssupportticket::$_config['date_format'], strtotime($inbox->created)); ?>
                                                </div>
                                                <div class="js-ticket-table-body-col js-col-md-3 js-col-xs-3">
                                                    <span class="js-ticket-display-block"><?php echo __('Action','js-support-ticket'); ?>:</span>
                                                   <a href="<?php echo jssupportticket::makeUrl(array('jstmod'=>'mail', 'jstlay'=>'message', 'jssupportticketid'=>$inbox->id)); ?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/downloadicon/edit.png" /></a>&nbsp;&nbsp;
                                                    <a onclick="return confirm('<?php echo __('Are you sure to delete', 'js-support-ticket'); ?>');" href="<?php echo wp_nonce_url(jssupportticket::makeUrl(array('jstmod'=>'mail', 'task'=>'deletemail', 'action'=>'jstask', 'mailid'=>$inbox->id, 'jsstpageid'=>get_the_ID())),'delete-mail'); ?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/downloadicon/delete.png" /></a>&nbsp;&nbsp;
                                                    <a href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'mail', 'task'=>'markasread', 'action'=>'jstask', 'jsstpageid'=>get_the_ID(), 'mailid'=>$inbox->id))); ?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/mark_read.png" /></a>&nbsp;&nbsp;
                                                    <a href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'mail', 'task'=>'markasunread', 'action'=>'jstask', 'jsstpageid'=>get_the_ID(), 'mailid'=>$inbox->id))); ?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/mark_unread.png" /></a>
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
            $redirect_url = jssupportticket::makeUrl(array('jstmod'=>'mail', 'jstlay'=>'inbox'));
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
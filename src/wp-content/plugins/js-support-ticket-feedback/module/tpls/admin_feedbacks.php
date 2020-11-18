<script type="text/javascript">
    function resetFrom() {
        document.getElementById('ticketid').value = '';
        document.getElementById('subject').value = '';
        document.getElementById('from').value = '';
        document.getElementById('staffid').value = '';
        document.getElementById('departmentid').value = '';
        document.getElementById('jssupportticketform').submit();
    }
</script>
<?php JSSTmessage::getMessage(); ?>
<div id="jsstadmin-wrapper">
    <div id="jsstadmin-leftmenu">
        <?php  JSSTincluder::getClassesInclude('jsstadminsidemenu'); ?>
    </div>
    <div id="jsstadmin-data">
    <span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=jssupportticket&jstlay=controlpanel');?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Feedbacks', 'js-support-ticket') ?></span>
        </span>
        <form class="js-filter-form" name="jssupportticketform" id="jssupportticketform" method="post" action="<?php echo admin_url("admin.php?page=feedback&jstlay=feedbacks"); ?>">

            <?php echo JSSTformfield::text('ticketid', jssupportticket::$_data['filter']['ticketid'], array('placeholder' => __('Ticket Id', 'js-support-ticket'))); ?>
            <?php echo JSSTformfield::text('subject', jssupportticket::$_data['filter']['subject'], array('placeholder' => __('Subject', 'js-support-ticket'))); ?>
            <?php echo JSSTformfield::text('from', jssupportticket::$_data['filter']['from'], array('placeholder' => __('From', 'js-support-ticket'))); ?>
            <?php
            if(in_array('agent', jssupportticket::$_active_addons)){
                echo JSSTformfield::select('staffid', JSSTincluder::getJSModel('agent')->getStaffForCombobox(), jssupportticket::$_data['filter']['staffid'], __('Select Staff Member', 'js-support-ticket'), array('class' => 'inputbox'));
            }?>
            <?php echo JSSTformfield::select('departmentid', JSSTincluder::getJSModel('department')->getDepartmentForCombobox(), jssupportticket::$_data['filter']['departmentid'], __('Select Department', 'js-support-ticket'), array('class' => 'inputbox')); ?>
            <?php echo JSSTformfield::hidden('JSST_form_search', 'JSST_SEARCH'); ?>
            <?php echo JSSTformfield::submitbutton('go', __('Search', 'js-support-ticket'), array('class' => 'button')); ?>
            <?php echo JSSTformfield::button('reset', __('Reset', 'js-support-ticket'), array('class' => 'button', 'onclick' => 'resetFrom();')); ?>
        </form>
        <div class="jsst-feedback-det-main">
        <?php if (!empty(jssupportticket::$_data[0])) {
             ?>
            <?php foreach (jssupportticket::$_data[0] as $feedback) {
                $img_name ='';
                if($feedback->rating == 5){
                    $img_name = 'excelent';
                }elseif($feedback->rating == 4){
                    $img_name = 'happy';
                }elseif($feedback->rating == 3){
                    $img_name = 'normal';
                }elseif($feedback->rating == 2){
                    $img_name = 'bad';
                }elseif($feedback->rating == 1){
                    $img_name = 'angery';
                }

             ?>
                <div class="jsst-feedback-det-wrp">
                    <div class="jsst-feedback-det-list">
                        <div class="jsst-feedback-det-list-top">
                            <div class="jsst-feedback-det-list-data-wrp">
                                <div class="jsst-feedback-det-list-data-top">
                                    <div class="jsst-feedback-det-list-data-top-title"><?php echo __('Subject','js-support-ticket');?>:&nbsp;</div>
                                    <div class="jsst-feedback-det-list-data-top-val">
                                        <a href="?page=ticket&jstlay=ticketdetail&jssupportticketid=<?php echo $feedback->ticketid; ?>" class="jsst-feedback-det-list-data-top-val-txt"><?php echo $feedback->subject;?> <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/newtab-icon.png" /></a>
                                    </div>
                                </div>
                                <div class="jsst-feedback-det-list-data-btm">
                                    <div class="jsst-feedback-det-list-datea-btm-rec">
                                        <div class="jsst-feedback-det-list-data-btm-title">
                                            <?php echo __('Ticket Id','js-support-ticket');?>:&nbsp;
                                        </div>
                                        <div class="jsst-feedback-det-list-data-btm-val">
                                            <?php echo $feedback->trackingid; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="jsst-feedback-det-list-data-btm">
                                    <div class="jsst-feedback-det-list-datea-btm-rec">
                                        <div class="jsst-feedback-det-list-data-btm-title">
                                            <?php echo __('User','js-support-ticket');?>:&nbsp;
                                        </div>
                                        <div class="jsst-feedback-det-list-data-btm-val">
                                            <?php echo $feedback->name; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="jsst-feedback-det-list-data-btm">
                                    <div class="jsst-feedback-det-list-datea-btm-rec">
                                        <div class="jsst-feedback-det-list-data-btm-title">
                                            <?php echo __('Department','js-support-ticket');?>:&nbsp;
                                        </div>
                                        <div class="jsst-feedback-det-list-data-btm-val">
                                            <?php echo $feedback->departmentname; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php if(in_array('agent', jssupportticket::$_active_addons)){ ?>
                                    <div class="jsst-feedback-det-list-data-btm">
                                        <div class="jsst-feedback-det-list-datea-btm-rec">
                                            <div class="jsst-feedback-det-list-data-btm-title">
                                                <?php echo __('Staff','js-support-ticket');?>:&nbsp;
                                            </div>
                                            <div class="jsst-feedback-det-list-data-btm-val">
                                                <?php echo $feedback->firstname .'&nbsp;'.$feedback->lastname; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                    jssupportticket::$_data['ticketid'] = $feedback->ticketid;
                                    $customfields = JSSTincluder::getObjectClass('customfields')->userFieldsData(2, 1);
                                    foreach ($customfields as $field) {
                                        $array_f = JSSTincluder::getObjectClass('customfields')->showCustomFields($field,3, $feedback->params);
                                        echo '  <div class="jsst-feedback-det-list-data-btm">
                                                    <div class="jsst-feedback-det-list-datea-btm-rec">
                                                        <div class="jsst-feedback-det-list-data-btm-title">
                                                            '.$array_f['title'].':&nbsp;
                                                        </div>
                                                        <div class="jsst-feedback-det-list-data-btm-val">
                                                            '.$array_f['value'].'
                                                        </div>
                                                    </div>
                                                </div>'   ;
                                    }
                                ?>
                            </div>
                            <div class="jsst-feedback-det-list-img-wrp">
                                <img alt="image" title="image" src="<?php echo jssupportticket::$_pluginpath.'includes/images/'.$img_name.'.png';?>" />
                            </div>
                        </div>
                        <?php if($feedback->remarks !=''){ ?>
                            <div class="jsst-feedback-det-list-btm">
                                <div class="jsst-feedback-det-list-btm-title">
                                    <?php echo __('Feedback','js-support-ticket');?>:&nbsp;
                                </div>
                                <div class="jsst-feedback-det-list-btm-val">
                                    <?php echo wp_kses_post($feedback->remarks); ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
            <?php
            if (jssupportticket::$_data[1]) {
                 echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . jssupportticket::$_data[1] . '</div></div>';
            }
        } else {
            JSSTlayout::getNoRecordFound();
        }
        ?>
    </div>
</div>
<div class="jsst-main-up-wrapper">
<?php
if (jssupportticket::$_config['offline'] == 2) {
    ?>
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
    <?php JSSTbreadcrumbs::getBreadcrumbs(); ?>
    <?php include_once(jssupportticket::$_path . 'includes/header.php'); ?>

    <div class="js-ticket-feedback-wrapper">
        <div class="js-ticket-top-search-wrp">
            <div class="js-ticket-search-heading-wrp">
                <div class="js-ticket-heading-left">
                    <?php echo __('Search Feedback', 'js-support-ticket') ?>
                </div>
            </div>
            <div class="js-ticket-search-fields-wrp">
                <form class="js-filter-form" name="jssupportticketform" id="jssupportticketform" method="POST" action="<?php echo jssupportticket::makeUrl(array('jstmod'=>'feedback', 'jstlay'=>'feedbacks')); ?>">
                    <div class="js-ticket-fields-wrp">
                        <div class="js-ticket-form-field js-ticket-feedback-fields-margin-bottom">
                            <?php echo JSSTformfield::text('ticketid', jssupportticket::$_data['filter']['ticketid'], array('placeholder' => __('Ticket Id', 'js-support-ticket'), 'class' => 'js-ticket-field-input')); ?>
                        </div>
                        <div class="js-ticket-form-field js-ticket-feedback-fields-margin-bottom">
                            <?php echo JSSTformfield::text('subject', jssupportticket::$_data['filter']['subject'], array('placeholder' => __('Subject', 'js-support-ticket'), 'class' => 'js-ticket-field-input')); ?>
                        </div>
                        <div class="js-ticket-form-field js-ticket-feedback-fields-margin-bottom">
                            <?php echo JSSTformfield::text('from', jssupportticket::$_data['filter']['from'], array('placeholder' => __('From', 'js-support-ticket'), 'class' => 'js-ticket-field-input')); ?>
                        </div>
                        <?php if(in_array('agent', jssupportticket::$_active_addons)){ ?>
                            <div class="js-ticket-form-field js-ticket-feedback-fields-margin-bottom js-ticket-form-field-select">
                                <?php echo JSSTformfield::select('staffid', JSSTincluder::getJSModel('agent')->getStaffForCombobox(), jssupportticket::$_data['filter']['staffid'], __('Select Staff Member', 'js-support-ticket'), array('class' => 'inputbox js-ticket-select-field'));  ?>
                            </div>
                        <?php } ?>
                        <div class="js-ticket-form-field js-ticket-feedback-fields-margin-bottom js-ticket-form-field-select">
                            <?php echo JSSTformfield::select('departmentid', JSSTincluder::getJSModel('department')->getDepartmentForCombobox(), jssupportticket::$_data['filter']['departmentid'], __('Select Department', 'js-support-ticket'), array('class' => 'inputbox js-ticket-select-field'));  ?>
                        </div>
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

    <div class="js-col-md-12 js-ticket-feedback-list-wrapper">
        <div class="js-ticket-feedback-heading">Latest Feedback</div>
        <?php
        if (jssupportticket::$_data[0]) {
            foreach (jssupportticket::$_data[0] as $feedback) {
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
                                        <a href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'ticket','jstlay'=>'ticketdetail','jssupportticketid'=> $feedback->ticketid))); ?>" class="jsst-feedback-det-list-data-top-val-txt"><?php echo $feedback->subject;?> <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/newtab-icon.png" /></a>
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
                <?php
            }

            if (isset(jssupportticket::$_data[1])) {
                echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . jssupportticket::$_data[1] . '</div></div>';
            }
        } else {
            JSSTlayout::getNoRecordFound();
        }
        ?>
    </div>
    <?php
} else {
    JSSTlayout::getSystemOffline();
} ?>

</div>
</div>
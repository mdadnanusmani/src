<div class="jsst-main-up-wrapper">
<?php
if (jssupportticket::$_config['offline'] == 2) {
                    wp_enqueue_script('formvalidate.js', jssupportticket::$_pluginpath . 'includes/js/jquery.form-validator.js');
                    ?>
                    <script type="text/javascript">
                        jQuery(document).ready(function ($) {
                            $.validate();
                        });
                    </script>
                    <?php JSSTmessage::getMessage(); ?>
                    <?php JSSTbreadcrumbs::getBreadcrumbs(); ?>
                    <?php include_once(jssupportticket::$_path . 'includes/header.php');
                    if (jssupportticket::$_data['feedback_flag'] == 0) { ?>
                        <div class="js-ticket-add-form-wrapper ">
                            <form class="js-ticket-form" method="post" action="<?php echo jssupportticket::makeUrl(array('jstmod'=>'feedback', 'task'=>'savefeedback')); ?>" enctype="multipart/form-data" >
                                <?php
                                foreach (jssupportticket::$_data['fieldordering'] AS $field){
                                    switch ($field->field) {
                                        case 'rating': ?>
                                            <div class="js-ticket-from-field-wrp js-ticket-from-field-wrp-full-width">
                                                <div class="js-ticket-from-field-title">
                                                    <?php echo __($field->fieldtitle, 'js-support-ticket'); ?>&nbsp;<span style="color: red;" >*</span>
                                                </div>
                                                <div class="js-ticket-from-field">
                                                    <div class="jsst-rating-div">
                                                        <img class="rating_image" data-value="1" src="<?php echo jssupportticket::$_pluginpath;?>includes/images/rating/angery.png"/>
                                                        <img class="rating_image" data-value="2" src="<?php echo jssupportticket::$_pluginpath;?>includes/images/rating/bad.png"/>
                                                        <img class="rating_image" data-value="3" src="<?php echo jssupportticket::$_pluginpath;?>includes/images/rating/normal.png"/>
                                                        <img class="rating_image" data-value="4" src="<?php echo jssupportticket::$_pluginpath;?>includes/images/rating/happy.png"/>
                                                        <img class="rating_image" data-value="5" src="<?php echo jssupportticket::$_pluginpath;?>includes/images/rating/excelent.png"/>
                                                    </div>
                                                     <?php echo JSSTformfield::hidden('rating', '',array('data-validation' => 'required')); ?>
                                                </div>
                                            </div>
                                            <?php
                                            break;
                                        case 'remarks':
                                            ?>
                                            <div class="js-ticket-from-field-wrp js-ticket-from-field-wrp-full-width">
                                                <div class="js-ticket-from-field-title">
                                                    <?php echo __($field->fieldtitle, 'js-support-ticket'); ?>&nbsp;<span style="color: red;" >*</span>
                                                </div>
                                                <div class="js-ticket-from-field">
                                                    <?php
                                                        echo wp_editor('', 'remarks', array('media_buttons' => false));
                                                    ?>
                                                </div>
                                            </div>
                                            <?php
                                            break;
                                            default:
                                                echo JSSTincluder::getObjectClass('customfields')->formCustomFields($field);
                                            break;
                                        }
                                }?>
                                <?php echo JSSTformfield::hidden('id', isset(jssupportticket::$_data[0]->id) ? jssupportticket::$_data[0]->id : '' ); ?>
                                <?php echo JSSTformfield::hidden('ordering', isset(jssupportticket::$_data[0]->ordering) ? jssupportticket::$_data[0]->ordering : '' ); ?>
                                <?php echo JSSTformfield::hidden('created', isset(jssupportticket::$_data[0]->created) ? jssupportticket::$_data[0]->created : ''); ?>
                                <?php echo JSSTformfield::hidden('action', 'announcement_saveannouncement'); ?>
                                <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
                                <?php echo JSSTformfield::hidden('jsstpageid', get_the_ID()); ?>
                                <?php echo JSSTformfield::hidden('ticketid', jssupportticket::$_data['ticketid']); ?>
                                <div class="js-ticket-form-btn-wrp">
                                    <?php echo JSSTformfield::submitbutton('save', __('Submit Feedback', 'js-support-ticket'), array('class' => 'js-ticket-save-button')); ?>
                                    <a href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'feedback', 'jstlay'=>'feedbacks')));?>" class="js-ticket-cancel-button"><?php echo __('Cancel','js-support-ticket'); ?></a>
                                </div>
                            </form>
                        </div>
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('img.rating_image').on('mouseover', function(){
            if(jQuery(this).hasClass('selected')){
            }else{
                src = jQuery(this).attr('src').replace('.png', '-1.png');
                jQuery(this).attr('src', src);
            }
        })
        jQuery('img.rating_image').on('mouseout', function(){
            if(jQuery(this).hasClass('selected')){
            }else{
                src = jQuery(this).attr('src').replace('-1.png', '.png');
                jQuery(this).attr('src', src);
            }
        });
        jQuery('img.rating_image').on('click', function(){
            jQuery("img.rating_image").each(function(index) {
                if(jQuery(this).hasClass('selected')){
                    jQuery(this).removeClass('selected');
                    src = jQuery(this).attr('src').replace('-1.png', '.png');
                    jQuery(this).attr('src', src);
                }
            });
            jQuery(this).addClass('selected');
            val = jQuery(this).attr('data-value');
            jQuery('input#rating').val(val);
        });
    });
</script>
    <?php

    } else { // User permission not granted
        JSSTlayout::getFeedbackMessages(jssupportticket::$_data['feedback_flag']);
    }
} else {
    JSSTlayout::getSystemOffline();
} ?>

</div>
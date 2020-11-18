<div class="jsst-main-up-wrapper">
<?php
if (jssupportticket::$_config['offline'] == 2) {
    if (jssupportticket::$_data['permission_granted'] == 1) {
        if (get_current_user_id() != 0) {
            if ( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()) {
                if (jssupportticket::$_data['staff_enabled']) {
                    wp_enqueue_script('formvalidate.js', jssupportticket::$_pluginpath . 'includes/js/jquery.form-validator.js');
                    ?>
                    <?php
                    $type = array((object) array('id' => '1', 'text' => __('Public', 'js-support-ticket')),
                        (object) array('id' => '0', 'text' => __('Private', 'js-support-ticket'))
                    );
                    $status = array((object) array('id' => '1', 'text' => __('Active', 'js-support-ticket')),
                        (object) array('id' => '0', 'text' => __('Disabled', 'js-support-ticket'))
                    );
                    ?>
                    <script type="text/javascript">
                        jQuery(document).ready(function ($) {
                            $.validate();
                        });
                        var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
                        function checkCategoriesParent(val, type) {
                            var parentid = jQuery("select#parentid").val();
                            if (val == true && parentid != '') {
                                jQuery.post(ajaxurl, {action: 'jsticket_ajax', parentid: parentid, type: type, jstmod: 'knowledgebase', task: 'checkParentType'}, function (data) {
                                    if (data) {
                                        console.log(data);
                                        jQuery("div#msgshowcategory").html(data);
                                    }
                                });
                            } else {
                                var currentid = jQuery("input#id").val();
                                jQuery.post(ajaxurl, {action: 'jsticket_ajax', currentid: currentid, type: type, jstmod: 'knowledgebase', task: 'checkChildType'}, function (data) {
                                    if (data) {
                                        console.log(data);
                                        jQuery("div#msgshowcategory").html(data);
                                        jQuery("input#" + type + 1).attr('checked', 'true');
                                    }
                                });
                            }
                        }
                        function addTypeToParent(parentid, type) {
                            jQuery.post(ajaxurl, {action: 'jsticket_ajax', parentid: parentid, type: type, jstmod: 'knowledgebase', task: 'makeParentOfType'}, function (data) {
                                if (data) {
                                    console.log(data);
                                    jQuery("div#msgshowcategory").html('');
                                }
                            });
                        }
                        function getTypeForByParentId(parentid) {
                            jQuery.post(ajaxurl, {action: 'jsticket_ajax', parentid: parentid, jstmod: 'knowledgebase', task: 'getTypeForByParentId'}, function (data) {
                                console.log(data);
                                if (data) {
                                    var array = jQuery.parseJSON(data);
                                    //reset the previous selection
                                    jQuery("input#kb1").removeAttr('checked');
                                    jQuery("input#downloads1").removeAttr('checked');
                                    jQuery("input#announcement1").removeAttr('checked');
                                    jQuery("input#faqs1").removeAttr('checked');
                                    if (array['kb'] == 1) {
                                        jQuery("input#kb1").attr({'checked': 'true'});
                                    }
                                    if (array['downloads'] == 1) {
                                        jQuery("input#downloads1").attr({'checked': 'true'});
                                    }
                                    if (array['announcement'] == 1) {
                                        jQuery("input#announcement1").attr({'checked': 'true'});
                                    }
                                    if (array['faqs'] == 1) {
                                        jQuery("input#faqs1").attr({'checked': 'true'});
                                    }
                                }
                            });
                        }
                        function closemsg(type) {
                            type = type + 1;
                            jQuery("input#" + type).attr('checked', false);
                            jQuery("div#msgshowcategory").html('');
                        }
                        function checkCategoryForSelected(){
                            var cat_for = jQuery('input[type="checkbox"]:checked').length;
                            if (cat_for == 0) {
                                alert('<?php echo __('Please select atleast one category for','js-support-ticket'); ?>');
                                return false;
                            }
                            return true;
                        }
                    </script>
                    <?php JSSTbreadcrumbs::getBreadcrumbs(); ?>
                    <?php include_once(jssupportticket::$_path . 'includes/header.php'); ?>

                    <div class="js-ticket-add-form-wrapper">
                        <form class = "js-ticket-form" method="post" enctype="multipart/form-data" action="<?php echo jssupportticket::makeUrl(array('jstmod'=>'knowledgebase', 'task'=>'savecategory')); ?>">
                            <div class="js-ticket-from-field-wrp">
                                <div class="js-ticket-from-field-title">
                                    <?php echo __('Category Name', 'js-support-ticket'); ?>&nbsp;<span style="color: red;" >*</span>
                                </div>
                                <div class="js-ticket-from-field">
                                    <?php echo JSSTformfield::text('name', isset(jssupportticket::$_data[0]->name) ? jssupportticket::$_data[0]->name : '', array('class' => 'inputbox js-ticket-form-field-input', 'data-validation' => 'required')) ?>
                                </div>
                            </div>
                            <?php /* <div class="js-ticket-from-field-wrp">
                                <div class="js-ticket-from-field-title">
                                    <?php echo __('Type', 'js-support-ticket'); ?>&nbsp;<span style="color: red;" >*</span>
                                </div>
                                <div class="js-ticket-from-field js-ticket-form-field-select">
                                    <?php echo JSSTformfield::select('type', $type, isset(jssupportticket::$_data[0]->type) ? jssupportticket::$_data[0]->type : '', __('Select Type', 'js-support-ticket'), array('class' => 'inputbox js-ticket-form-field-input', 'data-validation' => 'required')); ?>
                                </div>
                            </div>*/ ?>
                            <div class="js-ticket-from-field-wrp">
                                <div class="js-ticket-from-field-title">
                                    <?php echo __('Parent Category', 'js-support-ticket'); ?>
                                </div>
                                <div class="js-ticket-from-field js-ticket-form-field-select">
                                    <?php echo JSSTformfield::select('parentid', JSSTincluder::getJSModel('knowledgebase')->getCategoryForCombobox(null), isset(jssupportticket::$_data[0]->parentid) ? jssupportticket::$_data[0]->parentid : '', __('Select Category', 'js-support-ticket'), array('class' => 'inputbox js-ticket-form-field-input','onchange' => 'getTypeForByParentId(this.value);')); ?>
                                </div>
                            </div>
                            <div class="js-ticket-from-field-wrp js-ticket-from-field-wrp-full-width ">
                                <div id="msgshowcategory"></div>
                                <div class="js-ticket-from-field-title">
                                    <?php echo __('Category For', 'js-support-ticket'); ?>
                                </div>
                                <div class="js-ticket-from-field">
                                    <span class="js-ticket-sub-fields"><?php echo JSSTformfield::checkbox('kb', array('1' => __('Knowledge Base', 'js-support-ticket')), isset(jssupportticket::$_data[0]->kb) ? jssupportticket::$_data[0]->kb : '', array('class' => 'radiobutton js-ticket-checkbox', 'onchange' => "checkCategoriesParent(this.checked,'kb');")); ?></span>
                                    <?php if(in_array('download', jssupportticket::$_active_addons)){ ?>
                                        <span class="js-ticket-sub-fields"><?php echo JSSTformfield::checkbox('downloads', array('1' => __('Downloads', 'js-support-ticket')), isset(jssupportticket::$_data[0]->downloads) ? jssupportticket::$_data[0]->downloads : '', array('class' => 'radiobutton js-ticket-checkbox', 'onchange' => "checkCategoriesParent(this.checked,'downloads');")); ?></span>
                                    <?php } ?>
                                    <?php if(in_array('announcement', jssupportticket::$_active_addons)){ ?>
                                        <span class="js-ticket-sub-fields"><?php echo JSSTformfield::checkbox('announcement', array('1' => __('Announcements', 'js-support-ticket')), isset(jssupportticket::$_data[0]->announcement) ? jssupportticket::$_data[0]->announcement : '', array('class' => 'radiobutton js-ticket-checkbox', 'onchange' => "checkCategoriesParent(this.checked,'announcement');")); ?></span>
                                    <?php } ?>
                                    <?php if(in_array('faq', jssupportticket::$_active_addons)){ ?>
                                        <span class="js-ticket-sub-fields"><?php echo JSSTformfield::checkbox('faqs', array('1' => __("FAQ's", 'js-support-ticket')), isset(jssupportticket::$_data[0]->faqs) ? jssupportticket::$_data[0]->faqs : '', array('class' => 'radiobutton js-ticket-checkbox', 'onchange' => "checkCategoriesParent(this.checked,'faqs');")); ?></span>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="js-ticket-from-field-wrp js-ticket-from-field-wrp-full-width ">
                                <div class="js-ticket-from-field-title">
                                    <?php echo __('Logo', 'js-support-ticket'); ?>
                                </div>
                                <div class="js-ticket-from-field">
                                   <input type="file" class="inputbox js-ticket-form-field-input" name="filename" />
                                   <?php if (isset(jssupportticket::$_data[0]))
                                            if (jssupportticket::$_data[0]->logo != '') {
                                                $datadirectory = jssupportticket::$_config['data_directory'];
                                                $maindir = wp_upload_dir();
                                                $path = $maindir['baseurl'];
                                                $path = $path .'/'. $datadirectory;
                                                $path .= "/knowledgebasedata/categories/category_" . jssupportticket::$_data[0]->id . "/" . jssupportticket::$_data[0]->logo;
                                                ?> <img class="js-ticket-category-img" width="50" height="50" alt="image" src="<?php echo esc_url($path); ?>"> <?php
                                            }
                                        ?>
                                        <span class="tk_attachments_configform">
                                            <?php echo __('Maximum File Size', 'js-support-ticket');
                                                  echo ' (' . jssupportticket::$_config['file_maximum_size']; ?>KB)<br><?php echo __('File Extension Type', 'js-support-ticket');
                                                  echo ' (' . jssupportticket::$_config['file_extension'] . ')'; ?>
                                        </span>
                                </div>
                            </div>
                            <div class="js-ticket-from-field-wrp js-ticket-from-field-wrp-full-width ">
                                <div class="js-ticket-from-field-title">
                                    <?php echo __('Meta Description', 'js-support-ticket'); ?>
                                </div>
                                <div class="js-ticket-from-field">
                                   <textarea name="metadesc" cols="50" rows="5"><?php echo (isset(jssupportticket::$_data[0]->metadesc)) ? jssupportticket::$_data[0]->metadesc : ''; ?></textarea>
                                </div>
                            </div>
                            <div class="js-ticket-from-field-wrp js-ticket-from-field-wrp-full-width ">
                                <div class="js-ticket-from-field-title">
                                    <?php echo __('Meta Keywords', 'js-support-ticket'); ?>
                                </div>
                                <div class="js-ticket-from-field">
                                   <textarea name="metakey" cols="50" rows="5"><?php echo (isset(jssupportticket::$_data[0]->metakey)) ? jssupportticket::$_data[0]->metakey : ''; ?></textarea>
                                </div>
                            </div>
                            <div class="js-ticket-from-field-wrp">
                                <div class="js-ticket-from-field-title">
                                    <?php echo __('Status', 'js-support-ticket'); ?>
                                </div>
                                <div class="js-ticket-from-field js-ticket-form-field-select">
                                    <?php echo JSSTformfield::select('status', $status, isset(jssupportticket::$_data[0]->status) ? jssupportticket::$_data[0]->status : '', __('Select Status', 'js-support-ticket'), array('class' => 'inputbox js-ticket-form-field-input')); ?>
                                </div>
                            </div>
                            <?php echo JSSTformfield::hidden('id', isset(jssupportticket::$_data[0]->id) ? jssupportticket::$_data[0]->id : ''); ?>
                            <?php echo JSSTformfield::hidden('created', isset(jssupportticket::$_data[0]->created) ? jssupportticket::$_data[0]->created : '' ); ?>
                            <?php echo JSSTformfield::hidden('logo', isset(jssupportticket::$_data[0]->logo) ? jssupportticket::$_data[0]->logo : ''); ?>
                            <?php echo JSSTformfield::hidden('updated', isset(jssupportticket::$_data[0]->updated) ? jssupportticket::$_data[0]->updated : ''); ?>
                            <?php echo JSSTformfield::hidden('action', 'knowledgebase_savecategory'); ?>
                            <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
                            <?php echo JSSTformfield::hidden('jsstpageid', get_the_ID()); ?>
                            <div class="js-ticket-form-btn-wrp">
                                <?php echo JSSTformfield::submitbutton('save', __('Save Category', 'js-support-ticket'), array('class' => 'js-ticket-save-button')); ?>
                               <a href="<?php echo jssupportticket::makeUrl(array('jstmod'=>'knowledgebase', 'jstlay'=>'stafflistcategories'));?>" class="js-ticket-cancel-button"><?php echo __('Cancel','js-support-ticket'); ?></a>
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
            $redirect_url = jssupportticket::makeUrl(array('jstmod'=>'knowledgebase', 'jstlay'=>'addcategory'));
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
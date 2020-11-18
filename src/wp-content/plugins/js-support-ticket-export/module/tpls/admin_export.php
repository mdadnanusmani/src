<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
wp_enqueue_script('jquery-ui-datepicker');
wp_enqueue_style('jquery-ui-css', $protocol.'ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');

$status_combo = array(
    (object) array('id' => '0', 'text' => __('New', 'js-support-ticket')),
    (object) array('id' => '1', 'text' => __('Pending', 'js-support-ticket')),
    (object) array('id' => '2', 'text' => __('In Progress', 'js-support-ticket')),
    (object) array('id' => '3', 'text' => __('Answered', 'js-support-ticket')),
    (object) array('id' => '4', 'text' => __('Closed', 'js-support-ticket'))
);
$yesno = array(
    (object) array('id' => '1', 'text' => __('Yes', 'js-support-ticket')),
    (object) array('id' => '2', 'text' => __('No', 'js-support-ticket'))
);

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
                jQuery("input#username-text").val(name);
                jQuery("input#uid").val(id);
                jQuery("div#userpopup").slideUp('slow', function () {
                    jQuery("div#userpopupblack").hide();
                });
            });
        });
    }
    setUserLink();
    jQuery(document).ready(function ($) {
        $('.custom_date').datepicker({
            dateFormat: 'yy-mm-dd'
        });
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
        jQuery("form#userpopupsearch").submit(function (e) {
            e.preventDefault();
            var name = jQuery("input#name").val();
            var emailaddress = jQuery("input#emailaddress").val();
            jQuery.post(ajaxurl, {action: 'jsticket_ajax', name: name, emailaddress: emailaddress, jstmod: 'agent', task: 'getuserlistajax'}, function (data) {
                if (data) {
                    jQuery("div#records").html(data);
                    setUserLink();
                }
            });//jquery closed
        });
        jQuery("span.close, div#userpopupblack").click(function (e) {
            jQuery("div#userpopup").slideUp('slow', function () {
                jQuery("div#userpopupblack").hide();
            });

        });
	});


</script>
<div id="userpopupblack" style="display:none;"></div>
<div id="userpopup" style="display:none;">
    <div class="js-row">
        <form id="userpopupsearch">
            <div class="search-center">
                <div class="search-center-heading"><?php echo __('Select user','js-support-ticket'); ?><span class="close"></span></div>
                <div class="js-col-md-12">
                    <div class="js-col-xs-12 js-col-md-3 js-search-value">
                        <input type="text" name="username" id="username" placeholder="<?php echo __('Username','js-support-ticket'); ?>" />
                    </div>
                    <div class="js-col-xs-12 js-col-md-3 js-search-value">
                        <input type="text" name="name" id="name" placeholder="<?php echo __('Name','js-support-ticket'); ?>" />
                    </div>
                    <div class="js-col-xs-12 js-col-md-3 js-search-value">
                        <input type="text" name="emailaddress" id="emailaddress" placeholder="<?php echo __('Email Address','js-support-ticket'); ?>"/>
                    </div>
                    <div class="js-col-xs-12 js-col-md-3 js-search-value-button">
                        <div class="js-button">
                            <input type="submit" value="<?php echo __('Search','js-support-ticket'); ?>" />
                        </div>
                        <div class="js-button">
                            <input type="submit" onclick="document.getElementById('name').value = '';document.getElementById('username').value = ''; document.getElementById('emailaddress').value = '';" value="<?php echo __('Reset','js-support-ticket'); ?>" />
                        </div>
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
<div id="jsstadmin-wrapper">
    <div id="jsstadmin-leftmenu">
        <?php  JSSTincluder::getClassesInclude('jsstadminsidemenu'); ?>
    </div>
    <div id="jsstadmin-data">
    <span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=jssupportticket&jstlay=controlpanel');?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Export', 'js-support-ticket') ?></span></span>
        <div class="js-export-wrapper" >
        <form class="js-filter-form" autocomplete="off" method="post" action="<?php echo admin_url('admin.php?page=export&action=jstask&task=getticketsexport'); ?>">

                <div class="js-filter-form-data">
                    <label class="js-filter-form-title"><?php echo __('Start Date', 'js-support-ticket'); ?>:</label>
                    <div class="js-filter-form-value">
                    	<?php echo JSSTformfield::text('startdate', '', array('class' => 'custom_date')); ?>
                    </div>
                </div>
                <div class="js-filter-form-data">
                    <label class="js-filter-form-title"><?php echo __('End Date', 'js-support-ticket'); ?>:</label>
                    <div class="js-filter-form-value">
                    	<?php echo JSSTformfield::text('enddate', '', array('class' => 'custom_date')); ?>
                    </div>
                </div>
                <div class="js-filter-form-data">
                    <label class="js-filter-form-title"><?php echo __('Department', 'js-support-ticket'); ?>:</label>
                    <div class="js-filter-form-value">
                    	<?php echo JSSTformfield::select('departmentid', JSSTincluder::getJSModel('department')->getDepartmentForCombobox(), '', __('Select Department', 'js-support-ticket'), array('class' => 'inputbox'));  ?>
                    </div>
                </div>
                <?php if(in_array('agent', jssupportticket::$_active_addons)){ ?>
                    <div class="js-filter-form-data">
                        <label class="js-filter-form-title">
                            <?php echo __('Staff Member', 'js-support-ticket'); ?>:
                        </label>
                        <div class="js-filter-form-value">
                            <?php echo JSSTformfield::select('staffid', JSSTincluder::getJSModel('agent')->getStaffForCombobox(), '', __('Select Staff Member', 'js-support-ticket'), array('class' => 'inputbox'));  ?>
                        </div>
                    </div>
                <?php } ?>
                <div class="js-filter-form-data">
                    <label class="js-filter-form-title"><?php echo __('User', 'js-support-ticket'); ?>:</label>
                    <div class="js-filter-form-value">
                        <div id="username-div"></div><input type="text" value="" id="username-text" readonly="readonly" data-validation="required"/><a href="#" id="userpopup"><?php echo __('Select User', 'js-support-ticket'); ?></a>
                    </div>
                </div>
                <div class="js-filter-form-data">
                    <label class="js-filter-form-title"><?php echo __('Priority', 'js-support-ticket'); ?>:</label>
                    <div class="js-filter-form-value">
                        <?php echo JSSTformfield::select('priorityid', JSSTincluder::getJSModel('priority')->getPriorityForCombobox(), '', __('Select Priority', 'js-support-ticket'), array('class' => 'inputbox'));  ?>
                    </div>
                </div>
                <div class="js-filter-form-data">
                    <label class="js-filter-form-title"><?php echo __('Ticket Status', 'js-support-ticket'); ?>:</label>
                    <div class="js-filter-form-value">
                        <?php echo JSSTformfield::select('ticketstatus', $status_combo, '', __('Select Ticket Status', 'js-support-ticket'), array('class' => 'inputbox'));  ?>
                    </div>
                </div>
                <div class="js-filter-form-data">
                    <label class="js-filter-form-title"><?php echo __('Ticket Overdue', 'js-support-ticket'); ?>:</label>
                    <div class="js-filter-form-value">
                        <?php echo JSSTformfield::select('isoverdue', $yesno, '', __('Select Ticket Overdue Status', 'js-support-ticket'), array('class' => 'inputbox'));  ?>
                    </div>
                </div>
                <button type="submit" class="js-filter-form-btn">
                    <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/export-button-icon.png" /> <?php echo __('Export', 'js-support-ticket'); ?>
                </button>
                <?php echo JSSTformfield::hidden('uid','');;  ?>
        </form>
        </div>
    </div>
</div>

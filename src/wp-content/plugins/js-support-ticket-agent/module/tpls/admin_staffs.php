<script type="text/javascript">
    function resetFrom() {
        document.getElementById('username').value = '';
        document.getElementById('status').value = '';
        document.getElementById('roleid').value = '';
        document.getElementById('jssupportticketform').submit();
    }
</script>
<?php
$status = array(
    (object) array('id' => '1', 'text' => __('Active', 'js-support-ticket')),
    (object) array('id' => '0', 'text' => __('Disabled', 'js-support-ticket'))
);
?>
<?php JSSTmessage::getMessage(); ?>
<div id="jsstadmin-wrapper">
    <div id="jsstadmin-leftmenu">
        <?php  JSSTincluder::getClassesInclude('jsstadminsidemenu'); ?>
    </div>
    <div id="jsstadmin-data">
    <span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=jssupportticket&jstlay=controlpanel');?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Staff Members', 'js-support-ticket'); ?></span>
    <a class="js-add-link button" href="?page=agent&jstlay=addstaff"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/add_icon.png" /><?php echo __('Add Staff Member', 'js-support-ticket') ?></a>
        </span>
        <form class="js-filter-form" name="jssupportticketform" id="jssupportticketform" method="post" action="<?php echo admin_url("admin.php?page=agent&jstlay=staffs"); ?>">
            <?php echo JSSTformfield::text('username', jssupportticket::$_data['filter']['username'], array('placeholder' => __('Username', 'js-support-ticket'))); ?>&nbsp;&nbsp;
            <?php echo JSSTformfield::select('status', $status, jssupportticket::$_data['filter']['status'], __('Select Status', 'js-support-ticket'), array('class' => 'inputbox')); ?>&nbsp;&nbsp;
            <?php echo JSSTformfield::select('roleid', JSSTincluder::getJSModel('role')->getRolesForCombobox(), jssupportticket::$_data['filter']['roleid'], __('Select Role', 'js-support-ticket'), array('class' => 'inputbox')); ?>
            <?php echo JSSTformfield::hidden('JSST_form_search', 'JSST_SEARCH'); ?>
            <?php echo JSSTformfield::submitbutton('go', __('Search', 'js-support-ticket'), array('class' => 'button')); ?>
        <?php echo JSSTformfield::button('reset', __('Reset', 'js-support-ticket'), array('class' => 'button', 'onclick' => 'resetFrom();')); ?>
        </form>
        <?php
        if (!empty(jssupportticket::$_data[0])) {
            ?>
            <div class="js-filter-form-list">
                <div class="js-filter-form-head js-filter-form-head-xs">
                    <div class="js-col-md-3 js-col-xs-12 first"><?php echo __('Full Name', 'js-support-ticket'); ?></div>
                    <div class="js-col-md-2 js-col-xs-12 second js-textaligncenter"><?php echo __('Username', 'js-support-ticket'); ?></div>
                    <div class="js-col-md-2 js-col-xs-12 third js-textaligncenter"><?php echo __('Role', 'js-support-ticket'); ?></div>
                    <div class="js-col-md-1 js-col-xs-12 fourth js-textaligncenter"><?php echo __('Status', 'js-support-ticket'); ?></div>
                    <div class="js-col-md-1 js-col-xs-12 fifth js-textaligncenter"><?php echo __('Created', 'js-support-ticket'); ?></div>
                    <div class="js-col-md-2 js-col-xs-12 sixth js-textaligncenter"><?php echo __('Permissions', 'js-support-ticket'); ?></div>
                    <div class="js-col-md-1 js-col-xs-12 seventh js-textaligncenter"><?php echo __('Action', 'js-support-ticket'); ?></div>
                </div>
                <?php
                foreach (jssupportticket::$_data[0] AS $agent) {
                    $status = ($agent->status == 1) ? 'yes.png' : 'no.png';
                    $fullname = $agent->firstname . '  ' . $agent->lastname;
                    ?>
                    <div class="js-filter-form-data">
                        <div class="js-col-md-3 js-col-xs-12 first"><span class="js-filter-form-data-xs"><?php echo __('Full Name', 'js-support-ticket');
                    echo " : "; ?></span><a href="?page=agent&jstlay=addstaff&jssupportticketid=<?php echo $agent->id; ?>"><?php echo $fullname; ?></a></div>
                        <div class="js-col-md-2 js-col-xs-12 second js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Username', 'js-support-ticket');
                    echo " : "; ?></span><?php echo $agent->username; ?></div>
                        <div class="js-col-md-2 js-col-xs-12 third js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Role', 'js-support-ticket');
                    echo " : "; ?></span> <?php echo $agent->rolename; ?></div>
                        <div class="js-col-md-1 js-col-xs-12 fourth js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Status', 'js-support-ticket');
                    echo " : "; ?></span><a href="<?php echo wp_nonce_url('?page=agent&task=changestatus&action=jstask&staffid=' .$agent->id, 'change-status');?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/' . $status; ?>"/> </a></div>
                        <div class="js-col-md-1 js-col-xs-12 fifth js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Created', 'js-support-ticket');
                    echo " : "; ?></span> <?php echo date_i18n(jssupportticket::$_config['date_format'], strtotime($agent->created)); ?></div>
                        <div class="js-col-md-2 js-col-xs-12 sixth js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Permissions', 'js-support-ticket');
                    echo " : "; ?></span><a href="?page=agent&jstlay=staffpermissions&jssupportticketid=<?php echo $agent->id; ?>"><?php echo __('Permissions', 'js-support-ticket'); ?></a></div>
                        <div class="js-col-md-1 js-col-xs-12 seventh js-filter-form-action-hl-xs">
                            <a href="?page=agent&jstlay=addstaff&jssupportticketid=<?php echo $agent->id; ?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/edit.png" /></a>&nbsp;&nbsp;
                            <a onclick="return confirm('<?php echo __('Are you sure to delete', 'js-support-ticket'); ?>');" href="<?php echo wp_nonce_url('?page=agent&task=deletestaff&action=jstask&staffid=' .$agent->id,'delete-staff');?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/remove.png" /></a>
                        </div>
                    </div>

                <?php
            }
            ?>
            </div>
            <?php
            if (jssupportticket::$_data[1]) {
                echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . jssupportticket::$_data[1] . '</div></div>';
            }
        } else { // Record Not FOund
            JSSTlayout::getNoRecordFound();
        }
        ?>
    </div>
</div>

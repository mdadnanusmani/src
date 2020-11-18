<?php JSSTmessage::getMessage(); ?>
<div id="jsstadmin-wrapper">
    <div id="jsstadmin-leftmenu">
        <?php  JSSTincluder::getClassesInclude('jsstadminsidemenu'); ?>
    </div>
    <div id="jsstadmin-data">
    <span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=jssupportticket&jstlay=controlpanel');?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __("Reports", 'js-support-ticket') ?></span></span>
        <a class="js-admin-report-wrapper" href="<?php echo admin_url('admin.php?page=reports&jstlay=overallreport'); ?>" >
            <div class="js-admin-overall-report-type-wrapper">
                <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/report/overall_icon.png" />
                <span class="js-admin-staff-report-type-label"><?php echo __('Overall Statistics','js-support-ticket'); ?></span>
            </div>
        </a>
        <a class="js-admin-report-wrapper" href="<?php echo admin_url('admin.php?page=reports&jstlay=staffreport'); ?>" >
            <div class="js-admin-staff-report-type-wrapper">
                <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/report/staff.png" />
                <span class="js-admin-staff-report-type-label"><?php echo __('Staff Reports','js-support-ticket'); ?></span>
            </div>
        </a>
        <a class="js-admin-report-wrapper" href="<?php echo admin_url('admin.php?page=reports&jstlay=departmentreport'); ?>" >
            <div class="js-admin-department-report-type-wrapper">
                <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/report/department.png" />
                <span class="js-admin-staff-report-type-label"><?php echo __('Department Reports','js-support-ticket'); ?></span>
            </div>
        </a>
        <a class="js-admin-report-wrapper" href="<?php echo admin_url('admin.php?page=reports&jstlay=userreport'); ?>" >
            <div class="js-admin-user-report-type-wrapper">
                <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/report/user.png" />
                <span class="js-admin-user-report-type-label"><?php echo __('User Reports','js-support-ticket'); ?></span>
            </div>
        </a>
    </div>
</div>
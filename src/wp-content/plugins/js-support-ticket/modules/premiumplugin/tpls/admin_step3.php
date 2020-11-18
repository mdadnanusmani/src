<div id="jsstadmin-wrapper">
    <div id="jsstadmin-leftmenu">
        <?php  JSSTincluder::getClassesInclude('jsstadminsidemenu'); ?>
    </div>
    <div id="jsstadmin-data">
        <span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=premiumplugin&jstlay=step1');?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Premium Add ons', 'js-support-ticket'); ?></span></span>

        <div id="jssupportticket-content">
            <div id="black_wrapper_translation"></div>
            <div id="jstran_loading">
                <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/spinning-wheel.gif" />
            </div>
            <div id="jsst-lower-wrapper">
                <div class="jsst-addon-installer-wrapper step3" >
                    <div class="jsst-addon-installer-left-image-wrap" >
                        <img class="jsst-addon-installer-left-image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/addon-images/addon-installer-logo.png" />
                    </div>
                    <div class="jsst-addon-installer-left-heading" >
                        <?php echo __("Add ons installed and activated successfully","js-support-ticket"); ?>
                    </div>
                    <div class="jsst-addon-installer-left-description" >
                        <?php echo __("Add ons for JS Support Ticket have been installed and activated successfully. ","js-support-ticket"); ?>
                    </div>
                    <div class="jsst-addon-installer-right-button" >
                        <a class="jsst_btn" href="?page=jssupportticket" ><?php echo __("Control Panel","js-support-ticket"); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

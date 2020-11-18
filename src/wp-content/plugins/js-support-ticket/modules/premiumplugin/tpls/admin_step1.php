<?php
if(isset($_SESSION['jsst_addon_install_data'])){
    unset($_SESSION['jsst_addon_install_data']);
}
?>
    <div id="jsstadmin-wrapper">
        <div id="jsstadmin-leftmenu">
            <?php  JSSTincluder::getClassesInclude('jsstadminsidemenu'); ?>
        </div>
    <div id="jsstadmin-data">
        <span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=jssupportticket');?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Premium Add ons', 'js-support-ticket'); ?></span></span>

        <div id="jssupportticket-content">
            <div id="black_wrapper_translation"></div>
            <div id="jstran_loading">
                <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/spinning-wheel.gif" />
            </div>
            <div id="jsst-lower-wrapper">
                <div class="jsst-addon-installer-wrapper" >
                    <form id="jsticketfrom" action="<?php echo admin_url('admin.php?page=premiumplugin&task=verifytransactionkey&action=jstask'); ?>" method="post">
                        <div class="jsst-addon-installer-left-section-wrap" >
                            <div class="jsst-addon-installer-left-image-wrap" >
                                <img class="jsst-addon-installer-left-image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/addon-images/addon-installer-logo.png" />
                            </div>
                            <div class="jsst-addon-installer-left-heading" >
                                <?php echo __("JS Support Ticket","js-support-ticket"); ?>
                            </div>
                            <div class="jsst-addon-installer-left-title" >
                                <?php echo __("Wordpress Plugin","js-support-ticket"); ?>
                            </div>
                            <div class="jsst-addon-installer-left-description" >
                                <?php echo __("JS Support Ticket is a trusted open source ticket system. JS Support ticket is a simple, easy to use, web-based customer support system. User can create ticket from front-end. JS support ticket comes packed with lot features than most of the expensive(and complex) support ticket system on market. The best part is, It completely free.","js-support-ticket"); ?>
                            </div>
                        </div>
                        <div class="jsst-addon-installer-right-section-wrap" >
                            <div class="jsst-addon-installer-right-heading" >
                                <?php echo __("JS Support Ticket Addon Installer","js-support-ticket"); ?>
                            </div>
                            <div class="jsst-addon-installer-right-description" >
                                >><a href="?page=premiumplugin&jstlay=addonfeatures" class="jsst-addon-installer-addon-list-link" >
                                    <?php echo __("Add on list","js-support-ticket"); ?>
                                </a><<
                            </div>
                            <div class="jsst-addon-installer-right-key-section" >
                                <div class="jsst-addon-installer-right-key-label" >
                                    <?php echo __("Please Insert Your Transaction key","js-support-ticket"); ?>.
                                </div>

                                <?php
                                $error_message = '';
                                $transactionkey = '';
                                if(isset($_SESSION['jsst_addon_return_data'])){
                                    if(isset($_SESSION['jsst_addon_return_data']['status']) && $_SESSION['jsst_addon_return_data']['status'] == 0){
                                        $error_message = $_SESSION['jsst_addon_return_data']['message'];
                                        $transactionkey = $_SESSION['jsst_addon_return_data']['transactionkey'];
                                    }
                                    unset($_SESSION['jsst_addon_return_data']);
                                }

                                ?>
                                <div class="jsst-addon-installer-right-key-field" >
                                    <input type="text" name="transactionkey" id="transactionkey" class="jsst_key_field" value="<?php echo $transactionkey;?>" placeholder="<?php echo __('Transaction key','js-support-ticket'); ?>"/>
                                    <?php if($error_message != '' ){ ?>
                                        <div class="jsst-addon-installer-right-key-field-message" > <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/icon.png" /> <?php echo $error_message;?></div>
                                    <?php } ?>
                                </div>
                                <div class="jsst-addon-installer-right-key-button" >
                                    <button type="submit" class="jsst_btn" role="submit" onclick="jsShowLoading();"><?php echo __("Proceed","js-support-ticket"); ?></button>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function(){
        jQuery('#jsticketfrom').on('submit', function() {
            jsShowLoading();
        });
    });

    function jsShowLoading(){
        jQuery('div#black_wrapper_translation').show();
        jQuery('div#jstran_loading').show();
    }
</script>
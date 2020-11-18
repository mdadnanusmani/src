<div class="jsst-main-up-wrapper">
<?php
if (jssupportticket::$_config['offline'] == 2) {
    ?>
    <?php JSSTmessage::getMessage(); ?>
    <?php JSSTbreadcrumbs::getBreadcrumbs(); ?>
    <?php include_once(jssupportticket::$_path . 'includes/header.php'); ?>
    <div class="js-ticket-knowledgebase-wrapper">
        <?php if (jssupportticket::$_data[0]['faqdetails']) { ?>
           <div class="js-ticket-top-search-wrp">
                <div class="js-ticket-search-heading-wrp">
                    <div class="js-ticket-heading-left">
                        <?php echo jssupportticket::$_data[0]['faqdetails']->subject; ?>
                    </div>
                </div>
                <div class="js-ticket-knowledgebase-details">
                    <?php echo wp_kses_post(jssupportticket::$_data[0]['faqdetails']->content); ?>
                </div>
            </div>
            <?php
        }else {
            JSSTlayout::getNoRecordFound();
        } ?>
    </div>
    <?php
} else {
    JSSTlayout::getSystemOffline();
} ?>
</div>
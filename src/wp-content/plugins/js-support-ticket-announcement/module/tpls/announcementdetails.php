<?php if (jssupportticket::$_config['offline'] == 2) { ?>
    <?php JSSTmessage::getMessage(); ?>
    <div class="jsst-main-up-wrapper">
    <?php JSSTbreadcrumbs::getBreadcrumbs(); ?>
    <?php include_once(jssupportticket::$_path . 'includes/header.php'); ?>
        <div class="js-ticket-knowledgebase-wrapper">
            <?php if (jssupportticket::$_data[0]['announcementdetails']) { ?>
               <div class="js-ticket-top-search-wrp">
                    <div class="js-ticket-search-heading-wrp">
                        <div class="js-ticket-heading-left">
                            <?php echo jssupportticket::$_data[0]['announcementdetails']->title; ?>
                        </div>
                    </div>
                    <div class="js-ticket-knowledgebase-details">
                        <?php echo wp_kses_post(jssupportticket::$_data[0]['announcementdetails']->description); ?>
                    </div>
                </div>
    </div>
                <?php
            }
            else {
                JSSTlayout::getNoRecordFound();
            }
        } else {
            JSSTlayout::getSystemOffline();
        } ?>



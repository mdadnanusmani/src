<div class="jsst-main-up-wrapper">
<?php
if (jssupportticket::$_config['offline'] == 2) {
    ?>
    <script type="text/javascript">
        function getDownloadById(value) {
            ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
            jQuery.post(ajaxurl, {action: 'jsticket_ajax', downloadid: value, jstmod: 'download', task: 'getDownloadById'}, function (data) {
                if (data) {
                    var obj = jQuery.parseJSON(data);
                    jQuery("div#js-ticket-main-content").html(obj.data);
                    jQuery("span#js-ticket-popup-title").html(obj.title);
                    jQuery("div#js-ticket-main-downloadallbtn").html(obj.downloadallbtn);
                    jQuery("div#js-ticket-main-black-background").show();
                    jQuery("div#js-ticket-main-popup").slideDown("slow");
                }
            });
        }
    </script>
    <?php JSSTmessage::getMessage(); ?>
    <?php JSSTbreadcrumbs::getBreadcrumbs(); ?>
    <?php include_once(jssupportticket::$_path . 'includes/header.php'); ?>

    <?php if (jssupportticket::$_data[0]['articledetails']) { ?>
        <div class="js-ticket-knowledgebase-wrapper">
            <div class="js-ticket-categories-wrp js-ticket-margin-bottom">
                <div class="js-ticket-categories-heading-wrp">
                    <?php echo __('Category Name', 'js-support-ticket');
                    echo ' > ' . jssupportticket::$_data[0]['articledetails']->name; ?>
                </div>
            </div>
           <div class="js-ticket-top-search-wrp">
                <div class="js-ticket-search-heading-wrp">
                    <div class="js-ticket-heading-left">
                        <?php echo jssupportticket::$_data[0]['articledetails']->subject; ?>
                    </div>
                </div>
                <div class="js-ticket-knowledgebase-details">
                    <?php echo wp_kses_post(jssupportticket::$_data[0]['articledetails']->content); ?>
                </div>
            </div>
        </div>
        <?php if (jssupportticket::$_data[0]['articledownloads']) { ?>
            <div class="js-ticket-downloads-wrp">
                <div class="js-ticket-downloads-heading-wrp">
                    <?php echo __('Article Attachment', 'js-support-ticket') ?>
                </div>
                <div class="js-ticket-downloads-content">
                    <?php foreach (jssupportticket::$_data[0]['articledownloads'] as $download) { ?>
                        <div class="js-ticket-download-box">
                            <div class="js-ticket-download-left">
                                <a class="js-ticket-download-title" href="#">
                                    <img alt="image" class="js-ticket-download-icon" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/downloadicon/download.png" />
                                    <span class="js-ticket-download-name">
                                        <?php echo $download->filename; ?>
                                    </span>
                                </a>
                            </div>
                            <div class="js-ticket-download-right">
                                <?php
                                    $path = jssupportticket::makeUrl(array('jstmod'=>'articleattachmet', 'action'=>'jstask', 'task'=>'downloadbyid', 'id'=>$download->id, 'jsstpageid'=>get_the_ID()));
                                ?>
                                <div class="js-ticket-download-btn">
                                    <a target="_blank" href="<?php echo esc_url($path); ?>" class="js-ticket-download-btn-style">
                                        <img alt="image" class="js-ticket-download-btn-icon" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/downloadicon/downloadall.png" />
                                        <?php echo __('Download','js-support-ticket'); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php
                    } ?>
                </div>
            </div>
        <?php } ?>
    <?php } else {
        JSSTlayout::getNoRecordFound();
        }
} else {
    JSSTlayout::getSystemOffline();
} ?>
</div>
<div class="jsst-main-up-wrapper">
<?php
if (jssupportticket::$_config['offline'] == 2) {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            jQuery("div#js-ticket-main-black-background,span#js-ticket-popup-close-button").click(function () {
                jQuery("div#js-ticket-main-popup").slideUp();
                setTimeout(function () {
                    jQuery("div#js-ticket-main-black-background").hide();
                }, 600);

            });
        });
        function getDownloadById(value) {
            ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
            jQuery.post(ajaxurl, {action: 'jsticket_ajax', downloadid: value, jstmod: 'download', task: 'getDownloadById',jsstpageid:<?php echo get_the_ID(); ?>}, function (data) {
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
        function getAllDownloads(value) {
            ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
            jQuery.post(ajaxurl, {action: 'jsticket_ajax', downloadid: value, jstmod: 'download', task: 'getAllDownloads'}, function (data) {
                console.log(data);
                /*
                 if(data){
                 var obj = jQuery.parseJSON(data);
                 alert(obj.helloworld);
                 }
                 */		});
        }
    </script>
    <script type="text/javascript">
        function resetFrom() {
            document.getElementById('jsst-search').value = '';
            return true;
        }
        function addSpaces() {
            document.getElementById('jsst-search').value = fillSpaces(document.getElementById('jsst-search').value);
            return true;
        }
    </script>
    <?php JSSTmessage::getMessage(); ?>
    <div id="js-ticket-main-black-background" style="display:none;">
    </div>
    <div id="js-ticket-main-popup" style="display:none;">
        <span id="js-ticket-popup-title">abc title</span>
        <span id="js-ticket-popup-close-button"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/popup-close.png" /></span>
        <div id="js-ticket-main-content">
        </div>
        <div id="js-ticket-main-downloadallbtn">
        </div>

    </div>
    <?php JSSTbreadcrumbs::getBreadcrumbs(); ?>
    <?php include_once(jssupportticket::$_path . 'includes/header.php'); ?>

    <div class="js-ticket-download-wrapper">
        <div class="js-ticket-top-search-wrp">
            <div class="js-ticket-search-heading-wrp">
                <div class="js-ticket-heading-left">
                    <?php echo __('Search Downloads', 'js-support-ticket') ?>
                </div>
            </div>
            <div class="js-ticket-search-fields-wrp">
               <form class="js-filter-form" name="jssupportticketform" id="jssupportticketform" method="POST" action="<?php echo jssupportticket::makeUrl(array('jstmod'=>'download', 'jstlay'=>'downloads')); ?>">
                    <div class="js-ticket-fields-wrp">
                        <div class="js-ticket-form-field js-ticket-form-field-download-search">
                            <?php echo JSSTformfield::text('jsst-search', jssupportticket::parseSpaces(jssupportticket::$_data[0]['download-filter']['search']), array('placeholder' => __('Search', 'js-support-ticket'), 'class' => 'js-ticket-field-input')); ?>
                        </div>
                        <div class="js-ticket-search-form-btn-wrp js-ticket-search-form-btn-wrp-download ">
                            <?php echo JSSTformfield::submitbutton('jsst-go', __('Search', 'js-support-ticket'), array('class' => 'js-search-button', 'onclick' => 'return addSpaces();')); ?>
                            <?php echo JSSTformfield::submitbutton('jsst-reset', __('Reset', 'js-support-ticket'), array('class' => 'js-reset-button', 'onclick' => 'return resetFrom();')); ?>
                        </div>
                    </div>
                    <?php echo JSSTformfield::hidden('JSST_form_search', 'JSST_SEARCH'); ?>
                    <?php echo JSSTformfield::hidden('jsstpageid', get_the_ID()); ?>
                </form>
            </div>
        </div>
        <?php if(in_array('knowledgebase', jssupportticket::$_active_addons)){ ?>
            <?php
            $counter = 1;
            if (jssupportticket::$_data[0]['categories']) {
            ?>
                <div class="js-ticket-categories-wrp">
                    <div class="js-ticket-categories-heading-wrp">
                        <?php echo __('Categories', 'js-support-ticket') ?>
                    </div>
                    <div class="js-ticket-categories-content">
                        <?php foreach (jssupportticket::$_data[0]['categories'] as $category) { ?>
                            <div class="js-ticket-category-box">
                                <a class="js-ticket-category-title" href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'download', 'jstlay'=>'downloads', 'jssupportticketid'=>$category->id))); ?>">
                                    <span class="js-ticket-category-name">
                                        <?php echo $counter . ".  " . $category->name; ?>
                                    </span>
                                    <span class="js-ticket-category-download-logo">
                                        <img alt="image" class="js-ticket-download-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/arrowicon.png" />
                                    </span>
                                </a>
                            </div>
                        <?php
                        $counter ++;
                        } ?>
                    </div>
                </div>
            <?php }
        } ?>
        <div class="js-ticket-downloads-wrp">
            <div class="js-ticket-downloads-heading-wrp">
                <?php echo __('Downloads', 'js-support-ticket') ?>
            </div>
            <?php
            if (jssupportticket::$_data[0]['downloads']) { ?>
                <div class="js-ticket-downloads-content">
                    <?php foreach (jssupportticket::$_data[0]['downloads'] as $download) { ?>
                        <div class="js-ticket-download-box">
                            <div class="js-ticket-download-left">
                                <a class="js-ticket-download-title" onclick="getDownloadById(<?php echo $download->downloadid ?>)">
                                    <img alt="image" class="js-ticket-download-icon" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/downloadicon/download.png" />
                                    <span class="js-ticket-download-name">
                                        <?php echo __($download->title,"js-support-ticket"); ?>
                                    </span>
                                </a>
                            </div>
                            <div class="js-ticket-download-right">
                                <div class="js-ticket-download-btn">
                                    <button type="button" class="js-ticket-download-btn-style" onclick="getDownloadById(<?php echo $download->downloadid ?>)">
                                        <img alt="image" class="js-ticket-download-btn-icon" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/downloadicon/downloadall.png" />
                                        <?php echo __('Download','js-support-ticket'); ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>

                    <?php
                     if (isset(jssupportticket::$_data[1])) {
                echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . jssupportticket::$_data[1] . '</div></div>';
            }
        } else {
            JSSTlayout::getNoRecordFound();
        }
        ?>
    </div>
</div>

    <?php
// main if
} else { // System is offline
    JSSTlayout::getSystemOffline();
}
?>
</div>
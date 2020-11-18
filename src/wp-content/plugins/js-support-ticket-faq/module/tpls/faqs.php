<div class="jsst-main-up-wrapper">
<?php
if (jssupportticket::$_config['offline'] == 2) {
    ?>
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
    <?php JSSTbreadcrumbs::getBreadcrumbs(); ?>
    <?php include_once(jssupportticket::$_path . 'includes/header.php'); ?>
        <div class="js-ticket-download-wrapper">
        <div class="js-ticket-top-search-wrp">
            <div class="js-ticket-search-heading-wrp">
                <div class="js-ticket-heading-left">
                    <?php echo __('Search FAQs', 'js-support-ticket') ?>
                </div>
            </div>
            <div class="js-ticket-search-fields-wrp">
               <form class="js-filter-form" name="jssupportticketform" id="jssupportticketform" method="POST" action="<?php echo jssupportticket::makeUrl(array('jstmod'=>'faq', 'jstlay'=>'faqs')); ?>">
                    <div class="js-ticket-fields-wrp">
                        <div class="js-ticket-form-field js-ticket-form-field-download-search">
                            <?php echo JSSTformfield::text('jsst-search', jssupportticket::parseSpaces(jssupportticket::$_data[0]['faq-filter']['search']), array('placeholder' => __('Search', 'js-support-ticket'), 'class' => 'js-ticket-field-input')); ?>
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
        <?php
        $counter = 1;
        if(in_array('knowledgebase', jssupportticket::$_active_addons)){
            if (jssupportticket::$_data[0]['categories']) {
        ?>
                <div class="js-ticket-categories-wrp">
                    <div class="js-ticket-categories-heading-wrp">
                        <?php echo __('Categories', 'js-support-ticket') ?>
                    </div>
                    <div class="js-ticket-categories-content">
                        <?php foreach (jssupportticket::$_data[0]['categories'] as $category) { ?>
                            <div class="js-ticket-category-box">
                                <a class="js-ticket-category-title" href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'faq', 'jstlay'=>'faqs', 'jssupportticketid'=>$category->id))); ?>">
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
        <?php
            }
        }
        ?>
        <div class="js-ticket-downloads-wrp">
            <?php if(in_array('knowledgebase', jssupportticket::$_active_addons)){ ?>
                <div class="js-ticket-downloads-heading-wrp">
                    <?php echo __('FAQs', 'js-support-ticket');
                    if (jssupportticket::$_data[0]['categoryname']) echo ' > ' . jssupportticket::$_data[0]['categoryname']->name; ?>
                </div>
            <?php
            }
            if (jssupportticket::$_data[0]['faqs']) { ?>
                <div class="js-ticket-downloads-content">
                    <?php foreach (jssupportticket::$_data[0]['faqs'] as $faq) { ?>
                        <div class="js-ticket-download-box">
                            <div class="js-ticket-download-left">
                                <a class="js-ticket-download-title js-ticket-kb-title " href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'faq', 'jstlay'=>'faqdetails', 'jssupportticketid'=>$faq->id))); ?>">
                                    <img alt="image" class="js-ticket-download-icon" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/kb/file.png" />
                                    <span class="js-ticket-download-name">
                                        <?php echo $faq->subject; ?>
                                    </span>
                                </a>
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
    <?php
} else {
    JSSTlayout::getSystemOffline();
} ?>
</div>
</div>
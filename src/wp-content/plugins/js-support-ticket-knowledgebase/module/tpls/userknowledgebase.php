<div class="jsst-main-up-wrapper">
<?php
if (jssupportticket::$_config['offline'] == 2) {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $("div#js-ticket-border-box-kb").mouseover(function () {
                $(this).find("div#js-ticket-subcat-data").show();
                $(this).addClass("js-ticket-border-box-kb-jsenabled");
                /*  				$(this).css('box-shadow','0 0 12px 1px #909090');
                 $(this).css('border','1px solid #418AC9');
                 $(this).css('color','#418AC9');
                 */  			});
            $("div#js-ticket-border-box-kb").mouseout(function () {
                $(this).find("div#js-ticket-subcat-data").hide();
                $(this).removeClass("js-ticket-border-box-kb-jsenabled");
                /*  				$(this).css('box-shadow','none');
                 $(this).css('border','1px solid #dadada');
                 $(this).css('color','#666666');
                 */  			});
        });
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
    <?php JSSTbreadcrumbs::getBreadcrumbs(); ?>
    <?php include_once(jssupportticket::$_path . 'includes/header.php'); ?>

    <div class="js-ticket-knowledgebase-wrapper">
        <div class="js-ticket-top-search-wrp">
            <div class="js-ticket-search-heading-wrp">
                <div class="js-ticket-heading-left">
                    <?php echo __('Search knowledgebase', 'js-support-ticket') ?>
                </div>
            </div>
            <div class="js-ticket-search-fields-wrp">
               <form class="js-filter-form" name="jssupportticketform" id="jssupportticketform" method="POST" action="<?php echo jssupportticket::makeUrl(array('jstmod'=>'knowledgebase', 'jstlay'=>'userknowledgebase')); ?>">
                    <div class="js-ticket-fields-wrp">
                        <div class="js-ticket-form-field js-ticket-form-field-download-search">
                            <?php echo JSSTformfield::text('jsst-search', jssupportticket::parseSpaces(jssupportticket::$_data[0]['kb-filter']['search']), array('placeholder' => __('Search', 'js-support-ticket'), 'class' => 'js-ticket-field-input')); ?>
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
        if (jssupportticket::$_data[0]['categories']) {
            ?>
            <div class="js-ticket-categories-wrp">
                <div class="js-ticket-categories-heading-wrp">
                    <?php echo __('Categories', 'js-support-ticket') ?>
                </div>
                <?php
                if (jssupportticket::$_data[0]['categories']) { ?>
                    <div class="js-ticket-categories-content">
                        <?php foreach (jssupportticket::$_data[0]['categories'] as $category) { ?>
                            <div class="js-ticket-category-box">
                                <a class="js-ticket-category-title" href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'knowledgebase', 'jstlay'=>'userknowledgebasearticles', 'jssupportticketid'=>$category->id))); ?>">
                                    <span class="js-ticket-category-download-logo js-ticket-category-kb-logo ">
                                        <?php
                                            if ($category->logo != '') {
                                                $datadirectory = jssupportticket::$_config['data_directory'];
                                                $maindir = wp_upload_dir();
                                                $path = $maindir['baseurl'];
                                                $path = $path.'/' . $datadirectory;
                                                $path .= "/knowledgebasedata/categories/category_" . $category->id . "/" . $category->logo;
                                            } else {
                                                $path = jssupportticket::$_pluginpath . 'includes/images/kb/category.png';
                                            }
                                            ?>
                                            <img alt="image" class="js-ticket-kb-img" src="<?php echo esc_url($path); ?>">
                                    </span>
                                    <span class="js-ticket-category-name">
                                        <?php echo $category->name; ?>
                                    </span>
                                </a>
                            </div>
                            <?php if (!empty($category->subcategory)) { ?>
                                <div id="js-ticket-subcat-data" class="js-ticket-subcat-data" style="display:none;">
                                    <?php $counter = 1;
                                    foreach ($category->subcategory as $subcategory) { ?>
                                        <div class="js-col-md-6 js-ticket-body-data-kb-text js-ticket-body-data-elipses"><a href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'knowledgebase', 'jstlay'=>'userknowledgebasearticles', 'jssupportticketid'=>$category->id))); ?>"> <?php echo $counter . '. ' . $subcategory->name; ?>   </a> </div>
                                        <?php
                                        $counter ++;
                                    }
                                    ?>
                                </div>
                            <?php } ?>
                        <?php
                        } ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>

        <div class="js-ticket-downloads-wrp">
            <div class="js-ticket-downloads-heading-wrp">
                <?php echo __('knowledgebase', 'js-support-ticket') ?>
            </div>
            <?php
            $per_id = null;
            if (jssupportticket::$_data[0]['articles']) { ?>
                <div class="js-ticket-downloads-content">
                    <?php foreach (jssupportticket::$_data[0]['articles'] as $article) {
                        $canshow = false;
                        if($per_id == null){
                            $per_id = $article->articleid;
                            $canshow = true;
                        }
                        if($per_id != $article->articleid){
                            $per_id = $article->articleid;
                            $canshow = true;
                        }
                        if($canshow){ ?>
                            <div class="js-ticket-download-box">
                                <div class="js-ticket-download-left">
                                    <a class="js-ticket-download-title js-ticket-kb-title " href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'knowledgebase', 'jstlay'=>'articledetails', 'jssupportticketid'=>$article->articleid))); ?>">
                                        <img alt="image" class="js-ticket-download-icon" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/kb/file.png" />
                                        <span class="js-ticket-download-name">
                                            <?php echo $article->subject; ?>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        <?php }
                    }?>
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
} else {
    JSSTlayout::getSystemOffline();
} ?>

</div>
<div class="jsst-main-up-wrapper">
<?php
if (jssupportticket::$_config['offline'] == 2) {
    ?>
    <?php JSSTmessage::getMessage(); ?>
    <?php JSSTbreadcrumbs::getBreadcrumbs(); ?>
    <?php include_once(jssupportticket::$_path . 'includes/header.php'); ?>
    <div class="js-ticket-categories-wrp js-ticket-kb-categories-wrp">
        <div class="js-ticket-categories-heading-wrp js-ticket-position-relative">
            <?php if (isset(jssupportticket::$_data[0]['categoryname']->logo) AND jssupportticket::$_data[0]['categoryname']->logo != '') {
                    $datadirectory = jssupportticket::$_config['data_directory'];
                    $maindir = wp_upload_dir();
                    $path = $maindir['baseurl'];

                    $path = $path .'/' . $datadirectory;
                    $path .= "/knowledgebasedata/categories/category_" . jssupportticket::$_data[0]['categoryname']->id . "/" . jssupportticket::$_data[0]['categoryname']->logo;
            } else {
                    $path = jssupportticket::$_pluginpath . 'includes/images/kb/category.png';
                } ?>
            <div class="js-ticket-head-category-image">
                <img alt="image" class="js-ticket-kb-dtl-img" src="<?php echo esc_url($path); ?>">
            </div>
            <span class="js-ticket-head-text">
                <?php $name = isset(jssupportticket::$_data[0]['categoryname']->name) ? jssupportticket::$_data[0]['categoryname']->name : ''; ?>
                <?php echo __($name, 'js-support-ticket'); ?>
            </span>
        </div>
        <?php
        $counter = 1;
        if (jssupportticket::$_data[0]['categories']) {
        ?>
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
                                <img alt="image" class="js-ticket-kb-dtl-img" src="<?php echo esc_url($path); ?>">
                        </span>
                        <span class="js-ticket-category-name">
                            <?php echo $counter . ".  " . $category->name; ?>
                        </span>
                        <span class="js-ticket-category-download-logo js-ticket-kb-download-btn">
                            <img alt="image" class="js-ticket-arrow-icon" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/arrowicon.png" />
                        </span>
                    </a>
                </div>
            <?php
            $counter ++;
            } ?>
        </div>
        <?php }
        ?>
    </div>

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
                    } if (isset(jssupportticket::$_data[1])) {
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
<script type="text/javascript">
    function resetFrom() {
        document.getElementById('title').value = '';
        var celement =  document.getElementById('categoryid');
        if (typeof(celement) != 'undefined' && celement != null){
            document.getElementById('categoryid').value = '';
        }

        //document.getElementById('type').value = '';
        document.getElementById('jssupportticketform').submit();
    }
</script>
<?php JSSTmessage::getMessage(); ?>
<?php
$type = array(
    (object) array('id' => '1', 'text' => __('Public', 'js-support-ticket')),
    (object) array('id' => '2', 'text' => __('Private', 'js-support-ticket'))
);
?>
<div id="jsstadmin-wrapper">
    <div id="jsstadmin-leftmenu">
        <?php  JSSTincluder::getClassesInclude('jsstadminsidemenu'); ?>
    </div>
    <div id="jsstadmin-data">
    <span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=jssupportticket&jstlay=controlpanel');?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Announcements', 'js-support-ticket') ?></span>
<a class="js-add-link button" href="?page=announcement&jstlay=addannouncement"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/add_icon.png" /><?php echo __('Add Announcement', 'js-support-ticket') ?></a>
    </span>
    <form class="js-filter-form" name="jssupportticketform" id="jssupportticketform" method="post" action="<?php echo admin_url("admin.php?page=announcement&jstlay=announcements"); ?>">
        <?php echo JSSTformfield::text('title', jssupportticket::$_data['filter']['title'], array('placeholder' => __('Title', 'js-support-ticket'))); ?>
        <?php if(in_array('knowledgebase',jssupportticket::$_active_addons)){ ?>
            <?php echo JSSTformfield::select('categoryid', JSSTincluder::getJSModel('knowledgebase')->getCategoryForCombobox('announcement'), jssupportticket::$_data['filter']['categoryid'], __('Select Category', 'js-support-ticket'), array('class' => 'inputbox'));
        }?>
        <?php //echo JSSTformfield::select('type', $type, jssupportticket::$_data['filter']['type'], __('Select Type', 'js-support-ticket'), array('class' => 'inputbox')); ?>
        <?php echo JSSTformfield::hidden('JSST_form_search', 'JSST_SEARCH'); ?>
        <?php echo JSSTformfield::submitbutton('go', __('Search', 'js-support-ticket'), array('class' => 'button')); ?>
        <?php echo JSSTformfield::button('reset', __('Reset', 'js-support-ticket'), array('class' => 'button', 'onclick' => 'resetFrom();')); ?>
    </form>

    <?php if (!empty(jssupportticket::$_data[0])) { ?>
        <div class="js-filter-form-list">
            <div class="js-filter-form-head js-filter-form-head-xs">
                <?php if(in_array('knowledgebase',jssupportticket::$_active_addons)){ ?>
                    <div class="js-col-md-4 js-col-xs-12 first"><?php echo __('Title', 'js-support-ticket'); ?></div>
                    <div class="js-col-md-3 js-col-xs-12 second js-textaligncenter"><?php echo __('Category', 'js-support-ticket'); ?></div>
                <?php }else{ ?>
                    <div class="js-col-md-7 js-col-xs-12 first"><?php echo __('Title', 'js-support-ticket'); ?></div>
                <?php } ?>
                <?php /*<div class="js-col-md-1 js-col-xs-12 third js-textaligncenter"><?php echo __('Type', 'js-support-ticket'); ?></div>*/ ?>
                <div class="js-col-md-1 js-col-xs-12 third js-textaligncenter"><?php echo __('Ordering', 'js-support-ticket'); ?></div>
                <div class="js-col-md-1 js-col-xs-12 fourth js-textaligncenter"><?php echo __('Status', 'js-support-ticket'); ?></div>
                <div class="js-col-md-1 js-col-xs-12 fifth"><?php echo __('Created', 'js-support-ticket'); ?></div>
                <div class="js-col-md-2 js-col-xs-12 seventh"><?php echo __('Action', 'js-support-ticket'); ?></div>
            </div>

            <?php
            $number = 0;
            $count = COUNT(jssupportticket::$_data[0]) - 1; //For zero base indexing
            $pagenum = JSSTrequest::getVar('pagenum', 'get', 1);
            $islastordershow = JSSTpagination::isLastOrdering(jssupportticket::$_data['total'], $pagenum);
            foreach (jssupportticket::$_data[0] AS $announcement) {
                $listtype = '';
                if ($announcement->type == 1)
                    $listtype = __('Public', 'js-support-ticket');
                elseif ($announcement->type == 2)
                    $listtype = __('Private', 'js-support-ticket');
                $status = ($announcement->status == 1) ? 'yes.png' : 'no.png';
                ?>
                <div class="js-filter-form-data">
            <?php if(in_array('knowledgebase',jssupportticket::$_active_addons)){ ?>
                    <div class="js-col-md-4 js-col-xs-12 first"><span class="js-filter-form-data-xs"><?php echo __('Title', 'js-support-ticket');
                echo " : "; ?></span><a href="?page=announcement&jstlay=addannouncement&jssupportticketid=<?php echo $announcement->id; ?>"><?php echo $announcement->title; ?></a></div>

                    <div class="js-col-md-3 js-col-xs-12 second js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Category', 'js-support-ticket');
                echo " : "; ?></span><?php echo $announcement->categoryname; ?></div>
            <?php }else{ ?>
                    <div class="js-col-md-7 js-col-xs-12 first"><span class="js-filter-form-data-xs"><?php echo __('Title', 'js-support-ticket');
                echo " : "; ?></span><a href="?page=announcement&jstlay=addannouncement&jssupportticketid=<?php echo $announcement->id; ?>"><?php echo $announcement->title; ?></a></div>
            <?php } ?>

                    <?php /*<div class="js-col-md-1 js-col-xs-12 third js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Type', 'js-support-ticket');
            echo " : "; ?></span> <?php echo $listtype ?></div>*/ ?>

                    <div class="js-col-md-1 js-col-xs-12 fourth js-textaligncenter">
                        <span class="js-filter-form-data-xs"><?php echo __('Ordering', 'js-support-ticket');
                            echo " : "; ?></span>
                            <?php if ($number != 0 || $pagenum > 1) { ?>
                                <?php
                                    $url  = "?page=announcement&task=ordering&action=jstask&order=up&announcementid=".$announcement->id;
                                    if($pagenum > 1){
                                        $url .= '&pagenum=' . $pagenum;
                                    } ?>
                                    <a href="<?php echo wp_nonce_url($url, 'ordering'); ?>" ><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/uparrow.png" /></a>
                            <?php } ?>
                            <?php echo $announcement->ordering;
                            if ($number < $count) { ?>
                                <?php
                                    $url = "?page=announcement&task=ordering&action=jstask&order=down&announcementid=".$announcement->id;
                                    if($pagenum > 1){
                                        $url .= '&pagenum=' . $pagenum;
                                    } ?>
                                    <a href="<?php echo wp_nonce_url($url, 'ordering'); ?>" ><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/downarrow.png" /></a>
                            <?php } elseif ($islastordershow) { ?>
                                    <?php
                                        $url  = "?page=announcement&task=ordering&action=jstask&order=down&announcementid=".$announcement->id;
                                        if($pagenum > 1){
                                            $url .= '&pagenum=' . $pagenum;
                                        } ?>
                                        <a href="<?php echo wp_nonce_url($url, 'ordering'); ?>" ><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/downarrow.png" /></a>
                            <?php } ?>
                    </div>
                    <div class="js-col-md-1 js-col-xs-12 fourth js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Status', 'js-support-ticket');
                        echo " : "; ?></span>
                        <a href="<?php echo wp_nonce_url('?page=announcement&task=changestatus&action=jstask&announcementid='.$announcement->id,'change-status'); ?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/' . $status; ?>" /></a></div>
                    <div class="js-col-md-1 js-col-xs-12 fifth js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Created', 'js-support-ticket');
            echo " : "; ?></span><?php echo date_i18n(jssupportticket::$_config['date_format'], strtotime($announcement->created)); ?></div>
                    <div class="js-col-md-2 js-col-xs-12 seventh js-filter-form-action-hl-xs js-textaligncenter">
                        <a href="?page=announcement&jstlay=addannouncement&jssupportticketid=<?php echo $announcement->id; ?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/edit.png" /></a>&nbsp;&nbsp;
                        <a onclick="return confirm('<?php echo __('Are you sure to delete'); ?>');" href="<?php echo wp_nonce_url('?page=announcement&task=deleteannouncement&action=jstask&announcementid='. $announcement->id,'delete-announcement'); ?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/remove.png" /></a>
                    </div>
                </div>

            <?php
            $number ++;
        }
        ?>
        </div>
        <?php
        if (jssupportticket::$_data[1]) {
            echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . jssupportticket::$_data[1] . '</div></div>';
        }
    } else {
        JSSTlayout::getNoRecordFound();
    }
    ?>
</div>
</div>

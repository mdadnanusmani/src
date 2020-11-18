<script type="text/javascript">
    function resetFrom() {
        document.getElementById('emailaddress').value = '';
        document.getElementById('jssupportticketform').submit();
    }
</script>
<?php JSSTmessage::getMessage();
$mailreadtype = array(
    (object) array('id' => '1', 'text' => __('Only New Tickets', 'js-support-ticket')),
    (object) array('id' => '2', 'text' => __('Only Replies', 'js-support-ticket')),
    (object) array('id' => '3', 'text' => __('Both', 'js-support-ticket'))
);
$hosttype = array(
    (object) array('id' => '1', 'text' => __('Gmail', 'js-support-ticket')),
    (object) array('id' => '2', 'text' => __('Yahoo', 'js-support-ticket')),
    (object) array('id' => '3', 'text' => __('Aol', 'js-support-ticket')),
    (object) array('id' => '5', 'text' => __('Hotmail', 'js-support-ticket')),
    (object) array('id' => '4', 'text' => __('Other', 'js-support-ticket'))
);
$yesno = array(
    (object) array('id' => '1', 'text' => __('Yes', 'js-support-ticket')),
    (object) array('id' => '2', 'text' => __('No', 'js-support-ticket'))
);
 ?>
<div id="jsstadmin-wrapper">
    <div id="jsstadmin-leftmenu">
        <?php  JSSTincluder::getClassesInclude('jsstadminsidemenu'); ?>
    </div>
    <div id="jsstadmin-data">
    <span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=jssupportticket&jstlay=controlpanel');?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Email Piping', 'js-support-ticket'); ?></span>
    <a class="js-add-link button" href="?page=emailpiping&jstlay=addticketviaemail"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/add_icon.png" /><?php echo __('Add Email Piping', 'js-support-ticket'); ?></a>
        </span>
        <form class="js-filter-form" name="jssupportticketform" id="jssupportticketform" method="post" action="<?php echo admin_url("admin.php?page=emailpiping&jstlay=ticketviaemail"); ?>">
            <?php echo JSSTformfield::text('emailaddress', jssupportticket::$_data['filter']['emailaddress'], array('placeholder' => __('Email', 'js-support-ticket'))); ?>
            <?php echo JSSTformfield::hidden('JSST_form_search', 'JSST_SEARCH'); ?>
            <?php echo JSSTformfield::submitbutton('go', __('Search', 'js-support-ticket'), array('class' => 'button')); ?>
            <?php echo JSSTformfield::button(__('Reset', 'js-support-ticket'), __('Reset', 'js-support-ticket'), array('class' => 'button', 'onclick' => 'resetFrom();')); ?>
        </form>
        <?php if (!empty(jssupportticket::$_data[0])) { ?>
            <div class="js-filter-form-list">
                <div class="js-filter-form-head js-filter-form-head-xs">
                    <div class="js-col-md-4 js-col-xs-12 first"><?php echo __('Email', 'js-support-ticket'); ?></div>
                    <div class="js-col-md-2 js-col-xs-12 third js-textaligncenter"><?php echo __('Ticket Email Type', 'js-support-ticket'); ?></div>
                    <div class="js-col-md-2 js-col-xs-12 second js-textaligncenter"><?php echo __('Host Type', 'js-support-ticket'); ?></div>
                    <div class="js-col-md-2 js-col-xs-12 fourth js-textaligncenter"><?php echo __('Attachments', 'js-support-ticket'); ?></div>
                    <div class="js-col-md-2 js-col-xs-12 sixth"><?php echo __('Action', 'js-support-ticket'); ?></div>
                </div>
                <?php
                $number = 0;
                $count = COUNT(jssupportticket::$_data[0]) - 1; //For zero base indexing
                $pagenum = JSSTrequest::getVar('pagenum', 'get', 1);
                $islastordershow = JSSTpagination::isLastOrdering(jssupportticket::$_data['total'], $pagenum);
                foreach (jssupportticket::$_data[0] AS $ticketviaemail) {
                    $attachments = ($ticketviaemail->attachment == 2) ? 'No' : 'Yes';
                    if($ticketviaemail->mailreadtype == 1) $tickettype = 'Only New Tickets'; elseif($ticketviaemail->mailreadtype == 2) $tickettype = 'Only Replies'; else $tickettype = 'Both';
                    if($ticketviaemail->hosttype == 1) $hosttype = 'Gmail'; elseif($ticketviaemail->hosttype == 2) $hosttype = 'Yahoo';elseif($ticketviaemail->hosttype == 3) $hosttype = 'Aol';elseif($ticketviaemail->hosttype == 5) $hosttype = 'Hotmail'; elseif($ticketviaemail->hosttype == 4) $hosttype = $ticketviaemail->hostname;
                    ?>
                    <div class="js-filter-form-data">
                        <div class="js-col-md-4 js-col-xs-12 first"><span class="js-filter-form-data-xs"><?php
                                echo __('Title', 'js-support-ticket');
                                echo " : ";
                                ?></span><a href="?page=emailpiping&jstlay=addticketviaemail&jssupportticketid=<?php echo $ticketviaemail->id; ?>"><?php echo __($ticketviaemail->emailaddress, 'js-support-ticket'); ?></a></div>
                        <div class="js-col-md-2 js-col-xs-12 first js-textaligncenter"><span class="js-filter-form-data-xs"><?php
                                echo __('Title', 'js-support-ticket');
                                echo " : ";
                                ?></span><?php echo __($tickettype, 'js-support-ticket'); ?></div>
                        <div class="js-col-md-2 js-col-xs-12 first js-textaligncenter"><span class="js-filter-form-data-xs"><?php
                                echo __('Title', 'js-support-ticket');
                                echo " : ";
                                ?></span><?php echo __($hosttype, 'js-support-ticket'); ?></div>
                        <div class="js-col-md-2 js-col-xs-12 first js-textaligncenter"><span class="js-filter-form-data-xs"><?php
                                echo __('Title', 'js-support-ticket');
                                echo " : ";
                                ?></span><?php echo __($attachments, 'js-support-ticket'); ?></div>
                        <div class="js-col-md-2 js-col-xs-12 sixth js-filter-form-action-hl-xs">
                            <a href="?page=emailpiping&jstlay=addticketviaemail&jssupportticketid=<?php echo $ticketviaemail->id; ?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/edit.png" /></a>&nbsp;&nbsp;
                            <a onclick="return confirm('<?php echo __('Are you sure to delete', 'js-support-ticket'); ?>');" href="<?php echo wp_nonce_url('?page=emailpiping&task=deleteticketviaemail&action=jstask&ticketviaemailid='.$ticketviaemail->id,'delete-ticketviaemail');?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/remove.png" /></a>
                        </div>
                    </div>
                <?php
                $number++;
            }
            ?>		</div>
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

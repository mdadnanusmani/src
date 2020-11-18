<?php
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    wp_enqueue_script('jquery-ui-datepicker');
    wp_enqueue_style('jquery-ui-css', $protocol.'ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
?>
<script type="text/javascript">
    function resetFrom() {
        var form = jQuery('form#jssupportticketform');
        form.find("input[type=text], input[type=email], input[type=password], textarea").val("");
        form.find('input:checkbox').removeAttr('checked');
        form.find('select').prop('selectedIndex', 0);
        form.find('input[type="radio"]').prop('checked', false);
        document.getElementById('jssupportticketform').submit();
    }
    jQuery(document).ready(function(){
        jQuery('.date,.custom_date').datepicker({dateFormat: 'yy-mm-dd'});

        jQuery('a.jssortlink').click(function(e){
            e.preventDefault();
            var sortby = jQuery(this).attr('href');
            jQuery('input#sortby').val(sortby);
            jQuery('form#jssupportticketform').submit();
        });
        jQuery('a.js-myticket-link').click(function(e){
            e.preventDefault();
            var list = jQuery(this).attr('data-tab-number');
            jQuery('input#list').val(list);
            jQuery('form#jssupportticketform').submit();
        });
    });

    function setDepartmentFilter( depid ){
        jQuery('#departmentid').val( depid );
        jQuery('form#jssupportticketform').submit();
    }

    function setFromNameFilter( email ){
        jQuery('#email').val( email );
        jQuery('form#jssupportticketform').submit();
    }
</script>
<?php JSSTmessage::getMessage(); ?>
<div id="jsstadmin-wrapper">
    <div id="jsstadmin-leftmenu">
        <?php
        if(current_user_can('jsst_support_ticket')){
            JSSTincluder::getClassesInclude('jsstadminsidemenu');
        }
        ?>
    </div>
    <div id="jsstadmin-data">
    <span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=jssupportticket&jstlay=controlpanel');?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Tickets', 'js-support-ticket'); ?></span>
    <a class="js-add-link button" href="?page=ticket&jstlay=addticket"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/add_icon.png" /><?php echo __('Add Ticket', 'js-support-ticket'); ?></a>
        </span>
        <?php
        $list = JSSTrequest::getVar('list', null, null);
        if($list == null){
            $list = (isset($_SESSION['JSST_list']) && $_SESSION['JSST_list'] != '') ? $_SESSION['JSST_list'] : 1;
        }
        $open = ($list == 1) ? 'active' : '';
        $answered = ($list == 2) ? 'active' : '';
        $overdue = ($list == 3) ? 'active' : '';
        $closed = ($list == 4) ? 'active' : '';
        $alltickets = ($list == 5) ? 'active' : '';
        $field_array = JSSTincluder::getJSModel('fieldordering')->getFieldTitleByFieldfor(1);
        ?>
        <form class="js-filter-form" name="jssupportticketform" id="jssupportticketform" method="post" action="<?php echo admin_url("admin.php?page=ticket&jstlay=tickets"); ?>">
            <?php echo JSSTformfield::text('subject', jssupportticket::$_data['filter']['subject'], array('placeholder' => __($field_array['subject'], 'js-support-ticket'))); ?>
            <?php echo JSSTformfield::text('name', jssupportticket::$_data['filter']['name'], array('placeholder' => __('From', 'js-support-ticket'))); ?>
            <?php echo JSSTformfield::text('email', jssupportticket::$_data['filter']['email'], array('placeholder' => __($field_array['email'], 'js-support-ticket'))); ?>
            <?php if ( in_array('agent',jssupportticket::$_active_addons)) { ?>
                <?php echo JSSTformfield::select('staffid', JSSTincluder::getJSModel('agent')->getStaffForCombobox(), jssupportticket::$_data['filter']['staffid'], __('Select staff','js-support-ticket')); ?>
            <?php } ?>
            <?php echo JSSTformfield::select('departmentid', JSSTincluder::getJSModel('department')->getDepartmentForCombobox(), jssupportticket::$_data['filter']['departmentid'], __('Select','js-support-ticket').' '.__($field_array['department'],'js-support-ticket')); ?>
            <?php echo JSSTformfield::select('priority', JSSTincluder::getJSModel('priority')->getPriorityForCombobox(), jssupportticket::$_data['filter']['priority'], __('Select','js-support-ticket').' '.__($field_array['priority'],'js-support-ticket')); ?>
            <?php echo JSSTformfield::text('datestart', jssupportticket::$_data['filter']['datestart'], array('placeholder' => __('Date start', 'js-support-ticket'), 'class' => 'date')); ?>
            <?php echo JSSTformfield::text('dateend', jssupportticket::$_data['filter']['dateend'], array('placeholder' => __('Date end', 'js-support-ticket'), 'class' => 'date')); ?>
            <?php echo JSSTformfield::text('ticketid', jssupportticket::$_data['filter']['ticketid'], array('placeholder' => __('Ticket ID', 'js-support-ticket'))); ?>
            <?php if(class_exists('WooCommerce') && in_array('woocommerce', jssupportticket::$_active_addons)){  ?>
                <?php echo JSSTformfield::text('orderid', jssupportticket::$_data['filter']['orderid'], array('placeholder' => __($field_array['wcorderid'], 'js-support-ticket'))); ?>
            <?php } ?>
            <?php echo JSSTformfield::hidden('JSST_form_search', 'JSST_SEARCH'); ?>
            <?php echo JSSTformfield::hidden('sortby', jssupportticket::$_data['filter']['sortby']); ?>
            <?php echo JSSTformfield::hidden('list', $list); ?>
            <?php
                $customfields = JSSTincluder::getObjectClass('customfields')->userFieldsForSearch(1);
                foreach ($customfields as $field) {
                    JSSTincluder::getObjectClass('customfields')->formCustomFieldsForSearch($field, $k, 1);
                }
            ?>
            <?php echo JSSTformfield::submitbutton('go', __('Search', 'js-support-ticket'), array('class' => 'button js-search-btn')); ?>
            <?php echo JSSTformfield::button(__('Reset', 'js-support-ticket'), __('Reset', 'js-support-ticket'), array('class' => 'button js-reset-btn', 'onclick' => 'resetFrom();')); ?>
        </form>
        <div class="js-col-md-12" style = "margin-bottom:10px;margin-top:10px;">
            <div class="js-col-md-2 js-myticket-link js-col-md-offset-1">
                <a class="js-myticket-link <?php echo $open; ?>" href="#" data-tab-number="1">
                    <?php
                        echo __('Open', 'js-support-ticket');
                        if(jssupportticket::$_config['count_on_myticket'] == 1)
                            echo ' ( '.jssupportticket::$_data['count']['openticket'].' )';
                    ?>
                </a>
            </div>
            <div class="js-col-md-2 js-myticket-link">
                <a class="js-myticket-link <?php echo $answered; ?>" href="#" data-tab-number="2">
                    <?php
                        echo __('Answered', 'js-support-ticket');
                        if(jssupportticket::$_config['count_on_myticket'] == 1)
                            echo ' ( '.jssupportticket::$_data['count']['answeredticket'].' )';
                    ?>
                </a>
            </div>
            <div class="js-col-md-2 js-myticket-link">
                <a class="js-myticket-link <?php echo $overdue; ?>" href="#" data-tab-number="3">
                    <?php
                        echo __('Overdue', 'js-support-ticket');
                        if(jssupportticket::$_config['count_on_myticket'] == 1)
                            echo ' ( '.jssupportticket::$_data['count']['overdueticket'].' )';
                    ?>
                </a>
            </div>

            <div class="js-col-md-2 js-myticket-link">
                <a class="js-myticket-link <?php echo $closed; ?>" href="#" data-tab-number="4">
                    <?php
                        echo __('Closed', 'js-support-ticket');
                        if(jssupportticket::$_config['count_on_myticket'] == 1)
                            echo ' ( '.jssupportticket::$_data['count']['closedticket'].' )';
                    ?>
                </a>
            </div>
            <div class="js-col-md-2 js-myticket-link">
                <a class="js-myticket-link <?php echo $alltickets; ?>" href="#" data-tab-number="5">
                    <?php
                        echo __('All Tickets', 'js-support-ticket');
                        if(jssupportticket::$_config['count_on_myticket'] == 1)
                            echo ' ( '.jssupportticket::$_data['count']['allticket'].' )';
                    ?>
                </a>
            </div>
        </div>

        <?php
        $link = '?page=ticket';
        if (jssupportticket::$_sortorder == 'ASC')
            $img = "sort0.png";
        else
            $img = "sort1.png";
        ?>
        <div class="js-admin-sorting js-col-md-12">
            <span class="js-col-md-2 js-admin-sorting-link"><a href="<?php echo jssupportticket::$_sortlinks['subject']; ?>" class="jssortlink <?php if (jssupportticket::$_sorton == 'subject') echo 'selected' ?>"><?php echo __($field_array['subject'], 'js-support-ticket'); ?><?php if (jssupportticket::$_sorton == 'subject') { ?> <img alt="image" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/' . $img ?>"> <?php } ?></a></span>
            <span class="js-col-md-2 js-admin-sorting-link"><a href="<?php echo jssupportticket::$_sortlinks['priority']; ?>" class="jssortlink <?php if (jssupportticket::$_sorton == 'priority') echo 'selected' ?>"><?php echo __($field_array['priority'], 'js-support-ticket'); ?><?php if (jssupportticket::$_sorton == 'priority') { ?> <img alt="image" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/' . $img ?>"> <?php } ?></a></span>
            <span class="js-col-md-2 js-admin-sorting-link"><a href="<?php echo jssupportticket::$_sortlinks['ticketid']; ?>" class="jssortlink <?php if (jssupportticket::$_sorton == 'ticketid') echo 'selected' ?>"><?php echo __('Ticket ID', 'js-support-ticket'); ?><?php if (jssupportticket::$_sorton == 'ticketid') { ?> <img alt="image" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/' . $img ?>"> <?php } ?></a></span>
            <span class="js-col-md-2 js-admin-sorting-link"><a href="<?php echo jssupportticket::$_sortlinks['isanswered']; ?>" class="jssortlink <?php if (jssupportticket::$_sorton == 'isanswered') echo 'selected' ?>"><?php echo __('Answered', 'js-support-ticket'); ?><?php if (jssupportticket::$_sorton == 'isanswered') { ?> <img alt="image" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/' . $img ?>"> <?php } ?></a></span>
            <span class="js-col-md-2 js-admin-sorting-link"><a href="<?php echo jssupportticket::$_sortlinks['status']; ?>" class="jssortlink <?php if (jssupportticket::$_sorton == 'status') echo 'selected' ?>"><?php echo __($field_array['status'], 'js-support-ticket'); ?><?php if (jssupportticket::$_sorton == 'status') { ?> <img alt="image" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/' . $img ?>"> <?php } ?></a></span>
            <span class="js-col-md-2 js-admin-sorting-link"><a href="<?php echo jssupportticket::$_sortlinks['created']; ?>" class="jssortlink <?php if (jssupportticket::$_sorton == 'created') echo 'selected' ?>"><?php echo __('Created', 'js-support-ticket'); ?><?php if (jssupportticket::$_sorton == 'created') { ?> <img alt="image" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/' . $img ?>"> <?php } ?></a></span>
        </div>
        <?php
        if (!empty(jssupportticket::$_data[0])) {
            ?>
            <!-- Tabs Area -->
            <?php
            foreach (jssupportticket::$_data[0] AS $ticket) {
                if ($ticket->status == 0) {
                    $style = "#9ACC00;";
                    $status = __('New', 'js-support-ticket');
                } elseif ($ticket->status == 1) {
                    $style = "#FFB613;";
                    $status = __('Waiting Reply', 'js-support-ticket');
                } elseif ($ticket->status == 2) {
                    $style = "#FE7C2C;";
                    $status = __('In Progress', 'js-support-ticket');
                } elseif ($ticket->status == 3) {
                    $style = "#217ac3;";
                    $status = __('Replied', 'js-support-ticket');
                } elseif ($ticket->status == 4) {
                    $style = "#F04646;";
                    $status = __('Closed', 'js-support-ticket');
                } elseif ($ticket->status == 5) {
                    $style = "#F04646;";
                    $status = __('Close due to merged', 'js-support-ticket');
                }
                $ticketviamail = '';
                if ($ticket->ticketviaemail == 1)
                    $ticketviamail = __('Created via Email', 'js-support-ticket');
                ?>
                <div class="js-col-xs-12 js-col-md-12 js-ticket-wrapper">
                    <div class="js-col-xs-12 js-col-md-12 js-ticket-toparea">
                        <div class="js-col-xs-2 js-col-md-1 js-ticket-pic">
                            <?php if (in_array('agent',jssupportticket::$_active_addons) && $ticket->staffphoto) { ?>
                                <img  src="<?php echo admin_url('?page=agent&action=jstask&task=getStaffPhoto&jssupportticketid='.$ticket->staffid); ?>">
                            <?php } else {
                            if (isset($ticket->uid) && !empty($ticket->uid)) {
                                echo get_avatar($ticket->uid);
                            } else { ?>
                                <img alt="image" src="<?php echo jssupportticket::$_pluginpath . '/includes/images/ticketmanbig.png'; ?>" />
                            <?php } ?>
                <?php } ?>
                        </div>
                        <div class="js-col-xs-10 js-col-md-8 js-ticket-data js-nullpadding">
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-body-data-elipses">
                                <span class="js-ticket-title"><?php echo __($field_array['subject'], 'js-support-ticket'); ?>&nbsp;:&nbsp;</span>
                                <a href="?page=ticket&jstlay=ticketdetail&jssupportticketid=<?php echo $ticket->id; ?>"><?php echo $ticket->subject; ?></a>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12">
                                <span class="js-ticket-title"><?php echo __('From', 'js-support-ticket'); ?>&nbsp;:&nbsp;</span>
                                <span class="js-ticket-value" style="cursor:pointer;" onClick="setFromNameFilter('<?php echo $ticket->email; ?>');"><?php echo $ticket->name; ?></span>
                            </div>
                            <div class="js-col-xs-12 js-col-md-12">
                                <span class="js-ticket-title"><?php echo __($field_array['department'], 'js-support-ticket'); ?>&nbsp;:&nbsp;</span>
                                <span class="js-ticket-value" style="cursor:pointer;" onClick="setDepartmentFilter('<?php echo $ticket->departmentid; ?>');"><?php echo $ticket->departmentname; ?></span>
                            </div>
                            <?php
                                    jssupportticket::$_data['ticketid'] = $ticket->id;
                                    $customfields = JSSTincluder::getObjectClass('customfields')->userFieldsData(1, 1);
                                    foreach ($customfields as $field) {
                                        echo JSSTincluder::getObjectClass('customfields')->showCustomFields($field,1, $ticket->params);
                                    }
                                    ?>
                            <span class="js-ticket-value js-ticket-creade-via-email-spn"><?php echo $ticketviamail; ?></span>
                            <span class="js-ticket-status" style="background:<?php echo $style; ?>">
                                <?php
                                $counter = 'one';
                                if ($ticket->lock == 1) { ?>
                                    <img class="ticketstatusimage <?php echo $counter; $counter = 'two'; ?>" src="<?php echo jssupportticket::$_pluginpath . "includes/images/lockstatus.png"; ?>" title="<?php echo __('Ticket is locked', 'js-support-ticket'); ?>" />
                                <?php } ?>
                                <?php if ($ticket->isoverdue == 1) { ?>
                                    <img class="ticketstatusimage <?php echo $counter; ?>" src="<?php echo jssupportticket::$_pluginpath . "includes/images/mark_over_due.png"; ?>" title="<?php echo __('Ticket mark overdue', 'js-support-ticket'); ?>" />
                                <?php } ?>
                                <?php echo $status; ?>
                            </span>
                        </div>
                        <div class="js-col-xs-12 js-col-md-3 js-ticket-data1">
                            <div class="js-row">
                                <div class="js-col-xs-6 js-col-md-6"><?php echo __('Ticket ID', 'js-support-ticket'); ?></div>
                                <div class="js-col-xs-6 js-col-md-6"><?php echo $ticket->ticketid; ?></div>
                            </div>
                            <div class="js-row">
                                <div class="js-col-xs-6 js-col-md-6"><?php echo __('Last Reply', 'js-support-ticket'); ?></div>
                                <div class="js-col-xs-6 js-col-md-6"><?php if (empty($ticket->lastreply) || $ticket->lastreply == '0000-00-00 00:00:00') echo __('No Last Reply', 'js-support-ticket'); else echo date_i18n(jssupportticket::$_config['date_format'], strtotime($ticket->lastreply)); ?></div>
                            </div>
                            <div class="js-row">
                                <div class="js-col-xs-6 js-col-md-6"><?php echo __($field_array['priority'], 'js-support-ticket'); ?></div>
                                <div class="js-col-xs-6 js-col-md-6 js-ticket-wrapper-textcolor" style="background:<?php echo $ticket->prioritycolour; ?>;"><?php echo __($ticket->priority, 'js-support-ticket'); ?></div>
                            </div>
                            <?php if (in_array('agent',jssupportticket::$_active_addons)) { ?>
                                <div class="js-row">
                                    <div class="js-col-xs-6 js-col-md-6"><?php echo __($field_array['assignto'], 'js-support-ticket'); ?></div>
                                    <div class="js-col-xs-6 js-col-md-6"><?php echo $ticket->staffname; ?></div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="js-ticket-bottom-line"></div>
                    </div>
                    <div class="js-col-xs-12 js-col-md-12 js-ticket-bottom-data-part">
                        <span class="js-ticket-created"><?php echo __('Created', 'js-support-ticket'); ?>&nbsp;:&nbsp;<?php echo date_i18n(jssupportticket::$_config['date_format'], strtotime($ticket->created)); ?></span>
                        <div class="js-ticket-datapart-buttons-action">
                            <a class="js-ticket-bottom-data-part-action-button button"  onclick="return confirm('<?php echo __('Are you sure to enforce delete', 'js-support-ticket'); ?>');" href="<?php echo wp_nonce_url('?page=ticket&task=enforcedeleteticket&action=jstask&ticketid='.$ticket->id,'enforce-delete-ticket')?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/close.png" /><?php echo __('Enforce delete', 'js-support-ticket'); ?></a>
                            <a class="js-ticket-bottom-data-part-action-button button"  onclick="return confirm('<?php echo __('Are you sure to delete', 'js-support-ticket'); ?>');" href="<?php echo wp_nonce_url('?page=ticket&task=deleteticket&action=jstask&ticketid='.$ticket->id,'delete-ticket');?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/remove.png" /><?php echo __('Delete', 'js-support-ticket'); ?></a>
                            <a class="js-ticket-bottom-data-part-action-button button" href="?page=ticket&jstlay=addticket&jssupportticketid=<?php echo $ticket->id; ?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/edit.png" /><?php echo __('Edit', 'js-support-ticket'); ?></a>
                        </div>
                        <div class="js-ticket-datapart-buttons-detail">
                            <a class="js-ticket-bottom-data-part-action-button button" href="?page=ticket&jstlay=ticketdetail&jssupportticketid=<?php echo $ticket->id; ?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/detail.png" /><?php echo __('Ticket Detail', 'js-support-ticket'); ?></a>
                        </div>
                    </div>
                </div>
                <?php
            }
            if (jssupportticket::$_data[1]) {
                echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . jssupportticket::$_data[1] . '</div></div>';
            }
        } else {
            JSSTlayout::getNoRecordFound();
        }
        ?>
    </div>
</div>

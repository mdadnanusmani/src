<div class="jsst-main-up-wrapper">
<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
wp_enqueue_style('status-graph', jssupportticket::$_pluginpath . 'includes/css/status_graph.css');
if (jssupportticket::$_config['offline'] == 2) {
    if (get_current_user_id() != 0) {
        if ( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()) {
            if (jssupportticket::$_data['staff_enabled']) {
                wp_enqueue_script('jquery-ui-datepicker');
                wp_enqueue_style('jquery-ui-css', $protocol.'ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
                ?>
                <script type="text/javascript">
                    ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
                    jQuery(document).ready(function ($) {
                        jQuery('.custom_date').datepicker({dateFormat: 'yy-mm-dd'});
                        var combinesearch = "<?php echo isset(jssupportticket::$_data['filter']['combinesearch']) ? jssupportticket::$_data['filter']['combinesearch'] : ''; ?>";
                        if (combinesearch) {
                            doVisible();
                            jQuery("#js-filter-wrapper-toggle-area").show();
                        }
                        jQuery("#js-filter-wrapper-toggle-btn").click(function () {
                            if (jQuery("#js-filter-wrapper-toggle-search").is(":visible")) {
                                doVisible();
                            } else {
                                jQuery("#js-filter-wrapper-toggle-search").show();
                                jQuery(".js-filter-wrapper-toggle-ticketid").hide();
                                jQuery("#js-filter-wrapper-toggle-minus").hide();
                                jQuery("#js-filter-wrapper-toggle-plus").show();
                            }
                            jQuery("#js-filter-wrapper-toggle-area").toggle();
                        });

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


                        function doVisible() {
                            jQuery("#js-filter-wrapper-toggle-search").hide();
                            jQuery(".js-filter-wrapper-toggle-ticketid").show();
                            jQuery("#js-filter-wrapper-toggle-minus").show();
                            jQuery("#js-filter-wrapper-toggle-plus").hide();
                        }
                    });
                    function resetForm() {
                        var form = jQuery('form#jssupportticketform');
                        form.find("input[type=text], input[type=email], input[type=password], textarea").val("");
                        form.find('input:checkbox').removeAttr('checked');
                        form.find('select').prop('selectedIndex', 0);
                        form.find('input[type="radio"]').prop('checked', false);
                        return true;
                    }
                    function setDepartmentFilter( depid ){
                        jQuery('#departmentid').val( depid );
                        jQuery('form#jssupportticketform').submit();
                    }

                    function setFromNameFilter( email ){
                        jQuery('#jsst-email').val( email );
                        jQuery('form#jssupportticketform').submit();
                    }
                </script>

                <?php JSSTmessage::getMessage(); ?>
                <?php JSSTbreadcrumbs::getBreadcrumbs(); ?>
                <?php include_once(jssupportticket::$_path . 'includes/header.php'); ?>
                <?php
                $list = JSSTrequest::getVar('list', null, null);
                if($list == null){
                    $list = (isset($_SESSION['JSST_list']) && $_SESSION['JSST_list'] != '') ? $_SESSION['JSST_list'] : 1;
                }
                $open = ($list == 1) ? 'active' : '';
                $closed = ($list == 2) ? 'active' : '';
                $answered = ($list == 3) ? 'active' : '';
                $overdue = ($list == 5) ? 'active' : '';
                $allticket = ($list == 4) ? 'active' : '';
                $field_array = JSSTincluder::getJSModel('fieldordering')->getFieldTitleByFieldfor(1);
                $show_field = JSSTincluder::getJSModel('fieldordering')->getFieldsForListing(1);
                ?>
                <?php
                $open_percentage = 0;
                $close_percentage = 0;
                $overdue_percentage = 0;
                $answered_percentage = 0;
                if(jssupportticket::$_data['count']['allticket'] != 0){
                    $open_percentage = round((jssupportticket::$_data['count']['openticket'] / jssupportticket::$_data['count']['allticket']) * 100);
                    $close_percentage = round((jssupportticket::$_data['count']['closedticket'] / jssupportticket::$_data['count']['allticket']) * 100);
                    $overdue_percentage = round((jssupportticket::$_data['count']['overdue'] / jssupportticket::$_data['count']['allticket']) * 100);
                    $answered_percentage = round((jssupportticket::$_data['count']['answeredticket'] / jssupportticket::$_data['count']['allticket']) * 100);
                }
                if(jssupportticket::$_data['count']['allticket'] != 0){
                    $allticket_percentage = 100;
                }else
                {
                    $allticket_percentage = 0;
                }
                ?>
                <!-- Top Circle Count Boxes -->
                <div class="js-row js-ticket-top-cirlce-count-wrp">
                    <div class="js-col-xs-12 js-col-md-2 js-myticket-link">
                        <a class="js-ticket-green js-myticket-link <?php echo $open; ?>" href="#" data-tab-number="1">
                            <div class="js-ticket-cricle-wrp" data-per="<?php echo $open_percentage; ?>" >
                                <div class="js-mr-rp" data-progress="<?php echo $open_percentage; ?>">
                                    <div class="circle">
                                        <div class="mask full">
                                             <div class="fill js-ticket-open"></div>
                                        </div>
                                        <div class="mask half">
                                            <div class="fill js-ticket-open"></div>
                                            <div class="fill fix"></div>
                                        </div>
                                        <div class="shadow"></div>
                                    </div>
                                    <div class="inset">
                                    </div>
                                </div>
                            </div>
                            <span class="js-ticket-circle-count-text js-ticket-green">
                                <?php
                                    echo __('Open', 'js-support-ticket');
                                    if(jssupportticket::$_config['count_on_myticket'] == 1)
                                    echo ' ( ' . jssupportticket::$_data['count']['openticket'] . ' )';
                                ?>
                            </span>
                        </a>
                    </div>
                    <div class="js-col-xs-12 js-col-md-2 js-myticket-link">
                        <a class="js-ticket-red js-myticket-link <?php echo $closed; ?>" href="#" data-tab-number="2">
                            <div class="js-ticket-cricle-wrp" data-per="<?php echo $close_percentage; ?>" >
                                <div class="js-mr-rp" data-progress="<?php echo $close_percentage; ?>">
                                    <div class="circle">
                                        <div class="mask full">
                                             <div class="fill js-ticket-close"></div>
                                        </div>
                                        <div class="mask half">
                                            <div class="fill js-ticket-close"></div>
                                            <div class="fill fix"></div>
                                        </div>
                                        <div class="shadow"></div>
                                    </div>
                                    <div class="inset">
                                    </div>
                                </div>
                            </div>
                            <span class="js-ticket-circle-count-text js-ticket-red">
                                <?php
                                    echo __('Closed', 'js-support-ticket');
                                    if(jssupportticket::$_config['count_on_myticket'] == 1)
                                    echo ' ( ' . jssupportticket::$_data['count']['closedticket'] . ' )';
                                ?>
                            </span>
                        </a>
                    </div>
                    <div class="js-col-xs-12 js-col-md-2 js-myticket-link">
                        <a class="js-ticket-blue js-myticket-link <?php echo $answered; ?>" href="#" data-tab-number="3">
                            <div class="js-ticket-cricle-wrp" data-per="<?php echo $answered_percentage; ?>" >
                                <div class="js-mr-rp" data-progress="<?php echo $answered_percentage; ?>">
                                    <div class="circle">
                                        <div class="mask full">
                                             <div class="fill js-ticket-answer"></div>
                                        </div>
                                        <div class="mask half">
                                            <div class="fill js-ticket-answer"></div>
                                            <div class="fill fix"></div>
                                        </div>
                                        <div class="shadow"></div>
                                    </div>
                                    <div class="inset">
                                    </div>
                                </div>
                            </div>
                            <span class="js-ticket-circle-count-text js-ticket-blue">
                                <?php
                                    echo __('Answered', 'js-support-ticket');
                                    if(jssupportticket::$_config['count_on_myticket'] == 1)
                                    echo ' ( ' . jssupportticket::$_data['count']['answeredticket'] . ' )';
                                ?>
                            </span>
                        </a>
                    </div>
                    <div class="js-col-xs-12 js-col-md-2 js-myticket-link">
                        <a class="js-ticket-pink js-myticket-link <?php echo $overdue; ?>" href="#" data-tab-number="5">
                            <div class="js-ticket-cricle-wrp" data-per="<?php echo $overdue_percentage; ?>" >
                                <div class="js-mr-rp" data-progress="<?php echo $overdue_percentage; ?>">
                                    <div class="circle">
                                        <div class="mask full">
                                             <div class="fill js-ticket-overdue"></div>
                                        </div>
                                        <div class="mask half">
                                            <div class="fill js-ticket-overdue"></div>
                                            <div class="fill fix"></div>
                                        </div>
                                        <div class="shadow"></div>
                                    </div>
                                    <div class="inset">
                                    </div>
                                </div>
                            </div>
                            <span class="js-ticket-circle-count-text js-ticket-pink">
                                <?php
                                    echo __('Overdue', 'js-support-ticket');
                                    if(jssupportticket::$_config['count_on_myticket'] == 1)
                                    echo ' ( ' . jssupportticket::$_data['count']['overdue'] . ' )';
                                ?>
                            </span>
                        </a>
                    </div>
                    <div class="js-col-xs-12 js-col-md-2 js-myticket-link">
                        <a class="js-ticket-orange js-myticket-link <?php echo $allticket; ?>" href="#" data-tab-number="4">
                            <div class="js-ticket-cricle-wrp" data-per="<?php echo $allticket; ?>" >
                                <div class="js-mr-rp" data-progress="100">
                                    <div class="circle">
                                        <div class="mask full">
                                             <div class="fill js-ticket-allticket"></div>
                                        </div>
                                        <div class="mask half">
                                            <div class="fill js-ticket-allticket"></div>
                                            <div class="fill fix"></div>
                                        </div>
                                        <div class="shadow"></div>
                                    </div>
                                    <div class="inset">
                                    </div>
                                </div>
                            </div>
                            <span class="js-ticket-circle-count-text js-ticket-orange">
                                <?php
                                    echo __('All Tickets', 'js-support-ticket');
                                    if(jssupportticket::$_config['count_on_myticket'] == 1)
                                    echo ' ( ' . jssupportticket::$_data['count']['allticket'] . ' )';
                                ?>
                            </span>
                        </a>
                    </div>
                </div>

                <!-- Search Form -->
                <div class="js-ticket-search-wrp">
                    <div class="js-ticket-search-heading"><?php echo __('Search Ticket', 'js-support-ticket');?></div>
                    <div class="js-ticket-form-wrp">
                        <form class="js-filter-form" name="jssupportticketform" id="jssupportticketform" method="POST" action="<?php echo jssupportticket::makeUrl(array('jstmod'=>'ticket','jstlay'=>'staffmyticket')); ?>">
                            <div class="js-filter-wrapper">
                                <div class="js-filter-form-fields-wrp" id="js-filter-wrapper-toggle-search">
                                    <?php echo JSSTformfield::text('jsst-ticketsearchkeys', isset(jssupportticket::$_data['filter']['ticketsearchkeys']) ? esc_attr(jssupportticket::$_data['filter']['ticketsearchkeys']) : '', array('class' => 'js-ticket-input-field','placeholder' => __('Ticket ID', 'js-support-ticket') . ' ' . __('Or', 'js-support-ticket') . ' ' . __($field_array['email'], 'js-support-ticket') . ' ' . __('Or', 'js-support-ticket') . ' ' . __($field_array['subject'], 'js-support-ticket'))); ?>
                                </div>
                                <div class="js-filter-form-fields-wrp js-filter-wrapper-toggle-ticketid">
                                    <?php echo JSSTformfield::text('jsst-ticket', isset(jssupportticket::$_data['filter']['ticketid']) ? jssupportticket::$_data['filter']['ticketid'] : '', array('class' => 'js-ticket-input-field', 'placeholder' => __('Ticket ID', 'js-support-ticket'))); ?>
                                </div>
                                <div id="js-filter-wrapper-toggle-btn">
                                    <div id="js-filter-wrapper-toggle-plus">
                                        <img alt="image" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/ticketdetailicon/plus.png'; ?>" />
                                    </div>
                                    <div id="js-filter-wrapper-toggle-minus">
                                        <img alt="image" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/ticketdetailicon/minus.png'; ?>" />
                                    </div>
                                </div>
                                <div id="js-filter-wrapper-toggle-area" class="js-filter-wrapper-toggle-ticketid">
                                    <div class="js-col-md-12 js-filter-field-wrp">
                                        <?php echo JSSTformfield::text('jsst-from', isset(jssupportticket::$_data['filter']['from']) ? jssupportticket::$_data['filter']['from'] : '', array('class' => 'js-ticket-input-field', 'placeholder' => __('From', 'js-support-ticket'))); ?>
                                    </div>
                                    <div class="js-col-md-12 js-filter-field-wrp">
                                        <?php echo JSSTformfield::text('jsst-email', isset(jssupportticket::$_data['filter']['email']) ? jssupportticket::$_data['filter']['email'] : '', array('class' => 'js-ticket-input-field', 'placeholder' => __($field_array['email'], 'js-support-ticket'))); ?>
                                    </div>
                                    <div class="js-col-md-12 js-filter-field-wrp">
                                        <?php echo JSSTformfield::select('jsst-departmentid', JSSTincluder::getJSModel('department')->getDepartmentForCombobox(), isset(jssupportticket::$_data['filter']['departmentid']) ? jssupportticket::$_data['filter']['departmentid'] : '', __('Select', 'js-support-ticket').' '.__($field_array['department'], 'js-support-ticket')); ?>
                                    </div>
                                    <div class="js-col-md-12 js-filter-field-wrp">
                                        <?php echo JSSTformfield::select('jsst-priorityid', JSSTincluder::getJSModel('priority')->getPriorityForCombobox(), isset(jssupportticket::$_data['filter']['priorityid']) ? jssupportticket::$_data['filter']['priorityid'] : '', __('Select', 'js-support-ticket').' '.__($field_array['priority'], 'js-support-ticket')); ?>
                                    </div>
                                    <div class="js-col-md-12 js-filter-field-wrp">
                                        <?php echo JSSTformfield::text('jsst-subject', isset(jssupportticket::$_data['filter']['subject']) ? jssupportticket::$_data['filter']['subject'] : '', array('class' => 'js-ticket-input-field', 'placeholder' => __($field_array['subject'], 'js-support-ticket'))); ?>
                                    </div>
                                    <?php if(JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('View User')){ ?>
                                        <div class="js-col-md-12 js-filter-field-wrp">
                                            <?php echo JSSTformfield::select('staffid', JSSTincluder::getJSModel('agent')->getStaffForCombobox(), isset(jssupportticket::$_data['filter']['staffid']) ? jssupportticket::$_data['filter']['staffid'] : '', __('Select staff','js-support-ticket')); ?>
                                        </div>
                                    <?php } ?>
                                    <div class="js-col-md-12 js-filter-field-wrp">
                                        <?php echo JSSTformfield::text('jsst-datestart', isset(jssupportticket::$_data['filter']['datestart']) ? jssupportticket::$_data['filter']['datestart'] : '', array('class' => 'custom_date js-ticket-input-field', 'placeholder' => __('Start Date', 'js-support-ticket'))); ?>
                                    </div>
                                    <div class="js-col-md-12 js-filter-field-wrp">
                                        <?php echo JSSTformfield::text('jsst-dateend', isset(jssupportticket::$_data['filter']['dateend']) ? jssupportticket::$_data['filter']['dateend'] : '', array('class' => 'custom_date js-ticket-input-field', 'placeholder' => __('End Date', 'js-support-ticket'))); ?>
                                    </div>
                                    <?php
                                    if(in_array('woocommerce', jssupportticket::$_active_addons)){ ?>
                                        <div class="js-col-md-12 js-filter-field-wrp">
                                            <?php echo JSSTformfield::text('jsst-orderid', isset(jssupportticket::$_data['filter']['orderid']) ? jssupportticket::$_data['filter']['orderid'] : '', array('class' => 'js-ticket-input-field', 'placeholder' => __($field_array['wcorderid'], 'js-support-ticket'))); ?>
                                        </div><?php
                                    } ?>
                                    <?php $customfields = JSSTincluder::getObjectClass('customfields')->userFieldsForSearch(1);
                                        foreach ($customfields as $field) {
                                            JSSTincluder::getObjectClass('customfields')->formCustomFieldsForSearch($field, $k);
                                        }  ?>
                                    <div class="js-col-md-12 js-filter-field-wrp">
                                    <div class="js-ticket-assigned-tome"><?php echo JSSTformfield::checkbox('assignedtome', array('1' => __("Assigned To Me", 'js-support-ticket')), isset(jssupportticket::$_data['filter']['assignedtome']) ? jssupportticket::$_data['filter']['assignedtome'] : '0', array('class' => 'radiobutton')); ?></div>
                                    </div>
                                </div>
                                <div class="js-filter-button-wrp">
                                    <?php echo JSSTformfield::submitbutton('jsst-go', __('Search', 'js-support-ticket'), array('class' => 'js-ticket-filter-button js-ticket-search-btn')); ?>
                                    <?php echo JSSTformfield::submitbutton('jsst-reset', __('Reset', 'js-support-ticket'), array('class' => 'js-ticket-filter-button js-ticket-reset-btn', 'onclick' => 'return resetForm();')); ?>
                                </div>
                            </div>

                            <?php echo JSSTformfield::hidden('sortby', isset(jssupportticket::$_data['filter']['sortby']) ? jssupportticket::$_data['filter']['sortby'] :'' ); ?>
                            <?php echo JSSTformfield::hidden('list', $list); ?>
                            <?php echo JSSTformfield::hidden('JSST_form_search', 'JSST_SEARCH'); ?>
                            <?php echo JSSTformfield::hidden('jsstpageid', get_the_ID()); ?>
                        </form>
                    </div>
                </div>

                <!-- Sorting Wrapper -->
                <?php
                $link = jssupportticket::makeUrl(array('jstmod'=>'agent','jstlay'=>'staffmyticket','list'=> jssupportticket::$_data['list']));
                if (jssupportticket::$_sortorder == 'ASC')
                    $img = "sort1.png";
                else
                    $img = "sort2.png";
                ?>
                <div class="js-ticket-sorting js-col-md-12">
                    <span class="js-col-md-2 js-ticket-sorting-link"><a href="<?php echo jssupportticket::$_sortlinks['subject']; ?>" class="jssortlink <?php if (jssupportticket::$_sorton == 'subject') echo 'selected' ?>"><?php echo __($field_array['subject'], 'js-support-ticket'); ?><?php if (jssupportticket::$_sorton == 'subject') { ?> <img alt="image" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/ticketdetailicon/' . $img ?>"> <?php } ?></a></span>
                    <span class="js-col-md-2 js-ticket-sorting-link"><a href="<?php echo jssupportticket::$_sortlinks['priority']; ?>" class="jssortlink <?php if (jssupportticket::$_sorton == 'priority') echo 'selected' ?>"><?php echo __($field_array['priority'], 'js-support-ticket'); ?><?php if (jssupportticket::$_sorton == 'priority') { ?> <img alt="image" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/ticketdetailicon/' . $img ?>"> <?php } ?></a></span>
                    <span class="js-col-md-2 js-ticket-sorting-link"><a href="<?php echo jssupportticket::$_sortlinks['ticketid']; ?>" class="jssortlink <?php if (jssupportticket::$_sorton == 'ticketid') echo 'selected' ?>"><?php echo __('Ticket ID', 'js-support-ticket'); ?><?php if (jssupportticket::$_sorton == 'ticketid') { ?> <img alt="image" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/ticketdetailicon/' . $img ?>"> <?php } ?></a></span>
                    <span class="js-col-md-2 js-ticket-sorting-link"><a href="<?php echo jssupportticket::$_sortlinks['isanswered']; ?>" class="jssortlink <?php if (jssupportticket::$_sorton == 'isanswered') echo 'selected' ?>"><?php echo __('Answered', 'js-support-ticket'); ?><?php if (jssupportticket::$_sorton == 'isanswered') { ?> <img alt="image" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/ticketdetailicon/' . $img ?>"> <?php } ?></a></span>
                    <span class="js-col-md-2 js-ticket-sorting-link"><a href="<?php echo jssupportticket::$_sortlinks['status']; ?>" class="jssortlink <?php if (jssupportticket::$_sorton == 'status') echo 'selected' ?>"><?php echo __($field_array['status'], 'js-support-ticket'); ?><?php if (jssupportticket::$_sorton == 'status') { ?> <img alt="image" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/ticketdetailicon/' . $img ?>"> <?php } ?></a></span>
                    <span class="js-col-md-2 js-ticket-sorting-link"><a href="<?php echo jssupportticket::$_sortlinks['created']; ?>" class="jssortlink <?php if (jssupportticket::$_sorton == 'created') echo 'selected' ?>"><?php echo __('Created', 'js-support-ticket'); ?><?php if (jssupportticket::$_sorton == 'created') { ?> <img alt="image" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/ticketdetailicon/' . $img ?>"> <?php } ?></a></span>
                </div>

                <?php
                if (!empty(jssupportticket::$_data[0])) {
                    foreach (jssupportticket::$_data[0] AS $ticket) {
                        if ($ticket->status == 0) {
                            $style = "#5bb12f;";
                            $status = __('New', 'js-support-ticket');
                        } elseif ($ticket->status == 1) {
                            $style = "#28abe3;";
                            $status = __('Waiting Reply', 'js-support-ticket');
                        } elseif ($ticket->status == 2) {
                            $style = "#69d2e7;";
                            $status = __('In Progress', 'js-support-ticket');
                        } elseif ($ticket->status == 3) {
                            $style = "#FFB613;";
                            $status = __('Replied', 'js-support-ticket');
                        } elseif ($ticket->status == 4) {
                            $style = "#ed1c24;";
                            $status = __('Closed', 'js-support-ticket');
                        } elseif ($ticket->status == 5) {
                            $style = "#dc2742;";
                            $status = __('Closed and Merged', 'js-support-ticket');
                        }
                        $ticketviamail = '';
                        if ($ticket->ticketviaemail == 1)
                            $ticketviamail = __('Created via Email', 'js-support-ticket');
                        ?>
                        <div class="js-col-xs-12 js-col-md-12 js-ticket-wrapper">
                            <div class="js-col-xs-12 js-col-md-12 js-ticket-toparea">
                                <div class="js-col-xs-2 js-col-md-2 js-ticket-pic">
                                    <?php if (in_array('agent',jssupportticket::$_active_addons) && $ticket->staffphoto) { ?>
                                        <img class="js-ticket-staff-img" src="<?php echo jssupportticket::makeUrl(array('jstmod'=>'agent','task'=>'getStaffPhoto','action'=>'jstask','jssupportticketid'=> $ticket->staffid ,'jsstpageid'=>get_the_ID()));?> ">
                                    <?php } else {
                                        if (isset($ticket->uid) && !empty($ticket->uid)) {
                                            echo get_avatar($ticket->uid);
                                        } else { ?>
                                            <img class="js-ticket-staff-img" src="<?php echo jssupportticket::$_pluginpath . '/includes/images/ticketmanbig.png'; ?>" />
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                                <div class="js-col-xs-10 js-col-md-6 js-col-xs-10 js-ticket-data js-nullpadding">
                                    <div class="js-col-xs-12 js-col-md-12 js-ticket-padding-xs js-ticket-body-data-elipses">
                                        <span class="js-ticket-title"><?php echo __($field_array['subject'], 'js-support-ticket'); ?>&nbsp;:&nbsp;</span>
                                        <a class="js-ticket-title-anchor" href="<?php echo esc_url(jssupportticket::makeUrl(array('jstmod'=>'ticket','jstlay'=>'ticketdetail','jssupportticketid'=> $ticket->id))); ?>"><?php echo __($ticket->subject,"js-support-ticket"); ?></a>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-12 js-ticket-padding-xs js-ticket-body-data-elipses">
                                        <span class="js-ticket-title"><?php echo __('From', 'js-support-ticket'); ?>&nbsp;:&nbsp;</span>
                                        <span class="js-ticket-value" style="cursor:pointer;" onClick="setFromNameFilter('<?php echo $ticket->email; ?>');"><?php echo __($ticket->name,"js-support-ticket"); ?></span>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-12 js-ticket-padding-xs js-ticket-body-data-elipses">
                                        <span class="js-ticket-title"><?php echo __($field_array['department'], 'js-support-ticket'); ?>&nbsp;:&nbsp;</span>
                                        <span class="js-ticket-value" style="cursor:pointer;" onClick="setDepartmentFilter('<?php echo $ticket->departmentid; ?>');"><?php echo __($ticket->departmentname,"js-support-ticket"); ?></span>
                                    </div>
                                    <?php
                                        jssupportticket::$_data['ticketid'] = $ticket->id;
                                        $customfields = JSSTincluder::getObjectClass('customfields')->userFieldsData(1, 1);
                                        foreach ($customfields as $field) {
                                            echo JSSTincluder::getObjectClass('customfields')->showCustomFields($field,1, $ticket->params);
                                        }
                                        if ($ticket->ticketviaemail == 1){  ?>
                                            <span class="js-ticket-value js-ticket-creade-via-email-spn"><?php echo $ticketviamail; ?></span>
                                        <?php } ?>
                                    <span class="js-ticket-status" style="background:<?php echo $style; ?>">
                                        <?php
                                        $counter = 'one';
                                        if ($ticket->lock == 1) { ?>
                                            <img class="ticketstatusimage <?php echo $counter;
                                                $counter = 'two'; ?>" src="<?php echo jssupportticket::$_pluginpath . "includes/images/lockstatus.png"; ?>" title="<?php echo __('Ticket is locked', 'js-support-ticket'); ?>" />
                                        <?php } ?>
                                        <?php if ($ticket->isoverdue == 1) { ?>
                                                <img class="ticketstatusimage <?php echo $counter; ?>" src="<?php echo jssupportticket::$_pluginpath . "includes/images/mark_over_due.png"; ?>" title="<?php echo __('Ticket mark overdue', 'js-support-ticket'); ?>" />
                                        <?php } ?>
                                        <?php echo $status; ?>
                                    </span>
                                </div>
                                <div class="js-col-xs-12 js-col-md-4 js-ticket-data1 js-ticket-padding-left-xs">
                                    <div class="js-row">
                                        <div class="js-col-xs-6 js-col-md-6 js-col-xs-6"><?php echo __('Ticket ID', 'js-support-ticket'); ?></div>
                                        <div class="js-col-xs-6 js-col-md-6 js-col-xs-6"><?php echo $ticket->ticketid; ?></div>
                                    </div>
                                    <div class="js-row">
                                        <div class="js-col-xs-6 js-col-md-6 js-col-xs-6"><?php echo __('Last Reply', 'js-support-ticket'); ?></div>
                                        <div class="js-col-xs-6 js-col-md-6 js-col-xs-6"><?php if (empty($ticket->lastreply) || $ticket->lastreply == '0000-00-00 00:00:00') echo __('No Last Reply', 'js-support-ticket');
                                            else echo date_i18n(jssupportticket::$_config['date_format'], strtotime($ticket->lastreply)); ?>
                                        </div>
                                    </div>
                                    <div class="js-row">
                                        <div class="js-col-xs-6 js-col-md-6 js-col-xs-6"><?php echo __($field_array['priority'], 'js-support-ticket'); ?></div>
                                        <div class="js-col-xs-6 js-col-md-6 js-col-xs-6"><span class="js-ticket-wrapper-textcolor" style="background:<?php echo $ticket->prioritycolour; ?>;"><?php echo __($ticket->priority, 'js-support-ticket'); ?></span></div>
                                    </div>
                                    <?php
                                        if ($show_field['assignto'] == 1) { ?>
                                            <div class="js-row">
                                                <div class="js-col-xs-6 js-col-md-6 js-col-xs-6"><?php echo __($field_array['assignto'], 'js-support-ticket'); ?></div>
                                                <div class="js-col-xs-6 js-col-md-6 js-col-xs-6"><?php echo $ticket->staffname; ?></div>
                                            </div>
                                   <?php  } ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    }

                    if (jssupportticket::$_data[1]) {
                        echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . jssupportticket::$_data[1] . '</div></div>';
                    }
                } else { // Record Not FOund
                    JSSTlayout::getNoRecordFound();
                }
            } else {
                JSSTlayout::getStaffMemberDisable();
            }
        } else { // user not Staff
            JSSTlayout::getNotStaffMember();
        }
    } else {// User is guest
        $redirect_url = jssupportticket::makeUrl(array('jstmod'=>'ticket','jstlay'=>'staffmyticket'));
        $redirect_url = base64_encode($redirect_url);
        JSSTlayout::getUserGuest($redirect_url);
    }
} else { // System is offline
    JSSTlayout::getSystemOffline();
}
?>

</div>

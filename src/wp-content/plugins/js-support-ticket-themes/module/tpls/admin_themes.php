<?php
wp_enqueue_script('colorpicker.js', jssupportticket::$_pluginpath . 'includes/js/colorpicker.js');
wp_enqueue_style('jssupportticket-main-css', jssupportticket::$_pluginpath . 'includes/css/style.css');
wp_enqueue_style('colorpicker-style', jssupportticket::$_pluginpath . 'includes/css/colorpicker.css');
include_once jssupportticket::$_path . 'includes/css/style.php';
JSSTmessage::getMessage();

?>
<style type="text/css">
<?php
$color1 = jssupportticket::$_colors['color1'];
$color2 = jssupportticket::$_colors['color2'];
$color3 = jssupportticket::$_colors['color3'];
$color4 = jssupportticket::$_colors['color4'];
$color5 = jssupportticket::$_colors['color5'];
$color6 = jssupportticket::$_colors['color6'];
$color7 = jssupportticket::$_colors['color7'];
$color8 = jssupportticket::$_colors['color8'];
$color9 = jssupportticket::$_colors['color9'];


echo '


div.js-ticket-wrapper{border:1px solid'.$color5.';box-shadow: 0 8px 6px -6px #dedddd;}
div.js-ticket-wrapper:hover{border:1px solid'.$color2.';}
div.js-ticket-wrapper:hover div.js-ticket-pic{border-right:1px solid'.$color2.';}
div.js-ticket-wrapper:hover div.js-ticket-data1{border-left:1px solid'.$color2.';}
div.js-ticket-wrapper:hover div.js-ticket-bottom-line{background'.$color2.';}
div.js-ticket-wrapper div.js-ticket-pic{border-right:1px solid'.$color5.';}
div.js-ticket-wrapper div.js-ticket-data span.js-ticket-status{color:#FFFFFF;}
div.js-ticket-wrapper div.js-ticket-data1{border-left:1px solid'.$color5.';}
div.js-ticket-wrapper div.js-ticket-data span.js-ticket-title{color:'.$color4.';}
a.js-ticket-title-anchor:hover{color:'.$color2.' !important;}
div.js-ticket-wrapper div.js-ticket-data span.js-ticket-value{color:'.$color4.';}
div.js-ticket-wrapper div.js-ticket-bottom-line{background'.$color2.';}
div.js-ticket-assigned-tome{border:1px solid'.$color5.';background-color:'.$color3.';}
div.js-ticket-sorting span.js-ticket-sorting-link a{background:#373435;color:'.$color7.';color:#fff;}
div.js-ticket-sorting span.js-ticket-sorting-link a.selected,
div.js-ticket-sorting span.js-ticket-sorting-link a:hover{background:'.$color2.';}
div#jsst-header div#jsst-header-heading a{color:'.$color7.';}
';


?>

        div.js-ticket-sorting{float: left;width: 100%;}

    /* My Tickets $ Staff My Tickets*/
        div.js-ticket-wrapper{margin:8px 0px;padding-left: 0px;padding-right: 0px;}
        div.js-ticket-wrapper div.js-ticket-pic{margin: 10px 0px;padding: 0px;padding: 0px 10px;text-align: center;position: relative;float: left;width: 16%;height: 96px;}
        div.js-ticket-wrapper div.js-ticket-pic img.js-ticket-staff-img{width: auto;max-width: 96px;max-height: 96px;height: auto;position: absolute;top: 0;left: 0;right: 0;bottom: 0;margin: auto;}
        div.js-ticket-wrapper div.js-ticket-data{position: relative;padding: 23px 0px;}
        div.js-ticket-wrapper div.js-ticket-data span.js-ticket-status{position: absolute;top:41%;right:2%;padding: 10px 10px;border-radius: 20px;font-size: 10px;line-height: 1;font-weight: bold;}
        div.js-ticket-wrapper div.js-ticket-data span.js-ticket-status img.ticketstatusimage{position: absolute;top:0px;}
        div.js-ticket-wrapper div.js-ticket-data span.js-ticket-status img.ticketstatusimage.one{left:-25px;}
        div.js-ticket-wrapper div.js-ticket-data span.js-ticket-status img.ticketstatusimage.two{left:-50px;}
        div.js-ticket-wrapper div.js-ticket-data1{margin:0px 0px;padding: 17px 15px;}
        div.js-ticket-wrapper div.js-ticket-bottom-line{position:absolute;display: inline-block;width:90%;margin:0 5%;height:1px;left:0px;bottom: 0px;}
        div.js-ticket-wrapper div.js-ticket-toparea{position: relative;padding:0px;}
        div.js-ticket-wrapper div.js-ticket-bottom-data-part{padding: 0px;margin-bottom: 10px;}
        div.js-ticket-wrapper div.js-ticket-bottom-data-part a.button{float:right;margin-left: 10px;padding:0px 20px;line-height: 30px;height:32px;}
        div.js-ticket-wrapper div.js-ticket-bottom-data-part a.button img{height:16px;margin-right:5px;}
        div.js-ticket-assigned-tome{float: left;width: 100%;padding: 11px 10px;}
        div.js-ticket-assigned-tome input#assignedtome1{margin-right: 5px; vertical-align: middle;}
        div.js-ticket-assigned-tome label#forassignedtome{margin: 0px;display: inline-block;}
        label#forassigntome{margin: 0px;display: inline-block;}
        span.js-ticket-wrapper-textcolor{display: inline-block;padding: 5px 10px;min-width: 85px;text-align: center;}
    /* Sorting Section */
        div.js-ticket-sorting{padding-right: 0px;padding-left: 0px;margin-bottom: 15px;}
        div.js-ticket-sorting span.js-ticket-sorting-link{padding-right:0px;padding-left: 0px;}
        div.js-ticket-sorting span.js-ticket-sorting-link a{text-decoration: none;display: block;padding: 15px; text-align:center;color: #fff !important;}
        div.js-ticket-sorting span.js-ticket-sorting-link a img{display: inline-block;vertical-align: text-top;}

</style>
<div id="jsstadmin-wrapper">
    <div id="jsstadmin-leftmenu">
        <?php  JSSTincluder::getClassesInclude('jsstadminsidemenu'); ?>
    </div>
    <div id="jsstadmin-data">
    <span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=jssupportticket&jstlay=controlpanel');?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __("Themes", 'js-support-ticket') ?></span></span>
        <?php do_action('cm_theme_colors_message', 'js-support-ticket'); ?>
        <div id="theme_heading">
            <div class="left_side">
                <span class="job_sharing_text"><?php echo __('Color Chooser', 'js-support-ticket'); ?></span>
            </div>
            <div class="right_side">
                <a href="#" id="preset_theme"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/preset_theme.png" /><span class="theme_presets_theme"><?php echo __('Preset Theme', 'js-support-ticket'); ?></span></a>
            </div>
        </div>
        <div class="js_theme_section">
            <form action="<?php echo admin_url('admin.php?page=themes&task=savetheme'); ?>" method="POST" name="adminForm" id="adminForm">
                <span class="js_theme_heading">
                    <?php echo __('Color Chooser', 'js-support-ticket'); ?>
                </span>
                <div class="color_portion">
                    <span class="color_title"><?php echo __('Color 1', 'js-support-ticket'); ?></span>
                    <input type="text" name="color1" id="color1" value="<?php echo jssupportticket::$_data[0]['color1']; ?>" style="background:<?php echo jssupportticket::$_data[0]['color1']; ?>;"/>
                    <span class="color_location">
                        <?php echo __('Top menu heading background', 'js-support-ticket'); ?>
                    </span>
                </div>
                <div class="color_portion">
                    <span class="color_title"><?php echo __('Color 2', 'js-support-ticket'); ?></span>
                    <input type="text" name="color2" id="color2" value="<?php echo jssupportticket::$_data[0]['color2']; ?>" style="background:<?php echo jssupportticket::$_data[0]['color2']; ?>;"/>
                    <span class="color_location">
                        <?php echo __('Top header line color', 'js-support-ticket'); ?>,
                        <?php echo __('Button Hover', 'js-support-ticket'); ?>,
                        <?php echo __('Heading text', 'js-support-ticket'); ?>
                    </span>
                </div>
                <div class="color_portion">
                    <span class="color_title"><?php echo __('Color 3', 'js-support-ticket'); ?></span>
                    <input type="text" name="color3" id="color3" value="<?php echo jssupportticket::$_data[0]['color3']; ?>" style="background:<?php echo jssupportticket::$_data[0]['color3']; ?>;"/>
                    <span class="color_location"><?php echo __('Content Background Color', 'js-support-ticket'); ?></span>
                </div>
                <div class="color_portion">
                    <span class="color_title"><?php echo __('Color 4', 'js-support-ticket'); ?></span>
                    <input type="text" name="color4" id="color4" value="<?php echo jssupportticket::$_data[0]['color4']; ?>" style="background:<?php echo jssupportticket::$_data[0]['color4']; ?>;"/>
                    <span class="color_location"><?php echo __('Content Text Color', 'js-support-ticket'); ?></span>
                </div>
                <div class="color_portion">
                    <span class="color_title"><?php echo __('Color 5', 'js-support-ticket'); ?></span>
                    <input type="text" name="color5" id="color5" value="<?php echo jssupportticket::$_data[0]['color5']; ?>" style="background:<?php echo jssupportticket::$_data[0]['color5']; ?>;"/>
                    <span class="color_location">
                        <?php echo __('Border color', 'js-support-ticket'); ?>,
                        <?php echo __('Lines', 'js-support-ticket'); ?>
                    </span>
                </div>
                <div class="color_portion">
                    <span class="color_title"><?php echo __('Color 6', 'js-support-ticket'); ?></span>
                    <input type="text" name="color6" id="color6" value="<?php echo jssupportticket::$_data[0]['color6']; ?>" style="background:<?php echo jssupportticket::$_data[0]['color6']; ?>;"/>
                    <span class="color_location"><?php echo __('Button Color', 'js-support-ticket'); ?></span>
                </div>
                <div class="color_portion">
                    <span class="color_title"><?php echo __('Color 7', 'js-support-ticket'); ?></span>
                    <input type="text" name="color7" id="color7" value="<?php echo jssupportticket::$_data[0]['color7']; ?>" style="background:<?php echo jssupportticket::$_data[0]['color7']; ?>;"/>
                    <span class="color_location"><?php echo __('Top header text color', 'js-support-ticket'); ?></span>
                </div>
                <div class="color_submit_button">
                    <input type="hidden" name="form_request" value="jssupportticket" />
                    <input type="submit" value="<?php echo __('Save Theme', 'js-support-ticket'); ?>" />
                </div>
            </form>
        </div>
        <div class="js_effect_preview">
            <span class="js_effect_preview_heading"><?php echo __('Color Effect Preview', 'js-support-ticket'); ?></span>
            <main class="span12" role="main" id="content">
                <div class="jsst-main-up-wrapper">

                    <div id="jsst-header-main-wrapper" style="">
                        <div id="jsst-header" class="">
                            <div id="jsst-header-heading" class=""><a class="js-ticket-header-links" href="#">My Tickets</a></div>
                            <div id="jsst-tabs-wrp" class="">
                                <span class="jsst-header-tab js-ticket-homeclass">
                                    <a class="js-cp-menu-link" href="#">
                                        <img class="cp-menu-link-img" title="Dashboard-icon" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/dashboard-icon/header-icon/dashboard.png">
                                        Dashboard
                                    </a>
                                </span>
                                <span class="jsst-header-tab js-ticket-openticketclass">
                                    <a class="js-cp-menu-link" href="#">
                                        <img class="cp-menu-link-img" title="New Ticket" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/dashboard-icon/header-icon/add-ticket.png">
                                        New Ticket
                                    </a>
                                </span>
                                <span class="jsst-header-tab js-ticket-myticket">
                                    <a class="js-cp-menu-link" href="#">
                                        <img class="cp-menu-link-img" title="My Tickets" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/dashboard-icon/header-icon/my-tickets.png">
                                        My Tickets
                                    </a>
                                </span>
                                <span class="jsst-header-tab js-ticket-loginlogoutclass">
                                    <a class="js-cp-menu-link" href="#">
                                        <img class="cp-menu-link-img" title="Login" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/dashboard-icon/header-icon/logout.png">
                                        Log out
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- Top Circle Count Boxes -->
                    <!-- Search Form -->
                    <!-- Sorting Wrapper -->
                    <div class="js-ticket-sorting js-col-md-12">
                        <span class="js-col-md-2 js-ticket-sorting-link"><a href="#" class="jssortlink ">Subject</a></span>
                        <span class="js-col-md-2 js-ticket-sorting-link"><a href="#" class="jssortlink ">Priority</a></span>
                        <span class="js-col-md-2 js-ticket-sorting-link"><a href="#" class="jssortlink ">Ticket ID</a></span>
                        <span class="js-col-md-2 js-ticket-sorting-link"><a href="#" class="jssortlink ">Answered</a></span>
                        <span class="js-col-md-2 js-ticket-sorting-link"><a href="#" class="jssortlink selected">Status <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketdetailicon/sort1.png"> </a></span>
                        <span class="js-col-md-2 js-ticket-sorting-link"><a href="#" class="jssortlink ">Created</a></span>
                    </div>

                    <div class="js-col-xs-12 js-col-md-12 js-ticket-wrapper">
                        <div class="js-col-xs-12 js-col-md-12 js-ticket-toparea">
                            <div class="js-col-xs-2 js-col-md-2 js-ticket-pic">
                                <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketman.png">
                            </div>
                            <div class="js-col-xs-10 js-col-md-6 js-col-xs-10 js-ticket-data js-nullpadding">
                                <div class="js-col-xs-12 js-col-md-12 js-ticket-padding-xs js-ticket-body-data-elipses">
                                    <span class="js-ticket-field-title">Subject&nbsp;:&nbsp;</span>
                                    <a href="#">Test Ticket Title</a>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-ticket-padding-xs js-ticket-body-data-elipses">
                                    <span class="js-ticket-field-title">From&nbsp;:&nbsp;</span>
                                    <span class="js-ticket-value">Name</span>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-ticket-padding-xs js-ticket-body-data-elipses">
                                    <span class="js-ticket-field-title">Department&nbsp;:&nbsp;</span>
                                    <span class="js-ticket-value">Department</span>
                                </div>
                                <span class="js-ticket-status" style="background:#5bb12f;">New</span>
                            </div>
                            <div class="js-col-xs-12 js-col-md-4 js-ticket-data1 js-ticket-padding-left-xs">
                                <div class="js-row">
                                    <div class="js-col-xs-6 js-col-md-6 js-col-xs-6">Ticket ID</div>
                                    <div class="js-col-xs-6 js-col-md-6 js-col-xs-6">a1b2c3d4e5</div>
                                </div>
                                <div class="js-row">
                                    <div class="js-col-xs-6 js-col-md-6 js-col-xs-6">Last Reply</div>
                                    <div class="js-col-xs-6 js-col-md-6 js-col-xs-6">No Last Reply</div>
                                </div>
                                <div class="js-row">
                                    <div class="js-col-xs-6 js-col-md-6 js-col-xs-6">Priority</div>
                                    <div class="js-col-xs-6 js-col-md-6 js-col-xs-6"><span class="js-ticket-wrapper-textcolor" style="background:#c90000;">Urgent</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="js-col-xs-12 js-col-md-12 js-ticket-wrapper">
                        <div class="js-col-xs-12 js-col-md-12 js-ticket-toparea">
                            <div class="js-col-xs-2 js-col-md-2 js-ticket-pic">
                                <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketman.png">
                            </div>
                            <div class="js-col-xs-10 js-col-md-6 js-col-xs-10 js-ticket-data js-nullpadding">
                                <div class="js-col-xs-12 js-col-md-12 js-ticket-padding-xs js-ticket-body-data-elipses">
                                    <span class="js-ticket-field-title">Subject&nbsp;:&nbsp;</span>
                                    <a href="#">Test Ticket Title 2</a>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-ticket-padding-xs js-ticket-body-data-elipses">
                                    <span class="js-ticket-field-title">From&nbsp;:&nbsp;</span>
                                    <span class="js-ticket-value">Name 2</span>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-ticket-padding-xs js-ticket-body-data-elipses">
                                    <span class="js-ticket-field-title">Department&nbsp;:&nbsp;</span>
                                    <span class="js-ticket-value">Department 2</span>
                                </div>
                                <span class="js-ticket-status" style="background:#5bb12f;">New</span>
                            </div>
                            <div class="js-col-xs-12 js-col-md-4 js-ticket-data1 js-ticket-padding-left-xs">
                                <div class="js-row">
                                    <div class="js-col-xs-6 js-col-md-6 js-col-xs-6">Ticket ID</div>
                                    <div class="js-col-xs-6 js-col-md-6 js-col-xs-6">q1w2e3r4t5</div>
                                </div>
                                <div class="js-row">
                                    <div class="js-col-xs-6 js-col-md-6 js-col-xs-6">Last Reply</div>
                                    <div class="js-col-xs-6 js-col-md-6 js-col-xs-6">No Last Reply</div>
                                </div>
                                <div class="js-row">
                                    <div class="js-col-xs-6 js-col-md-6 js-col-xs-6">Priority</div>
                                    <div class="js-col-xs-6 js-col-md-6 js-col-xs-6"><span class="js-ticket-wrapper-textcolor" style="background:#86f793;">Low</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="js-col-xs-12 js-col-md-12 js-ticket-wrapper">
                        <div class="js-col-xs-12 js-col-md-12 js-ticket-toparea">
                            <div class="js-col-xs-2 js-col-md-2 js-ticket-pic">
                                <img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/ticketman.png">
                            </div>
                            <div class="js-col-xs-10 js-col-md-6 js-col-xs-10 js-ticket-data js-nullpadding">
                                <div class="js-col-xs-12 js-col-md-12 js-ticket-padding-xs js-ticket-body-data-elipses">
                                    <span class="js-ticket-field-title">Subject&nbsp;:&nbsp;</span>
                                    <a href="#">Test Ticket Title 3</a>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-ticket-padding-xs js-ticket-body-data-elipses">
                                    <span class="js-ticket-field-title">From&nbsp;:&nbsp;</span>
                                    <span class="js-ticket-value">Name 3</span>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-ticket-padding-xs js-ticket-body-data-elipses">
                                    <span class="js-ticket-field-title">Department&nbsp;:&nbsp;</span>
                                    <span class="js-ticket-value">Department 2</span>
                                </div>
                                <span class="js-ticket-status" style="background:blue;">Replied</span>
                            </div>
                            <div class="js-col-xs-12 js-col-md-4 js-ticket-data1 js-ticket-padding-left-xs">
                                <div class="js-row">
                                    <div class="js-col-xs-6 js-col-md-6 js-col-xs-6">Ticket ID</div>
                                    <div class="js-col-xs-6 js-col-md-6 js-col-xs-6">qwert12345</div>
                                </div>
                                <div class="js-row">
                                    <div class="js-col-xs-6 js-col-md-6 js-col-xs-6">Last Reply</div>
                                    <div class="js-col-xs-6 js-col-md-6 js-col-xs-6">No Last Reply</div>
                                </div>
                                <div class="js-row">
                                    <div class="js-col-xs-6 js-col-md-6 js-col-xs-6">Priority</div>
                                    <div class="js-col-xs-6 js-col-md-6 js-col-xs-6"><span class="js-ticket-wrapper-textcolor" style="background:#86f793;">Low</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <script type="text/javascript" >
            jQuery(document).ready(function () {
                makeColorPicker('<?php echo jssupportticket::$_data[0]['color1']; ?>', '<?php echo jssupportticket::$_data[0]['color2']; ?>', '<?php echo jssupportticket::$_data[0]['color3']; ?>', '<?php echo jssupportticket::$_data[0]['color4']; ?>', '<?php echo jssupportticket::$_data[0]['color5']; ?>', '<?php echo jssupportticket::$_data[0]['color6']; ?>', '<?php echo jssupportticket::$_data[0]['color7']; ?>');
            });
            function makeColorPicker(color1, color2, color3, color4, color5, color6, color7) {
                jQuery('input#color1').ColorPicker({
                    color: color1,
                    onShow: function (colpkr) {
                        jQuery(colpkr).fadeIn(500);
                        return false;
                    },
                    onHide: function (colpkr) {
                        jQuery(colpkr).fadeOut(500);
                        return false;
                    },
                    onChange: function (hsb, hex, rgb) {
                        jQuery('input#color1').css('backgroundColor', '#' + hex).val('#' + hex);
                        jQuery('div#jsst-header span.jsst-header-tab.active a.js-cp-menu-link').css('backgroundColor', '#' + hex);
                    }
                });
                jQuery('input#color2').ColorPicker({
                    color: color2,
                    onShow: function (colpkr) {
                        jQuery(colpkr).fadeIn(500);
                        return false;
                    },
                    onHide: function (colpkr) {
                        jQuery(colpkr).fadeOut(500);
                        return false;
                    },
                    onChange: function (hsb, hex, rgb) {
                        jQuery('input#color2').css('backgroundColor', '#' + hex).val('#' + hex);
                        jQuery('div.js-ticket-wrapper').mouseover(function () {
                            jQuery('div.js-ticket-wrapper').css('borderColor', jQuery('input#color2').val());
                            jQuery('div.js-ticket-pic').css('borderColor', jQuery('input#color2').val());
                            jQuery('div.js-ticket-data1').css('borderColor', jQuery('input#color2').val());
                            jQuery('div.js-ticket-bottom-line').css('backgroundColor', jQuery('input#color2').val());
                        }).mouseout(function () {
                            jQuery('div.js-ticket-wrapper').css('borderColor', jQuery('input#color5').val());
                            jQuery('div.js-ticket-pic').css('borderColor', jQuery('input#color5').val());
                            jQuery('div.js-ticket-data1').css('borderColor', jQuery('input#color5').val());
                            jQuery('div.js-ticket-bottom-line').css('backgroundColor', jQuery('input#color5').val());
                        });
                        jQuery('div.js-ticket-sorting span.js-ticket-sorting-link a.selected').css('backgroundColor', jQuery('input#color2').val());
                        jQuery('div#jsst-header').css('backgroundColor', jQuery('input#color2').val());
                        jQuery('div.js-ticket-wrapper div.js-ticket-bottom-line').css('borderColor', jQuery('input#color2').val());
                        jQuery('div.js-ticket-flat a.active').css('borderColor', jQuery('input#color2').val());
                        jQuery('div.js-ticket-sorting span.js-ticket-sorting-link a').mouseover(function () {
                            jQuery('div.js-ticket-sorting span.js-ticket-sorting-link a').css('backgroundColor', jQuery('input#color2').val());
                        }).mouseout(function () {
                            jQuery('div.js-ticket-sorting span.js-ticket-sorting-link a').css('backgroundColor', jQuery('input#color5').val());
                        });
                        jQuery('a.js-ticket-title-anchor').mouseover(function () {
                            jQuery('a.js-ticket-title-anchor').css('color', jQuery('input#color2').val());
                        }).mouseout(function () {
                            jQuery('a.js-ticket-title-anchor').css('color', jQuery('input#color5').val());
                        });
                        jQuery('div.js-ticket-flat a').mouseover(function () {
                            jQuery('div.js-ticket-flat a').css('backgroundColor', jQuery('input#color2').val());
                        }).mouseout(function () {
                            jQuery('div.js-ticket-flat a').css('backgroundColor', jQuery('input#color5').val());
                        });
                    }
                });
                jQuery('input#color3').ColorPicker({
                    color: color3,
                    onShow: function (colpkr) {
                        jQuery(colpkr).fadeIn(500);
                        return false;
                    },
                    onHide: function (colpkr) {
                        jQuery(colpkr).fadeOut(500);
                        return false;
                    },
                    onChange: function (hsb, hex, rgb) {
                        jQuery('input#color3').css('backgroundColor', '#' + hex).val('#' + hex);
                        jQuery('div#jsst-header div#jsst-header-heading').css('color', '#' + hex);
                        jQuery('div.js-ticket-assigned-tome').css('backgroundColor', '#' + hex);
                    }
                });
                jQuery('input#color4').ColorPicker({
                    color: color4,
                    onShow: function (colpkr) {
                        jQuery(colpkr).fadeIn(500);
                        return false;
                    },
                    onHide: function (colpkr) {
                        jQuery(colpkr).fadeOut(500);
                        return false;
                    },
                    onChange: function (hsb, hex, rgb) {
                        jQuery('input#color4').css('backgroundColor', '#' + hex).val('#' + hex);
                        jQuery('div.js-ticket-breadcrumb-wrp .breadcrumb li a').css('color', '#' + hex);
                        jQuery('div.js-ticket-wrapper div.js-ticket-data span.js-ticket-title').css('color', '#' + hex);
                        jQuery('div.js-ticket-wrapper div.js-ticket-data span.js-ticket-value').css('color', '#' + hex);
                    }
                });
                jQuery('input#color5').ColorPicker({
                    color: color5,
                    onShow: function (colpkr) {
                        jQuery(colpkr).fadeIn(500);
                        return false;
                    },
                    onHide: function (colpkr) {
                        jQuery(colpkr).fadeOut(500);
                        return false;
                    },
                    onChange: function (hsb, hex, rgb) {
                        jQuery('input#color5').css('backgroundColor', '#' + hex).val('#' + hex);
                        jQuery('div.js-ticket-wrapper').css('borderColor', '#' + hex);
                        jQuery('div.js-ticket-wrapper div.js-ticket-pic').css('borderColor', '#' + hex);
                        jQuery('div.js-ticket-wrapper div.js-ticket-data1').css('borderColor', '#' + hex);
                        jQuery('div.js-ticket-assigned-tome').css('borderColor', '#' + hex);
                    }
                });
                jQuery('input#color6').ColorPicker({
                    color: color6,
                    onShow: function (colpkr) {
                        jQuery(colpkr).fadeIn(500);
                        return false;
                    },
                    onHide: function (colpkr) {
                        jQuery(colpkr).fadeOut(500);
                        return false;
                    },
                    onChange: function (hsb, hex, rgb) {
                        jQuery('input#color6').css('backgroundColor', '#' + hex).val('#' + hex);
                        jQuery('a.js-myticket-link').css('backgroundColor', '#' + hex);
                    }
                });
                jQuery('input#color7').ColorPicker({
                    color: color7,
                    onShow: function (colpkr) {
                        jQuery(colpkr).fadeIn(500);
                        return false;
                    },
                    onHide: function (colpkr) {
                        jQuery(colpkr).fadeOut(500);
                        return false;
                    },
                    onChange: function (hsb, hex, rgb) {
                        jQuery('input#color7').css('backgroundColor', '#' + hex).val('#' + hex);
                        jQuery("a.js-myticket-link,span.js-ticket-sorting-link a").each(function () {
                            jQuery(this).css('color', '#' + hex)
                        });
                        jQuery('a.js-ticket-header-links').mouseover(function () {
                            jQuery('a.js-ticket-header-links').css('color', jQuery('input#color7').val());
                        }).mouseout(function () {
                            jQuery('a.js-ticket-header-links').css('color', jQuery('input#color7').val());
                        });
                        jQuery('div#jsst-header span.jsst-header-tab a.js-cp-menu-link').mouseover(function () {
                            jQuery('div#jsst-header span.jsst-header-tab a.js-cp-menu-link').css('color', jQuery('input#color7').val());
                        }).mouseout(function () {
                            jQuery('div#jsst-header span.jsst-header-tab a.js-cp-menu-link').css('color', jQuery('input#color7').val());
                        });
                        jQuery('input#color7').css('backgroundColor', '#' + hex).val('#' + hex);
                        jQuery('div#jsst-header span.jsst-header-tab.active a.js-cp-menu-link').css('color', '#' + hex).val('#' + hex);
                        jQuery('div.js-ticket-sorting span.js-ticket-sorting-link a').css('color', '#' + hex).val('#' + hex);
                        jQuery('div#jsst-header div#jsst-header-heading a').css('color', '#' + hex).val('#' + hex);
                    }
                });

            }
        </script>
        <div id="black_wrapper_jobapply" style="display:none;"></div>
        <div id="js_jobapply_main_wrapper" style="display:none;padding:0px 5px;">
            <div id="js_job_wrapper">
                <span class="js_job_controlpanelheading"><?php echo __('Preset Theme', 'js-support-ticket'); ?></span>
                <div class="js_theme_wrapper">
                    <div class="theme_platte">
                        <div class="color_wrapper">
                            <div class="color 1" style="background:#343538;"></div>
                            <div class="color 2" style="background:#428BCA;"></div>
                            <div class="color 3" style="background:#FDFDFD;"></div>
                            <div class="color 4" style="background:#373435;"></div>
                            <div class="color 5" style="background:#B8B8B8;"></div>
                            <div class="color 6" style="background:#E7E7E7;"></div>
                            <div class="color 7" style="background:#FFFFFF;"></div>
                            <span class="theme_name"><?php echo __('Blue', 'js-support-ticket'); ?></span>
                            <img class="preview" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/themes/preview1.png" />
                            <a href="#" class="preview"></a>
                            <a href="#" class="set_theme"></a>
                        </div>
                    </div>
                    <div class="theme_platte">
                        <div class="color_wrapper">
                            <div class="color 1" style="background:#343538;"></div>
                            <div class="color 2" style="background:#E43039;"></div>
                            <div class="color 3" style="background:#FFFFFF;"></div>
                            <div class="color 4" style="background:#373435;"></div>
                            <div class="color 5" style="background:#B8B8B8;"></div>
                            <div class="color 6" style="background:#E7E7E7;"></div>
                            <div class="color 7" style="background:#FFFFFF;"></div>
                            <span class="theme_name"><?php echo __('Red', 'js-support-ticket'); ?></span>
                            <img class="preview" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/themes/preview2.png" />
                            <a href="#" class="preview"></a>
                            <a href="#" class="set_theme"></a>
                        </div>
                    </div>
                    <div class="theme_platte">
                        <div class="color_wrapper">
                            <div class="color 1" style="background:#343538;"></div>
                            <div class="color 2" style="background:#00A88C;"></div>
                            <div class="color 3" style="background:#FDFDFD;"></div>
                            <div class="color 4" style="background:#373435;"></div>
                            <div class="color 5" style="background:#B8B8B8;"></div>
                            <div class="color 6" style="background:#E7E7E7;"></div>
                            <div class="color 7" style="background:#FFFFFF;"></div>
                            <span class="theme_name"><?php echo __('Greenish', 'js-support-ticket'); ?></span>
                            <img class="preview" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/themes/preview3.png" />
                            <a href="#" class="preview"></a>
                            <a href="#" class="set_theme"></a>
                        </div>
                    </div>
                    <div class="theme_platte">
                        <div class="color_wrapper">
                            <div class="color 1" style="background:#8F5600;"></div>
                            <div class="color 2" style="background:#91764E;"></div>
                            <div class="color 3" style="background:#FDFDFD;"></div>
                            <div class="color 4" style="background:#373435;"></div>
                            <div class="color 5" style="background:#ABA25F;"></div>hrther
                            <div class="color 6" style="background:#E7E7E7;"></div>
                            <div class="color 7" style="background:#FFFFFF;"></div>
                            <span class="theme_name"><?php echo __('Brown', 'js-support-ticket'); ?></span>
                            <img class="preview" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/themes/preview4.png" />
                            <a href="#" class="preview"></a>
                            <a href="#" class="set_theme"></a>
                        </div>
                    </div>
                    <div class="theme_platte">
                        <div class="color_wrapper">
                            <div class="color 1" style="background:#E8E8E8;"></div>
                            <div class="color 2" style="background:#FFB613;"></div>
                            <div class="color 3" style="background:#FDFDFD;"></div>
                            <div class="color 4" style="background:#373435;"></div>
                            <div class="color 5" style="background:#B8B8B8;"></div>
                            <div class="color 6" style="background:#E7E7E7;"></div>
                            <div class="color 7" style="background:#FFFFFF;"></div>
                            <span class="theme_name"><?php echo __('Orange', 'js-support-ticket'); ?></span>
                            <img class="preview" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/themes/preview5.png" />
                            <a href="#" class="preview"></a>
                            <a href="#" class="set_theme"></a>
                        </div>
                    </div>
                    <div class="theme_platte">
                        <div class="color_wrapper">
                            <div class="color 1" style="background:#343538;"></div>
                            <div class="color 2" style="background:#9ACC00;"></div>
                            <div class="color 3" style="background:#FDFDFD;"></div>
                            <div class="color 4" style="background:#373435;"></div>
                            <div class="color 5" style="background:#B8B8B8;"></div>
                            <div class="color 6" style="background:#E7E7E7;"></div>
                            <div class="color 7" style="background:#FFFFFF;"></div>
                            <span class="theme_name"><?php echo __('Green', 'js-support-ticket'); ?></span>
                            <img class="preview" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/themes/preview6.png" />
                            <a href="#" class="preview"></a>
                            <a href="#" class="set_theme"></a>
                        </div>
                    </div>
                    <div class="theme_platte">
                        <div class="color_wrapper">
                            <div class="color 1" style="background:#373435;"></div>
                            <div class="color 2" style="background:#414141;"></div>
                            <div class="color 3" style="background:#FDFDFD;"></div>
                            <div class="color 4" style="background:#373435;"></div>
                            <div class="color 5" style="background:#B8B8B8;"></div>
                            <div class="color 6" style="background:#E7E7E7;"></div>
                            <div class="color 7" style="background:#FFFFFF;"></div>
                            <span class="theme_name"><?php echo __('Black', 'js-support-ticket'); ?></span>
                            <img class="preview" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/themes/preview7.png" />
                            <a href="#" class="preview"></a>
                            <a href="#" class="set_theme"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            jQuery(document).ready(function () {
                jQuery('a#preset_theme').click(function (e) {
                    e.preventDefault();
                    jQuery("div#js_jobapply_main_wrapper").fadeIn();
                    jQuery("div#black_wrapper_jobapply").fadeIn();
                });
                jQuery("div#black_wrapper_jobapply").click(function () {
                    jQuery("div#js_jobapply_main_wrapper").fadeOut();
                    jQuery("div#black_wrapper_jobapply").fadeOut();
                });
                jQuery('a.preview').each(function (index, element) {
                    jQuery(this).hover(function () {
                        if (index > 2)
                            jQuery(this).parent().find('img.preview').css('top', "-110px");
                        jQuery(jQuery(this).parent().find('img.preview')).show();
                    }, function () {
                        jQuery(jQuery(this).parent().find('img.preview')).hide();
                    });
                });
                jQuery('a.set_theme').each(function (index, element) {
                    jQuery(this).click(function (e) {
                        e.preventDefault();
                        var div = jQuery(this).parent();
                        var color1 = rgb2hex(jQuery(div.find('div.1')).css('backgroundColor'));
                        var color2 = rgb2hex(jQuery(div.find('div.2')).css('backgroundColor'));
                        var color3 = rgb2hex(jQuery(div.find('div.3')).css('backgroundColor'));
                        var color4 = rgb2hex(jQuery(div.find('div.4')).css('backgroundColor'));
                        var color5 = rgb2hex(jQuery(div.find('div.5')).css('backgroundColor'));
                        var color6 = rgb2hex(jQuery(div.find('div.6')).css('backgroundColor'));
                        var color7 = rgb2hex(jQuery(div.find('div.7')).css('backgroundColor'));
                        jQuery('input#color1').val(color1).css('backgroundColor', color1).ColorPickerSetColor(color1);
                        jQuery('input#color2').val(color2).css('backgroundColor', color2).ColorPickerSetColor(color2);
                        jQuery('input#color3').val(color3).css('backgroundColor', color3).ColorPickerSetColor(color3);
                        jQuery('input#color4').val(color4).css('backgroundColor', color4).ColorPickerSetColor(color4);
                        jQuery('input#color5').val(color5).css('backgroundColor', color5).ColorPickerSetColor(color5);
                        jQuery('input#color6').val(color6).css('backgroundColor', color6).ColorPickerSetColor(color6);
                        jQuery('input#color7').val(color7).css('backgroundColor', color7).ColorPickerSetColor(color7);
                        themeSelectionEffect();
                        jQuery("div#js_jobapply_main_wrapper").fadeOut();
                        jQuery("div#black_wrapper_jobapply").fadeOut();
                    });
                });
            });
            function rgb2hex(rgb) {
                rgb = rgb.match(/^rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*(\d+))?\)$/);
                function hex(x) {
                    return ("0" + parseInt(x).toString(16)).slice(-2);
                }
                return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
            }
            function themeSelectionEffect() {
                jQuery('div.js-ticket-wrapper').mouseover(function () {
                    jQuery('div.js-ticket-wrapper').css('borderColor', jQuery('input#color2').val());
                    jQuery('div.js-ticket-pic-themepage').css('borderColor', jQuery('input#color2').val());
                    jQuery('div.js-ticket-data1').css('borderColor', jQuery('input#color2').val());
                }).mouseout(function () {
                    jQuery('div.js-ticket-wrapper').css('borderColor', jQuery('input#color5').val());
                    jQuery('div.js-ticket-pic-themepage').css('borderColor', jQuery('input#color5').val());
                    jQuery('div.js-ticket-data1').css('borderColor', jQuery('input#color5').val());
                });
                jQuery("div.js-ticket-sorting span.js-ticket-sorting-link a").mouseover(function () {
                    jQuery(this).css('backgroundColor', jQuery('input#color2').val());
                });
                jQuery("div.js-ticket-sorting span.js-ticket-sorting-link a").mouseout(function () {
                    jQuery(this).css('backgroundColor', jQuery('input#color1').val());
                });
                jQuery("a.js-myticket-link").mouseover(function () {
                    jQuery(this).css('backgroundColor', jQuery('input#color2').val());
                });
                jQuery("a.js-myticket-link").mouseout(function () {
                    jQuery(this).css('backgroundColor', jQuery('input#color6').val());
                });
                jQuery('div#jsst-header').css('borderColor', jQuery("input#color2").val());
                jQuery('span.jsst-header-tab.active').find("a").css('backgroundColor', jQuery("input#color2").val());
                jQuery('h1.js-ticket-heading').css('color', jQuery("input#color2").val());


                jQuery('div#jsst-header').css('backgroundColor', jQuery('input#color1').val());
                jQuery('span.jsst-header-tab a').mouseover(function () {
                    jQuery(this).css('color', jQuery('input#color2').val());
                });
                jQuery('span.jsst-header-tab a').mouseout(function () {
                    jQuery(this).css('color', jQuery('input#color7').val());
                });
                jQuery('span.jsst-header-tab.active a').css('color', jQuery('input#color3').val());
                jQuery('div#jsst-header-2').css('backgroundColor', jQuery('input#color2').val());
                jQuery('span.jsst-header-2-tab a').mouseover(function () {
                    jQuery(this).css({'backgroundColor': jQuery('input#color3').val(), 'color': jQuery('input#color2').val()});
                }).mouseout(function () {
                    jQuery(this).css({'backgroundColor': jQuery('input#color2').val(), 'color': jQuery('input#color7').val()});
                });
                jQuery('span.jsst-header-2-tab.active a').css({'backgroundColor': jQuery('input#color3').val(), 'color': jQuery('input#color2').val()});
                jQuery('div.js-ticket-sorting span.js-ticket-sorting-link a').css('backgroundColor', jQuery('input#color1').val());
                jQuery('div.js-ticket-wrapper').mouseover(function () {
                    jQuery('div.js-ticket-wrapper').css('borderColor', jQuery('input#color2').val());
                    jQuery('div.js-ticket-pic-themepage').css('borderColor', jQuery('input#color2').val());
                    jQuery('div.js-ticket-data1').css('borderColor', jQuery('input#color2').val());
                }).mouseout(function () {
                    jQuery('div.js-ticket-wrapper').css('borderColor', jQuery('input#color5').val());
                    jQuery('div.js-ticket-pic-themepage').css('borderColor', jQuery('input#color5').val());
                    jQuery('div.js-ticket-data1').css('borderColor', jQuery('input#color5').val());
                });
                jQuery("div.js-ticket-sorting span.js-ticket-sorting-link a").mouseover(function () {
                    jQuery(this).css('backgroundColor', jQuery('input#color2').val());
                });
                jQuery("div.js-ticket-sorting span.js-ticket-sorting-link a").mouseout(function () {
                    jQuery(this).css('backgroundColor', jQuery('input#color1').val());
                });
                jQuery("a.js-myticket-link").mouseover(function () {
                    jQuery(this).css('backgroundColor', jQuery('input#color2').val());
                });
                jQuery("a.js-myticket-link").mouseout(function () {
                    jQuery(this).css('backgroundColor', jQuery('input#color6').val());
                });
                jQuery('h1.js-ticket-heading').css('borderColor', jQuery('input#color2').val());
                jQuery('h1.js-ticket-heading').css('color', jQuery('input#color2').val());
                jQuery('div.js-ticket-wrapper').css('backgroundColor', jQuery('input#color3').val());
                jQuery('span.js-ticket-title').css('color', jQuery('input#color4').val());
                jQuery('span.js-ticket-value').css('color', jQuery('input#color4').val());
                jQuery('div.js-ticket-data1').css('color', jQuery('input#color4').val());
                jQuery('a.js-myticket-link').css('borderColor', jQuery('input#color5').val());
                jQuery('div.js-ticket-wrapper').css('borderColor', jQuery('input#color5').val());
                jQuery('a.js-myticket-link').css('backgroundColor', jQuery('input#color6').val());
                jQuery("span.js-ticket-sorting-link a").each(function () {
                    jQuery(this).css('color', jQuery('input#color7').val())
                });
            }
        </script>
    </div>
</div>

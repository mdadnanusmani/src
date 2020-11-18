<?php
if (!defined('ABSPATH'))
    die('Restricted Access');
$color1 = "#343538";
$color2 = "#428bca";
$color3 = "#fdfdfd";
$color4 = "#373435";
$color5 = "#b8b8b8";
$color6 = "#e7e7e7";
$color7 = "#ffffff";
$color8 = "#2DA1CB";
$color9 = "#000000";

$array = array('color1' => $color1, 'color2' => $color2, 'color3' => $color3, 'color4' => $color4, 'color5' => $color5, 'color6' => $color6, 'color7' => $color7, 'color8' => $color8, 'color9' => $color9 );
$array = apply_filters( 'cm_theme_colors', $array, 'js-support-ticket' );
$color2 = $array['color2'];
$color1 = $array['color1'];
$color3 = $array['color3'];
$color4 = $array['color4'];
$color5 = $array['color5'];
$color6 = $array['color6'];
$color7 = $array['color7'];
$color8 = $array['color8'];
$color9 = $array['color9'];

jssupportticket::$_colors['color1']=$color1;
jssupportticket::$_colors['color2']=$color2;
jssupportticket::$_colors['color3']=$color3;
jssupportticket::$_colors['color4']=$color4;
jssupportticket::$_colors['color5']=$color5;
jssupportticket::$_colors['color6']=$color6;
jssupportticket::$_colors['color7']=$color7;
jssupportticket::$_colors['color8']=$color8;
jssupportticket::$_colors['color9']=$color9;

$result = "

/*BreadCrumbs*/
.button--inline:after, .button--inline:before, .wysiwyg a:after, .wysiwyg a:before {
    background-color: transparent;}
div.js-ticket-breadcrumb-wrp{
    display:none;
}
	div.js-ticket-flat a:hover, div.js-ticket-flat a.active, div.js-ticket-flat a:hover::after, div.js-ticket-flat a.active::after{background-color:$color2;}
	div.js-ticket-breadcrumb-wrp .breadcrumb li:first-child a{background-color:$color2;}
	div.js-ticket-breadcrumb-wrp .breadcrumb li:first-child a:hover::after{background-color:transparent !important;}
	div.js-ticket-breadcrumb-wrp .breadcrumb li:first-child a::after {border-left-color:$color2;}
	div.js-ticket-breadcrumb-wrp .breadcrumb li a::after{border-left-color:#c9c9c9;}
	div.js-ticket-breadcrumb-wrp .breadcrumb li a{color:$color4;}
	div.js-ticket-breadcrumb-wrp .breadcrumb li a:hover{color:$color2;}
/*BreadCrumbs*/

/*Top Header*/
	div#jsst-header{background-color:$color2;}
	a.js-ticket-header-links{color:$color7;}
	a.js-ticket-header-links:hover{color: $color7;;}
	div#jsst-header div#jsst-header-heading{color:$color3;}
	div#jsst-header span.jsst-header-tab a.js-cp-menu-link{background:rgba(0,0,0,0.4);color:$color7;}
	div#jsst-header span.jsst-header-tab a.js-cp-menu-link:hover{background:rgba(0,0,0,0.6);color:$color7;}
	div#jsst-header span.jsst-header-tab.active a.js-cp-menu-link{background:$color1;color:$color7;}
	div#jsst_breadcrumbs_parent div.home a{background:$color2;}
/*Top Header*/
/* Error Message Page */
	span.js-ticket-user-login-btn-wrp a.js-ticket-login-btn{background-color:$color2;color:$color7;}
	span.js-ticket-user-login-btn-wrp a.js-ticket-register-btn{background-color:#48484a;color:$color7;}
	div.jsst_errors span.error{color:#871414;border:1px solid #871414;background-color: #ffd2d3;}
/* Error Message Page */
/* Feedbacks */
	div.js-ticket-feedback-heading{border: 1px solid $color5;background-color: #e7ecf2;color: $color4;}
	div.jsst-feedback-det-wrp  div.jsst-feedback-det-list {border:1px solid $color5;}
	div.jsst-feedback-det-wrp  div.jsst-feedback-det-list div.jsst-feedback-det-list-top {border-bottom: 1px solid $color5;}
	div.jsst-feedback-det-wrp  div.jsst-feedback-det-list div.jsst-feedback-det-list-top div.jsst-feedback-det-list-data-wrp div.jsst-feedback-det-list-data-top {border-bottom: 1px solid $color5;}
	div.jsst-feedback-det-wrp  div.jsst-feedback-det-list div.jsst-feedback-det-list-top div.jsst-feedback-det-list-data-wrp div.jsst-feedback-det-list-data-top div.jsst-feedback-det-list-data-top-title {color: $color4;}
	div.jsst-feedback-det-wrp  div.jsst-feedback-det-list div.jsst-feedback-det-list-top div.jsst-feedback-det-list-data-wrp div.jsst-feedback-det-list-data-top div.jsst-feedback-det-list-data-top-val {color: $color4;}
	div.jsst-feedback-det-wrp  div.jsst-feedback-det-list div.jsst-feedback-det-list-top div.jsst-feedback-det-list-data-wrp div.jsst-feedback-det-list-data-top div.jsst-feedback-det-list-data-top-val a.jsst-feedback-det-list-data-top-val-txt {color: $color2;}
	div.jsst-feedback-det-wrp  div.jsst-feedback-det-list div.jsst-feedback-det-list-top div.jsst-feedback-det-list-data-wrp div.jsst-feedback-det-list-data-btm div.jsst-feedback-det-list-datea-btm-rec div.jsst-feedback-det-list-data-btm-title{color: $color4;}
	div.jsst-feedback-det-wrp  div.jsst-feedback-det-list div.jsst-feedback-det-list-top div.jsst-feedback-det-list-data-wrp div.jsst-feedback-det-list-data-btm div.jsst-feedback-det-list-datea-btm-rec div.jsst-feedback-det-list-data-btm-val{color: $color4;}
	div.jsst-feedback-det-wrp  div.jsst-feedback-det-list div.jsst-feedback-det-list-btm div.jsst-feedback-det-list-btm-title{color:$color4;}
	div.jsst-feedback-det-wrp  div.jsst-feedback-det-list div.jsst-feedback-det-list-img-wrp{border:1px solid $color5;}
/* Feedbacks */
/* Existing colors */
	div.js-ticket-body-data-elipses a{color:$color2;text-decoration:none;}
	div.js-ticket-detail-wrapper div.js-ticket-openclosed{background:$color6;color:$color4;border-right:1px solid $color5;}
	div#records div.jsst_userpages a.jsst_userlink:hover{background: $color2;color:$color7;}
	span.jsst_userlink.selected{background: $color2;color: $color7;}
	/* Pagination */
	div.tablenav div.tablenav-pages{border:1px solid #f1f1fc;width:100%;}
	div.tablenav div.tablenav-pages span.page-numbers.current{background: $color2;color: $color7;padding:11px 20px;}
	div.tablenav div.tablenav-pages a.page-numbers:hover{background:$color2;color:$color7;border:1px solid $color2;}
	div.tablenav div.tablenav-pages a.page-numbers{background: #ffffff; /* Old browsers */background: -moz-linear-gradient(top,  #ffffff 0%, #f2f2f2 100%); /* FF3.6+ */background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffff), color-stop(100%,#f2f2f2)); /* Chrome,Safari4+ */background: -webkit-linear-gradient(top,  #ffffff 0%,#f2f2f2 100%); /* Chrome10+,Safari5.1+ */background: -o-linear-gradient(top,  #ffffff 0%,#f2f2f2 100%); /* Opera 11.10+ */background: -ms-linear-gradient(top,  #ffffff 0%,#f2f2f2 100%); /* IE10+ */background: linear-gradient(to bottom,  #ffffff 0%,#f2f2f2 100%); /* W3C */filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#f2f2f2',GradientType=0 ); /* IE6-9 */color: $color4;border:1px solid $color5;}
	/* Pagination */
/* Existing colors */
	/******** Widgets ***********/
	div#jsst-widget-myticket-wrapper{background: $color3;border:1px solid $color5;}
	div#jsst-widget-myticket-wrapper div.jsst-widget-myticket-topbar{border-bottom: 1px solid $color5;}
	div#jsst-widget-myticket-wrapper div.jsst-widget-myticket-topbar span.jsst-widget-myticket-subject a{color:$color2;}
	div#jsst-widget-myticket-wrapper div.jsst-widget-myticket-topbar span.jsst-widget-myticket-status{color:#FFFFFF;}
	div#jsst-widget-myticket-wrapper div.jsst-widget-myticket-bottombar span.jsst-widget-myticket-priority{color: #FFFFFF;}
	div#jsst-widget-myticket-wrapper div.jsst-widget-myticket-bottombar span.jsst-widget-myticket-from span.widget-from{color:$color4;}
	div#jsst-widget-myticket-wrapper div.jsst-widget-myticket-bottombar span.jsst-widget-myticket-from span.widget-fromname{color:$color4;}
	div#jsst-widget-mailnotification-wrapper{background:$color3;border:1px solid $color5;}
	div#jsst-widget-mailnotification-wrapper img{}
	div#jsst-widget-mailnotification-wrapper span.jsst-widget-mailnotification-upper{color:$color4;}
	div#jsst-widget-mailnotification-wrapper span.jsst-widget-mailnotification-upper span.jsst-widget-mailnotification-created{color:$color4;}
	div#jsst-widget-mailnotification-wrapper span.jsst-widget-mailnotification-upper span.jsst-widget-mailnotification-new{color:#0752AD;}
	div#jsst-widget-mailnotification-wrapper span.jsst-widget-mailnotification-upper span.jsst-widget-mailnotification-replied{color:#ED6B6D;}
	div.jsst-visitor-message-wrapper{border:1px solid $color5;}
	div.jsst-visitor-message-wrapper img{border-right:1px solid $color5}
	div.feedback-sucess-message{border:1px solid $color5;}
	div.feedback-sucess-message span.feedback-message-text{border-top:1px solid $color5;}
	div.js-ticket-thread-wrapper div.js-ticket-thread-upperpart a.ticket-edit-reply-button{border:1px solid $color2;background:$color3;color:$color2;}
	div.js-ticket-thread-wrapper div.js-ticket-thread-upperpart a.ticket-edit-time-button{border:1px solid $color5;background:$color3;color:$color4;}
	span.js-ticket-value.js-ticket-creade-via-email-spn{border:1px solid $color5;background:$color3;color:$color4;}

	/*Custom Fields*/
	input.custom_date{background-color:$color3;border: 1px solid $color5;}
	select.js-ticket-custom-select{background-color:$color3;border: 1px solid $color5;}
	div.js-ticket-custom-radio-box{background-color:$color3;border: 1px solid $color5;}
	div.js-ticket-radio-box{border: 1px solid $color5;background-color:$color3;}
	 .js-ticket-custom-textarea{border: 1px solid $color5;background-color:$color3;}
	 span.js-attachment-file-box{border: 1px solid $color5;background-color:$color3;}

	div.js-ticket-table-body div.js-ticket-data-row{border:1px solid  $color5;border-top:none}
  	div.js-ticket-table-body div.js-ticket-data-row div.js-ticket-table-body-col{border-right:1px solid $color5;}
	div.js-ticket-table-header{background-color:#ecf0f5;border:1px solid  $color5;}
  	div.js-ticket-table-header div.js-ticket-table-header-col{border-right:1px solid $color5;}
  	div.js-ticket-table-header div.js-ticket-table-header-col:last-child{border-right:none;}
  	div.js-ticket-downloads-wrp div.js-ticket-downloads-heading-wrp{background-color:#ecf0f5;border:1px solid $color5;}

  	/* JS Support Ticket Woocommerce */
  	.js-ticket-wc-order-box .js-ticket-wc-order-item .js-ticket-wc-order-item-title{
        color: ".$color1.";
    }
    .js-ticket-wc-order-box .js-ticket-wc-order-link{
        background-color: ".$color2.";
        color: ".$color7.";
    }
    div.js-ticket-add-form-wrapper div.js-ticket-from-field-wrp div.js-ticket-from-field .js-ticket-custom-terms-and-condition-box{border: 1px solid $color5;background:$color3;}


    div.jsst-main-up-wrapper a.js-ticket-delete-attachment {color:#fff;text-decoration:none}

";
if ( is_rtl() ) {
    $result .= "div.js-ticket-wrapper:hover div.js-ticket-pic{border-right:0px;border-left:1px solid $color2;}"
            . "div.js-ticket-wrapper:hover div.js-ticket-data1{border-left:0px;border-right:1px solid $color2;}"
            . "div.js-ticket-wrapper div.js-ticket-pic{border:0px;border-left:1px solid $color5;float:right;}"
            . "div.js-ticket-wrapper div.js-ticket-data1{border-left:0px;border-right:1px solid $color5;}"
            . "div.js-ticket-detail-wrapper div.js-ticket-topbar div.js-openclosed{float:right;border:0px;border-left: 1px solid $color5;}"
            . "div.js-ticket-detail-wrapper div.js-ticket-openclosed{border-right:0px;border-left:1px solid $color5;}"
            . "div.js-ticket-detail-wrapper div.js-ticket-topbar div.js-last-left{border-left:0px;border-right: 1px solid $color5;}"
            . "div.js-filter-form-head div{border-right:0px; border-left: 1px solid $color3;}
               div.js-filter-form-data div{border-right:0px; border-left: 1px solid $color5;}"
            . "	div.js-ticket-body-row-button{border-left:0px;border-right: 1px solid $color5;}"
            . "	div.jsst-visitor-message-wrapper img{border-right:none;border-left:1px solid $color5}

            /*My Ticket*/
            div.js-ticket-detail-box div.js-ticket-detail-right{border-right: 1px solid $color5;border-left:unset;}
            /*My Ticket*/

            /*Roles*/
            div.js-ticket-table-header div.js-ticket-table-header-col{border-left: 1px solid $color5;border-right:unset;}
            div.js-ticket-table-body div.js-ticket-data-row div.js-ticket-table-body-col{border-left: 1px solid $color5;border-right:unset;}
            /*Roles*/

            /*BreadCrumbs*/
            	div.js-ticket-breadcrumb-wrp .breadcrumb li a::after{border-right-color: #c9c9c9 !important;border-left-color: unset;}
				div.js-ticket-breadcrumb-wrp .breadcrumb li:first-child a::after{border-right-color:$color2 !important;border-left-color: unset;}
            ";

}
$location = 'left';
                $borderradius = '0px 8px 8px 0px';
                $padding = '5px 10px 5px 20px';
                switch (jssupportticket::$_config['screentag_position']) {
                    case 1: // Top left
                        $top = "30px";
                        $left = "0px";
                        $right = "auto";
                        $bottom = "auto";
                    break;
                    case 2: // Top right
                        $top = "30px";
                        $left = "auto";
                        $right = "0px";
                        $bottom = "auto";
                        $location = 'right';
                        $borderradius = '8px 0px 0px 8px';
                        $padding = '5px 20px 5px 10px';
                    break;
                    case 3: // middle left
                        $top = "48%";
                        $left = "0px";
                        $right = "auto";
                        $bottom = "auto";
                    break;
                    case 4: // middle right
                        $top = "48%";
                        $left = "auto";
                        $right = "0px";
                        $bottom = "auto";
                        $location = 'right';
                        $borderradius = '8px 0px 0px 8px';
                        $padding = '5px 20px 5px 10px';
                    break;
                    case 5: // bottom left
                        $top = "auto";
                        $left = "0px";
                        $right = "auto";
                        $bottom = "30px";
                    break;
                    case 6: // bottom right
                        $top = "auto";
                        $left = "auto";
                        $right = "0px";
                        $bottom = "30px";
                        $location = 'right';
                        $borderradius = '8px 0px 0px 8px';
                        $padding = '5px 20px 5px 10px';
                    break;
                }
                $result .= '
                            div#js-ticket_screentag{display:none;opacity:0;position:fixed;top:'.$top.';left:'.$left.';right:'.$right.';bottom:'.$bottom.';padding:'.$padding.';background:rgba(18, 17, 17, 0.5);z-index:9999;border-radius:'.$borderradius.';}
                            div#js-ticket_screentag img.js-ticket_screentag_image{margin-'.$location.':10px;display:inline-block;}
                            div#js-ticket_screentag a.js-ticket_screentag_anchor{color:#ffffff;text-decoration:none;}
                            div#js-ticket_screentag span.text{display:inline-block;font-family:sans-serif;font-size:15px;}
                        ';


//wp_add_inline_style('jsticket-style', $result);
wp_add_inline_style('jssupportticket-main-css', $result);
?>

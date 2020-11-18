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

$jssupportticket_css = '';

/*Code for Css*/
$jssupportticket_css .= '
/* Top Circle Count Boxes */
	div.js-ticket-top-cirlce-count-wrp{float: left;width: 100%;margin:20px 0px 0px 0px;}
	div.js-myticket-link{text-align:center;padding-bottom:20px;padding-left:5px;padding-right:5px; width: calc(100% / 5);}
	div.js-ticket-myticket-link-myticket{width: calc(100% / 4);}
	div.js-myticket-link a.js-myticket-link{display: inline-block;padding:15px 0px; text-decoration: none;min-width: 100%;}
	.js-mr-rp{margin: auto;}
	div.js-ticket-cricle-wrp{float: left;width: 100%;margin-bottom: 10px;}

/* Search Ticket Form*/
	div.js-ticket-search-wrp{float: left;width: 100%;margin-bottom: 17px;}
	div.js-ticket-search-wrp div.js-ticket-search-heading{float: left;width: 100%;padding: 15px;}
	div.js-ticket-search-wrp div.js-ticket-form-wrp{float: left;width: 100%;}
	div.js-ticket-search-wrp div.js-ticket-form-wrp form.js-filter-form{display: inline-block;width: 100%;float: left;}
	div.js-ticket-search-wrp div.js-ticket-form-wrp form.js-filter-form div.js-filter-wrapper{float: left;width: 100%;padding: 15px; }
	div.js-ticket-search-wrp div.js-ticket-form-wrp form.js-filter-form div.js-filter-wrapper div.js-filter-form-fields-wrp{width:94%;float: left;}
	div.js-ticket-search-wrp div.js-ticket-form-wrp form.js-filter-form div#js-filter-wrapper-toggle-area div.js-filter-field-wrp{float: left;width: calc(100% / 2);margin-bottom: 10px;}
	div.js-ticket-search-wrp div.js-ticket-form-wrp form.js-filter-form div#js-filter-wrapper-toggle-area div.js-filter-field-wrp input.js-ticket-input-field{border-radius: unset;width:100%;}
	div.js-ticket-search-wrp div.js-ticket-form-wrp form.js-filter-form div#js-filter-wrapper-toggle-area div.js-filter-field-wrp input.inputbox{border-radius: unset;width:100%;}
	div.js-ticket-search-wrp div.js-ticket-form-wrp form.js-filter-form div#js-filter-wrapper-toggle-area div.js-filter-field-wrp input#jsst-datestart{background-image: url('.jssupportticket::$_pluginpath.'includes/images/ticketdetailicon/calender.png);background-repeat: no-repeat;background-position: 97% 14px;}
	div.js-ticket-search-wrp div.js-ticket-form-wrp form.js-filter-form div#js-filter-wrapper-toggle-area div.js-filter-field-wrp input#jsst-dateend{background-image: url('.jssupportticket::$_pluginpath.'includes/images/ticketdetailicon/calender.png);background-repeat: no-repeat;background-position: 97% 14px;}
	div.js-ticket-search-wrp div.js-ticket-form-wrp form.js-filter-form div#js-filter-wrapper-toggle-area div.js-filter-field-wrp select#jsst-departmentid{width: 100%;border-radius: unset;background: url('.jssupportticket::$_pluginpath.'includes/images/selecticon.png) 96% / 4% no-repeat;}
	div.js-ticket-search-wrp div.js-ticket-form-wrp form.js-filter-form div#js-filter-wrapper-toggle-area div.js-filter-field-wrp select#jsst-priorityid{width: 100%;border-radius: unset;background: url('.jssupportticket::$_pluginpath.'includes/images/selecticon.png) 96% / 4% no-repeat ;}
	div.js-ticket-search-wrp div.js-ticket-form-wrp form.js-filter-form div#js-filter-wrapper-toggle-area div.js-filter-field-wrp select#staffid{width: 100%;border-radius: unset;background: url('.jssupportticket::$_pluginpath.'includes/images/selecticon.png) 96% / 4% no-repeat ;}
	div.js-ticket-search-wrp div.js-ticket-form-wrp form.js-filter-form div.js-filter-wrapper div.js-filter-form-fields-wrp input{width:100%;border-radius: unset;padding: 15px 10px;}
	div.js-ticket-search-wrp div.js-ticket-form-wrp form.js-filter-form div.js-filter-wrapper div.js-filter-form-fields-wrp input#assignedtome1 {width: auto;}
	div.js-ticket-search-wrp div.js-ticket-form-wrp form.js-filter-form div.js-filter-wrapper div.js-filter-form-fields-wrp label {display: inline-block;}
	div.js-ticket-search-wrp div.js-ticket-form-wrp form.js-filter-form div.js-filter-wrapper div.js-filter-title {width:100%;}
	div.js-ticket-search-wrp div.js-ticket-form-wrp form.js-filter-form div.js-filter-wrapper div.js-filter-button{padding-top: 10px; padding-bottom: 10px; display: inline-block; width: 100%; text-align: center;}
	div.js-ticket-search-wrp div.js-ticket-form-wrp form.js-filter-form div.js-filter-wrapper div.js-filter-button input[class="button"]{min-width: 90px;}
	div.js-ticket-search-wrp div.js-ticket-form-wrp form.js-filter-form div.js-filter-wrapper div.js-filter-value select{width:100%;}
	div.js-ticket-search-wrp div.js-ticket-form-wrp form.js-filter-form div.js-filter-button-wrp{float: left;width:100%;margin-top: 20px}
	div.js-ticket-search-wrp div.js-ticket-form-wrp form.js-filter-form div.js-filter-button-wrp input.js-ticket-search-btn{min-width: 120px; float: left; border-radius: unset; margin-left: 10px; padding: 21px 0px;}
	div.js-ticket-search-wrp div.js-ticket-form-wrp form.js-filter-form div.js-filter-button-wrp input.js-ticket-reset-btn{min-width: 120px; float: left; border-radius: unset; margin-left: 10px; padding: 21px 0px;}
	div.js-filter-wrapper-toggle-ticketid input.js-ticket-input-field{border-radius: unset;}
	div#js-filter-wrapper-toggle-area div.js-filter-wrapper div.js-filter-value input.js-ticket-input-field{border-radius: unset;}
	div#js-filter-wrapper-toggle-area{float: left;width: 100%;padding: 20px 0px 0px;}
	div#js-filter-wrapper-toggle-btn{float: left;width: calc(100% - 94% - 5px);margin-left: 5px;}
	div#js-filter-wrapper-toggle-plus{float: left;width: 100%;cursor: pointer;padding: 16px 15px;text-align: center;}
	div#js-filter-wrapper-toggle-minus{float: left;width: 100%;cursor: pointer;padding: 16px 15px;text-align: center;}
	div.js-filter-wrapper-toggle-ticketid{display: none;}
	div#js-filter-wrapper-toggle-minus{display: none;}
	div#js-filter-wrapper-toggle-area{display: none;}
	span.js-filter-form-data-xs{display: none;}
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
	div.js-ticket-sorting span.js-ticket-sorting-link a{text-decoration: none;display: block;padding: 15px; text-align:center;}
	div.js-ticket-sorting span.js-ticket-sorting-link a img{display: inline-block;vertical-align: text-top;}

	select ::-ms-expand {display:none !important;}
	select{-webkit-appearance:none !important;}


';
/*Code For Colors*/
$jssupportticket_css .= '

/* My Tickets */
	/* Top Circle Count Box*/
		div.js-myticket-link a.js-myticket-link{background-color:'.$color3.';border:1px solid'.$color5.';}
		div.js-myticket-link a.js-myticket-link:hover{background: rgba(227, 231, 234, 0.7);}
		.js-ticket-answer{background-color:#D79922;}
		.js-ticket-close{background-color:#e82d3e;}
		.js-ticket-allticket{background-color:#5AB9EA;}
		.js-ticket-open{background-color:#14A76C;}
		.js-ticket-overdue{background-color:#FF652F;}
		div.js-myticket-link a.js-myticket-link span.js-ticket-circle-count-text.js-ticket-blue{color:#D79922;}
		div.js-myticket-link a.js-myticket-link span.js-ticket-circle-count-text.js-ticket-red{color:#e82d3e;}
		div.js-myticket-link a.js-myticket-link span.js-ticket-circle-count-text.js-ticket-orange{color:#5AB9EA;}
		div.js-myticket-link a.js-myticket-link span.js-ticket-circle-count-text.js-ticket-green{color:#14A76C;}
		div.js-myticket-link a.js-myticket-link span.js-ticket-circle-count-text.js-ticket-pink{color:#FF652F;}
		div.js-myticket-link a.js-myticket-link div.progress::after {border: 25px solid #bfbfbf;}
		div.js-myticket-link a.js-myticket-link:hover{box-shadow: 0 1px 3px 0 rgba(60,64,67,0.302),0 4px 8px 3px rgba(60,64,67,0.149);background-color: #fafafb;}
		div.js-myticket-link a.js-myticket-link.js-ticket-green.active{border-color:#14A76C;}
		div.js-myticket-link a.js-myticket-link.js-ticket-blue.active{border-color:#D79922;}
		div.js-myticket-link a.js-myticket-link.js-ticket-red.active{border-color:#e82d3e;}
		div.js-myticket-link a.js-myticket-link.js-ticket-orange.active{border-color:#5AB9EA;}
		div.js-myticket-link a.js-myticket-link.js-ticket-pink.active{border-color:#FF652F;}

		div.js-myticket-link a.js-myticket-link.js-ticket-green:hover{border-color:#14A76C;}
		div.js-myticket-link a.js-myticket-link.js-ticket-blue:hover{border-color:#D79922;}
		div.js-myticket-link a.js-myticket-link.js-ticket-red:hover{border-color:#e82d3e;}
		div.js-myticket-link a.js-myticket-link.js-ticket-orange:hover{border-color:#5AB9EA;}
		div.js-myticket-link a.js-myticket-link.js-ticket-pink:hover{border-color:#FF652F;}


	/* Top Circle Count Box*/
	/* Search Ticket Form*/
		div.js-ticket-search-wrp{border:1px solid'.$color5.';}
		div.js-ticket-search-wrp div.js-ticket-search-heading{background-color:#e7ecf2;border-bottom:1px solid'.$color5.'; color:'.$color4.'}
		div.js-ticket-search-wrp div.js-ticket-form-wrp form.js-filter-form div.js-filter-wrapper div.js-filter-form-fields-wrp input.js-ticket-input-field{background-color:'.$color3.';border:1px solid'.$color5.';}
		div.js-filter-wrapper-toggle-ticketid input.js-ticket-input-field{background-color:'.$color3.';border:1px solid'.$color5.';}
		div.js-ticket-search-wrp div.js-ticket-form-wrp form.js-filter-form div#js-filter-wrapper-toggle-area div.js-filter-field-wrp input.js-ticket-input-field{background-color:'.$color3.';border:1px solid'.$color5.';}
		div.js-ticket-search-wrp div.js-ticket-form-wrp form.js-filter-form div#js-filter-wrapper-toggle-area div.js-filter-field-wrp input.inputbox{background-color:'.$color3.';border:1px solid'.$color5.';}
		div.js-ticket-search-wrp div.js-ticket-form-wrp form.js-filter-form div#js-filter-wrapper-toggle-area div.js-filter-field-wrp select#jsst-departmentid{background-color:'.$color3.';border:1px solid'.$color5.';}
		div.js-ticket-search-wrp div.js-ticket-form-wrp form.js-filter-form div#js-filter-wrapper-toggle-area div.js-filter-field-wrp select#jsst-priorityid{background-color:'.$color3.';border:1px solid'.$color5.';}
		div.js-ticket-search-wrp div.js-ticket-form-wrp form.js-filter-form div#js-filter-wrapper-toggle-area div.js-filter-field-wrp select#staffid{background-color:'.$color3.';border:1px solid'.$color5.';}
		div#js-filter-wrapper-toggle-area div.js-filter-wrapper div.js-filter-value input.js-ticket-input-field{background-color:'.$color3.';border:1px solid'.$color5.';}
		div#js-filter-wrapper-toggle-area div.js-filter-wrapper div.js-filter-value select#jsst-departmentid{background-color:'.$color3.';border:1px solid'.$color5.';}
		div#js-filter-wrapper-toggle-area div.js-filter-wrapper div.js-filter-value select#jsst-priorityid{background-color:'.$color3.';border:1px solid'.$color5.';}
		div#js-filter-wrapper-toggle-plus{background-color:#474749;}
		div#js-filter-wrapper-toggle-minus{background-color:#474749;}
		div.js-ticket-search-wrp div.js-ticket-form-wrp form.js-filter-form div.js-filter-button-wrp input.js-ticket-search-btn{background-color:'.$color2.';color:'.$color7.';}
		div.js-ticket-search-wrp div.js-ticket-form-wrp form.js-filter-form div.js-filter-button-wrp input.js-ticket-reset-btn{background-color:#474749;color:'.$color7.';}
		span.js-ticket-wrapper-textcolor{color: '.$color7.';}
	/* Search Ticket Form*/
	/* My Tickets $ Staff My Tickets*/
		div.js-ticket-wrapper{border:1px solid'.$color5.';box-shadow: 0 8px 6px -6px #dedddd;}
		div.js-ticket-wrapper:hover{border:1px solid'.$color2.';}
		div.js-ticket-wrapper:hover div.js-ticket-pic{border-right:1px solid'.$color2.';}
		div.js-ticket-wrapper:hover div.js-ticket-data1{border-left:1px solid'.$color2.';}
		div.js-ticket-wrapper:hover div.js-ticket-bottom-line{background:'.$color2.';}
		div.js-ticket-wrapper div.js-ticket-pic{border-right:1px solid'.$color5.';}
		div.js-ticket-wrapper div.js-ticket-data span.js-ticket-status{color:#FFFFFF;}
		div.js-ticket-wrapper div.js-ticket-data1{border-left:1px solid'.$color5.';}
		div.js-ticket-wrapper div.js-ticket-data span.js-ticket-title{color: '.$color4.';}
		a.js-ticket-title-anchor:hover{color:'.$color2.' !important;}
		div.js-ticket-wrapper div.js-ticket-data span.js-ticket-value{color:'.$color4.';}
		div.js-ticket-wrapper div.js-ticket-bottom-line{background:'.$color2.';}
		div.js-ticket-assigned-tome{border:1px solid'.$color5.';background-color:'.$color3.';}
		div.js-ticket-sorting span.js-ticket-sorting-link a{background:#373435;color: '.$color7.';color:#fff;}
		div.js-ticket-sorting span.js-ticket-sorting-link a.selected,
		div.js-ticket-sorting span.js-ticket-sorting-link a:hover{background:'.$color2.';}
	/* My Tickets $ Staff My Tickets*/
/* My Tickets */';


wp_add_inline_style('jssupportticket-main-css',$jssupportticket_css);


?>
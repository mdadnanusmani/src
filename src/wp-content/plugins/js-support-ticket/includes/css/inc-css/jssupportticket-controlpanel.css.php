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





/*

*/

$jssupportticket_css = '';

/*Code for Css*/
$jssupportticket_css .= '
	/* Dashboard Menu Links */
	div#js-dash-menu-link-wrp{display: inline-block;width: 100%;margin: 25px 0px 0px 0px;}
	div.js-section-heading{display: inline-block;width: 100%;padding: 13px 15px;font-size: 18px;}
	div.js-menu-links-wrp{display: inline-block;width: 100%;margin-top: 15px;}
	div.js-ticket-menu-links-row{float: left;width: 100%;}
	a.js-ticket-dash-menu{display: inline-block; float: left;width:calc(100% / 6 - 10px); margin-right:5px;margin-left: 5px;margin-bottom: 10px;margin-top: 10px;padding: 15px 0px;}
	a.js-ticket-dash-menu div.js-ticket-dash-menu-icon{float: left;width: 100%;text-align: center;}
	a.js-ticket-dash-menu div.js-ticket-dash-menu-icon img.js-ticket-dash-menu-img{}
	a.js-ticket-dash-menu span.js-ticket-dash-menu-text{display: inline-block;float: left;width: 100%;text-align: center;margin: 20px 0px;}

	/* Count Box */
	div#js-main-cp-wrapper{display: inline-block; float: left; width: 100%; padding: 15px 15px;}
	div#js-main-head-cp{display: inline-block;float: left;width: calc(25% - 10px);padding: 9px 9px;margin: 0px 5px;}
	div#js-main-head-cp .js-cptext{display: inline-block; float: left; font-size: 25px;}
	div#js-main-head-cp .js-cpmenu{display: inline-block; float: right;}
	div#js-total-count-cp{display: inline-block; float: left; width: 100%; padding: 0px 0px; margin: 20px 0px 25px 0px;}
	div#js-total-count-cp a.js-ticket-count-wrp{display: inline-block; float: left; width: calc(25% - 10px);margin-right: 5px;margin-left: 5px;}
	div#js-total-count-cp .js-total-count{display: inline-block; float: left;width: 100%;}
	div#js-total-count-cp .js-total-count .img{ float: left;}
	div#js-total-count-cp .js-total-count .data{display: inline-block; float: left; padding-left: 10px; }
	div#js-total-count-cp .js-total-count .data .jstotal{display: block;font-size: 22px; padding-bottom: 8px; padding-top: 8px;}
	div#js-total-count-cp .js-total-count .data .jsstatus{display: block; font-size: 14px;}

	/* Ticket Stats */
	div.js-pm-graphtitle-wrp{display: inline-block;width: 100%;}
	div.js-pm-graphtitle{font-size: 18px;display: inline-block; padding: 13px 15px; width: 100%;}
	div#js-pm-grapharea{display: inline-block;float: left; width: 100%;padding-top: 20px;}

	/* Latest Tickets */
	div.js-ticket-latest-ticket-wrapper{float: left;width: 100%;margin-top: 15px;}
	div.js-ticket-latest-tickets-wrp{float: left;width: 100%;}
	div.js-ticket-latest-tickets-wrp div.js-ticket-row{float: left;width: calc(100% - 10px); margin: 0px 5px;padding: 15px 10px;}
	div.js-ticket-latest-tickets-wrp div.js-ticket-row div.js-ticket-first-left{float: left;width: 40%;}
	div.js-ticket-latest-tickets-wrp div.js-ticket-row div.js-ticket-first-left div.js-ticket-user-img-wrp{float: left;width: 35px;height: 35px;padding: 2px;position: relative;}
	div.js-ticket-latest-tickets-wrp div.js-ticket-row div.js-ticket-first-left div.js-ticket-user-img-wrp img.js-ticket-staff-img{width: auto;max-width: 100%;max-height: 100%;height: auto;position: absolute;top: 0;left: 0;right: 0;bottom: 0;margin: auto;}
	div.js-ticket-latest-tickets-wrp div.js-ticket-row div.js-ticket-first-left div.js-ticket-ticket-subject{float: left;width: calc(100% - 45px - 10px);margin-left: 10px;padding: 5px 0px;}
	div.js-ticket-latest-tickets-wrp div.js-ticket-row div.js-ticket-first-left div.js-ticket-ticket-subject a.js-ticket-subject-link{display: inline-block;text-decoration: none;outline: 0;}
	div.js-ticket-latest-tickets-wrp div.js-ticket-row div.js-ticket-second-left{float: left;width: 20%; text-align: center;}
	div.js-ticket-latest-tickets-wrp div.js-ticket-row div.js-ticket-second-left div.js-ticket-user-name{padding: 5px 0px;}
	div.js-ticket-latest-tickets-wrp div.js-ticket-row div.js-ticket-second-left div.js-ticket-user-name a.js-ticket-username-link{display: inline-block;text-decoration: none;outline: 0;}
	div.js-ticket-latest-tickets-wrp div.js-ticket-row div.js-ticket-third-left{float: left;width: 25%;text-align: center;}
	div.js-ticket-latest-tickets-wrp div.js-ticket-row div.js-ticket-third-left div.js-ticket-department{padding: 5px 0px;}
	div.js-ticket-latest-tickets-wrp div.js-ticket-row div.js-ticket-third-left div.js-ticket-department a.js-ticket-department-link{display: inline-block;text-decoration: none;outline: 0;}
	div.js-ticket-latest-tickets-wrp div.js-ticket-row div.js-ticket-fourth-left{float: left;width: 15%;padding: 0px 25px;text-align: center;}
	div.js-ticket-latest-tickets-wrp div.js-ticket-row div.js-ticket-fourth-left div.js-ticket-priorty{text-align: center;padding: 5px 0px;}
	span.js-ticket-latest-ticket-heading{display: none;}
	div.js-ticket-zero-padding{padding: 0px !important;}
';
/*Code For Colors*/
$jssupportticket_css .= '
/*Count Box*/
	div#js-total-count-cp .js-total-count{border: 1px solid '.$color5.';background-color: '.$color3.';}
	div#js-total-count-cp .js-total-count .data .jstotal{color:#373435;}
	div#js-total-count-cp .js-total-count .data .jsstatus{color:#838386;}
	div#js-total-count-cp a.js-ticket-count-wrp:hover .js-ticket{border-color: #0073b7;}
	div#js-total-count-cp a.js-ticket-count-wrp:hover .js-department{border-color: #dd4b39;}
	div#js-total-count-cp a.js-ticket-count-wrp:hover .js-staff{border-color: #f39c12;}
	div#js-total-count-cp a.js-ticket-count-wrp:hover .js-feedback{border-color: #00a859;}

	div#js-total-count-cp a.js-ticket-count-wrp:hover .js-ticket-total {color: #0073b7;}
	div#js-total-count-cp a.js-ticket-count-wrp:hover .js-ticket-status{color: #0073b7;}
	div#js-total-count-cp a.js-ticket-count-wrp:hover .js-department-total{color: #dd4b39;}
	div#js-total-count-cp a.js-ticket-count-wrp:hover .js-department-status{color: #dd4b39;}
	div#js-total-count-cp a.js-ticket-count-wrp:hover .js-staff-total{color: #f39c12;}
	div#js-total-count-cp a.js-ticket-count-wrp:hover .js-staff-status{color: #f39c12;}
	div#js-total-count-cp a.js-ticket-count-wrp:hover .js-feedback-total{color: #00a859;}
	div#js-total-count-cp a.js-ticket-count-wrp:hover .js-feedback-status{color: #00a859;}
/*Count Box*/
/*Ticket Stats*/
	div.js-pm-graphtitle-wrp{border:1px solid '.$color5.';}
	div.js-pm-graphtitle{background-color: '.$color3.';border-bottom:1px solid '.$color5.';color :'.$color4.';}
/*Ticket Stats*/
/* Dashboard Menu Links */
	div.js-section-heading{background-color: '.$color3.';border:1px solid '.$color5.';color :'.$color4.';}
	a.js-ticket-dash-menu{background-color: '.$color3.';border:1px solid '.$color5.';}
	a.js-ticket-dash-menu span.js-ticket-dash-menu-text{color:#838386;}
	.js-col-xs-12.js-col-sm-6.js-col-md-4.js-ticket-dash-menu:hover{box-shadow: 0 1px 3px 0 rgba(60,64,67,0.302),0 4px 8px 3px rgba(60,64,67,0.149);background-color: #fafafb;}
/* Dashboard Menu Links */
/* latest Tickets */
	div.js-ticket-latest-ticket-header{background-color:#ecf0f5!important;}
	div.js-ticket-latest-tickets-wrp div.js-ticket-row{border-bottom:1px solid '.$color5.';}
	div.js-ticket-latest-tickets-wrp div.js-ticket-row:last-child{border-bottom:none;}
	div.js-ticket-latest-tickets-wrp div.js-ticket-row div.js-ticket-first-left div.js-ticket-user-img-wrp{background-color:#e6e7e8;}
	div.js-ticket-latest-tickets-wrp div.js-ticket-row div.js-ticket-first-left div.js-ticket-ticket-subject a.js-ticket-subject-link{color: '.$color2.';}
	div.js-ticket-latest-tickets-wrp div.js-ticket-row div.js-ticket-second-left div.js-ticket-user-name a.js-ticket-username-link{color:#838386;}
	div.js-ticket-latest-tickets-wrp div.js-ticket-row div.js-ticket-third-left div.js-ticket-department a.js-ticket-department-link{color:#838386;}
	div.js-ticket-latest-tickets-wrp div.js-ticket-row div.js-ticket-fourth-left div.js-ticket-priorty{color:'.$color7.';}
/* latest Tickets */

';


wp_add_inline_style('jssupportticket-main-css',$jssupportticket_css);


?>
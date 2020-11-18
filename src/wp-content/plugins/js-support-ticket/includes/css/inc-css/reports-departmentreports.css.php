<?php 






/*
jssupportticket::$_colors[color1] => #8f5600
jssupportticket::$_colors[color2] => #4ABDAC
jssupportticket::$_colors[color3] => #fafafa
jssupportticket::$_colors[color4] => #373435
jssupportticket::$_colors[color5] => #DFDCE3
jssupportticket::$_colors[color6] => #e7e7e7
jssupportticket::$_colors[color7] => #ffffff
jssupportticket::$_colors[color8] => #2DA1CB
jssupportticket::$_colors[color9] => #000000
*/

$jssupportticket_css = '';

/*Code for Css*/
$jssupportticket_css .= '
div.js-ticket-downloads-wrp{float: left;width: 100%;margin-top: 17px;}
div.js-ticket-downloads-wrp div.js-ticket-downloads-heading-wrp{float: left;width: 100%;padding: 15px 10px;}
/* Staff Report */
	div.js-ticket-staff-report-wrapper{float: left;width: 100%;margin-top: 20px;}
	input#jsst-date-start{background-image: url('.jssupportticket::$_pluginpath.'includes/images/ticketdetailicon/calender.png);background-repeat: no-repeat;background-position: 97% 14px;}
	input#jsst-date-end{background-image: url('.jssupportticket::$_pluginpath.'includes/images/ticketdetailicon/calender.png);background-repeat: no-repeat;background-position: 97% 14px;}
	div.js-admin-report-box-wrapper{float:left;width:100%;margin-top:20px;margin-bottom: 10px;}
	div.js-ticket-download-content-wrp-mtop{margin-top: 30px;}
	div.js-admin-report-box-wrapper div.js-admin-box{background:#ffffff;border:1px solid #cccccc;padding:0px;width: calc(100% / 5 - 5px);margin: 0px 2.5px; }
	div.js-admin-report-box-wrapper.js-admin-controlpanel div.js-admin-box{margin-right: 0px;}
	div.js-admin-report-box-wrapper div.js-admin-box.js-col-md-offset-2{margin-left:11%;}
	div.js-admin-report-box-wrapper.js-admin-controlpanel div.js-admin-box.js-col-md-offset-2{margin-left:0px;}
	div.js-admin-report-box-wrapper div.js-admin-box div.js-admin-box-image{padding:5px;}
	div.js-admin-report-box-wrapper div.js-admin-box div.js-admin-box-image img{max-width: 100%;max-height: 100%;}
	div.js-admin-report-box-wrapper div.js-admin-box div.js-admin-box-content{padding:5px;}
	div.js-admin-report-box-wrapper div.js-admin-box div.js-admin-box-content div.js-admin-box-content-number{text-align: right;font-size:24px;font-weight: bold;}
	div.js-admin-report-box-wrapper div.js-admin-box div.js-admin-box-content div.js-admin-box-content-label{text-align: right;font-size:12px;padding:0px;margin-top:5px;color:#989898;white-space: nowrap;overflow: hidden;text-overflow:ellipsis;}
	div.js-admin-report-box-wrapper div.js-admin-box.box1 div.js-admin-box-content div.js-admin-box-content-number{color:#1EADD8;}
	div.js-admin-report-box-wrapper div.js-admin-box.box2 div.js-admin-box-content div.js-admin-box-content-number{color:#179650;}
	div.js-admin-report-box-wrapper div.js-admin-box.box3 div.js-admin-box-content div.js-admin-box-content-number{color:#D98E11;}
	div.js-admin-report-box-wrapper div.js-admin-box.box4 div.js-admin-box-content div.js-admin-box-content-number{color:#DB624C;}
	div.js-admin-report-box-wrapper div.js-admin-box.box5 div.js-admin-box-content div.js-admin-box-content-number{color:#5F3BBB;}

	div.js-admin-report-box-wrapper div.js-admin-box.box1 div.js-admin-box-label{height:20px;background:#1EADD8;}
	div.js-admin-report-box-wrapper div.js-admin-box.box2 div.js-admin-box-label{height:20px;background:#179650;}
	div.js-admin-report-box-wrapper div.js-admin-box.box3 div.js-admin-box-label{height:20px;background:#D98E11;}
	div.js-admin-report-box-wrapper div.js-admin-box.box4 div.js-admin-box-label{height:20px;background:#DB624C;}
	div.js-admin-report-box-wrapper div.js-admin-box.box5 div.js-admin-box-label{height:20px;background:#5F3BBB;}

	a.js-admin-report-wrapper{float:left;display: block;width:95%;font-size:18px;}
	a.js-admin-report-wrapper:hover{text-decoration: none;}
	a.js-admin-report-wrapper div.js-admin-overall-report-type-wrapper{box-shadow: 0px 0px 10px #aaaaaa;border-bottom:8px solid #6AA108;color:#6AA108;margin:10px 0px;background:url('.jssupportticket::$_pluginpath.'includes/images/report/overall.png)  98% center no-repeat #EAF1DD;}
	a.js-admin-report-wrapper div.js-admin-staff-report-type-wrapper{box-shadow: 0px 0px 10px #aaaaaa;border-bottom:8px solid #1EADD8;color:#1EADD8;margin:10px 0px;background:url('.jssupportticket::$_pluginpath.'includes/images/report/staffbox.png)  98% center no-repeat #EEF9FD;}
	a.js-admin-report-wrapper div.js-admin-user-report-type-wrapper{box-shadow: 0px 0px 10px #aaaaaa;border-bottom:8px solid #D98E11;color:#D98E11;margin:10px 0px;background:url('.jssupportticket::$_pluginpath.'includes/images/report/userbox.png)  98% center no-repeat #FFF5EB;}
	div.js-admin-staff-wrapper{display: inline-block;width:100%;background:#ffffff;margin-top:20px;border:1px solid #cccccc;}
	div.js-admin-staff-wrapper.js-departmentlist{padding: 10px;}
	div.js-admin-staff-wrapper.js-departmentlist div.departmentname{font-size: 20px;}
	div.js-admin-staff-wrapper.js-departmentlist div.jsposition-reletive{padding-top: 30px;}
	div.js-admin-staff-wrapper.js-departmentlist div.jsposition-reletive div.departmentname{}
	div.js-admin-staff-wrapper.padding{padding:10px;}
	div.js-admin-staff-wrapper .nopadding{padding:0px;}
	div.js-admin-staff-wrapper div.js-report-staff-image-wrapper{margin:0px;padding:0px;border:1px solid #cccccc;background:#F1F1F1;}
	div.js-admin-staff-wrapper div.js-report-staff-image-wrapper img.js-report-staff-pic{max-width:100%;max-height:90px;margin:0 auto;display: block;}
	div.js-admin-staff-wrapper div.js-report-staff-name{display: block;padding:3px 0px;font-weight: bold;font-size: 15px;color:#666666;border-bottom:1px solid #cccccc;margin-bottom:5px;}
	div.js-admin-staff-wrapper div.js-departmentname{font-weight: bold;font-size: 18px;color:#666666; margin: 15px 0px;}
	div.js-admin-staff-wrapper div.js-report-staff-username{display: block;padding:3px 0px;font-size: 14px;color:#666666;}
	div.js-admin-staff-wrapper div.js-report-staff-email{display: block;padding:3px 0px;font-size: 14px;color:#666666;}
	div.js-admin-staff-wrapper div.js-admin-report-box{background:#F1F1F1;border:1px solid #cccccc;margin-left:8px;padding:0px;padding-top:10px;}
	div.js-admin-staff-wrapper div.js-admin-report-box span.js-report-box-number{color:#989898;display: block;font-size:22px;font-weight: bold;text-align: center;margin:5px 0px 10px 0px;}
	div.js-admin-staff-wrapper div.js-admin-report-box span.js-report-box-title{color:#989898;display: block;font-size:12px;text-align: center;padding:5px 4px 10px 4px;white-space: nowrap;text-overflow:ellipsis;overflow: hidden;}
	div.js-admin-staff-wrapper div.js-admin-report-box.box1{margin-left:10.4%;}
	div.js-admin-staff-wrapper div.js-admin-report-box.box1 div.js-report-box-color{height:5px;background:#1EADD8;}
	div.js-admin-staff-wrapper div.js-admin-report-box.box2 div.js-report-box-color{height:5px;background:#179650;}
	div.js-admin-staff-wrapper div.js-admin-report-box.box3 div.js-report-box-color{height:5px;background:#D98E11;}
	div.js-admin-staff-wrapper div.js-admin-report-box.box4 div.js-report-box-color{height:5px;background:#DB624C;}
	div.js-admin-staff-wrapper div.js-admin-report-box.box5 div.js-report-box-color{height:5px;background:#5F3BBB;}
	a.js-admin-staff-anchor-wrapper{display: inline-block;width: 100%;padding:10px;float:left;}
	table.js-admin-report-tickets{width:100%;}
	table.js-admin-report-tickets tr th{background:#cccccc;color:#333333;padding:8px;font-size:18px;}
	table.js-admin-report-tickets tr td.overflow{white-space: nowrap;overflow: hidden;text-overflow:ellipsis;text-align: left;}
	table.js-admin-report-tickets tr td{text-align: center;background:#FFFFFF;padding:8px;}
	table.js-admin-report-tickets tr td span.js-responsive-heading{display:none;}
	a.js-admin-report-butonright{float:right;}
	div#js-admin-ticketviaemail-bar{display: none;float:left;height:25px;width:35%;background:url('.jssupportticket::$_pluginpath.'includes/images/progress_bar.gif);background-size: 100% 100%;margin-left:20px;margin-top:5px;}
	div#js-admin-ticketviaemail-text{display:none;padding:10px 0px;}
	a#js-admin-ticketviaemail{display: block;float:left;border:1px solid #666555;padding:8px 15px 8px 40px;background:url('.jssupportticket::$_pluginpath.'includes/images/button_ticketviaemail.png);background-size:100% 100%;color:#ffffff;font-weight: bold;border-radius: 4px;text-decoration: none;position: relative;}
	a#js-admin-ticketviaemail img{position: absolute;top:3px;left:5px;}
	div#js-admin-ticketviaemail-msg{padding:10px;display:inline-block;float:none;margin-top:5px;border-radius: 4px;margin-bottom:10px;}
	div#js-admin-ticketviaemail-msg.server-error{background:#FEEFB3;color:#B98324;border:1px solid #B98324;}
	div#js-admin-ticketviaemail-msg.imap-error{background:#FEEFB3;color:#B98324;border:1px solid #B98324;}
	div#js-admin-ticketviaemail-msg.email-error{background:#FEEFB3;color:#B98324;border:1px solid #B98324;}
	div#js-admin-ticketviaemail-msg.no-error{background:#DFF2BF;color:#387B00;border:1px solid #387B00;}
	div.js-admin-ticketviaemail-wrapper-checksetting{margin-top:10px;}
	span.js-relative{position: relative;}
	span.js-relative img.js-relative-image{position: absolute;top:60px;right:0px;}
	div#tabs.tabs{float: left; width:100%}
	div.js-form-wrapper div.js-form-wrapper {padding-left: 2%;}
	div.js-form-wrapper div.js-form-value.js-assingtome-chkbox{padding: 6px 15px;}
	div.js-form-wrapper div.js-form-value.js-assingtome-chkbox label#forassigntome{padding-left: 4px;}
	div#pie3d_chart1{}
	div#no_message{background: #f6f6f6 none repeat scroll 0 0; border: 1px solid #d4d4d5; color: #723776; display: inline-block; font-size: 15px; left: 50%; min-width: 80%; padding: 15px 20px; position: absolute; text-align: center; top: 50%; transform: translate(-50%, -50%); }
	div#records div.jsst_userpages{text-align: right;padding:5px; margin: 10px 5px;width: calc(100% - 10px);}
	div#records div.jsst_userpages a.jsst_userlink{display: inline-block;padding:5px 10px;margin-left:5px;text-decoration: none;background:rgba(0, 0, 0, 0.05) none repeat scroll 0 0;}
	div#records div.jsst_userpages span.jsst_userlink{display: inline-block;padding:5px 15px;margin-left:5px;}
	form div.js-form-wrapper div.js-form-value input#sendmail2.radiobutton{margin-left: 15px;}
	h1.js-department-margin{padding-top: 15px;}
	.leftrightnull{padding-left: 0px; padding-right: 0px;}
';
/*Code For Colors*/
$jssupportticket_css .= '';


wp_add_inline_style('jssupportticket-main-css',$jssupportticket_css);


?>
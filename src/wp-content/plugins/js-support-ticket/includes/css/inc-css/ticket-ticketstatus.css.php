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
/* Ticket Status */
	form.js-ticket-form{display:inline-block; width: 100%; margin-top: 17px;}
	div.js-ticket-checkstatus-wrp{float: left;width: 100%;}
	div.js-ticket-checkstatus-wrp div.js-ticket-checkstatus-field-wrp{float: left;width: calc(100% / 2 - 50px); margin:0px 25px;margin-bottom: 25px;}
	div.js-ticket-field-title{float: left;width: 100%;margin-bottom: 10px;}
	div.js-ticket-field-wrp{float: left;width: 100%;}
	div.js-ticket-field-wrp input.js-ticket-form-input-field{border-radius: 0px;padding: 11px 5px;width: 100%;}
	div.js-ticket-form-btn-wrp{float: left;width:calc(100% - 20px);margin: 0px 10px;text-align: center;padding: 25px 0px 10px 0px;}
	div.js-ticket-form-btn-wrp input.js-ticket-save-button{padding: 20px 10px;margin-right: 10px;min-width: 120px;border-radius: 0px;}
	div.js-ticket-form-btn-wrp a.js-ticket-cancel-button{display: inline-block; padding: 14px 10px;margin-right: 10px;min-width: 120px;border-radius: 0px;}


';
/*Code For Colors*/
$jssupportticket_css .= '

/*Ticket Status*/
	div.js-ticket-field-wrp input.js-ticket-form-input-field{background-color:'.$color3.'; border:1px solid '.$color5.';}
	div.js-ticket-form-btn-wrp{border-top:2px solid '.$color2.';}
	div.js-ticket-form-btn-wrp input.js-ticket-save-button{background-color:'.$color2.';color:'.$color7.';}
	div.js-ticket-form-btn-wrp a.js-ticket-cancel-button{background: #606062;color:'.$color7.';}

/*Ticket Status*/

';


wp_add_inline_style('jssupportticket-main-css',$jssupportticket_css);


?>
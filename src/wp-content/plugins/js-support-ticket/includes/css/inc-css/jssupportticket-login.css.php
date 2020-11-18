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
/* Login Page */
	div.js-ticket-login-wrapper{float: left;width: 100%;}
	div.js-ticket-login-wrapper div.js-ticket-login{float: left;width: 100%;}
	div.js-ticket-login-wrapper div.js-ticket-login form#loginform-custom{width:100%;float: left;padding: 20px;margin: 0px;}
	form#loginform-custom p.login-username{width:48%;float:left;margin-right:4% !important;}
	form#loginform-custom p.login-username label{font-weight: unset;}
	form#loginform-custom p.login-password{width:48%;float:left;margin-bottom: 15px!important;}
	form#loginform-custom p.login-password label{font-weight: unset;}
	form#loginform-custom p.login-remember label{font-weight: unset;}
	form#loginform-custom p.login-remember {margin-top: 10px !important;}
	form#loginform-custom p.login-remember label input#rememberme{vertical-align: middle;}
	form#loginform-custom p.login-submit{width:100%;float:left;padding:20px 0px;text-align: center;margin-top:15px !important;}
	form#loginform-custom p.login-username input#user_login{border-radius: unset;width:100%;}
	form#loginform-custom p.login-password input#user_pass{border-radius: unset;width:100%;}
	form#loginform-custom p.login-submit input#wp-submit{min-width: 120px;border-radius: unset;}
	span.help-block{font-size:14px;}
	span.help-block{color:red;}
';
/*Code For Colors*/
$jssupportticket_css .= '
	/* Login Page */
		form#loginform-custom p.login-submit{border-top:1px solid '.$color2.';}
		form#loginform-custom p.login-username input#user_login{background-color:'.$color3.'; border:1px solid '.$color5.';}
		form#loginform-custom p.login-password input#user_pass{background-color:'.$color3.'; border:1px solid '.$color5.';}
		form#loginform-custom p.login-submit input#wp-submit{background-color:'.$color2.';}
	/* Login Page */
';


wp_add_inline_style('jssupportticket-main-css',$jssupportticket_css);


?>
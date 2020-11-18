<?php
 date_default_timezone_set("Asia/Riyadh");
include "administrator/config.php";
include "administrator/config_or.php";
include "administrator/fun/fun.php";
session_start();

 $sqql=" INSERT INTO `users_log`( `username`, `time`, `action`, `ip`) VALUES ('".$_SESSION['username']."','".date('d/m/Y h:i:sa')."','Logout','".$_SERVER['REMOTE_ADDR']."')";
        	$qqq=mysqli_query($connn,$sqql) ;
unset($_SESSION["userid"]); 
unset($_SESSION["username"]);
unset($_SESSION["name"]);
unset($_SESSION["admin"]);
unset($_SESSION["login"]);
header("Location: page-login.php");

?>
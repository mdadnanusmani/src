<?php

session_start();
unset($_SESSION["userid"]); 
unset($_SESSION["username"]);
unset($_SESSION["name"]);
unset($_SESSION["admin"]);
unset($_SESSION["login"]);
header("Location: page-login.php");

?>
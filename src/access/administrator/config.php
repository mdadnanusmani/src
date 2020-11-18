<?php
 date_default_timezone_set("Asia/Riyadh");     
$dbhost = "localhost";
$dbuser = "srcocoms_admin";
$dbpass = "Abc@655010";
$dbname = "srcocoms_partner";

@session_start();
$connn = mysqli_connect( $dbhost, $dbuser, $dbpass,$dbname );
if(mysqli_connect_errno())
{
    echo  mysqli_connect_error();
  exit( "Error Connect to DataBase..." );
}


$_SESSION['dbname']=$dbname;
mysqli_set_charset('utf8',$connn);
?>

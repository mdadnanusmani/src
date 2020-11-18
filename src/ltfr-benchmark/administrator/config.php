<?php
 date_default_timezone_set("Asia/Riyadh");     
$dbhost = "localhost";
$dbuser = "srcocom_admin";
$dbpass = "Abc@655010";
$dbname = "srcocom_partner";

@session_start();
if ( !( $connn = mysql_connect( $dbhost, $dbuser, $dbpass ) ) )
{
  exit( "Error Connect to DataBase" );
}

if ( !( $sql = mysql_select_db( $dbname, $connn ) ) )
{
   exit( "<br><div align=center><big>Error select_db </big></div>" );
}
$_SESSION['dbname']=$dbname;
mysql_set_charset('utf8',$connn);
?>

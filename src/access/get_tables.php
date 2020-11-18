<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "root@2017";
$dbname = "beautyksa_pmo";


@session_start();
if ( !( $connn = mysql_connect( $dbhost, $dbuser, $dbpass ) ) )
{
  exit( "Error Connect to DataBase" );
}

if ( !( $sql = mysql_select_db( $dbname, $connn ) ) )
{
   exit( "<br><div align=center><big>Error select_db </big></div>" );
}
mysql_set_charset('utf8',$connn);

$row=mysql_fetch_array( mysql_query("DESCRIBE my_table road"));
   print_r($row);

?>
<?php

include "administrator/config.php";
$q=mysql_query("select * from `db` where notificition ='Yes'");
//$s=mysql_fetch_array($q);

while($s=mysql_fetch_array($q))
{
//print_r($s);
$dbid=$s['id'];
$qu=mysql_query("select * from `users` where notificition ='1'");
 while($su=mysql_fetch_array($qu)){
    $usid=$su['id'];
     $qq="insert into `notificition` values (NULL,'$dbid','0','0','0','0','$usid')";
    //echo "<br>";
    mysql_query($qq) or die(mysql_error());
 };

};

?>
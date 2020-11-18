<?php

session_start();
if($_SESSION['login']=="okk")
{
     if($_SESSION['admin']=='1')
        			   {}
        			else{
        			    echo '<script>window.location = "view.php";</script>';
        			    
        			    exit();
        			}
}
else{
     echo '<script>window.location = "page-login.php";</script>';
        			    
        			    exit();
}


date_default_timezone_set("Asia/Riyadh");
include "administrator/config.php";
 header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="users_access_log_export.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');
   $df = fopen("php://output", 'w');
 fputcsv($df, array("Username","",$_REQUEST['username']));
 fputcsv($df, array("","",""));
 fputcsv($df, array("Date Time","Action","IP Address"));

                 $sql="SELECT * FROM `users_log` where `users_log`.`username` = '".$_REQUEST['username']."' ORDER BY `users_log`.`id` ASC";
                    
                    $result= mysqli_query($connn,$sql);
                     while($row = mysqli_fetch_array($result)){
                         
                          fputcsv($df, array($row['time'],$row['action'],$row['ip']));
                         
                     }


die();

?>
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
    header('Content-Disposition: attachment; filename="users_export.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');
   $df = fopen("php://output", 'w');

 fputcsv($df, array("Username","Password","IsAdmin","Name","Mobile No."));

          $sql="SELECT * FROM `users` ORDER BY `users`.`id` ASC";
                    $result= mysqli_query($connn,$sql);
                     while($row = mysqli_fetch_array($result)){
                          $isadmin="No";
                         if($row['isadmin']==1){
                             $isadmin="Yes";
                         }
                          fputcsv($df, array($row['username'],$row['password'],$isadmin,$row['emp_name'],$row['mobile']));
                         
                     }


die();

?>
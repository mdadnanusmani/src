<?php
if(isset($_POST['old_emp_password']) && isset($_POST['emp_password']))
{

        @session_start();
        include "../administrator/config.php";
        $old_emp_password=$_POST['old_emp_password'];
        $pass=$_POST['emp_password'];
        $userid=$_SESSION['S_USERID'];
        $username=$_SESSION['S_USERNAME'];
        $sql="select * from users where id='$userid' and password='$old_emp_password' and username='$username'";
        $q=mysql_query($sql) or die(mysql_error($sql));

        if(mysql_num_rows($q)>0)
        {
            $sq="update users set password='$pass' where id='$userid'";
            $q=mysql_query($sq) or die(mysql_error());            
            $_SESSION['msg2']='<div class="alert alert-success">تم تعديل بياناتك بنجاح</div>';
        } else
        {
            $_SESSION['msg2']='<div class="alert alert-warning">خطاء عند تعديل البيانات</div>';
        }
        echo '<script>window.location = "../index.php";</script>';
}
?>
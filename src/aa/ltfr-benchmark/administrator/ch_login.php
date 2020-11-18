<?
include "../config.php";
include "../config_or.php";
include "fun/fun.php";
session_start();
if(isset($_POST['emp_id']) && isset($_POST['emp_password']))
{

    $emp=$_POST['emp_id'];
    $emp_pass=base64_encode(md5(base64_encode(md5(md5($_POST['emp_password'])))));
    $sql="select * from sys_users where EMP_NO='$emp' and EMP_PASSWORD='$emp_pass'";
    $q=mysql_query($sql) or die(mysql_error());
    if(mysql_num_rows($q)>0)
    {
        or_user_session($emp);
        echo '<script>window.location = "index.php";</script>';
        
    }else
    {   
        
         $_SESSION['err_msg']="الرجاء التاكد من رقم الهوية او كلمة المرور";
         echo '<script>window.location = "login.php";</script>';
         //echo '<script>alert("الرجاء التاكد من رقم الهوية او كلمة المرور"); window.history.back();</script>';
    }
}

?>
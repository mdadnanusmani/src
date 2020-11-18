<?php
@session_start();
function get_main_consolut()
{
    $sql="select * from consolut ";
    $q=mysql_query($sql) or die(mysql_error());
    return $q;
}


function insert_portal_group_item()
{

  if($_POST['submit_portal_group'])
    {

    $name=$_POST['name'];
    $mgname=$_POST['mgname'];

    $sql="insert into `consolut` values('','$name','$mgname')";
    $q=mysql_query($sql) or die(mysql_error());

    $_SESSION['msg2']="تمت إضافة المجموعة بنجاح";
    $_SESSION['msg_type']="s";
    echo '<script>window.location = "consolut.php";</script>';

    }
}
 insert_portal_group_item();


function update_aseer_portal_item()
{
    if($_POST['submit_portal_group_update'])
    {


    $name=$_POST['name'];
    $mgname=$_POST['mgname'];
    $id=$_POST['id'];
    $sql="update `consolut` set name='$name',mgname='$mgname' where id='$id'";
    $q=mysql_query($sql) or die(mysql_error());

    $_SESSION['msg2']="تم تعديل البيانات بنجاح";
    $_SESSION['msg_type']="s";
    echo '<script>window.location = "consolut.php";</script>';


    }
}
update_aseer_portal_item();
if($_GET['del_value'])
{
   include "../administrator/config.php";
  // echo "elmgdaaaaaaaaaaaad".$_GET['del_value'];
   $id=$_GET['del_value'];
   $sql="delete from consolut where id='$id'";
   $q=mysql_query($sql) or die(mysql_error());
   $_SESSION['msg2']="تم الحذف بنجاح";
   $_SESSION['msg_type']="s";
  echo '<script>window.location = "consolut.php";</script>';
}

////////////////////




?>
<script>
function del(val)
 {
     if (confirm(" حذف من النظام ؟")) {

        jQuery('#div_session_write').load('fun/include_fun_consolut.php?del_value='+val);
        setTimeout(function(){
        window.location.reload(1);
        }, 1000);
    } else {
    // Do nothing!
    }

 }
 </script>
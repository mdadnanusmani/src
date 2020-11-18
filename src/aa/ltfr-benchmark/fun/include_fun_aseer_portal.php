<?php
@session_start();
function get_main_serv()
{
    $sql="select * from main_serve order by main_id";
    $q=mysql_query($sql) or die(mysql_error());
    return $q;
}

function get_sub_serv()
{
    $sql="select * from `items`";
    $q=mysql_query($sql) or die(mysql_error());
    return $q;
}


function insert_portal_group_item()
{
  if($_POST['submit_portal_group_item'])
    {

    $title=$_POST['title'];
    $data=$_POST['data'];
    $mid=$_POST['group'];
    $sql="insert into `items` (main_id,title,data) values('$mid','$title','$data')";
    $q=mysql_query($sql) or die(mysql_error());

    $_SESSION['msg2']="تمت إضافة المجموعة بنجاح";
    $_SESSION['msg_type']="s";
    echo '<script>window.location = "aseer-portal.php";</script>';

    }
}

function insert_portal_group()
{
  if($_POST['submit_portal_group'])
    {

    $name=$_POST['name'];
    $desc=$_POST['desc'];
    $group=$_POST['group'];
    $file_name=$_POST['img'];

    $target_dir = "assets/images/portal/";
    $target_file = $target_dir . basename($_FILES["img"]["name"]);

    //get type
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        $file_name= $target_dir."//deafult_img.png";
        $sql="insert into main_serve (main_id,name,Description,img) values('$group','$name','$desc','$file_name')";

    }else
    {
    ////////////
        $file=$target_dir.date("mdYHis")."-". basename($_FILES["img"]["name"]);
        if (move_uploaded_file($_FILES['img']['tmp_name'],$file )) {
            $sql="insert into main_serve (main_id,name,Description,img) values('$group','$name','$desc','$file')";
        } else {
        $img=$target_dir."//deafult_img.png";
        $sql="insert into main_serve (main_id,name,Description,img) values('$group','$name','$desc','$img')";
        }
    ////////////
    }


    // Execute
    $q=mysql_query($sql) or die(mysql_error());

   $_SESSION['msg2']="تمت إضافة المجموعة بنجاح";
   $_SESSION['msg_type']="s";
   echo '<script>window.location = "aseer-portal.php";</script>';

}


}

function update_aseer_portal_item()
{
    if($_POST['submit_portal_group_item_update'])
    {

    $title=$_POST['title'];
    $data=$_POST['data'];
    $mid=$_POST['group'];
    $id=$_POST['id'];
    $sql="update `items` set Main_id='$mid',title='$title',Data='$data' where ID='$id'";
    $q=mysql_query($sql) or die(mysql_error());

    $_SESSION['msg2']="تم تعديل البيانات بنجاح";
    $_SESSION['msg_type']="s";
    echo '<script>window.location = "aseer-portal.php";</script>';


    }
}
function update_aseer_portal()
{
  if($_POST['submit_portal_group_update'])
    {
    $id=$_POST['id'];
    $name=$_POST['name'];
    $desc=$_POST['desc'];
    $group=$_POST['group'];
    $file_name=$_POST['img'];
    $old_img=$_POST['old_img'];

    $file=basename( $_FILES["img"]["name"]);
    if($file!="")
    {

    $target_dir = "assets/images/portal/";
    $target_file = $target_dir . basename($_FILES["img"]["name"]);

    //get type
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {

        $sql="update main_serve set Name='$name',Description='$desc',main_id='$group' where ID='$id'";

    }else
    {
    ////////////
        $file=$target_dir.date("mdYHis")."-". basename($_FILES["img"]["name"]);
        if (move_uploaded_file($_FILES['img']['tmp_name'],$file )) {
            $sql="update main_serve set Name='$name',Description='$desc',img='$file',main_id='$group' where ID='$id'";
        } else {
            $sql="update main_serve set Name='$name',Description='$desc',main_id='$group' where ID='$id'";
        }
    ////////////
    }




    }else
    {
        $sql="update main_serve set Name='$name',Description='$desc',main_id='$group' where ID='$id'";
    }


    // Execute
    $q=mysql_query($sql) or die(mysql_error());

   $_SESSION['msg2']="تم تعديل البيانات بنجاح";
   $_SESSION['msg_type']="s";
   echo '<script>window.location = "aseer-portal.php";</script>';



    }

}

if($_GET['del_value'])
{
   include "../administrator/config.php";
  // echo "elmgdaaaaaaaaaaaad".$_GET['del_value'];
   $id=$_GET['del_value'];
   $sql="delete from main_serve where ID='$id'";
   $q=mysql_query($sql) or die(mysql_error());
   $_SESSION['msg2']="تم الحذف بنجاح";
   $_SESSION['msg_type']="s";
  echo '<script>window.location = "aseer-portal.php";</script>';
}

if($_GET['del_item_value'])
{
   include "../administrator/config.php";
  // echo "elmgdaaaaaaaaaaaad".$_GET['del_value'];
   $id=$_GET['del_item_value'];
   $sql="delete from `items` where ID='$id'";
   $q=mysql_query($sql) or die(mysql_error());
   $_SESSION['msg2']="تم الحذف بنجاح";
   $_SESSION['msg_type']="s";
  echo '<script>window.location = "aseer-portal.php";</script>';
}

////////////////////

function bind_aseer_portal_view($id)
{

    $sql="select * from main_serve where ID ='$id'";
    $q=mysql_query($sql) or die(mysql_error());
    $row = mysql_fetch_array($q);
    return $row['Name'];

}


function bind_aseer_portal_update($id,$main='')
{
    echo "<select name='group' class='form-control'>";

    if($main==1)
        if($id==0)
            echo "<option value='0' selected='selected'>الرئسية</option>";
        else
            echo "<option value='0' >الرئسية</option>";

    if($main==1)
    $sql="select * from main_serve where main_id=19";
    else
    $sql="select * from main_serve";
    $q=mysql_query($sql) or die(mysql_error());


    while($row = mysql_fetch_array($q))
    {
    if($row['ID']==$id)
        echo "<option value='".$row['ID']."' selected='selected'>".$row['Name']."</option>";
    else
        echo "<option value='".$row['ID']."'>".$row['Name']."</option>";
    }
    echo "</select>";
}

function bind_aseer_portal_select($main='')
{
    $sql="select * from main_serve";
    $q=mysql_query($sql) or die(mysql_error());
    echo "<select name='group' class='form-control'>";
    if($main==1)
    echo "<option value='0'>الرئسية</option>";
    while($row = mysql_fetch_array($q))
    {
        echo "<option value='".$row['ID']."'>".$row['Name']."</option>";
    }
    echo "</select>";
}







insert_portal_group();
insert_portal_group_item();
update_aseer_portal();
update_aseer_portal_item();
?>
<script>
function del(val)
 {
     if (confirm(" حذف من النظام ؟")) {

        jQuery('#div_session_write').load('fun/include_fun_aseer_portal.php?del_value='+val);
        setTimeout(function(){
        window.location.reload(1);
        }, 1000);
    } else {
    // Do nothing!
    }

 }
 function delitem(val)
 {
     if (confirm(" حذف من النظام ؟")) {

        jQuery('#div_session_write').load('fun/include_fun_aseer_portal.php?del_item_value='+val);
        setTimeout(function(){
        window.location.reload(1);
        }, 1000);
    } else {
    // Do nothing!
    }

 }
 </script>
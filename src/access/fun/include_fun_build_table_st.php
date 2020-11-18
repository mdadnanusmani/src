<?php
  
    if(isset($_GET['td_id']))
    { 
        $td_id=$_GET['td_id'];
        $_SESSION['td_id']=$td_id;
    }
    if($_SESSION['td_id']!="")
        $td_id=$_SESSION['td_id'];
   else
   echo'<html lang="en"><head><meta http-equiv="refresh" content="0;URL=form_reg.php">';
   //echo '<script>alert('.$td_id.');</script>';
 //save insert
  if($_POST['submit'])
    {
        $option=trim($_POST['option']);
        $value=$_POST['value'];
        $table=$_SESSION['table_name'];
        $sql="select * from ".$table." where `option` ='$option' order by id";
        $q=mysql_query($sql) or die(mysql_error());
        $count=mysql_num_rows($q);
        if($count=='0')
        {            
            $sql="insert into ".$table." values(NULL,'$option','$value')";
            $q=mysql_query($sql) or die(mysql_error());
            $_SESSION['msg']='<div class="alert alert-info">Save Done</div>';
            echo '<html lang="en"><head><meta http-equiv="refresh" content="0.0001;URL=build_table_st.php">';
        }else
        {
            $_SESSION['msg']='<div class="alert alert-warning"> Category Already Exited </div>';
        }
    }
//edit and delete
if($_GET['op'] and $_GET['op']=="del")
{
$delid=$_GET['id'];
$table=$_SESSION['table_name'];

$sql="delete from ".$table." where id='$delid'";
$q=mysql_query($sql) or die(mysql_error());

$_SESSION['msg']='<div class="alert alert-warning">Remove Done</div>';
echo '<html lang="en"><head><meta http-equiv="refresh" content="1;URL=build_table_st.php">';


}else if($_GET['op'] and $_GET['op']=="edit")
{
$editid=$_GET['id'];

}
//edit Commit
if($_POST['edit_sub'])
{
   $eid=$_POST['id'];
   $table=$_SESSION['table_name'];
   $new_option= $_POST['new_option'];
   $new_value= $_POST['new_value'];
   $sql="update ".$table." set `option`='$new_option',`value`='$new_value' where id='$eid'";
   $q=mysql_query($sql) or die(mysql_error());
   $_SESSION['msg']='<div class="alert alert-info">Edit Done</div>';
   echo '<html lang="en"><head><meta http-equiv="refresh" content="1;URL=build_table_st.php">';
}

///////////////2222222222222222222222222
$sql_name="select name from generation_table where table_id='$td_id'";
$q_name=mysql_query($sql_name) or die(mysql_error());
$row_name_master=mysql_fetch_array($q_name);

//field
$name_field=$row_name_master[0];
$cat_field=$row_name_master[1];

//cat name
$cat_name="Generation Table";
//zeeeeeeeeeeeeeeeeeeeeeeeee
$sql="select * from gt_".$name_field."";
$q=mysql_query($sql) or die(mysql_error());
$row=mysql_fetch_array($q);
$count_master_cat=mysql_num_rows($q);

$sql2="SELECT MAX(id) FROM `gt_".$name_field."` AS MID";
$q1=mysql_query($sql2) or die(mysql_error());
$maxid=mysql_fetch_array($q1);
$maxid['MAX(id)']+=1;
$_SESSION['table_name']="gt_".$name_field."";



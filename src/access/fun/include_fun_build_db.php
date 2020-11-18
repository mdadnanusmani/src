
<?php

// inseeeeeeeeeeeeeeeeeeeeeeeeeeeeeeert
if(isset($_POST['submit']))
{

$table=$_POST['table'];
$table_lable=$_POST['table_lable'];
$descrption=$_POST['descrption'];
$menuid=$_POST['menuid'];
$sortby=$_POST['sortby'];
$linecolor=$_POST['linecolor'];
$notificition=$_POST['notificition'];
$report_view=$_POST['report_view'];


  if(mysql_num_rows(mysql_query("SHOW TABLES LIKE '$table'"))==1) 
  {    


  }else
  {
    $sql_create_table = 'CREATE TABLE `'.$table.'` ('
    . ' `id` INT(3) NOT NULL AUTO_INCREMENT PRIMARY KEY, '
    . ' `s_insertby` varchar(25) NOT NULL '
    . ' )'
    . ' ENGINE = myisam;';
    $q_create_table=mysql_query($sql_create_table) or die(mysql_error());        

  }

  if($linecolor=='')
  {
    $linecolor='No';
    $col='';
  }else
  {
      $col=$linecolor;
      $linecolor='Yes';
  }

$sql_insert="insert into `db` values(NULL,'$table','$table_lable','$descrption','$sortby','$menuid','0','$linecolor','$col','$notificition','$report_view')";
$q_insert=mysql_query($sql_insert) or die(mysql_error());


echo'<html lang="en"><head><meta http-equiv="refresh" content="0.000000001;URL=build_db.php">';
exit();
}

//deeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeel option

if(isset($_GET['op']) and $_GET['op']=="del")
{
  $delid=$_GET['id'];
  $rand=rand(1,5000);

  ///////
  $sql="select * from `db` where id='$delid'";
  $q=mysql_query($sql) or die(mysql_error());
  $row_del=mysql_fetch_array($q);

  ////////
  $sql_rename= 'RENAME TABLE `'.$row_del['name'].'` TO `zz_del_'.$row_del['name'].$rand.'`';
  $q_rename=mysql_query($sql_rename);  
  
  ////////
  $sql="delete from `db` where id='$delid'";
  $q=mysql_query($sql) or die(mysql_error());

  ///////
  $sql="select * from `zz_del_generation_table` where table_name='".$row_del['name']."'";
  $q=mysql_query($sql) or die(mysql_error());
  if(mysql_num_rows($q)==0)
  {
    $sql="insert into zz_del_generation_table (select * from generation_table where table_name='".$row_del['name']."')";
    $q=mysql_query($sql) or die(mysql_error());
    
    $sql="delete from generation_table where table_name='".$row_del['name']."'";
    $q=mysql_query($sql) or die(mysql_error());
  }else
  {

  }

  $_SESSION['msg']='<div class="alert alert-warning">تم الحذف بنجاح</div>';
  echo '<html lang="en"><head><meta http-equiv="refresh" content="1;URL=build_db.php">';
exit();
}else if($_GET['op'] and $_GET['op']=="edit")
{
$editid=$_GET['id'];
//Main Select For Edit Option
$sql_select_DT_edit="select * from db where id='$editid'";
$q_select_DT_edit=mysql_query($sql_select_DT_edit) or die(mysql_error());
$q_count_edit=mysql_num_rows($q_select_DT_edit);
$row_DT_edit=mysql_fetch_array($q_select_DT_edit);

}


//edit Commit
if($_POST['edit_sub'])
{

$eid=$_POST['id'];

$table_lable=$_POST['new_table_lable'];
$table=$_POST['new_table'];
$descrption=$_POST['new_descrption'];
$old_name=$_POST['old_name'];
$menuid=$_POST['new_menuid'];
$sortby=$_POST['new_sortby'];
$linecolor=$_POST['new_linecolor'];
$notificition=$_POST['new_notificition'];
$report_view=$_POST['new_report_view'];


  if($linecolor=='')
  {
    $linecolor='No';
    $col='';
  }else
  {
      $col=$linecolor;
      $linecolor='Yes';
  }

$sql="update `db` set notificition='$notificition',linecolor='$linecolor',tb_col='$col', `name`='$table',table_lable='$table_lable',descrption='$descrption',sortby='$sortby',`fillter`='$menuid',`report view`='$report_view' where id='$eid'";
$q=mysql_query($sql) or die(mysql_error());

$_SESSION['msg']='<div class="alert alert-info">Edit Done</div>';
echo '<html lang="en"><head><meta http-equiv="refresh" content="1;URL=build_db.php">';
exit();
}


//Main Select For Body

$sql_select_DT="select * from db";
$q_select_DT=mysql_query($sql_select_DT) or die(mysql_error());
$q_count=mysql_num_rows($q_select_DT);
$row_DT=mysql_fetch_array($q_select_DT);


//select all

$dbname=$_SESSION['dbname'];  
$sql_TABLE = "SHOW TABLES FROM db";
$result_table = mysql_query($sql_TABLE);
$result_intable = mysql_query($sql_TABLE);

?>

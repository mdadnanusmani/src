<?php

  // inseeeeeeeeeeeeeeeeeeeeeeeeeeeeeeert
  if(isset($_POST['submit']))
  {

  $table=$_POST['table'];
  $name=strtolower($_POST['name']);
  $labe=$_POST['label'];
  $type=$_POST['type'];
  $width=$_POST['width'];
  $required=$_POST['required'];  
  $font_size=$_POST['font_size'];
  $placeholder=$_POST['placeholder'];
  $defult_value=$_POST['default_value'];
  $intable=$_POST['intable'];
  $infield=$_POST['infield'];
  $disfield=$_POST['disfield'];
  $table_lable=$_POST['table_lable'];
  $ordernum=$_POST['ordernum'];
  $fenabling=$_POST['fenabling'];
  $refields=$_POST['refields'];
  $dbf_to=$_POST['dbf_to'];
  $dbf=$_POST['dbf'];
  $dbf_value=$_POST['dbf_value'];
  $refields_dis=$_POST['refields_dis'];

  if($ordernum=='')
  {
      $ordernum=get_max_order($table);
  }
  $name=str_replace(" ","_",$name);

    
    if(mysql_num_rows(mysql_query("SHOW TABLES LIKE '$table'"))==1)
    {

  
    }else
    {
      $sql_create_table = 'CREATE TABLE `'.$table.'` ('
      . ' `id` INT(3) NOT NULL AUTO_INCREMENT PRIMARY KEY '
      . ' )'
      . ' ENGINE = myisam;';
      $q_create_table=mysql_query($sql_create_table) or die(mysql_error());        

    }

  $sql_insert="insert into generation_table values(NULL,'$name','$type','$labe','$width','Yes','$font_size','$placeholder','$defult_value','$table','$intable','$infield','$disfield','$refields','$refields_dis','$required','$ordernum','$fenabling','$dbf','$dbf_to','$dbf_value')";
  $q_insert=mysql_query($sql_insert) or die(mysql_error());

  //new table for (select)
  if($type=="Select" || $type=="Check Box" || $type=="Related to table" || $type=="Related to Field")
  {
    $sql_inset_cat_dept = 'ALTER TABLE `'.$table.'` ADD `'.$name.'` INT(5) NOT NULL;';
    $q_insert_cat_dept=mysql_query($sql_inset_cat_dept) or die(mysql_error());

  }else
  {
    if($type=='HTML')
    {
        $sql_inset_cat_dept = 'ALTER TABLE `'.$table.'` ADD `'.$name.'` VARCHAR(9999) NOT NULL;';
    }else if($type=='Multi Select')
    {
        $sql_inset_cat_dept = 'ALTER TABLE `'.$table.'` ADD `'.$name.'` VARCHAR(9999) NOT NULL;';
    }
    else
    $sql_inset_cat_dept = 'ALTER TABLE `'.$table.'` ADD `'.$name.'` VARCHAR(200) NOT NULL;';
    $q_insert_cat_dept=mysql_query($sql_inset_cat_dept) or die(mysql_error());
  }


  if($type=="Select" || $type=="Check Box")
  {
  $sql_create_table = 'CREATE TABLE `gt_'.$name.'` ('
        . ' `id` INT(3) NOT NULL AUTO_INCREMENT PRIMARY KEY, '
        . ' `option` VARCHAR(500) NOT NULL, '
        . ' `value` VARCHAR(500) NOT NULL'
        . ' )'
        . ' ENGINE = myisam;';
  $q_create_table=mysql_query($sql_create_table) or die(mysql_error());
  }

  echo'<html lang="en"><head><meta http-equiv="refresh" content="0.000000001;URL=build_table.php">';
  exit();
  }

  //deeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeel option

if(isset($_GET['op']) and $_GET['op']=="del")
{

$delid=$_GET['id'];
$sql="select * from generation_table where table_id='$delid'";
$q=mysql_query($sql) or die(mysql_error());
$row=mysql_fetch_array($q);

$sql_drop= 'ALTER TABLE '.$row['table_name'].' DROP `'.$row['name'].'`';
$q_drop=mysql_query($sql_drop);

$sql="delete from generation_table where table_id='$delid'";
$q=mysql_query($sql) or die(mysql_error());

$_SESSION['msg']='<div class="alert alert-warning">تم الحذف بنجاح</div>';
echo '<html lang="en"><head><meta http-equiv="refresh" content="1;URL=build_table.php">';


}else if($_GET['op'] and $_GET['op']=="edit")
{
$editid=$_GET['id'];
}
//edit Commit
if($_POST['edit_sub'])
{
$eid=$_POST['id'];
$old_type=$_POST['old_type'];
$old_name=$_POST['old_name'];
$new_name=$_POST['new_name'];
$new_labe=$_POST['new_label'];
$new_label=$_POST['new_label'];
$type=$_POST['new_type'];
$new_type=$_POST['new_type'];
$new_width=$_POST['new_width'];
$new_required=$_POST['new_required'];  
$new_default_value=$_POST['new_default_value'];
$new_font_size=$_POST['new_font_size'];
$new_placeholder=$_POST['new_placeholder'];
$new_intable=$_POST['new_intable'];
$new_infield=$_POST['new_infield'];
$new_disfield=$_POST['new_disfield'];
$table_lable=$_POST['new_table_lable'];
$table_name=$_POST['table_name'];
$ordernum=$_POST['new_ordernum'];
$fenabling=$_POST['new_fenabling'];
$intable=$_POST['intable'];
$infield=$_POST['infield'];
$disfield=$_POST['disfield'];
$refields=$_POST['refields'];
$dbf_to=$_POST['new_dbf_to'];
$dbf=$_POST['new_dbf'];
$dbf_value=$_POST['new_dbf_value'];
  $refields_dis=$_POST['new_refields_dis'];



//echo $type."<br>".$old_type."<br>";
if($type!="Select" || $type!="Check Box" ||  $type=="Related to table" || $type=="Related to Field")
{
  $sql="update generation_table set refields_dis='$refields_dis',dbf_value='$dbf_value',dbf_to='$dbf_to',dbf='$dbf', refields='$refields', ordernum='$ordernum',name='$new_name',lable='$new_labe',type='$type',width='$new_width',placeholder='$new_placeholder',font_size='$new_font_size',default_value='$new_default_value',dis_fields='$new_disfield',required='$new_required',related_table='$intable',fields='$infield',dis_fields='$disfield',fenabling='$fenabling' where table_id='$eid'";
  $q=mysql_query($sql) or die(mysql_error());
  if($type=="HTML")
  $sql = 'ALTER TABLE `'.$table_name.'` CHANGE `'.$old_name.'` `'.$new_name.'` VARCHAR(99999999) NOT NULL';
  else if($type=="Text Area")
  $sql = 'ALTER TABLE `'.$table_name.'` CHANGE `'.$old_name.'` `'.$new_name.'` VARCHAR(200) NOT NULL';
  else
  $sql = 'ALTER TABLE `'.$table_name.'` CHANGE `'.$old_name.'` `'.$new_name.'` VARCHAR(50) NOT NULL';
  $q=mysql_query($sql) or die(mysql_error());

}else
{

  if($old_type!="Select" and $new_type=="Select" or $old_type !="Check Box" and $new_type =="Check Box")
  {

   $sql_create_table = 'CREATE TABLE `gt_'.$new_name.'` ('
        . ' `id` INT(3) NOT NULL AUTO_INCREMENT PRIMARY KEY, '
        . ' `option` VARCHAR(25) NOT NULL, '
        . ' `value` VARCHAR(25) NOT NULL'
        . ' )'
        . ' ENGINE = myisam;';
  $q_create_table=mysql_query($sql_create_table) or die(mysql_error());

  $sql = 'ALTER TABLE `'.$table_name.'` CHANGE `'.$old_name.'` `'.$new_name.'` INT(5) NOT NULL';
  $q=mysql_query($sql) or die(mysql_error());


  }else if($old_type=="Select" and $new_type=="Select" or $old_type=="Check Box" and $new_type=="Check Box")
    {
      if($old_name != $new_name)
      {
              $sql=' RENAME TABLE `gt_'.$old_name.'` TO `gt_'.$new_name.'`';
              $q=mysql_query($sql) or die(mysql_error());
              $sql = 'ALTER TABLE `'.$table_name.'` CHANGE `'.$old_name.'` `'.$new_name.'` INT( 5 ) NOT NULL';
              $q=mysql_query($sql) or die(mysql_error());

      }
    }
  $sql="update generation_table set refields_dis='$refields_dis',dbf_value='$dbf_value', dbf_to='$dbf_to',dbf='$dbf',refields='$refields',ordernum='$ordernum',type='$new_type',name='$new_name',lable='$new_label',width='$new_width',placeholder='$new_placeholder',font_size='$new_font_size',default_value='$new_default_value',required='$new_required',fenabling='$fenabling' where table_id='$eid'";
  $q=mysql_query($sql) or die(mysql_error());

}
  $_SESSION['msg']='<div class="alert alert-info">Edit Done</div>';
  echo '<html lang="en"><head><meta http-equiv="refresh" content="1;URL=build_table.php">';
  exit();
}


  //Main Select For Body

  $sql_select_DT="select * from generation_table  ORDER BY `table_id` DESC,`table_name`";
  $q_select_DT=mysql_query($sql_select_DT) or die(mysql_error());
  $q_count=mysql_num_rows($q_select_DT);
  $row_DT=mysql_fetch_array($q_select_DT);

 //Main Select For Edit Option
  $sql_select_DT_edit="select * from generation_table where table_id='$editid'";
  $q_select_DT_edit=mysql_query($sql_select_DT_edit) or die(mysql_error());
  $q_count_edit=mysql_num_rows($q_select_DT_edit);
  $row_DT_edit=mysql_fetch_array($q_select_DT_edit);
  //select all

$dbname=$_SESSION['dbname'];

//$sql_TABLE = "select * from `db`";
$sql_TABLE = "SELECT TABLE_NAME as name
FROM INFORMATION_SCHEMA.TABLES
WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='".$dbname."'
and TABLE_NAME not like '%zz_%'
and TABLE_NAME not like 'setting'
and TABLE_NAME not like 'generation_table'
";
//and TABLE_NAME not like 'users'
$result_table = mysql_query($sql_TABLE);
$result_intable = mysql_query($sql_TABLE);




function get_max_order($table)
{
    $sql_TABLE="select max(ordernum) as max_order FROM `generation_table` where table_name='$table'";
    $result_table = mysql_query($sql_TABLE);
    $result_row= mysql_fetch_array($result_table);
    if(mysql_num_rows($result_table)>0)
    {
        return $result_row['max_order']+1;
    }else
    {
        return 1;
    }
}

?>
<script type="text/javascript">
    function normal_vac_type()
    {

      var e = document.getElementById("type");
      var strUser = e.options[e.selectedIndex].value;
      var x = document.getElementById("myDIV");
      var xx = document.getElementById("myDIV2");

      if(strUser=="Related to table" || strUser=="Multi Select" || strUser=="Related to Field" || strUser=="List")
      {
          x.style.display = "block";
          xx.style.display = "block";
          if(strUser=='Related to Field')
          {
            var ee = document.getElementById("table");
            var strUsere = ee.options[ee.selectedIndex].value;
            jQuery('#myDIV2').load('jq.php?table='+strUsere);
          }else
          {
            xx.style.display = "none";
          }



      }else{
              x.style.display = "none";
              xx.style.display = "none";
          }

    }

function myFunction() {
    var x = document.getElementById("mySelect").value;
    document.getElementById("lableinput").value = "الرجاء إدخال " + x;
}
</script>


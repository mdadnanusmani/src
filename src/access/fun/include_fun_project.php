<?
@session_start();
if(isset($_POST['submit_portal_group']))
{
    $goto=$_POST['goto'];
    $name=$_POST['name'];
    $govname=$_POST['gov_name'];
    $comname=$_POST['com_name'];
    $price=$_POST['price'];
    $price_year=$_POST['price_year'];
    $time=$_POST['time'];
    $dates=$_POST['dates'];
    $datee=$_POST['datee'];
    $loc=$_POST['loc_name'];
    $status=$_POST['status'];

    $sql="insert into contract values('','$goto','$name','$price','$datee','$time','$comname','$loc','','','$govname','$price_year','$dates','$status')";
    //print_r($_POST);

    $q=mysql_query($sql) or die(mysql_error());
        $_SESSION['msg2']="تمت إضافة المشروع  بنجاح";
    $_SESSION['msg_type']="s";
    echo '<script>window.location = "project.php";</script>';


}
if(isset($_POST['submit_update']))
{
    $id=$_POST['id'];
    $goto=$_POST['goto'];
    $oldgoto=$_POST['old_goto'];
    $name=$_POST['name'];
    $govname=$_POST['gov_name'];
    $comname=$_POST['com_name'];
    $old_comname=$_POST['old_com_name'];
    $price=$_POST['price'];
    $price_year=$_POST['price_year'];
    $time=$_POST['time'];
    $dates=$_POST['dates'];
    $datee=$_POST['datee'];
    $loc=$_POST['loc_name'];
    $status=$_POST['status'];
    if($goto=='')
    {
         $goto=$oldgoto;
    }

    if($comname=='')
    {
        $comname=$old_comname;
    }



    $sql="update contract set main_id='$goto',name='$name',price='$price',date='$datee',time='$time',com_name='$comname',location='$loc',gov_name='$govname',year_price='$price_year' ,date_start='$dates',status='$status' where id='$id'";
     $q=mysql_query($sql) or die(mysql_error());
        $_SESSION['msg2']="تم التعديل بنجاح";
    $_SESSION['msg_type']="s";
    echo '<script>window.location = "project.php";</script>';

print_r($_POST);
 exit();
}

function select_con()
{
    $sql="select * from contract order by main_id";
    $q=mysql_query($sql) or die(mysql_error());
return $q;

}

function bind_select($dbval,$seval)
{
    if($dbval==$seval)
    return 'selected="selected"';
    else
    echo "";
}
if($_GET['del_value'])
{

   include "../administrator/config.php";
  // echo "elmgdaaaaaaaaaaaad".$_GET['del_value'];
   $id=$_GET['del_value'];
   $sql="delete from contract where id='$id'";
   $q=mysql_query($sql) or die(mysql_error());
   $_SESSION['msg2']="تم الحذف بنجاح";
   $_SESSION['msg_type']="s";
 // echo '<script>window.location = "aseer-portal.php";</script>';
}

function bind_aseer_portal_view($id)
{

    $sql="select * from main_serve where ID ='$id'";
    $q=mysql_query($sql) or die(mysql_error());
    $row = mysql_fetch_array($q);

    return $row['Name'];

}

function bind_com_name($id)
{

    $sql="select * from consolut where id ='$id'";
    $q=mysql_query($sql) or die(mysql_error());
    $row = mysql_fetch_array($q);

    return $row['name'];

}

function bind_goto($se)
{


$code='<input list="jobs" autocomplete="on"   class="form-control" name="goto">
<datalist id="jobs">
      ';
    $sql="select * from main_serve order by main_id";
    $qu=mysql_query($sql) or die(mysql_error());
    $ro=mysql_fetch_array($qu);
    do{
        $code.='<option value="'.$ro['ID'].'" '.bind_select($se,$ro['ID']).'>'.$ro['Name'].'</option>';
    }while($ro=mysql_fetch_array($qu));

    $code.='
       </datalist>
         ';

         return $code;


}

function bind_con($se)
{

$code='<input list="cons" autocomplete="on"  class="form-control" name="com_name">
<datalist id="cons">
      ';

    $sqq="select * from consolut ";
    $qq=mysql_query($sqq) or die(mysql_error());
    $r=mysql_fetch_array($qq);
    do{
        $code.='<option value="'.$r['id'].'" '.bind_select($se,$r['id']).'>'.$r['name'].'</option>';
    }while($r=mysql_fetch_array($qq));


    $code.='
       </datalist>
         ';

         return $code;
}

function bind_status($val)
{
    switch ($val)
    {
        case $val==1:
            return "منجزة";
        break;
        case $val==2:
            return "متقطعة";
        break;
        case $val==3:
            return "متوقفة";
        break;
        case $val==4:
            return "متاخرة";
        break;
        case $val==5:
            return "جارية";
        break;
        case $val==6:
            return "";
        break;
        case $val==7:
            return "";
        break;


    }
}



?>
<script>

function del(val)
 {
     if (confirm(" حذف من النظام ؟")) {

        jQuery('#div_session_write').load('fun/include_fun_project.php?del_value='+val);
        setTimeout(function(){
        window.location.reload(1);
        }, 1000);
    } else {
    // Do nothing!
    }

 }
</script>

<?
include "administrator/config.php";
if(isset($_REQUEST['table']))
{
    $tbale=$_REQUEST['table'];
    $value=$_REQUEST['value'];
    $fname=$_REQUEST['fname'];
    $dis=$_REQUEST['dis'];
    $putto=$_REQUEST['putto'];
    $lable=$_REQUEST['lable'];
    $redis=$_REQUEST['inserted'];
    $sq="select ".$redis.",".$_REQUEST['id'].",".$dis." from ".$tbale." where ".$_REQUEST['id']."=".$_REQUEST['value'];
    $q=mysql_query($sq);
    $row=mysql_fetch_array($q);
    $array_sqlquery_count=mysql_num_rows($q);

    	echo'
        <select name="'.$putto.'"  class="form-control select2">
        ';
        for($x=0;$x<$array_sqlquery_count;$x++)
        {
            echo '<option value="'.$row["".$_REQUEST['inserted'].""].'">'.$row["".$dis.""].'</option>';
            $row=mysql_fetch_array($q);
        }
        echo'</select>';
    //echo'<input type="text"  id="'.$putto.'" disabled="disabled" name="'.$putto.'"  class="form-control"  value="'.$row[$dis].'" >';
}
if(isset($_REQUEST['bind_view_fillter']) )
{
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
include "include.php";
chfun();

    include "fun/main_function.php";
    include "administrator/fun/funcat.php";
    include "fun/include_fun_bind.php";

$db=$_SESSION['db']=$_REQUEST['db']=$_SESSION['db'];

if($_REQUEST['action']=='2')
{
    $lable='عرض البيانات '.$lable;
}else if($_REQUEST['action']=='1')
{
    $lable='إدخال بيانات '.$lable;
}else if($_REQUEST['action']=='3')
{
    $lable=' '.$lable;
}
 if($_REQUEST['bind_view_fillter']=='')
 {
    $_REQUEST['bind_view_fillter']=-1;
 }

 //exit();
bind_view($db);

}
    if($_GET['count_sql'])
    {

        echo '
<div class="alert alert-mini alert-info margin-bottom-30"><!-- INFO -->
    <button type="button" class="close" data-dismiss="alert">
        <span aria-hidden="true">×</span>
        <span class="sr-only">Close</span>
    </button>
    <strong>العدد المتحصل عليه </strong>  &nbsp;:'.$_SESSION["total_records"].'
</div>
';
    }


?>
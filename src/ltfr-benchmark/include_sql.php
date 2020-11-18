<?
include "fun/fun_db.php";
include "administrator/config_or.php";
include "administrator/config.php";
include "administrator/fun/hijri.php";
$hijri_obj= new Hijri();
$k=array_search(basename($_SERVER['PHP_SELF']),$_SESSION['allow_pages']);
if( is_null(array_search(basename($_SERVER['PHP_SELF']),$_SESSION['allow_pages'])) && basename($_SERVER['PHP_SELF']) != 'jq.php' )
{
    echo '<script>window.location = "index.php";</script>';
    exit();
}
function select_from_table ($table,$where='',$field='',$value='',$op='=')
{

$sql="SELECT * FROM ".$table;

if($where!='')
$sql .= " where ".$field." ".$op." '".$value."'";


$stid = oci_parse($GLOBALS['conn'], $sql);
oci_execute($stid);
$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
//echo $row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
return $row;

}


function select_or_user ($emp)
{
$stid = oci_parse($GLOBALS['conn'], "SELECT * FROM emp_info_bonofide where EMP_NO='$emp'");
oci_execute($stid);
$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
return $row;

}
function select_tw_vac_user ($emp)
{
$stid = oci_parse($GLOBALS['conn'], "SELECT t.*,s.USER_NAME as manger_name,s.MGR as smgr FROM TW_USERS t left join TW_USERS s on t.MGR = s.USER_EMP  where t.USER_EMP='$emp'");
oci_execute($stid);
$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
return $row;

}
function select_user_vac($emp)
{
    $stid = oci_parse($GLOBALS['conn'], "SELECT * FROM PP_VACATIONS where EMP_NO='$emp' order by START_DATE desc");
    oci_execute($stid);
    return $stid;
}

function tw_users_data($emp)
{
    $stid = oci_parse($GLOBALS['conn'], "select USER_EMP,USER_NAME,PRO_NAME,DEP_NAME1,DEP_NAME,CENTER_NAME,PRO_NAME1,JOB_TITLE,MGR  from TW_USERS where USER_EMP='$emp'");
    oci_execute($stid);
    return $stid;
}

function select_all_or_user ()
{
$stid = oci_parse($GLOBALS['conn'], "SELECT * FROM emp_info_bonofide");
oci_execute($stid);
return $stid;
}

function bind_or_from_table($table,$field,$value,$or ='=',$return="row")
{

    $sql="SELECT * FROM $table";
    if($field != '')
    {
        $sql.=" where '$field' '$or' ".$value;
    }
   // echo $sql;
    $stid = oci_parse($GLOBALS['conn'], $sql);
    oci_execute($stid);
    if($return=="row")
    {
        $row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
        return $row;
    }
    else
    {
        return $stid;
    }
 }

function bind_or_user_select($emp,$or ='=',$where="",$return="row")
{

    $sql="SELECT * FROM emp_info_bonofide where EMP_NO ".$or." '$emp'";
    if($where != '')
    {
        $sql.=" and ".$where;
    }
   // echo $sql;
    $stid = oci_parse($GLOBALS['conn'], $sql);
    oci_execute($stid);
    if($return=="row")
    {
        $row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
        return $row;
    }
    else
    {
        return $stid;
    }
 }

 function insert_vac()
 {
     if($_POST['submit_add_vac'] && $_POST['submit_add_vac']!='')
    {

    $hijri_obj= new Hijri();
    $EMP_NO=$_SESSION['S_EMP_NO'];
    $INSERTDT=date("Y-m-d");
    $INSERTTIME=date("H:i");
    $replace_user=$_POST['replace'];
    $VAC_STARTDATE=$_POST['date'];
    $VAC_TYPE=$_POST['vac_type_one_select'];
    $VAC_TIME=$_POST['vac_time'];

    //$hijri_obj->GregorianToHijri(date("yyyy-mm-dd"),"yyyy-mm-dd");

    //echo $date = str_replace('-', '', $hijri_obj->GregorianToHijri(date("yyyy-mm-dd"),"yyyy-mm-dd"));
    exit();
    $sql="insert into PP_VACATIONS_TW (EMP_NO , VACATION_TYPE , VACATION_DAYS , START_DATE , END_DATE , INSERT_USER_NO ,INSERT_DT , LUSER_TIME , ASSIGNED_EMPLOYEE  ) values ('$EMP_NO','$VAC_TYPE','$VAC_TIME','1','2','$EMP_NO','','','$replace_user')"; //('$EMP_NO' , '$VAC_TYPE' , '$VAC_TIME' ,' 1' ,' 2 ',' $EMP_NO' ,'' ,'', '$replace_user')";
    $stid = oci_parse($GLOBALS['conn'], $sql);
    oci_execute($stid);

    /*
    $inserted_id=insert("vacations","vac_user_emp",$_SESSION['S_EMP_NO']);
    echo '<p dir="ltr">';
    update("vacations","vac_user_id",$_SESSION['S_ID'],"vac_id",$inserted_id);
    update("vacations","vac_send_date",date("Y-m-d"),"vac_id",$inserted_id);
    update("vacations","vac_last_active_date",date("Y-m-d"),"vac_id",$inserted_id);
    update("vacations","vac_time",$_POST['vac_time'],"vac_id",$inserted_id);
    update("vacations","vac_date_start",$_POST['date'],"vac_id",$inserted_id);
    update("vacations","vac_type_one",$_POST['vac_type_one_select'],"vac_id",$inserted_id);
    update("vacations","vac_type_two",$_POST['type'],"vac_id",$inserted_id);
    update("vacations","vac_replaced_user",$_POST['replace'],"vac_id",$inserted_id);
    //update("em_employess","PRO_vac_id",$_POST['pro'],"ID",$inserted_id);

    echo '</p>';
    */
    }
 }

function update_or($table,$field,$value,$w_field,$w_value,$op='=')
{
   if($_POST['emp_no']  && $_POST['jobcode'])
    {
    $job_row=select_from_table("job_name","where","ITEM_NO",$_POST['jobcode'],'=');

     $sql="update ".$table." set ".$field." = ".$job_row['ITEM_NO']." where  ".$w_field."  ".$op." ".$w_value."";
    

    $stid = oci_parse($GLOBALS['conn'], $sql);
    oci_execute($stid);
    return "1";
    }
    else
    {
        return "0";
    }
 }

 function update_or_vac($table,$field,$value,$w_field,$w_value,$op='=')
{
   $sql="update ".$table." set ".$field." = ".$value." where  ".$w_field."  ".$op." ".$w_value."";
   $stid = oci_parse($GLOBALS['conn'], $sql);
   oci_execute($stid);
    return "1";

}

?>
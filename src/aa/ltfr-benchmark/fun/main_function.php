<?
is_loged(); 
include "administrator/config_or.php";
include "administrator/config.php";
include "administrator/fun/hijri.php";
include "administrator/fun/SMS.php";
include "administrator/fun/pagination.php";
$hijri_obj= new Hijri();


function tw_users_data($emp)
{
    $stid = oci_parse($GLOBALS['conn'], "select *  from TW_USERS where USER_EMP='$emp'");
    oci_execute($stid);
    return $stid;
}
function tw_all_users_data()
{
    $stid = oci_parse($GLOBALS['conn'], "select *  from TW_USERS ");
    oci_execute($stid);
    return $stid;
}
function select_or_user ($emp)
{
    $stid = oci_parse($GLOBALS['conn'], "SELECT * FROM emp_info_bonofide where EMP_NO='$emp'");
    oci_execute($stid);
    $row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
    return $row;
}
function select_or_user_name ($emp)
{
    $stid = oci_parse($GLOBALS['conn'], "SELECT * FROM emp_info_bonofide where EMP_NO='$emp'");
    oci_execute($stid);
    $row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
    return $row['ENAME'];
}
function select_or_table ($table,$where="",$field="",$value="",$op="",$order_by="",$order_type="ASC")
{
    if($where=="")
    {
        if($order_by=="")
        {
           $sql="SELECT * FROM $table";

        }else
        {
            $sql= "SELECT * FROM $table order by $order_by $order_type";
        }
    }else
    {
        if($order_by=="")
        {
             $sql= "SELECT * FROM $table where $field $op $value";

        }else
        {
            $sql="SELECT * FROM $table where $field $op $value order by $order_by $order_type";
        }
    }

    $stid = oci_parse($GLOBALS['conn'],$sql);
    oci_execute($stid);
    return $stid;
}
function bind_select_vac_filds()
{
    $stid = oci_parse($GLOBALS['conn'], "select * from  VAC_FIELDS");
    oci_execute($stid);
    echo '<select name="vac_fileds" class="form-control pointer">';
    echo '<option value="">---</option>';
    while($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS))
    {
        echo "<option value='".$row['ID']."'>".$row['NAME']."</option>";
    }
    echo "</select>";
}

function bind_oprater()
{
    echo '<select name="opr" class="form-control pointer">
    <option value=">">أكبرمن </option>
    <option value=">=">أكبر من او يساوي</option>
    <option value="<">أقل من </option>
    <option value="<=">إقل من او يساوي</option>
    <option value="=">يساوي</option>
    </select>
    ';
}

function bind_oprater_show($value)
{
    if($value==">")
        $value= "أكبر من";
    if($value==">=")
        $value="أكبر من او يساوي";
    if($value=="<")
        $value= "أقل من";
    if($value=="<=")
        $value="أقل من";
    if($value=="=")
        $value= "يساوي";
    return $value;
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

 function bind_date($date)
 {
    return substr($date,0,4)."-".substr($date,4,2)."-".substr($date,6,2);
 }
  function change_date($data)
 {
   $data = date('d-m-Y',strtotime($data . "+1 days"));
   $hijri_obj= new Hijri();
   $datee = str_replace('-', '', $hijri_obj->GregorianToHijri(date("d-m-Y",strtotime($data)),"dd-mm-yyyy"));
   return $datee= substr($datee,4,4).substr($datee,2,2).substr($datee,0,2);
 }

 function change_date_h_g($data)
 {
   $hijri_obj= new Hijri();
   return $datee = $hijri_obj->HijriToGregorian($data,"DDMMYYYY");

 }

 function get_phone_number($emp)
 {
    $stid = oci_parse($GLOBALS['conn'], "SELECT * FROM TW_USERS where USER_EMP='$emp'");
    oci_execute($stid);
    $row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
    return $row['MOBILE'];
 }

 function get_emp_mgr_data($emp)
 {

    $stid=tw_users_data($emp);
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

?>
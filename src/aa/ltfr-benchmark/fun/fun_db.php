<?
include "administrator/config.php";

function select_sql($table,$fiald,$value,$op='=',$type='q',$limit_start='0',$limit_end='20')
{

    $sql="select * from ".$table." where ".$fiald." ".$op." ".$value." LIMIT ".$limit_start.",".$limit_end;
    //echo '<p dir="ltr">'.$sql.'</p>';
    $q=mysql_query($sql) or die();
    //print_r($row);
    if($type=='q')
    return $q;
    else
    {
    $row=mysql_fetch_array($q);
    return $row;
    }
//    $_SESSION[$row_name]=$row;
}

function select_all($table,$op='=',$type='q',$limit_start='0',$limit_end='20')
{

    $sql="select * from ".$table." LIMIT ".$limit_start.",".$limit_end;
    echo '<p dir="ltr">'.$sql.'</p>';
    $q=mysql_query($sql) or die();
    //print_r($row);
    if($type=='q')
    return $q;
    else
    {
    $row=mysql_fetch_array($q);
    return $row;
    }
//    $_SESSION[$row_name]=$row;
}
function get_status($vid)
{
	$q=select_sql("vacations","vac_id",$vid,"=",'r');
	$row_st=$q;
	    if (($row_st['vac_center_president_accept'] == 0 and $row_st['vac_user_manager_accept'] == 0) OR $row_st['vac_user_files_accept'] == 0 OR $row_st['vac_user_personnel_accept'] == 0) {
        	if ($row_st['vac_center_president_accept'] == 2 OR $row_st['vac_user_manager_accept'] == 2 OR $row_st['vac_user_files_accept'] == 2 OR $row_st['vac_user_personnel_accept'] == 2) {
                return 2;
            } else {
                return 0;
            }
        } elseif ($row_st['vac_center_president_accept'] == 2 OR $row_st['vac_user_manager_accept'] == 2 OR $row_st['vac_user_files_accept'] == 2 OR $row_st['vac_user_personnel_accept'] == 2) {
            return 2;
        } else {
            return 1;
        }

}

function sum_vac_this_user($emp_no)
{

    $sql="SELECT sum(`vac_time`) as vac_sum FROM `vacations` WHERE `vac_user_manager_accept` = '1' and `vac_user_files_accept` = '1' and `vac_user_personnel_accept` = '1' and `vac_user_emp` = '".$emp_no."' and `vac_date_start` LIKE '%".date("Y")."%'";
    return cus_query($sql,"row");


}



function cus_query($sql,$return='q')
{

    $mysql_query=mysql_query($sql) or die(mysql_error());
    if($return=='q')
    return $mysql_query;
    else
    {
    $row=mysql_fetch_array($mysql_query);
    return $row;
    }

}




?>
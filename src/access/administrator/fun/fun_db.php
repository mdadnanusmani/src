<?
function select($table,$fiald,$value,$op='=')
{
    con();
    $sql="select * from ".$table." where ".$fiald." ".$op." ".$value;
    $q=mysql_query($sql) or die();
    $row=mysql_fetch_array($q);
    return $row;
//    $_SESSION[$row_name]=$row;
}

function update($table,$new_field,$new_value,$fiald,$value,$op="=")
{
    if($new_value=="aseer_date")
    {
        $new_value=date("Y-m-d");
    }
    if($new_value=="aseer_time")  
    {
        $new_value=date("h:i:s");
    }
    $date=date("Y-m-d");
     $sql="update `".$table."` set `".$new_field."` = '".$new_value."' where `".$fiald."` ".$op." '".$value."'";
    //echo "<br>";
    $q=mysql_query($sql) or die(mysql_error());

}

function bind_drob_down($table,$field_name,$dis,$value)
{
$q=select($table,"ID",'-1',"!=","q");
$count=mysql_num_rows($q);
$row=mysql_fetch_array($q);
echo '
<select name="'.$field_name.'" >
';
for($x=1;$x<=$count;$x++)
{
    echo '<option value="'.$row[$value].'">'.$row[$dis].'</option>';
$row=mysql_fetch_array($q);
}
echo '</select>
';
}




function insert($table,$fiald,$value)
{

     $sql="insert into ".$table." (`".$fiald."`) VALUES ('".$value."')";

    $q=mysql_query($sql) or die(mysql_error());
    return  mysql_insert_id();
}

function del_db($table,$field,$value,$op='=',$fiald2='',$value2='',$op2='')
{

$sql="delete from ".$table." where ".$field." ".$op." '$value'";
if($fiald2!='')
{
    $sql .="and ".$fiald2." ".$op2." ".$value2 ;
}

$q=mysql_query($sql) or die(mysql_error());

}








?>
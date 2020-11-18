<?php
/////////////////////
if(isset($_POST['submit']))
{
@session_start();
function insert_dept()
{
	@session_start();
	//Get Field name
	$total=$_SESSION['total'];
	for($x=1;$x<$_SESSION['total']+1;$x++)
	{
		$field=$field.$_SESSION['formvar'][$x];
			if($x!=$total)
			{
				$field=$field.",";
			}
	}

	for($x=1;$x<$_SESSION['total']+1;$x++)
	{
            if(is_array($_POST[$_SESSION['formvar'][$x]]))
            {
                $matstring="'".implode(",",$_POST[ $_SESSION['formvar'][$x]])."'";
                $values.=$matstring;
            }
			else
			{
				$_POST[$_SESSION['formvar'][$x]]=mysql_real_escape_string($_POST[ $_SESSION['formvar'][$x]]);
				//$_POST[ $_SESSION['formvar'][$x]]=str_replace($bad_symbols, "",$_POST[ $_SESSION['formvar'][$x]]);
				$values=$values."'".$_POST[ $_SESSION['formvar'][$x]]."'";
			}

			if($x!=$total)
			{
				$values=$values.",";
			}
	}

	$db=$_SESSION['db'];
	$sql="insert into ".$db." (".$field.") values(".$values.") ";

    $q=mysql_query($sql) or die(mysql_error());

	$_SESSION['lastinsertid']=mysql_insert_id();
	$_SESSION['msg']="تم التسجيل بنجاح شكراً";

    /////////
    $r=mysql_fetch_array( mysql_query("select * from `db` where name = '".$db."'"));
    $userid=$_SESSION['S_USERID'];
    $sq=mysql_query("select * from users where notificition =1 and id!='$userid'") or die(mysql_error());
    $ro=mysql_fetch_array($sq);
    do
    {
        $usid=$ro['id'];
        $dbid=$r['id'];
        $q=mysql_query("update `notificition` set lastinsert='1' where userid='$usid' and db='$dbid'");
    }while($ro=mysql_fetch_array($sq));
    ////////
    add_log($dbid,2,$_SESSION['S_USERID'],$_SESSION['lastinsertid']);
    echo'<html lang="en"><head><meta http-equiv="refresh" content="0;URL=route.php">';
	exit();
}

///////////////////////////// My Nigaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
insert_dept();
////////////////////////////

}
/////////////////////
if(isset($_POST['update']))
{

function insert_dept()
{
	//print_r($_POST);
	$db=$_SESSION['db'];
	$sql="update ".$db." set ";
	
	//Get Field name
	$total=$_SESSION['total'];	
	
	for($x=1;$x<$_SESSION['total']+1;$x++)
	{
        $remove[] = "'";
        $remove[] = '"';
        $remove[] = "-"; // just as another example
		$_POST[ $_SESSION['formvar'][$x]] = str_replace( $remove, "", $_POST[ $_SESSION['formvar'][$x]] );
				
	    $field=$field.$_SESSION['formvar'][$x];
        if(is_array($_POST[ $_SESSION['formvar'][$x]]))
        {
            $matstring="'".implode(",",$_POST[ $_SESSION['formvar'][$x]])."'";
            $values=$matstring;
        }
		else
            $values="'".$_POST[ $_SESSION['formvar'][$x]]."'";

			if($x!=$total)
			{
				//echo $x;
				$sql.=" `".$_SESSION['formvar'][$x]."`=".$values.",";
			}else
			{
				$sql.=" `".$_SESSION['formvar'][$x]."`=".$values." where id='".$_POST['id']."'";
				//echo "end";
			}
	}

	//echo $sql="insert into ".$db." (".$field.") values(".$values.") ";
	$q=mysql_query($sql) or die(mysql_error());
	$_SESSION['lastinsertid']=mysql_insert_id();
	$_SESSION['msg']="تم تعديل البيانات بنجاح شكراً";
    ///////////
    $r=mysql_fetch_array( mysql_query("select * from `db` where name = '".$db."'"));
    $userid=$_SESSION['S_USERID'];
    $sq=mysql_query("select * from users where notificition =1 and id!='$userid'") or die(mysql_error());
    $ro=mysql_fetch_array($sq);
    do
    {
        $usid=$ro['id'];
        $dbid=$r['id'];
        $q=mysql_query("update `notificition` set lastupdate='1' where userid='$usid' and db='$dbid'");
    }while($ro=mysql_fetch_array($sq));
    ///////////////
    add_log($dbid,3,$_SESSION['S_USERID'],$_POST['id']);
	echo'<html lang="en"><head><meta http-equiv="refresh" content="0;URL=route.php">';
	exit();                                   
}

///////////////////////////// My Nigaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
insert_dept();
////////////////////////////

}
//@session_destroy();
//@session_start();
/////////////////////

function array_fillter($val)
{
$va='';
foreach ($val as $v)
{
    $va.=$v.',';
}
return $va;
}

///////////////////
$_SESSION['total']=0;

$_SESSION['totalmain']=0;

$var = array(30);

$varmina = array(30);

$_SESSION['formvar'] = array(30);

$_SESSION['formvarmain'] = array(30);

///////////////////////

function totamain($name)
{
	$_SESSION{'totalmain'};
	$_SESSION['totalmain']+=1;
	$t= $_SESSION['totalmain'];
	//$var[$_SESSION['total']]=$name;
	$_SESSION['formvarmain'][$t]=$name;
}

function tota($name)
{
	$_SESSION{'total'};
	$_SESSION['total']+=1;
	$t= $_SESSION['total'];
	//$var[$_SESSION['total']]=$name;
	$_SESSION['formvar'][$t]=$name;
}
///////////////////////
//Bing <hr> Line

function bindhr()
{
    echo "<hr>";
}
//bind <br>
function bindbr()
{
    echo "<br>";
}
/////////////////////////

//SqlQuery From Table
function sqlquery_items($op1,$table)
{
	$sql_statment="select ".$op1." from ".$table."";
	$query=mysql_query($sql_statment) or die(mysql_error());
	$array_sqlquery=mysql_fetch_array($query);
	$array_sqlquery_count=mysql_num_rows($query);
	return $array_sqlquery;
}

//SqlQuery For Count off row

function sqlquery_count($table)
{
	$sql_statment="select COUNT(id) AS count from ".$table."";
	$query=mysql_query($sql_statment) or die(mysql_error());
	$array_sqlquery=mysql_fetch_array($query);
	return $array_sqlquery[0];
}

//Form Binding
function bindform($lable,$font_size,$action,$method)
{
	echo'<div class="container" dir="rtl">
	<div class="row">
	<div class="col-lg-12">
	<section class="panel">
	<header class="panel-heading">
	<h2 class="panel-title"><b><span style="font-size: '.$font_size.'px">'.$lable.'</span></b></h2>
	</header>
	<div class="panel-body">
	<form class="form-horizontal form-bordered" name="maininsertform" action="'.$action.'" method="'.$method.'" enctype="multipart/form-data">
	';
}

//Main Details
function bindmain($lable,$name,$wid)
{
	$sql_statment="select * from cat_master";
	$query=mysql_query($sql_statment) or die(mysql_error());
	$array_sqlquery=mysql_fetch_array($query);
	$array_sqlquery_count=mysql_num_rows($query);
	echo'<div class="form-group">
	<label class="col-md-3 control-label">'.$lable.'&nbsp;<span style="color: #CC0000">*</span></label>
	<div class="col-md-'.$wid.'">
	<select name="'.$name.'" data-plugin-selectTwo class="form-control populate" data-plugin-options="{ "minimumInputLength": 2 }">
	';

	for($x=0;$x<$array_sqlquery_count;$x++)
	{
		$master_id=$array_sqlquery[0];
		echo'<optgroup label="'.$array_sqlquery[1].'">';
		$sql_statment_dept="select * from cat_dept where cat_id='$master_id'";
		$query_dept=mysql_query($sql_statment_dept) or die(mysql_error());
		$count_dept=mysql_num_rows($query_dept);
		if($count_dept!=0)
		{
			$array_sqlquery_dept=mysql_fetch_array($query_dept);
		do
		{
		echo '<option value="'.$array_sqlquery_dept[0].'">'.$array_sqlquery_dept[2].'</option>';
		}while($array_sqlquery_dept=mysql_fetch_array($query_dept));

		}else
		{
		
		}
	echo'</optgroup>';
	$array_sqlquery=mysql_fetch_array($query);
	}

	echo'</select></div></div>';
	totamain($name);
}
function bindmultilist($table,$name,$lable,$wid,$thems,$font_size,$req,$show='',$val='',$select='')
{
    $select = explode(',', $select);
	$sql_statment="select * from ".$table." order by id";
	$query=mysql_query($sql_statment) or die(mysql_error());
	$array_sqlquery=mysql_fetch_array($query);
	$array_sqlquery_count=mysql_num_rows($query);
	echo'
	<div class="form-group ">
	<div class=" col-md-'.$wid.' col-sm-6">
		<label><span style="font-size: '.$font_size.'px">'.$lable.'</span>&nbsp; *</label>
		<select  id="'.$name.'"  name="'.$name.'[]" '.$req.' class="form-control" separator="," id="" multiple>
       
        ';

		for($x=0;$x<$array_sqlquery_count;$x++)
		{

			if(in_array($array_sqlquery["".$val.""], $select))
				echo '<option selected value="'.$array_sqlquery["".$val.""].'">'.$array_sqlquery["".$show.""].'</option>';
			else
				echo '<option value="'.$array_sqlquery["".$val.""].'">'.$array_sqlquery["".$show.""].'</option>';
			$array_sqlquery=mysql_fetch_array($query);
		}
		echo'</select>';
        echo'</div></div>';
    	tota($name);

}
function bind_List($table,$name,$lable,$wid,$thems,$font_size,$req,$show='',$val='',$select='',$refields='',$redis='')
{

	$sql_statment="select * from ".$table." ".$order;
	$query=mysql_query($sql_statment) or die(mysql_error());
	$array_sqlquery=mysql_fetch_array($query);
	$array_sqlquery_count=mysql_num_rows($query);
	echo'
	<div class="form-group " >
	<div class=" col-md-'.$wid.' col-sm-6">
		<label><span style="font-size: '.$font_size.'px">'.$lable.'</span>&nbsp; *</label>
	';
    $ra=rand(0,100);
		echo'
		<input id="'.$name.'"  name="'.$name.'" '.$req.' class="form-control" list="'.$name.$ra.'" value="'.$select.'">
         <datalist id="'.$name.$ra.'">

		';
		for($x=0;$x<$array_sqlquery_count;$x++)
		{
			echo '<option >'.$array_sqlquery["".$show.""].'</option>';
			$array_sqlquery=mysql_fetch_array($query);
		}
		echo'</datalist>';

    ///////////////////////////////////////////////////////
	echo'</div></div>';
	tota($name);
}
//Bind Combo Box From DateBase
function bindlist($table,$name,$lable,$wid,$thems,$font_size,$req,$show='',$val='',$select='',$refields='',$redis='')
	{
    

    if($thems=='Related to Field')
        $gfv=get_fields_value($refields,$table,$name,$val,$show,$lable,$redis);
	//$name=$table;
    if($thems=='Select' || $thems=="Multi Select")
        $order=' order by id';
	 $sql_statment="select * from ".$table." ".$order;
	$query=mysql_query($sql_statment) or die(mysql_error());
	$array_sqlquery=mysql_fetch_array($query);
	$array_sqlquery_count=mysql_num_rows($query);
	echo'
	<div class="form-group " >
	<div class=" col-md-'.$wid.' col-sm-6">
		<label><span style="font-size: '.$font_size.'px">'.$lable.'</span>&nbsp; *</label>
	';
//////////////////////////////////////////////

if($thems=="Multi Select")
	{
		echo'
		<select id="'.$name.'"  name="'.$name.'" '.$req.' class="form-control">
	   <!--	<option disabled="disabled" selected >الرجاء الاختيار</option> -->
		';
		for($x=0;$x<$array_sqlquery_count;$x++)
		{
			if($select==$array_sqlquery["".$val.""])
				echo '<option selected value="'.$array_sqlquery["".$val.""].'">'.$array_sqlquery["".$show.""].'</option>';
			else
				echo '<option value="'.$array_sqlquery["".$val.""].'">'.$array_sqlquery["".$show.""].'</option>';
			$array_sqlquery=mysql_fetch_array($query);
		}
		echo'</select>';
	}
//////////////////////////////
    if($thems=="Related to table")
	{
		echo'
		<select id="'.$name.'"  name="'.$name.'" '.$req.' class="form-control select2">

		';
		for($x=0;$x<$array_sqlquery_count;$x++)
		{
			if($select==$array_sqlquery["".$val.""])
				echo '<option selected value="'.$array_sqlquery["".$val.""].'">'.$array_sqlquery["".$show.""].'</option>';
			else
				echo '<option value="'.$array_sqlquery["".$val.""].'">'.$array_sqlquery["".$show.""].'</option>';
			$array_sqlquery=mysql_fetch_array($query);
		}
		echo'</select>';
	}
//////////////////////////////
    if($thems=="Related to Field")
	{

    	echo' <div id="'.$name.'">
		<select id="'.$name.'"  name="'.$name.'" '.$req.' class="form-control select2">

		';
		for($x=0;$x<$array_sqlquery_count;$x++)
		{
			if($select==$array_sqlquery["".$val.""])
				echo '<option selected value="'.$array_sqlquery["".$val.""].'">'.$array_sqlquery["".$show.""].'</option>';
			else
				echo '<option value="'.$array_sqlquery["".$val.""].'">'.$array_sqlquery["".$show.""].'</option>';
			$array_sqlquery=mysql_fetch_array($query);
		}
		echo'</select></div>';
	}
/////////////////////////////////////////////////
	if($thems=="Select")
	{
		echo'
		<select id="'.$name.'"  name="'.$name.'" '.$req.' class="form-control">
	   
		';
		for($x=0;$x<$array_sqlquery_count;$x++)
		{
			if($select==$array_sqlquery[0])
				echo '<option value="'.$array_sqlquery[0].'" selected>'.$array_sqlquery[1].'</option>';
			else			
				echo '<option value="'.$array_sqlquery[0].'">'.$array_sqlquery[1].'</option>';
			$array_sqlquery=mysql_fetch_array($query);
		}
		echo'</select>';
	}
/////////////////////////////////////////////////////
	if($thems=="Check Box")
	{
		for($x=0;$x<$array_sqlquery_count;$x++)
		{
		if($x==5 || $x==10 || $x==15|| $x==20|| $x==25|| $x==30 || $x==35)
			echo "<br>";
			if($select==$array_sqlquery[1])
				echo '<input  id="'.$name.'"  name="'.$name.'" value="'.$array_sqlquery[1].'" type="checkbox" selected>'.$array_sqlquery[2]."&nbsp;&nbsp;";
			else
				echo '<input id="'.$name.'"  name="'.$name.'" value="'.$array_sqlquery[1].'" type="checkbox">'.$array_sqlquery[2]."&nbsp;&nbsp;";
			$array_sqlquery=mysql_fetch_array($query);
		}
	}
///////////////////////////////////////////////////////
	echo'</div></div>';
	tota($name);
}

//Bind <input type="text" />
function bind_hidden()
{
	echo'<input type="hidden" name="s_insertby" class="form-control"  value="'.$_SESSION['S_USERNAME'].'" >';
	tota('s_insertby');
}
//Bind <input type="text" />
function bindtext($name,$lable,$value,$place,$wid,$font_size,$req,$dis)
{
	echo'
		<div class="form-group" id="'.$name.'">
			<div class="col-md-'.$wid.' col-sm-6">
				<label><span style="font-size: '.$font_size.'px">'.$lable.'</span>&nbsp; *</label>
				<input type="text"  id="'.$name.'"  name="'.$name.'" '.$dis.' class="form-control" placeholder="'.$place.'"  value="'.$value.'" '.$req.' title="'.$place.'">
			</div>
		</div>

				';
    if($dis=='')
	    tota($name);
}
//bind number
function bindnumber($name,$lable,$value,$place,$wid,$font_size,$req,$dis)
{
	echo'
		<div class="form-group" id="'.$name.'">
			<div class="col-md-'.$wid.' col-sm-6">
				<label><span style="font-size: '.$font_size.'px">'.$lable.'</span>&nbsp; *</label>
				<!--
<input type="number" name="'.$name.'" class="form-control" placeholder="'.$place.'" step="0.01" min="0" value="'.$value.'" '.$req.' title="'.$place.'">
    -->
				<input type="text" id="'.$name.'"  name="'.$name.'" '.$dis.' class="form-control stepper" min="0"  placeholder="'.$place.'"  value="'.$value.'" '.$req.' title="'.$place.'">
			</div>
		</div>
	
				';

    if($dis=='')
	    tota($name);
}

function bindpass($name,$lable,$value,$place,$wid,$font_size,$req)
{
	echo '
	<div class="form-group" id="'.$name.'">
	<label class="col-md-3 control-label" for="inputDefault"><span style="font-size: '.$font_size.'px">'.$lable.'</span>&nbsp;<span style="color: #CC0000">*</span></label>
	<div class="col-md-'.$wid.'">
	<input type="password" class="form-control"  id="'.$name.'"  placeholder="'.$place.'" name="'.$name.'" value="'.$value.'" required title="طول كلمة المرور من 5 ال 10 حروف" pattern=".{5,10}">
	</div>
	</div>';

	tota($name);
}


function bindtextmain($name,$lable,$value,$place,$wid)
	{
	echo '
	<div class="form-group" id="'.$name.'">
	<label class="col-md-3 control-label" for="inputDefault">'.$lable.'&nbsp;<span style="color: #CC0000">*</span></label>
	<div class="col-md-'.$wid.'">
	<input type="text" class="form-control"  id="'.$name.'" " placeholder="'.$place.'" name="'.$name.'" value="'.$value.'" '.$req.'>
	</div>
	</div>';
	totamain($name);
}

//Bind <textarea name="" id="" cols="??" rows="??"></textarea>
function bindtextarea($name,$lable,$value,$place,$wid,$font_size,$req)
	{

	echo'<div class="form-group" id="'.$name.'">
			<div class="col-md-'.$wid.' col-sm-6">
				<label><span style="font-size: '.$font_size.'px">'.$lable.'</span>&nbsp; *</label>								
				<textarea name="'.$name.'" id="'.$name.'"  '.$req.' class="form-control" placeholder="'.$place.'" rows="'.$row.'" id="textareaDefault">'.$value.'</textarea>
			</div>
		</div>';
	tota($name);
}

//bind uploder

function binduploder()
{
    echo'								<div class="form-group">
											<label class="col-md-3 control-label">Photos</label>
											<div class="col-md-6">
												<div class="fileupload fileupload-new" data-provides="fileupload">
													<div class="input-append">
														<div class="uneditable-input">
															<i class="fa fa-file fileupload-exists"></i>
															<span class="fileupload-preview"></span>
														</div>
														<span class="btn btn-default btn-file">
                                                        <h6>You can upload up to 8<br> photos Maximum photo size is 5 MB</h6>
															<input type="file" />
															<input type="file" />
															<input type="file" />
															<input type="file" />
															<input type="file" />
															<input type="file" />
															<input type="file" />
															<input type="file" />
															<input type="file" />
														</span>
													</div>
												</div>
											</div>
										</div>';
}

//bind Phone

function bindphone($name,$lable,$value,$place,$wid,$font_size,$req)
{
    echo'<div class="form-group" id="'.$name.'">
	<label class="col-md-3 control-label"><span style="font-size: '.$font_size.'px">'.$lable.'</span> <span style="color: #CC0000">*</span></label>
	<div class="col-md-'.$wid.' control-label">
	<div class="input-group">
	<span  class="input-group-addon">
	<i class="fa fa-phone"></i>
	</span>
	<input id="phone" '.$req.' id="'.$name.'"  name="'.$name.'" value="'.$value.'" placeholder="'.$place.'" class="form-control">
	</div></div></div>';
tota($name);

}

//bind email
function bindemil($name,$lable,$value,$place,$wid,$req)
{
    echo'
    <div class="form-group" id="'.$name.'">
											<label class="col-md-3 control-label">'.$lable.' <span style="color: #CC0000">*</span></label>
											<div class="col-md-'.$wid.'">
												<div class="input-group mb-md">
													<span class="input-group-addon">
														<i class="fa fa-envelope"></i>
													</span>
													<input '.$req.' type="email" name="'.$name.'"  id="'.$name.'"  value="'.$value.'" class="form-control" placeholder="'.$place.'">
												</div>
											</div>
										</div>
    ';
tota($name);

}
//bind date

//Bind <input type="text" />
function binddatetime($name,$lable,$value,$place,$wid,$font_size,$req)
{
	echo'
		<div class="form-group" id="'.$name.'">
			<div class="col-md-'.$wid.' col-sm-6">
				<label><span style="font-size: '.$font_size.'px">'.$lable.'</span>&nbsp; *</label>
				<input '.$req.' type="text" name="'.$name.'" value="'.$value.'"  id="'.$name.'"  class="form-control masked" placeholder="DD/MM/YYYY 00:00:00" data-format="99/99/9999 99:99" data-placeholder="_" >
			</div>
		</div>
	';
	tota($name);
}

//Bind <input type="text" />
function bindhtml($name,$lable,$value,$place,$wid,$font_size,$req)
{
	echo'
		<div class="form-group" id="'.$name.'">
			<div class="col-md-'.$wid.' col-sm-6">
				<label><span style="font-size: '.$font_size.'px">'.$lable.'</span>&nbsp; *</label>
<textarea  name="'.$name.'"  id="'.$name.'"  class="summernote  form-control" data-height="300" rows="10" data-lang="en-US" >'.$value.'</textarea>
			</div>
		</div>
	';
	tota($name);
}
/////////////////////
function bindmap($name,$lable,$value,$place,$wid,$font_size,$req)
{
    $val="'".$name."'";
    $s1=$wid/2;
    $s2=$wid/2;
    $_SESSION['bind_map']=1;

	echo'

		<div class="form-group">
			<div class="col-md-'.$s1.' col-sm-3">
				<label><span style="font-size: '.$font_size.'px">'.$lable.'</span>&nbsp; *</label>
                <input type="text" name="'.$name.'"  required="required" id="qwe" value="'.$value.'" class="form-control">
			</div>
    	</div>
		<div class="form-group">
			<div class="col-md-'.$s1.' col-sm-3">
    		   
                <br>
                <button type="button" id="hidebtn" style="display: none" onclick="hide_map('.$val.')" class="btn btn-primary" >إخفاء  الخاريطة</button>
                <button type="button" id="showbtn" onclick="show_map('.$val.')" class="btn btn-primary" >فتخ الخاريطة</button>
			</div>
    	</div>
    <script>
    function show_map(name)
    {
        document.getElementById(name).style.display = "block";
        document.getElementById("hidebtn").style.display = "block";
        document.getElementById("showbtn").style.display = "none";
    }
    function hide_map(name)
    {
        document.getElementById(name).style.display = "none";
        document.getElementById("hidebtn").style.display = "none";
        document.getElementById("showbtn").style.display = "block";
    }

    </script>
	';
    include"administrator/fun/maps.php";
    bind_modeel($name,$lable,$value);
	tota($name);
}
/////////////////

//Bind <input type="text" />
function binddate($name,$lable,$value,$place,$wid,$font_size,$req)
{

	echo'
		<div class="form-group" id="'.$name.'">
			<div class="col-md-'.$wid.' col-sm-6">
				<label><span style="font-size: '.$font_size.'px">'.$lable.'</span>&nbsp; *</label>
				<input '.$req.' type="text" id="'.$name.'"  name="'.$name.'" value="'.$value.'" class="form-control masked" placeholder="DD/MM/YYYY" data-format="99/99/9999" data-placeholder="_" >
			</div>
		</div>
	';

	tota($name);
}

//Bind <input type="text" />
function bindtime($name,$lable,$value,$place,$wid,$font_size,$req)
{

	echo'
		<div class="form-group" id="'.$name.'">
			<div class="col-md-'.$wid.' col-sm-6">
				<label><span style="font-size: '.$font_size.'px">'.$lable.'</span>&nbsp; *</label>
				<input dir="ltr" '.$req.' type="text" id="'.$name.'" name="'.$name.'" value="'.$value.'" class="form-control timepicker" >
			</div>
		</div>


    ';

	tota($name);
}



//bind Contact
function bindcontact($name,$lable,$wid)
{
	echo'<div class="form-group">
	<label class="col-sm-3 control-label">'.$lable.'</label>
	<div class="col-md-'.$wid.'">
	<div class="radio-custom">
	<label for="radioExample1">Both</label>&nbsp;<input type="radio" id="radioExample1" name="'.$name.'" value="Both">
	<label for="radioExample1">Phone</label>&nbsp;<input type="radio" id="radioExample1" name="'.$name.'" value="Phone">
	<label for="radioExample1">E-mail</label>&nbsp;<input type="radio" id="radioExample1" name="'.$name.'" value="E-mail">
	</div>
	</div>
	</div>';
	tota($name);
}

//bind Submit Area
function bindsubmit($name,$value,$wid,$update='')
{
	if($update!='')
	echo '<input type="hidden" name="id" value="'.$update.'">';

    if($_SESSION['bind_map']==1)
        $st='style="display: none"';
    else
        $st='';
        $_SESSION['bind_map']='';
        
		echo'<div class="row" id="submitbtn" '.$st.'>
			<div class="col-md-'.$wid.'">
				<button type="submit" name="'.$name.'"  value="'.$value.'"  class="btn btn-3d btn-teal btn-xlg btn-block margin-top-30">
					'.$value.'
					<span class="block font-lato"></span>
				</button>
			</div>
		</div>';

}

//bind end off Form
function bindformend()
{
echo'</form></div></section></div></div></div>';
}

function bind($table,$select_list='gt')
{
   
	$sqt="select * from db where name='$table'";
	$qut=mysql_query($sqt) or die(mysql_error());
	$row_update_t=mysql_fetch_array($qut);
    if($row_update_t['page_style']==2)
    {
	    $table=$_SESSION['db'];
		$s_insertby=$_SESSION['S_USERNAME'];
	    $sq="select * from `".$table."` where s_insertby='$s_insertby'";
		$qu=mysql_query($sq) or die(mysql_error());
		$row_update_data=mysql_fetch_array($qu);
        $row_update_data_count=mysql_num_rows($qu);
        if($row_update_data_count==1)
            {
              $_GET['op']='update';
              $_GET['row']= $row_update_data['id'];
            }
    }

    if(isset($_GET['op']) && $_GET['op']!='' && $_GET['op']=='update' && isset($_GET['row']) && $_GET['row']!='')
	{

	    $table=$_SESSION['db'];
		$tid=$_GET['row'];
	    $sq="select * from `".$table."` where id='$tid'";
		$qu=mysql_query($sq) or die(mysql_error());
		$row_update_data=mysql_fetch_array($qu);
       // print_r($row_update_data);
        $row_update_data_count=mysql_num_rows($qu);
	}
    $event=array();
    $re_event=bind_event($table);
    if($re_event!=-1)
    $event=unserialize($re_event);
    else
    unset($event);



	$sql="select * from generation_table where table_name='$table' order by ".$row_update_t['sortby'];
	$q=mysql_query($sql) or die(mysql_error());
	$row_generatoin=mysql_fetch_array($q);
	$count=mysql_num_rows($q);

	if($count<1)
	{
		return 0;
	}


    if($row_update_t['dbnote']!='')
        design_noti_warning($row_update_t['dbnote']);
    echo '<form  action="" method="post" enctype="multipart/form-data" >';
    bind_hidden();
	for($x=0;$x<=$count ;$x++)
	{
		if($row_generatoin['required']=='Yes')
			$row_generatoin['required']='required="required"';
		else
			$row_generatoin['required']='';
       	if(isset($_GET['op']) && $_GET['op']!='' && $_GET['op']=='update' && isset($_GET['row']) && $_GET['row']!='')
	    {
    		if($row_generatoin['fenabling']=='2')
    			$row_generatoin['fenabling']='disabled="disabled"';
    		else
    			$row_generatoin['fenabling']='';
        }else
        {
            $row_generatoin['fenabling']='';
        }





	if($row_generatoin['type']=="Text Area")
	{
		if(isset($_GET['op']) && $_GET['op']!='' && $_GET['op']=='update' && isset($_GET['row']) && $_GET['row']!='')
			bindtextarea($row_generatoin['name'],$row_generatoin['lable'],$row_update_data[$row_generatoin['name']],$row_generatoin['placeholder'],$row_generatoin['width'],$row_generatoin['font_size'],$row_generatoin['required']);
		else
			bindtextarea($row_generatoin['name'],$row_generatoin['lable'],$row_generatoin['default_value'],$row_generatoin['placeholder'],$row_generatoin['width'],$row_generatoin['font_size'],$row_generatoin['required']);
	}

	//////
	if($row_generatoin['type']=="Text" || $row_generatoin['type']=="Username")
	{
		if(isset($_GET['op']) && $_GET['op']!='' && $_GET['op']=='update' && isset($_GET['row']) && $_GET['row']!='')
			bindtext($row_generatoin['name'],$row_generatoin['lable'],$row_update_data[$row_generatoin['name']],$row_generatoin['placeholder'],$row_generatoin['width'],$row_generatoin['font_size'],$row_generatoin['required'],$row_generatoin['fenabling']);
		else
			bindtext($row_generatoin['name'],$row_generatoin['lable'],$row_generatoin['default_value'],$row_generatoin['placeholder'],$row_generatoin['width'],$row_generatoin['font_size'],$row_generatoin['required'],$row_generatoin['fenabling']);
	}
	//neeeeeeeew
	if($row_generatoin['type']=="Number" )
	{
		if(isset($_GET['op']) && $_GET['op']!='' && $_GET['op']=='update' && isset($_GET['row']) && $_GET['row']!='')
			bindnumber($row_generatoin['name'],$row_generatoin['lable'],$row_update_data[$row_generatoin['name']],$row_generatoin['placeholder'],$row_generatoin['width'],$row_generatoin['font_size'],$row_generatoin['required'],$row_generatoin['fenabling']);
		else
			bindnumber($row_generatoin['name'],$row_generatoin['lable'],$row_generatoin['default_value'],$row_generatoin['placeholder'],$row_generatoin['width'],$row_generatoin['font_size'],$row_generatoin['required'],$row_generatoin['fenabling']);
	}

	//datetime
	if($row_generatoin['type']=="DateTime" )
	{
		if(isset($_GET['op']) && $_GET['op']!='' && $_GET['op']=='update' && isset($_GET['row']) && $_GET['row']!='')
			binddatetime($row_generatoin['name'],$row_generatoin['lable'],$row_update_data[$row_generatoin['name']],$row_generatoin['placeholder'],$row_generatoin['width'],$row_generatoin['font_size'],$row_generatoin['required']);
		else
			binddatetime($row_generatoin['name'],$row_generatoin['lable'],$row_generatoin['default_value'],$row_generatoin['placeholder'],$row_generatoin['width'],$row_generatoin['font_size'],$row_generatoin['required']);
	}

	//date
	if($row_generatoin['type']=="HTML" )
	{
		if(isset($_GET['op']) && $_GET['op']!='' && $_GET['op']=='update' && isset($_GET['row']) && $_GET['row']!='')
			bindhtml($row_generatoin['name'],$row_generatoin['lable'],$row_update_data[$row_generatoin['name']],$row_generatoin['placeholder'],$row_generatoin['width'],$row_generatoin['font_size'],$row_generatoin['required']);
		else
			bindhtml($row_generatoin['name'],$row_generatoin['lable'],$row_generatoin['default_value'],$row_generatoin['placeholder'],$row_generatoin['width'],$row_generatoin['font_size'],$row_generatoin['required']);
	}

    ///bindmap
	if($row_generatoin['type']=="Maps" )
	{
		if(isset($_GET['op']) && $_GET['op']!='' && $_GET['op']=='update' && isset($_GET['row']) && $_GET['row']!='')
			bindmap($row_generatoin['name'],$row_generatoin['lable'],$row_update_data[$row_generatoin['name']],$row_generatoin['placeholder'],$row_generatoin['width'],$row_generatoin['font_size'],$row_generatoin['required']);
		else
			bindmap($row_generatoin['name'],$row_generatoin['lable'],$row_generatoin['default_value'],$row_generatoin['placeholder'],$row_generatoin['width'],$row_generatoin['font_size'],$row_generatoin['required']);
	}



	//date
	if($row_generatoin['type']=="Date" )
	{
		if(isset($_GET['op']) && $_GET['op']!='' && $_GET['op']=='update' && isset($_GET['row']) && $_GET['row']!='')
			binddate($row_generatoin['name'],$row_generatoin['lable'],$row_update_data[$row_generatoin['name']],$row_generatoin['placeholder'],$row_generatoin['width'],$row_generatoin['font_size'],$row_generatoin['required']);
		else
			binddate($row_generatoin['name'],$row_generatoin['lable'],$row_generatoin['default_value'],$row_generatoin['placeholder'],$row_generatoin['width'],$row_generatoin['font_size'],$row_generatoin['required']);
	}
	
	//date		
	if($row_generatoin['type']=="Time" )
	{
		if(isset($_GET['op']) && $_GET['op']!='' && $_GET['op']=='update' && isset($_GET['row']) && $_GET['row']!='')
			bindtime($row_generatoin['name'],$row_generatoin['lable'],$row_update_data[$row_generatoin['name']],$row_generatoin['placeholder'],$row_generatoin['width'],$row_generatoin['font_size'],$row_generatoin['required']);
		else
			bindtime($row_generatoin['name'],$row_generatoin['lable'],$row_generatoin['default_value'],$row_generatoin['placeholder'],$row_generatoin['width'],$row_generatoin['font_size'],$row_generatoin['required']);
	}

	if($row_generatoin['type']=="Select" || $row_generatoin['type']=="Check Box" )
	{
		if(isset($_GET['op']) && $_GET['op']!='' && $_GET['op']=='update' && isset($_GET['row']) && $_GET['row']!='')
			bindlist("`".$select_list."_".$row_generatoin['name']."`",$row_generatoin['name'],$row_generatoin['lable'],$row_generatoin['width'],$row_generatoin['type'],$row_generatoin['font_size'],$row_generatoin['required'],'','',$row_update_data[$row_generatoin['name']]);
		else
			bindlist("`".$select_list."_".$row_generatoin['name']."`",$row_generatoin['name'],$row_generatoin['lable'],$row_generatoin['width'],$row_generatoin['type'],$row_generatoin['font_size'],$row_generatoin['required']);
	}
/////////////
    if($row_generatoin['type']=="Multi Select")
    {
 		if(isset($_GET['op']) && $_GET['op']!='' && $_GET['op']=='update' && isset($_GET['row']) && $_GET['row']!='')
            bindmultilist("`".$row_generatoin['related_table']."`",$row_generatoin['name'],$row_generatoin['lable'],$row_generatoin['width'],$row_generatoin['type'],$row_generatoin['font_size'],$row_generatoin['required'],$row_generatoin['dis_fields'],$row_generatoin['fields'],$row_update_data[$row_generatoin['name']]);
        else
            bindmultilist("`".$row_generatoin['related_table']."`",$row_generatoin['name'],$row_generatoin['lable'],$row_generatoin['width'],$row_generatoin['type'],$row_generatoin['font_size'],$row_generatoin['required'],$row_generatoin['dis_fields'],$row_generatoin['fields']);

    }
//////////////
	if($row_generatoin['type']=="Related to table" )
	{
		if(isset($_GET['op']) && $_GET['op']!='' && $_GET['op']=='update' && isset($_GET['row']) && $_GET['row']!='')
			bindlist("`".$row_generatoin['related_table']."`",$row_generatoin['name'],$row_generatoin['lable'],$row_generatoin['width'],$row_generatoin['type'],$row_generatoin['font_size'],$row_generatoin['required'],$row_generatoin['dis_fields'],$row_generatoin['fields'],$row_update_data[$row_generatoin['name']]);
		else
			bindlist("`".$row_generatoin['related_table']."`",$row_generatoin['name'],$row_generatoin['lable'],$row_generatoin['width'],$row_generatoin['type'],$row_generatoin['font_size'],$row_generatoin['required'],$row_generatoin['dis_fields'],$row_generatoin['fields']);
	}
////////////////////
if($row_generatoin['type']=="List" )
{
	if(isset($_GET['op']) && $_GET['op']!='' && $_GET['op']=='update' && isset($_GET['row']) && $_GET['row']!='')
		bind_list("`".$row_generatoin['related_table']."`",$row_generatoin['name'],$row_generatoin['lable'],$row_generatoin['width'],$row_generatoin['type'],$row_generatoin['font_size'],$row_generatoin['required'],$row_generatoin['dis_fields'],$row_generatoin['fields'],$row_update_data[$row_generatoin['name']]);
	else
		bind_list("`".$row_generatoin['related_table']."`",$row_generatoin['name'],$row_generatoin['lable'],$row_generatoin['width'],$row_generatoin['type'],$row_generatoin['font_size'],$row_generatoin['required'],$row_generatoin['dis_fields'],$row_generatoin['fields']);
}

///////////////
	if($row_generatoin['type']=="Related to Field" )
	{

		if(isset($_GET['op']) && $_GET['op']!='' && $_GET['op']=='update' && isset($_GET['row']) && $_GET['row']!='')
			bindlist("`".$row_generatoin['related_table']."`",$row_generatoin['name'],$row_generatoin['lable'],$row_generatoin['width'],$row_generatoin['type'],$row_generatoin['font_size'],$row_generatoin['required'],$row_generatoin['refields_dis'],$row_generatoin['dis_fields'],$row_generatoin['fields'],$row_update_data[$row_generatoin['name']],$row_update_data[$row_generatoin['refields']]);
		else
			bindlist("`".$row_generatoin['related_table']."`",$row_generatoin['name'],$row_generatoin['lable'],$row_generatoin['width'],$row_generatoin['type'],$row_generatoin['font_size'],$row_generatoin['required'],$row_generatoin['dis_fields'],$row_generatoin['fields'],'',$row_generatoin['refields'],$row_generatoin['refields_dis']);

	}

    if( isset($event) && is_numeric(array_search($row_generatoin['name'],$event,true)))
    {
        if($row_generatoin['type']=='Select' ||  $row_generatoin['type']=='Related to table' || $row_generatoin['type']=='Related To Field')
        {
            $_SESSION['lastjs']=bind_js($row_generatoin['name'],$table);
        } else
        {
            $_SESSION['lastjs']=bind_js($row_generatoin['name'],$table);
        }
    }
    $row_generatoin=mysql_fetch_array($q);
    }

   if(isset($_SESSION['lastjs']) && $_SESSION['lastjs'] !='')
        echo  $_SESSION['lastjs'];
	if(isset($_GET['op']) && $_GET['op']!='' && $_GET['op']=='update' && isset($_GET['row']) && $_GET['row']!='')
		bindsubmit("update","تعديل البيانات",12,$_GET['row']);
	else
		bindsubmit("submit","موافق",12);
 echo '</form>';
}
function bind_event($db)
{
    $sql="SELECT * FROM generation_table gt where gt.table_name = '".$db."' and dbf_to !='' and dbf = 'Yes' and dbf_value !=''";
	$q=mysql_query($sql) or die(mysql_error());
	$row_event=mysql_fetch_array($q);
	$count=mysql_num_rows($q);
    if($count>0)
    {
        $item=array();
        $_SESSION['jsnames']=array();
        do{
//            print_r($row_event);
            array_push($item,$row_event['dbf_to']);
            array_push($_SESSION['jsnames'],$row_event);

        }while($row_event=mysql_fetch_array($q));

        return serialize($item);
    }else
    {
        return -1;
    }
}
function bind_js($fieldname,$table)
{

$return= "
<script>
document.addEventListener('DOMContentLoaded',function() {
    document.querySelector('select[name=".'"'.$fieldname.'"'."]').onchange=changeEventHandler;
},false);
function changeEventHandler(event) {

";
    $sql="SELECT * FROM generation_table gt where gt.table_name = '".$table."' and dbf_to !='' and dbf = 'Yes' and dbf_value !=''";
	$q=mysql_query($sql) or die(mysql_error());
	$q2=mysql_query($sql) or die(mysql_error());
	$row_event=mysql_fetch_array($q);
	$row_event2=mysql_fetch_array($q2);
	$count=mysql_num_rows($q);
    if($count>0)
    {
        do{
                $return.= "
                    if(event.target.value=='".$row_event['dbf_value']."')
                        {
                          document.getElementById('".$row_event['name']."').style.visibility = 'hidden';
                        }else
                        {
                         document.getElementById('".$row_event['name']."').style.visibility = 'visible';
                        }
                ";
        }while($row_event=mysql_fetch_array($q));
    }
//table_id,dbf_to,dbf_value
//print_r($_SESSION['jsnames']);



$return.= "}";

$return .="
loadjs();
function loadjs()
{
 doo=document.getElementById('".$fieldname."').value;

";
if($count>0)
{
    do{
                $return.= "
                    if(doo=='".$row_event2['dbf_value']."')
                        {
                          document.getElementById('".$row_event2['name']."').style.visibility = 'hidden';
                        }else
                        {
                         document.getElementById('".$row_event2['name']."').style.visibility = 'visible';
                        }
                ";
    }while($row_event2=mysql_fetch_array($q2));
}


$return.="
}

";


$return.= "</script>";

return $return;

}

function get_fields_value($fieldname,$table,$fname,$v1,$v3,$lable,$redis)
{
// echo $v1.'<hr>'.$fieldname.'<hr>'.$v3.'<hr>'.$fname.'<hr>'.$table;
 $return.="
<script>
document.addEventListener('DOMContentLoaded',function() {
    document.querySelector('select[name=".'"'.$fieldname.'"'."]').onchange=changeEventHandler;
},false);
function changeEventHandler(event) {
       var doo=document.getElementById('".$fieldname."').value;
       var a=document.querySelector('select[name=".'"'.$fieldname.'"'."]').value;

      jQuery('#".$fname."').load('jq.php?table=".$table."&value='+a+'&id=".$v1."&dis=".$v3."&putto=".$fname."&inserted=".$redis."');
}";
$return.= "</script>";

 echo $return;
}

?>
<?php
function bind_route($ac)
{

    if($ac['action']==1 ||isset($_GET['op']) )
    {
        if(isset($_GET['op']))
            bind_form($_SESSION['db']);
        else
            bind_form($ac['db']);
    }
    else
    {
        if($ac['page_style']==1)
            bind_view($ac['db']);
        else
            bind_view($ac['db']);
    }
}
function bind_form($db)
{
    bind($db);
}

function fillter($dateflaq='',$fillter_search='')
{
    $fl=0;
    if(isset( $_REQUEST['fillter']) && $_REQUEST['fillter']=='Yes')
    {
        $where.=' where '.$_REQUEST['col'].' between "'.$_REQUEST['fromdate'].'" and "'.$_REQUEST['todate'].'" ';

        if($_SESSION['S_SHOW_ALL']==0)
        {
            $fl=1;
            $usernama=$_SESSION['S_USERNAME'];
            $where.=" and s_insertby='$usernama'";
        }

        if($_SESSION['S_MGR']!='' && $_SESSION['S_SHOW_ALL']!=0)
        {
            $mgr= $_SESSION['S_MGR'];
            $where.=" or s_insertby in($mgr) ";
        }

    }

    if($fl==0 )
    {
        if($_SESSION['S_SHOW_ALL']==0)
        {
            $fl=1;
            $mgr= $_SESSION['S_MGR'];
            $usernama=$_SESSION['S_USERNAME'];
            $where.=" WHERE s_insertby='$usernama' ";
            if($_SESSION['S_MGR']!='')
            {
                $where.=" or s_insertby in($mgr) ";
            }
        }

    }
    if($fillter_search!='' && $_REQUEST['bind_view_fillter']!='' && $_REQUEST['bind_view_fillter']!='-1')
        if($fl==1)
        {
            $where.=' and '.$fillter_search.' like "%'.$_REQUEST['bind_view_fillter'].'%"';
        }else
        {
            $where.=' where '.$fillter_search.' like "%'.$_REQUEST['bind_view_fillter'].'%"';
        }

    if($dateflaq!='')
    {
        $where.=' ORDER BY '.$dateflaq;
    }

    $start_from=$_SESSION['start_from'];
    $limit=$_SESSION['limit'];
    $where.=' LIMIT '.$start_from.','.$limit;

    return $where;
}

function bind_view($db,$op="",$sortby='',$menuid='')
{

    $dateflaq=0;
    $sq="select * from db where name='$db'";
    $qu=mysql_query($sq) or die(mysql_error());
    $line=mysql_fetch_array($qu);
    add_log($line[0],6,$_SESSION['S_USERID'],'');
    $orderby=$line['sortby'];
    $fillterby=$line['fillter'];
    $fillter_search=$line['fillter_search'];
    if($line['page_style']==2)
    {
        bind($db);

    }else{

    $sql_statment="select * from generation_table where table_name='$db' and name='$fillter_search'";
    $query=mysql_query($sql_statment) or die(mysql_error());
    $array_sqlquery=mysql_fetch_array($query);
    $fillter_la=  $array_sqlquery['lable'];
	$sql_statment="select * from generation_table where table_name='$db' order by `$orderby`";
    $query=mysql_query($sql_statment) or die(mysql_error());
    $query_sub=mysql_query($sql_statment) or die(mysql_error());
    $array_sqlquery_count=mysql_num_rows($query);
    $co=1;
    if($array_sqlquery_count>0)
    {
        $array_sqlquery=mysql_fetch_array($query);
        $array_sqlquery_sub=mysql_fetch_array($query_sub);
        $hrflaq=0;
        if(!isset($_REQUEST['bind_view_fillter']) && $_REQUEST['bind_view_fillter']!='-1' && $fillter_la!='')
        {
            $hrflaq=1;
            echo " <hr>
        <input type='text' id='myInput'  oninput='bind_view(this.value)'  placeholder='بحث ب (".$fillter_la.")' title='Type in a name' class='form-control'>
                 <hr>";
        }
        if($_SESSION['total_pages']>1)
        {
            echo "<hr>". $_SESSION['pagelink'];
        }
        echo "
        <div class='table-responsive wow shake ' data-wow-delay='0.2s'>
        <div id='reload_div'>

        <table id='myTable' border='2.5' class='table table-striped table-bordered table-hover alert alert-success' bordercolor='black'>
        <thead ><tr class=''>";

        do{
            if($array_sqlquery['type']=='Date' || isset($array_sqlquery['Time']))
                {
                    $szi="width=8%";
                    $dateflaq=1;
                }
                else{
                    $szi='';
                    $dateflaq='';
                }
            echo "<th class='text-center' ".$szi."><i class='glyphicon'></i><strong>".$array_sqlquery['lable']."</strong></th>";
        }while($array_sqlquery=mysql_fetch_array($query));

        if($op=='')
        echo "<th><i class='glyphicon '></i>عمليات</th>";

        echo"</tr></thead><tbody>";


        $_SESSION['count_sql']=$sql_statment2="select * from `$db` ".fillter($fillterby,$fillter_search);


        $query2=mysql_query($sql_statment2) or die(mysql_error());
        $array_sqlquery2=mysql_fetch_array($query2);
        $flaq2=0;
        $array_sqlquery_count2=mysql_num_rows($query2);
        //$_SESSION['count']=$array_sqlquery_count2;
        if($array_sqlquery_count2>0)
        {

            do{
                $flaq2=0;
                $flaq=0;
                for($i=2;$i<=$array_sqlquery_count+1;$i++)
                {
                    $qu=mysql_query("select * from generation_table where table_name='$db'  order by ordernum");
                    $ro=mysql_fetch_array($qu);

                    $fl=0;
                    $fl2=0;
                    for($j=2;$j<=mysql_num_rows($qu)+1;$j++)
                    {
                            if($j==$i)
                            {
                                $st='';
                                if($ro['type']=="Related to table")
                                {
                                    $fl=1;
                                    $relate=$ro['related_table'];
                                    $relate_val=$ro['fields'];
                                    $relate_dis=$ro['dis_fields'];
                                }else if($ro['type']=="Select")
                                {
                                    $fl=2;
                                    $ta=$ro['name'];
                                }else if($ro['type']=="HTML")
                                {
                                    $fl=5;
                                }else if($ro['type']=="Date" || $ro['type']=="Time" || $ro['type']=="DateTime")
                                {
                                    $fl=8;
                                }else if($ro['type']=="Multi Select"  )
                                {
                                    $fl=9;
                                    $relate=$ro['related_table'];
                                    $relate_val=$ro['fields'];
                                    $relate_dis=$ro['dis_fields'];
                                }else if($ro['type']=="Related to Field"  )
                                {
                                    $fl=1;
                                    $relate=$ro['related_table'];
                                    $relate_val=$ro['refields_dis'];
                                    $relate_dis=$ro['dis_fields'];

                                }
                                else if($ro['type']=="Maps")
                                {
                                    $fl=10;
                                    $modelname=$ro['name'];
                                    $modellable=$ro['lable'];
                                }
                                else
                                {
                                    $fl=0;
                                }
                                if($ro['fenabling']==2)
                                    $del_btn='style="display:none"';
                                else
                                    $del_btn='';
                            }
                        $ro=mysql_fetch_array($qu);
                    }

                    if($line['linecolor']=='Yes' && $flaq2==0)
                    {
                        $col= get_line_color($db,$array_sqlquery2[$line['tb_col']]);
                        echo "<tr class='".$col."'>";
                         $flaq2=1;
                    }



                    if($fl==0)
                        echo "<td class='text-center'>".$array_sqlquery2[$i]."</td>";
                    else if($fl == 8)
                    {
                        echo "<td class='text-center' style='direction:ltr;'>".$array_sqlquery2[$i]."</td>";
                    }
                    else if($fl == 2)
                    {
                        echo "<td class='text-center'>".bind_select_view("gt_".$ta,$array_sqlquery2[$i])."</td>";
                    }
                    else if($fl==5)
                    {
                       echo '<td>
<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target=".bs-example-modal-full">عرض المحتوي</button>
                       </td>';
                       bind_model_html($array_sqlquery2[$i]);
                    }
                    else if($fl==9)
                    {

echo "<td class='text-center'>".bind_select_multi($relate,$relate_val,$relate_dis,$array_sqlquery2[$i])."</td>";

                    }else if($fl==10)
                    {
                        echo "<td class='text-center'>".$array_sqlquery2[$i]."
                        <!-- <button type='button' class='btn btn-primary' data-toggle='modal' data-target='.".$modelname."'>فتخ الخاريطة</button>-->
                        </td>";
                       //include"administrator/fun/maps.php";
                        //bind_modeel($modelname,$modellable,$array_sqlquery2[$i]);
                    }
                    else
                    {

                    echo "<td class='text-center'>".bind_select_q($relate,$relate_val,$relate_dis,$array_sqlquery2[$i])."</td>";

                    }



                }
                if($op=='')
                {

                echo'<td>
                <a href="route.php?op=update&row='.$array_sqlquery2[0].'" class="btn btn-default btn-xs"><i class="fa fa-edit white"></i> تعديل </a>
                <button type="button" '.$del_btn.' onclick="del(this.value)" value="'.$array_sqlquery2[0].'"  class="btn btn-default btn-xs"><i class="fa fa-times white"></i> حذف</button>';

                    if($line['report_view']==2)
                    {
                       echo '
                        <form action="bind_print2.php" method="post">
<button type="submit" name="action" class="btn btn-default btn-xs" value="2"><span style="color: #000000"><i class="fa fa-print white"></i> طباعة</span></button>
                    <input type="hidden" name="rowid" value="'.$array_sqlquery2[0].'">
                    <input type="hidden" name="db" value="'.$db.'">
                    <input type="hidden" name="lable" value="'.$line['table_lable'].'">

                        </form>';
                    }
                }


                echo "</tr>";
                $co++;
            }while($array_sqlquery2=mysql_fetch_array($query2));
        }
        echo "</tbody></table></div></div></div>";

    }
    }//page style
}

function bind_model_html($val)
{
    echo '

<div class="modal fade bs-example-modal-full" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-full">
        <div class="modal-content">

            <!-- header modal -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myLargeModalLabel"></h4>
            </div>

            <!-- body modal -->
            <div class="modal-body">

            <textarea disabled="disabled" class="summernote form-control" data-height="450"  data-lang="en-US">'.$val.'</textarea>

            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">إغلاق النافذة</button>
            </div>

        </div>
    </div>
</div>


    ';
}


function bind_select_q($table,$val,$dis,$dbval)
{
    $sql_statment="select `$dis` from `".$table."` where $val='$dbval'";
	$query=mysql_query($sql_statment) or die(mysql_error());
    $array_sqlquery=mysql_fetch_array($query);
    return $array_sqlquery[0];
}
function bind_select_multi($table,$val,$dis,$dbval)
{

    if($dbval!='' && $dbval!='-1' && $dbval!='-2')
    {
    $sql_statment="select * from `".$table."` where $val in($dbval)";
    $query=mysql_query($sql_statment) or die(mysql_error());

    $num_sqlquery=mysql_num_rows($query);
    $re='';
    while($array_sqlquery=mysql_fetch_array($query))
    {
        $re.=$array_sqlquery[$dis]." - ";
    }

    return $re;
    }
    if($dbval=='-1')
    {   
        return "مدير نظام";
    }

       return "لم يتم التحديد";


    //return $array_sqlquery[0];
}
function bind_select_view($table,$va)
{

	$sql_statment="select * from `".$table."` where id ='$va'";
	$query=mysql_query($sql_statment) or die(mysql_error());
	$array_sqlquery=mysql_fetch_array($query);    
    return $array_sqlquery[1];

}


if(isset($_GET['del_value']) && $_GET['del_value'])
{
    include "../administrator/config.php";
    include "../administrator/fun/fun.php";
    $id=$_GET['del_value'];
    $db=$_SESSION['db'];
    $sql="delete from `$db` where id='$id'";
    $q=mysql_query($sql) or die(mysql_error());
    ///////////
    $r=mysql_fetch_array( mysql_query("select * from `db` where name = '".$db."'"));
    $dbid=$r['id'];
    ////////////
    add_log($dbid,4,$_SESSION['S_USERID'],$id);
    $_SESSION['msg2']="تم الحذف بنجاح";
    $_SESSION['msg_type']="s";
    //exit();
    echo '<script>window.location = "route.php";</script>';
}

function get_line_color($db,$val)
{

    $sql_color="select * from `setting_linecolor` where `table`= '".$db."' and tb_value='$val'";
    
	$query_color=mysql_query($sql_color) or die(mysql_error());
    $array_color=mysql_fetch_array($query_color);    
    return $array_color['csscolor'];
}
?>

<script>
function del(val)
 {
     if (confirm(" حذف من النظام ؟")) {

        jQuery('#div_session_write').load('fun/include_fun_bind.php?del_value='+val);
        setTimeout(function(){
        window.location.reload(1);
        }, 1000);
    } else {
    // Do nothing!
    }

 }
 </script>
 <?php

function bind_alert_search($table,$lable)
{
        $sq="select * from db where name='$table'";
        $qu=mysql_query($sq) or die(mysql_error());
        $row_update_data=mysql_fetch_array($qu);
        //print_r($row_update_data['fillter']);
        $row_update_data_count=mysql_num_rows($qu);
            if($row_update_data['fillter_search']!='')
            {
           $sq=mysql_query('select * from `generation_table` where name="date" and table_name="'.$table.'"') or die(mysql_error());
            $row_gt=mysql_fetch_array($sq);
        if($row_gt['type']=='Date')
        {
           echo'<div class="alert alert-info bordered-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12"><!-- left text -->
                        <form method="post" action="" >

                <input type="hidden" name="db" value="'.$table.'">
                <input type="hidden" name="lable" value="'.$lable.'">
                <input type="hidden" name="col" value="'.$row_update_data['fillter_search'].'">
                <input type="hidden" name="fillter" value="Yes">
                <input type="hidden" name="action" value="3">

                            <div class="col-sm-3">
<input type="text" name="fromdate"  required="required" class="form-control masked input-lg" data-format="99/99/9999" data-placeholder="_" placeholder="من تاريخ">
                            </div>

                            <div class="col-sm-3">
<input type="text"  required="required" name="todate" class="form-control masked input-lg" data-format="99/99/9999" data-placeholder="_" placeholder="الي تاريخ">
                            </div>

                            <div class="col-sm-3">
                                <button class="btn btn-3d btn-block btn-dirtygreen"><i class="fa fa-search"></i>بحث و فلتر بالتاريخ</button>
                            </div>
                        </form>
                        </div><!-- /left text -->
                    </div>
                </div>
            </div>';

                }else if($sq['type']=='Select' || $sq['type']=='Related to table')
                {

                }else
                {

                }

            }

 return $row_update_data;

}

function bind_group_name_update($val)
{

}
?>
<script>
function myFunction() {
    var input, filter, table, tr, td, i;
    input = document.getElementById("myInput");

        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }


}
function sea(emp)
{
    jQuery('#div_session_write').load('fun/include_fun_bind.php?del_value='+val)
}
function bind_view(emp_no)
{
    setTimeout(
        function(){
            //if(emp_no.length >5)
            jQuery('#reload_div').load('jq.php?bind_view_fillter='+emp_no);
            }, 3000);
    //console.log(emp_no.length);



}
</script>


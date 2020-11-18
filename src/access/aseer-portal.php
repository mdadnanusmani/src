<?php
include "include.php";
is_admin();
design_page("محافظات و مراكز منطقة عسير");
$global_var='محافظات و مراكز منطقة عسير';
$global_var2='إعدادات بواية عسير التنموية';
?>
	<section id="middle">

<?php

    design_page_header("إضافة مواد","مراكز والمحافظات ");
    include "fun/main_function.php";
    include "fun/include_fun_aseer_portal.php";
?>

<!-- Page Content -->
            <div id="content" class="padding-20">
					<div id="panel-4" class="panel panel-default">
								<div class="panel-heading">

									<span class="elipsis"><!-- panel title -->
										<strong><? echo $global_var; ?></strong>
									</span>
									<!-- tabs nav -->
									<ul class="nav nav-tabs pull-right options">
                                    <li>
                                        <a href="#" class="opt panel_colapse" data-toggle="tooltip" title="تصغير" data-placement="bottom"></a>
                                    </li>
        							<li>
                                        <a href="#" class="opt panel_fullscreen hidden-xs" data-toggle="tooltip" title="تكبير " data-placement="bottom"><i class="fa fa-expand"></i></a>
                                    </li>
									</ul>
									<!-- /tabs nav -->
					</div>
                    <div class="panel-body">
                                <?
                                    noti_show();
                                ?>

 <div class="table-responsive">
  <div id='div_session_write'> </div>
	<table class="table nomargin">
		<thead>
			<tr>
				<th><i class="glyphicon "></i>ID</th>
				<th><i class="glyphicon "></i>إسم المجموعة الرئيسي</th>
				<th><i class="glyphicon "></i>إسم المجموعة</th>
				<th><i class="glyphicon "></i>نص توضيحي</th>
   				<th><i class="glyphicon "></i>صورة المجموعة</th>
   				<th><i class="glyphicon "></i></th>
   				<th><i class="glyphicon "></i></th>
			</tr>
		</thead>
		<tbody>
<?
$count=1;
$q=get_main_serv();
                                    $x=1;

                                    while($row = mysql_fetch_array($q))
                                    {
                                    $main_id=$row['main_id'];
if($row['main_id']==0)
{
    $row['main_id']="القائمة الرئسية";
}
else
{
    $row['main_id']=bind_aseer_portal_view($row['main_id']);
}
                                        if( isset( $_GET['op']) && $_GET['op']!='' && isset($_GET['row']) && $_GET['row']!='' && $_GET['row'] == $row['ID'])
                                        {
                                            echo '<form  action="" method="post" enctype="multipart/form-data">';
                                            echo "<tr>";
                                            echo '<td>'.$x.'</td>';
                                            echo "<td>"; bind_aseer_portal_update($main_id,1); echo"</td>";
                                            echo '<td><input type="text" name="name" value="'.$row['Name'].'" class="form-control "></td>';
                                            echo '<td><input type="text" name="desc" value="'.$row['Description'].'" class="form-control "></td>';

                                            echo '<td><input type="file" name="img" velue="" class="form-control"></td>';
                                            echo '<td><input name="submit_portal_group_update"  type="submit" value="إعتماد التعديل" class="btn btn-success">
                                                <a href="aseer-portal.php"><input name="close"  type="button" value="ألغاء" class="btn btn-danger"></a></td>';
                                            echo "</tr>
                                                <input type='hidden' name='id' value='".$row['ID']."'>
                                                <input type='hidden' name='old_img' value='".$row['img']."'>
                                                </form>
                                            ";
                                        }else{


                                       echo "<tr>";
                                       echo "<td>".$x."</td>";
                                       echo "<td>".$row['main_id']."</td>";
                                       echo "<td>".$row['Name']."</td>";
                                       echo "<td>".$row['Description']."</td>";

                                       echo "<td><img class='avatar' src='".$row['img']."' width='50' height='50' alt='avatar' /></td>";
                                       echo'<td> <a href="?op=update&row='.$row['ID'].'" class="btn btn-default btn-xs"><i class="fa fa-edit white"></i> تعديل </a>
                                        <button type="button" onclick="del(this.value)" value="'.$row['ID'].'"  class="btn btn-default btn-xs"><i class="fa fa-times white"></i> حذف</button>
									    </td>';
                                       echo "</tr> ";

                                        }
                                        $x++;
                                    };
?>
                                    <form action="" method="post" enctype="multipart/form-data">
                                     <tr>
                                     <td><? echo $x; ?></td>
                                     <td><? echo bind_aseer_portal_select(1);?></td>
                                     <td><input type="text" name="name" value="" class="form-control" required="required"></td>
                                     <td><input type="text" name="desc" value="" class="form-control" ></td>
                                     <td><input type="file" name="img" id="img" value="" class="form-control" ></td>
                                     <td><input name="submit_portal_group"  type="submit" value="حفظ" class="btn btn-success"></td>
                                     </tr>
                                    </form>
        </tbody>
    </table>
    </div>



                                </div>
    				</div>
            </div>
<!--page Content End -->


	</section>
	<!-- /MIDDLE -->
<?php
desing_page_end();
?>
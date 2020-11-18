<?php
include "include.php";
is_admin();
design_page("المقاولون");
$global_var='المقاولون';
$global_var2='المقاولون';
?>
    <section id="middle">

<?php

    design_page_header("إضافة المقاولون ","إدارة المشاريع");
    include "fun/main_function.php";
    include "fun/include_fun_consolut.php";
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
                <th><i class="glyphicon "></i>اسم الشركة	</th>
                <th><i class="glyphicon "></i>الاسم الكامل للمدير	</th>
   				<th><i class="glyphicon "></i></th>
   				<th><i class="glyphicon "></i></th>
            </tr>
        </thead>
        <tbody>
<?
$count=1;
$q=get_main_consolut();
                                    $x=1;

                                    while($row = mysql_fetch_array($q))
                                    {


                                        if( isset( $_GET['op']) && $_GET['op']!='' && isset($_GET['row']) && $_GET['row']!='' && $_GET['row'] == $row['id'])
                                        {
                                            echo '<form  action="" method="post" enctype="multipart/form-data">';
                                            echo "<tr>";
                                            echo '<td>'.$x.'</td>';

                                            echo '<td><input type="text" name="name" value="'.$row['name'].'" class="form-control "></td>';
                                            echo '<td><input type="text" name="mgname" value="'.$row['mgname'].'" class="form-control "></td>';


                                            echo '<td><input name="submit_portal_group_update"  type="submit" value="إعتماد التعديل" class="btn btn-success">
                                                <a href="consolut.php"><input name="close"  type="button" value="ألغاء" class="btn btn-danger"></a></td>';
                                            echo "</tr>
                                                <input type='hidden' name='id' value='".$row['id']."'>

                                                </form>
                                            ";
                                        }else{


                                       echo "<tr>";
                                       echo "<td>".$x."</td>";
                                       echo "<td>".$row['name']."</td>";
                                       echo "<td>".$row['mgname']."</td>";

                                       echo'<td> <a href="?op=update&row='.$row['id'].'" class="btn btn-default btn-xs"><i class="fa fa-edit white"></i> تعديل </a>
                                        <button type="button" onclick="del(this.value)" value="'.$row['id'].'"  class="btn btn-default btn-xs"><i class="fa fa-times white"></i> حذف</button>
                                        </td>';
                                       echo "</tr> ";

                                        }
                                        $x++;
                                    };
?>
                                    <form action="" method="post" enctype="multipart/form-data">
                                     <tr>
                                     <td><? echo $x; ?></td>

                                     <td><input type="text" name="name" value="" class="form-control" required="required"></td>
                                     <td><input type="text" name="mgname" value="" class="form-control" ></td>
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
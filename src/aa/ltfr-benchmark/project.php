<?php
include "include.php";
is_admin();
$global_var1="إضافة مشروع جديد";
design_page($global_var1);
include "fun/main_function.php";
include "fun/include_fun_project.php";
include "fun/include_fun_vac_add_op.php";
//count_normal_vac($_SESSION['S_EMP_NO']);

?>
	<section id="middle">
    <?php
    	design_page_header("إضافة مشروع جديد","صفحات النظام");
    ?>
	<div id="content" class="padding-20">



                    <div id="panel-4" class="panel panel-default">
                 <div id="map"></div>
						<div class="panel-heading">
							<span class="title elipsis">
								<strong><? echo $global_var1; ?></strong> <!-- panel title -->
							</span>

							<!-- right options -->
							<ul class="options pull-right list-inline">
								<li><a href="#" class="opt panel_colapse" data-toggle="tooltip" title="تصغير" data-placement="bottom"></a></li>
								<li><a href="#" class="opt panel_fullscreen hidden-xs" data-toggle="tooltip" title="تكبير " data-placement="bottom"><i class="fa fa-expand"></i></a></li>

							</ul>
							<!-- /right options -->

						</div>
						<div class="panel-body">
                        <div id='div_session_write'> </div>
<!------------------------- -->
                        <?
                            noti_show();
                        ?>
								<div class="panel-body">

								<form  action="" method="post" enctype="multipart/form-data" >
<fieldset>
		<!-- required [php action request] -->
		<input type="hidden" name="action" value="insert" />

		<div class="row">
			<div class="form-group">
				<div class="col-md-6 col-sm-12">
					<label>تابع الي *</label>
                 <input list="jobs" autocomplete="off" required="required" class="form-control" name="goto">
<datalist id="jobs">

<?php
    $sql="select * from main_serve order by main_id";
    $q=mysql_query($sql) or die(mysql_error());
    $row=mysql_fetch_array($q);
    do{
    echo '<option value="'.$row['ID'].'">'.$row['Name'].'</option>';
    }while($row=mysql_fetch_array($q));
?>

       </datalist>

				</div>

			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<div class="col-md-6 col-sm-6">
					<label>أسم المشروع *</label>
					<input type="text" name="name" value="" class="form-control required">
				</div>
				<div class="col-md-6 col-sm-6">
					<label> اسم الإدارة الحكومية *</label>
					<input type="text" name="gov_name" value="" class="form-control required">
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<div class="col-md-6 col-sm-6">
					<label>أسم الشركة  *</label>
<input list="con" autocomplete="off" required="required" class="form-control" name="com_name">
<datalist id="con">

<?php
    $sql="select * from consolut ";
    $q=mysql_query($sql) or die(mysql_error());
    $row=mysql_fetch_array($q);
    do{
    echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
    }while($row=mysql_fetch_array($q));
?>

</datalist>


				</div>
				<div class="col-md-6 col-sm-6">
					<label> قيمة العقد *</label>
					<input type="number" name="price" value="" class="form-control required">
				</div>
			</div>
		</div>


		<div class="row">
			<div class="form-group">
				<div class="col-md-6 col-sm-6">
					<label>السنة المالية *</label>
					<input type="number" min="1300" max="1500" name="price_year" value="" class="form-control required">
				</div>
				<div class="col-md-6 col-sm-6">
					<label>المدة *</label>
					<input type="text" name="time" value="" class="form-control required">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group">
				<div class="col-md-6 col-sm-6">
					<label> تاريخ الاستلام *</label>
<input type="date" required="required"  name="dates" id="date" class="form-control" data-format="dd-mm-yyyy" data-lang="ar" data-RTL="false">
				</div>
				<div class="col-md-6 col-sm-6" >
					<label> تاريخ الانتهاء *</label>
<input type="date" required="required"  name="datee" id="date" class="form-control" data-format="dd-mm-yyyy" data-lang="ar" data-RTL="false">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group">
				<div class="col-md-6 col-sm-6">
					<label> اسم الموقع *</label>
					<input type="text" name="loc_name" value="" class="form-control required">
				</div>

				<div class="col-md-6 col-sm-12">
					<label>حالة المشروع *</label>
					<select name="status" class="form-control pointer required">

						<option value="1">منجزة</option>
						<option value="2">متقطعة</option>
						<option value="3">متوقفة</option>
						<option value="4">متاخرة</option>
						<option value="5">جارية</option>
					</select>
				</div>
				</div>

		</div>
        <td><input name="submit_portal_group"  type="submit" value="حفظ المشروع" class="btn btn-success"></td>

	</fieldset>

										</form>
								</div>
<!-------------------- -->

                        </div>
		            </div>
                     <!--------------------- Display-->

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

	<table class="table nomargin">
		<thead>
			<tr>
				<th><i class="glyphicon "></i>ID</th>
				<th><i class="glyphicon "></i>تابع الي</th>
				<th><i class="glyphicon "></i> اسم المشروع </th>
   				<th><i class="glyphicon "></i> قيمة العقد </th>
   				<th><i class="glyphicon "></i> تاريخ الانتهاء </th>
   				<th><i class="glyphicon "></i>المدة</th>
   				<th><i class="glyphicon "></i>الشركة</th>
   				<th><i class="glyphicon "></i>الموقع</th>
   				<th><i class="glyphicon "></i>الحالة</th>
   				<th><i class="glyphicon "></i></th>
			</tr>
		</thead>
		<tbody>

         <?php

         $q=select_con();
         $x=1;
         while($row=mysql_fetch_array($q))
         {
               echo "<tr>";
               echo "<td>".$x."</td>";
               echo "<td>".bind_aseer_portal_view($row['main_id'])."</td>";
               echo "<td>".$row['name']."</td>";
               echo "<td>".$row['price']."</td>";
               echo "<td>".$row['date']."</td>";
               echo "<td>".$row['time']."</td>";
               echo "<td>".$row['com_name']."</td>";
               echo "<td>".$row['location']."</td>";
               echo "<td>".bind_status($row['status'])."</td>";
               echo '<td>
                <button type="button" onclick="del(this.value)" value="'.$row[0].'"  class="btn btn-default btn-xs"><i class="fa fa-times white"></i> حذف</button>
               <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg'.$row[0].'">تفاصيل</button>
                </td>

               ';
              echo "</tr> ";
              $x++;
              echo '<div class="modal fade bs-example-modal-lg'.$row[0].'" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<!-- header modal -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="mySmallModalLabel">'.$row['name'].'</h4>
			</div>

			<!-- body modal -->
			<div class="modal-body">



        <form  action="" method="post" enctype="multipart/form-data" >
        <fieldset>

        <div class="row">
			<div class="form-group">
				<div class="col-md-12 col-sm-6">
					<label>تابع الي *</label>
                    <b>'.bind_aseer_portal_view($row['main_id']).'</b><br>
					'.bind_goto($row['main_id']).'
                    <input type="hidden" name="old_goto" value="'.$row['main_id'].'">
				</div>

			</div>
		</div>

        <div class="row">
			<div class="form-group">
				<div class="col-md-6 col-sm-6">
					<label>أسم المشروع *</label>
					<input type="text" name="name" value="'.$row['name'].'" class="form-control required">
				</div>
				<div class="col-md-6 col-sm-6">
					<label> اسم الإدارة الحكومية *</label>
					<input type="text" name="gov_name" value="'.$row['gov_name'].'" class="form-control required">
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<div class="col-md-6 col-sm-6">
					<label>الشركة *</label>
                    <b>'.bind_com_name($row['com_name']).'</b><br>
					'.bind_con($row['co_mname']).'
                     <input type="hidden" name="old_com_name" value="'.$row['com_name'].'">
				</div>
				<div class="col-md-6 col-sm-6">
					<label> قيمة العقد *</label>
					<input type="number" name="price" value="'.$row['price'].'" class="form-control required">
				</div>
			</div>
		</div>


		<div class="row">
			<div class="form-group">
				<div class="col-md-6 col-sm-6">
					<label>السنة المالية *</label>
					<input type="number" min="1300" max="1500" name="price_year"  value="'.$row['year_price'].'" class="form-control required">
				</div>
				<div class="col-md-6 col-sm-6">
					<label>المدة *</label>
					<input type="text" name="time" value="'.$row['time'].'" class="form-control required">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group">
				<div class="col-md-6 col-sm-6">
					<label> تاريخ الاستلام *</label>
<input type="date" required="required"  name="dates" id="date"  value="'.$row['date_start'].'" class="form-control" data-format="dd-mm-yyyy" data-lang="ar" data-RTL="false">
				</div>
				<div class="col-md-6 col-sm-6" >
					<label> تاريخ الانتهاء *</label>
<input type="date" required="required"  name="datee" id="date" class="form-control" value="'.$row['date'].'" data-format="dd-mm-yyyy" data-lang="ar" data-RTL="false">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group">
				<div class="col-md-6 col-sm-6">
					<label> اسم الموقع *</label>
					<input type="text" name="loc_name" value="'.$row['location'].'" class="form-control required">
				</div>

				<div class="col-md-6 col-sm-12">
					<label>حالة المشروع *</label>
					<select name="status" class="form-control pointer required">

						<option value="1" '.bind_select($row['status'],1).'>منجزة</option>
						<option value="2" '.bind_select($row['status'],2).'>متقطعة</option>
						<option value="3" '.bind_select($row['status'],3).'>متوقفة</option>
						<option value="4" '.bind_select($row['status'],4).'>متاخرة</option>
						<option value="5" '.bind_select($row['status'],5).'>جارية</option>
					</select>
				</div>
				</div>

			</div>

         <br>
         <input type="hidden" name="id" value="'.$row['id'].'">
          <input name="submit_update"  type="submit" value="تعديل  المشروع" class="btn btn-success">
               </fieldset>
               </form>

            </div>

	    </div>
	</div>
</div>';
         }


         ?>
        </tbody>
    </table>
    </div>





				</div>
				</div>
				</div>

			<!--page Content End -->


	</section>

<?php
desing_page_end();
?>


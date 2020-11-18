<?php
include "include.php";
$global_var1="إضافة مشروع جديد";
design_page($global_var1);
include "fun/main_function.php";
include "fun/include_project.php";
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
					<label>الشركة *</label>
					<input type="email" name="com_name" value="" class="form-control required">
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
						<option value="">--- الرجاء الاختيار ---</option>
						<option value="">منجزة</option>
						<option value="">متقطعة</option>
						<option value="">متوقفة</option>
						<option value="">متاخرة</option>
						<option value="">جارية</option>
					</select>
				</div>
				</div>

		</div>


	</fieldset>

										</form>
								</div>
<!-------------------- -->

                        </div>
		            </div>

				</div>

			<!--page Content End -->


	</section>

<?php
desing_page_end();
?>


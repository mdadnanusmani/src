<?php

$header='
<!doctype html>
<html lang="en-US">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>'.$PAGE_TITLE.' | منصة التطبيقات </title>
		<meta name="description" content="" />
		<meta name="Author" content="Elmgdad Hamed Ahmed" />
		<!-- mobile settings -->
		<meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0" />

		<!-- WEB FONTS -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800&amp;subset=latin,latin-ext,cyrillic,cyrillic-ext" rel="stylesheet" type="text/css" />

		<!-- CORE CSS -->
		<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

           <link href="assets/css/bootstrap3.5.min.css" rel="stylesheet" >
		<link href="assets/css/multi-select.css" rel="stylesheet" type="text/css" />

		<!-- THEME CSS -->

		<link href="assets/css/essentials.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/layout.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/color_scheme/green.css" rel="stylesheet" type="text/css" id="color_scheme" />

		<link href="assets/plugins/bootstrap/RTL/bootstrap-rtl.min.css" rel="stylesheet" type="text/css" />
		<link href="assets/plugins/bootstrap/RTL/bootstrap-flipped.min.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/layout-RTL.css" rel="stylesheet" type="text/css" />

                   <!-- GIS Import -->

	</head>

	<body>

<div class="modal fade bs-chpass-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<!-- header modal -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myLargeModalLabel">تغير كلمة المرور</h4>
			</div>

			<!-- body modal -->
			<div class="modal-body" >

                 <form action="fun/include_chpass.php" method="post" class="sky-form boxed">
                    <fieldset>
                        <section>
                            <label class="label pull-left" >كلمة المرور القديمة</label>
                            <label class="input">
<input type="password" pattern="^(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[\d])(?=.*[\W]).*$" value="" name="old_emp_password" required="required">
<b class="tooltip tooltip-top-right">الرجاء ادخال كلمة المرور القديمة</b>
                            </label>
                        </section>
                    </fieldset>
                    <fieldset>
                        <section>
                            <label class="label pull-left" >كلمة المرور الجديدة</label>
                            <label class="input">
<input type="password" pattern="^(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[\d])(?=.*[\W]).*$" value="" name="emp_password" required="required">
<b class="tooltip tooltip-top-right">الرجاء ادخال كلمة المرور الجديد</b>
                            </label>
                        </section>
                    </fieldset>
                    <footer>
                        <button type="submit" class="btn btn-success pull-right">تحديث بياناتي</button>

                    </footer>
                </form>

                <div dir="rtl" class="alert alert-info noborder weight-400 nomargin noradius">
                                شروط كلمة المرور:
                            <ol>
                                <li>يجب ان يحتوي علي احرف صغيرة و  كبيرة </li>
                                <li>يجب ان يحتوي علي أرقام</li>
                                <li>يجب ان يحتوي علي رمز (مثلاً: @,#,$,%)</li>
                                <li>طول كلمة المرور لايقل عن 8 خانات</li>
                            </ol>

                </div>
			</div>

			<!-- Modal Footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">إغلاق النافذة</button>
			</div>

		</div>
	</div>
</div>
		<!-- WRAPPER -->
		<div id="wrapper">
';
?>
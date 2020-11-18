<?
include "administrator/config.php";
include "administrator/fun/fun.php";
@session_start();
$flaq=-1;
if(isset($_POST['emp_password']))
{
        //or_user_session($emp);
        //echo '<script>window.location = "index.php";</script>';
        $emp=$_SESSION['S_USERID'];
        $pass=$_POST['emp_password'];

        $sql="update users set password='$pass',change_password=1 where id='$emp'";
        $q=mysql_query($sql) or die(mysql_error($sql));

        $_SESSION['S_CHANGE_PASSWORD']=1;
        //or_user_session($row);
  		echo '<script>window.location = "index.php";</script>';
    exit();
}



?>

<!doctype html>
<html lang="en-US">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <title>تسجيل دخول | أمارة منطقة عسير</title>
        <meta name="description" content="" />
        <meta name="Author" content="" />

        <!-- mobile settings -->
        <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0" />

        <!-- WEB FONTS -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800&amp;subset=latin,latin-ext,cyrillic,cyrillic-ext" rel="stylesheet" type="text/css" />

        <!-- CORE CSS -->
        <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

        <!-- THEME CSS -->
        <link href="assets/css/essentials.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/layout.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/color_scheme/green.css" rel="stylesheet" type="text/css" id="color_scheme" />



    </head>
    <!--
        .boxed = boxed version
    -->
    <body>


        <div class="">

            <div class="login-box">
                <div class="alert alert-danger  noborder text-center weight-400 nomargin noradius">
                   نعتذر عن الإزعاج .. عند تسجيل الدخول لاول مره يجيب تغير كلمة المرور الافتراضيه
                </div>

                <!-- login form -->
                <form action="" method="post" class="sky-form boxed">

                   <header class="">
                    <i class="fa fa-users pull-right"></i> مرحباً بك <?php echo $_SESSION['S_USERNAME']; ?>
                    </header>

                    <fieldset>

                        <section>
                            <label class="label" >أسم المستخدم</label>
                            <label class="input">
                                <i class="icon-append fa fa-envelope"></i>
<input type="emp_id" value="<?php echo $_SESSION['S_USERNAME']; ?>"  disabled="disabled" name="emp_id" required="required" >
                                <span class="tooltip tooltip-top-right">أسم المستخدم او رقم الهوية الوطنية</span>
                            </label>
                        </section>

                        <section>
                            <label class="label">كلمة المرور الجديدة</label>
                            <label class="input">
                                <i class="icon-append fa fa-lock"></i>
                                <input type="password" pattern="^(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[\d])(?=.*[\W]).*$" value="" name="emp_password" required="required">
                                <b class="tooltip tooltip-top-right">الرجاء ادخال كلمة المرور الجديد</b>
                            </label>

                        </section>

                    </fieldset>

                    <footer>
                        <button type="submit" class="btn btn-primary pull-right">تحديث بياناتي</button>

                    </footer>

                </form>
                <!-- /login form -->

                <hr />
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

        </div>

        <!-- JAVASCRIPT FILES -->
        <script type="text/javascript">var plugin_path = 'assets/plugins/';</script>
        <script type="text/javascript" src="assets/plugins/jquery/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="assets/js/app.js"></script>
    </body>
</html>
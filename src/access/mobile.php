<?
include "administrator/config.php";
include "administrator/fun/fun.php";
include "administrator/fun/SMS.php";

@session_start();
$flaq=-1;
if(isset($_POST['emp_mobile']))
{
    if(isset($_POST['flaq']) && $_POST['flaq']==2)
    {
        print_r($_POST);
        if($_POST['code']==$_POST['emp_mobile'])
        {
            $_SESSION['S_MOBILE']=$_POST['mobile'];
            $emp=$_SESSION['S_USERID'];
            $mobile=$_POST['mobile'];
            $sql="update users set mobile='$mobile' where id='$emp'";
            $q=mysql_query($sql) or die(mysql_error($sql));
            echo '<script>window.location = "index.php";</script>';
            exit();
        }else
        {
            echo '<script>
alert("الرمز خاطئ");
</script>';
            $flaq=2;
        }

    }else
    {
        $code=rand(1000,9999);
        sms_orbit_send($_POST['emp_mobile'],'رمز التاكيد : '.$code);
        $flaq=2;

    }

        //or_user_session($emp);
        //echo '<script>window.location = "index.php";</script>';
        //$emp=$_SESSION['S_USERID'];
        //$pass=$_POST['emp_password'];
        //$sql="update users set ='$pass',change_password=1 where id='$emp'";
        //$q=mysql_query($sql) or die(mysql_error($sql));

       //$_SESSION['S_CHANGE_PASSWORD']=1;
       //or_user_session($row);
  	   //echo '<script>window.location = "index.php";</script>';
    //exit();
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
           <?php
           if($flaq==2)
           {
           ?>

            <div class="login-box">
                <div class="alert alert-danger  noborder text-center weight-400 nomargin noradius">
                   <h4>نعتذر عن الإزعاج .. الرجاء إدخال رمز التاكيد المرسل الي جوالك</h4>
                </div>

                <!-- login form -->
                <form action="" method="post" class="sky-form boxed">

                   <header class="">
                   <h2 style="text-align: center">مرحباً بك <?php echo $_SESSION['S_USERNAME']; ?> </h2>
                    </header>

                    <fieldset>

                        <section>
                            <label class="label pull-right" >الرمز</label>
                            <label class="input">
                                <i class="icon-mobile fa fa-phone"></i>
                                <input type="number" value="" name="emp_mobile" required="required">
                                <b class="tooltip tooltip-top-right">الرجاء ادخال رقم الجوال</b>
                            </label>
                           <script>

                           function phonenumber(inputtxt,code)
                            {
                              var phoneno = /^\d{10}$/;
                              if(inputtxt==code)
                                    {
                                  return true;
                                    }
                                  else
                                    {
                                    alert("message");
                                    return false;
                                    }
                            }

                           </script>
                        </section>

                    </fieldset>

                    <footer>
                        <button type="submit"  class="btn btn-primary pull-right">تحديث بياناتي</button>

                    </footer>
                       <input type="hidden" name="flaq" value="2">
                       <input type="hidden" name="mobile" value="<?php echo $_POST['emp_mobile']; ?>">
                       <input type="hidden" name="code" value="<?php echo $code; ?>">
                </form>
                <!-- /login form -->

                <hr />

            </div>
            <?php
               }else
               {
            ?>

            <div class="login-box">
                <div class="alert alert-danger  noborder text-center weight-400 nomargin noradius">
                   <h4>نعتذر عن الإزعاج .. الرجاء تحديث رقم الجوال الخاص بك</h4>
                </div>

                <!-- login form -->
                <form action="" method="post" class="sky-form boxed">

                   <header class="">
                   <h2 style="text-align: center">مرحباً بك <?php echo $_SESSION['S_USERNAME']; ?> </h2>
                    </header>

                    <fieldset>

                        <section>
                            <label class="label pull-right" >رقم الجوال</label>
                            <label class="input">
                                <i class="icon-mobile fa fa-phone"></i>
                                <input type="number" pattern="/(7|8|9)\d{9}/" value="" name="emp_mobile" required="required">
                                <b class="tooltip tooltip-top-right">الرجاء ادخال رقم الجوال</b>
                            </label>

                        </section>

                    </fieldset>

                    <footer>
                        <button type="submit" class="btn btn-primary pull-right">تحديث بياناتي</button>

                    </footer>

                </form>
                <!-- /login form -->

                <hr />

            </div>

            <?php

            }
            ?>

        </div>

        <!-- JAVASCRIPT FILES -->
        <script type="text/javascript">var plugin_path = 'assets/plugins/';</script>
        <script type="text/javascript" src="assets/plugins/jquery/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="assets/js/app.js"></script>
    </body>
</html>
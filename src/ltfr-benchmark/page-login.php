<?
 date_default_timezone_set("Asia/Riyadh");
include "administrator/config.php";
include "administrator/config_or.php";
include "administrator/fun/fun.php";
session_start();
if($_SESSION['login']=="okk")
{
     if($_SESSION['admin']=='1')
        			    echo '<script>window.location = "page-admin.php";</script>';
        			else
        			    echo '<script>window.location = "view.php";</script>';
        			    
        			    exit();
}

$flaq=-1;
if(isset($_POST['emp_id']) && isset($_POST['emp_password']))
{
		//or_user_session($emp);
		//echo '<script>window.location = "index.php";</script>';
        $emp=$_POST['emp_id'];
        $pass=$_POST['emp_password'];


		$sql="select * from users where username='$emp' and password='$pass'";
		$q=mysql_query($sql) or die(mysql_error($sql));

		if(mysql_num_rows($q)>0)
		{
			$row=mysql_fetch_array($q);

		    $_SESSION['userid']=$row['id'];
		    $_SESSION['username']=$row['username'];
		    $_SESSION['name']=$row['emp_name'];
		    $_SESSION['admin']=$row['isadmin'];
		    $_SESSION['login']="okk";
		    

                 /*   $flaq=2;
        			or_user_session($row,1);
                    add_log(0,1,$_SESSION['S_USERID'],'');
                    //echo $_SESSION['S_ISADMIN'];
                    //exit();  */
                    
                    
                    if($_SESSION['admin']=='1')
        			    echo '<script>window.location = "page-admin.php";</script>';
        			else
        			    echo '<script>window.location = "view.php";</script>';
                

            
           exit();
		}else
		{
			$flaq=2;
			// $_SESSION['err_msg']="الرجاء التاكد من رقم الهوية او كلمة المرور";
			// echo '<script>window.location = "login.php";</script>';
			 //echo '<script>alert("الرجاء التاكد من رقم الهوية او كلمة المرور"); window.history.back();</script>';
		}

    }  
	
    

?>

<!doctype html>
<html lang="en-US">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>Login Page | الشركة السعودية لإعادة التمويل العقاري</title>
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
	<body style="background-color: rgba(255, 255, 255, 1) !important;">


		<div class="padding-15">

			<div class="login-box">

				<!-- login form -->
				<form action="page-login.php" method="post" class="sky-form boxed">

                   <header class="text-center">
                   <img src="https://srco.com.sa/wp-content/uploads/2018/10/SRC-LOGO_Final4_S.png">    <hr>
                    <? if($flaq!=1)echo 'الشركة السعودية لإعادة التمويل العقاري';?>
                    </header>

                    <?
					if($flaq==2)
                    {
                        echo'
		        			<div class="alert alert-danger noborder text-center weight-400 nomargin noradius">
	    		    		    Wrong Login
    				    	</div>
                        ';
                    }
                    if($flaq==1)
                    {
                        include"administrator/design/model.php";
                        echo'
               				<div class="alert alert-success noborder text-center weight-400 nomargin noradius">

			        		</div>

                            ';
                    }
                      ?>
                    <!--
					<div class="alert alert-warning noborder text-center weight-400 nomargin noradius">
						Account Inactive!
					</div>

					<div class="alert alert-default noborder text-center weight-400 nomargin noradius">
						<strong>Too many failures!</strong> <br />
						Please wait: <span class="inlineCountdown" data-seconds="180"></span>
					</div>
					-->
                  	<?  if($flaq!=1)
					{echo'
					<fieldset>

						<section>
							<label class="label" >Username</label>
							<label class="input">
								<i class="icon-append fa fa-envelope"></i>
								<input type="emp_id" value="" name="emp_id" required="required">

							</label>
						</section>

						<section>
							<label class="label">Password</label>
							<label class="input">
								<i class="icon-append fa fa-lock"></i>
								<input type="password" value=""  name="emp_password" required="required">
								<b class="tooltip tooltip-top-right">please enter password</b>
							</label>

						</section>

					</fieldset>
                    '; }
                    if($flaq!=1){
                    echo'
					<footer>
						<button type="submit" class="btn btn-primary pull-right">Log In</button>

					</footer>';
					} ?>
				</form>
				<!-- /login form -->

				<hr />
			
			</div>

		</div>

		<!-- JAVASCRIPT FILES -->
		<script type="text/javascript">var plugin_path = 'assets/plugins/';</script>
		<script type="text/javascript" src="assets/plugins/jquery/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="assets/js/app.js"></script>
	</body>
</html>
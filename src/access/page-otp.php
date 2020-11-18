<?
 date_default_timezone_set("Asia/Riyadh");
include "administrator/config.php";
include "administrator/config_or.php";
include "administrator/fun/fun.php";

require 'mail/vendor/autoload.php';
    use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
session_start();
if($_SESSION['login']=="okk")
{
     if($_SESSION['admin']=='1'){
        			    echo '<script>window.location = "page-admin.php";</script>'; 
         exit();
     }
        			    
       elseif($_SESSION['admin_ok']=='1'){	 
           
       }
        			else{
        			    echo '<script>window.location = "view.php";</script>';
        			    
        			    exit();
        			    
        			}
}else{
    
       echo '<script>window.location = "page-login.php";</script>'; 
         exit();
}

if($_SESSION['sent_otp']=="ok"){
    //
}else{
    $_SESSION['sent_otp']="ok";


// Load Composer's autoloader


// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = false;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.office365.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;   
	// Enable SMTP authentication
    $mail->Username   = 'notifications@osit.com.sa';                     // SMTP username
    $mail->Password   = '@Notification321';                               // SMTP password
    $mail->SMTPSecure = 'STARTTLS';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
    $mail->Port       = 587;      
    //Recipients
    $mail->setFrom('notifications@osit.com.sa', 'OSIT Notifications');
    $mail->addAddress('kalqahtani@srco.com.sa', '');  

    // Attachments 
  // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
   // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$otp = mt_rand(100000, 999999);
 $_SESSION['otp_password']=$otp;
    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'SRCO ACCESS ADMIN LOGIN OTP';
    $mail->Body    = 'Your OTP For Login SRCO ACCESS is : <b>'.$otp.'</b>';
    $mail->AltBody = 'Your OTP For Login SRCO ACCESS is : '.$otp;

    $mail->send();
  //  echo 'Message has been sent';
} catch (Exception $e) {
   // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}


   
}

$flaq=-1;

    if(isset($_POST['otp_password']))
{
     if($_SESSION['otp_password']==$_POST['otp_password']){
         $_SESSION['admin']='1';
           echo '<script>window.location = "page-admin.php";</script>'; 
         exit();
     }else{
         $flaq=2;
         
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
				<form action="page-otp.php" method="post" class="sky-form boxed">

                   <header class="text-center">
                   <img src="https://srco.com.sa/wp-content/uploads/2018/10/SRC-LOGO_Final4_S.png">    <hr>
                    <? if($flaq!=1)echo 'الشركة السعودية لإعادة التمويل العقاري';?>
                    </header>

                    <?
					if($flaq==2)
                    {
                        echo'
		        			<div class="alert alert-danger noborder text-center weight-400 nomargin noradius">
	    		    		    Inavlid OTP !!!
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
							<label class="label">OTP</label>
							<label class="input">
								<i class="icon-append fa fa-lock"></i>
								<input type="password" value=""  name="otp_password" required="required">
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
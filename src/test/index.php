<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function

set_time_limit(10);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'mx.srco.com.sa';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;   
    
	// Enable SMTP authentication
    $mail->Username   = 'wm@srco.com.sa';                     // SMTP username
    $mail->Password   = 'WebM@!L1';                               // SMTP password
    $mail->SMTPSecure = false;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
    $mail->Port       = 25;      
    //Recipients
    $mail->setFrom('wm@srco.com.sa', 'Mailer');
    $mail->addAddress('r.rajbir@osit.com.sa', 'Rajbir');  

    // Attachments
  // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
   // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
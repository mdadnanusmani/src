<?php
/**
* @package JS Support Ticket SMTP
* @version 1.0.1
*/
/*
Plugin Name: JS Support Ticket SMTP
Plugin URI: https://www.joomsky.com
Description:  SMTP Addon for JS Support Ticket.
Author: Joom Sky
Version: 1.0.1
Author URI: https://www.joomsky.com
*/

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTSMTP{
    public static $_addon_version;

    function __construct() {
        self::$_addon_version = '1.0.1';
        add_action( 'plugins_loaded', array($this,'jsst_addon_update_check' ));

        //parent::__construct(__FILE__);
        self::includes();
        //add_filter('cron_schedules', array($this,'jsst_weekly_cron_notify' ));
        register_activation_hook(__FILE__, array($this, 'jstsupportitkcetaddon_activate_hook'));
        register_deactivation_hook(__FILE__, array($this, 'jssupportticketaddon_deactivate_hook'));

        add_action('jsst_aadon_send_smtp_mail', array($this, 'sendSMTPEmail') , 10, 7);
    }

	function includes(){
		if(is_admin()){
			//include_once 'includes/jsticketdesktopnotificationadmin.php';
		}
		//include_once 'includes/shotcodes.php';

	}

    function jsst_addon_update_check() {
        // to manage updates for addon
        if(file_exists(dirname(__FILE__).'/includes/addon-sql.php') && realpath(dirname(__FILE__).'/includes/addon-sql.php')){
            require dirname(__FILE__).'/includes/addon-sql.php';
            @unlink(dirname(__FILE__).'/includes/addon-sql.php');
            update_option('jsst-addon-smtp-version',JSSTSMTP::$_addon_version);
        }
    }

    function jstsupportitkcetaddon_activate_hook(){
        if ( !class_exists('jssupportticket') ) {
            deactivate_plugins( plugin_basename( __FILE__ ) );
            wp_die( 'Install and activate JS Support Ticket Plugin for this plugin to work.' );
        }
        $plugin_data = get_plugin_data( __FILE__ );
        $plugin_version = $plugin_data['Version'];
        if(!JSSTincluder::getJSModel('jssupportticket')->updateDate('smtp',$plugin_version)){
            do_action('jsst_addon_update_date_failed');
        }
        update_option('jsst-addon-smtp-version',JSSTSMTP::$_addon_version);
        // include_once 'includes/activation.php';
        // JSTSMTPeactivation::jssupportticketaddon_activate();
        // wp_schedule_event(time(), 'weekly', 'jsstnotification_cronjobs_action');
        // update_option('jsstnotification_do_activation_redirect', true);
    }

    function jssupportticketaddon_deactivate_hook(){
        if (class_exists('jssupportticket') ) {
            JSSTincluder::getJSModel('premiumplugin')->logAddonDeactivation('smtp');
        }
        // include_once 'includes/activation.php';
        // JSTSMTPeactivation::jssupportticketaddon_deactivate();
    }

    static function sendSMTPEmail($recevierEmail, $subject, $body, $senderEmail, $senderName, $attachments, $action){
        require_once ABSPATH . WPINC . '/class-phpmailer.php';
        require_once ABSPATH . WPINC . '/class-smtp.php';
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {

            $emailconfig = JSSTincluder::getJSModel('email')->getSMTPEmailConfig($senderEmail);

            //Server settings
            //$mail->SMTPDebug = 2;                                // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP

            $mail->Host = $emailconfig->smtphost;  // Specify main and backup SMTP servers
            //$mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = $emailconfig->smtpauthencation;                               // Enable SMTP authentication
            $mail->Username = $senderEmail;                 // SMTP username
            $mail->Password = base64_decode($emailconfig->password);                           // SMTP password
            if($emailconfig->smtpsecure == 0){
                $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            }else{
                $mail->SMTPSecure = 'tls';
            }
            $mail->Port = $emailconfig->mailport;
                                      // TCP port to connect to
            //Recipients
            
            $senderEmail=$senderEmail."@srco.com.sa";
            $mail->setFrom($senderEmail, jssupportticket::$_config['title']);
            $mail->AddReplyTo($senderEmail, jssupportticket::$_config['title']);
            // foreach ($recevierEmail as $key => $value) {
            //     $mail->addAddress($value, 'Name Of User');     // Add a recipient
            // }
            $mail->addAddress($recevierEmail, 'Name Of User');     // Add a recipient

            //$mail->addAddress('ellen@example.com');               // Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('xaid@burujsolutions.com');


            //Attachments

            if(!empty($attachments)){
                $mail->addAttachment($attachments);         // Add attachments
            }
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            //echo 'Message has been sent';
            return ;
        } catch (Exception $e) {
           $error_text = 'Message could not be sent. Mailer Error: '. $mail->ErrorInfo;
           JSSTincluder::getJSModel('systemerror')->addSystemError($error_text);
        }
        return;
    }
}

$JSSTSMTP = new JSSTSMTP();

?>
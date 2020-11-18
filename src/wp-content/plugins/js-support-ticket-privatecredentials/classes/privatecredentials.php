<?php

if(!defined('ABSPATH'))
	die('Restricted Access');


class JSSTprivatecredentials{

    // The cipher method. openssl_get_cipher_methods returns list of all available methods
    private $cipher_method = "AES-256-CBC";

    // to return data on as is
    private $options = OPENSSL_RAW_DATA;

    private $secretKey;

    public function encrypt($text_for_enrcyption) {
        $this->secretKey = $this->secretKey();
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->cipher_method));

        $encrypted_text = openssl_encrypt( $text_for_enrcyption, $this->cipher_method, $this->secretKey, $this->options, $iv );
        $return_data = base64_encode($encrypted_text) . ':'. base64_encode($iv);

        return $return_data;
    }

    public function decrypt($encrypted_string) {
        $parts = explode(':', $encrypted_string);
        if (count($parts) != 2) {
            die('failed');
        }
        $encrypted_text = base64_decode($parts[0]);
        $iv = base64_decode($parts[1]);

        return openssl_decrypt( $encrypted_text, $this->cipher_method, $this->getSecretKeyForDcrpt(), $this->options, $iv);
    }

    private function secretKey(){
        $secretkey = JSSTincluder::getJSModel('configuration')->getConfigValue('private_credentials_secretkey');
        if($secretkey == ''){
            if(defined('JSST_PRIVATE_CREDENTIALS_KEY')){
                $secretkey = hash('sha256', JSST_PRIVATE_CREDENTIALS_KEY);
            }else{
                $secretkey = $this->generateSecretKey();
                $secretkey = hash('sha256', $secretkey);
                $result = jssupportticket::$_db->update(jssupportticket::$_db->prefix . 'js_ticket_config', array('configvalue' => $secretkey), array('configname' => 'private_credentials_secretkey'));
                if(!$result){
                    $error_message = 'Secrect key store failed';
                    JSSTincluder::getJSModel('systemerror')->addSystemError($error_message);
                }
            }
            // store secret key in configuration
        }
        return $secretkey;
    }

    private function getSecretKeyForDcrpt(){
        if(defined('JSST_PRIVATE_CREDENTIALS_KEY')){
            $secretkey = hash('sha256', JSST_PRIVATE_CREDENTIALS_KEY);
        }else{
            $secretkey = JSSTincluder::getJSModel('configuration')->getConfigValue('private_credentials_secretkey');
        }
        return $secretkey;
    }

   // Generate a key of given length;

    public static function generateSecretKey($length = 128){
        return  bin2hex(openssl_random_pseudo_bytes($length));
    }
}

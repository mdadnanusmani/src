<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTpremiumpluginModel {

    private static $server_url = 'https://jshelpdesk.com/setup/index.php';

    function verfifyAddonActivation($addon_name){
        $option_name = 'transaction_key_for_js-support-ticket-'.$addon_name;
        $transaction_key = get_option($option_name);
        try {
            if (! $transaction_key ) {
                throw new Exception( 'License key not found' );
            }
            if ( empty( $transaction_key ) ) {
                throw new Exception( 'License key not found' );
            }
            $activate_results = $this->activate( array(
                'token'    => $transaction_key,
                'plugin_slug'    => $addon_name
            ) );
            if ( false === $activate_results ) {
                throw new Exception( 'Connection failed to the server' );
            } elseif ( isset( $activate_results['error_code'] ) ) {
                throw new Exception( $activate_results['error'] );
            } elseif(isset($activate_results['verfication_status']) && $activate_results['verfication_status'] == 1 ){
                return true;
            }
            throw new Exception( 'License could not activate. Please contact support.' );
        } catch ( Exception $e ) {
            echo '<div class="notice notice-error is-dismissible">
                    <p>'.$e->getMessage().'.</p>
                </div>';
            return false;
        }
    }

    function logAddonDeactivation($addon_name){
        $option_name = 'transaction_key_for_js-support-ticket-'.$addon_name;
        $transaction_key = get_option($option_name);

        $activate_results = $this->deactivate( array(
            'token'    => $transaction_key,
            'plugin_slug'    => $addon_name
        ) );
    }

    function logAddonDeletion($addon_name){
        $option_name = 'transaction_key_for_js-support-ticket-'.$addon_name;
        $transaction_key = get_option($option_name);
        $activate_results = $this->delete( array(
            'token'    => $transaction_key,
            'plugin_slug'    => $addon_name
        ) );
    }

    public static function activate( $args ) {
        $defaults = array(
            'request'  => 'activate',
            'domain' => site_url(),
            'activation_call' => 1
        );

        $args    = wp_parse_args( $defaults, $args );
        $request = wp_remote_get( self::$server_url . '?' . http_build_query( $args, '', '&' ) );

        if ( is_wp_error( $request ) ) {
            return json_encode( array( 'error_code' => $request->get_error_code(), 'error' => $request->get_error_message() ) );
        }

        if ( wp_remote_retrieve_response_code( $request ) != 200 ) {
            return json_encode( array( 'error_code' => wp_remote_retrieve_response_code( $request ), 'error' => 'Error code: ' . wp_remote_retrieve_response_code( $request ) ) );
        }
        $response =  wp_remote_retrieve_body( $request );
        $response = json_decode($response,true);
        return $response;
    }

    /**
     * Attempt t deactivate a license
     */
    public static function deactivate( $dargs ) {
        $defaults = array(
            'request'  => 'deactivate',
            'domain' => site_url()
        );

        $args    = wp_parse_args( $defaults, $dargs );
        $request = wp_remote_get( self::$server_url . '?' . http_build_query( $args, '', '&' ) );
        if ( is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) != 200 ) {
            return false;
        } else {
            return wp_remote_retrieve_body( $request );
        }
    }
    /**
     * Attempt t deactivate a license
     */
    public static function delete( $args ) {
        $defaults = array(
            'request'  => 'delete',
            'domain' => site_url(),
        );

        $args    = wp_parse_args( $defaults, $args );
        $request = wp_remote_get( self::$server_url . '?' . http_build_query( $args, '', '&' ) );
        if ( is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) != 200 ) {
            return false;
        } else {
            return;
        }
    }

}

?>
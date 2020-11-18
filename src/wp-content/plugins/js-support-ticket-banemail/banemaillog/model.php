<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTbanemaillogModel {

    function getBanEmailLogs() {
        // Filter
        $loggeremail = JSSTrequest::getVar('loggeremail');
        $inquery = '';

        $formsearch = JSSTrequest::getVar('JSST_form_search', 'post');
        if ($formsearch == 'JSST_SEARCH') {
            $_SESSION['JSST_SEARCH']['loggeremail'] = $loggeremail;
        }

        if (JSSTrequest::getVar('pagenum', 'get', null) != null) {
            $loggeremail = (isset($_SESSION['JSST_SEARCH']['loggeremail']) && $_SESSION['JSST_SEARCH']['loggeremail'] != '') ? $_SESSION['JSST_SEARCH']['loggeremail'] : null;
        }

        if ($loggeremail != null)
            $inquery .= " WHERE banemaillog.loggeremail LIKE '%$loggeremail%'";

        jssupportticket::$_data['filter']['loggeremail'] = $loggeremail;

        // Pagination
        $query = "SELECT COUNT(`id`) FROM `" . jssupportticket::$_db->prefix . "js_ticket_banlist_log` AS  banemaillog ";
        $query .= $inquery;
        $total = jssupportticket::$_db->get_var($query);
        jssupportticket::$_data[1] = JSSTpagination::getPagination($total);

        // Data
        $query = "SELECT banemaillog.*
					FROM`" . jssupportticket::$_db->prefix . "js_ticket_banlist_log` AS banemaillog
					";
        $query .= $inquery;
        $query .= " ORDER BY banemaillog.created DESC  LIMIT " . JSSTpagination::getOffset() . ", " . JSSTpagination::getLimit();
        jssupportticket::$_data[0] = jssupportticket::$_db->get_results($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return;
    }

    function storebanemaillog($data) {
        $data['id'] = isset($data['id']) ? $data['id'] : '';
        if (!$data['id'])
            $data['created'] = date_i18n('Y-m-d H:i:s');
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);
        $row = JSSTincluder::getJSTable('banemaillog');

        $data = JSSTincluder::getJSmodel('jssupportticket')->stripslashesFull($data);// remove slashes with quotes.
        $error = 0;
        if (!$row->bind($data)) {
            $error = 1;
        }
        if (!$row->store()) {
            $error = 1;
        }

        if ($error == 1) {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
        }
        return;
    }

    function checkbandata() {
        $post_data['serialnumber'] = isset(jssupportticket::$_config['serialnumber']) ? jssupportticket::$_config['serialnumber'] : '';
        $post_data['zvdk'] = isset(jssupportticket::$_config['zvdk']) ? jssupportticket::$_config['zvdk'] : '';
        $post_data['hostdata'] = isset(jssupportticket::$_config['hostdata']) ? jssupportticket::$_config['hostdata'] : '';
        $post_data['domain'] = site_url();
        $url = JCONSTV;

        $response = wp_remote_post( $url, array('body' => $post_data,'timeout'=>7,'sslverify'=>false));
        if( !is_wp_error($response) && $response['response']['code'] == 200 && isset($response['body']) ){
            $result = $response['body'];
        }else{
            $result = false;
            if(!is_wp_error($response)){
               $error = $response['response']['message'];
           }else{
                $error = $response->get_error_message();
           }
        }
        if($result){
            $res= json_decode($result, true);
        }else{
            return FALSE;
        }
    }

    function removeBanEmailLog($id) {
        if (!is_numeric($id))
            return false;
        if ($this->canRemoveBanEmailLog($id)) {

            $row = JSSTincluder::getJSTable('banemaillog');
            if ($row->delete($id)) {
                JSSTincluder::getJSModel('systemerror')->addSystemError();
            }
        }
        return;
    }

    private function canRemoveBanEmailLog($id) {
        return true;
    }

}

?>

<?php
if (!defined('ABSPATH'))
    die('Restricted Access');
class JSTWidgetsactivation {

    static function jssupportticketaddon_activate() {
        // Install Database
        JSTWidgetsactivation::runSQL();
    }

    static function jssupportticketaddon_deactivate() {
    }

    static private function runSQL() {
        if(file_exists(dirname(__FILE__).'/addon-sql.php') && realpath(dirname(__FILE__).'/addon-sql.php')){
            require dirname(__FILE__).'/addon-sql.php';
            @unlink(dirname(__FILE__).'/addon-sql.php');
        }
        return;
    }
}
?>
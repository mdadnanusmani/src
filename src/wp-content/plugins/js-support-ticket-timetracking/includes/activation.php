<?php
if (!defined('ABSPATH'))
    die('Restricted Access');
class JSTTimeTrackingeactivation {

    static function jssupportticketaddon_activate() {
        // Install Database
        JSTTimeTrackingeactivation::runSQL();
    }

    static function jssupportticketaddon_deactivate() {

    }

    static private function runSQL() {
        // create table if does not exsists
            if(file_exists(dirname(__FILE__).'/addon-sql.php') && realpath(dirname(__FILE__).'/addon-sql.php')){
                require dirname(__FILE__).'/addon-sql.php';
                @unlink(dirname(__FILE__).'/addon-sql.php');
            }

        return;
    }
}
?>
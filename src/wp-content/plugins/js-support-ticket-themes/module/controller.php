<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTthemesController {

    function __construct() {
        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSSTrequest::getLayout('jstlay', null, 'controlpanel');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_themes':
                    JSSTincluder::getJSModel('themes')->getCurrentTheme();
                    break;
            }
            $module = (is_admin()) ? 'page' : 'jstmod';
            $module = JSSTrequest::getVar($module, null, 'themes');
            JSSTincluder::include_file($layout, $module);
        }
    }

    function canaddfile() {
        if (isset($_POST['form_request']) && $_POST['form_request'] == 'themes')
            return false;
        elseif (isset($_GET['action']) && $_GET['action'] == 'jstask')
            return false;
        else
            return true;
    }
    static function savetheme() {
        $data = JSSTrequest::get('post');
        JSSTincluder::getJSModel('themes')->storeTheme($data);
        $url = admin_url("admin.php?page=themes&jstlay=themes");
        wp_redirect($url);
        exit;
    }

}

$controlpanelController = new JSSTthemesController();
?>

<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTnotificationController {

    function canaddfile() {
        if (isset($_POST['form_request']) && $_POST['form_request'] == 'jssupportticket')
            return false;
        elseif (isset($_GET['action']) && $_GET['action'] == 'jstask')
            return false;
        else
            return true;
    }


}

$JSSTnotificationController = new JSSTnotificationController();
?>

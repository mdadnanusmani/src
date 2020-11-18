<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTajax {

    function __construct() {
        add_action("wp_ajax_jsticket_ajax", array($this, "ajaxhandler")); // when user is login
        add_action("wp_ajax_nopriv_jsticket_ajax", array($this, "ajaxhandler")); // when user is not login
    }

    function ajaxhandler() {
        $functions_allowed = array('DataForDepandantField','subscribeForNotifications','unsubscribeFromNotifications','getDownloadById','getAllDownloads','sendTestEmail','getuserlistajax','getFieldsForComboByFieldFor','getSectionToFillValues','getListTranslations','validateandshowdownloadfilename','getlanguagetranslation','updateUserDevice','checkParentType','checkChildType','makeParentOfType','getTypeForByParentId','getusersearchstaffreportajax','getusersearchuserreportajax','getusersearchajax','saveuserprofileajax','getHelpTopicByDepartment','getpremadeajax','getPremadeByDepartment','getTicketsForMerging','getLatestReplyForMerging','getReplyDataByID','getTimeByReplyID','getTimeByNoteID','readEmailsAjax','getOptionsForFieldEdit','storePrivateCredentials','getFormForPrivteCredentials', 'getPrivateCredentials', 'removePrivateCredential','getWcOrderProductsAjax');
        $task = JSSTrequest::getVar('task');
        if($task != '' && in_array($task, $functions_allowed)){
            $module = JSSTrequest::getVar('jstmod');
            $result = JSSTincluder::getJSModel($module)->$task();
            echo $result;
            die();
        }else{
            die('Not Allowed!');
        }
    }

}

$jsajax = new JSSTajax();
?>

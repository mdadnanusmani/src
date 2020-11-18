<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTExportController {

    function __construct() {
        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSSTrequest::getLayout('jstlay', null, 'export');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_export':
                    // $id = JSSTrequest::getVar('jssupportticketid');
                    // JSSTincluder::getJSModel('announcement')->getAnnouncementDetails($id);
                    break;
            }
            $module = (is_admin()) ? 'page' : 'jstmod';
            $module = JSSTrequest::getVar($module, null, 'export');
            JSSTincluder::include_file($layout, $module);
        }
    }

    function canaddfile() {
        if (isset($_POST['form_request']) && $_POST['form_request'] == 'jssupportticket')
            return false;
        elseif (isset($_GET['action']) && $_GET['action'] == 'jstask')
            return false;
        else
            return true;
    }

    function getoverallexport() {

        $return_value = JSSTincluder::getJSModel('export')->setOverallExport();

        if (!empty($return_value)) {
            // Push the report now!
            $msg = __('Overall Reports', 'js-jobs');
            $name = 'export-overalll-reports';
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=" . $name . ".xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            header("Lacation: excel.htm?id=yes");
            print $return_value;
            exit;
        }
        die();
    }

    function getstaffmemberexport() {

        $return_value = JSSTincluder::getJSModel('export')->setStaffMemberExport();
        //var_dump($return_value);
        //die();
        if (!empty($return_value)) {
            // Push the report now!
            $msg = __('Staff Members Report', 'js-jobs');
            $name = 'export-overalll-reports';
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=" . $name . ".xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            header("Lacation: excel.htm?id=yes");
            print $return_value;
            exit;
        }
        die();
    }

    function getstaffmemberexportbystaffid() {
        $return_value = JSSTincluder::getJSModel('export')->setStaffMemberExportByStaffId();
        if (!empty($return_value)) {
            // Push the report now!
            $msg = __('Staff Members Report', 'js-jobs');
            $name = 'export-overalll-reports';
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=" . $name . ".xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            header("Lacation: excel.htm?id=yes");
            print $return_value;
            exit;
        }
        die();
    }

    function getdepartmentmemberexportbydepartmentid() {
        $return_value = JSSTincluder::getJSModel('export')->setDepartmentExportByDepartmentId();
        if (!empty($return_value)) {
            // Push the report now!
            $msg = __('Department Report', 'js-jobs');
            $name = 'department-reports';
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=" . $name . ".xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            header("Lacation: excel.htm?id=yes");
            print $return_value;
            exit;
        }
        die();
    }


    function getdepartmentexport() {

        $return_value = JSSTincluder::getJSModel('export')->setDepartmentExport();
        //var_dump($return_value);
        //die();
        if (!empty($return_value)) {
            // Push the report now!
            $msg = __('Departments Report', 'js-jobs');
            $name = 'Departments-reports';
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=" . $name . ".xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            header("Lacation: excel.htm?id=yes");
            print $return_value;
            exit;
        }
        die();
    }


    function getusersexport() {
        $return_value = JSSTincluder::getJSModel('export')->setUsersExport();
        if (!empty($return_value)) {
            // Push the report now!
            $msg = __('Staff Members Report', 'js-jobs');
            $name = 'export-overalll-reports';
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=" . $name . ".xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            header("Lacation: excel.htm?id=yes");
            print $return_value;
            exit;
        }
        die();
    }

    function getuserexportbyuid() {
        $return_value = JSSTincluder::getJSModel('export')->setUserExportByuid();
        if (!empty($return_value)) {
            // Push the report now!
            $msg = __('Staff Members Report', 'js-jobs');
            $name = 'export-overalll-reports';
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=" . $name . ".xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            header("Lacation: excel.htm?id=yes");
            print $return_value;
            exit;
        }
        die();
    }

    function getticketsexport() {
        $return_value = JSSTincluder::getJSModel('export')->setTicketsExport();
        if (!empty($return_value)) {
            // Push the report now!
            $msg = __('Tickets', 'js-jobs');
            $name = 'tickets-data';
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=" . $name . ".xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            header("Lacation: excel.htm?id=yes");
            print $return_value;
            exit;
        }
        die();
    }
}
$exportController = new JSSTExportController();
?>
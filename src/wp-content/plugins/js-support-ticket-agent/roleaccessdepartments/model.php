<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTroleaccessdepartmentsModel {

    function storeRoleAccessDepartments($departmentaccess, $roleid) {
        if (!is_numeric($roleid))
            return false;
        $new_departments = array();
        $query = "SELECT departmentid
				FROM `" . jssupportticket::$_db->prefix . "js_ticket_acl_role_access_departments` WHERE roleid = " . $roleid;
        $old_departments = jssupportticket::$_db->get_results($query);
        if(is_array($departmentaccess)){
            foreach ($departmentaccess AS $key => $value) {
                $new_departments[] = $value;
            }
        }

        $error = array();
        foreach ($old_departments AS $olddepid) {
            $match = false;
            foreach ($new_departments AS $depid) {
                if ($olddepid->departmentid == $depid) {
                    $match = true;
                    break;
                }
            }
            if ($match == false) {
                $query = "DELETE FROM `" . jssupportticket::$_db->prefix . "js_ticket_acl_role_access_departments` WHERE roleid = " . $roleid . " AND departmentid=" . $olddepid->departmentid;
                jssupportticket::$_db->query($query);
                if (jssupportticket::$_db->last_error != null) {
                    JSSTincluder::getJSModel('systemerror')->addSystemError();
                }
            }
        }
        foreach ($new_departments AS $depid) {
            $insert = true;
            foreach ($old_departments AS $olddepid) {
                if ($olddepid->departmentid == $depid) {
                    $insert = false;
                    break;
                }
            }
            if ($insert) {


                $data['roleid'] = $roleid;
                $data['departmentid'] = $depid;
                $data['status'] = 1;
                $data['created'] = date_i18n('Y-m-d H:i:s');

                $row = JSSTincluder::getJSTable('acl_role_access_departments');

                $data = JSSTincluder::getJSmodel('jssupportticket')->stripslashesFull($data);// remove slashes with quotes.
                $error = 0;
                if (!$row->bind($data)) {
                    $error = 1;
                }
                if (!$row->store()) {
                    $error = 1;
                }

                if ($error == 1) {
                    JSSTincluder::getJSModel('systemerror')->addSystemError();
                }
            } else { // update permission
                /*
                  $query = "UPDATE `".jssupportticket::$_db->prefix."js_ticket_acl_role_access_departments`
                  SET permissionlevel = ".$permissionlevel[$depid]."
                  WHERE roleid = " . $roleid . " AND departmentid=" . $depid;
                  jssupportticket::$_db->query($query);
                  if(jssupportticket::$_db->last_error  != null){
                  JSSTincluder::getJSModel('systemerror')->addSystemError();
                  }
                 */
            }
        }
    }

}

?>

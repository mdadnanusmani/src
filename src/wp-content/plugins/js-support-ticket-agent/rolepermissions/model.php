<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTrolepermissionsModel {

    function storeRolePermissions($permissions, $roleid) {
        if ( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()) {
            $allowed = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Assign Role Permissions');
            if ($allowed != true) {
                JSSTmessage::setMessage(__('You are not allowed', 'js-support-ticket'), 'updated');
                return;
            }
        }
        if (!is_numeric($roleid))
            return false;
        $new_permissions = array();
        $query = "SELECT permissionid FROM `" . jssupportticket::$_db->prefix . "js_ticket_acl_role_permissions` WHERE roleid = " . $roleid;
        $old_permissions = jssupportticket::$_db->get_results($query);
        foreach ($permissions AS $key => $value) {
            $new_permissions[] = $value;
        }
        foreach ($old_permissions AS $oldperid) {
            $match = false;
            foreach ($new_permissions AS $perid) {
                if ($oldperid->permissionid == $perid) {
                    $match = true;
                    break;
                }
            }
            if ($match == false) {
                $query = "DELETE FROM `" . jssupportticket::$_db->prefix . "js_ticket_acl_role_permissions` WHERE roleid = " . $roleid . " AND permissionid=" . $oldperid->permissionid;
                jssupportticket::$_db->query($query);
                if (jssupportticket::$_db->last_error != null) {
                    JSSTincluder::getJSModel('systemerror')->addSystemError();
                }
            }
        }

        foreach ($new_permissions AS $perid) {
            $insert = true;
            foreach ($old_permissions AS $oldperid) {
                if ($oldperid->permissionid == $perid) {
                    $insert = false;
                    break;
                }
            }
            if ($insert) {
                // replace query;

                $data['roleid'] = $roleid;
                $data['permissionid'] = $perid;
                $data['isgranted'] = 1;
                $data['status'] = 1;

                $row = JSSTincluder::getJSTable('acl_role_permissions');

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
            }
        }
    }

    function getRolePermissions($roleid) {
        if (empty($roleid) || (!is_numeric($roleid)))
            return false;
        $query = "SELECT permissionid FROM `" . jssupportticket::$_db->prefix . "js_ticket_acl_role_permissions` WHERE roleid = " . $roleid;
        $permissions = jssupportticket::$_db->get_results($query);

        return $permissions;
    }

}

?>

<?php

if(!defined('ABSPATH'))
	die('Restricted Access');

class JSSTacl_role_permissionsTable extends JSSTtable {

	public $id = '';
	public $roleid = '';
	public $permissionid = '';
	public $isgranted = '';
	public $status = '';

	function __construct() {
		parent::__construct('acl_role_permissions', 'id'); // tablename, primarykey
	}

}

?>
<?php

if(!defined('ABSPATH'))
	die('Restricted Access');

class JSSTacl_user_permissionsTable extends JSSTtable {

	public $id = '';
	public $uid = '';
	public $roleid = '';
	public $staffid = '';
	public $permissionid = '';
	public $isgranted = '';
	public $status = '';

	function __construct() {
		parent::__construct('acl_user_permissions', 'id'); // tablename, primarykey
	}

}

?>
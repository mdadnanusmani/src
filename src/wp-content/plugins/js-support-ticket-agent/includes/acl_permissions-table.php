<?php

if(!defined('ABSPATH'))
	die('Restricted Access');

class JSSTacl_permissionsTable extends JSSTtable {

	public $id = '';
	public $permission = '';
	public $permissiongroup = '';
	public $status = '';

	function __construct() {
		parent::__construct('acl_permissions', 'id'); // tablename, primarykey
	}

}

?>
<?php

if(!defined('ABSPATH'))
	die('Restricted Access');

class JSSTacl_role_access_departmentsTable extends JSSTtable {

	public $id = '';
	public $roleid = '';
	public $departmentid = '';
	public $status = '';
	public $created = '';

	function __construct() {
		parent::__construct('acl_role_access_departments', 'id'); // tablename, primarykey
	}

}

?>
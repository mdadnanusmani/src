<?php

if(!defined('ABSPATH'))
	die('Restricted Access');

class JSSTacl_user_access_departmentsTable extends JSSTtable {

	public $id = '';
	public $uid = '';
	public $roleid = '';
	public $staffid = '';
	public $departmentid = '';
	public $status = '';

	function __construct() {
		parent::__construct('acl_user_access_departments', 'id'); // tablename, primarykey
	}

}

?>
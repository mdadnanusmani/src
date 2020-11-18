<?php

if(!defined('ABSPATH'))
	die('Restricted Access');

class JSSTacl_rolesTable extends JSSTtable {

	public $id = '';
	public $name = '';
	public $status = '';
	public $parentid = '';
	public $created = '';

	function __construct() {
		parent::__construct('acl_roles', 'id'); // tablename, primarykey
	}

}

?>
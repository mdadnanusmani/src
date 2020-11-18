<?php

if(!defined('ABSPATH'))
	die('Restricted Access');

class JSSTuserroleTable extends JSSTtable {

	public $id = '';
	public $uid = '';
	public $roleid = '';
	public $status = '';
	public $update = '';
	public $created = '';

	function __construct() {
		parent::__construct('userrole', 'id'); // tablename, primarykey
	}

}

?>
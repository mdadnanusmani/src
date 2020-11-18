<?php

if(!defined('ABSPATH'))
	die('Restricted Access');

class JSSTagentTable extends JSSTtable {

	public $id = '';
	public $uid = '';
	public $groupid = '';
	public $roleid = '';
	public $departmentid = '';
	public $firstname = '';
	public $lastname = '';
	public $username = '';
	public $email = '';
	public $phone = '';
	public $phoneext = '';
	public $mobile = '';
	public $signature = '';
	public $isadmin = '';
	public $isvisible = '';
	public $onvocation = '';
	public $appendsignature = '';
	public $autorefreshrate = '';
	public $photo = '';
	public $status = '';
	public $created = '';
	public $lastlogin = '';
	public $updated = '';

	function __construct() {
		parent::__construct('staff', 'id'); // tablename, primarykey
	}

}

?>
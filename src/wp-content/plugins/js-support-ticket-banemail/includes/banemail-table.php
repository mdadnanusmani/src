<?php

if(!defined('ABSPATH'))
	die('Restricted Access');

class JSSTbanemailTable extends JSSTtable {

	public $id = '';
	public $email = '';
	public $submitter = '';
	public $uid = '';
	public $created = '';

	function __construct() {
		parent::__construct('email_banlist', 'id'); // tablename, primarykey
	}

}

?>
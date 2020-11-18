<?php

if(!defined('ABSPATH'))
	die('Restricted Access');

class JSSTmailTable extends JSSTtable {

	public $id = '';
	public $fromid = '';
	public $toid = '';
	public $message = '';
	public $subject = '';
	public $isread = '';
	public $replytoid = '';
	public $deletedby = '';
	public $status = '';
	public $created = '';

	function __construct() {
		parent::__construct('staff_mail', 'id'); // tablename, primarykey
	}

}

?>
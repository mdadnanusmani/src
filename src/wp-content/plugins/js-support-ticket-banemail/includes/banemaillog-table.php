<?php

if(!defined('ABSPATH'))
	die('Restricted Access');

class JSSTbanemaillogTable extends JSSTtable {

	public $id = '';
	public $loggeremail = '';
	public $title = '';
	public $log = '';
	public $logger = '';
	public $ipaddress = '';
	public $created = '';

	function __construct() {
		parent::__construct('banlist_log', 'id'); // tablename, primarykey
	}

}

?>
<?php

if(!defined('ABSPATH'))
	die('Restricted Access');

class JSSTprivatecredentialsTable extends JSSTtable {

	public $id = '';
	public $ticketid = '';
	public $uid = '';
	public $data = '';
	public $status = '';
	public $created = '';

	function __construct() {
		parent::__construct('privatecredentials', 'id'); // tablename, primarykey
	}

}

?>
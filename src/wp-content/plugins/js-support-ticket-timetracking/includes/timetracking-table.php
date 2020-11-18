<?php

if(!defined('ABSPATH'))
	die('Restricted Access');

class JSSTtimetrackingTable extends JSSTtable {

	public $id = '';
	public $ticketid = '';
	public $staffid = '';
	public $referencefor = '';
	public $referenceid = '';
	public $usertime = '';
	public $systemtime = '';
	public $conflict = '';
	public $description = '';
	public $status = '';
	public $created = '';

	function __construct() {
		parent::__construct('staff_time', 'id'); // tablename, primarykey
	}

}

?>
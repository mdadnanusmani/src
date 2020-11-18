<?php

if(!defined('ABSPATH'))
	die('Restricted Access');

class JSSThelptopicTable extends JSSTtable {

	public $id = '';
	public $isactive = '';
	public $autoresponce = '';
	public $departmentid = '';
	public $priorityid = '';
	public $topic = '';
	public $ordering = '';
	public $created = '';
	public $updated = '';
	public $status = '';

	function __construct() {
		parent::__construct('help_topics', 'id'); // tablename, primarykey
	}

}

?>
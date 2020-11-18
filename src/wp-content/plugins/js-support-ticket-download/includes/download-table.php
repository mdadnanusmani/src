<?php

if(!defined('ABSPATH'))
	die('Restricted Access');

class JSSTdownloadTable extends JSSTtable {

	public $id = '';
	public $categoryid = '';
	public $title = '';
	public $description = '';
	public $staffid = '';
	public $ordering = '';
	public $downloads = '';
	public $status = '';
	public $created = '';

	function __construct() {
		parent::__construct('downloads', 'id'); // tablename, primarykey
	}

}

?>
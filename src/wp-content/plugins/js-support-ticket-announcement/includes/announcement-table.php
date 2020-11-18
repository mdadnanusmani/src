<?php

if(!defined('ABSPATH'))
	die('Restricted Access');

class JSSTannouncementTable extends JSSTtable {

	public $id = '';
	public $categoryid = '';
	public $title = '';
	public $description = '';
	public $staffid = '';
	public $ordering = '';
	public $type = '';
	public $status = '';
	public $created = '';

	function __construct() {
		parent::__construct('announcements', 'id'); // tablename, primarykey
	}

}

?>
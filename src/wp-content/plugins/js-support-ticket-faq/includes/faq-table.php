<?php

if(!defined('ABSPATH'))
	die('Restricted Access');

class JSSTfaqTable extends JSSTtable {

	public $id = '';
	public $categoryid = '';
	public $staffid = '';
	public $subject = '';
	public $content = '';
	public $views = '';
	public $ordering = '';
	public $created = '';
	public $status = '';

	function __construct() {
		parent::__construct('faqs', 'id'); // tablename, primarykey
	}

}

?>
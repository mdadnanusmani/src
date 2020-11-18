<?php

if(!defined('ABSPATH'))
	die('Restricted Access');

class JSSTarticlesTable extends JSSTtable {

	public $id = '';
	public $categoryid = '';
	public $staffid = '';
	public $subject = '';
	public $content = '';
	public $views = '';
	public $type = '';
	public $ordering = '';
	public $metadesc = '';
	public $metakey = '';
	public $status = '';
	public $created = '';

	function __construct() {
		parent::__construct('articles', 'id'); // tablename, primarykey
	}

}

?>
<?php

if(!defined('ABSPATH'))
	die('Restricted Access');

class JSSTcategoriesTable extends JSSTtable {

	public $id = '';
	public $name = '';
	public $parentid = '';
	public $totalarticles = '';
	public $hits = '';
	public $metadesc = '';
	public $metakey = '';
	public $logo = '';
	public $downloads = '';
	public $announcement = '';
	public $faqs = '';
	public $kb = '';
	public $staffid = '';
	public $ordering = '';
	public $type = '';
	public $status = '';
	public $created = '';

	function __construct() {
		parent::__construct('categories', 'id'); // tablename, primarykey
	}

}

?>
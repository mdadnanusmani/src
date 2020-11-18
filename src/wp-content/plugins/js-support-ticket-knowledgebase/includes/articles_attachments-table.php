<?php

if(!defined('ABSPATH'))
	die('Restricted Access');

class JSSTarticles_attachmentsTable extends JSSTtable {

	public $id = '';
	public $articleid = '';
	public $filename = '';
	public $filesize = '';
	public $filetype = '';
	public $staffid = '';
	public $status = '';
	public $created = '';

	function __construct() {
		parent::__construct('articles_attachments', 'id'); // tablename, primarykey
	}

}

?>
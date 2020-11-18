<?php

if(!defined('ABSPATH'))
	die('Restricted Access');

class JSSTdownloadattachmentTable extends JSSTtable {

	public $id = '';
	public $downloadid = '';
	public $filename = '';
	public $filesize = '';
	public $filetype = '';
	public $staffid = '';
	public $created = '';

	function __construct() {
		parent::__construct('downloads_attachments', 'id'); // tablename, primarykey
	}

}

?>
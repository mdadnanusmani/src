<?php

if(!defined('ABSPATH'))
	die('Restricted Access');

class JSSTnoteTable extends JSSTtable {

	public $id = '';
	public $ticketid = '';
	public $staffid = '';
	public $title = '';
	public $note = '';
	public $status = '';
	public $created = '';
	public $filename = '';
	public $filesize = '';

	function __construct() {
		parent::__construct('notes', 'id'); // tablename, primarykey
	}

}

?>
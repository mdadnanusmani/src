<?php

if(!defined('ABSPATH'))
	die('Restricted Access');

class JSSTfeedbackTable extends JSSTtable {

	public $id = '';
	public $ticketid = '';
	public $rating = '';
	public $remarks = '';
	public $params = '';
	public $status = '';
	public $created = '';

	function __construct() {
		parent::__construct('feedbacks', 'id'); // tablename, primarykey
	}

}

?>
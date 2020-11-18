<?php

if(!defined('ABSPATH'))
	die('Restricted Access');

class JSSTticketsTable extends JSSTtable {

	public $id = '';
	public $uid = '';
	public $ticketid = '';
	public $departmentid = '';
	public $priorityid = '';
	public $staffid = '';
	public $email = '';
	public $name = '';
	public $subject = '';
	public $message = '';
	public $helptopicid = '';
	public $phone = '';
	public $phoneext = '';
	public $status = '';
	public $isoverdue = '';
	public $isanswered = '';
	public $duedate = '';
	public $reopened = '';
	public $closed = '';
	public $lastreply = '';
	public $created = '';
	public $updated = '';
	public $lock = '';
	public $ticketviaemail = '';
	public $ticketviaemail_id = '';
	public $attachmentdir = '';
	public $feedbackemail = '';
	public $mergestatus = '';
	public $mergewith = '';
	public $mergenote = '';
	public $mergedate = '';
	public $multimergeparams = '';
	public $mergeuid = '';
	public $params = '';
	public $hash = '';
	public $notificationid = '';
	public $wcorderid = '';
	public $wcproductid = '';

	function __construct() {
		parent::__construct('tickets', 'id'); // tablename, primarykey
	}
}
?>

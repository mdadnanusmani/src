<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTemailpipingModel {
    private $plainmsg;
    private $htmlmsg;
    private $subject;
    private $charset;
    private $attachments;
    private $headers;

    function readEmailsAjax(){
        $hosttype = JSSTrequest::getVar('hosttype');
        $hostname = JSSTrequest::getVar('hostname');
        $ssl = JSSTrequest::getVar('ssl');
        $hostportnumber = JSSTrequest::getVar('hostportnumber');
        $emailaddress = JSSTrequest::getVar('emailaddress');
        $password = JSSTrequest::getVar('password');
        $adminemailid = JSSTincluder::getJSModel('configuration')->getConfigValue('default_admin_email');
        $adminEmail = JSSTincluder::getJSModel('email')->getEmailById($adminemailid);
        if($adminEmail == $emailaddress){
            $array['type'] = 2;
            $array['msg'] = __('Admin email address and email piping (email address) cannot be same, your email piping will not be work.','js-support-ticket');
            $arraystring = json_encode($array);
            return $arraystring;
        }


        if(function_exists('imap_open')){
            //check Imap is enable or not
            switch ($hosttype) {
                case 1:
                    $hostname = "{imap.gmail.com:993/imap/ssl}INBOX";
                    break;
                case 2:
                    $hostname = "{imap.mail.yahoo.com:993/imap/ssl}INBOX";
                    break;
                case 3:
                    $hostname = "{imap.aol.com:993/imap/ssl}INBOX";
                    break;
                case 4:
                    if($ssl == 1){
                        $hostname = "{" . $hostname;
                        if(!empty($hostportnumber)){
                            $hostname .= ":".$hostportnumber;
                        }
                        $hostname .= "/imap/ssl}INBOX";
                    }else{
                        $hostname = "{" . $hostname . "/notls}";
                    }
                    break;
                case 5:
                    $hostname = "{imap-mail.outlook.com/imap/ssl}INBOX";
                    break;
            }
            set_time_limit(300);
            $username = $emailaddress;
            $imap = imap_open($hostname, $username, $password) or die(imap_last_error()) or die("can't connect: " . imap_last_error());
            $emails = imap_search($imap, 'ALL'); // Grabs any e-mail that is not read
            if($emails){
                $array['type'] = 0;
                $array['msg'] = __('Your setting is working please save the setting','js-support-ticket');
            }else{
                $array['type'] = 2;
                $array['msg'] = __('Connection established but we cannot read any email','js-support-ticket');
            }
        }else{
            $array['type'] = 1;
            $array['msg'] = __('IMAP is either not installed or not enable in your server','js-support-ticket');
        }
        $arraystring = json_encode($array);
        return $arraystring;
    }

    function storeConfiguration($data) {
        $notsave = false;
        foreach ($data AS $key => $value) {
            $query = true;
            jssupportticket::$_db->update(jssupportticket::$_db->prefix . 'js_ticket_config', array('configvalue' => $value), array('configname' => $key));
            if (jssupportticket::$_db->last_error != null) {
                JSSTincluder::getJSModel('systemerror')->addSystemError();
                $notsave = true;
            }
        }
        if ($notsave == false) {
            JSSTmessage::setMessage(__('Configuration has been stored', 'js-support-ticket'), 'updated');
            if($data['tve_enabled'] == 1){
                //JSSTincluder::getJSController('emailpiping')->registerReadEmails();
            }
        } else {
            JSSTmessage::setMessage(__('Configuration not has been stored', 'js-support-ticket'), 'error');
        }
        return;
    }
    function getAllEmailsForTickets()
    {
        $query = "SELECT * FROM `" . jssupportticket::$_db->prefix . "js_ticket_ticketsemail` ";
        $ticketsemail = jssupportticket::$_db->get_results($query);
        $result = array();
        if(!empty($ticketsemail)){
            foreach($ticketsemail as $key){
                $this->readEmails($key);
            }
        }
    }

    function readEmails($result) {
        //echo "Fetching emails ...";
        $adminemailid = JSSTincluder::getJSModel('configuration')->getConfigValue('default_admin_email');
        $adminEmail = JSSTincluder::getJSModel('email')->getEmailById($adminemailid);
        $ticketviaemailaddress = $result->emailaddress;
        if($adminEmail == $ticketviaemailaddress){ // if Email Piping disable
            return;
        }
        if($result->status!=1)
            return ;

        $imap = $this->getImap($result);
        if(is_null($imap)){
            return;
        }
        $emails = imap_search($imap, 'UNSEEN'); // Grabs any e-mail that is not read
        if ($emails) {
            // put the newest emails on top
            rsort($emails);
            foreach ($emails as $email) {
                $this->attachments = array();
                // get information specific to this email
                $overview = imap_fetch_overview($imap, $email, 0);
                $this->getHeaders($imap, $email);
                if (!empty($this->headers->subject)){
                    $this->subject = $this->headers->subject->text;
                }
                $this->getMessage($imap, $email);
                $message = $this->htmlmsg;
                $structure = imap_fetchstructure($imap, $email);
                imap_setflag_full($imap, $email, "\\Seen \\Flagged");
                $validate = $this->validateEmail($overview[0]->from);
                if ($validate) {
                    $message = $this->htmlmsg;
                    if($message == 'EMPTY') $message = $this->plainmsg;

                    $message = $this->removeTagInlineText($message, "style");
                    $message = $this->removeTagInlineText($message, "script");

                    //$message = trim(utf8_encode(quoted_printable_decode($message)));
                    $idsarray = $this->manageNewEmail($overview, $message, $structure,$result);
                    $this->getAttachments($idsarray);
                } else {// not validate
                } // validate end
            }
        }
    }

    function getAttachments($idsarray) {
        if(isset($this->attachments))
        foreach ($this->attachments as $key => $value) {
            $name = $key;
            $contents = $value;
            JSSTincluder::getJSModel('attachment')->storeTicketAttachment($idsarray[0], $idsarray[1], '', $name);
            JSSTincluder::getObjectclass('uploads')->storeTicketViaEmailAttachment($idsarray,$key,$value);
        }
    }

    function checkNewTicketOrReply($overview, $message) {
        $ticketnumber = "";
        $return = array();
        $return[0] = 1; // new ticket
        $replyInSubject = 0;
        $messagefrom = "";
        // check Re: in subject
        $subject = $overview[0]->subject;
        $subjectpos = strpos($subject, 'Re:', 0);
        if ($subjectpos < 5)
            $replyInSubject = 1;
        // check ticket number in message
        $messagepos1 = strpos($message, 'ticketid:', 0);
        if ($messagepos1) {
            $messagepos2 = strpos($message, '###', $messagepos1);
            $ticketnumber = substr($message, $messagepos1 + 9, ($messagepos2 - ($messagepos1 + 9)));

            $frompos = strpos($message, '####', $messagepos2);
            $messagefrom = substr($message, $messagepos2 + 3, ($frompos - ($messagepos2 + 3)));

            $find = '<input type="hidden" name="ticketid:' . $ticketnumber . '###admin####">';
            $message = str_replace($find, "", $message);

            $find = '<input type="hidden" name="ticketid:' . $ticketnumber . '###staff####">';
            $message = str_replace($find, "", $message);

            $find = '<input type="hidden" name="ticketid:' . $ticketnumber . '###user####">';
            $message = str_replace($find, "", $message);

            $find = '<span style="display:none;" ticketid:' . $ticketnumber . '###admin#### ></span>';
            $message = str_replace($find, "", $message);

            $find = '<span style="display:none;" ticketid:' . $ticketnumber . '###staff#### ></span>';
            $message = str_replace($find, "", $message);

            $find = '<span style="display:none;" ticketid:' . $ticketnumber . '###user#### ></span>';
            $message = str_replace($find, "", $message);

        }
        if($ticketnumber == ""){
            $messagepos1 = strpos($message, 'jssupportticketid=', 0);
            if ($messagepos1) {
                $messagepos2 = strpos($message, '>', $messagepos1);
                $ticketnumber = substr($message, $messagepos1 + 9, ($messagepos2 - ($messagepos1 + 9)));
            }
        }

        if($ticketnumber != ""){
            $query = "SELECT id, `hash` FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE ticketid = '" . $ticketnumber . "'";
            $row = jssupportticket::$_db->get_row($query);
            $ticketid = $row->id;
            $hash = $row->hash;
            if ($ticketid) { // confirm reply
                $return[0] = 2; // reply
                $return[1] = $ticketid;
                $return[2] = $messagefrom;
                $return[3] = $ticketnumber;
                $return[4] = $hash;
            }
        }
        // find in subject
        if($return[0] != 2){
            $messagepos = substr($subject, strpos($subject, "[") + 1);
            $ticketnumber = substr($messagepos, 0, strpos($messagepos, "]"));
        }
            if ($ticketnumber) {
                $query = "SELECT id, `hash` FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE ticketid = '" . $ticketnumber . "'";
                $row = jssupportticket::$_db->get_row($query);
                $ticketid = $row->id;
                $hash = $row->hash;
                if ($ticketid) { // confirm reply
                    $return[0] = 2; // reply
                    $return[1] = $ticketid;
                    $return[2] = $messagefrom;
                    $return[3] = $ticketnumber;
                    $return[4] = $hash;
                }
            }

        return $return;
    }

    function manageNewEmail($overview, $message, $structure,$maildata) {
        $mailreadtype = $maildata->mailreadtype;
        // check is new ticket or reply
        $result = $this->checkNewTicketOrReply($overview, $message);
        $ticketid = 0;
        $replyid = 0;
        if ($result[0] == 1) { // new ticket
            if ($mailreadtype == 1 || $mailreadtype == 3) {
                $ticketid = $this->addNewTicket($overview, $message,$maildata);
            }
        } elseif ($result[0] == 2) { // reply
            if ($mailreadtype == 2 || $mailreadtype == 3) {
                $ticketid = $result[1];
                $messagefrom = $result[2];
                $ticketrandomid = $result[3];
                $hash = $result[4];
                $replyid = $this->addNewReply($overview, $message, $ticketid, $messagefrom,$maildata, $ticketrandomid, $hash);
            }
        }
        $array[0] = $ticketid;
        $array[1] = $replyid;
        return $array;
    }

    function addNewTicket($overview, $message,$maildata) {
        $path1 = strpos($overview[0]->from, '<', 0);
        $path2 = strpos($overview[0]->from, '>', 0);
        $email = substr($overview[0]->from, $path1 + 1, ($path2 - $path1) - 1);
        $name = substr($overview[0]->from,0,$path1 - 1);
        $defaultdepartmentid = JSSTincluder::getJSModel('department')->getDefaultDepartmentID();

        $subject = $this->subject;
        // special treat for other langauges i.e russian
        if(JSSTincluder::getJSModel('configuration')->getConfigValue('read_utf_ticket_via_email') == 1){
            $subject = iconv_mime_decode($this->subject,0,"UTF-8");
            $name = iconv_mime_decode($name,0,"UTF-8");
        }
        $uid = $this->getUidFromEmail($email);

        $data = array();
        $data['id'] = '';
        $data['email'] = $email;
        $data['name'] = $name;
        $data['uid'] = $uid;
        $data['phone'] = '';
        $data['phoneext'] = '';
        $data['departmentid'] = $defaultdepartmentid;
        $data['priorityid'] = JSSTincluder::getJSModel('priority')->getDefaultPriorityID();
        $data['subject'] = $subject;
        $data['staffid'] = '';
        $data['lastreply'] = '';
        $data['userfields_total'] = 0;
        $data['helptopicid'] = '';
        $data['jsticket_message'] = $message;
        $data['status'] = 0;
        $data['ticketviaemail'] = 1;
        $data['ticketviaemail_id'] = $maildata->id;
        $data['duedate'] = '';
        $data['created'] = date_i18n('Y-m-d H:i:s');
        $ticketid = JSSTincluder::getJSModel('ticket')->storeTickets($data);
        return $ticketid;
    }

    function addNewReply($overview, $message, $ticketid, $messagefrom,$maildata, $ticketrandomid, $hash) {

        if($messagefrom == "") $ticketstatus = 1; // reply from user
        elseif($messagefrom == "user") $ticketstatus = 1; // reply from user
        elseif($messagefrom == "admin") $ticketstatus = 3; // reply from admin
        elseif($messagefrom == "staff") $ticketstatus = 3; // reply from staff

        $path1 = strpos($overview[0]->from, '<', 0);
        $path2 = strpos($overview[0]->from, '>', 0);
        $email = substr($overview[0]->from, $path1 + 1, ($path2 - $path1) - 1);
        $name = substr($overview[0]->from,0,$path1 - 1);
        if(JSSTincluder::getJSModel('configuration')->getConfigValue('read_utf_ticket_via_email') == 1){
            $name = iconv_mime_decode($name,0,"UTF-8");
        }
        $uid = $this->getUidFromEmail($email);
        $staffid = $this->getStaffMemberIdFromEmail($email);

        $data = array();
        $data['id'] = '';
        $created = date_i18n('Y-m-d H:i:s');
        $data['nonesignature'] = '';
        $data['ownsignature'] = '';
        $data['departmentsignature'] = '';
        $data['closeonreply'] = '';
        $data['uid'] = $uid;
        $data['name'] = $name;
        $data['ticketid'] = $ticketid;
        $data['ticketrandomid'] = $ticketrandomid;
        $data['jsticket_message'] = $message;
        $data['ticketviaemail'] = 1;
        $data['ticketviaemail_id'] = $maildata->id;
        $data['status'] = 1;
        $data['staffid'] = $staffid;
        $data['hash'] = $hash;
        JSSTincluder::getJSModel('reply')->storeReplies($data);
    }

    function validateEmail($emailaddress) {
        // validate in ban email, this already validate in ticket model
        // validate in max open ticket, this already validate in ticket model
        // validate in max open ticke in specific time from this address
        $maxticket_peremail = 3; // get from configurations
        $maxticket_peremail_time = 5; // time in minutes .. get from configurations

        $check_time = date_i18n('Y-m-d H:i:s', strtotime("-$maxticket_peremail_time min"));

        // check only ticket
        $query = "SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE email = '" . $emailaddress . "' AND created >= '" . $check_time . "'";
        $maxticketsperemail = jssupportticket::$_db->get_var($query);
        if ($maxticketsperemail > $maxticket_peremail) {
            //validate fail
            return 2;
        }

        // validate max ticket in specific time
        $maxticket_pertime = 25; // get from configurations
        $maxticket_time = 5; // time in minutes .. get from configurations

        $check_time = date_i18n('Y-m-d H:i:s', strtotime("-$maxticket_time min"));

        // check only ticket
        $query = "SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE created >= '" . $check_time . "'";
        $maxtickets = jssupportticket::$_db->get_var($query);
        if ($maxtickets > $maxticket_pertime) {
            //validate fail
            return 3;
        }

        return true;
    }

    function checkEmail($emailaddress) {
        $query = "SELECT emailaddress
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_ticketsemail`";
        $emailaddresses = jssupportticket::$_db->get_results($query);
        foreach ($emailaddresses as $data) {
            if($data->emailaddress == $emailaddress){
                return false;
            }
        }

        $query = "SELECT email
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff`";
        $emailaddresses = jssupportticket::$_db->get_results($query);
        foreach ($emailaddresses as $data) {
            if($data->email == $emailaddress){
                return false;
            }
        }

        $query = "SELECT email.email
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS dept
                    JOIN `" . jssupportticket::$_db->prefix . "js_ticket_email` AS email On email.id = dept.emailid
                    WHERE dept.sendmail = 1
                    ";
        $emailaddresses = jssupportticket::$_db->get_results($query);
        foreach ($emailaddresses as $data) {
            if($data->email == $emailaddress){
                return false;
            }
        }

        $adminemailid = JSSTincluder::getJSModel('configuration')->getConfigValue('default_admin_email');
        $adminEmail = JSSTincluder::getJSModel('email')->getEmailById($adminemailid);
        if($adminEmail == $emailaddress){
                return false;
        }

        return true;
    }

    function getImap($result) {
        $hosttype = $result->hosttype;
        $adminemailid = JSSTincluder::getJSModel('configuration')->getConfigValue('default_admin_email');
        $adminEmail = JSSTincluder::getJSModel('email')->getEmailById($adminemailid);
        if($adminEmail == $result->emailaddress){
            die('emailaddress error');
        }
        switch ($hosttype) {
            case 1:
                $hostname = "{imap.gmail.com:993/imap/ssl}INBOX";
                break;
            case 2:
                $hostname = "{imap.mail.yahoo.com:993/imap/ssl}INBOX";
                break;
            case 3:
                $hostname = "{imap.aol.com:993/imap/ssl}INBOX";
                break;
            case 4:
                if($result->enabled_ssl == 1){
                    $hostname = "{" . $result->hostname;
                    if(!empty($result->hostportnumber)){
                        $hostname .= ":".$result->hostportnumber;
                    }
                    $hostname .= "/imap/ssl}INBOX";
                }else{
                    $hostname = "{" . $result->hostname . "/notls}";
                }
                break;
            case 5:
                $hostname = "{imap-mail.outlook.com/imap/ssl}INBOX";
                break;
        }
        set_time_limit(300);
        $username = $result->emailaddress;
        $password = $result->emailpassword;
        //$imap = imap_open($hostname, $username, $password) or die(imap_last_error()) or die("can't connect: " . imap_last_error());
        $imap = imap_open($hostname, $username, $password) or null;
        //the following two lines just make sure error and warnings cought
        imap_errors();
        if(is_null($imap)) {
            if(imap_last_error()){
                echo "IMAP Error: ".imap_last_error();
            }
        }
        $this->imap = $imap;
        return $imap;
    }

    function getMessage($imap, $email) {
        $this->plainmsg = "";
        $this->htmlmsg = "";

        $structure = imap_fetchstructure($imap, $email);

        if (empty($structure->parts)){
            $this->getPart($imap, $email, $structure, 0);
        } else {
            foreach($structure->parts as $partno => $part){
                $this->getPart($imap, $email, $part, $partno+1);
            }
        }

        if (empty($this->plainmsg))
            $this->plainmsg = "EMPTY";

        if (empty($this->htmlmsg))
            $this->htmlmsg = "EMPTY";

        if ($this->charset != 'UTF-8'){
            $this->plainmsg = iconv($this->charset, 'UTF-8', $this->plainmsg);
            $this->htmlmsg = iconv($this->charset, 'UTF-8', $this->htmlmsg);
        }

        if (strlen($this->plainmsg) < 10 && strlen($this->htmlmsg) > 20){ // htmll message
            require_once(jssupportticket::$_path. 'modules/ticketviaemail/html2text.php');
            $h2t = new html2text($this->htmlmsg);
            $this->plainmsg = $h2t->get_text();
        }
    }

    function getPart($imap, $email, $part, $partno) {
        // decode data
        $data = ($partno)?
            imap_fetchbody($imap,$email,$partno):  // multipart
            imap_body($imap,$email);  // not multipart
        if ($part->encoding==4){
            $data = quoted_printable_decode($data);
        }elseif ($part->encoding==3){
            $data = base64_decode($data);
        }

        $aparams = array();
        if ($part->parameters){
            foreach ($part->parameters as $x){
                $aparams[ strtolower( $x->attribute ) ] = $x->value;
            }
        }

        if (!empty($part->dparameters)){
            foreach ($part->dparameters as $x){
                $aparams[ strtolower( $x->attribute ) ] = $x->value;
            }
        }

        if ( (array_key_exists("filename",$aparams) && $aparams['filename']) || (array_key_exists("name",$aparams) &&  $aparams['name'])) {
            $filename = ($aparams['filename'])? $aparams['filename'] : $aparams['name'];
            if (empty($this->attachments)){
                $this->attachments = array();
            }

            while (array_key_exists($filename,$this->attachments)){
                $filename = "-".$filename;
            }
            $this->attachments[$filename] = $data;  // problem if two files have same name
        }elseif ($part->type==0 && $data) { // text
            if (strtolower($part->subtype)== 'plain'){
                $this->plainmsg .= trim($data) ."\n\n";
            }else{
                $this->htmlmsg .= $data ."<br><br>";
            }
            $this->charset = $aparams['charset'];
        }elseif ($part->type==2 && $data) { // embedded message
            $this->plainmsg .= trim($data) ."\n\n";
        }

        // sub parts
        if (!empty($part->parts)) {
            foreach ($part->parts as $partno0=>$part2)
                $this->getPart($imap, $email, $part2, $partno.'.'.($partno0+1));  // 1.2, 1.2.1, etc.
        }
    }
    function getHeaders($imap, $email){
        // get and parse headers
        $headers = imap_headerinfo($imap,$email);
        $this->headers = null;

        if (empty($headers)){
            return false;
        }

        foreach ($headers as $header => $value){
            if (is_string($value)){
                $obj = new stdClass();
                $obj->text = imap_utf8($value);
                $obj->charset = 'UTF-8';

                $headers->$header = $obj;

            }elseif (is_array($value)) {
                foreach ($value as $offset => $values){
                    foreach ($values as $key => $text){
                        if (is_string($text)){
                            $headers->{$header}[$offset]->$key = iconv_mime_decode($text);
                        }
                    }
                }

            }
        }

        $this->headers = $headers;
        return true;
    }

    function getUidFromEmail($email) {
        $query = "SELECT id FROM `" . jssupportticket::$_wpprefixforuser . "users` WHERE user_email = '" . $email . "'";
        $uid = jssupportticket::$_db->get_var($query);
        if ($uid) {
            return $uid;
        }
        return 0;
    }

    function getStaffMemberIdFromEmail($email) {
        $query = "SELECT id FROM `" . jssupportticket::$_wpprefixforuser . "js_ticket_staff` WHERE email = '" . $email . "'";
        $id = jssupportticket::$_db->get_var($query);
        if ($id) {
            return $id;
        }
        return 0;
    }

    function removeTagInlineText($text, $tag){
        while (stripos($text, "<" . $tag) !== false){
            $spos = stripos($text, "<" . $tag);
            $epos = stripos($text, "</" . $tag . ">");

            if ($spos && $epos){
                $text = substr($text,0, $spos) . substr($text, $epos + strlen($tag) + 3);
            } else {
                break;
            }
        }

        return $text;
    }
     function getAllTicketViaEmails() {
        // Filter
        $emailaddress = JSSTrequest::getVar('emailaddress');
        $inquery = '';

        $formsearch = JSSTrequest::getVar('JSST_form_search', 'post');
        if ($formsearch == 'JSST_SEARCH') {
            $_SESSION['JSST_SEARCH']['emailaddress'] = $emailaddress;
        }

        if (JSSTrequest::getVar('pagenum', 'get', null) != null) {
            $emailaddress = (isset($_SESSION['JSST_SEARCH']['emailaddress']) && $_SESSION['JSST_SEARCH']['emailaddress'] != '') ? $_SESSION['JSST_SEARCH']['emailaddress'] : null;
        }

        if ($emailaddress != null)
            $inquery .= " WHERE tve.emailaddress LIKE '%$emailaddress%'";

        jssupportticket::$_data['filter']['emailaddress'] = $emailaddress;

        // Pagination
        $query = "SELECT COUNT(`id`) FROM `" . jssupportticket::$_db->prefix . "js_ticket_ticketsemail` AS tve ";
        $query .= $inquery;
        $total = jssupportticket::$_db->get_var($query);
        jssupportticket::$_data['total'] = $total;
        jssupportticket::$_data[1] = JSSTpagination::getPagination($total);
        // Data
        $query = "SELECT tve.*
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_ticketsemail` AS tve ";
        $query .= $inquery;
        // $query .= " ORDER BY tve.ordering ASC LIMIT " . JSSTpagination::getOffset() . ", " . JSSTpagination::getLimit();
        jssupportticket::$_data[0] = jssupportticket::$_db->get_results($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return;
    }

    function getTicketViaEmailForForm($id) {
        $result=array();
        if ($id) {
            if (!is_numeric($id))
                return false;
            $query = "SELECT tve.*
                        FROM `" . jssupportticket::$_db->prefix . "js_ticket_ticketsemail` AS tve
                        WHERE tve.id = " . $id;
            $result = jssupportticket::$_db->get_row($query);
            if (jssupportticket::$_db->last_error != null) {
                JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            }
        }
        jssupportticket::$_data[0]=$result;
        return;
    }

    function storeTicketViaEmail($data) {
        if (!$this->validateEmail($data['emailaddress'])) {
            JSSTmessage::setMessage(__('Email Address Already Exist', 'js-support-ticket'), 'error');
            return;
        }
        if(!is_numeric($data['id'])){
            if (!$this->checkEmail($data['emailaddress'])) {
                JSSTmessage::setMessage(__('Email Address Already Exist', 'js-support-ticket'), 'error');
                return;
            }
        }
        if(!isset($data['enabled_ssl']) || $data['enabled_ssl'] == ''){
            $data['enabled_ssl'] = 0;
        }
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);
        $query_array = array('id'   => $data['id'],
            'status'            => $data['status'],
            'mailreadtype'      => $data['mailreadtype'],
            'attachment'        => $data['attachment'],
            'hosttype'          => $data['hosttype'],
            'hostname'          => $data['hostname'],
            'enabled_ssl'       => $data['enabled_ssl'],
            'hostportnumber'    => $data['hostportnumber'],
            'emailaddress'      => $data['emailaddress'],
            'emailpassword'     => $data['emailpassword']
        );
        jssupportticket::$_db->replace(jssupportticket::$_db->prefix . 'js_ticket_ticketsemail', $query_array);
        $id = jssupportticket::$_db->insert_id;
        if (jssupportticket::$_db->last_error == null) {
            JSSTmessage::setMessage(__('Email For email piping has been stored', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Email For email piping has not been stored', 'js-support-ticket'), 'error');
        }
        return;
    }
    function removeTicketviaemail($id) {
        if (!is_numeric($id))
            return false;
        $canremove = $this->canRemoveEmail($id);
        if ($canremove == 1) {
            jssupportticket::$_db->delete(jssupportticket::$_db->prefix . 'js_ticket_ticketsemail', array('id' => $id));
            if (jssupportticket::$_db->last_error == null) {
                JSSTmessage::setMessage(__('Email has been deleted', 'js-support-ticket'), 'updated');
            } else {
                JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
                JSSTmessage::setMessage(__('Email has not been deleted', 'js-support-ticket'), 'error');
            }
        } else{
            JSSTmessage::setMessage(__('Email','js-support-ticket').' '.__('in use cannot deleted', 'js-support-ticket'), 'error');
        }


        return;
    }

    function canRemoveEmail($id){
        if(!is_numeric($id))
            return false;
        $query = "SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE ticketviaemail = 1 AND ticketviaemail_id =" .$id;
        $email = jssupportticket::$_db->get_var($query);
        if($email > 0){
            return false;
        }else{
            return true;
        }

    }
}

?>

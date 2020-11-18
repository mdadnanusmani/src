<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTprivatecredentialsModel {

	function getFormForPrivteCredentials(){
		$ticketid = JSSTrequest::getVar('ticketid','post',0);
		$cred_id = JSSTrequest::getVar('cred_id','post',0);
		$uid = JSSTrequest::getVar('uid','post',0);
		// manage data for form (mainly to handle edit case`)
		$cred_data_array = array();
		if(!is_numeric($ticketid) || $ticketid ==  0){
			return false;
		}
		if(is_numeric($cred_id) && $cred_id > 0){
			$cred_data = JSSTrequest::getVar('cred_data','post','');
			if($cred_data != ''){
				$cred_json_string = base64_decode($cred_data);
				$cred_data_array = json_decode($cred_json_string, true);
				$cred_data_array['uid'] = $uid;
				$cred_data_array['id'] = $cred_id;
			}
		}
		if(empty($cred_data_array)){
			$cred_data_array['credentialtype'] = '';
			$cred_data_array['username'] = '';
			$cred_data_array['password'] = '';
			$cred_data_array['info'] = '';
			$cred_data_array['id'] = '';
			$cred_data_array['uid'] = get_current_user_id();
		}
		$cred_data_array['ticketid'] = $ticketid;

		$html = $this->generateFormHTML($cred_data_array);

		return json_encode($html);
	}

	function generateFormHTML($cred_data_array){
		$html ='';
		$html .='
				<form class="js-ticket-usercredentails-form" id="js-ticket-usercredentails-form" method="POST" action="#" >
				    <div class="js-ticket-usercredentails-fields-wrp">
				        <div class="js-ticket-select-usercredentails">
				            <label for="credentialtype" class="js-ticket-select-usercredentails-label" >'. __('Credential type','js-support-ticket').'</label>
				            '. JSSTformfield::text('credentialtype', $cred_data_array['credentialtype'], array('class' => 'inputbox jsst-popup-credentials-fields' )).'
				        </div>
				        <div class="js-ticket-select-usercredentails">
				            <label for="username" class="js-ticket-select-usercredentails-label" >'. __('User name','js-support-ticket').'</label>
				            '. JSSTformfield::text('username', $cred_data_array['username'], array('class' => 'inputbox jsst-popup-credentials-fields' )).'
				        </div>
				        <div class="js-ticket-select-usercredentails">
				            <label for="password" class="js-ticket-select-usercredentails-label" >'. __('Password','js-support-ticket').'</label>
				            '. JSSTformfield::text('password', $cred_data_array['password'], array('class' => 'inputbox jsst-popup-credentials-fields' )).'
				        </div>
				        <div class="js-ticket-select-usercredentails">
				            <label for="info" class="js-ticket-select-usercredentails-label" >'. __('Addiotional info','js-support-ticket').'</label>
				            '. JSSTformfield::textarea('info', $cred_data_array['info'], array('class' => 'inputbox jsst-popup-credentials-fields' )).'
				      </div>
				    </div>
				    <div class="js-ticket-usercredentails-btn-wrp">
				        '. JSSTformfield::submitbutton('savecredentials', __('Save', 'js-support-ticket'), array('class' => 'js-ticket-usercredentails-save')).'
				        '. JSSTformfield::button('cancelcredentials', __('Cancel', 'js-support-ticket'), array('class' => 'js-ticket-usercredentails-cancel','onclick'=>'closeCredentailsForm('.$cred_data_array['ticketid'].');')).'
				    </div>
				    '.JSSTformfield::hidden('pc_ticketid', $cred_data_array['ticketid']).'
				    '.JSSTformfield::hidden('id', $cred_data_array['id']).'
				    '.JSSTformfield::hidden('uid', $cred_data_array['uid']).'
				</form>';
		return $html;
	}

	function getPrivateCredentials(){
		$ticketid = JSSTrequest::getVar('ticketid','post',0);
		if(!is_numeric($ticketid) || $ticketid ==  0){
			return false;
		}

		if(in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()){
			$credentialpermission = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('View Credentials');
			if(!$credentialpermission){
				return false;
			}
		}

		$query = "SELECT id, data, ticketid,uid,status
					FROM `" . jssupportticket::$_db->prefix . "js_ticket_privatecredentials`
					WHERE ticketid = ".$ticketid;

		$query .= " ORDER BY created DESC";
		$cred_data = jssupportticket::$_db->get_results($query);
		$html = '';
		if($cred_data != '' ){
			foreach ($cred_data as $cred) {
				$html .= $this->generatePrivateCredentialsHTML($ticketid, $cred->data, $cred->id, $cred->uid, $cred->status);
			}
		}
		if($html != ''){
			$return_array['status'] = 1;
			$return_array['content'] = $html;
			return json_encode($return_array);
		}
		$return_array['status'] = 1;
		$return_array['content'] = '';
		return json_encode($return_array);
	}

	function removePrivateCredential(){
		$cred_id = JSSTrequest::getVar('cred_id','post',0);
		if(!is_numeric($cred_id) || $cred_id ==  0){
			return false;
		}

		$del_allowed = false;
		$current_u_id = get_current_user_id();

		$row = JSSTincluder::getJSTable('privatecredentials');

		if(is_numeric($current_u_id) && $current_u_id > 0){
			if(current_user_can('manage_options')){
				$del_allowed = true;
			}elseif( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff(get_current_user_id()) && JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Delete Credentials') ) {
				// checks if is staff memeber and check whehter he is allowed to delete.
				$del_allowed = true;
			}else{
				$row->load($cred_id);
				if($row->uid == $current_u_id){
					$del_allowed = true;
				}
			}
		}

		if($del_allowed === true && $row->delete($cred_id)){
			return true;
		}else{
			return false;
		}

	}

	function storePrivateCredentials(){
		$data = array();
		$result_array = array();

		if(isset($_POST['formdata_string']) &&  $_POST['formdata_string'] != '' ){
			parse_str($_POST['formdata_string'],$result_array);
		}

		$data['id'] = '';
		$result_string = '';
		if(!empty($result_array)){
			$data['ticketid'] = $result_array['pc_ticketid'];
			$data['id'] = $result_array['id'];
			$data['uid'] = $result_array['uid'];
			unset($result_array['pc_ticketid']);
			unset($result_array['uid']);
			unset($result_array['id']);
			$result_array = array_filter($result_array);
			if(!empty($result_array)){
				$result_string = json_encode($result_array);
				$result_string = base64_encode($result_string);
				$result_string = JSSTincluder::getObjectClass('privatecredentials')->encrypt($result_string);
			}
		}


		if($result_string == ''){
			$return_array = array();
			$return_array['status'] = 0;
			$return_array['content'] = '';
			$return_array['error_message'] = __('Please insert values','js-support-ticket').'.';
			return json_encode($return_array);
		}

		$data['data'] = $result_string;
		$data['status'] = 1;// status 0 is for deleted credentials
		if( $data['id'] != ''){
			$data['created'] = date_i18n('Y-m-d H:i:s');
		}

		$row = JSSTincluder::getJSTable('privatecredentials');

		$error = 0;

		if(isset($data['ticketid']) && is_numeric($data['ticketid']) && $data['ticketid'] > 0){
			if (!$row->bind($data)) {
			    $error = 1;
			}
			if (!$row->store()) {
			    $error = 1;
			}
		}else{
			$error = 1;
		}

		if($error == 1){
			return false;// save error or data error.
		}else{ // everything ok

			// return html of stored credntail
			$html = $this->generatePrivateCredentialsHTML($data['ticketid'], $data['data'], $row->id, $row->uid, $row->status);
			if($html){
				$return_array = array();
				$return_array['status'] = 1;
				$return_array['content'] = $html;
				return json_encode($return_array);
			}
			return FALSE;
		}
	}

	function generatePrivateCredentialsHTML($ticketid,$cred_data_string,$cred_id,$uid,$status){
		if(!is_numeric($ticketid)){
			return false;
		}
		$cred_data_string = JSSTincluder::getObjectClass('privatecredentials')->decrypt($cred_data_string);
		$cred_json = base64_decode($cred_data_string);
		$cred_array = json_decode($cred_json,true);
		if($status == 1 && $cred_array && is_array($cred_array) && !empty($cred_array)){
			$html = '
				<div class="js-ticket-usercredentails-single" id="js-ticket-usercredentails-single-id-'.$cred_id.'">
				    <div class="js-ticket-usercredentail-title">';
				    if(isset($cred_array['credentialtype']) && $cred_array['credentialtype'] != ''){
				    	$html .= $cred_array['credentialtype'];
				    }else{
				    	$html .= '---------';
					}

				    $user_name =  __('Visitor','js-support-ticket');
				    if(is_numeric($uid) && $uid > 0){
				    	if ($user = get_userdata($uid)){
						    $user_name =  $user->data->display_name;
						}
				    }

			$html .= '&nbsp;('. __('By','js-support-ticket') .':&nbsp;'. $user_name .')';

			$html .= '
				    </div>
				    <div class="js-ticket-usercredentail-data">
				        <div class="js-ticket-usercredentail-data-label">
				            '. __("User name","js-support-ticket").':&nbsp;
				        </div>
				        <div class="js-ticket-usercredentail-data-value">';
						    if(isset($cred_array['username']) && $cred_array['username'] != ''){
						    	$html .= $cred_array['username'];
						    }else{
						    	$html .= '---------';
							}
					$html .= '
				        </div>
				    </div>
				    <div class="js-ticket-usercredentail-data">
				        <div class="js-ticket-usercredentail-data-label">
				            '. __("Password","js-support-ticket").':&nbsp;
				        </div>
				        <div class="js-ticket-usercredentail-data-value">
				            ';
	        			    if(isset($cred_array['password']) && $cred_array['password'] != ''){
	        			    	$html .= $cred_array['password'];
	        			    }else{
	        			    	$html .= '---------';
	        				}
	        		$html .= '
				        </div>
				    </div>
				    <div class="js-ticket-usercredentail-data js-ticket-usercredentail-data-full-width ">
				        <div class="js-ticket-usercredentail-data-label">
				            '. __("Additional info","js-support-ticket").':&nbsp;
				        </div>
				        <div class="js-ticket-usercredentail-data-value">
				            ';
	        			    if(isset($cred_array['info']) && $cred_array['info'] != ''){
	        			    	$html .= $cred_array['info'];
	        			    }else{
	        			    	$html .= '---------';
	        				}
	        		$html .= '
				        </div>
				    </div>
				    <div class="js-ticket-usercredentail-data-button-wrap" >';
					$credential_edit_permission = false;
					$credential_delete_permission = false;
				    if(in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()){
						$credential_edit_permission = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Edit Credentials');
						$credential_delete_permission = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Delete Credentials');
					}elseif(current_user_can('manage_options')){
						$credential_edit_permission = true;
						$credential_delete_permission = true;
					}elseif(get_current_user_id() == $uid){
						$credential_edit_permission = true;
						$credential_delete_permission = true;
					}

					if($credential_edit_permission){
						$html .= '
					        <button class="js-ticket-usercredentail-data-button-edit" onclick="addEditCredentail('.$ticketid.','.$uid.','.$cred_id.',\''.$cred_data_string.'\');" >
					            '. __("Edit","js-support-ticket").'
					        </button>';
					}
					if($credential_delete_permission){
			    		$html .= '
					        <button class="js-ticket-usercredentail-data-button-delete" onclick="removeCredentail('.$cred_id.');">
					            '. __("Delete","js-support-ticket").'
					        </button>';
					}
	        		$html .= '
				    </div>
				</div>';
			}else{
					if($status == 0){
						$html = '
							<div class="js-ticket-usercredentails-single" id="js-ticket-usercredentails-single-id-'.$cred_id.'">
							    <div class="js-ticket-usercredentail-title">';
						$html .=  __('Credential removed on ticket close','js-support-ticket');
						$html .= '
							    </div>
							</div>';
					}else{
						$html = '
							<div class="js-ticket-usercredentails-single" id="js-ticket-usercredentails-single-id-'.$cred_id.'">
							    <div class="js-ticket-usercredentail-title">';

						$html .=  __('Failed to retrieve data','js-support-ticket');

						$html .= '
							    </div>
							    <div class="js-ticket-usercredentail-data-button-wrap" >';
						        $html .= '
							        <button class="js-ticket-usercredentail-data-button-delete" onclick="removeCredentail('.$cred_id.');">
							            '. __("Delete","js-support-ticket").'
							        </button>';
								$html .= '
							    </div>
							</div>';
					}
			}
	return $html;
	}

	function deleteCredentialsOnCloseTicket($ticketid){
		// to mark as deleted on closing ticket.
		// set empty array as value.
		$empty_array = array();
		$json_string = json_encode($empty_array);
		$base64_string = base64_encode($json_string);
		$empty_array_string = JSSTincluder::getObjectClass('privatecredentials')->encrypt($base64_string);
		// set values in table (empty array in data to remove data, status 0 to show message.)
		$query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_privatecredentials` SET status = 0, data = '".$empty_array_string."' WHERE ticketid = " . $ticketid;
        jssupportticket::$_db->query($query);

	}
}
?>
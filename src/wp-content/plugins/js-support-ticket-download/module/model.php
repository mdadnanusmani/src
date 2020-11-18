<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTdownloadModel {

    function getStaffDownloads() {
        $isadmin = is_admin();

        $titlename = ($isadmin) ? 'title' : 'jsst-title';
        $catname = ($isadmin) ? 'categoryid' : 'jsst-cat';

        $title = addslashes(trim(JSSTrequest::getVar($titlename)));
        $categoryid = JSSTrequest::getVar($catname);
        $title = jssupportticket::parseSpaces($title);

        $formsearch = JSSTrequest::getVar('JSST_form_search', 'post');
        if ($formsearch == 'JSST_SEARCH') {
            $_SESSION['JSST_SEARCH']['title'] = $title;
            $_SESSION['JSST_SEARCH']['categoryid'] = $categoryid;
        }elseif(JSSTrequest::getVar('pagenum', 'get', null) == null){
            if(isset($_SESSION['JSST_SEARCH'])){
                foreach ($_SESSION['JSST_SEARCH'] as $key => $value) {
                    unset($_SESSION['JSST_SEARCH'][$key]);
                }
            }
        }

        if (JSSTrequest::getVar('pagenum', 'get', null) != null) {
            $title = (isset($_SESSION['JSST_SEARCH']['title']) && $_SESSION['JSST_SEARCH']['title'] != '') ? $_SESSION['JSST_SEARCH']['title'] : null;
            $categoryid = (isset($_SESSION['JSST_SEARCH']['categoryid']) && $_SESSION['JSST_SEARCH']['categoryid'] != '') ? $_SESSION['JSST_SEARCH']['categoryid'] : null;
        }

        $condition = " WHERE ";
        $inquery = '';
        if ($title != null) {
            $inquery .= $condition . "download.title LIKE '%".$title."%'";
            $condition = " AND ";
        }
        if(in_array('knowledgebase', jssupportticket::$_active_addons)){
            if ($categoryid) {
                if (!is_numeric($categoryid))
                    return false;
                $inquery .= $condition . "download.categoryid= " . $categoryid;
            }
        }

        jssupportticket::$_data['filter'][$titlename] = $title;
        jssupportticket::$_data['filter'][$catname] = $categoryid;

        // Pagination
        $query = "SELECT COUNT(`download`.`id`)
                        FROM `" . jssupportticket::$_db->prefix . "js_ticket_downloads` AS download ";
                        if(in_array('knowledgebase', jssupportticket::$_active_addons)){
                            $query .= "LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_categories` AS category ON download.categoryid = category.id ";
                        }
        $query .= $inquery;
        $total = jssupportticket::$_db->get_var($query);
        jssupportticket::$_data['total'] = $total;
        jssupportticket::$_data[1] = JSSTpagination::getPagination($total);
        // Data
        do_action('jsst_addon_get_staff_download');
        $query = "SELECT download.*, (SELECT count(downloadattachment.id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_downloads_attachments` AS downloadattachment WHERE download.id=downloadattachment.downloadid ) AS totalattachment ".jssupportticket::$_addon_query['select']."
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_downloads` AS download
                    ".jssupportticket::$_addon_query['join'];
        $query .= $inquery;
        $query .= " ORDER BY download.ordering ASC LIMIT " . JSSTpagination::getOffset() . ", " . JSSTpagination::getLimit();
        jssupportticket::$_data[0] = jssupportticket::$_db->get_results($query);
        do_action('reset_jsst_aadon_query');
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return;
    }

    function getDownloadForForm($id) {
        if ($id) {
            if (!is_numeric($id))
                return false;
        do_action('jsst_addon_get_staff_download_form');
            $query = "SELECT download.* ".jssupportticket::$_addon_query['select']."
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_downloads` AS download
                    ".jssupportticket::$_addon_query['join']."
                    WHERE download.id = " . $id;
            jssupportticket::$_data[0] = jssupportticket::$_db->get_row($query);
        do_action('reset_jsst_aadon_query');
            if (jssupportticket::$_db->last_error != null) {
                JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            }
        }
        JSSTincluder::getJSModel('downloadattachment')->getAttachmentForForm($id);
        return;
    }

    private function getNextOrdering() {
        $query = "SELECT MAX(ordering) FROM `" . jssupportticket::$_db->prefix . "js_ticket_downloads`";
        $result = jssupportticket::$_db->get_var($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return $result + 1;
    }

    function storeDownload($data) {
        if (!$data['id'])
            $data['created'] = date_i18n('Y-m-d H:i:s');
        $staffid = 0;
        if ( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()) {
            $task_allow = ($data['id'] == '') ? 'Add Download' : 'Edit Download';
            $allowed = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask($task_allow);
            if ($allowed != true) {
                JSSTmessage::setMessage(__('You are not allowed', 'js-support-ticket') . ' ' . __($task_allow, 'js-support-ticket'), 'updated');
                return;
            }
            $staffid = JSSTincluder::getJSModel('agent')->getStaffId(get_current_user_id());
        }
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);
        $data['description'] = wpautop(wptexturize(stripslashes($_POST['description'])));

        $data['staffid'] = $staffid;
        if (!$data['id']) { //new
            $data['ordering'] = $this->getNextOrdering();
        }

        $row = JSSTincluder::getJSTable('download');

        $data = JSSTincluder::getJSmodel('jssupportticket')->stripslashesFull($data);// remove slashes with quotes.
        $error = 0;
        if (!$row->bind($data)) {
            $error = 1;
        }
        if (!$row->store()) {
            $error = 1;
        }

        if ($error == 0) {
            $data['id'] = $row->id;
            JSSTincluder::getJSModel('downloadattachment')->storeAttachments($data);
            JSSTmessage::setMessage(__('Download has been stored', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Download has not been stored', 'js-support-ticket'), 'error');
        }
        return;
    }

    function setOrdering($id) {
        if (!is_numeric($id))
            return false;
        $order = JSSTrequest::getVar('order', 'get');
        if ($order == 'down') {
            $order = ">";
            $direction = "ASC";
        } else {
            $order = "<";
            $direction = "DESC";
        }
        $query = "SELECT t.ordering,t.id,t2.ordering AS ordering2 FROM `" . jssupportticket::$_db->prefix . "js_ticket_downloads` AS t,`" . jssupportticket::$_db->prefix . "js_ticket_downloads` AS t2 WHERE t.ordering $order t2.ordering AND t2.id = $id ORDER BY t.ordering $direction LIMIT 1";
        $result = jssupportticket::$_db->get_row($query);

        $row = JSSTincluder::getJSTable('download');
        if ($row->update(array('id' => $id, 'ordering' => $result->ordering)) && $row->update(array('id' => $result->id, 'ordering' => $result->ordering2))) {
            JSSTmessage::setMessage(__('Download','js-support-ticket').' '.__('ordering has been changed', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Download','js-support-ticket').' '.__('ordering has not changed', 'js-support-ticket'), 'error');
        }
        return;
    }

    function removeDownload($id) {
        if (!is_numeric($id))
            return false;
        if ( in_array('agent',jssupportticket::$_active_addons) && JSSTincluder::getJSModel('agent')->isUserStaff()) {
            $allowed = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Delete Download');
            if ($allowed != true) {
                JSSTmessage::setMessage(__('You are not allowed', 'js-support-ticket'), 'error');
                return;
            }
        }
        $row = JSSTincluder::getJSTable('download');
        if ($row->delete($id)) {
            JSSTmessage::setMessage(__('Download has been deleted', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
            JSSTmessage::setMessage(__('Download has not been deleted', 'js-support-ticket'), 'error');
        }
        return;
    }

    function changeStatus($id) {
        if (!is_numeric($id))
            return false;

        $query = "SELECT status  FROM `" . jssupportticket::$_db->prefix . "js_ticket_downloads` WHERE id=" . $id;
           $status = jssupportticket::$_db->get_var($query);
        $status = 1 - $status;

        $row = JSSTincluder::getJSTable('download');
        if ($row->update(array('id' => $id, 'status' => $status))) {
            JSSTmessage::setMessage(__('Download','js-support-ticket').' '.__('status has been changed', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Download','js-support-ticket').' '.__('status has not been changed', 'js-support-ticket'), 'error');
        }
        return;
    }

    function getDownloads($id) {
        if ($id) {
            if (!is_numeric($id))
                return false;
        } else
            $id = 0;

        $title = addslashes(trim(JSSTrequest::getVar('jsst-search')));
        $title = jssupportticket::parseSpaces($title);
        $formsearch = JSSTrequest::getVar('JSST_form_search', 'post');
        if ($formsearch == 'JSST_SEARCH') {
            $_SESSION['JSST_SEARCH']['title'] = $title;
        }elseif(JSSTrequest::getVar('pagenum', 'get', null) == null){
            if(isset($_SESSION['JSST_SEARCH'])){
                unset($_SESSION['JSST_SEARCH']['title']);
            }
        }

        if (JSSTrequest::getVar('pagenum', 'get', null) != null) {
            $title = (isset($_SESSION['JSST_SEARCH']['title']) && $_SESSION['JSST_SEARCH']['title'] != '') ? $_SESSION['JSST_SEARCH']['title'] : null;
        }
        $inquery = '';
        $inquerycat = '';
        if ($title != null) {
            $inquerycat .=" AND category.name LIKE '%".$title."%'";
            $inquery .=" AND download.title LIKE '%".$title."%'";
        }
        jssupportticket::$_data[0]['download-filter']['search'] = $title;

        if(in_array('knowledgebase', jssupportticket::$_active_addons)){
            $query = "SELECT category.name, category.id
                        FROM `" . jssupportticket::$_db->prefix . "js_ticket_categories` AS category
                        WHERE category.parentid = " . $id . " AND category.status = 1 AND downloads = 1 ". $inquerycat;
            jssupportticket::$_data[0]['categories'] = jssupportticket::$_db->get_results($query);
        }
        if ($id != 0)
            $inquery = " AND download.categoryid = " . $id;
        // Pagination
        $query = "SELECT COUNT(download.id)
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_downloads` AS download
                    WHERE download.status = 1" . $inquery;
        $total = jssupportticket::$_db->get_var($query);
        jssupportticket::$_data['total'] = $total;
        jssupportticket::$_data[1] = JSSTpagination::getPagination($total);

        $query = "SELECT download.title, download.id AS downloadid
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_downloads` AS download
                    WHERE download.status = 1" . $inquery;
        $query .=" ORDER BY download.ordering ASC LIMIT " . JSSTpagination::getOffset() . ", " . JSSTpagination::getLimit();
        jssupportticket::$_data[0]['downloads'] = jssupportticket::$_db->get_results($query);

        return;
    }

    function getDownloadById() {
        $downloadid = JSSTrequest::getVar('downloadid');
        $pageid = JSSTrequest::getVar('pageid');
        if (!is_numeric($downloadid))
            return false;

        $query = "SELECT download.title, download.description, download.id AS downloadid, attachment.id AS attachmentid, attachment.filename,attachment.filesize, attachment.filetype
                FROM `" . jssupportticket::$_db->prefix . "js_ticket_downloads` AS download
                LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_downloads_attachments` AS attachment
                ON download.id = attachment.downloadid
                WHERE download.status = 1 AND download.id = " . $downloadid;
        $query .=" ORDER BY downloadid";
        $downloads = jssupportticket::$_db->get_results($query);

        $result['data'] = '
           <div class="js-ticket-downloads-content">
                <div class="js-ticket-download-description">'
                    . $downloads[0]->description.'
                </div>';
                if($downloads[0]->attachmentid && $downloads[0]->downloadid != 0){
                    foreach ($downloads as $download) {
                        $datadirectory = jssupportticket::$_config['data_directory'];
                        $path = jssupportticket::makeUrl(array('jstmod'=>'download', 'action'=>'jstask', 'task'=>'downloadbyid', 'id'=> $download->attachmentid, 'jsstpageid'=> $pageid));
                        $result['data'] .='
                            <div class="js-ticket-download-box">
                                <div class="js-ticket-download-left">
                                    <a class="js-ticket-download-title" href="#">
                                        <img class="js-ticket-download-icon" src="' . jssupportticket::$_pluginpath . 'includes/images/downloadicon/download.png" />
                                        <span class="js-ticket-download-name">
                                            ' . $download->filename . '
                                        </span>
                                        <span class="js-ticket-download-name">
                                            ' . $download->filesize . '
                                        </span>
                                    </a>
                                </div>
                                <div class="js-ticket-download-right">
                                    <div class="js-ticket-download-btn">
                                        <a class="js-ticket-download-btn-style" href="' . esc_url($path) . '" target="_blank">
                                            <img class="js-ticket-download-btn-icon" src="' . jssupportticket::$_pluginpath . 'includes/images/downloadicon/downloadall.png" />
                                            '.__('Download','js-support-ticket').'
                                        </a>
                                    </div>
                                </div>
                            </div>';
                    }
                    $result['downloadallbtn'] = '
                        <div class="js-ticket-download-btn">
                            <a class="js-ticket-download-btn-style" href="' . esc_url(jssupportticket::makeUrl(array('jstmod'=>'download', 'task'=>'downloadall', 'action'=>'jstask', 'downloadid'=>$downloadid, 'jsstpageid'=>$pageid))) . '" onclick="" target="_blank">
                                <img class="js-ticket-download-btn-icon" src="' . jssupportticket::$_pluginpath . 'includes/images/downloadicon/downloadall.png" />
                                '.__('Download All','js-support-ticket').'
                            </a>
                        </div>
                        ';
                }
        $result['data'] .= '</div>';
        $result['title'] = $downloads[0]->title;
        return json_encode($result);
    }

    function getAllDownloads() {
        $downloadid = JSSTrequest::getVar('downloadid');
		if(!class_exists('PclZip')){
			require_once(jssupportticket::$_path . 'includes/lib/pclzip.lib.php');
		}
        $path = jssupportticket::$_path;
        $path .= 'zipdownloads';
        JSSTincluder::getJSModel('jssupportticket')->makeDir($path);
        $randomfolder = $this->getRandomFolderName($path);
        $path .= '/' . $randomfolder;
        JSSTincluder::getJSModel('jssupportticket')->makeDir($path);
        $archive = new PclZip($path . '/alldownloads.zip');

        $datadirectory = jssupportticket::$_config['data_directory'];
        $maindir = wp_upload_dir();
        $jpath = $maindir['basedir'];
        $jpath = $jpath .'/'.$datadirectory;
        $directory = $jpath . '/attachmentdata/downloads/download_' . $downloadid . '/';
        if(!is_dir($directory))
                return false;
        $scanned_directory = array_diff(scandir($directory), array('..', '.'));
        $filelist = '';
        foreach ($scanned_directory AS $file) {
            $filelist .= $directory . '/' . $file . ',';
        }
        $filelist = substr($filelist, 0, strlen($filelist) - 1);
        $v_list = $archive->create($filelist, PCLZIP_OPT_REMOVE_PATH, $directory);
        if ($v_list == 0) {
            die("Error : '" . $archive->errorInfo() . "'");
        }
        $file = $path . '/alldownloads.zip';
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        //ob_clean();
        flush();
        readfile($file);
        @unlink($file);
        $path = jssupportticket::$_path;
        $path .= 'zipdownloads';
        $path .= '/' . $randomfolder;
        @unlink($path . '/index.html');
        rmdir($path);
        exit();
    }

    function getRandomFolderName($path) {
        $match = '';
        do {
            $rndfoldername = "";
            $length = 5;
            $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";
            $maxlength = strlen($possible);
            if ($length > $maxlength) {
                $length = $maxlength;
            }
            $i = 0;
            while ($i < $length) {
                $char = substr($possible, mt_rand(0, $maxlength - 1), 1);
                if (!strstr($rndfoldername, $char)) {
                    if ($i == 0) {
                        if (ctype_alpha($char)) {
                            $rndfoldername .= $char;
                            $i++;
                        }
                    } else {
                        $rndfoldername .= $char;
                        $i++;
                    }
                }
            }
            $folderexist = $path . '/' . $rndfoldername;
            if (file_exists($folderexist))
                $match = 'Y';
            else
                $match = 'N';
        }while ($match == 'Y');

        return $rndfoldername;
    }

    function getDownloadAttachmentById($id){
        if(!is_numeric($id)) return false;
        $query = "SELECT filename,downloadid FROM `".jssupportticket::$_db->prefix."js_ticket_downloads_attachments` WHERE id = $id";
        $object = jssupportticket::$_db->get_row($query);
        $filename = $object->filename;
        $downloadid = $object->downloadid;
        $datadirectory = jssupportticket::$_config['data_directory'];
        $maindir = wp_upload_dir();
        $path = $maindir['basedir'];
        $path = $path .'/'.$datadirectory;

        $path = $path . '/attachmentdata';
        $path = $path . '/downloads/download_' . $downloadid;
        $file = $path . '/'.$filename;
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        //ob_clean();
        flush();
        readfile($file);
        exit();

    }

}

?>

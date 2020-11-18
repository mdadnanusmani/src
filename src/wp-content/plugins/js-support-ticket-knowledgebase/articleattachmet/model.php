<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTarticleattachmetModel {

    function getAttachmentForForm($id) {
        if (!is_numeric($id))
            return false;
        $query = "SELECT filename,filesize,id
					FROM `" . jssupportticket::$_db->prefix . "js_ticket_articles_attachments`
					WHERE articleid = " . $id;
        jssupportticket::$_data[5] = jssupportticket::$_db->get_results($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return;
    }

    function storeAttachments($data) {
        JSSTincluder::getObjectClass('uploads')->storeArticleAttachment($data, $this);
    }

    function storeArticleAttachmet($articleid, $filesize, $filename) {
        if (!is_numeric($articleid))
            return false;
        $created = date_i18n('Y-m-d H:i:s');
        $data = array('articleid' => $articleid,
            'filesize' => $filesize,
            'filename' => $filename,
            'created' => $created,
            'status' => 1
        );

        $row = JSSTincluder::getJSTable('articles_attachments');
        
        $data = JSSTincluder::getJSmodel('jssupportticket')->stripslashesFull($data);// remove slashes with quotes.
        $error = 0;
        if (!$row->bind($data)) {
            $error = 1;
        }
        if (!$row->store()) {
            $error = 1;
        }
        
        if ($error == 1) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
            return false;
        }
        return true;
    }

    function removeAttachment($id , $articleid) {
        if (!is_numeric($id))
            return false;
        $query = "SELECT filename FROM `" . jssupportticket::$_db->prefix . "js_ticket_articles_attachments` WHERE id = " . $id;
        $filename = jssupportticket::$_db->get_var($query);
        $row = JSSTincluder::getJSTable('articles_attachments');
        if ($row->delete($id)) {
            $datadirectory = jssupportticket::$_config['data_directory'];
            $maindir = wp_upload_dir();
            $path = $maindir['basedir'];
            $path = $path .'/'.$datadirectory;
            $path = $path . '/attachmentdata';
            $path = $path . '/articles/article_' . $articleid . '/' . $filename;
            unlink($path);
            //$files = glob($path.'/*.*');
            //array_map('unlink', $files); // delete all file in the direcoty
            JSSTmessage::setMessage(__('Attachment has been removed', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
            JSSTmessage::setMessage(__('Attachment has not been removed', 'js-support-ticket'), 'error');
        }
    }

    function removeAllAttachment($articleid) {
        if (!is_numeric($articleid))
            return false;
        jssupportticket::$_db->delete(jssupportticket::$_db->prefix . 'js_ticket_articles_attachments', array('articleid' => $articleid));
        if (jssupportticket::$_db->last_error == null) {
            $datadirectory = jssupportticket::$_config['data_directory'];
            $maindir = wp_upload_dir();
            $path = $maindir['basedir'];
            $path = $path .'/'.$datadirectory;
            
            $path = $path . '/attachmentdata';
            $path = $path . '/articles/article_' . $id . '/';
            $files = glob($path . '/*.*');
            array_map('unlink', $files); // delete all file in the direcoty
            JSSTmessage::setMessage(__('Attachment has been removed', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
            JSSTmessage::setMessage(__('Attachment has not been removed', 'js-support-ticket'), 'error');
        }
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
        $query = "SELECT filename,articleid FROM `".jssupportticket::$_db->prefix."js_ticket_articles_attachments` WHERE id = $id";
        $object = jssupportticket::$_db->get_row($query);
        $filename = $object->filename;
        $articleid = $object->articleid;
        $datadirectory = jssupportticket::$_config['data_directory'];
        $maindir = wp_upload_dir();
        $path = $maindir['basedir'];
        $path = $path .'/'.$datadirectory;

        $path = $path . '/attachmentdata';
        $path = $path . '/articles/article_' . $articleid;
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

    function getAllDownloads() {
        $downloadid = JSSTrequest::getVar('downloadid');
        $ticketattachment = JSSTincluder::getJSModel('ticket')->getAttachmentByTicketId($downloadid);
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
        $scanned_directory = [];
        foreach ($ticketattachment AS $ticketattachments) {
            $directory = $jpath . '/attachmentdata/ticket/' . $ticketattachments->attachmentdir . '/';
            // $scanned_directory = array_diff(scandir($directory), array('..', '.'));
        array_push($scanned_directory,$ticketattachments->filename);
        }
        // if(!is_dir($directory))
        //         return false;
        
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

    function getAllReplyDownloads() {
        $downloadid = JSSTrequest::getVar('downloadid');
        $replyattachment = JSSTincluder::getJSModel('reply')->getAttachmentByReplyId($downloadid);
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
        $scanned_directory = [];
        foreach ($replyattachment AS $replyattachments) {
            $directory = $jpath . '/attachmentdata/ticket/' . $replyattachments->attachmentdir . '/';
            // $scanned_directory = array_diff(scandir($directory), array('..', '.'));
        array_push($scanned_directory,$replyattachments->filename);
        }
        // if(!is_dir($directory))
        //         return false;
        
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
        @rmdir($path);
        exit();
    }
}

?>

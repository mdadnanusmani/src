<?php
/*
        $strUrl = "http://mobile.net.sa/sms/gw/";
        $userName = 'aseergov';
        $password = '665942';
        $sender = 'EmartAseer';
        $mobile="0500385025";
        $contenet = 'elmgdad123';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$strUrl);
        curl_setopt ($ch, CURLOPT_HEADER, false);
        curl_setopt ($ch, CURLOPT_POST, true);

        $dataPOST = array('userName' => $userName, 'userPassword' => $password,'userSender' => $sender, 'numbers' => $mobile, 'msg' => $contenet, 'By' => "standard".$infos.$xml);
        print_r($dataPOST);
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $dataPOST);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLE_HTTP_NOT_FOUND,1);
        $FainalResult = curl_exec ($ch);
        echo $FainalResult;
        curl_close ($ch);
*/
?>
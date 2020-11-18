<?

    function send_vac_msg($mobile,$vac_flaq)
    {

    if(strlen($mobile)<9 || $mobile=='')
    {
        return -1;
    }


    $sql="select VAC_YEARS.ID  AS ID,VAC_YEARS.DAYS AS DAYS , VAC_FIELDS.VALUE AS FI_VALUE , VAC_FIELDS.NAME AS FI_NAME , VAC_YEARS.OPR AS OPR ,VAC_YEARS.VALUE AS YE_VALUE from VAC_YEARS LEFT OUTER JOIN VAC_FIELDS ON VAC_YEARS.CONDITION = VAC_FIELDS.ID where VAC_FIELDS.VALUE ='VAC_SEND_MSG' ORDER BY VAC_YEARS.DAYS ";
    $stid = oci_parse($GLOBALS['conn'], $sql);

    oci_execute($stid);

    $flaq=0;

    while($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS))
    {
        if($row['DAYS']==0 && $row['YE_VALUE']=='1')
        {
           $flaq=1;
        }
    }

    if($flaq==1)
    {
        $stid2 = oci_parse($GLOBALS['conn'], $sql);
        oci_execute($stid2);

        while($row = oci_fetch_array($stid2, OCI_ASSOC+OCI_RETURN_NULLS))
        {
            if($row['DAYS']!=0)
            {
                if($row['DAYS']==$vac_flaq)
                sms_orbit_send($mobile,$row['YE_VALUE']);
            }
        }

    }else
    {
        return -1;

    }

    }





	 function sms_orbit_send($mobile , $msg) {

        $strUrl = "http://mobile.net.sa/sms/gw/";
        $userName = 'aseergov';
        $password = '665942';
        $sender = 'EmartAseer';
        $contenet = $msg;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$strUrl);
        curl_setopt ($ch, CURLOPT_HEADER, false);
        curl_setopt ($ch, CURLOPT_POST, true);

        $dataPOST = array('userName' => $userName, 'userPassword' => $password,'userSender' => $sender, 'numbers' => $mobile, 'msg' => $contenet, 'By' => "standard".$infos.$xml);
        //print_r($dataPOST);
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $dataPOST);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLE_HTTP_NOT_FOUND,1);
        $FainalResult = curl_exec ($ch);
        echo $FainalResult;
        curl_close ($ch);

	}

?>
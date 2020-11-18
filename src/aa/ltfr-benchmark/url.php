<?php
        echo 123;
        // create curl resource
        $ch = curl_init();

        // set url
        $rand=rand(1,2000);
        curl_setopt($ch, CURLOPT_URL, "https://xservices.rich.sa/RiCHClientServiceREST.svc/SendSmsLoginGet?username=admin@aseer.gov.sa&password=r5Uucs0$&Sender=Emart%20Aseer&Text=".$rand."&number=966500385025");

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);
        
        echo $output;
        // close curl resource to free up system resources
        curl_close($ch);
?>

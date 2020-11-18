<?php

// Get cURL resource
$curl = curl_init();
// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'https://xservices.rich.sa/RiCHClientServiceREST.svc/SendSmsLoginGet?username=admin@aseer.gov.sa&password=r5Uucs0$&Sender=Emart%20Aseer&Text=testing&number=966500385025'

));
// Send the request & save response to $resp
$resp = curl_exec($curl);
print_r($resp);
// Close request to clear up some resources
curl_close($curl);

?>
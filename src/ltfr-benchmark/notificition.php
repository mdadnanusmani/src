<script>
function notifyBrowser(desc)
{
document.getElementById("sound").innerHTML='<audio autoplay="autoplay"><source src="audio.mp3" type="audio/mpeg" /><source src="audio.ogg" type="audio/ogg" /><embed hidden="true" autostart="true" loop="false" src="audio.mp3" /></audio>';

    var title='أضغط هنا لفتح النظام';
    var desc=desc;
    var url='https://www3.aseer.gov.sa/';

    if (!Notification) {
        console.log('Desktop notifications not available in your browser..');
        return;
    }

    if (Notification.permission !== "granted")
    {
        Notification.requestPermission();
    }
    else{

        var notification = new Notification(title, {
        icon:'http://aseer.gov.sa/style/images/s_logo.png',
        body: desc,
        });

        // Remove the notification from Notification Center when clicked.
        notification.onclick = function () {
        window.open(url);
        };

        // Callback function when the notification is closed.
        notification.onclose = function () {
        console.log('Notification closed');
        };

    }

}
</script>
<div id="sound"></div>
<?php
if(isset($_GET['notificition']) &&  $_GET['notificition']!='')
{
    include "administrator/config.php";
    $userid=$_SESSION['S_USERID'];
    $msg=$_SESSION['lable'];
    $sq="SELECT * FROM `notificition` where (lastinsert =1 or lastupdate=1) and userid='$userid'";
    $q=mysql_query($sq) or die(mysql_error());
    $row=mysql_fetch_array($q);
    $count=mysql_num_rows($q);
    if($count>0)
    {
        $dbid=$row['db'];
        $r=mysql_fetch_array( mysql_query("select * from `db` where id = '$dbid'"));
        if($row['lastinsert']==1)
        {
            $msg='لديك إضافة جديدة ('.$r['descrption'].')';
            echo'<script>notifyBrowser("'.$msg.'");</script>';
            $nid=$row['id'];
            mysql_query("update `notificition` set `lastinsert`=0 where id='$nid'");
        }
        if($row['lastupdate']==1)
        {
            $msg='لديك تعديل  جديدة ('.$r['descrption'].')';
            echo'<script>notifyBrowser("'.$msg.'");</script>';
            $nid=$row['id'];
            mysql_query("update `notificition` set `lastupdate`=0 where id='$nid'");
        }
    }
}
?>


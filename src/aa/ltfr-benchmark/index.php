<?php
include "include.php";
//echo $_SESSION['S_ISADMIN'];
                    if($_SESSION['S_ISADMIN']=='2')
        			    echo '<script>window.location = "view.php";</script>';
//        			else
//        			    echo '<script>window.location = "index.php";</script>'; 
        			    
design_page("منصة التطبيقات");
?>
	<section   id="middle">

<?php
	 design_page_header("صفحة الرئسية","منصة التطبيقات");

?>

<!-- Page Content -->
<div id="content" class="padding-20">
     
        <div id='div_session_write'></div>
		    <?
                noti_show();
            ?>
        <?php echo '<script>if (Notification.permission !== "granted"){Notification.requestPermission();}</script>'; ?>

</div>

	</section>
	<!-- /MIDDLE -->
<?php
ch_notificition();
desing_page_end();
?>
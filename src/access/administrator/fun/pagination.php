<?php

$limit = 150;
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
$start_from = ($page-1) * $limit;
$_SESSION['start_from']=$start_from;
$_SESSION['limit']=$limit;

$db=$_REQUEST['db'];
$sql = "SELECT COUNT(id) FROM $db";
$rs_result = @mysql_query( $sql);
$row = @mysql_fetch_row($rs_result);
$total_records = $row[0];
$total_pages = @ceil($total_records / $limit);
$_SESSION['total_pages']=$total_pages;
$pagLink = "<nav><ul class='pagination pagination-sm'>";
for ($i=1; $i<=$total_pages; $i++) {
    $pagLink .= "<li><a href='route.php?page=".$i."'>".$i."</a></li>";
};
$pagLink .= "</ul></nav>";
        $_SESSION['pagelink']= '
<div class="alert alert-mini alert-info margin-bottom-30"><!-- INFO -->
    <button type="button" >
        <span aria-hidden="true">×</span>
        <span class="sr-only">Close</span>
    </button>
      '.$pagLink.'
</div>
';
//$_SESSION['pagelink']=$pagLink;
$_SESSION['total_records']=$total_records;


?>
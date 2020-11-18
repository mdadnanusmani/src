<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
include "include.php";
chfun();

$db=$_REQUEST['db']=$_SESSION['db'];
$lable=$_REQUEST['lable']=$_SESSION['lable'];
//$style=$_REQUEST['page_style']=$_SESSION['page_style'];

if($_REQUEST['action']=='2')
{
    $lable='عرض البيانات '.$lable;
}else if($_REQUEST['action']=='1')
{
    $lable='إدخال بيانات '.$lable;
}else if($_REQUEST['action']=='3')
{
    $lable='بيانات'.$lable;
}

design_page($lable);
?>
   <script langauge="javascript">
                window.setInterval("refreshv()", 3000);
                function refreshv(){
                    jQuery('#div_count').load('jq.php?count_sql="true"');
                }
    </script>
    <section id="middle">
<?php
    design_page_header($lable,"نظام إدارة المشاريع");
    include "fun/main_function.php";
    include "administrator/fun/funcat.php";
    include "fun/include_fun_bind.php";
?>
 <!-- Page Content -->
<div id="content" class="padding-20">


    <?php
    if($_REQUEST['action']=='2' ||$_REQUEST['action']=='3')
    {
     $ro_date=bind_alert_search($db,$lable);
    }
     ?>

                    <div id="panel-4" class="panel panel-success">
                                <div class="panel-heading">

                                    <span class="elipsis"><!-- panel title -->
                                        <strong><?php echo $lable; ?></strong>
                                    </span>
                                    <!-- tabs nav -->
                                    <ul class="nav nav-tabs pull-right options">
                                    <li>
                                        <a href="#" class="opt panel_colapse" data-toggle="tooltip" title="تصغير" data-placement="bottom"></a>
                                    </li>
        							<li>
                                        <a href="#" class="opt panel_fullscreen hidden-xs" data-toggle="tooltip" title="تكبير " data-placement="bottom"><i class="fa fa-expand"></i></a>
                                    </li>
                                    <li>
                            <?php
                                if($ro_date['report_view']==1)
                                {
                            ?>
                                    <form action="bind_print.php" method="post">
<button type="submit" name="action" class="btn" value="2" data-toggle="tooltip" title="طباعة" ><span style="color: #000000"><i class="fa fa-print"></i></span></button>

                <input type="hidden" name="db" value="<?php echo $_REQUEST['db']; ?>">
                <input type="hidden" name="lable" value="<?php echo $_REQUEST['lable']; ?>">
                <input type="hidden" name="action" value="<?php echo $_REQUEST['action']; ?> ">
                <?php
                if($_REQUEST['action']==3)
                {
                    echo '
                    <input type="hidden" name="fromdate" value="'.$_REQUEST['fromdate'].'">
                    <input type="hidden" name="todate" value="'.$_REQUEST['todate'].'">
                    <input type="hidden" name="col" value="'.$_REQUEST['col'].'">
                    <input type="hidden" name="fillter" value="Yes">
                    <input type="hidden" name="action" value="3">

                    ';
                }

                ?>
                                    </form>
                <?php } ?>

                                    </li>
                                    <li>
                                        <?php if($_REQUEST['db']=='project')
                                        {
//echo'<a href="export.php" class="opt " data-toggle="tooltip" title="تصدير كملف Excel " data-placement="bottom"><i class="fa fa-file-excel-o"></i></a> ';
                                        }
                                        ?>
                                    </li>
                                    </ul>
                                    <!-- /tabs nav -->
                    </div>
                    <div class="panel-body">
                        <div id="div_session_write"></div>
                        <div id="div_count"></div>
                        <div id="div_count"></div>
                           
                            <?
                            
                               // echo $_SESSION['count'];
                                noti_show();
                                bind_route($_REQUEST);
                            ?>
                        </div>
                    </div>
                </div>
</div>
    </section>

<?php
ch_notificition();
desing_page_end();
?>

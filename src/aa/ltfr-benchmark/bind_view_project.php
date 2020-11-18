<?php
include "include.php";
chfun();
$db=$_GET['db'];
$lable=$_GET['lable'];
design_page($lable);
$global_var=$lable;
$global_var2=$lable;
$_SESSION['db']=$db;
?>
    <section id="middle">

<?php

design_page_header("عرض بيانات ".$lable,"نظام إدارة المشاريع");
    include "fun/main_function.php";
    include "administrator/fun/funcat.php";
    include "fun/include_fun_bind.php";

?>


<!-- Page Content -->
<div id="content" class="padding-20">
                    <div id="panel-4" class="panel panel-default alert alert-success">
                                <div class="panel-heading ">

                                    <span class="elipsis"><!-- panel title -->
                                        <strong><b><?php echo $global_var; ?></b> </strong>
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
                                        <a href="bind_print.php?db=<?php echo $_GET['db']; ?>&lable=<?php echo $_GET['lable']; ?>" class="">طباعة</a>
                                    </li>
                                    </ul>
                                    <!-- /tabs nav -->
                    </div>
                    <div class="panel-body">
                                <?
                                    noti_show();
                                ?>
<!----------  -->
<?php bind_view($db); ?>
<!----------  -->

</div>
</div>
</div>
</section>
<?php
desing_page_end();
?>

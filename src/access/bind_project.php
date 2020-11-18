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

    design_page_header("إدخال بيانات ".$lable,"نظام إدارة المشاريع");
    include "fun/main_function.php";
    include "administrator/fun/funcat.php";
    include "fun/include_fun_bind.php";

?>


<!-- Page Content -->
<div id="content" class="padding-20">
                    <div id="panel-4" class="panel panel-default">
                                <div class="panel-heading">

                                    <span class="elipsis"><!-- panel title -->
                                        <strong><?php echo $global_var; ?></strong>
                                    </span>
                                    <!-- tabs nav -->
                                    <ul class="nav nav-tabs pull-right options">
                                    <li>
                                        <a href="#" class="opt panel_colapse" data-toggle="tooltip" title="تصغير" data-placement="bottom"></a>
                                    </li>
        							<li>
                                        <a href="#" class="opt panel_fullscreen hidden-xs" data-toggle="tooltip" title="تكبير " data-placement="bottom"><i class="fa fa-expand"></i></a>
                                    </li>
                                    </ul>
                                    <!-- /tabs nav -->
                    </div>
                    <div class="panel-body">
                                <?
                                    noti_show();
                                ?>


<?php bind_form($db); ?>



</div>
</div>
</div>
    </section>

<?php
desing_page_end();
?>

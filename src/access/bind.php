<?php
include "include.php";
is_admin();
design_page("الطرق");
$global_var='الطرق';
$global_var2='الطرق';

$db="roads";
$_SESSION['db']='';
$_SESSION['db']=$db;
?>
    <section id="middle">

<?php

    design_page_header("إضافة الطرق ","إدارة المشاريع");
    include "fun/main_function.php";
    include "administrator/fun/funcat.php";
    include "fun/include_fun_bind.php";
   
?>

					
<!-- Page Content -->
<div id="content" class="padding-20">
                    <div id="panel-4" class="panel panel-default">
                                <div class="panel-heading">

                                    <span class="elipsis"><!-- panel title -->
                                        <strong>الطرق</strong>
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
                                
<form  action="" method="post" enctype="multipart/form-data" >

<?php bind_form($db); ?>
                  
</form>

</div>
</div>

<?php
desing_page_end();
?>

                                  <?php
include "include.php";
//print_r($_POST);

//exit();
//chfun();
$db=$_REQUEST['db'];
$lable=$_REQUEST['lable'];
$rowid=$_REQUEST['rowid'];
$global_var=$lable;
$global_var2=$lable;
$_SESSION['db']=$db;

include "fun/main_function.php";
include "administrator/fun/funcat.php";
include "fun/include_fun_bind.php";

?>
<!doctype html>
<html lang="en-US">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <title>طباعة تقرير | <?php echo $global_var; ?></title>
        <meta name="description" content="" />
        <meta name="Author" content="Dorin Grigoras [www.stepofweb.com]" />

        <!-- mobile settings -->
        <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0" />

        <!-- WEB FONTS -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800&amp;subset=latin,latin-ext,cyrillic,cyrillic-ext" rel="stylesheet" type="text/css" />

        <!-- CORE CSS -->
        <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

        <!-- THEME CSS -->
        <link href="assets/css/essentials.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/layout.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/color_scheme/green.css" rel="stylesheet" type="text/css" id="color_scheme" />
        <link href="assets/plugins/bootstrap/RTL/bootstrap-rtl.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/bootstrap/RTL/bootstrap-flipped.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/layout-RTL.css" rel="stylesheet" type="text/css" />

    </head>
    <!--
        .boxed = boxed version
    -->
    <body>


        <!-- WRAPPER -->
        <div id="wrapper">

            <div class="padding">

                <div class="panel panel-default">

                    <div class="panel-body">

                        <div class="row">

                            <div class="col-md-4 col-xs-4">
                                <img src="assets/reportimg.png" width="172" height="137" alt="">
                            </div>
                            <div class="col-md-4 col-xs-4 text-center" style="margin-top: 50px">
                                <h6><strong style="font-size: x-large;" ><span style="color: #087ECC"><?php echo $global_var2; ?></span></strong></h6>
                            </div>
                            <div class="col-md-4 col-xs-4 text-right">
                                <img src="assets/images/Adood-logo-smail.png" width="172" height="137" alt="">
                            </div>

                        </div>

                        <hr class="nomargin-top" />
<!----------  -->
<?php
//bind_view($db,'1','','');


    $sq="select * from db where name='$db'";
    $qu=mysql_query($sq) or die(mysql_error());
    $line=mysql_fetch_array($qu);

    add_log($line[0],5,$_SESSION['S_USERID'],'');

    $sql_statment2="select * from `$db` where id='$rowid'";
    $query2=mysql_query($sql_statment2) or die(mysql_error());
    $array_sqlquery2=mysql_fetch_array($query2);
    $flaq2=0;
    $array_sqlquery_count2=mysql_num_rows($query2);
    if($array_sqlquery_count2>0)
    {

        echo'<div class="row">';
        echo'<div class="col-md-12 col-xs-12 text-center">';
        echo '<strong style="font-size: medium;" ><span style="color: #1A1A1A">'.bind_select_view("gt_today",$array_sqlquery2['day']).'&nbsp;&nbsp;&nbsp;&nbsp;الموافق &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$array_sqlquery2['hdate'].'&nbsp;هـ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;| &nbsp;&nbsp;&nbsp;&nbsp;'.$array_sqlquery2['mdate'].'&nbsp;مـ </span></strong></h6>';
        echo '</div>';
        echo '</div>';
        echo '<br>';
        echo'<div class="row">';
        echo'<div class="col-md-12 col-xs-12 text-center">';

        echo"<div class='table-responsive wow shake ' data-wow-delay='0.2s'>
        <table border='2.5' class='table table-striped table-bordered table-hover alert alert-success' bordercolor='black'>
        <tbody>
        <tr class=''>";
        echo "<td width='20%'>الموضوع</td>";
        echo "<td class='text-center'><i class='glyphicon'></i><strong>".$array_sqlquery2['subject']."</strong></td>";
        echo '</tr><tr>';

        echo "<td>رئيس الإجتماع</td>";
        echo "<td class='text-center'><i class='glyphicon'></i><strong>".$array_sqlquery2['meeting_head']."</strong></td>";
        echo '</tr><tr>';

        echo "<td>المشاركون</td>";
        echo "<td class='text-center'><i class='glyphicon'></i><strong>".$array_sqlquery2['participants']."</strong></td>";
        echo '</tr><tr>';

        echo "<td>مكان الإجتماع</td>";
        echo "<td class='text-center'><i class='glyphicon'></i><strong>".$array_sqlquery2['meeting_place']."</strong></td>";
        echo '</tr><tr>';

        echo "<td>وقت الإجتماع</td>";
        echo "<td class='text-center'><i class='glyphicon'></i><strong>".$array_sqlquery2['meetingdate']."</strong></td>";
        echo '</tr><tr><tbody></table>';


        echo "<td>";
        echo $array_sqlquery2['about'];
        echo "</td>";

        echo '</div>';
        echo '</div>';


//print_r($array_sqlquery2);

    }





                                                //bind_route($_REQUEST);

?>
<!----------  -->


                    </div>

                </div>

            </div>

        </div>
        <!-- /WRAPPER -->
        <!-- JAVASCRIPT FILES -->
        <script type="text/javascript">var plugin_path = 'assets/plugins/';</script>
        <script type="text/javascript" src="assets/plugins/jquery/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="assets/js/app.js"></script>

        <script type="text/javascript">
          window.print();
        </script>

    </body>
</html>
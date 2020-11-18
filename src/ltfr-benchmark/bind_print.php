<?php
include "include.php";
//print_r($_POST);

//exit();
//chfun();
$db=$_REQUEST['db'];
$lable=$_REQUEST['lable'];
$global_var=$lable;
$global_var2=$lable;
$_SESSION['db']=$db;

include "fun/main_function.php";
include "administrator/fun/funcat.php";
include "fun/include_fun_bind.php";

	$sq="select * from db where name = '$db'";
    $q=mysql_query($sq) or die(mysql_error());
    $r=mysql_fetch_array($q);

    add_log($r[0],5,$_SESSION['S_USERID'],'');

    $tb_col=$r['tb_col'];
    $sql="select * from generation_table where table_name='$db' and name='$tb_col'";
    $q=mysql_query($sql) or die(mysql_error());
    if(mysql_num_rows($q)>0)
    {
            $row=mysql_fetch_array($q);
            $type=$row['type'];
            if($type=="Select" )
            {
                $qu= mysql_query("select * from gt_".$tb_col);
            }else if($type=="Related to table")
            {
                $qu= mysql_query("select * from ".$row['related_table']);
            }



    $color=$row['lable'].'<br><ul class="dd-list">';
    if(mysql_num_rows($qu)>0)
    {
        while($row=mysql_fetch_array($qu)){

            $val=$row['id'];
            $sql_color="select * from `setting_linecolor` where `table`= '".$db."'  and tb_value='$val'";
        	$query_color=mysql_query($sql_color) or die(mysql_error());
            $array_color=mysql_fetch_array($query_color);
            if(mysql_num_rows($query_color)>0)
            {
                $color.= '<li class="dd-item" data-id="6">
                        <div class="dd-handle bg-'.$array_color['csscolor'].'">
                    	   '.$row['option'].'
                        </div>
                    </li>';
            }
        }
        $color.= '</ul>';
    }
     }

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

							<div class="col-md-4 col-xs-4 text-center" style="margin-top: 0px">
							<img src="assets/images/Adood-logo-smail.png" width="172" height="137" alt="">

                            <h6>
                                <strong style="font-size: xx-large;" >
  							  <span style="color: #087ECC"><?php echo $global_var2; ?></span>                                </strong>
                            </h6>

							</div>
							<div class="col-md-4 col-xs-4 text-left">




                                 <?php
                                   echo $color;
                                 ?>
							</div>

						</div><br>
						<hr class="nomargin-top" />
<!----------  -->
<?php
bind_view($db,'1','','');
                        //bind_route($_REQUEST);

?>
<!----------  -->
						<hr class="nomargin-top" />

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
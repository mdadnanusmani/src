<?php
include "include.php";
is_admin();
design_page("المستخدمين والصلاحيات");
$global_var='إدخال الجدول';
$global_var2='جدول بيانات';
?>
    <section id="middle">

<?php

    design_page_header("المستخدمين والصلاحيات","إدارة المشاريع");
    include "fun/main_function.php";
    include "fun/include_fun_build.php";
   
?>

 					
<!-- Page Content -->
<div id="content" class="padding-20">
                    <div id="panel-4" class="panel panel-default">
                                <div class="panel-heading">

                                    <span class="elipsis"><!-- panel title -->
                                        <strong><? echo $global_var; ?></strong>
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
 

<!--------------------------------22222222222222222222222222222222222222------------------- -->    
    <fieldset>
		
		<div class="row">
			<div class="form-group">
				<div class="col-md-6 col-sm-6">
					<label>أسم الموظف *</label>
                    <? if($editid==$row_DT_edit['table_id'] and $editid!=""){
                                    echo'<input type="text" name="new_label" value="'.$row_DT_edit['lable'].'" placeholder="Lable"   class="form-control" required="required">';
                        }else
                        {
                            echo'<input type="text" name="label" placeholder="Lable" class="form-control" required="required" id="mySelect" onchange="myFunction()">';
                        }

                    ?>					
				</div>
				<div class="col-md-6 col-sm-6">
					<label>رقم السجل *</label>
                    <?php if($editid==$row_DT_edit['table_id'] and $editid!=""){
                        echo'<input type="text" name="new_placeholder" value="'.$row_DT_edit['placeholder'].'" placeholder="Placeholder" id="lableinput"  class="form-control" >';
                    }else
                    {
                        echo'<input type="text" name="placeholder" placeholder="" value="الرجاء إدخال " id="lableinput"  class="form-control">';
                    }

                    ?>
				</div>
			</div>
		</div>
    </fieldset>

<!--------------------------------3333333333333333333333333333333333333------------------- -->    
<fieldset>
		<!-- required [php action request] -->
	

		<div class="row">
			<div class="form-group">
				<div class="col-md-6 col-sm-6">
					<label>رقم الجوال *</label>
                    <? if($editid==$row_DT_edit['table_id'] and $editid!=""){
                                    echo'<input type="text" name="new_default_value" value="'.$row_DT_edit['default_value'].'" placeholder="Default Value" id="inputReadOnly"  class="form-control">';
}else
{
    echo'										<input type="text" name="default_value" placeholder="Default Value" id="inputReadOnly"  class="form-control" >';
}

?>
					
				</div>
				<div class="col-md-6 col-sm-6">
					<label>Width *</label>
                    <?
if($editid==$row_DT_edit['table_id'] and $editid!=""){
if($row_DT_edit['width']=="6")
$select_3="selected='selected'";
if($row_DT_edit['width']=="12")
$select_6="selected='selected'";
echo '                                	         	
<select class="form-control" name="new_width">
    <option value="6" '.$select_3.'>6md</option>
    <option value="12" '.$select_6.'>12md</option>
</select>
    ';

}else
{
echo '
<select class="form-control" name="width">
    <option value="6">6md</option>
    <option value="12">12md</option>
</select>
    ';
}


 ?>
				</div>
			</div>
		</div>
    </fieldset>    
 
 <!--------------------------------5555555555555555555555555555555------------------- -->    
 <?
if($editid==$row_DT_edit['table_id'] and $editid!=""){
echo '<input  type="submit" name="edit_sub" class="btn btn-default" value="Update" />';
echo '<a href="build_table.php"><input  type="button" name="Cancel" class="btn btn-default" value="Cancel" /></a>';
}else
{
echo '<input type="submit" name="submit" class="btn btn-default" value="Generation Table" />';

}
?>
    </form>
</div>
</div>
</div>

                                            <!-- Page Content -->
<div id="content" class="padding">
                    <div id="panel-4" class="panel panel-default">
                        <div class="panel-heading">

                            <span class="elipsis"><!-- panel title -->
                                <strong><? echo $global_var2; ?></strong>
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
                        <table class="table table-no-more table-bordered table-striped mb-none">
									<thead>
										<tr>
											<th>ID</th>
											<th>Name</th>
											<th>Lable</th>
											<th>Placeholder</th>
											<th>Default Value</th>
											<th>Type</th>
											<th>Width</th>
											<th>Font Size</th>
											<th>Visable</th>
											<th>Required</th>                                            
											<th>Table Name</th>
											<th></th>
											<th></th>
										</tr>
									</thead>
									<tbody>
<?php 

  do{

    if($q_count !="0")
  {
    ?>

  <tr>
    <td><? echo $row_DT[0]; ?></td>
    <?php
    if($row_DT[2]=="Select" || $row_DT[2]=="Check Box"){
        echo'<td><a href="build_table_st.php?td_id='.$row_DT[0].'">'.$row_DT[1].'</a></td>';
      }else
      {
        echo '<td>'.$row_DT[1].'</td>';
      }
    ?>
    <td><? echo $row_DT[3]; ?></td>
    <td><? echo $row_DT[7]; ?></td>
    <td><? echo $row_DT[8]; ?></td>
    <td><? echo $row_DT[2]; ?></td>
    <td><? echo $row_DT[4]; ?>md</td>
    <td><? echo $row_DT[6]; ?>px</td>
    <td><? echo $row_DT[5]; ?></td>
    <td><? echo $row_DT[13]; ?></td>
    <td><? echo $row_DT['table_name']; ?></td>
    
    <?php 
    if($row_DT[2]=="Related to table") 
        echo '<td>'.$row_DT['related_table'].' -> '.$row_DT['fields'].' -> '.$row_DT['dis_fields'].'</td>';
    else
        echo '<td></td>';
    ?>
  
    <td>
      <a href="?id=<? echo $row_DT[0]; ?>&op=edit" class="delete-row"><i class="fa fa-pencil"></i></a>
      <a href="?id=<? echo $row_DT[0]; ?>&op=del" class="delete-row"><i class="fa fa-trash-o"></i></a>
    </td>
  </tr>

  <?php
  }
  }while($row_DT=mysql_fetch_array($q_select_DT)); ?>

                                    </tbody>
                        </table>

                        </div>
                    </div>
</div>
  </section>

<?php
desing_page_end();
?>
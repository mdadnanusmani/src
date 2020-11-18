<?php
include "include.php";
is_admin();
design_page("جدول بيانات");
$global_var='إدخال الجدول';
$global_var2='جدول بيانات';
?>
    <section id="middle">

<?php

    design_page_header("إضافة جدول بيانات ","إدارة المشاريع");
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
                                <input type="hidden" name="table_name" value="<? echo $row_DT_edit['table_name']; ?>">
                                <input type="hidden" name="old_name" value="<? echo $row_DT_edit['name']; ?>">
                                <input type="hidden" name="old_type" value="<? echo $row_DT_edit['type']; ?>">
                                <input type="hidden" name="id" value="<? echo $row_DT_edit[0]; ?>">
            <!--------------------------------000000000000000000000000000000------------------- -->
    <fieldset>
		<!-- required [php action request] -->
			<div class="row">
			<div class="form-group">
				<div class="col-md-6 col-sm-6">
					<label>Table *</label>

                    <select  required="required"  class="form-control" id="table" name="table" id="table" >
                        <?PHP 
                        while($row_table = mysql_fetch_row($result_table)){
                            if($row_DT_edit['table_name']==$row_table[0])
                                echo '<option selected="selected">'.$row_table[0].'</option>';
                            else
                                echo '<option>'.$row_table[0].'</option>';
                        };            
                        ?>                 
                    </select>
				</div>

			</div>
		</div>
    </fieldset>
    <!--------------------------------11111111111111111111111111111111111------------------- -->
    <fieldset>
		<!-- required [php action request] -->
			<div class="row">
			<div class="form-group">
				<div class="col-md-6 col-sm-6">
					<label>Name *</label>
					<?php
                        if($editid==$row_DT_edit['table_id'] and $editid!=""){
                        echo '<input type="text" name="new_name" value="'.$row_DT_edit['name'].'" placeholder="Name of table" id="inputReadOnly" class="form-control" required="required">';
                        }
                        else
                        {
                        echo '<input type="text" name="name" placeholder="Name of table" id="inputReadOnly" class="form-control" required="required">';
                        }
                    ?>

				</div>
				<div class="col-md-6 col-sm-6">
					<label>Type of data *</label>
<?
if($editid==$row_DT_edit['table_id'] and $editid!=""){
if($row_DT_edit['type']=="Text")
$select_text="selected='selected'";
if($row_DT_edit['type']=="Select")
$select_select="selected='selected'";
if($row_DT_edit['type']=="Multi Select")
$select_multi_select="selected='selected'";
if($row_DT_edit['type']=="Related to table")
$select_select_related="selected='selected'";
if($row_DT_edit['type']=="Text Area")
$select_area="selected='selected'";
if($row_DT_edit['type']=="Check Box")
$select_check="selected='selected'";
if($row_DT_edit['type']=="Username")
$select_username="selected='selected'";
if($row_DT_edit['type']=="Password")
$select_password="selected='selected'";
if($row_DT_edit['type']=="Phone")
$select_phone="selected='selected'";
if($row_DT_edit['type']=="Email")
$select_email="selected='selected'";
if($row_DT_edit['type']=="Date")
$select_date="selected='selected'";
if($row_DT_edit['type']=="Number")
$select_number="selected='selected'";
if($row_DT_edit['type']=="Time")
$select_time="selected='selected'";
if($row_DT_edit['type']=="DateTime")
$select_datetime="selected='selected'";
if($row_DT_edit['type']=="HTML")
$select_html="selected='selected'";
if($row_DT_edit['type']=="Maps")
$select_maps="selected='selected'";
if($row_DT_edit['type']=="Related to Field")
$select_select_field="selected='selected'";
if($row_DT_edit['type']=="List")
$select_list="selected='selected'";


echo'
<select class="form-control" name="new_type" onchange="normal_vac_type()">
<option '.$select_text.'>Text</option>
<option '.$select_select.'>Select</option>
<option '.$select_multi_select.'>Multi Select</option>
<option '.$select_select_related.'>Related to table</option>
<option '.$select_select_field.'>Related to Field</option>
<option '.$select_area.' >Text Area</option>
<option '.$select_check.' >Check Box</option>
<option '.$select_username.' >Username</option>
<option '.$select_password.' >Password</option>
<option '.$select_phone.' >Phone</option>
<option '.$select_email.' >Email</option>
<option '.$select_date.' >Date</option>
<option '.$select_time.' >Time</option>
<option '.$select_number.' >Number</option>
<option '.$select_datetime.' >DateTime</option>
<option '.$select_html.' >HTML</option>
<option '.$select_maps.' >Maps</option>
<option '.$select_list.' >List</option>

</select>
';
}else
{
  echo'
<select class="form-control" name="type" id="type" onchange="normal_vac_type()">
<option>Text</option>
<option>Select</option>
<option>Multi Select</option>
<option>Related to table</option>
<option>Related to Field</option>
<option>Text Area</option>
<option>Check Box</option>
<option>Username</option>
<option>Password</option>
<option>Phone</option>
<option>Email</option>
<option>Date</option>
<option>Number</option>
<option>Time</option>
<option>DateTime</option>
<option>HTML</option>
<option>Maps</option>
<option>List</option>

</select>
';

}?>
				</div>
			</div>
		</div>
    </fieldset>
    <!--------------------------------999999999999999999999------------------- -->
<div style="display:none" id="myDIV2">
   <hr>

</div>
<div style="display:none" id="myDIV">
   <hr>
    <fieldset >
			<div class="row">
			<div class="form-group">
				<div class="col-md-4 col-sm-6">
					<label>In Table *</label>
                    <input list="tables" autocomplete="on"  class="form-control" name="intable" id="intable">
                    <datalist id="tables">
                        <?PHP
                            while($row_intable = mysql_fetch_row($result_intable)){
                                echo '<option>'.$row_intable[0].'</option>';
                            };
                        ?>
                    </datalist>

				</div>
				<div class="col-md-4 col-sm-6">
					<label>Fileds *</label>
                    <div id='div_session_write_fields'></div>
                    
                    <?php if($editid==$row_DT_edit['table_id'] and $editid!=""){
                        echo'<input type="text" name="new_infield" value="'.$row_DT_edit['fields'].'"  class="form-control" >';
                    }else
                    {
                        echo'<input type="text" name="infield"  class="form-control">';
                    }

                    ?>
				</div>
				<div class="col-md-4 col-sm-6">
					<label>Display Fileds *</label>
                    <div id='div_session_write_fields'></div>
                    
                    <?php if($editid==$row_DT_edit['table_id'] and $editid!=""){
                        echo'<input type="text" name="new_disfield" value="'.$row_DT_edit['dis_fields'].'" class="form-control" >';
                    }else
                    {
                        echo'<input type="text" name="disfield" class="form-control">';
                    }

                    ?>
				</div>

			</div>
		</div>
    </fieldset>
    <hr>
</div>
<!--------------------------------22222222222222222222222222222222222222------------------- -->    
    <fieldset>
		
		<div class="row">
			<div class="form-group">
				<div class="col-md-6 col-sm-6">
					<label>Lable *</label>
                    <? if($editid==$row_DT_edit['table_id'] and $editid!=""){
                                    echo'<input type="text" name="new_label" value="'.$row_DT_edit['lable'].'" placeholder="Lable"   class="form-control" required="required">';
                        }else
                        {
                            echo'<input type="text" name="label" placeholder="Lable" class="form-control" required="required" id="mySelect" onchange="myFunction()">';
                        }

                    ?>					
				</div>
				<div class="col-md-6 col-sm-6">
					<label>Placeholder *</label>
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
					<label>Default Value *</label>
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

if($row_DT_edit['width']=="3")
$select_3="selected='selected'";

if($row_DT_edit['width']=="4")
$select_4="selected='selected'";

if($row_DT_edit['width']=="6")
$select_6="selected='selected'";

if($row_DT_edit['width']=="12")
$select_12="selected='selected'";

echo '
<select class="form-control" name="new_width">
    <option value="3" '.$select_3.'>3md</option>
    <option value="4" '.$select_4.'>4md</option>
    <option value="6" '.$select_6.'>6md</option>
    <option value="12" '.$select_12.'>12md</option>
</select>
    ';

}else
{
echo '
<select class="form-control" name="width">
    <option value="3">3md</option>
    <option value="4">4md</option>
    <option value="6" selected="selected">6md</option>
    <option value="12">12md</option>
</select>
    ';
}


 ?>
				</div>
			</div>
		</div>
    </fieldset>    

<!--------------------------------44444444444444444444444444444444444------------------- -->
<fieldset>
		<!-- required [php action request] -->
		<div class="row">
			<div class="form-group">
				<div class="col-md-6 col-sm-6">
					<label>Font Size *</label>
                    <?
if($editid==$row_DT_edit['table_id'] and $editid!=""){
if($row_DT_edit['font_size']=="14")
$select_14="selected='selected'";
if($row_DT_edit['font_size']=="16")
$select_16="selected='selected'";
if($row_DT_edit['font_size']=="18")
$select_18="selected='selected'";
if($row_DT_edit['font_size']=="20")
$select_20="selected='selected'";

echo '
<select class="form-control" name="new_font_size">
    <option value="14" '.$select_14.'>14px</option>
    <option value="16" '.$select_16.'>16px</option>
    <option value="18" '.$select_18.'>18px</option>
    <option value="20" '.$select_20.'>20px</option>
</select>
    ';

}else
{
echo '
<select class="form-control" name="font_size">
    <option value="14">14px</option>
    <option value="16">16px</option>
    <option value="18">18px</option>
    <option value="20">20px</option>
</select>
    ';
}


 ?>					
				</div>
                <div class="col-md-6 col-sm-6">
					<label>Required *</label>
                    <?
if($editid==$row_DT_edit['table_id'] and $editid!=""){
if($row_DT_edit['required']=="Yes")
$select_1="selected='selected'";
if($row_DT_edit['required']=="No")
$select_2="selected='selected'";
echo '
<select class="form-control" name="new_required">
    <option '.$select_1.'>Yes</option>
    <option '.$select_2.'>No</option>
</select>
    ';

}else
{
echo '
<select class="form-control" name="required">
    <option>Yes</option>
    <option >No</option>
</select>
    ';
}


 ?>
				</div>
			</div>
		</div>
    </fieldset>
   
    <fieldset>
		<!-- required [php action request] -->
		<div class="row">
			<div class="form-group">
				<div class="col-md-6 col-sm-6">
					<label>Order in View *</label>
                    <?php if($editid==$row_DT_edit['table_id'] and $editid!=""){
                        echo'<input type="number" name="new_ordernum" value="'.$row_DT_edit['ordernum'].'" placeholder="Order number"   class="form-control" >';
                    }else
                    {
                        echo'<input type="number" name="ordernum" placeholder="" value=""  class="form-control">';
                    }

                    ?>
				</div>
				<div class="col-md-6 col-sm-6">
					<label>Enabling *</label>
                    <?
if($editid==$row_DT_edit['table_id'] and $editid!=""){
if($row_DT_edit['fenabling']=="1")
$select_1="selected='selected'";
if($row_DT_edit['fenabling']=="2")
$select_2="selected='selected'";
echo '
<select class="form-control" name="new_fenabling">
    <option '.$select_1.'>1</option>
    <option '.$select_2.'>2</option>
</select>
    ';

}else
{
echo '
<select class="form-control" name="fenabling">
    <option>1</option>
    <option>2</option>
</select>
    ';
}


 ?>				</div>
			</div>
		</div>
    </fieldset>
    <!--------------------------------44444444444444444444444444444444444------------------- -->
<fieldset>
		<!-- required [php action request] -->
		<div class="row">
			<div class="form-group">
                <div class="col-md-6 col-sm-6">
					<label>Dependent by fields *</label>
                    <?
if($editid==$row_DT_edit['table_id'] and $editid!=""){
if($row_DT_edit['dbf']=="Yes")
$select_1="selected='selected'";
if($row_DT_edit['dbf']=="No")
$select_2="selected='selected'";
echo '
<select class="form-control" name="new_dbf">
    <option '.$select_2.'>No</option>
    <option '.$select_1.'>Yes</option>
</select>
    ';

}else
{
echo '
<select class="form-control" name="dbf">
    <option >No</option>
    <option>Yes</option>
</select>
    ';
}


 ?>
				</div>
				<div class="col-md-6 col-sm-6">
					<label>Dependent field *</label>
                    <?php if($editid==$row_DT_edit['table_id'] and $editid!=""){
                        echo'<input type="text" name="new_dbf_to" value="'.$row_DT_edit['dbf_to'].'" placeholder=""   class="form-control" >';
                    }else
                    {
                        echo'<input type="test" name="dbf_to" placeholder="" value=""  class="form-control">';
                    }

                    ?>				</div>

			</div>
		</div>
    </fieldset>
    <fieldset>
		<div class="row">
			<div class="form-group">
				<div class="col-md-6 col-sm-6">
					<label>Dependent value *</label>
                    <?php if($editid==$row_DT_edit['table_id'] and $editid!=""){
                        echo'<input type="text" name="new_dbf_value" value="'.$row_DT_edit['dbf_value'].'" placeholder=""   class="form-control" >';
                    }else
                    {
                        echo'<input type="test" name="dbf_value" placeholder="" value=""  class="form-control">';
                    }

                    ?>
                </div>
				<div class="col-md-6 col-sm-6">
					<label>Refields Display *</label>
                    <?php if($editid==$row_DT_edit['table_id'] and $editid!=""){
                        echo'<input type="text" name="new_refields_dis" value="'.$row_DT_edit['refields_dis'].'" placeholder=""   class="form-control" >';
                    }else
                    {
                        echo'<input type="test" name="refields_dis" placeholder="" value=""  class="form-control">';
                    }

                    ?>
                </div>
            </div>
		</div>
    </fieldset>
                  
    <br>    
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
 <div class="table-responsive">
                        <table class="table table-no-more table-bordered table-striped mb-none">
									<thead>
										<tr>
											<th>ID</th>
											<th>Name</th>
											<th>Lable</th>
											<th>Placeholder</th>
										   <!--	<th>Default Value</th> -->
											<th>Type</th>
											<th>Width</th>
											<th>Font Size</th>
											<th>Visable</th>
											<th>Required</th>                                            
                                            <th>Enable</th>
                                            <th>Order</th>
											<th>Table Name</th>
											<th>Relate To</th>
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
    <!--<td><? echo $row_DT[8]; ?></td>-->
    <td><? echo $row_DT[2]; ?></td>
    <td><? echo $row_DT[4]; ?>md</td>
    <td><? echo $row_DT[6]; ?>px</td>
    <td><? echo $row_DT[5]; ?></td>
    <td><? echo $row_DT[13]; ?></td>
    <td><? echo $row_DT['fenabling']; ?></td>
    <td><? echo $row_DT[14]; ?></td>
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
</div>


<?php
desing_page_end();
?>
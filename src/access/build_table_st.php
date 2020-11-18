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
    include "fun/include_fun_build_table_st.php";
   
?>
<!-- Page Content -->
<div id="content" class="padding-20">
                    <div id="panel-4" class="panel panel-default">
                                <div class="panel-heading">

                                    <span class="elipsis"><!-- panel title -->
                                        <strong><? echo $cat_name."&nbsp; / &nbsp; ".$name_field;  ?></strong>
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
<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name" class="form-control">
                        <div class="table-responsive">
<script>
function myFunction() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
</script>
                        <table id="myTable" class="table table-no-more table-bordered table-striped mb-none">
									<thead>
										<tr>
                                            <th>ID</th>
											<th>Option</th>
											<th>Value</th>									
											<th></th>
										</tr>
									</thead>
									<tbody>
                                    <form action="" method="post">
 <tr>
  <td><? echo $maxid['MAX(id)'];  ?></td>
  <td><input required="required" placeholder="Option..." autofocus name="option" class="form-control input-rounded" id="inputRounded"> </td>
  <td><input required="required" placeholder="Value..."  name="value" type="text" value="<? echo $maxid['MAX(id)'];  ?>" class="form-control input-rounded" id="inputRounded"> </td>
  <td><input type="submit" class="mb-xs mt-xs mr-xs btn btn-success" name="submit" value="Save" /></td>
  </tr>
  </form>                                    
                                    <? do{  ?>


<?
if($editid==$row[0] and $editid!="" and $row['0']!="")
{
echo'<tr>
    <td>'.$row[0].'</td>
      <form action="" method="post">
            <td><input required="required" class="form-control input-rounded" type="text" value="'.$row[1].'" name="new_option" /> </td>
            <td><input required="required" class="form-control input-rounded" type="text" value="'.$row[2].'" name="new_value" /> </td>

          <td class="actions">
          <input type="hidden" name="id" value="'.$row[0].'">
           <input type="submit" name="edit_sub" class="btn btn-default" value="Edit Commit" />
           <a href="build_table_st.php"><input type="button" name="Cancel" class="btn btn-default" value="Cancel" /></a>
        </form>
    </td>
       </tr>
          ';

}else if($count_master_cat !="0")
{
?>    <form action="" method="post"><tr>
    <td><? echo $row[0]; ?></td>
    <td><? echo $row[1]; ?></td>
    <td><? echo $row[2]; ?></td>
          <td class="actions">
         
          <a href="build_table_st.php?id=<? echo $row[0]; ?>&op=edit" class="delete-row"><i class="fa fa-pencil"></i></a>
          <a href="build_table_st.php?id=<? echo $row[0]; ?>&op=del" class="delete-row"><i class="fa fa-trash-o"></i></a>
         

       </td>
       </tr> </form>
<?
}
 }while($row=mysql_fetch_array($q)); ?>

 </tbody>
   </table>
   </div>

                    </div>
</div>                    

<?php
desing_page_end();
?>
<?php
include "include.php";
is_admin();
include "fun/main_function.php";
 @session_start();
date_default_timezone_set ( "Asia/Riyadh" );
    $sql = "
    select p.id,p.project_name as 'إسم المشروع',pp.`option` as 'مرحلة المشروع',completion_rate as 'نسبة الإنجاز',cost_approved as 'التكلفة المعتمدة',project_start_date as 'تاريخ بداية المشروع',
    project_end_date as 'تاريخ نهاية المشروع',ps.option as 'هل مشروع متوقف ؟',rf.option as 'سبب التاخير او التوقف', pt.option as 'نوع المشروع',project_description as 'وصف المشروع' ,
    competition_number as 'رقم المنافسة ',contract_number as 'رقم العقد',gr.Name as 'المحافظة' ,gr.Name as 'البلدية الفرعية',latitude as 'الإحداثي العرضي',langitude as 'الإحداثي الطولي',
    contractor_name as 'إسم المقاول',note as 'ملاحظات إضافية' from project p
    left join gt_project_phase pp on  p.project_phase= pp.id
    left join gt_project_suspended ps on  p.project_suspended= ps.id
    left join gt_reason_for_delay_or_stop rf on  p.reason_for_delay_or_stop= rf.id
    left join gt_project_type pt on  p.project_type= pt.id
    left join main_serve gr on  p.governorate= gr.ID
    left join main_serve mu on  p.sub_municipality= mu.ID";

        if($_SESSION['S_SHOW_ALL']==0)
        {

            $usernama=$_SESSION['S_USERNAME'];
            $sql.=" where s_insertby='$usernama'";
        }
    $result = @mysql_query($sql) or die("Failed to execute query:<br />" . mysql_error(). "<br />" . mysql_errno());

    // Header info settings
    header("Content-Type: application/xls");
    header("Content-Disposition: attachment; filename=المشاريع-".date("Y-m-d").".xls");
    header("Pragma: no-cache");
    header("Expires: 0");

  /***** Start of Formatting for Excel *****/
  // Define separator (defines columns in excel &amp; tabs in word)
  $sep = "\t"; // tabbed character
   
  // Start of printing column names as names of MySQL fields
  for ($i = 0; $i<mysql_num_fields($result); $i++) {
    echo mysql_field_name($result, $i) . "\t";
  }
  print("\n");
  // End of printing column names
   
  // Start while loop to get data
  while($row = mysql_fetch_row($result))
  {
    $schema_insert = "";
    for($j=0; $j<mysql_num_fields($result); $j++)
    {
      if(!isset($row[$j])) {
        $schema_insert .= "NULL".$sep;
      }
      elseif ($row[$j] != "") {
        $schema_insert .= "$row[$j]".$sep;
      }
      else {
        $schema_insert .= "".$sep;
      }
    }
    $schema_insert = str_replace($sep."$", "", $schema_insert);
    $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
    $schema_insert .= "\t";
    print(trim($schema_insert));
    print "\n";
  }
?>
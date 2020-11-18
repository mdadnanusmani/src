<?php
include "administrator/config.php";

$sql="
select p.id,p.project_name as 'إسم المشروع',pp.`option` as 'مرحلة المشروع',completion_rate as 'نسبة الإنجاز',cost_approved as 'التكلفة المعتمدة',project_start_date as 'تاريخ بداية المشروع',
project_end_date as 'تاريخ نهاية المشروع',ps.option as 'هل مشروع متوقف ؟',rf.option as 'سبب التاخير او التوقف', pt.option as 'نوع المشروع',project_description as 'وصف المشروع' ,
competition_number as 'رقم المنافسة ',contract_number as 'رقم العقد',gr.Name as 'المحافظة' ,gr.Name as 'البلدية الفرعية',latitude as 'الإحداثي العرضي',langitude as 'الإحداثي الطولي',
contractor_name as 'إسم المقاول',note as 'ملاحظات إضافية' from project p
left join gt_project_phase pp on  p.project_phase= pp.id
left join gt_project_suspended ps on  p.project_suspended= ps.id
left join gt_reason_for_delay_or_stop rf on  p.reason_for_delay_or_stop= rf.id
left join gt_project_type pt on  p.project_type= pt.id
left join main_serve gr on  p.governorate= gr.ID
left join main_serve mu on  p.sub_municipality= mu.ID where p.id=88";
$q=mysql_query($sql);
print_r(mysql_fetch_row($q));
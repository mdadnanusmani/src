<?


 ///////////   Setting

if(isset($_POST['submit_add_vac']) && $_POST['vac_type_one_select'] != '-1')
{
    insert_vac();
    //re_direct("page_vacation.php");
}
if(isset($_POST['submit_add_vac_edit']) && $_POST['vid'] != '')
{
  edit_insert_vac($_POST['vid']);

    //re_direct("page_vacation.php");
}
if(isset($_POST['submit_ch_replace_user']) && $_POST['vac_id'] != '')
{
    select_vac_by_id($_POST['vac_id']);
}


?>
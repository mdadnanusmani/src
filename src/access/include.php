<?
include "administrator/fun/fun.php";
is_loged();
function ch_notificition()
{
    if($_SESSION['S_NOTIFICITION']==1)
    {
        echo '<script langauge="javascript">
            window.setInterval("refreshDiv()", 2000);
            function refreshDiv(){
                jQuery("#div_session_write").load("notificition.php?notificition=1");
            }
        </script>';
    }
}
function chfun()
{
    if(isset($_REQUEST['db']) && $_REQUEST['db']!='' || isset($_SESSION['db']) && $_SESSION['db']!='')
    {
        if (in_array($_REQUEST['db'],$_SESSION['allow_pages']))
        {
            $_SESSION['db']=$_REQUEST['db'];
            $_SESSION['lable']=$_REQUEST['lable'];

        }else if (in_array($_SESSION['db'],$_SESSION['allow_pages']))
        {

        }
        else
        {
            re_direct("page-500.php");
        }

    }
    else
    {
        if( isset( $_REQUEST['op']) && $_REQUEST['row']!='')
        {

        }else
        re_direct("page-500.php");
    }
}

function re_direct($url,$time="0")
{
    echo '<script>window.location = "'.$url.'";</script>';
    exit();
}

function re_direct2($url,$time="0")
{
    echo '<script>window.location = "'.$url.'";</script>';
    exit();
}

function design_page($title)
{
    include "administrator/fun/fun_design.php";
    $PAGE_TITLE=$title;

    include "design/header.php";
    include "design/menu.php";

    echo $header;
    echo $mene;
}
function desing_page_end()
{
include "design/footer.php";
echo $footer;
}

function design_noti_success($msg,$title="تنبيه")
{
echo '<div class="alert alert-success margin-bottom-30"><!-- SUCCESS -->
<button type="button" class="close" data-dismiss="alert">
    <span aria-hidden="true">×</span>
    <span class="sr-only">Close</span>
</button>
<strong> '.$title.'  :</strong>'.$msg.'
</div>';
}

function design_noti_warning($msg,$title="تنبيه")
{
echo '<div class="alert alert-warning margin-bottom-30"><!-- WARNING -->
<strong> '.$title.'  :</strong>'.$msg.'
</div>';
}

function design_noti_danger($msg,$title='تنبيه')
{
echo '<div class="alert alert-danger margin-bottom-30"><!-- DANGER -->
<strong> '.$title.'  :</strong> '.$msg.'
</div>';
}

function noti_show()
{
    if($_SESSION['msg2']!='')
           {
                if($_SESSION['msg_type']=="s")
                {
                    echo design_noti_success($_SESSION['msg2']);
                }else
                {
                    echo design_noti_danger($_SESSION['msg2']);
                }
                if(isset($_SESSION['msg2']))
                {
                    $_SESSION['msg2']="";
                    $_SESSION['msg_type']="";
    
                }
            }
}

?>


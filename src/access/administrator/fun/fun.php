<?
$dbhost = "localhost";
$dbuser = "srcocoms_admin";
$dbpass = "Abc@655010";
$dbname = "srcocoms_partner";

@session_start();
$connn = mysqli_connect( $dbhost, $dbuser, $dbpass,$dbname );
if(mysqli_connect_errno())
{
    echo  mysqli_connect_error();
  exit( "Error Connect to DataBase..." );
}

$_SESSION['dbname']=$dbname;
mysqli_set_charset('utf8',$connn);
///////////////

if ($_SERVER['SERVER_PORT'] != 443)
//echo '<script>window.location = "https://www3.aseer.gov.sa";</script>';

$row_get_data=array();
@session_start();

function con()
{

}

function add_log($db,$opration,$insertby,$note)
{
    $date=date('Y-m-d');
    $time=date('H:i:s');
    $user_id=$_SESSION['S_USERID'];
    $ip=$_SERVER['HTTP_HOST'];
    $sql="insert into log values(null,'$insertby','$user_id','$db','$date','$time',$opration)";
    $q=mysql_query($sql) or die(mysql_error());
    //exit();
}

function or_user_session($row,$f='')
{
    $_SESSION['S_LOGED']="1";
    $_SESSION['S_USERID']=$row['id'];
    $_SESSION['S_ISADMIN']=$row['isadmin'];
    $_SESSION['S_USERNAME']=$row['username'];
    $_SESSION['S_NOTIFICITION']=$row['notificition'];
    $_SESSION['S_CHANGE_PASSWORD']=$f;
    $_SESSION['S_DB_GROUPS']=$row['dbgroups'];
    $_SESSION['S_SHOW_ALL']=$row['showall'];
    $_SESSION['S_MGR']=$row['mgr'];
    $_SESSION['S_MOBILE']=$row['mobile'];


    build_menu($row['isadmin'],$row['dbgroups']);
}



function is_loged()
{
    if($_SESSION['S_LOGED']=='1')
    {
        if($_SESSION['S_CHANGE_PASSWORD']==1)
        {

        }else
        {
           // echo '<script>window.location = "ch_password.php";</script>';
        }

        if($_SESSION['S_MOBILE']=='')
        {
            echo '<script>window.location = "mobile.php";</script>';
        }else
        {
           // echo '<script>window.location = "ch_password.php";</script>';
        }
    }
    else
    {
        $_SESSION['err_msg']="الرجاء تسجيل الدخول أولاُ";
        echo '<script>window.location = "page-login.php";</script>';
    }


}
function is_admin()
{
    if($_SESSION['S_ISADMIN']=='1')
    {

    }
    else
    {       
        echo '<script>window.location = "index.php";</script>';
    }
}

function logout()
{
    session_destroy();
    $_SESSION['err_msg']="تم تسجيل الخروج بنجاح";
    echo '<script>window.location = "login.php";</script>';
}

function logout_user()
{
    session_destroy();
    $_SESSION['err_msg']="تم تسجيل الخروج بنجاح";
    echo '<script>window.location = "page-login.php";</script>';
}

function encrypt($value)
{
   return substr(base64_encode(md5(base64_encode(md5(md5($value))))), 0, 7);
}

function arabic_e2w($str) {
	$arabic_eastern = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
	$arabic_western = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
	return str_replace($arabic_western,$arabic_eastern , $str);
}

function build_menu($isadmin,$dbval)
{
    $_SESSION['allow_pages']='';
    $_SESSION['allow_pages']=array();

    $_SESSION['build_menu']='';
    if($isadmin==1 && $dbval=='-1')
    $sql="select * from db";
    else
    $sql="select * from db where view=1 and id in ($dbval)";


    $q=mysql_query($sql) or die(mysql_error($sql));

    if($isadmin==1)
    {
        $_SESSION['build_menu'].='


        <li>
                <a href="build_table.php">
                    <i class="main-icon fa fa-bar-chart-o"></i> <span>تحكم شامل</span>
                </a>
        </li>';
    }

    while($row=mysql_fetch_array($q)){
        $_SESSION['build_menu'].='
        <form action="route.php" method="post">
        <li>
        <a href="#">
            <i class="fa fa-menu-arrow pull-right"></i>
            <i class="main-icon fa fa-pencil-square-o"></i> <span>'.$row['table_lable'].'</span>
        </a>
            <ul><!-- submenus -->
                <input type="hidden" name="db" value="'.$row['name'].'">
                <input type="hidden" name="lable" value="'.$row['table_lable'].'">
                <input type="hidden" name="page_style" value="'.$row['page_style'].'">
                ';
                if($row['page_style']==1)
                {
$_SESSION['build_menu'].='  <li>
                                <button type="submit" name="action" class="btn" value="1"><span style="color: #FFFFFF">إدخال البيانات</span></button>
                            </li>
                            <li>
                                <button type="submit" name="action" class="btn" value="2"><span style="color: #FFFFFF">عرض البيانات</span></button>
                            </li>';
                }
                else if($row['page_style']==2)
                {
$_SESSION['build_menu'].='  <li>
                                <button type="submit" name="action" class="btn" value="1"><span style="color: #FFFFFF">إدخال البيانات</span></button>
                            </li>';
                }

                $_SESSION['build_menu'].='
                <!-- <li><a href="bind_project.php?db='.$row['name'].'&lable='.$row['table_lable'].'" class="btn">إدخال البيانات</a></li>
                <li><a href="bind_view_project.php?db='.$row['name'].'&lable='.$row['table_lable'].'">عرض البيانات</a></li>-->

            </ul>
        </li>
        </form>
        ';
        array_push($_SESSION['allow_pages'],$row['name']);  
    };

                $_SESSION['build_menu'].='<li>
                    <a href="view.php">
                            <i class="main-icon fa fa-bar-chart-o"></i> <span>التقرير</span>
                    </a>
                </li> ';


}

?>
<?
function design_page_header($page_header,$page_sub1='',$page_sub2='',$page_sub3='',$page_sub4='')
{

echo '
				<!-- page title -->
				<header id="page-header">
					<h1>'.$page_header.'</h1>
					<ol class="breadcrumb">';

if($page_sub1!='')
echo '<li><a href="#">'.$page_sub1.'</a></li>';

if($page_sub2!='')
echo '<li><a href="#">'.$page_sub2.'</a></li>';

if($page_sub3!='')
echo '<li><a href="#">'.$page_sub3.'</a></li>';

if($page_sub4!='')
echo '<li><a href="#">'.$page_sub4.'</a></li>';


echo'						<li class="active">'.$page_header.'</li>
					</ol>
				</header>
				<!-- /page title -->
';


}


?>
<?php
$mene='
		<!-- 
				ASIDE 
				Keep it outside of #wrapper (responsive purpose)
			-->
			<aside id="aside">
				<!--
					Always open:
					<li class="active alays-open">

					LABELS:
						<span class="label label-danger pull-right">1</span>
						<span class="label label-default pull-right">1</span>
						<span class="label label-warning pull-right">1</span>
						<span class="label label-success pull-right">1</span>
						<span class="label label-info pull-right">1</span>
				-->

				<nav id="sideNav"><!-- MAIN MENU -->
					<ul class="nav nav-list">
						<li class="active"><!-- dashboard -->
							<a class="dashboard" href="index.php"><!-- warning - url used by default by ajax (if eneabled) -->
								<i class="active" class="main-icon fa fa-dashboard"></i> <span>الصفحة الرئسية</span>
							</a>
						</li>
'.$_SESSION['build_menu'].'						
								
				</ul>

				</nav>
 
				<span id="asidebg"><!-- aside fixed background --></span>
			</aside>
			<!-- /ASIDE -->


			<!-- HEADER -->
			<header id="header">

				<!-- Mobile Button -->
				<button id="mobileMenuBtn"></button>

				<!-- Logo -->
				<span class="logo pull-left hidden-xs">
                


				</span>

<!--
				<form method="get" action="#" class="search pull-left hidden-xs">
					<input type="text" class="form-control" name="k" placeholder="الرجاء ادخال كلمة البحث.." />
				</form>
-->
				<nav>

					<!-- OPTIONS LIST -->
					<ul class="nav pull-right">

						<!-- USER OPTIONS -->
						<li class="dropdown pull-left">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
								<img class="user-avatar" alt="" src="assets/images/noavatar.jpg" height="34" /> 
								<span class="user-name">
									<span class="hidden-xs">
										'.$_SESSION['S_USERNAME'].'<i class="fa fa-angle-down"></i>
									</span>
								</span>
							</a>


							<ul class="dropdown-menu hold-on-click">
								<li><!-- my inbox -->
									<a href="http://mail.google.com" target="_blank"><i class="fa fa-envelope"></i> البريد الالكتروني

									</a>
								</li>


								<li class="divider"></li>

                                <li>

                                </li>
                                <li class="divider"></li>


								<li><!-- logout -->
									<a href="logout.php"><i class="fa fa-power-off"></i> تسجيل خروج</a>
								</li>

							</ul>

						</li>
						<!-- /USER OPTIONS -->
                      <button type="button" style="z-index:1000;" class="btn btn-info" data-toggle="modal" data-target=".bs-chpass-lg"><i class="fa fa-lock"></i>تغير كلمة المرور</button>
					</ul>
					<!-- /OPTIONS LIST -->

				</nav>

			</header>

			<!-- /HEADER -->
';

?>
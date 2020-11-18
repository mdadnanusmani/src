<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
wp_enqueue_script('jquery-ui-datepicker');
wp_enqueue_style('jquery-ui-css', $protocol.'ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
?>
<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1','packages':['corechart']}]}"></script>
<script type="text/javascript">
    function updateuserlist(pagenum){
        jQuery.post(ajaxurl, {action: 'jsticket_ajax', jstmod: 'agent', task: 'getusersearchstaffreportajax',userlimit:pagenum}, function (data) {
            if(data){
                jQuery("div#records").html("");
                jQuery("div#records").html(data);
                setUserLink();
            }
        });
    }
    function setUserLink() {
        jQuery("a.js-userpopup-link").each(function () {
            var anchor = jQuery(this);
            jQuery(anchor).click(function (e) {
                var id = jQuery(this).attr('data-id');
                var name = jQuery(this).html();
                jQuery("input#username-text").val(name);
                jQuery("input#uid").val(id);
                jQuery("div#userpopup").slideUp('slow', function () {
                    jQuery("div#userpopupblack").hide();
                });
            });
        });
    }
    setUserLink();
    jQuery(document).ready(function ($) {
        $('.custom_date').datepicker({
            dateFormat: 'yy-mm-dd'
        });
        jQuery("a#userpopup").click(function (e) {
            e.preventDefault();
            jQuery("div#userpopupblack").show();
            jQuery.post(ajaxurl, {action: 'jsticket_ajax', jstmod: 'agent', task: 'getusersearchstaffreportajax'}, function (data) {
                if(data){
                    jQuery("div#records").html("");
                    jQuery("div#records").html(data);
                    setUserLink();
                }
            });
            jQuery("div#userpopup").slideDown('slow');
        });
        jQuery("form#userpopupsearch").submit(function (e) {
            e.preventDefault();
            var name = jQuery("input#name").val();
            var emailaddress = jQuery("input#emailaddress").val();
            jQuery.post(ajaxurl, {action: 'jsticket_ajax', name: name, emailaddress: emailaddress, jstmod: 'agent', task: 'getusersearchstaffreportajax'}, function (data) {
                if (data) {
                    jQuery("div#records").html(data);
                    setUserLink();
                }
            });//jquery closed
        });
        jQuery("span.close, div#userpopupblack").click(function (e) {
            jQuery("div#userpopup").slideUp('slow', function () {
                jQuery("div#userpopupblack").hide();
            });

        });
	});

	function resetFrom(){
		document.getElementById('date_start').value = '';
		document.getElementById('date_end').value = '';
		document.getElementById('uid').value = '';
		document.getElementById('username-text').value = '';
		document.getElementById('jssupportticketform').submit();
	}

	google.setOnLoadCallback(drawChart);

      function drawChart() {
      	var data = new google.visualization.DataTable();
		data.addColumn('date', '<?php echo __('Dates','js-support-ticket'); ?>');
        data.addColumn('number', '<?php echo __('New','js-support-ticket'); ?>');
        data.addColumn('number', '<?php echo __('Answered','js-support-ticket'); ?>');
        data.addColumn('number', '<?php echo __('Pending','js-support-ticket'); ?>');
        data.addColumn('number', '<?php echo __('Overdue','js-support-ticket'); ?>');
        data.addColumn('number', '<?php echo __('Closed','js-support-ticket'); ?>');
		data.addRows([
			<?php echo jssupportticket::$_data['line_chart_json_array']; ?>
        ]);

        var options = {
          colors:['#1EADD8','#179650','#D98E11','#DB624C','#5F3BBB'],
          curveType: 'function',
          legend: { position: 'bottom' },
          pointSize: 6,
		  // This line will make you select an entire row of data at a time
		  focusTarget: 'category',
		  chartArea: {width:'90%',top:50}
		};

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
        chart.draw(data, options);
    }
	function resizeCharts () {
	    // redraw charts, dashboards, etc here
	    chart.draw(data, options);
	}
	jQuery(window).resize(resizeCharts);
</script>
<div id="userpopupblack" style="display:none;"></div>
<div id="userpopup" style="display:none;">
    <div class="js-row">
        <form id="userpopupsearch">
            <div class="search-center">
                <div class="search-center-heading"><?php echo __('Select user','js-support-ticket'); ?><span class="close"></span></div>
                <div class="js-col-md-12">
                    <div class="js-col-xs-12 js-col-md-3 js-search-value">
                        <input type="text" name="username" id="username" placeholder="<?php echo __('Username','js-support-ticket'); ?>" />
                    </div>
                    <div class="js-col-xs-12 js-col-md-3 js-search-value">
                        <input type="text" name="name" id="name" placeholder="<?php echo __('Name','js-support-ticket'); ?>" />
                    </div>
                    <div class="js-col-xs-12 js-col-md-3 js-search-value">
                        <input type="text" name="emailaddress" id="emailaddress" placeholder="<?php echo __('Email Address','js-support-ticket'); ?>"/>
                    </div>
                    <div class="js-col-xs-12 js-col-md-3 js-search-value-button">
                        <div class="js-button">
                            <input type="submit" value="<?php echo __('Search','js-support-ticket'); ?>" />
                        </div>
                        <div class="js-button">
                            <input type="submit" onclick="document.getElementById('name').value = '';document.getElementById('username').value = ''; document.getElementById('emailaddress').value = '';" value="<?php echo __('Reset','js-support-ticket'); ?>" />
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div id="records">
        <div id="records-inner">
            <div class="js-staff-searc-desc">
                <?php echo __('Use Search Feature To Select The User','js-support-ticket'); ?>
            </div>
        </div>
    </div>
</div>
<?php JSSTmessage::getMessage(); ?>

<?php
$t_name = 'getstaffmemberexport';
$link_export = admin_url('admin.php?page=export&task='.$t_name.'&action=jstask&uid='.jssupportticket::$_data['filter']['uid'].'&date_start='.jssupportticket::$_data['filter']['date_start'].'&date_end='.jssupportticket::$_data['filter']['date_end']);
?>
<div id="jsstadmin-wrapper">
    <div id="jsstadmin-leftmenu">
        <?php  JSSTincluder::getClassesInclude('jsstadminsidemenu'); ?>
    </div>
    <div id="jsstadmin-data">
    	<span class="js-adminhead-title"> <a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=jssupportticket&jstlay=controlpanel');?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a> <span class="jsheadtext"><?php echo __("Report By Staff Members", 'js-support-ticket') ?></span>
    		<?php if(in_array('export', jssupportticket::$_active_addons)){ ?>
				<a id="jsexport-link" class="js-add-link button" href="<?php echo $link_export; ?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/export-icon.png" /><?php echo __('Export Data', 'js-support-ticket'); ?></a>
			<?php } ?>
		</span>
		<form class="js-filter-form js-report-form" name="jssupportticketform" id="jssupportticketform" method="post" action="<?php echo admin_url("admin.php?page=reports&jstlay=staffreport"); ?>">
		    <?php
		        $curdate = date_i18n('Y-m-d');
		        $enddate = date_i18n('Y-m-d', strtotime("now -1 month"));
		        $date_start = !empty(jssupportticket::$_data['filter']['date_start']) ? jssupportticket::$_data['filter']['date_start'] : $curdate;
		        $date_end = !empty(jssupportticket::$_data['filter']['date_end']) ? jssupportticket::$_data['filter']['date_end'] : $enddate;
		        $uid = !empty(jssupportticket::$_data['filter']['uid']) ? jssupportticket::$_data['filter']['uid'] : '';
		    	echo JSSTformfield::text('date_start', $date_start, array('class' => 'custom_date','placeholder' => __('Start Date','js-support-ticket')));
		    	echo JSSTformfield::text('date_end', $date_end, array('class' => 'custom_date','placeholder' => __('End Date','js-support-ticket')));
		    	echo JSSTformfield::hidden('uid', $uid);
		    	echo JSSTformfield::hidden('JSST_form_search', 'JSST_SEARCH');
			?>
		    <?php if (!empty(jssupportticket::$_data['filter']['staffname'])) { ?>
		        <div id="username-div"><input type="text" value="<?php echo jssupportticket::$_data['filter']['staffname']; ?>" id="username-text" readonly="readonly" data-validation="required"/></div><a href="#" id="userpopup"><?php echo __('Select User', 'js-support-ticket'); ?></a>
		    <?php } else { ?>
		        <div id="username-div"></div><input type="text" value="" id="username-text" readonly="readonly" data-validation="required"/><a href="#" id="userpopup"><?php echo __('Select User', 'js-support-ticket'); ?></a>
		    <?php } ?>
		    <?php echo JSSTformfield::submitbutton('go', __('Search', 'js-support-ticket'), array('class' => 'button')); ?>
			<?php echo JSSTformfield::button('reset', __('Reset', 'js-support-ticket'), array('class' => 'button', 'onclick' => 'resetFrom();')); ?>
		</form>
		<span class="js-admin-subtitle"><?php echo __('Overall Report','js-support-ticket'); ?></span>
		<div id="curve_chart" style="height:400px;width:98%; "></div>
		<div class="js-admin-report-box-wrapper">
			<div class="js-col-md-2 js-admin-box js-col-md-offset-2 box1" >
				<div class="js-col-md-4 js-admin-box-image">
					<img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>/includes/images/report/ticket_icon.png" />
				</div>
				<div class="js-col-md-8 js-admin-box-content">
					<div class="js-col-md-12 js-admin-box-content-number"><?php echo jssupportticket::$_data['ticket_total']['openticket']; ?></div>
					<div class="js-col-md-12 js-admin-box-content-label"><?php echo __('New','js-support-ticket'); ?></div>
				</div>
				<div class="js-col-md-12 js-admin-box-label"></div>
			</div>
			<div class="js-col-md-2 js-admin-box box2">
				<div class="js-col-md-4 js-admin-box-image">
					<img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>/includes/images/report/ticket_answered.png" />
				</div>
				<div class="js-col-md-8 js-admin-box-content">
					<div class="js-col-md-12 js-admin-box-content-number"><?php echo jssupportticket::$_data['ticket_total']['answeredticket']; ?></div>
					<div class="js-col-md-12 js-admin-box-content-label"><?php echo __('Answered','js-support-ticket'); ?></div>
				</div>
				<div class="js-col-md-12 js-admin-box-label"></div>
			</div>
			<div class="js-col-md-2 js-admin-box box3">
				<div class="js-col-md-4 js-admin-box-image">
					<img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>/includes/images/report/ticket_pending.png" />
				</div>
				<div class="js-col-md-8 js-admin-box-content">
					<div class="js-col-md-12 js-admin-box-content-number"><?php echo jssupportticket::$_data['ticket_total']['pendingticket']; ?></div>
					<div class="js-col-md-12 js-admin-box-content-label"><?php echo __('Pending','js-support-ticket'); ?></div>
				</div>
				<div class="js-col-md-12 js-admin-box-label"></div>
			</div>
			<div class="js-col-md-2 js-admin-box box4">
				<div class="js-col-md-4 js-admin-box-image">
					<img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>/includes/images/report/ticket_overdue.png" />
				</div>
				<div class="js-col-md-8 js-admin-box-content">
					<div class="js-col-md-12 js-admin-box-content-number"><?php echo jssupportticket::$_data['ticket_total']['overdueticket']; ?></div>
					<div class="js-col-md-12 js-admin-box-content-label"><?php echo __('Overdue','js-support-ticket'); ?></div>
				</div>
				<div class="js-col-md-12 js-admin-box-label"></div>
			</div>
			<div class="js-col-md-2 js-admin-box box5">
				<div class="js-col-md-4 js-admin-box-image">
					<img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>/includes/images/report/ticket_close.png" />
				</div>
				<div class="js-col-md-8 js-admin-box-content">
					<div class="js-col-md-12 js-admin-box-content-number"><?php echo jssupportticket::$_data['ticket_total']['closeticket']; ?></div>
					<div class="js-col-md-12 js-admin-box-content-label"><?php echo __('Closed','js-support-ticket'); ?></div>
				</div>
				<div class="js-col-md-12 js-admin-box-label"></div>
			</div>
		</div>
		<span class="js-admin-subtitle"><?php echo __('Staff Members','js-support-ticket'); ?></span>
		<?php
		if(!empty(jssupportticket::$_data['staffs_report'])){
			foreach(jssupportticket::$_data['staffs_report'] AS $agent){ ?>
				<div class="js-admin-staff-wrapper">
					<a href="<?php echo admin_url('admin.php?page=reports&jstlay=staffdetailreport&id='.$agent->id.'&date_start='.jssupportticket::$_data['filter']['date_start'].'&date_end='.jssupportticket::$_data['filter']['date_end']); ?>" class="js-admin-staff-anchor-wrapper">
					<div class="js-col-md-4 nopadding">
						<div class="js-col-md-3 js-report-staff-image-wrapper">
							<?php
								if($agent->photo){
									$maindir = wp_upload_dir();
									$path = $maindir['baseurl'];

									$imageurl = $path."/".jssupportticket::$_config['data_directory']."/staffdata/staff_".$agent->id."/".$agent->photo;
								}else{
									$imageurl = jssupportticket::$_pluginpath."includes/images/defaultprofile.png";
								}
							?>
							<img class="js-report-staff-pic" src="<?php echo esc_url($imageurl); ?>" />
						</div>
						<div class="js-col-md-9">
							<div class="js-report-staff-name">
								<?php
									if($agent->firstname && $agent->lastname){
										$agentname = $agent->firstname . ' ' . $agent->lastname;
									}else{
										$agentname = $agent->display_name;
									}
									echo $agentname;
								?>
							</div>
							<div class="js-report-staff-username">
								<?php
									if($agent->display_name){
										$username = $agent->display_name;
									}else{
										$username = $agent->user_nicename;
									}
									echo $username;
								?>
							</div>
							<div class="js-report-staff-email">
								<?php
									if($agent->email){
										$email = $agent->email;
									}else{
										$email = $agent->user_email;
									}
									echo $email;
								?>
							</div>
						</div>
					</div>
					<?php
					$rating_class = 'box6';
						if(in_array('feedback', jssupportticket::$_active_addons)){
							if($agent->avragerating > 4){
								$rating_class = 'box65';
							}elseif($agent->avragerating > 3){
								$rating_class = 'box64';
							}elseif($agent->avragerating > 2){
								$rating_class = 'box63';
							}elseif($agent->avragerating > 1){
								$rating_class = 'box62';
							}elseif($agent->avragerating > 0){
								$rating_class = 'box61';
							}
						}
						if(in_array('timetracking', jssupportticket::$_active_addons)){
							$hours = floor($agent->time[0] / 3600);
				            $mins = floor(($agent->time[0] / 60) % 60);
				            $secs = floor($agent->time[0] % 60);
				            $avgtime = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
				        }
			        ?>
					<div class="js-col-md-8 nopadding jsst-report-staff-listing-box">
						<div class="js-admin-report-box box1">
							<span class="js-report-box-number"><?php echo $agent->openticket; ?></span>
							<span class="js-report-box-title"><?php echo __('New','js-support-ticket'); ?></span>
							<div class="js-report-box-color"></div>
						</div>
						<div class="js-admin-report-box box2">
							<span class="js-report-box-number"><?php echo $agent->answeredticket; ?></span>
							<span class="js-report-box-title"><?php echo __('Answered','js-support-ticket'); ?></span>
							<div class="js-report-box-color"></div>
						</div>
						<div class="js-admin-report-box box3">
							<span class="js-report-box-number"><?php echo $agent->pendingticket; ?></span>
							<span class="js-report-box-title"><?php echo __('Pending','js-support-ticket'); ?></span>
							<div class="js-report-box-color"></div>
						</div>
						<div class="js-admin-report-box box4">
							<span class="js-report-box-number"><?php echo $agent->overdueticket; ?></span>
							<span class="js-report-box-title"><?php echo __('Overdue','js-support-ticket'); ?></span>
							<div class="js-report-box-color"></div>
						</div>
						<div class="js-admin-report-box box5">
							<span class="js-report-box-number"><?php echo $agent->closeticket; ?></span>
							<span class="js-report-box-title"><?php echo __('Closed','js-support-ticket'); ?></span>
							<div class="js-report-box-color"></div>
						</div>
						<?php if(in_array('feedback', jssupportticket::$_active_addons)){ ?>
							<div class="js-admin-report-box <?php echo $rating_class?>">
								<span class="js-report-box-number">
									<?php if($agent->avragerating > 0){ ?>
										<span class="rating" ><?php echo round($agent->avragerating,1); ?></span>/5
									<?php }else{ ?>
										NA
									<?php } ?>
								</span>
								<span class="js-report-box-title"><?php echo __('Average rating','js-support-ticket'); ?></span>
								<div class="js-report-box-color"></div>
							</div>
						<?php } ?>
						<?php if(in_array('timetracking', jssupportticket::$_active_addons)){ ?>
							<div class="js-admin-report-box box7">
								<span class="js-report-box-number">
									<span class="time" >
										<?php echo $avgtime; ?>
									</span>
									<span class="exclamation" >
										<?php
										if($agent->time[1] != 0){
							            	echo '!';
							            }
										?>
									</span>
								</span>
								<span class="js-report-box-title"><?php echo __('Average time','js-support-ticket'); ?></span>
								<div class="js-report-box-color"></div>
							</div>
						<?php } ?>
					</div>
					</a>
				</div>
			<?php
			}
		    if (jssupportticket::$_data[1]) {
		        echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . jssupportticket::$_data[1] . '</div></div>';
		    }
		}
		?>
	</div>
</div>

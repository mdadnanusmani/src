<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
wp_enqueue_script('jquery-ui-datepicker');
wp_enqueue_style('jquery-ui-css', $protocol.'ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
?>
<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1','packages':['corechart']}]}"></script>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('.custom_date').datepicker({
            dateFormat: 'yy-mm-dd'
        });
	});
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

	function resetFrom(){
		document.getElementById('date_start').value = '';
		document.getElementById('date_end').value = '';
		document.getElementById('jssupportticketform').submit();
	}
</script>
<?php JSSTmessage::getMessage(); ?>

<?php
$t_name = 'getstaffmemberexportbystaffid';
$link_export = admin_url('admin.php?page=export&task='.$t_name.'&action=jstask&uid='.jssupportticket::$_data['filter']['uid'].'&date_start='.jssupportticket::$_data['filter']['date_start'].'&date_end='.jssupportticket::$_data['filter']['date_end']);
?>
<div id="jsstadmin-wrapper">
    <div id="jsstadmin-leftmenu">
        <?php  JSSTincluder::getClassesInclude('jsstadminsidemenu'); ?>
    </div>
    <div id="jsstadmin-data">
	    <span class="js-adminhead-title"> <a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=reports&jstlay=staffreport');?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a> <span class="jsheadtext"><?php echo __("Report By Staff Member", 'js-support-ticket') ?></span>
	    	<?php if(in_array('export', jssupportticket::$_active_addons)){ ?>
				<a id="jsexport-link" class="js-add-link button" href="<?php echo $link_export; ?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/export-icon.png" /><?php echo __('Export Data', 'js-support-ticket'); ?></a>
			<?php } ?>
		</span>
		<?php
		$agent = jssupportticket::$_data['staff_report'];
		?>

		<a href="<?php echo admin_url('admin.php?page=reports&jstlay=staffdetailreport&id='.$agent->id.'&date_start='.jssupportticket::$_data['filter']['date_start'].'&date_end='.jssupportticket::$_data['filter']['date_end']); ?>"></a>
		<form class="js-filter-form js-report-form" name="jssupportticketform" id="jssupportticketform" method="post" action="<?php echo admin_url("admin.php?page=reports&jstlay=staffdetailreport&id=".jssupportticket::$_data['staff_report']->id); ?>">
		    <?php
		        $curdate = date_i18n('Y-m-d');
		        $enddate = date_i18n('Y-m-d', strtotime("now -1 month"));
		        $date_start = !empty(jssupportticket::$_data['filter']['date_start']) ? jssupportticket::$_data['filter']['date_start'] : $curdate;
		        $date_end = !empty(jssupportticket::$_data['filter']['date_end']) ? jssupportticket::$_data['filter']['date_end'] : $enddate;
		    	echo JSSTformfield::text('date_start', $date_start, array('class' => 'custom_date','placeholder' => __('Start Date','js-support-ticket')));
		    	echo JSSTformfield::text('date_end', $date_end, array('class' => 'custom_date','placeholder' => __('End Date','js-support-ticket')));
		    	echo JSSTformfield::hidden('JSST_form_search', 'JSST_SEARCH');
			?>
		    <?php echo JSSTformfield::submitbutton('go', __('Search', 'js-support-ticket'), array('class' => 'button')); ?>
			<?php echo JSSTformfield::button('reset', __('Reset', 'js-support-ticket'), array('class' => 'button', 'onclick' => 'resetFrom();')); ?>
		</form>
		<span class="js-admin-subtitle"><?php echo __('Staff Member','js-support-ticket'); ?></span>
		<div id="curve_chart" style="height:400px;width:98%; "></div>
		<?php
			if(!empty($agent)){ ?>
				<div class="js-admin-staff-wrapper padding">
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
						<div class=" js-admin-report-box box1">
							<span class="js-report-box-number"><?php echo $agent->openticket; ?></span>
							<span class="js-report-box-title"><?php echo __('New','js-support-ticket'); ?></span>
							<div class="js-report-box-color"></div>
						</div>
						<div class=" js-admin-report-box box2">
							<span class="js-report-box-number"><?php echo $agent->answeredticket; ?></span>
							<span class="js-report-box-title"><?php echo __('Answered','js-support-ticket'); ?></span>
							<div class="js-report-box-color"></div>
						</div>
						<div class=" js-admin-report-box box3">
							<span class="js-report-box-number"><?php echo $agent->pendingticket; ?></span>
							<span class="js-report-box-title"><?php echo __('Pending','js-support-ticket'); ?></span>
							<div class="js-report-box-color"></div>
						</div>
						<div class=" js-admin-report-box box4">
							<span class="js-report-box-number"><?php echo $agent->overdueticket; ?></span>
							<span class="js-report-box-title"><?php echo __('Overdue','js-support-ticket'); ?></span>
							<div class="js-report-box-color"></div>
						</div>
						<div class=" js-admin-report-box box5">
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
								<a class="" target="_blank" href="<?php echo admin_url('admin.php?page=reports&jstlay=stafftimereport&id='.$agent->id); ?>" >
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
								</a>
							</div>
						<?php } ?>
					</div>
				</div>
			<?php
			} ?>
		<span class="js-admin-subtitle"><?php echo __('Tickets','js-support-ticket'); ?></span>
		<?php
			if(!empty(jssupportticket::$_data['staff_tickets'])){ ?>
				<table class="js-admin-report-tickets">
					<tr class="js-support-ticket-table-heading">
						<th width="60%"><?php echo __('Subject','js-support-ticket'); ?></th>
						<th><?php echo __('Status','js-support-ticket'); ?></th>
						<th><?php echo __('Priority','js-support-ticket'); ?></th>
						<th><?php echo __('Created','js-support-ticket'); ?></th>
						<?php if(in_array('feedback', jssupportticket::$_active_addons)){ ?>
							<th><?php echo __('Rating','js-support-ticket'); ?></th>
						<?php }?>
						<?php if(in_array('timetracking', jssupportticket::$_active_addons)){ ?>
							<th><?php echo __('Time Taken','js-support-ticket'); ?></th>
						<?php }?>
					</tr>
				<?php
				$show_flag = 0;
				foreach(jssupportticket::$_data['staff_tickets'] AS $ticket){
					if(in_array('timetracking', jssupportticket::$_active_addons)){
						$hours = floor($ticket->time / 3600);
			            $mins = floor(($ticket->time / 60) % 60);
			            $secs = floor($ticket->time % 60);
			            $avgtime = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
			        }
					if(in_array('feedback', jssupportticket::$_active_addons)){
			            $rating_color = 0;
			            if($ticket->rating > 4){
			            	$rating_color = '#ea1d22';
			            }elseif($ticket->rating > 3){
			            	$rating_color = '#f58634';
			            }elseif($ticket->rating > 2){
			            	$rating_color = '#a8518a';
			            }elseif($ticket->rating > 1){
			            	$rating_color = '#0098da';
			            }elseif($ticket->rating > 0){
			            	$rating_color = '#069a2e';
			            }
			        }
				 ?>
					<tr>
						<td class="overflow">
							<span class="js-ticket-admin-cp-showhide">
								<?php echo __('Subject','js-support-ticket'); ?> :
							</span>
							<a target="_blank" href="<?php echo admin_url('admin.php?page=ticket&jstlay=ticketdetail&jssupportticketid='.$ticket->id); ?>"><?php echo $ticket->subject; ?></a>
						<?php
						if($agent->id != $ticket->staffid){
							$show_flag = 1;
							?>
							<font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font>
						<?php } ?>
						</td>
						<td >
							<span class="js-ticket-admin-cp-showhide">
								<?php echo __('Status','js-support-ticket'); ?> :
							</span>
							<?php
					            // 0 -> New Ticket
					            // 1 -> Waiting admin/staff reply
					            // 2 -> in progress
					            // 3 -> waiting for customer reply
					            // 4 -> close ticket
								$status = '';
								switch($ticket->status){
									case 0:
										$status = '<font color="#1EADD8">'.__('New','js-support-ticket').'</font>';
										if($ticket->isoverdue == 1)
											$status = '<font color="#DB624C">'.__('Overdue','js-support-ticket').'</font>';
									break;
									case 1:
										$status = '<font color="#D98E11">'.__('Pending','js-support-ticket').'</font>';
										if($ticket->isoverdue == 1)
											$status = '<font color="#DB624C">'.__('Overdue','js-support-ticket').'</font>';
									break;
									case 2:
										$status = '<font color="#D98E11">'.__('In Progress','js-support-ticket').'</font>';
										if($ticket->isoverdue == 1)
											$status = '<font color="#DB624C">'.__('Overdue','js-support-ticket').'</font>';
									break;
									case 3:
										$status = '<font color="#179650">'.__('Answered','js-support-ticket').'</font>';
										if($ticket->isoverdue == 1)
											$status = '<font color="#DB624C">'.__('Overdue','js-support-ticket').'</font>';
									break;
									case 4:
										$status = '<font color="#5F3BBB">'.__('Closed','js-support-ticket').'</font>';
									break;
									case 5:
										$status = '<font color="#5F3BBB">'.__('Merged and closed','js-support-ticket').'</font>';
									break;
								}
								echo $status;
							?>
						</td>
						<td style="color:<?php echo $ticket->prioritycolour; ?>;">
							<span class="js-ticket-admin-cp-showhide"><?php echo __('Priority','js-support-ticket'); ?> :</span>
							<?php echo __($ticket->priority,'js-support-ticket'); ?>
						</td>
						<td >
							<span class="js-ticket-admin-cp-showhide"><?php echo __("Created","js-support-ticket");?>: </span>
							<?php echo date_i18n('Y-m-d',strtotime($ticket->created)); ?>
						</td>
						<?php if(in_array('feedback', jssupportticket::$_active_addons)){ ?>
							<td >
								<span class="js-ticket-admin-cp-showhide"> <?php echo __('Rating','js-support-ticket'); ?> : </span>
								<?php if($ticket->rating > 0){ ?>
									<span style="color:<?php echo $rating_color; ?>;font-weight:bold;font-size:16px;" > <?php echo $ticket->rating;?></span>
									<?php echo __('out of','js-support-ticket').'<span style="font-weight:bold;font-size:15px;" >&nbsp;5</span>';
								}else{
									echo 'NA';
								} ?>
							</td>
						<?php } ?>
						<?php if(in_array('timetracking', jssupportticket::$_active_addons)){ ?>
							<td >
								<span class="js-ticket-admin-cp-showhide"><?php echo __('Time Taken','js-support-ticket'); ?> : </span>
								<?php echo $avgtime; ?>
							</td>
						<?php } ?>
					</tr>
				<?php
				} ?>
				</table>
				<?php if($show_flag == 1){ ?>
					<div class="js-form-button">
			        <?php echo '<font style="color:#1C6288;font-size:20px;margin:0px 5px;">*</font>'.__('Tickets not assigned to the staff member','js-support-ticket'); ?>
			        </div>
		        <?php } ?>

				<?php
			    if (jssupportticket::$_data[1]) {
			        echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . jssupportticket::$_data[1] . '</div></div>';
			    }
			}
			?>
		</div>
	</div>

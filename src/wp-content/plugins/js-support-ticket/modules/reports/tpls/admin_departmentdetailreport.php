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
$department = jssupportticket::$_data['depatments_report'];
$t_name = 'getdepartmentmemberexportbydepartmentid';
$link_export = admin_url('admin.php?page=export&task='.$t_name.'&action=jstask&id='.jssupportticket::$_data['filter']['id'].'&date_start='.jssupportticket::$_data['filter']['date_start'].'&date_end='.jssupportticket::$_data['filter']['date_end']);
?>
<div id="jsstadmin-wrapper">
    <div id="jsstadmin-leftmenu">
        <?php  JSSTincluder::getClassesInclude('jsstadminsidemenu'); ?>
    </div>
    <div id="jsstadmin-data">
	    <span class="js-adminhead-title"> <a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=reports&jstlay=departmentreport');?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a> <span class="jsheadtext"><?php echo __("Report By Department", 'js-support-ticket') ?></span>
	    	<?php if(in_array('export', jssupportticket::$_active_addons)){ ?>
				<a id="jsexport-link" class="js-add-link button" href="<?php echo $link_export; ?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/export-icon.png" /><?php echo __('Export Data', 'js-support-ticket'); ?></a>
			<?php } ?>
		</span>
		<a href="<?php echo admin_url('admin.php?page=reports&jstlay=departmentdetailreport&id='.$department->id.'&date_start='.jssupportticket::$_data['filter']['date_start'].'&date_end='.jssupportticket::$_data['filter']['date_end']); ?>"></a>
		<form class="js-filter-form js-report-form" name="jssupportticketform" id="jssupportticketform" method="post" action="<?php echo admin_url("admin.php?page=reports&jstlay=departmentdetailreport&id=".$department->id); ?>">
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
		<span class="js-admin-subtitle"><?php echo __('Department','js-support-ticket'); ?></span>
		<div id="curve_chart" style="height:400px;width:98%; "></div>
		<?php

			if(!empty($department)){ ?>
				<div class="js-admin-staff-wrapper padding">
					<div class="js-col-md-4 nopadding">
						<div class="js-col-md-9">
							<div class="js-report-staff-name">
								<?php
									echo $department->departmentname;
								?>
							</div>
							<div class="js-report-staff-email">
								<?php
									echo $department->email;
								?>
							</div>
						</div>
					</div>
					<div class="js-col-md-8 nopadding">
						<div class="js-col-md-2 js-col-md-offset-1 js-admin-report-box box1">
							<span class="js-report-box-number"><?php echo $department->openticket; ?></span>
							<span class="js-report-box-title"><?php echo __('New','js-support-ticket'); ?></span>
							<div class="js-report-box-color"></div>
						</div>
						<div class="js-col-md-2 js-admin-report-box box2">
							<span class="js-report-box-number"><?php echo $department->answeredticket; ?></span>
							<span class="js-report-box-title"><?php echo __('Answered','js-support-ticket'); ?></span>
							<div class="js-report-box-color"></div>
						</div>
						<div class="js-col-md-2 js-admin-report-box box3">
							<span class="js-report-box-number"><?php echo $department->pendingticket; ?></span>
							<span class="js-report-box-title"><?php echo __('Pending','js-support-ticket'); ?></span>
							<div class="js-report-box-color"></div>
						</div>
						<div class="js-col-md-2 js-admin-report-box box4">
							<span class="js-report-box-number"><?php echo $department->overdueticket; ?></span>
							<span class="js-report-box-title"><?php echo __('Overdue','js-support-ticket'); ?></span>
							<div class="js-report-box-color"></div>
						</div>
						<div class="js-col-md-2 js-admin-report-box box5">
							<span class="js-report-box-number"><?php echo $department->closeticket; ?></span>
							<span class="js-report-box-title"><?php echo __('Closed','js-support-ticket'); ?></span>
							<div class="js-report-box-color"></div>
						</div>
					</div>
				</div>
			<?php
			} ?>
		<span class="js-admin-subtitle"><?php echo __('Tickets','js-support-ticket'); ?></span>
		<?php
			if(!empty(jssupportticket::$_data['department_tickets'])){ ?>
				<table class="js-admin-report-tickets">
					<tr>
						<th width="60%"><?php echo __('Subject','js-support-ticket'); ?></th>
						<th><?php echo __('Status','js-support-ticket'); ?></th>
						<th><?php echo __('Priority','js-support-ticket'); ?></th>
						<th><?php echo __('Created','js-support-ticket'); ?></th>
						<?php if(in_array('feedback', jssupportticket::$_active_addons)){ ?>
							<th><?php echo __('Rating','js-support-ticket'); ?></th>
						<?php } ?>
						<?php if(in_array('timetracking', jssupportticket::$_active_addons)){ ?>
							<th><?php echo __('Time Taken','js-support-ticket'); ?></th>
						<?php } ?>
					</tr>
				<?php
				foreach(jssupportticket::$_data['department_tickets'] AS $ticket){
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
						<td class="overflow"><a target="_blank" href="<?php echo admin_url('admin.php?page=ticket&jstlay=ticketdetail&jssupportticketid='.$ticket->id); ?>"><?php echo $ticket->subject; ?></a></td>
						<td >
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
						<td style="color:<?php echo $ticket->prioritycolour; ?>;"><?php echo __($ticket->priority,'js-support-ticket'); ?></td>
						<td ><?php echo date_i18n('Y-m-d',strtotime($ticket->created)); ?></td>
						<?php if(in_array('feedback', jssupportticket::$_active_addons)){ ?>
							<td >
								<?php if($ticket->rating > 0){ ?>
									<span style="color:<?php echo $rating_color; ?>;font-weight:bold;font-size:16px;" > <?php echo $ticket->rating;?></span>
									<?php echo __('out of','js-support-ticket').'<span style="font-weight:bold;font-size:15px;" >&nbsp;5</span>';
								}else{
									echo 'NA';
								} ?>
							</td>
						<?php
						}
						if(in_array('timetracking', jssupportticket::$_active_addons)){ ?>
							<td ><?php echo $avgtime; ?></td>
						<?php }?>
					</tr>
				<?php
				} ?>
				</table>
				<?php
			    if (jssupportticket::$_data[1]) {
			        echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . jssupportticket::$_data[1] . '</div></div>';
			    }
			}
			?>
	</div>
</div>

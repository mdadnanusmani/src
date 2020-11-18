<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
wp_enqueue_script('jquery-ui-datepicker');
wp_enqueue_style('jquery-ui-css', $protocol.'ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
?>
<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1','packages':['corechart']}]}"></script>
<script type="text/javascript">
    	function resetFrom(){
		document.getElementById('date_start').value = '';
		document.getElementById('date_end').value = '';
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
<?php JSSTmessage::getMessage(); ?>
<?php
$t_name = 'getdepartmentexport';
$link_export = admin_url('admin.php?page=export&task='.$t_name.'&action=jstask&date_start='.jssupportticket::$_data['filter']['date_start'].'&date_end='.jssupportticket::$_data['filter']['date_end']);
?>
<div id="jsstadmin-wrapper">
    <div id="jsstadmin-leftmenu">
        <?php  JSSTincluder::getClassesInclude('jsstadminsidemenu'); ?>
    </div>
    <div id="jsstadmin-data">
	    <span class="js-adminhead-title"> <a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=jssupportticket&jstlay=controlpanel');?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a> <span class="jsheadtext"><?php echo __("Report By Departments", 'js-support-ticket') ?></span>
	  		<?php if(in_array('export', jssupportticket::$_active_addons)){ ?>
	  			<a id="jsexport-link" class="js-add-link button" href="<?php echo $link_export; ?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/export-icon.png" /><?php echo __('Export Data', 'js-support-ticket'); ?></a>
	  		<?php } ?>
		</span>
		<form class="js-filter-form js-report-form" name="jssupportticketform" id="jssupportticketform" method="post" action="<?php echo admin_url("admin.php?page=reports&jstlay=departmentreport"); ?>">
		    <?php
		        $curdate = date_i18n('Y-m-d');
		        $enddate = date_i18n('Y-m-d', strtotime("now -1 month"));
		        $date_start = !empty(jssupportticket::$_data['filter']['date_start']) ? jssupportticket::$_data['filter']['date_start'] : $curdate;
		        $date_end = !empty(jssupportticket::$_data['filter']['date_end']) ? jssupportticket::$_data['filter']['date_end'] : $enddate;
		        $uid = !empty(jssupportticket::$_data['filter']['uid']) ? jssupportticket::$_data['filter']['uid'] : '';
		    	echo JSSTformfield::text('date_start', $date_start, array('class' => 'custom_date','placeholder' => __('Start Date','js-support-ticket')));
		    	echo JSSTformfield::text('date_end', $date_end, array('class' => 'custom_date','placeholder' => __('End Date','js-support-ticket')));
		    	echo JSSTformfield::hidden('JSST_form_search', 'JSST_SEARCH');
			?>
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
		<span class="js-admin-subtitle"><?php echo __('Departments','js-support-ticket'); ?></span>
		<?php
		if(!empty(jssupportticket::$_data['depatments_report'])){
			foreach(jssupportticket::$_data['depatments_report'] AS $dept){ ?>
				<div class="js-admin-staff-wrapper">
					<a href="<?php echo admin_url('admin.php?page=reports&jstlay=departmentdetailreport&id='.$dept->id.'&date_start='.jssupportticket::$_data['filter']['date_start'].'&date_end='.jssupportticket::$_data['filter']['date_end']); ?>" class="js-admin-staff-anchor-wrapper">
					<div class="js-col-md-4 nopadding">
						<div class="js-col-md-9">
							<div class="js-report-staff-name">
								<?php
									echo $dept->departmentname;
								?>
							</div>
							<div class="js-report-staff-email">
								<?php
									echo $dept->email;
								?>
							</div>
						</div>
					</div>
					<div class="js-col-md-8 nopadding">
						<div class="js-col-md-2 js-col-md-offset-1 js-admin-report-box box1">
							<span class="js-report-box-number"><?php echo $dept->openticket; ?></span>
							<span class="js-report-box-title"><?php echo __('New','js-support-ticket'); ?></span>
							<div class="js-report-box-color"></div>
						</div>
						<div class="js-col-md-2 js-admin-report-box box2">
							<span class="js-report-box-number"><?php echo $dept->answeredticket; ?></span>
							<span class="js-report-box-title"><?php echo __('Answered','js-support-ticket'); ?></span>
							<div class="js-report-box-color"></div>
						</div>
						<div class="js-col-md-2 js-admin-report-box box3">
							<span class="js-report-box-number"><?php echo $dept->pendingticket; ?></span>
							<span class="js-report-box-title"><?php echo __('Pending','js-support-ticket'); ?></span>
							<div class="js-report-box-color"></div>
						</div>
						<div class="js-col-md-2 js-admin-report-box box4">
							<span class="js-report-box-number"><?php echo $dept->overdueticket; ?></span>
							<span class="js-report-box-title"><?php echo __('Overdue','js-support-ticket'); ?></span>
							<div class="js-report-box-color"></div>
						</div>
						<div class="js-col-md-2 js-admin-report-box box5">
							<span class="js-report-box-number"><?php echo $dept->closeticket; ?></span>
							<span class="js-report-box-title"><?php echo __('Closed','js-support-ticket'); ?></span>
							<div class="js-report-box-color"></div>
						</div>
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
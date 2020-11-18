<div id="jsstadmin-wrapper">
    <div id="jsstadmin-leftmenu">
        <?php  JSSTincluder::getClassesInclude('jsstadminsidemenu'); ?>
    </div>
    <div id="jsstadmin-data">
    <span class="js-adminhead-title"> <a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=jssupportticket');?>"><img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a> <span class="jsheadtext"><?php echo __("Satisfaction Report", 'js-support-ticket') ?></span>
		</span>
		<?php
		$percentage = round(jssupportticket::$_data[0]['avg']*20,2);
		?>
		<div class="jsst-statifacetion-report-wrapper" >
			<div class="statifacetion-report-left" >
				<?php
					$class="first";
					$src ="excelent.png";
					if($percentage > 80){
						$class="first";
						$src ="excelent.png";
					}elseif($percentage > 60){
						$class="second";
						$src ="happy.png";
					}elseif($percentage > 40){
						$class="third";
						$src ="normal.png";
					}elseif($percentage > 20){
						$class="fourth";
						$src ="bad.png";
					}elseif($percentage > 0){
						$class="fifth";
						$src ="angery.png";
					}

					?>
				<div class="top-number <?php echo $class;?>" >
					<?php echo $percentage.'%'; ?>
				</div>
				<span class="total-feedbacks" >
					<?php echo __('Based on','js-support-ticket').'&nbsp;'. jssupportticket::$_data[0]['result'][6].'&nbsp;'. __('Feedbacks','js-support-ticket');?>
				</span>
				<div class="top-text" >
					<?php echo __('Customer Satisfaction','js-support-ticket')?>
				</div>
			</div>

			<div class="satisfaction-report-right <?php echo $class; ?>" >
				<img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/<?php echo $src;?>" />
			</div>




			<div class="jsst-satisfaction-report-bottom" >
				<div class="indi-stats first" >
					<img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/excelent.png" />
					<div class="stats-percentage" ><?php
						if(jssupportticket::$_data[0]['result'][6] != 0){
							echo round(jssupportticket::$_data[0]['result'][5]/jssupportticket::$_data[0]['result'][6]*100 ,2).'%';
						}else{
							echo __('NA','js-support-ticket');
						}
						?></div>
					<div class="stats-text" > <?php echo __('Excellent','js-support-ticket')?> </div>
				</div>
				<div class="indi-stats second" >
					<img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/happy.png" />
					<div class="stats-percentage" ><?php
						if(jssupportticket::$_data[0]['result'][6] != 0){
							echo round(jssupportticket::$_data[0]['result'][4]/jssupportticket::$_data[0]['result'][6]*100 ,2).'%';
						}else{
							echo __('NA','js-support-ticket');
						}
						?></div>
					<div class="stats-text" > <?php echo __('Happy','js-support-ticket')?> </div>
				</div>
				<div class="indi-stats third" >
					<img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/normal.png" />
					<div class="stats-percentage" ><?php
						if(jssupportticket::$_data[0]['result'][6] != 0){
							echo round(jssupportticket::$_data[0]['result'][3]/jssupportticket::$_data[0]['result'][6]*100 ,2).'%';
						}else{
							echo __('NA','js-support-ticket');
						}
						?></div>
					<div class="stats-text" > <?php echo __('Normal','js-support-ticket')?> </div>
				</div>
				<div class="indi-stats fourth" >
					<img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/bad.png" />
					<div class="stats-percentage" ><?php
						if(jssupportticket::$_data[0]['result'][6] != 0){
							echo round(jssupportticket::$_data[0]['result'][2]/jssupportticket::$_data[0]['result'][6]*100 ,2).'%';
						}else{
							echo __('NA','js-support-ticket');
						}
						?></div>
					<div class="stats-text" > <?php echo __('Sad','js-support-ticket')?> </div>
				</div>
				<div class="indi-stats fifth" >
					<img alt="image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/angery.png" />
					<div class="stats-percentage" ><?php
						if(jssupportticket::$_data[0]['result'][6] != 0){
							echo round(jssupportticket::$_data[0]['result'][1]/jssupportticket::$_data[0]['result'][6]*100 ,2).'%';
						}else{
							echo __('NA','js-support-ticket');
						}
						?></div>
					<div class="stats-text" > <?php echo __('Angry','js-support-ticket')?> </div>
				</div>
			</div>
		</div>
	</div>
</div>

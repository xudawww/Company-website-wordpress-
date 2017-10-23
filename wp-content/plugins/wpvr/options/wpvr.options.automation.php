<!-- autoRunMode *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'automation',
	'id'    => 'autoRunMode',
	'label' => __( 'Enable AutoRun Mode', WPVR_LANG ),
	'desc'  => __( 'Disable this option to stop the plugin from working automatically using the CRON.', WPVR_LANG ) . '<br/>' .
	           '<div class="wpvr_switch_conditional_content">' . wpvr_render_automation_data() . '</div>',
), $wpvr_options['autoRunMode'] ); ?>


<!-- wakeUpHours *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'automation',
	'id'    => 'wakeUpHours',
	'label' => __( 'Automation Working Hours', WPVR_LANG ),
	'desc'  => __( 'Define the time range when the plugin should work.', WPVR_LANG ) . '<br/>' .
	           __( 'Turn this off if you want the plugin to work all the time.', WPVR_LANG ) . '<br/>' .
	           __( 'Timezone used :', WPVR_LANG ) . ' '. wpvr_get_timezone_name( wpvr_get_timezone() ).'<br/>' .
	           '<div class="wpvr_switch_conditional_content">' . wpvr_render_wake_up_hours() . '</div>',
), $wpvr_options['wakeUpHours'] ); ?>

<!-- treshold *** -->
<?php //wpvr_render_input_option( array(
// 	'tab'   => 'automation',
// 	'class'   => 'small',
// 	'id'    => 'sourceDeactivationThreshold',
// 	'label' => __( 'Source Deactivation Threshold', WPVR_LANG ),
// 	'desc'  => __( 'Define after how many empty executions, a source should be automatically deactivated.', WPVR_LANG ) . '<br/>' .
// 	           __( 'This is useful to avoid executing sources that no longer have any new video.', WPVR_LANG ) ,
// ), $wpvr_options['sourceDeactivationThreshold'] ); ?>


<!-- autoClean *** -->
<?php wpvr_render_switch_option( array(
		'tab'          => 'automation',
		'id'           => 'autoClean',
		'label'        => __( 'Duplicates Auto Cleaner', WPVR_LANG ),
		'desc'         => __( 'Enable this option to automatically merge any found duplicates on your site.', WPVR_LANG ) . '<br />' .
		                  __( 'You can define how often you want this duplicates auto cleaner to run.', WPVR_LANG ).'<br/>'.
		                  __( 'Timezone used :', WPVR_LANG ) . ' '. wpvr_get_timezone_name( wpvr_get_timezone() ).'<br/>',
		'function_out' => function () {
			global $wpvr_options;
			
			global $wpvr_hours, $wpvr_hours_us, $wpvr_days_names;
			$wpvr_hours_formatted = $wpvr_options['timeFormat'] == 'standard' ? $wpvr_hours : $wpvr_hours_us;
			
			?>
        <div class="wpvr_switch_conditional_content">
            

            <!--autoCleanScheduleTime-->
            <div class="wpvr_sub_option pull-right wpvr_autoClean_scheduleTime_wrap ">
                <label class="wpvr_conditional_label">
			        <?php echo __( 'Time', WPVR_LANG ); ?>
                </label>
		        <?php echo wpvr_render_select_option_only( array(
			        'id' => 'autoCleanScheduleTime',
			        'class' => 'wpvr_autoClean_scheduleTime wpvr_autoClean_fields',
			        'options' => $wpvr_hours_formatted,
		        ) , $wpvr_options['autoCleanScheduleTime']) ; ?>
            </div>

            <!--autoCleanScheduleDay-->
            <div class="wpvr_sub_option pull-right wpvr_autoClean_scheduleDay_wrap ">
                <label class="wpvr_conditional_label">
			        <?php echo __( 'Day', WPVR_LANG ); ?>
                </label>
		        <?php echo wpvr_render_select_option_only( array(
			        'id' => 'autoCleanScheduleDay',
			        'class' => 'wpvr_autoClean_scheduleDay wpvr_autoClean_fields',
			        'options' => $wpvr_days_names,
		        ) , $wpvr_options['autoCleanScheduleDay']) ; ?>
            </div>

            <div class="wpvr_sub_option pull-right wpvr_autoClean_schedule_wrap ">
                <label class="wpvr_conditional_label">
			        <?php echo __( 'Frequency', WPVR_LANG ); ?>
                </label>
		        <?php echo wpvr_render_select_option_only( array(
			        'id' => 'autoCleanSchedule',
			        'class' => 'wpvr_autoClean_schedule wpvr_autoClean_fields',
			        'options' => array(
				        'hourly' => __( 'Run Hourly', WPVR_LANG ),
				        'daily'  => __( 'Run Daily', WPVR_LANG ),
				        'weekly' => __( 'Run Weekly', WPVR_LANG ),
			        ),
		        ) , $wpvr_options['autoCleanSchedule']) ; ?>
            </div>
            
        </div>

        <div class="wpvr_clearfix"></div>
		<?php
		},
	), $wpvr_options['autoClean'] ); ?>


<!-- ecoMode *** -->
<?php //wpvr_render_switch_option( array(
// 	'tab'          => 'automation',
// 	'id'           => 'ecoMode',
// 	'label'        => __( 'Eco Mode', WPVR_LANG ),
// 	'desc'         => __( 'xxxx.', WPVR_LANG ) . '<br />' .
// 	                  __( 'xxx.', WPVR_LANG ) . '<br/>' .
// 	                  __( 'xxx.', WPVR_LANG ),
// 	'function_out' => function () {
// 		global $wpvr_options;
// 		?>
<!--        <div class="wpvr_switch_conditional_content">-->
<!--            <div class="wpvr_sub_option pull-right">-->
<!--                <label class="wpvr_conditional_label">-->
<!--					--><?php //echo __( 'Eco Mode Threshold', WPVR_LANG ); ?>
<!--                </label>-->
<!--                <input-->
<!--                        type="text"-->
<!--                        class="wpvr_options_input"-->
<!--                        name="ecoModeThreshold"-->
<!--                        style="margin-top: 7px;"-->
<!--                        value="--><?php //echo $wpvr_options['ecoModeThreshold']; ?><!--"-->
<!--                />-->
<!---->
<!--            </div>-->
<!--        </div>-->
<!---->
<!--        <div class="wpvr_clearfix"></div>-->
<!--		--><?php
// 	},
// ), $wpvr_options['ecoMode'] ); ?>

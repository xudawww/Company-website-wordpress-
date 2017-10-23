<?php

	global $wpvr_pages, $wpvr_setters;
	$wpvr_pages = true ;
	
	
	$setters = array(
		'left' => array(),
		'right' => array(),
	);
	$i = 1 ;
	foreach( (array) $wpvr_setters as $setter ){
		$setter['id'] = $i ;
		
		if( !isset( $setter['show_result'] ) ) $setter['show_result'] = 0;
		
		if($i%2 == 0) $setters['right'][] = $setter ;
		else $setters['left'][] = $setter ;
		$i++;
	}
	
	//new dBug( $setters );
?>

	<div id="dashboard-widgets-wrap">
		<div id="dashboard-widgets" class="metabox-holder">
			<?php //new dBug( $wpvr_setters ); ?>
			
			<div id="postbox-container-1" class="postbox-container">
				<div id="normal-sortables" class="meta-box-sortables ui-sortable">
					<?php foreach( (array) $setters['left'] as $setter) { ?>
						<div id="dashboard_right_now" class="postbox ">
							<h3 class="hndle"><span><?php echo $setter['title']; ?></span></h3>
							<div class="inside">
								<div class="main">
									<p><?php echo $setter['desc']; ?></p>	
									<br/><br/>
									<button 
										url="<?php echo WPVR_SETTERS_URL; ?>" 
										action="<?php echo $setter['action']; ?>" 
										id="<?php echo $setter['id']; ?>" 
										class="pull-right wpvr_button wpvr_large wpvr_setter_button"
										is_demo="<?php echo WPVR_IS_DEMO ? 1 : 0 ; ?>"
										show_result="<?php echo $setter['show_result']; ?>"
									>
										<i class="wpvr_button_icon fa fa-bolt"></i>
										<?php echo $setter['button']; ?>
									</button>
									<div class="wpvr_clearfix"></div>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
			
			<div id="postbox-container-2" class="postbox-container">
				<div id="normal-sortables" class="meta-box-sortables ui-sortable">
					<?php foreach( (array) $setters['right'] as $setter) { ?>
						<div id="dashboard_right_now" class="postbox ">
							<h3 class="hndle"><span><?php echo $setter['title']; ?></span></h3>
							<div class="inside">
								<div class="main">
									<p><?php echo $setter['desc']; ?></p>	
									<br/><br/>
									<button 
										url="<?php echo WPVR_SETTERS_URL; ?>" 
										action="<?php echo $setter['action']; ?>" 
										id="<?php echo $setter['id']; ?>" 
										class="pull-right wpvr_button wpvr_large wpvr_setter_button"
										is_demo="<?php echo WPVR_IS_DEMO ? 1 : 0 ; ?>"
										show_result="<?php echo $setter['show_result']; ?>"
									>
										<i class="wpvr_button_icon fa fa-bolt"></i>
										<?php echo $setter['button']; ?>
									</button>
									<div class="wpvr_clearfix"></div>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
			
			
		</div>
	</div>

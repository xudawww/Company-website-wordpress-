<?php

	/* RENDER HELPER FORM */
	$vs[ 'render_helper_form' ] = function ( $type , $append = FALSE , $counter_id = '' , $desc = '' ) use ( $vs ) {
		ob_start();
		//d( $vs );
		$service            = $vs[ 'id' ];
		$button_dest_id     = '';
		$button_label       = '';
		$button_placeholder = '';
		$item_type          = '';
		$button_url         = WPVR_ACTIONS_URL . '?wpvr_wpload&use_helper';
		$helper_id          = 'helper_' . $type;

		if( $type == 'user' ) {
			$button_dest_id     = 'wpvr_source_userId_yt';
			$button_label       = ' Get User ID';
			$button_placeholder = 'Username ...';
			$item_type          = 'User';
		} elseif( $type == 'channel' ) {
			$button_dest_id     = 'wpvr_source_channelIds_yt';
			$button_label       = ' Get Channel ID';
			$button_placeholder = 'Channel Name ...';
			$item_type          = 'Channel';
		} elseif( $type == 'searchByChannel' ) {
			$button_dest_id     = 'wpvr_source_searchContextChannel_yt';
			$button_label       = ' Get Channel ID';
			$button_placeholder = 'Channel Name ...';
			$item_type          = 'Channel';

		} elseif( $type == 'page' ) {
			$button_dest_id     = 'wpvr_source_pageId_yt';
			$button_label       = ' Get Page ID';
			$button_placeholder = 'Page Name ...';
			$item_type          = 'Page';

		}

		?>
		<div
			class = "wpvr_helper_wrap"
			service = "<?php echo $service; ?>"
			helper_url = "<?php echo $button_url; ?>"
			helper_dest_id = "<?php echo $button_dest_id; ?>"
			helper_type = "<?php echo $type; ?>"
			helper_type_label = "<?php echo $item_type; ?>"
			helper_append = "<?php echo $append ? 1 : 0; ?>"
			helper_counter_id = "<?php echo $counter_id; ?>"


		>
			<a
				class = "wpvr_helper_toggler"
				form_id = "<?php echo $helper_id; ?>"
				href = "#"
			><?php _e( 'Toggle Helper' , WPVR_LANG ); ?></a>

			<?php if( $desc !== FALSE ) { ?>
				<p class = "cmb_metabox_description">
					<?php if( $desc == '' ) { ?>
						<?php _e( 'Example' , WPVR_LANG ); ?> :
						JavaJazzFest Channel <span class = "wpvr_wanted_param">UCGW-Pf2Tzy4lnbVc1HW_m3A</span>
						<br/>
						<?php _e( 'List of comma-separated channel IDs' , WPVR_LANG ); ?>
					<?php } else { ?>
						<?php echo $desc; ?>
					<?php } ?>

				</p>
			<?php } ?>


			<div
				class = "wpvr_helper_form"
				id = ""<?php echo $helper_id; ?>"
			>
			<br/>
			<input
				class = "wpvr_helper_input pull-left"
				name = "wpvr_helper_value"
				id = ""
				type = "text"
				value = ""
				placeholder = "<?php echo $button_placeholder; ?>"
			/>
			<input
				class = ""
				name = "wpvr_helper_type"
				id = ""
				type = "hidden"
				value = "<?php echo $type; ?>"
			/>
			<button class = "wpvr_button wpvr_helper_button">
				<i class = "fa fa-search"></i>
				<?php echo $button_label; ?>
			</button>
		</div>
		</div>
		<?php


		$helper_echo = ob_get_contents();
		ob_get_clean();

		return $helper_echo;


	};




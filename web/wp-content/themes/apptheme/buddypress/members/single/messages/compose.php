<form action="<?php bp_messages_form_action('compose' ); ?>" method="post" id="send_message_form" onsubmit="proceed;" class="standard-form list" role="main" enctype="multipart/form-data">

	<?php do_action( 'bp_before_messages_compose_content' ); ?>

	<label for="send-to-input" class="item item-input item-stacked-label">

		<span class="input-label"><?php _e("Send To (Username or Friend's Name)", 'ap3-ion-theme' ); ?></span>

		<ul class="first acfb-holder">
			<li>
				<input type="text" name="send-to-input" class="send-to-input" id="send-to-input" />
				<?php bp_message_get_recipient_tabs(); ?>
			</li>
		</ul>

	</label>

	<?php if ( bp_current_user_can( 'bp_moderate' ) ) : ?>
		<label class="item">
		<input type="checkbox" id="send-notice" name="send-notice" value="1" /> <?php _e( "This is a notice to all users.", 'ap3-ion-theme' ); ?>
		</label>
	<?php endif; ?>

	<label for="subject" class="item item-input item-stacked-label">
				<input type="hidden" name="subject" id="subject" value=" 点击此处查看消息" />
	</label>

	<label for="content" class="item item-input item-stacked-label">
		<span class="input-label"><?php _e( 'Message', 'ap3-ion-theme' ); ?></span>
		<textarea name="content" id="message_content" rows="15" cols="40"><?php bp_messages_content_value(); ?></textarea>
	</label>

	<input type="hidden" name="send_to_usernames" id="send-to-usernames" value="<?php bp_message_get_recipient_usernames(); ?>" class="<?php bp_message_get_recipient_usernames(); ?>" />

	<?php do_action( 'bp_after_messages_compose_content' ); ?>

	<div class="submit padding">
		<input type="submit" class="button button-primary button-block" value="<?php esc_attr_e( "Send Message", 'ap3-ion-theme' ); ?>" name="send" id="send" />
	</div>

	<?php wp_nonce_field( 'messages_send_message' ); ?>
</form>

<script type="text/javascript">
	if( /iP(ad|hone|od)/.test(navigator.userAgent) ) {
		// current iOS keyboard bug doesn't like .focus()
	} else {
		jQuery("#send-to-input").focus();
	}
	
	window.onload = function(e){ 
        function proceed(){
	var s= document.getElementById("message_content").value;
	if(s ===null)
	{alert("请输入消息再发送！！！");
	 return false;
	}
	
	}

       
       
       
        }
	
	
	
		
	
	
	
	
</script>
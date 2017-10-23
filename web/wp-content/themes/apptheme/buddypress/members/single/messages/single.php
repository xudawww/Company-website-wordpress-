<div id="message-thread" role="main" class="list">

	<?php do_action( 'bp_before_message_thread_content' ); ?>

	<?php if ( bp_thread_has_messages() ) : ?>

		<div class="item">

			<h2 id="message-subject"><?php bp_the_thread_subject(); ?></h2>

			<p id="message-recipients">
				<span class="highlight">

					<?php if ( !bp_get_the_thread_recipients() ) : ?>

						<?php _e( 'You are alone in this conversation.', 'ap3-ion-theme' ); ?>

					<?php else : ?>

						<?php printf( __( 'Conversation between %s and you.', 'ap3-ion-theme' ), bp_get_the_thread_recipients() ); ?>

					<?php endif; ?>

				</span>

				<a class="confirm" href="<?php bp_the_thread_delete_link(); ?>" title="<?php esc_attr_e( "Delete Message", 'ap3-ion-theme' ); ?>"><?php _e( 'Delete', 'ap3-ion-theme' ); ?></a> &nbsp;
			</p>

		</div><!-- .item -->

		<?php do_action( 'bp_before_message_thread_list' ); ?>

		<?php while ( bp_thread_messages() ) : bp_thread_the_message(); ?>
			<?php bp_get_template_part( 'members/single/messages/message' ); ?>
		<?php endwhile; ?>

		<?php do_action( 'bp_after_message_thread_list' ); ?>

		<?php do_action( 'bp_before_message_thread_reply' ); ?>

		<form id="send-reply" action="<?php bp_messages_form_action(); ?>" method="post" class="standard-form list">

			<div class="message-box item">

				<div class="message--rply-metadata">

					<?php do_action( 'bp_before_message_meta' ); ?>

					<?php do_action( 'bp_after_message_meta' ); ?>

				</div><!-- .message-metadata -->

				<div class="message-content">

					<?php do_action( 'bp_before_message_reply_box' ); ?>

					<label class="item item-input">

					<textarea placeholder="<?php esc_attr_e( 'Reply...', 'ap3-ion-theme' ); ?>" name="content" id="message_content" rows="15" cols="40"></textarea>

					</label>

					<?php do_action( 'bp_after_message_reply_box' ); ?>

					<div class="submit">
						<input class="button button-primary button-block" type="submit" name="send" value="<?php esc_attr_e( 'Send Reply', 'ap3-ion-theme' ); ?>" id="send_reply_button"/>
					</div>

					<input type="hidden" id="thread_id" name="thread_id" value="<?php bp_the_thread_id(); ?>" />
					<input type="hidden" id="messages_order" name="messages_order" value="<?php bp_thread_messages_order(); ?>" />
					<?php wp_nonce_field( 'messages_send_message', 'send_message_nonce' ); ?>

				</div><!-- .message-content -->

			</div><!-- .message-box -->

		</form><!-- #send-reply -->

		<p style="clear:both">&nbsp;</p>
		<p style="clear:both">&nbsp;</p>

		<?php do_action( 'bp_after_message_thread_reply' ); ?>

	<?php endif; ?>

	<?php do_action( 'bp_after_message_thread_content' ); ?>

</div>

<?php
/**
 * AppPresser App Functionality
 *
 * @package Ion
 * @since   0.0.1
 */

/**
 * Theme hooks
 */

// Left panel top, used for search bar, shopping cart, and user profile pic
function appp_left_panel_before() {
	 do_action( 'appp_left_panel_before' );
}

function appp_login_modal_before() {
	 do_action( 'appp_login_modal_before' );
}

function appp_login_modal_after() {
	 do_action( 'appp_login_modal_after' );
}

class AppPresser_AP3_Functionality {

	public static $errorpath = '../php-error-log.php';

	/**
	 * AppPresser_AP3_Functionality hooks
	 * @since 1.0.6
	 */
	public function hooks() {
		return array(
			array( 'wp_footer', 'login_modal_template' ),
			array( 'wp_footer', 'comment_modal_template' ),
			array( 'wp_footer', 'appp_lost_password_template' )
		);
	}

	/**
	 * login modal html markup
	 * @since  0.0.1
	 */
	function login_modal_template() {
		?>
		<aside class="io-modal" id="loginModal" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="bar bar-header bar-white">
				<div class="title">Login</div>
				<i class="io-modal-close icon ion-close-round"></i>
			</div>
			<div class="io-modal-content has-header">

				<?php appp_login_modal_before();

					if ( !is_user_logged_in() ) {
						_e( $this->get_error_param(), 'ap3-ion-theme' );
						echo '<div id="error-message"></div>';
						echo '<h4 class="login-modal-title">' . __( 'Please Login', 'ap3-ion-theme' ) . '</h4>';

						wp_login_form();

					} else {
						_e( 'Welcome back!', 'ap3-ion-theme' );

						echo '<p><a class="button button-secondary" href="' . wp_logout_url( get_permalink() ) . '">Logout</a></p>';
					}

					appp_login_modal_after();

					if ( !is_user_logged_in() ) {
						echo '<div class="button-bar"><a href="#app-lost-password" class="button button-secondary password-reset-btn io-modal-open">' . __('Lost Password?', 'ap3-ion-theme') . '</a>';

						if( get_option( 'users_can_register' ) )
							echo '<a class="button button-secondary register-btn" href="' . wp_registration_url() . '">Register</a></div>';
					}
				?>
				<script type="text/javascript">
					jQuery('#user_login').attr('autocapitalize', 'off').attr('spellcheck','false').attr('autocomplete','off').attr('autocorrect','off');
				</script>
			</div>
		</aside>
		<?php
	}

	/**
	 * Modal's html markup
	 * @since  0.0.1
	 */
	function comment_modal_template() {
		?>
		<aside class="io-modal" id="commentModal" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="bar bar-header bar-white">
				<div class="title">Comment</div>
				<i class="io-modal-close icon ion-close-round"></i>
			</div>
			<div class="io-modal-content">

				<h4><?php _e( 'Leave a comment', 'ap3-ion-theme' ); ?></h4>

				<div id="comment-status"></div>

				<div class="list">

					<span class="ajax-comment-form-author"><label for="author" class="item item-input"><input id="author" name="author" type="text" size="30" aria-required="true" placeholder="<?php _e( '*Name', 'ap3-ion-theme' ); ?>"></label> </span>

					<span class="ajax-comment-form-email"><label for="email" class="item item-input"><input id="email" name="email" type="text" size="30" aria-describedby="email-notes" aria-required="true" placeholder="<?php _e( '*Email', 'ap3-ion-theme' ); ?>"></label> </span>

					<span class="ajax-comment-form-url"><label for="url"  class="item item-input"><input id="url" name="url" type="text" value="" size="30" placeholder="<?php _e( 'Website', 'ap3-ion-theme' ); ?>"></label></span>

					<span class="ajax-comment-form-comment"><label for="comment" class="item item-input"><textarea id="comment" name="comment" cols="45" rows="8" aria-describedby="form-allowed-tags" aria-required="true" placeholder="<?php _e( 'Comment', 'ap3-ion-theme' ); ?>"></textarea></label></span>

					<input type="hidden" id="ajax-comment-parent" value="0">

					<span id="ajax-comment-form-submit">
						<input name="submit" type="submit" id="submit" class="submit button button-primary button-block" value="<?php _e( 'Post Comment', 'ap3-ion-theme' ); ?>">
					</span>

				</div>
			</div>
		</aside>
		<?php
	}

	/*
	 * Modal template for lost password
	 */
	function appp_lost_password_template() {

		if( !is_user_logged_in() ) {
		?>
		<aside class="io-modal" id="app-lost-password" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="bar bar-header bar-white">
				<div class="title">Lost Password</div>
				<i class="io-modal-close icon ion-close-round"></i>
			</div>
			<div class="io-modal-content">
				<p><?php _e( 'Please enter your email and a password retrieval code will be sent.', 'ap3-ion-theme' ) ?></p>
				<p><input type="text" id="lost_email" name="email" value="" placeholder="<?php _e( 'Email', 'ap3-ion-theme' ); ?>"/></p>
				<button type="button" id="app-new-password" class="button button-primary"><?php _e( 'Request Code', 'ap3-ion-theme' )?></button>
				<?php wp_nonce_field( 'new_password','app_new_password' ); ?>
				<span class="reset-code-rsp"></span>

				<br/><br/>

				<h4><?php _e('New Password', 'ap3-ion-theme' )?></h4>

				<p><?php _e('Please enter your code and a new password.', 'ap3-ion-theme' ) ?></p>
				<p><input type="text" id="reset-code" name="reset-code" value="" placeholder="<?php _e( 'Code', 'ap3-ion-theme' ); ?>"/></p>
				<p><input type="password" id="app-pw" name="app-pw" value="" placeholder="<?php _e( 'New Password', 'ap3-ion-theme' ); ?>"/></p>
				<p><input type="password" id="app-pwr" name="app-pwr" value="" placeholder="<?php _e( 'Repeat Password', 'ap3-ion-theme' ); ?>"/></p>
				<button type="button" id="app-change-password" class="button button-primary"><?php _e( 'Change Password', 'ap3-ion-theme' ); ?></button>
				<span class="psw-msg"></span>

				</div>

		</aside>
		<?php
		}
	}

	public function get_error_param() {

		if ( isset( $_GET['errors'] ) && $_GET['errors'] == 'login_failed' )
			return __('Login Failed! Please try again.', 'ap3-ion-theme');

		return '';
	}

}
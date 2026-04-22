<?php
/**
 * Security Warning Message View
 *
 * Provides the view for the security warning message.
 *
 * @link       https://www.miniorange.com
 * @since      1.0.0
 *
 * @package    Miniorange_Oauth_20_Server
 * @subpackage Miniorange_Oauth_20_Server/admin/views
 */

/**
 * Security Warning Message View
 *
 * @return void
 */
function mo_oauth_server_security_warning_message_view() {
	// If on plugin page don't show global notice,
	// Also don't show when mo_oauth_server_hide_security_warning_admin is set to 1 in wp_options.
	$jwks_uri_hit_count             = get_option( 'mo_oauth_server_jwks_uri_hit_count' );
	$hide_security_notice_permanent = get_option( 'mo_oauth_server_hide_security_warning_admin' );
	$is_security_warning_mail_sent  = get_option( 'mo_oauth_server_is_security_warning_mail_sent' );

	if ( current_user_can( 'manage_options' ) && $jwks_uri_hit_count >= 10 && ! boolval( $hide_security_notice_permanent ) ) { // phpcs:ignore WordPress.Security.NonceVerification -- This is only to get the page to display the security warning
		if ( false === $is_security_warning_mail_sent ) {
			mo_oauth_server_jwks_security_email();
		}
		?>
		<div class="notice notice-warning mo_security_banner" id="mo_security_banner">
			<form action="#" method="POST">
				<?php wp_nonce_field( 'mo_oauth_server_security_warning_form', 'mo_oauth_server_security_warning_form_field' ); ?>
				<div class="mo_security_banner_header">
					<div>
						<img class="mo_logo" src="<?php echo esc_attr( MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_URL ); ?>assets/logo/mo_logo.png" height="48" width="48">
					</div>
					<div class="mo_security_banner_header_text">
						[ <span style="color:red;">ATTENTION REQUIRED</span> ] miniOrange WordPress OAuth Server Security Risk!
					</div>
					<input type="submit" name="mo_admin_security_dismiss" id="mo_admin_security_dismiss" onclick="mo_close_security_banner" class="button button-primary button-large mo_dismiss_security_banner" value="X" />
				</div>
			</form>

			<p style="font-size:medium;">You are at a Security Risk for the WordPress OAuth Server Plugin. 
				It is because you are using the free version of the plugin for JWT Signing, where new keys are not generated for each configuration and are common for all users. <br>
				You can 
				<a href="<?php echo esc_url( Miniorange_Oauth_20_Server_Oauth_Constants::PRICING_PLAN_URL ); ?>" target="_blank" class="button">
					<strong><span style="margin-top:4%" class="dashicons dashicons-external"></span> Upgrade Now</strong>
				</a>
				to Premium for RSA support with dynamic keys to avoid this risk.<br><br>
				<i><b>Note:</b> The free plugin will continue to function but will remain vulnerable to this risk.</i>
			</p>
		</div>

		<?php
	}
}

/**
 * Prepare security Warning email.
 *
 * @return void
 */
function mo_oauth_server_jwks_security_email() {
	$email = get_option( 'admin_email' );

	$message = 'Dear Customer, <br><br>
	You are at a Security Risk for the WordPress OAuth Server Plugin. It is because you are using the free version of the plugin for JWT Signing, where new keys are not generated for each configuration and are common for all users.<br><br>
	You can			
	<a href="' . esc_url( Miniorange_Oauth_20_Server_Oauth_Constants::PRICING_PLAN_URL ) . '" target="_blank" id="upgrade_now">
		<strong>Upgrade Now</strong>
	</a>
	for RSA support with dynamic keys to avoid this risk.<br><br>
	<i><b>Note:</b> The free plugin will continue to function but will remain vulnerable to this risk.</i>
	<br><br>
	For more information, you can contact us at wpidpsupport@xecurify.com. <br><br>
	Thank you,<br>
	miniOrange Team';

	$customer = new Mo_Oauth_Server_Customer();
	$customer->mo_oauth_send_jwks_alert( $email, $message, 'WP OAuth Server Alert | You are at a Security Risk - ' . $email );
	update_option( 'mo_oauth_server_is_security_warning_mail_sent', 1, false );
}

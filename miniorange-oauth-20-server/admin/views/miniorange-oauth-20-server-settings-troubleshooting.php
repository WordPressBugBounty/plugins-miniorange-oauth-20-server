<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Provide a troubleshooting view for the plugin.
 *
 * This file is used to markup the troubleshooting aspects of the plugin.
 *
 * @link       https://www.miniorange.com
 * @since      1.0.0
 *
 * @package    Miniorange_Oauth_20_Server
 * @subpackage Miniorange_Oauth_20_Server/admin/views
 */

?>
<div class="column has-background-white mr-5 px-5">
	<div class="mb-4">
		<h2 class="is-size-5 has-text-weight-semibold miniorange-oauth-20-server-card-title">Troubleshooting</h2>
	</div>
	<h3 class="has-text-weight-semibold mt-4 is-blue">Debug Logs</h3>
	<p class="mt-4 is-size-6">Enable the debug logs to troubleshoot the issue.</p>

	<form id="mo_oauth_server_log_button_form" method="POST">
		<?php wp_nonce_field( 'mo_oauth_server_debug_logs_form', 'mo_oauth_server_debug_logs_form_nonce' ); ?>
		<div class="field">
			<input id="mo_oauth_server_log_button_toggle" type="checkbox" name="mo_oauth_server_log_button_toggle" <?php echo esc_attr( $debug_log_button ); ?> class="switch is-rounded is-success">
			<label for="mo_oauth_server_log_button_toggle">Debug Logs</label>
		</div>
		<?php if ( 'checked' === $debug_log_button ) : ?>
		<div class="field is-grouped is-grouped-centered">
			<p class="control">
				<button type="submit" name="mo_oauth_server_download_logs" value="true" class="button is-blue">Download Logs</button>
			</p>
			<p class="control">
				<button type="submit" name="mo_oauth_server_delete_logs" value="true" class="button is-blue is-outlined">Delete Old Logs</button>
			</p>
		</div>
		<?php endif; ?>
	</form>

	<?php if ( $legacy_log_file_exists ) : ?>
	<div class="notification is-warning is-light mt-4">
		<p class="has-text-weight-semibold is-size-6">
			<i class="fa-solid fa-triangle-exclamation mr-1"></i> Old debug log file detected: <code><?php echo esc_html( $legacy_log_file_name ); ?></code>
		</p>
		<p class="mt-2 is-size-6">
			This fixed-name file from an older version could be requested directly over the web, exposing OAuth tokens and user data. We recommend deleting it.
		</p>
		<form id="mo_oauth_server_legacy_log_delete_form" method="POST" class="mt-3">
			<?php wp_nonce_field( 'mo_oauth_server_legacy_log_delete_form', 'mo_oauth_server_legacy_log_delete_form_nonce' ); ?>
			<div class="field is-grouped">
				<p class="control">
					<button type="submit" name="mo_oauth_server_delete_legacy_log" value="true" class="button is-danger is-outlined">Delete Log File</button>
				</p>
			</div>
		</form>
	</div>
	<?php endif; ?>

</div>
<!-- This div close the parent container of main template. -->
</div>

<script>
	// submit this form on toggling the mo switch button for debug log
	const debug_log_button = document.querySelector('#mo_oauth_server_log_button_toggle');
	debug_log_button.addEventListener('click', () => {
		const debug_log_form = document.getElementById('mo_oauth_server_log_button_form');
		debug_log_form.submit();
	});
</script>

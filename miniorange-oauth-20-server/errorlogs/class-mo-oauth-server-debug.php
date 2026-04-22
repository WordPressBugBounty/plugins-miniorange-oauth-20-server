<?php
/**
 * Summary of class-mo-oauth-server-debug
 *
 * @package Debug
 */

/**
 * Summary of MO_OAuth_Server_Debug
 */
class MO_OAuth_Server_Debug {

	/**
	 * Summary of error_log
	 *
	 * Handles the debug logs.
	 *
	 * @param mixed $message error message.
	 * @return void
	 */
	public static function error_log( $message ) {

		if ( ! get_option( 'mo_oauth_server_is_debug_enabled' ) ) {
			return;
		}
		require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/constants/class-miniorange-oauth-20-server-oauth-constants.php';
		$upload_dir = wp_upload_dir();
		$log_dir    = trailingslashit( $upload_dir['basedir'] ) . Miniorange_Oauth_20_Server_Oauth_Constants::ERROR_LOGS_DIR;

		if ( ! file_exists( $log_dir ) ) {
			wp_mkdir_p( $log_dir );
		}
		require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/class-mo-oauth-server-file-protection.php';
		MO_OAuth_Server_File_Protection::mo_oauth_server_create_protection_files( $log_dir );

		$file_location = $log_dir . 'wp_oauth_server_errors.log';
		$time          = gmdate( 'd-M-Y H:i:s' );
		$message       = '[ ' . $time . ' UTC]: ' . print_r( $message, true ) . PHP_EOL; //phpcs:ignore -- This is in debug logs.

		error_log( $message, 3, $file_location ); //phpcs:ignore -- This is in debug logs.
	}
}

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
		require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/class-mo-oauth-server-log-file.php';
		$log_dir = MO_OAuth_Server_Log_File::get_log_dir();

		if ( ! file_exists( $log_dir ) ) {
			wp_mkdir_p( $log_dir );
		}
		require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/class-mo-oauth-server-file-protection.php';
		MO_OAuth_Server_File_Protection::mo_oauth_server_create_protection_files( $log_dir );

		MO_OAuth_Server_Log_File::create_log_file_if_missing();
		$file_location = MO_OAuth_Server_Log_File::get_log_file_path();

		$time    = gmdate( 'd-M-Y H:i:s' );
		$message = '[ ' . $time . ' UTC]: ' . print_r( $message, true ) . PHP_EOL; //phpcs:ignore -- This is in debug logs.

		error_log( $message, 3, $file_location ); //phpcs:ignore -- This is in debug logs.
	}
}

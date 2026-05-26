<?php
/**
 * Enable OAuth server debug logging (uploads dir checks and options).
 *
 * @package Miniorange_Oauth_20_Server
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shared logic to turn on debug logs; safe for admin forms and Abilities API callbacks.
 */
class Miniorange_Oauth_20_Server_Enable_Debug_Logs {

	/**
	 * Create the log directory if needed, verify write access, then enable debug logging.
	 *
	 * @return array{success:bool,message:string}
	 */
	public static function mo_oauth_server_try_enable_debug_logs() {
		require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/constants/class-miniorange-oauth-20-server-oauth-constants.php';

		$upload_dir = wp_upload_dir();
		$log_dir    = trailingslashit( $upload_dir['basedir'] ) . Miniorange_Oauth_20_Server_Oauth_Constants::ERROR_LOGS_DIR;

		if ( ! file_exists( $log_dir ) ) {
			$created = wp_mkdir_p( $log_dir );
			if ( ! $created ) {
				update_option( 'mo_oauth_server_is_debug_enabled', 0, false );
				return array(
					'success' => false,
					'message' => 'Debug logs have been automatically disabled. The plugin does not have the necessary permissions to create a folder in the uploads directory to store error logs.',
				);
			}
		}

		require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/class-mo-oauth-server-file-protection.php';
		MO_OAuth_Server_File_Protection::mo_oauth_server_create_protection_files( $log_dir );

		global $wp_filesystem;
		if ( empty( $wp_filesystem ) ) {
			require_once ABSPATH . '/wp-admin/includes/file.php';
			WP_Filesystem();
		}

		if ( ! $wp_filesystem->is_writable( $log_dir ) ) {
			update_option( 'mo_oauth_server_is_debug_enabled', 0, false );
			return array(
				'success' => false,
				'message' => 'Debug logs have been automatically disabled. The plugin does not have write permission for the error-logs directory.',
			);
		}

		$log_file = $log_dir . 'wp_oauth_server_errors.log';
		if ( $wp_filesystem->exists( $log_file ) && ! $wp_filesystem->is_writable( $log_file ) ) {
			update_option( 'mo_oauth_server_is_debug_enabled', 0, false );
			return array(
				'success' => false,
				'message' => 'Debug logs have been automatically disabled. The plugin does not have write permission for the error log file.',
			);
		}

		update_option( 'mo_oauth_server_is_debug_enabled', 1, false );

		return array(
			'success' => true,
			'message' => 'Debug logs enabled successfully.',
		);
	}
}

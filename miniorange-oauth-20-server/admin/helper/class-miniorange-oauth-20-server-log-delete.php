<?php
/**
 * Class Miniorange_Oauth_20_Server_Log_Delete
 *
 * @package Miniorange_Oauth_20_Server
 */

/**
 * Class Miniorange_Oauth_20_Server_Log_Delete
 *
 * This class handles the deletion of log files.
 */
class Miniorange_Oauth_20_Server_Log_Delete {

	/**
	 * Utils contains some commonly used functions
	 *
	 * @var [object]
	 */
	private $utils;

	/**
	 * Constructor for Miniorange_Oauth_20_Server_Log_Delete.
	 */
	public function __construct() {
		require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/class-miniorange-oauth-20-server-utils.php';
		require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/constants/class-miniorange-oauth-20-server-oauth-constants.php';
		$this->utils = new Miniorange_Oauth_20_Server_Utils();
	}

	/**
	 * This function handles the deletion of log files.
	 */
	public function handle_log_delete() {

		// delete old error log files.
		$this->mo_oauth_delete_debug_log_file();

		// show success message.
		update_option( 'message', 'Previous log cleared successfully', false );
		$this->utils->mo_oauth_show_success_message();
	}

	/**
	 * Summary of mo_oauth_delete_debug_log_file
	 *
	 * Deletes or empties the debug log file.
	 *
	 * @return void
	 */
	public function mo_oauth_delete_debug_log_file() {

		global $wp_filesystem;

		if ( ! $wp_filesystem ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';	
			WP_Filesystem();
		}

		$upload_dir = wp_upload_dir();
		$log_dir    = trailingslashit( $upload_dir['basedir'] ) . Miniorange_Oauth_20_Server_Oauth_Constants::ERROR_LOGS_DIR;

		if ( ! file_exists( $log_dir ) ) {
			wp_mkdir_p( $log_dir );
		}

		require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/class-mo-oauth-server-file-protection.php';
		MO_OAuth_Server_File_Protection::mo_oauth_server_create_protection_files( $log_dir );

		$file_name = $log_dir . 'wp_oauth_server_errors.log';

		// Overwrite the file with the fixed message.
		$wp_filesystem->put_contents( $file_name, 'This is miniOrange Oauth server plugin debug log' . PHP_EOL . '------------------------------------------------' . PHP_EOL );
	}
}

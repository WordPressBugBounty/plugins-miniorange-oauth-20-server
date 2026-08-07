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

		// clear the current log file.
		$this->mo_oauth_clear_debug_log_file();

		// show success message.
		update_option( 'mo_oauth_server_message', 'Previous log cleared successfully', false );
		$this->utils->mo_oauth_show_success_message();
	}

	/**
	 * Summary of mo_oauth_clear_debug_log_file
	 *
	 * Resets the current debug log file to the standard banner-only content
	 * (creating it first if it does not exist yet).
	 *
	 * @return void
	 */
	public function mo_oauth_clear_debug_log_file() {

		global $wp_filesystem;

		if ( ! $wp_filesystem ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';	
			WP_Filesystem();
		}

		require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/class-mo-oauth-server-log-file.php';

		$log_dir = MO_OAuth_Server_Log_File::get_log_dir();

		if ( ! file_exists( $log_dir ) ) {
			wp_mkdir_p( $log_dir );
		}

		require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/class-mo-oauth-server-file-protection.php';
		MO_OAuth_Server_File_Protection::mo_oauth_server_create_protection_files( $log_dir );

		$file_name = MO_OAuth_Server_Log_File::get_log_file_path();

		// Overwrite the file with the fixed message.
		$wp_filesystem->put_contents( $file_name, 'This is miniOrange Oauth server plugin debug log' . PHP_EOL . '------------------------------------------------' . PHP_EOL );
	}

	/**
	 * Summary of handle_legacy_log_delete
	 *
	 * Deletes the legacy, fixed-name log file left behind by older versions
	 * of the plugin, if present, and shows a success or error message
	 * depending on whether the delete actually succeeded.
	 *
	 * @return void
	 */
	public function handle_legacy_log_delete() {

		global $wp_filesystem;

		if ( ! $wp_filesystem ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
			WP_Filesystem();
		}

		require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/class-mo-oauth-server-log-file.php';
		$legacy_log_file = MO_OAuth_Server_Log_File::get_legacy_log_file_path();

		if ( ! $wp_filesystem->exists( $legacy_log_file ) ) {
			return;
		}

		if ( $wp_filesystem->delete( $legacy_log_file ) ) {
			update_option( 'mo_oauth_server_message', 'Old debug log file deleted successfully', false );
			$this->utils->mo_oauth_show_success_message();
		} else {
			update_option( 'mo_oauth_server_message', 'Failed to delete the old debug log file. Please check file permissions.', false );
			$this->utils->mo_oauth_show_error_message();
		}
	}
}

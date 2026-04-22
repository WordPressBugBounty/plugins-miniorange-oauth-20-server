<?php
/**
 * Class Miniorange_Oauth_20_Server_Log_Download
 *
 * @package Miniorange_Oauth_20_Server
 */

/**
 * Class Miniorange_Oauth_20_Server_Log_Download
 *
 * This class handles the download of log file.
 */
class Miniorange_Oauth_20_Server_Log_Download {

	/**
	 * Utils contains some commonly used functions
	 *
	 * @var [object]
	 */
	private $utils;

	/**
	 * Constructor for Miniorange_Oauth_20_Server_Log_Download.
	 */
	public function __construct() {
		require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/class-miniorange-oauth-20-server-utils.php';
		$this->utils = new Miniorange_Oauth_20_Server_Utils();
	}

	/**
	 * Function to download the log file.
	 */
	public function handle_log_download() {

		global $wp_filesystem;

		if ( ! $wp_filesystem ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';	
			WP_Filesystem();
		}

		if ( ! current_user_can( 'manage_options' ) ) {
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

		$file_name = $log_dir . 'wp_oauth_server_errors.log';

		if ( ! file_exists( $file_name ) ) {
			update_option( 'message', 'Log file does not exist.' );
			$this->utils->mo_oauth_show_error_message();
		}

		$download_file_name = 'mo-server-log-' . gmdate( 'd-m-y-H-i-s' ) . '.log';
		$file_content       = $wp_filesystem->get_contents( $file_name );
		header( 'Content-Type: application/octet-stream' );
		header( 'Content-Transfer-Encoding: Binary' );
		header( 'Content-disposition: attachment; filename="' . $download_file_name . '"' );
		echo $file_content; //phpcs:ignore -- This is the debug log content.
		exit();
	}
}

<?php
/**
 * Log File Naming Utility Class
 *
 * @package MiniOrange_OAuth_20_Server
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Resolves the current, randomized debug log file name and detects the
 * legacy, fixed-name log file used by older versions of the plugin.
 *
 * Older versions always wrote to a fixed, predictable file name, which made
 * the log directly requestable over HTTP by anyone who knew (or guessed) the
 * path. The file name is now randomized per site so it cannot be guessed.
 */
class MO_OAuth_Server_Log_File {

	/**
	 * Gets the log directory path inside the uploads folder.
	 *
	 * @return string
	 */
	public static function get_log_dir() {
		require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/constants/class-miniorange-oauth-20-server-oauth-constants.php';
		$upload_dir = wp_upload_dir();
		return trailingslashit( $upload_dir['basedir'] ) . Miniorange_Oauth_20_Server_Oauth_Constants::ERROR_LOGS_DIR;
	}

	/**
	 * Gets the randomized log file name for this site, generating and
	 * persisting one on first use.
	 *
	 * @return string
	 */
	public static function get_log_file_name() {
		$file_name = get_option( 'mo_oauth_server_debug_log_filename' );
		if ( empty( $file_name ) ) {
			$file_name = 'moos_' . wp_generate_uuid4() . '.log';
			update_option( 'mo_oauth_server_debug_log_filename', $file_name, false );
		}
		return $file_name;
	}

	/**
	 * Gets the full path to the current, randomized log file.
	 *
	 * @return string
	 */
	public static function get_log_file_path() {
		return self::get_log_dir() . self::get_log_file_name();
	}

	/**
	 * Gets the full path to the legacy, fixed-name log file.
	 *
	 * @return string
	 */
	public static function get_legacy_log_file_path() {
		return self::get_log_dir() . 'wp_oauth_server_errors.log';
	}

	/**
	 * Checks whether the legacy, fixed-name log file still exists on disk.
	 *
	 * @return bool
	 */
	public static function legacy_log_file_exists() {
		return file_exists( self::get_legacy_log_file_path() );
	}

	/**
	 * Creates the current log file with the placeholder if missing; bails out silently if WP_Filesystem is unavailable, since this runs on
     * the public OAuth path and must never fatal.
	 * @return void
	 */
	public static function create_log_file_if_missing() {
		$file_path = self::get_log_file_path();

		if ( file_exists( $file_path ) ) {
			return;
		}

		global $wp_filesystem;
		if ( empty( $wp_filesystem ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
			WP_Filesystem();
		}

		if ( empty( $wp_filesystem ) ) {
			return;
		}

		$wp_filesystem->put_contents( $file_path, 'This is miniOrange Oauth server plugin debug log' . PHP_EOL . '------------------------------------------------' . PHP_EOL );
	}
}

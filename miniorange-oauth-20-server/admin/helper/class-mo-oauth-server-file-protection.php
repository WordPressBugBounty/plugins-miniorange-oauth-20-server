<?php
/**
 * File Protection Utility Class
 *
 * @package MiniOrange_OAuth_20_Server
 */

/**
 * Handles file protection operations for sensitive directories.
 */
class MO_OAuth_Server_File_Protection {

	/**
	 * Creates protection files to prevent public access to a directory.
	 *
	 * @param string $directory_path Directory path to protect.
	 * @return void
	 */
	public static function mo_oauth_server_create_protection_files( $directory_path ) {
		self::mo_oauth_server_create_index_php_file( $directory_path );
	}

	/**
	 * Creates index.php file for directory protection.
	 *
	 * @param string $directory_path Directory path to protect.
	 * @return void
	 */
	private static function mo_oauth_server_create_index_php_file( $directory_path ) {

		$directory_path = trailingslashit( $directory_path );
		$index_file = $directory_path . 'index.php';

		if ( file_exists( $index_file ) ) {
			return;
		}

		$template_file = MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'errorlogs/index.php';
		if ( ! file_exists( $template_file ) ) {
			return;
		}

		$protection_content = file_get_contents( $template_file ); //phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_file_get_contents -- local plugin guard file, WP_Filesystem is unnecessary overhead on a front-end request path.

		file_put_contents( $index_file, $protection_content ); //phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_file_put_contents -- see above.
	}
}

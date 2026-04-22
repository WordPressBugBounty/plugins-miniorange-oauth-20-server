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

		global $wp_filesystem;
		if ( empty( $wp_filesystem ) ) {
			require_once ABSPATH . '/wp-admin/includes/file.php';
			WP_Filesystem();
		}

		$directory_path = trailingslashit( $directory_path );
		$index_file = $directory_path . 'index.php';

		$template_file = MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'errorlogs/index.php';
		$protection_content = $wp_filesystem->get_contents( $template_file );

		$wp_filesystem->put_contents( $index_file, $protection_content );
	}
}

<?php
/**
 * Summary of mo-oauth-db-handler
 *
 * Handles database operations.
 *
 * @package Database
 */

/**
 * Summary of Mo_Oauth_Server_Db
 */
class Mo_Oauth_Server_Db {

	/**
	 * Summary of mo_plugin_activate
	 *
	 * Creates required tables on plugin activation.
	 *
	 * @return void
	 */
	public function mo_plugin_activate() {
		global $wpdb;

		$esc_clients_table         = esc_sql( $wpdb->base_prefix . 'moos_oauth_clients' );
		$esc_access_tokens_table   = esc_sql( $wpdb->base_prefix . 'moos_oauth_access_tokens' );
		$esc_auth_codes_table      = esc_sql( $wpdb->base_prefix . 'moos_oauth_authorization_codes' );
		$esc_refresh_tokens_table  = esc_sql( $wpdb->base_prefix . 'moos_oauth_refresh_tokens' );
		$esc_scopes_table          = esc_sql( $wpdb->base_prefix . 'moos_oauth_scopes' );
		$esc_users_table           = esc_sql( $wpdb->base_prefix . 'moos_oauth_users' );
		$esc_public_keys_table     = esc_sql( $wpdb->base_prefix . 'moos_oauth_public_keys' );
		$esc_authorized_apps_table = esc_sql( $wpdb->base_prefix . 'moos_oauth_authorized_apps' );
		//phpcs:disable WordPress.DB.PreparedSQL.InterpolatedNotPrepared,WordPress.DB.DirectDatabaseQuery.SchemaChange,WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
		$wpdb->query( "CREATE TABLE IF NOT EXISTS `$esc_clients_table` (client_name VARCHAR(255), client_id VARCHAR(255), client_secret VARCHAR(255), redirect_uri VARCHAR(255), active_oauth_server_id INT);" );
		$wpdb->query( "CREATE TABLE IF NOT EXISTS `$esc_access_tokens_table` (access_token VARCHAR(255), client_id VARCHAR(255), user_id INT, expires TIMESTAMP, scope VARCHAR(255));" );
		$wpdb->query( "CREATE TABLE IF NOT EXISTS `$esc_auth_codes_table` (authorization_code VARCHAR(255), client_id VARCHAR(255), user_id INT, redirect_uri VARCHAR(255), expires TIMESTAMP, scope VARCHAR(255), id_token VARCHAR(255));" );
		$wpdb->query( "CREATE TABLE IF NOT EXISTS `$esc_refresh_tokens_table` (refresh_token VARCHAR(255), client_id VARCHAR(255), user_id INT, expires TIMESTAMP, scope VARCHAR(255));" );
		$wpdb->query( "CREATE TABLE IF NOT EXISTS `$esc_scopes_table` (scope varchar(100), is_default BOOLEAN, UNIQUE (scope));" );
		$wpdb->query( "CREATE TABLE IF NOT EXISTS `$esc_users_table` (username VARCHAR(100) NOT NULL, password VARCHAR(2000), first_name VARCHAR(255), last_name VARCHAR(255), CONSTRAINT username_pk PRIMARY KEY (username));" );
		$wpdb->query( "CREATE TABLE IF NOT EXISTS `$esc_public_keys_table` (client_id VARCHAR(80), public_key VARCHAR(8000), private_key VARCHAR(8000), encryption_algorithm VARCHAR(80) DEFAULT 'RS256');" );
		$wpdb->query( "CREATE TABLE IF NOT EXISTS `$esc_authorized_apps_table` (client_id TEXT, user_id INT);" );
		$wpdb->query( $wpdb->prepare( "INSERT IGNORE INTO `$esc_scopes_table` (scope, is_default) VALUES (%s, %d), (%s, %d)", 'email', 1, 'profile', 0 ) );

		// check if the table moos_oauth_clients is already exist.
		$table_name = $wpdb->esc_like( $wpdb->base_prefix . 'moos_oauth_clients' );
		if ( $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $table_name ) ) === $table_name ) {
			$row = $wpdb->get_results( $wpdb->prepare( "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema = %s AND table_name = %s AND column_name ='active_oauth_server_id'", array( DB_NAME, $table_name ) ), ARRAY_A );
			if ( empty( $row ) ) {
				$wpdb->query( $wpdb->prepare( 'ALTER TABLE ' . $wpdb->base_prefix . 'moos_oauth_clients ADD active_oauth_server_id INT DEFAULT %d', array( get_current_blog_id() ) ) );
			}
		}
		//phpcs:enable
	}

	/**
	 * Summary of add_client
	 *
	 * Adds client details in the database on save event.
	 *
	 * @param string $client_name the name of the client.
	 * @param string $client_secret the client secret.
	 * @param string $redirect_url the redirect URL.
	 * @param int    $active_oauth_server_id the active ID.
	 * @param string $jwt_signing_algorithm the JWT signing algorithm.
	 * @param string $private_key the private key for the JWT signing algorithm.
	 * @param string $public_key the public key for the JWT signing algorithm.
	 * @return bool True when both inserts succeed.
	 */
	public function add_client( $client_name, $client_secret, $redirect_url, $active_oauth_server_id, $jwt_signing_algorithm, $private_key, $public_key ) {
		global $wpdb;
		require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/class-miniorange-oauth-20-server-utils.php';
		$mo_utils  = new Miniorange_Oauth_20_Server_Utils();
		$client_id = $mo_utils->moos_generate_random_string( 32 );
		//phpcs:ignore WordPress.DB.DirectDatabaseQuery.SchemaChange,WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching	
		$insert_client = $wpdb->query( $wpdb->prepare( 'INSERT INTO ' . $wpdb->base_prefix . 'moos_oauth_clients (client_name, client_id, client_secret, redirect_uri,active_oauth_server_id ) VALUES (%s, %s, %s, %s, %d )', $client_name, $client_id, $client_secret, $redirect_url, $active_oauth_server_id ) );

		if ( false === $insert_client ) {
			return false;
		}

		if ( 'RS256' === $jwt_signing_algorithm ) {
			//phpcs:ignore WordPress.DB.DirectDatabaseQuery.SchemaChange,WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
			$insert_keys = $wpdb->query( $wpdb->prepare( 'INSERT INTO ' . $wpdb->base_prefix . "moos_oauth_public_keys (client_id, public_key, private_key, encryption_algorithm) VALUES (%s, %s, %s, 'RS256')", $client_id, $public_key, $private_key ) );
		} else {
			// Storing client secret as private key in public keys table for HS algorithm.
			//phpcs:ignore WordPress.DB.DirectDatabaseQuery.SchemaChange,WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
			$insert_keys = $wpdb->query( $wpdb->prepare( 'INSERT INTO ' . $wpdb->base_prefix . "moos_oauth_public_keys (client_id, public_key, private_key, encryption_algorithm) VALUES ( %s, '', %s, 'HS256')", $client_id, $client_secret ) );
		}

		return false !== $insert_keys;
	}

	/**
	 * Summary of update_client
	 *
	 * Updates client details in the database on update event.
	 *
	 * @param string $client_name the name of the client.
	 * @param string $redirect_uri the redirect URI.
	 * @return void
	 */
	public function update_client( $client_name, $redirect_uri ) {
		global $wpdb;
		 //phpcs:ignore WordPress.DB.DirectDatabaseQuery.SchemaChange,WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
		$wpdb->query( $wpdb->prepare( 'UPDATE ' . $wpdb->base_prefix . 'moos_oauth_clients SET redirect_uri = %s WHERE client_name = %s and active_oauth_server_id= %d', $redirect_uri, $client_name, get_current_blog_id() ) );
	}

	/**
	 * Summary of get_clients
	 *
	 * Gets client details from the database.
	 *
	 * @return mixed
	 */
	public function get_clients() {
		global $wpdb;
		 //phpcs:ignore WordPress.DB.DirectDatabaseQuery.SchemaChange,WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
		$myrows = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->base_prefix . 'moos_oauth_clients where active_oauth_server_id= %d', array( get_current_blog_id() ) ) );
		return $myrows;
	}

	/**
	 * Summary of delete_client
	 *
	 * Deletes client details in the database on delete event.
	 *
	 * @param string $client_name the name of the client.
	 * @param string $client_id the client ID.
	 * @return int|false Number of client rows deleted (typically 0 or 1), or false if the clients DELETE query failed.
	 */
	public function delete_client( $client_name, $client_id ) {
		global $wpdb;
		// Deleting public and private keys for JWT support.
		 //phpcs:ignore WordPress.DB.DirectDatabaseQuery.SchemaChange,WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
		$wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $wpdb->base_prefix . 'moos_oauth_public_keys WHERE client_id = %s', array( $client_id ) ) );
		 //phpcs:ignore WordPress.DB.DirectDatabaseQuery.SchemaChange,WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
		$del_clients = $wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $wpdb->base_prefix . 'moos_oauth_clients WHERE client_name = %s and active_oauth_server_id= %d', $client_name, get_current_blog_id() ) );

		if ( false === $del_clients ) {
			return false;
		}

		$rows_deleted = (int) $wpdb->rows_affected;

		delete_option( 'mo_oauth_server_client' );
		delete_option( 'mo_oauth_server_enable_jwt_support_for_' . $client_name );
		delete_option( 'mo_oauth_server_jwt_signing_algo_for_' . $client_name );

		return $rows_deleted;
	}
}

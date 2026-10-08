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
	 * DB error from the last failed migration, captured before later queries clear $wpdb->last_error.
	 *
	 * @var string
	 */
	private $migration_error = '';

	/**
	 * Summary of mo_oauth_server_create_tables
	 *
	 * Creates the plugin tables if they do not exist.
	 *
	 * @return void
	 */
	public function mo_oauth_server_create_tables() {
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
		$wpdb->query( "CREATE TABLE IF NOT EXISTS `$esc_auth_codes_table` (authorization_code VARCHAR(255), client_id VARCHAR(255), user_id INT, redirect_uri VARCHAR(255), expires TIMESTAMP, scope VARCHAR(255), id_token TEXT);" );
		$wpdb->query( "CREATE TABLE IF NOT EXISTS `$esc_refresh_tokens_table` (refresh_token VARCHAR(255), client_id VARCHAR(255), user_id INT, expires TIMESTAMP, scope VARCHAR(255));" );
		$wpdb->query( "CREATE TABLE IF NOT EXISTS `$esc_scopes_table` (scope varchar(100), is_default BOOLEAN, UNIQUE (scope));" );
		$wpdb->query( "CREATE TABLE IF NOT EXISTS `$esc_users_table` (username VARCHAR(100) NOT NULL, password VARCHAR(2000), first_name VARCHAR(255), last_name VARCHAR(255), CONSTRAINT username_pk PRIMARY KEY (username));" );
		$wpdb->query( "CREATE TABLE IF NOT EXISTS `$esc_public_keys_table` (client_id VARCHAR(80), public_key VARCHAR(8000), private_key VARCHAR(8000), encryption_algorithm VARCHAR(80) DEFAULT 'RS256');" );
		$wpdb->query( "CREATE TABLE IF NOT EXISTS `$esc_authorized_apps_table` (client_id TEXT, user_id INT);" );
		$wpdb->query( $wpdb->prepare( "INSERT IGNORE INTO `$esc_scopes_table` (scope, is_default) VALUES (%s, %d), (%s, %d)", 'email', 1, 'profile', 0 ) );

		//phpcs:enable
	}

	/**
	 * Summary of mo_oauth_server_check_db_version
	 *
	 * Creates the tables and runs the DB migrations newer than the stored DB version, since activation hooks do not fire on plugin updates.
	 *
	 * @return void
	 */
	public function mo_oauth_server_check_db_version() {
		global $wpdb;

		if ( wp_doing_ajax() ) {
			return;
		}

		$old_version = get_site_option( 'mo_oauth_server_db_version' );

		if ( ! empty( $old_version ) && version_compare( $old_version, MINIORANGE_OAUTH_20_SERVER_DB_VERSION, '>=' ) ) {
			return;
		}

		$auth_codes_table = $wpdb->base_prefix . 'moos_oauth_authorization_codes';
		$is_fresh_install = $auth_codes_table !== $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $auth_codes_table ) ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching

		$this->mo_oauth_server_create_tables();

		if ( empty( $old_version ) && $is_fresh_install ) {
			update_site_option( 'mo_oauth_server_db_version', MINIORANGE_OAUTH_20_SERVER_DB_VERSION );
			return;
		}

		if ( version_compare( $old_version, '1.0', '<' ) ) {
			if ( ! $this->mo_oauth_server_add_active_oauth_server_id_column() ) {
				$this->mo_oauth_server_show_migration_error( 'Clients could not be linked to this site.' );
				return;
			}
		}

		if ( version_compare( $old_version, '1.1', '<' ) ) {
			if ( ! $this->mo_oauth_server_widen_id_token_column() ) {
				$this->mo_oauth_server_show_migration_error( 'ID tokens may be truncated.' );
				return;
			}
		}

		update_site_option( 'mo_oauth_server_db_version', MINIORANGE_OAUTH_20_SERVER_DB_VERSION );
	}

	/**
	 * Summary of mo_oauth_server_show_migration_error
	 *
	 * Shows an admin notice for a failed DB migration.
	 *
	 * @param string $message what the failure affects.
	 * @return void
	 */
	private function mo_oauth_server_show_migration_error( $message ) {
		require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/class-miniorange-oauth-20-server-utils.php';
		$error = '' !== $this->migration_error ? ' Error: ' . $this->migration_error : '';
		update_option( 'mo_oauth_server_message', 'miniOrange OAuth Server: database update failed. ' . $message . ' Please grant the database user ALTER privilege on the plugin tables.' . $error, false );
		( new Miniorange_Oauth_20_Server_Utils() )->mo_oauth_show_error_message();
	}

	/**
	 * Summary of mo_oauth_server_add_active_oauth_server_id_column
	 *
	 * Adds the active_oauth_server_id column to the clients table on installs that predate it.
	 *
	 * @return bool True if the column exists, false otherwise.
	 */
	private function mo_oauth_server_add_active_oauth_server_id_column() {
		global $wpdb;

		$esc_clients_table = esc_sql( $wpdb->base_prefix . 'moos_oauth_clients' );
		//phpcs:disable WordPress.DB.PreparedSQL.InterpolatedNotPrepared,WordPress.DB.DirectDatabaseQuery.SchemaChange,WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
		if ( $wpdb->get_row( "SHOW COLUMNS FROM `$esc_clients_table` LIKE 'active_oauth_server_id'" ) ) {
			return true;
		}
		if ( false === $wpdb->query( $wpdb->prepare( "ALTER TABLE `$esc_clients_table` ADD active_oauth_server_id INT DEFAULT %d", get_current_blog_id() ) ) ) {
			$this->migration_error = $wpdb->last_error;
			return false;
		}
		//phpcs:enable
		return true;
	}

	/**
	 * Summary of mo_oauth_server_widen_id_token_column
	 *
	 * Widens the id_token column to TEXT, as VARCHAR(255) truncates signed JWTs.
	 *
	 * @return bool True if the id_token column is TEXT, false otherwise.
	 */
	private function mo_oauth_server_widen_id_token_column() {
		global $wpdb;

		$esc_auth_codes_table = esc_sql( $wpdb->base_prefix . 'moos_oauth_authorization_codes' );
		// SHOW COLUMNS only needs privileges on our own table, unlike INFORMATION_SCHEMA which may be restricted or not match DB_NAME.
		//phpcs:disable WordPress.DB.PreparedSQL.InterpolatedNotPrepared,WordPress.DB.DirectDatabaseQuery.SchemaChange,WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching,WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
		$id_token_column = $wpdb->get_row( "SHOW COLUMNS FROM `$esc_auth_codes_table` LIKE 'id_token'" );
		if ( ! $id_token_column ) {
			$this->migration_error = $wpdb->last_error;
		} elseif ( 'text' !== strtolower( $id_token_column->Type ) ) {
			if ( false === $wpdb->query( "ALTER TABLE `$esc_auth_codes_table` MODIFY id_token TEXT" ) ) {
				$this->migration_error = $wpdb->last_error;
			}
			$id_token_column = $wpdb->get_row( "SHOW COLUMNS FROM `$esc_auth_codes_table` LIKE 'id_token'" );
		}

		$is_text = $id_token_column && 'text' === strtolower( $id_token_column->Type );
		//phpcs:enable
		if ( ! $is_text ) {
			require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'errorlogs/class-mo-oauth-server-debug.php';
			MO_OAuth_Server_Debug::error_log( 'Unable to widen id_token column to TEXT. ' . $this->migration_error );
		}
		return $is_text;
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
	 * @param string $client_id Optional pre-supplied client ID; auto-generated when empty.
	 * @return string|false The client_id on success, false on failure.
	 */
	public function add_client( $client_name, $client_secret, $redirect_url, $active_oauth_server_id, $jwt_signing_algorithm, $private_key, $public_key, $client_id = '' ) {
		global $wpdb;
		require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/class-miniorange-oauth-20-server-utils.php';
		$mo_utils = new Miniorange_Oauth_20_Server_Utils();
		if ( '' === $client_id ) {
			$client_id = $mo_utils->moos_generate_random_string( 32 );
		}
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

		if ( false === $insert_keys ) {
			// Roll back the client row to avoid leaving an orphan.
			$wpdb->delete( // phpcs:ignore WordPress.DB.DirectDatabaseQuery
				$wpdb->base_prefix . 'moos_oauth_clients',
				array( 'client_id' => $client_id ),
				array( '%s' )
			);
			return false;
		}

		return $client_id;
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

		// moos_oauth_public_keys has no tenant column, so only delete keys for a client this site actually owns.
		 //phpcs:ignore WordPress.DB.DirectDatabaseQuery.SchemaChange,WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
		$owned_client_id = $wpdb->get_var(
			$wpdb->prepare(
				'SELECT client_id FROM ' . $wpdb->base_prefix . 'moos_oauth_clients WHERE client_id = %s AND client_name = %s AND active_oauth_server_id = %d',
				$client_id,
				$client_name,
				get_current_blog_id()
			)
		);

		if ( null !== $owned_client_id ) {
			 //phpcs:ignore WordPress.DB.DirectDatabaseQuery.SchemaChange,WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
			$wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $wpdb->base_prefix . 'moos_oauth_public_keys WHERE client_id = %s', array( $owned_client_id ) ) );
		}
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

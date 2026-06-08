<?php
/**
 * Class Miniorange_Oauth_20_Server_Add_Client
 *
 * @package Miniorange_Oauth_20_Server
 */

/**
 * Class Miniorange_Oauth_20_Server_Add_Client
 *
 * This class handles the addition of a new client.
 */
class Miniorange_Oauth_20_Server_Add_Client {

	/**
	 * Utils contains some commonly used functions
	 *
	 * @var [object]
	 */
	private $utils;

	/**
	 * Constructor for Miniorange_Oauth_20_Server_Add_Client.
	 */
	public function __construct() {
		require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/class-miniorange-oauth-20-server-db.php';
		require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/class-miniorange-oauth-20-server-utils.php';

		$this->utils = new Miniorange_Oauth_20_Server_Utils();
	}

	/**
	 * This function handles the addition of a new client (admin form or Abilities API).
	 *
	 * @param string $client_name The name of the client.
	 * @param string $redirect_uri The redirect uri of the client (may be empty).
	 * @param bool   $from_ability When true, returns array with success and message instead of admin notices only.
	 * @return bool|array True on admin success; false on admin failure; array when $from_ability is true.
	 */
	public function handle_add_client( $client_name, $redirect_uri, $from_ability = false ) {

		$client_name  = is_string( $client_name ) ? trim( $client_name ) : '';
		$redirect_uri = is_string( $redirect_uri ) ? trim( $redirect_uri ) : '';

		if ( '' === $client_name ) {
			if ( $from_ability ) {
				return array(
					'success' => false,
					'message' => 'Client name is empty, please provide a client name.',
				);
			}
			update_option( 'message', 'Client name is empty, please provide a client name.', false );
			$this->utils->mo_oauth_show_error_message();
			return false;
		}

		$mo_oauth_server_db = new Mo_Oauth_Server_Db();
		$clientlist         = $mo_oauth_server_db->get_clients();

		if ( ! empty( $clientlist ) ) {
			if ( $from_ability ) {
				return array(
					'success' => false,
					'message' => 'Only one OAuth client application can be configured. Delete the existing application before creating a new one.',
				);
			}
			update_option( 'message', 'Only one OAuth client application can be configured. Delete the existing application before creating a new one.', false );
			$this->utils->mo_oauth_show_error_message();
			return false;
		}

		$is_client_secret_encrypted = 1;
		update_option( 'mo_oauth_server_is_client_secret_encrypted', $is_client_secret_encrypted, false );
		$client_secret = $this->utils->mo_oauth_server_encrypt( $this->utils->moos_generate_random_string( 32 ), $client_name );

		$active_oauth_server_id = get_current_blog_id();

		$jwt_signing_algorithm = 'RS256';
		require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/class-miniorange-oauth-20-server-key-manager.php';
		$rsa_keys    = Mo_Oauth_Server_Key_Manager::generate_key_pair();
		$private_key = $rsa_keys ? $rsa_keys['private_key'] : '';
		$public_key  = $rsa_keys ? $rsa_keys['public_key'] : '';

		$added = $mo_oauth_server_db->add_client( $client_name, $client_secret, $redirect_uri, $active_oauth_server_id, $jwt_signing_algorithm, $private_key, $public_key );

		if ( ! $added ) {
			if ( $from_ability ) {
				return array(
					'success' => false,
					'message' => 'Could not create the OAuth client application.',
				);
			}
			update_option( 'message', 'Could not create the OAuth client application.', false );
			$this->utils->mo_oauth_show_error_message();
			return false;
		}

		Mo_Oauth_Server_Key_Manager::mark_keys_generated();

		if ( $from_ability ) {
			return array(
				'success' => true,
				'message' => 'Application created successfully.',
			);
		}

		return true;
	}
}

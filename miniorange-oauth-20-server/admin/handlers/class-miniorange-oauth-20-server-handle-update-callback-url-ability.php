<?php
/**
 * Abilities API handler: update OAuth client redirect / callback URI.
 *
 * @package    Miniorange_Oauth_20_Server
 * @subpackage Miniorange_Oauth_20_Server/admin/handlers
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/class-miniorange-oauth-20-server-db.php';

/**
 * Validates ability input and delegates to {@see Mo_Oauth_Server_Db::update_client()}.
 */
class Miniorange_Oauth_20_Server_Handle_Update_Callback_Url_Ability {

	/**
	 * Update redirect URI for an existing client (same DB path as the admin settings form).
	 *
	 * @param string $application_name OAuth client_name in the database.
	 * @param string $redirect_uri     New redirect URI (may be empty).
	 * @return array Array with success (bool) and message (string) keys.
	 */
	public static function handle_update_callback_url_ability( $application_name, $redirect_uri ) {
		$application_name = is_string( $application_name ) ? trim( $application_name ) : '';
		$redirect_uri     = is_string( $redirect_uri ) ? trim( $redirect_uri ) : '';

		if ( '' === $application_name ) {
			return array(
				'success' => false,
				'message' => 'Client name is empty, please provide a client name.',
			);
		}

		$mo_oauth_server_db = new Mo_Oauth_Server_Db();
		$clientlist         = $mo_oauth_server_db->get_clients();
		$found = false;
		if ( is_array( $clientlist ) ) {
			foreach ( $clientlist as $client ) {
				if ( isset( $client->client_name ) && $client->client_name === $application_name ) {
					$found = true;
					break;
				}
			}
		}

		if ( ! $found ) {
			return array(
				'success' => false,
				'message' => 'No OAuth client found with that application name.',
			);
		}

		$mo_oauth_server_db->update_client( $application_name, $redirect_uri );

		return array(
			'success' => true,
			'message' => 'Callback URL updated successfully.',
		);
	}
}

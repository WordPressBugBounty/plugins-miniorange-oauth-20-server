<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Summary of discovery
 *
 * @package Discovery
 */

/**
 * Summary of _mo_discovery
 *
 * Handles the discovery endpoint.
 *
 * @param mixed $data client data.
 * @return array
 */
function mo_oauth_server_discovery( $data ) {

	global $mo_oauth_server_home_url_plus_rest_prefix;

	mo_oauth_server_init();     // checking either server is on or off.
	$client_id = isset( $data['client_id'] ) ? $data['client_id'] : false;
	if ( ! $client_id ) {
		wp_send_json(
			array(
				'error'             => 'invalid_request',
				'error_description' => 'Resource Identifier Missing.',
			),
			400
		);
	}

	global $wpdb;
	$client = $wpdb->get_row( $wpdb->prepare( 'SELECT client_id FROM ' . $wpdb->base_prefix . 'moos_oauth_clients WHERE client_id = %s', $client_id ) ); //phpcs:ignore WordPress.DB.DirectDatabaseQuery
	if ( ! $client ) {
		wp_send_json(
			array(
				'error'             => 'invalid_client',
				'error_description' => 'Client does not exist.',
			),
			400
		);
	}

	return array(
		'request_parameter_supported'           => true,
		'claims_parameter_supported'            => false,
		'issuer'                                => $mo_oauth_server_home_url_plus_rest_prefix . '/moserver/' . $client_id,
		'authorization_endpoint'                => $mo_oauth_server_home_url_plus_rest_prefix . '/moserver/authorize',
		'token_endpoint'                        => $mo_oauth_server_home_url_plus_rest_prefix . '/moserver/token',
		'userinfo_endpoint'                     => $mo_oauth_server_home_url_plus_rest_prefix . '/moserver/resource',
		'scopes_supported'                      => array( 'profile', 'openid', 'email' ),
		'id_token_signing_alg_values_supported' => array( 'HS256', 'RS256' ),
		'response_types_supported'              => array( 'code' ),
		'jwks_uri'                              => $mo_oauth_server_home_url_plus_rest_prefix . '/moserver/' . $client_id . '/.well-known/keys',
		'grant_types_supported'                 => array( 'authorization_code' ),
		'subject_types_supported'               => array( 'public' ),
		'token_endpoint_auth_methods_supported' => array( 'client_secret_post' ),
	);
}

<?php
/**
 * Register Abilities handler File
 *
 * @package    Miniorange_Oauth_20_Server
 * @subpackage Miniorange_Oauth_20_Server/admin/handlers
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/constants/class-miniorange-oauth-20-server-oauth-constants.php';
require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/class-miniorange-oauth-20-server-abilities-api-settings.php';
require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/class-miniorange-oauth-20-server-utils.php';
require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/class-miniorange-oauth-20-server-db.php';
require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/class-miniorange-oauth-20-server-customer.php';
require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/class-miniorange-oauth-20-server-add-client.php';
require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/class-miniorange-oauth-20-server-log-delete.php';
require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/class-miniorange-oauth-20-server-contact-us.php';
require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/handlers/class-miniorange-oauth-20-server-handle-update-callback-url-ability.php';
require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/handlers/class-miniorange-oauth-20-server-handle-custom-login-url-ability.php';
require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/class-miniorange-oauth-20-server-enable-jwt-support.php';

/**
 * Class to register abilities.
 */
class Miniorange_Oauth_20_Server_Register_Abilities {

	/**
	 * Category and ability IDs registered by this plugin (for unregister on toggle-off).
	 *
	 * @return string[]
	 */
	private static function mo_oauth_server_registered_ability_ids() {
		return array(
			'mo-oauth-server/query-support-request',
			'mo-oauth-server/create-application',
			'mo-oauth-server/enable-jwt-support',
			'mo-oauth-server/disable-jwt-support',
			'mo-oauth-server/enable-debug-logs',
			'mo-oauth-server/disable-debug-logs',
			'mo-oauth-server/get-scope',
			'mo-oauth-server/update-callback-url',
			'mo-oauth-server/update-custom-login-url',
			'mo-oauth-server/get-discovery-endpoint',
			'mo-oauth-server/get-jwks-endpoint',
			'mo-oauth-server/enable-state-parameter',
			'mo-oauth-server/disable-state-parameter',
		);
	}

	/**
	 * Base ability meta for registered abilities (only called when Abilities API is enabled).
	 *
	 * @param array $annotations Ability meta.annotations value.
	 * @return array
	 */
	private static function mo_oauth_server_get_ability_meta( array $annotations ) {
		return array(
			'show_in_rest' => true,
			'annotations'  => $annotations,
			'mcp'          => array(
				'public' => true,
			),
		);
	}

	/**
	 * Callback for wp_abilities_api_categories_init.
	 */
	public static function hook_wp_abilities_api_categories_init() {
		if ( Miniorange_Oauth_20_Server_Abilities_Api_Settings::is_enabled() ) {
			self::mo_oauth_server_register_ability_category();
			return;
		}

		if ( function_exists( 'wp_unregister_ability_category' ) && function_exists( 'wp_has_ability_category' ) && wp_has_ability_category( 'mo-oauth-server' ) ) {
			wp_unregister_ability_category( 'mo-oauth-server' );
		}
	}

	/**
	 * Callback for wp_abilities_api_init.
	 */
	public static function hook_wp_abilities_api_init() {
		if ( ! function_exists( 'wp_register_ability' ) || ! function_exists( 'wp_unregister_ability' ) ) {
			return;
		}

		if ( Miniorange_Oauth_20_Server_Abilities_Api_Settings::is_enabled() ) {
			self::mo_oauth_server_register_all_abilities();
			return;
		}

		self::mo_oauth_server_unregister_all_abilities();
	}

	/**
	 * Unregister plugin abilities and category (e.g. when the toggle is turned off).
	 */
	public static function mo_oauth_server_unregister_all_abilities() {
		if ( function_exists( 'wp_unregister_ability' ) && function_exists( 'wp_has_ability' ) ) {
			foreach ( self::mo_oauth_server_registered_ability_ids() as $ability_id ) {
				if ( wp_has_ability( $ability_id ) ) {
					wp_unregister_ability( $ability_id );
				}
			}
		}
		if ( function_exists( 'wp_unregister_ability_category' ) && function_exists( 'wp_has_ability_category' ) ) {
			if ( wp_has_ability_category( 'mo-oauth-server' ) ) {
				wp_unregister_ability_category( 'mo-oauth-server' );
			}
		}
	}

	/**
	 * Register the MO OAuth Server ability category.
	 */
	public static function mo_oauth_server_register_ability_category() {
		if ( ! function_exists( 'wp_register_ability_category' ) || ! Miniorange_Oauth_20_Server_Abilities_Api_Settings::is_enabled() ) {
			return;
		}
		wp_register_ability_category(
			'mo-oauth-server',
			array(
				'label'       => 'OAuth 2.0 Server',
				'description' => 'Tools for configuring and managing the miniOrange OAuth 2.0 Server — register client applications, manage JWT token settings, control debug logging, and retrieve server endpoints.',
			)
		);
	}

	/**
	 * Register all abilities.
	 * Only registers when the plugin Abilities API toggle is on and core API exists.
	 */
	public static function mo_oauth_server_register_all_abilities() {
		if ( ! function_exists( 'wp_register_ability' ) || ! Miniorange_Oauth_20_Server_Abilities_Api_Settings::is_enabled() ) {
			return;
		}
		self::mo_oauth_server_query_support_request();
		self::mo_oauth_server_create_application();
		self::mo_oauth_server_enable_jwt_support();
		self::mo_oauth_server_disable_jwt_support();
		self::mo_oauth_server_enable_debug_logs();
		self::mo_oauth_server_disable_debug_logs();
		self::mo_oauth_server_get_scope();
		self::mo_oauth_server_update_callback_url();
		self::mo_oauth_server_update_custom_login_url();
		self::mo_oauth_server_get_discovery_endpoint();
		self::mo_oauth_server_get_jwks_endpoint();
		self::mo_oauth_server_enable_state_parameter();
		self::mo_oauth_server_disable_state_parameter();
	}

	/**
	 * Register the ability to query the support request.
	 */
	public static function mo_oauth_server_query_support_request() {
		wp_register_ability(
			'mo-oauth-server/query-support-request',
			array(
				'label'       => 'Send Support Request',
				'description' => 'Submits a support or contact message to the miniOrange team on behalf of the site administrator. Use this to request help, report issues, or ask about licensing. The current user\'s email is used as the reply-to address if none is provided.',
				'category'    => 'mo-oauth-server',

				'input_schema' => array(
					'type'       => 'object',
					'properties' => array(
						'support_request' => array(
							'type'        => 'string',
							'description' => 'Support or contact message to send to miniOrange.',
						),
						'email'           => array(
							'type'        => 'string',
							'format'      => 'email',
							'description' => 'Contact email. If omitted, the current user email is used.',
						),
						'phone'           => array(
							'type' => 'string',
						),
						'no_of_users'     => array(
							'type' => 'string',
						),
					),
					'required'   => array( 'support_request' ),
				),

				'output_schema' => array(
					'type' => 'object',
					'properties' => array(
						'success' => array( 'type' => 'boolean' ),
						'message' => array( 'type' => 'string' ),
					),
					'required' => array( 'success', 'message' ),
				),

				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},

				'execute_callback' => function ( $input = null ) {
					if ( is_object( $input ) ) {
						$input = json_decode( wp_json_encode( $input ), true );
					}
					if ( ! is_array( $input ) ) {
						$input = array();
					}

					$query = isset( $input['support_request'] ) ? sanitize_textarea_field( wp_unslash( $input['support_request'] ) ) : '';
					$email = isset( $input['email'] ) ? sanitize_email( wp_unslash( $input['email'] ) ) : '';
					$phone = isset( $input['phone'] ) ? sanitize_text_field( wp_unslash( $input['phone'] ) ) : '';
					$no_of_users = isset( $input['no_of_users'] ) ? sanitize_text_field( wp_unslash( $input['no_of_users'] ) ) : '';

					if ( empty( $email ) ) {
						$user = wp_get_current_user();
						if ( $user && $user->ID ) {
							$email = sanitize_email( $user->user_email );
						}
					}

					$contact_us = new Miniorange_Oauth_20_Server_Contact_Us();
					$result     = $contact_us->handle_contact_us( $email, $phone, $query, $no_of_users, true );

					return is_array( $result ) ? $result : array(
						'success' => false,
						'message' => 'Support request could not be processed.',
					);
				},

				'meta' => self::mo_oauth_server_get_ability_meta(
					array(
						'readonly'      => false,
						'idempotent'    => false,
						'openWorldHint' => true,
					)
				),
			)
		);
	}

	/**
	 * Register the ability to create an application.
	 */
	public static function mo_oauth_server_create_application() {
		wp_register_ability(
			'mo-oauth-server/create-application',
			array(
				'label'       => 'Create Application',
				'description' => 'Registers a new OAuth 2.0 client application on this WordPress OAuth server, generating a client ID and secret. Use this to onboard a new application — such as a web app, AI tool, or mobile client — that will authenticate users against this site.',
				'category'    => 'mo-oauth-server',

				'input_schema' => array(
					'type'       => 'object',
					'properties' => array(
						'application_name' => array(
							'type'        => 'string',
							'description' => 'OAuth client / application name.',
						),
						'redirect_uri'     => array(
							'type'        => 'string',
							'description' => 'Redirect URI for the client. Optional; may be empty.',
						),
					),
					'required'   => array( 'application_name' ),
				),

				'output_schema' => array(
					'type' => 'object',
					'properties' => array(
						'success' => array( 'type' => 'boolean' ),
						'message' => array( 'type' => 'string' ),
					),
					'required' => array( 'success', 'message' ),
				),

				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},

				'execute_callback' => function ( $input = null ) {
					if ( is_object( $input ) ) {
						$input = json_decode( wp_json_encode( $input ), true );
					}
					if ( ! is_array( $input ) ) {
						$input = array();
					}

					$application_name = isset( $input['application_name'] ) ? sanitize_text_field( wp_unslash( $input['application_name'] ) ) : '';
					$redirect_uri     = isset( $input['redirect_uri'] ) ? sanitize_url( wp_unslash( $input['redirect_uri'] ) ) : '';

					$add_client = new Miniorange_Oauth_20_Server_Add_Client();
					$result     = $add_client->handle_add_client( $application_name, $redirect_uri, true );

					return is_array( $result ) ? $result : array(
						'success' => false,
						'message' => 'Application could not be created.',
					);
				},

				'meta' => self::mo_oauth_server_get_ability_meta(
					array(
						'readonly'      => false,
						'idempotent'    => false,
						'openWorldHint' => true,
					)
				),
			)
		);
	}

	/**
	 * Register the ability to enable JWT support.
	 */
	public static function mo_oauth_server_enable_jwt_support() {
		wp_register_ability(
			'mo-oauth-server/enable-jwt-support',
			array(
				'label'       => 'Enable JWT Support',
				'description' => 'Switches a registered OAuth 2.0 client to issue signed JWT access tokens instead of opaque random strings. Requires specifying the signing algorithm (e.g. RS256 or HS256). JWT tokens allow client applications to verify claims locally without calling the server\'s introspection endpoint.',
				'category'    => 'mo-oauth-server',

				'input_schema' => array(
					'type'       => 'object',
					'properties' => array(
						'application_name' => array(
							'type'        => 'string',
							'description' => 'OAuth client / application name as stored in the server (must match client_name in the database).',
						),
						'jwt_signing_algo' => array(
							'type'        => 'string',
							'description' => 'JWT signing algorithm value, e.g. RS256 or HS256.',
						),
					),
					'required'   => array( 'application_name', 'jwt_signing_algo' ),
				),

				'output_schema' => array(
					'type'       => 'object',
					'properties' => array(
						'success' => array( 'type' => 'boolean' ),
						'message' => array( 'type' => 'string' ),
					),
					'required'   => array( 'success', 'message' ),
				),

				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},

				'execute_callback' => function ( $input = null ) {
					if ( is_object( $input ) ) {
						$input = json_decode( wp_json_encode( $input ), true );
					}
					if ( ! is_array( $input ) ) {
						$input = array();
					}

					$handler = new Miniorange_Oauth_20_Server_Enable_JWT_Support();
					return $handler->handle_enable_jwt_support( $input );
				},

				'meta' => self::mo_oauth_server_get_ability_meta(
					array(
						'readonly'      => false,
						'idempotent'    => false,
						'openWorldHint' => true,
					)
				),
			)
		);
	}

	/**
	 * Register the ability to disable JWT support.
	 */
	public static function mo_oauth_server_disable_jwt_support() {
		wp_register_ability(
			'mo-oauth-server/disable-jwt-support',
			array(
				'label'       => 'Disable JWT Support',
				'description' => 'Reverts a registered OAuth 2.0 client from JWT access tokens back to opaque tokens. Use this if the client application does not support JWT validation or if you need to switch token strategies.',
				'category'    => 'mo-oauth-server',

				'input_schema' => array(
					'type'       => 'object',
					'properties' => array(
						'application_name' => array(
							'type'        => 'string',
							'description' => 'OAuth client / application name as stored in the server (must match client_name in the database).',
						),
					),
					'required'   => array( 'application_name' ),
				),

				'output_schema' => array(
					'type'       => 'object',
					'properties' => array(
						'success' => array( 'type' => 'boolean' ),
						'message' => array( 'type' => 'string' ),
					),
					'required'   => array( 'success', 'message' ),
				),

				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},

				'execute_callback' => function ( $input = null ) {
					if ( is_object( $input ) ) {
						$input = json_decode( wp_json_encode( $input ), true );
					}
					if ( ! is_array( $input ) ) {
						$input = array();
					}
					$input['disabled'] = true;

					$handler = new Miniorange_Oauth_20_Server_Enable_JWT_Support();
					return $handler->handle_enable_jwt_support( $input );
				},

				'meta' => self::mo_oauth_server_get_ability_meta(
					array(
						'readonly'      => false,
						'idempotent'    => true,
						'openWorldHint' => true,
					)
				),
			)
		);
	}

	/**
	 * Register the ability to enable debug logs.
	 */
	public static function mo_oauth_server_enable_debug_logs() {
		wp_register_ability(
			'mo-oauth-server/enable-debug-logs',
			array(
				'label'       => 'Enable Debug Logs',
				'description' => 'Turns on verbose debug logging for the OAuth 2.0 Server. Logs OAuth request and response details to a file on the server, useful for diagnosing authorization failures, token errors, or client integration issues.',
				'category'    => 'mo-oauth-server',

				'input_schema' => array(
					'type'                 => 'object',
					'properties'           => new \stdClass(),
					'additionalProperties' => false,
				),

				'output_schema' => array(
					'type'       => 'object',
					'properties' => array(
						'success' => array( 'type' => 'boolean' ),
						'message' => array( 'type' => 'string' ),
					),
					'required'   => array( 'success', 'message' ),
				),

				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},

				'execute_callback' => function () {
					require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/class-miniorange-oauth-20-server-enable-debug-logs.php';
					return Miniorange_Oauth_20_Server_Enable_Debug_Logs::mo_oauth_server_try_enable_debug_logs();
				},

				'meta' => self::mo_oauth_server_get_ability_meta(
					array(
						'readonly'      => false,
						'idempotent'    => true,
						'openWorldHint' => true,
					)
				),
			)
		);
	}

	/**
	 * Register the ability to disable debug logs.
	 */
	public static function mo_oauth_server_disable_debug_logs() {
		wp_register_ability(
			'mo-oauth-server/disable-debug-logs',
			array(
				'label'       => 'Disable Debug Logs',
				'description' => 'Turns off debug logging and deletes the existing log file from the server. Use this after resolving an issue to prevent sensitive OAuth data from accumulating on disk.',
				'category'    => 'mo-oauth-server',

				'input_schema' => array(
					'type'                 => 'object',
					'properties'           => new \stdClass(),
					'additionalProperties' => false,
				),

				'output_schema' => array(
					'type'       => 'object',
					'properties' => array(
						'success' => array( 'type' => 'boolean' ),
						'message' => array( 'type' => 'string' ),
					),
					'required'   => array( 'success', 'message' ),
				),

				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},

				'execute_callback' => function () {
					update_option( 'mo_oauth_server_is_debug_enabled', 0, false );
					require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/class-miniorange-oauth-20-server-log-delete.php';
					$debug_logs_delete = new Miniorange_Oauth_20_Server_Log_Delete();
					$debug_logs_delete->mo_oauth_delete_debug_log_file();

					return array(
						'success' => true,
						'message' => 'Debug logs disabled successfully.',
					);
				},

				'meta' => self::mo_oauth_server_get_ability_meta(
					array(
						'readonly'      => false,
						'idempotent'    => true,
						'openWorldHint' => true,
					)
				),
			)
		);
	}

	/**
	 * Register the ability to get scope.
	 */
	public static function mo_oauth_server_get_scope() {
		wp_register_ability(
			'mo-oauth-server/get-scope',
			array(
				'label'       => 'Get Scope',
				'description' => 'Returns the default OAuth 2.0 scopes granted to all access tokens issued by this server. On the free plan the scope is always "profile email"; per-client scope configuration requires a premium license.',
				'category'    => 'mo-oauth-server',

				'input_schema' => array(
					'type'                 => 'object',
					'properties'           => new \stdClass(),
					'additionalProperties' => false,
				),

				'output_schema' => array(
					'type' => 'object',
					'properties' => array(
						'success' => array( 'type' => 'boolean' ),
						'message' => array( 'type' => 'string' ),
						'scope'   => array(
							'type'        => 'string',
							'description' => 'Space-delimited default scopes (profile and email); matches OAuth2\Storage\MoPdo::getDefaultScope() for this plugin.',
						),
					),
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},

				'execute_callback' => function () {
					// Free plugin: no per-client scope UI; same default string as OAuth2\Storage\MoPdo::getDefaultScope().
					return array(
						'success' => true,
						'message' => 'Scope retrieved successfully.',
						'scope'   => 'profile email',
					);
				},

				'meta' => self::mo_oauth_server_get_ability_meta(
					array(
						'readonly' => true,
						'idempotent' => true,
						'openWorldHint' => false,
					)
				),
			)
		);
	}

	/**
	 * Register the ability to update callback URL.
	 */
	public static function mo_oauth_server_update_callback_url() {
		wp_register_ability(
			'mo-oauth-server/update-callback-url',
			array(
				'label'       => 'Update Callback URL',
				'description' => 'Updates the redirect URI for an existing OAuth 2.0 client application. The redirect URI is the endpoint the authorization server sends the user back to after login, along with the authorization code. Must exactly match the URI registered in the client application.',
				'category'    => 'mo-oauth-server',

				'input_schema' => array(
					'type'       => 'object',
					'properties' => array(
						'application_name' => array(
							'type'        => 'string',
							'description' => 'OAuth client / application name.',
						),
						'redirect_uri'     => array(
							'type'        => 'string',
							'description' => 'Redirect URI for the client. Optional; may be empty.',
						),
					),
					'required'   => array( 'application_name' ),
				),

				'output_schema' => array(
					'type' => 'object',
					'properties' => array(
						'success' => array( 'type' => 'boolean' ),
						'message' => array( 'type' => 'string' ),
					),
					'required' => array( 'success', 'message' ),
				),

				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},

				'execute_callback' => function ( $input = null ) {
					if ( is_object( $input ) ) {
						$input = json_decode( wp_json_encode( $input ), true );
					}
					if ( ! is_array( $input ) ) {
						$input = array();
					}	

					$application_name = isset( $input['application_name'] ) ? sanitize_text_field( wp_unslash( $input['application_name'] ) ) : '';
					$redirect_uri     = isset( $input['redirect_uri'] ) ? sanitize_url( wp_unslash( $input['redirect_uri'] ) ) : '';

					return Miniorange_Oauth_20_Server_Handle_Update_Callback_Url_Ability::handle_update_callback_url_ability( $application_name, $redirect_uri );
				},

				'meta' => self::mo_oauth_server_get_ability_meta(
					array(
						'readonly'      => false,
						'idempotent'    => false,
						'openWorldHint' => true,
					)
				),
			)
		);
	}

	/**
	 * Register the ability to set or clear the custom login URL (advance settings).
	 */
	public static function mo_oauth_server_update_custom_login_url() {
		wp_register_ability(
			'mo-oauth-server/update-custom-login-url',
			array(
				'label'       => 'Update Custom Login URL',
				'description' => 'Sets a custom login page URL that users are redirected to at the start of the OAuth authorization flow, replacing the default WordPress login page. Useful when the site uses a custom login form or a non-default login path. Pass an empty string to revert to the WordPress default (/wp-login.php).',
				'category'    => 'mo-oauth-server',

				'input_schema' => array(
					'type'       => 'object',
					'properties' => array(
						'custom_login_url' => array(
							'type'        => 'string',
							'description' => 'Full URL of the custom login page. Omit or use empty string to clear and use the default WordPress login.',
						),
					),
				),

				'output_schema' => array(
					'type'       => 'object',
					'properties' => array(
						'success'          => array( 'type' => 'boolean' ),
						'message'          => array( 'type' => 'string' ),
						'custom_login_url' => array(
							'type'        => 'string',
							'description' => 'Stored URL after success; on validation failure, the previous saved value.',
						),
					),
					'required'   => array( 'success', 'message', 'custom_login_url' ),
				),

				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},

				'execute_callback' => function ( $input = null ) {
					if ( is_object( $input ) ) {
						$input = json_decode( wp_json_encode( $input ), true );
					}
					if ( ! is_array( $input ) ) {
						$input = array();
					}

					$custom_url = isset( $input['custom_login_url'] ) ? sanitize_url( wp_unslash( $input['custom_login_url'] ) ) : '';

					return Miniorange_Oauth_20_Server_Handle_Custom_Login_Url_Ability::handle_custom_login_url_ability( $custom_url );
				},

				'meta' => self::mo_oauth_server_get_ability_meta(
					array(
						'readonly'      => false,
						'idempotent'    => false,
						'openWorldHint' => true,
					)
				),
			)
		);
	}

	/**
	 * Register the ability to get discovery endpoint.
	 */
	public static function mo_oauth_server_get_discovery_endpoint() {
		wp_register_ability(
			'mo-oauth-server/get-discovery-endpoint',
			array(
				'label'       => 'Get Discovery Endpoint',
				'description' => 'Returns the OpenID Connect discovery document URL for a registered OAuth client. AI agents and identity providers can fetch this URL to auto-configure authorization, token, and JWKS endpoints without manual setup.',
				'category'    => 'mo-oauth-server',

				'input_schema' => array(
					'type'       => 'object',
					'properties' => array(
						'application_name' => array(
							'type'        => 'string',
							'description' => 'OAuth client name (client_name in the database; same as the Client Name field in the admin UI).',
						),
					),
					'required'   => array( 'application_name' ),
				),

				'output_schema' => array(
					'type' => 'object',
					'properties' => array(
						'success'              => array( 'type' => 'boolean' ),
						'message'              => array( 'type' => 'string' ),
						'discovery_endpoint'   => array(
							'type'        => 'string',
							'description' => 'Full URL to /.well-known/openid-configuration for this client.',
						),
					),
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},

				'execute_callback' => function ( $input = null ) {
					if ( is_object( $input ) ) {
						$input = json_decode( wp_json_encode( $input ), true );
					}
					if ( ! is_array( $input ) ) {
						$input = array();
					}

					$application_name = isset( $input['application_name'] ) ? sanitize_text_field( wp_unslash( $input['application_name'] ) ) : '';

					if ( '' === $application_name ) {
						return array(
							'success'            => false,
							'message'            => 'application_name is required.',
							'discovery_endpoint' => '',
						);
					}

					$mo_oauth_server_db = new Mo_Oauth_Server_Db();
					$clientlist         = $mo_oauth_server_db->get_clients();
					$client_id          = '';

					if ( is_array( $clientlist ) ) {
						foreach ( $clientlist as $client ) {
							if ( isset( $client->client_name ) && $client->client_name === $application_name ) {
								$client_id = $client->client_id;
								break;
							}
						}
					}

					if ( '' === $client_id ) {
						return array(
							'success'            => false,
							'message'            => 'No OAuth client found with that application name.',
							'discovery_endpoint' => '',
						);
					}

					$mo_utils                  = new Miniorange_Oauth_20_Server_Utils();
					$home_url_plus_rest_prefix = $mo_utils->get_home_url_with_permalink_structure();

					// Matches admin configured-client view: home + rest prefix + /moserver/{client_id}/.well-known/openid-configuration.
					$discovery_endpoint = esc_url_raw(
						$home_url_plus_rest_prefix . '/moserver/' . $client_id . '/.well-known/openid-configuration'
					);

					return array(
						'success'            => true,
						'message'            => 'Discovery endpoint retrieved successfully.',
						'discovery_endpoint' => $discovery_endpoint,
					);
				},

				'meta' => self::mo_oauth_server_get_ability_meta(
					array(
						'readonly' => true,
						'idempotent' => true,
						'openWorldHint' => true,
					)
				),
			)
		);
	}

	/**
	 * Register the ability to get JWKS endpoint.
	 */
	public static function mo_oauth_server_get_jwks_endpoint() {
		wp_register_ability(
			'mo-oauth-server/get-jwks-endpoint',
			array(
				'label'       => 'Get JWKS Endpoint',
				'description' => 'Returns the JSON Web Key Set (JWKS) endpoint URL for a registered OAuth client. Client applications fetch this URL to retrieve the public keys used to verify JWT access tokens issued by this server.',
				'category'    => 'mo-oauth-server',

				'input_schema' => array(
					'type'       => 'object',
					'properties' => array(
						'application_name' => array(
							'type'        => 'string',
							'description' => 'OAuth client name (client_name in the database; same as the Client Name field in the admin UI).',
						),
					),
					'required'   => array( 'application_name' ),
				),

				'output_schema' => array(
					'type' => 'object',
					'properties' => array(
						'success'        => array( 'type' => 'boolean' ),
						'message'        => array( 'type' => 'string' ),
						'jwks_endpoint'  => array(
							'type'        => 'string',
							'description' => 'Full URL to /.well-known/keys for this client.',
						),
					),
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},

				'execute_callback' => function ( $input = null ) {
					if ( is_object( $input ) ) {
						$input = json_decode( wp_json_encode( $input ), true );
					}
					if ( ! is_array( $input ) ) {
						$input = array();
					}

					$application_name = isset( $input['application_name'] ) ? sanitize_text_field( wp_unslash( $input['application_name'] ) ) : '';

					if ( '' === $application_name ) {
						return array(
							'success'       => false,
							'message'       => 'application_name is required.',
							'jwks_endpoint' => '',
						);
					}

					$mo_oauth_server_db = new Mo_Oauth_Server_Db();
					$clientlist         = $mo_oauth_server_db->get_clients();
					$client_id          = '';

					if ( is_array( $clientlist ) ) {
						foreach ( $clientlist as $client ) {
							if ( isset( $client->client_name ) && $client->client_name === $application_name ) {
								$client_id = $client->client_id;
								break;
							}
						}
					}

					if ( '' === $client_id ) {
						return array(
							'success'       => false,
							'message'       => 'No OAuth client found with that application name.',
							'jwks_endpoint' => '',
						);
					}

					$mo_utils                  = new Miniorange_Oauth_20_Server_Utils();
					$home_url_plus_rest_prefix = $mo_utils->get_home_url_with_permalink_structure();

					// Matches admin configured-client view: home + rest prefix + /moserver/{client_id}/.well-known/keys.
					$jwks_endpoint = esc_url_raw(
						$home_url_plus_rest_prefix . '/moserver/' . $client_id . '/.well-known/keys'
					);

					return array(
						'success'       => true,
						'message'       => 'JWKS endpoint retrieved successfully.',
						'jwks_endpoint' => $jwks_endpoint,
					);
				},

				'meta' => self::mo_oauth_server_get_ability_meta(
					array(
						'readonly' => true,
						'idempotent' => true,
						'openWorldHint' => true,
					)
				),
			)
		);
	}

	/**
	 * Register the ability to enable state parameter.
	 */
	public static function mo_oauth_server_enable_state_parameter() {
		wp_register_ability(
			'mo-oauth-server/enable-state-parameter',
			array(
				'label'       => 'Enable State Parameter',
				'description' => 'Enforces the OAuth 2.0 state parameter on all authorization requests to this server. When enabled, the server rejects requests that omit the state value or return a mismatched one, protecting against CSRF attacks during the OAuth flow.',
				'category'    => 'mo-oauth-server',
				'input_schema' => array(
					'type'                 => 'object',
					'properties'           => new \stdClass(),
					'additionalProperties' => false,
				),
				'output_schema' => array(
					'type'       => 'object',
					'properties' => array(
						'success' => array( 'type' => 'boolean' ),
						'message' => array( 'type' => 'string' ),
					),
					'required' => array( 'success', 'message' ),
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
				'execute_callback' => function () {
					update_option( 'mo_oauth_server_enforce_state', 'on', false );
					return array(
						'success' => true,
						'message' => 'State parameter enabled successfully.',
					);
				},
				'meta' => self::mo_oauth_server_get_ability_meta(
					array(
						'readonly'      => false,
						'idempotent'    => true,
						'openWorldHint' => true,
					)
				),
			)
		);
	}

	/**
	 * Register the ability to disable state parameter.
	 */
	public static function mo_oauth_server_disable_state_parameter() {
		wp_register_ability(
			'mo-oauth-server/disable-state-parameter',
			array(
				'label'       => 'Disable State Parameter',
				'description' => 'Stops requiring the OAuth 2.0 state parameter on authorization requests. Only use this when the connecting client application does not support the state parameter and CSRF protection is handled by other means.',
				'category'    => 'mo-oauth-server',
				'input_schema' => array(
					'type'                 => 'object',
					'properties'           => new \stdClass(),
					'additionalProperties' => false,
				),
				'output_schema' => array(
					'type'       => 'object',
					'properties' => array(
						'success' => array( 'type' => 'boolean' ),
						'message' => array( 'type' => 'string' ),
					),
					'required' => array( 'success', 'message' ),
				),
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
				'execute_callback' => function () {
					update_option( 'mo_oauth_server_enforce_state', 'off', false );
					return array(
						'success' => true,
						'message' => 'State parameter disabled successfully.',
					);
				},
				'meta' => self::mo_oauth_server_get_ability_meta(
					array(
						'readonly'      => false,
						'idempotent'    => true,
						'openWorldHint' => true,
					)
				),
			)
		);
	}
}

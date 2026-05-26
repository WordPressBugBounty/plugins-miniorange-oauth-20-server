<?php
/**
 * MCP (Model Context Protocol) endpoint for the miniOrange OAuth 2.0 Server.
 *
 * Exposes POST /wp-json/moserver/mcp — a stateless HTTP JSON-RPC 2.0 endpoint
 * implementing MCP protocol version 2025-11-25.
 *
 * Auth: WordPress Application Password (Basic) or the OAuth 2.0 Bearer tokens
 * issued by this same plugin — both are supported simultaneously.
 *
 * Tools are sourced from the WordPress Abilities API. The admin configures an
 * allowlist of ability slugs to stay within ChatGPT's 128-tool limit.
 *
 * @package    Miniorange_Oauth_20_Server
 * @subpackage Miniorange_Oauth_20_Server/includes/mcp
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Miniorange_Oauth_20_Server_MCP
 */
class Miniorange_Oauth_20_Server_MCP {

	/**
	 * REST namespace — matches the rest of the plugin's routes.
	 */
	const REST_NS = 'moserver';

	/**
	 * MCP protocol version advertised in initialize responses.
	 */
	const MCP_VERSION = '2025-11-25';

	/**
	 * Maximum tools returned to a single client.
	 * ChatGPT enforces a 128-tool ceiling; we cap here to prevent silent failures.
	 */
	const MAX_TOOLS = 128;

	// JSON-RPC 2.0 standard error codes.
	const ERR_PARSE          = -32700;
	const ERR_INVALID_REQ    = -32600;
	const ERR_METHOD_UNKNOWN = -32601;
	const ERR_INVALID_PARAMS = -32602;
	const ERR_INTERNAL       = -32603;

	// Custom error codes.
	const ERR_ACCESS_DENIED = -32001;

	/**
	 * Register the MCP REST route.
	 *
	 * @return void
	 */
	public static function register_routes() {
		register_rest_route(
			self::REST_NS,
			'/mcp',
			array(
				'methods'             => 'POST',
				'callback'            => array( __CLASS__, 'handle_request' ),
				'permission_callback' => array( __CLASS__, 'check_permission' ),
			)
		);

		// RFC 8414 — OAuth 2.0 Authorization Server Metadata.
		// MCP clients (ChatGPT, Claude) probe GET /wp-json/moserver/mcp/.well-known/oauth-authorization-server.
		register_rest_route(
			self::REST_NS,
			'/mcp/.well-known/oauth-authorization-server',
			array(
				'methods'             => 'GET',
				'callback'            => array( __CLASS__, 'handle_as_metadata' ),
				'permission_callback' => '__return_true',
			)
		);

		// RFC 9728 — OAuth 2.0 Protected Resource Metadata.
		// MCP clients probe GET /wp-json/moserver/mcp/.well-known/oauth-protected-resource.
		register_rest_route(
			self::REST_NS,
			'/mcp/.well-known/oauth-protected-resource',
			array(
				'methods'             => 'GET',
				'callback'            => array( __CLASS__, 'handle_resource_metadata' ),
				'permission_callback' => '__return_true',
			)
		);

		// Add WWW-Authenticate to 401 responses so clients find the metadata URL.
		add_filter( 'rest_post_dispatch', array( __CLASS__, 'add_www_authenticate_header' ), 10, 3 );
	}

	/**
	 * RFC 8414 Authorization Server Metadata.
	 *
	 * @return WP_REST_Response
	 */
	public static function handle_as_metadata() {
		MO_OAuth_Server_Debug::error_log( 'MCP OAuth discovery - serving AS metadata (RFC 8414).' );
		$base = rtrim( rest_url( self::REST_NS ), '/' );
		return new WP_REST_Response(
			array(
				'issuer'                                => $base,
				'authorization_endpoint'               => $base . '/authorize',
				'token_endpoint'                        => $base . '/token',
				'response_types_supported'             => array( 'code' ),
				'grant_types_supported'                => array( 'authorization_code' ),
				'token_endpoint_auth_methods_supported' => array( 'client_secret_post', 'client_secret_basic' ),
				'scopes_supported'                     => array( 'openid', 'email', 'profile' ),
			),
			200
		);
	}

	/**
	 * RFC 9728 Protected Resource Metadata.
	 * Points clients to the authorization server for OAuth discovery.
	 *
	 * @return WP_REST_Response
	 */
	public static function handle_resource_metadata() {
		MO_OAuth_Server_Debug::error_log( 'MCP OAuth discovery - serving resource metadata (RFC 9728).' );
		$base = rtrim( rest_url( self::REST_NS ), '/' );
		return new WP_REST_Response(
			array(
				'resource'                 => $base . '/mcp',
				'authorization_servers'    => array( $base ),
				'bearer_methods_supported' => array( 'header' ),
				'scopes_supported'         => array( 'openid', 'email', 'profile' ),
			),
			200
		);
	}

	/**
	 * Inject WWW-Authenticate into 401 responses from the MCP endpoint.
	 * Without this, clients show "does not implement OAuth" instead of prompting for auth.
	 *
	 * @param WP_REST_Response $response Response object.
	 * @param WP_REST_Server   $server   REST server.
	 * @param WP_REST_Request  $request  Incoming request.
	 * @return WP_REST_Response
	 */
	public static function add_www_authenticate_header( $response, $_server, $request ) {
		if ( 401 === $response->get_status() && '/moserver/mcp' === $request->get_route() ) {
			$resource_metadata_url = rest_url( self::REST_NS . '/mcp/.well-known/oauth-protected-resource' );
			$response->header( 'WWW-Authenticate', 'Bearer resource_metadata="' . esc_url_raw( $resource_metadata_url ) . '"' );
		}
		return $response;
	}

	/**
	 * Permission callback: enforces MCP enabled check and dual-mode authentication.
	 *
	 * Supports two auth modes configured by the admin:
	 *  - application_password: WP core resolves the user from Basic auth at priority 10.
	 *  - oauth: validates Bearer token against this plugin's bshaffer OAuth server.
	 *  - both (default): accepts either.
	 *
	 * @param WP_REST_Request $request Incoming request.
	 * @return true|WP_Error
	 */
	public static function check_permission( WP_REST_Request $request ) {
		MO_OAuth_Server_Debug::error_log( 'MCP Endpoint - Permission check started.' );

		if ( 'on' !== get_option( 'mo_oauth_server_mcp_enabled', 'off' ) ) {
			MO_OAuth_Server_Debug::error_log( 'MCP Endpoint - Permission check failed: MCP is disabled.' );
			return new WP_Error(
				'mcp_disabled',
				'MCP functionality is not enabled on this server.',
				array( 'status' => 403 )
			);
		}

		$auth_method = get_option( 'mo_oauth_server_mcp_auth_method', 'both' );
		MO_OAuth_Server_Debug::error_log( 'MCP Endpoint - Auth method configured: ' . $auth_method );

		// Application Password: WP core already resolved determine_current_user at priority 10.
		if ( in_array( $auth_method, array( 'application_password', 'both' ), true ) && is_user_logged_in() ) {
			MO_OAuth_Server_Debug::error_log( 'MCP Endpoint - Authenticated via WordPress Application Password. User ID: ' . get_current_user_id() );
			return true;
		}

		// OAuth 2.0 Bearer token issued by this plugin.
		if ( in_array( $auth_method, array( 'oauth', 'both' ), true ) ) {
			$auth_header = $request->get_header( 'authorization' );
			if ( $auth_header && 0 === strpos( $auth_header, 'Bearer ' ) ) {
				MO_OAuth_Server_Debug::error_log( 'MCP Endpoint - Bearer token found, verifying OAuth token.' );
				$user_id = self::verify_oauth_bearer();
				if ( $user_id ) {
					MO_OAuth_Server_Debug::error_log( 'MCP Endpoint - Authenticated via OAuth Bearer token. User ID: ' . $user_id );
					wp_set_current_user( $user_id );
					return true;
				}
				MO_OAuth_Server_Debug::error_log( 'MCP Endpoint - OAuth Bearer token verification failed.' );
			} else {
				MO_OAuth_Server_Debug::error_log( 'MCP Endpoint - No Bearer token found in Authorization header.' );
			}
		}

		MO_OAuth_Server_Debug::error_log( 'MCP Endpoint - Permission check failed: no valid credentials provided.' );
		return new WP_Error(
			'rest_forbidden',
			'Authentication required. Provide a valid OAuth 2.0 Bearer token or WordPress Application Password.',
			array( 'status' => 401 )
		);
	}

	/**
	 * Main request handler: parses JSON-RPC 2.0 body and dispatches to method handlers.
	 *
	 * @param WP_REST_Request $request Incoming request.
	 * @return WP_REST_Response
	 */
	public static function handle_request( WP_REST_Request $request ) {
		MO_OAuth_Server_Debug::error_log( 'MCP Endpoint - Request received.' );

		$raw_body = $request->get_body();

		if ( strlen( $raw_body ) > 1048576 ) {
			MO_OAuth_Server_Debug::error_log( 'MCP Endpoint - Request rejected: body size ' . strlen( $raw_body ) . ' bytes exceeds 1 MB limit.' );
			return self::rpc_error( null, self::ERR_INVALID_REQ, 'Request body exceeds 1 MB limit.' );
		}

		$body = json_decode( $raw_body, true );

		if ( JSON_ERROR_NONE !== json_last_error() ) {
			MO_OAuth_Server_Debug::error_log( 'MCP Endpoint - Request rejected: JSON parse error. Raw body: ' . $raw_body );
			return self::rpc_error( null, self::ERR_PARSE, 'JSON parse error.' );
		}

		if ( ! is_array( $body )
			|| ! isset( $body['jsonrpc'] ) || '2.0' !== $body['jsonrpc']
			|| ! isset( $body['method'] ) || ! is_string( $body['method'] )
		) {
			MO_OAuth_Server_Debug::error_log( 'MCP Endpoint - Request rejected: invalid JSON-RPC 2.0 envelope.' );
			MO_OAuth_Server_Debug::error_log( $body );
			return self::rpc_error( null, self::ERR_INVALID_REQ, 'Invalid JSON-RPC 2.0 request.' );
		}

		$id     = array_key_exists( 'id', $body ) ? $body['id'] : null;
		$method = $body['method'];
		$params = isset( $body['params'] ) && is_array( $body['params'] ) ? $body['params'] : array();

		MO_OAuth_Server_Debug::error_log( 'MCP Endpoint - Dispatching method: ' . $method . ' (id: ' . wp_json_encode( $id ) . ')' );

		switch ( $method ) {
			case 'initialize':
				return self::method_initialize( $id, $params );

			case 'tools/list':
				return self::method_tools_list( $id );

			case 'tools/call':
				return self::method_tools_call( $id, $params );

			case 'notifications/initialized':
				// MCP notification: client signals it received initialize response.
				// Notifications have no id and require no response body.
				MO_OAuth_Server_Debug::error_log( 'MCP Endpoint - notifications/initialized received (no response required).' );
				return self::rpc_success( $id, new \stdClass() );

			default:
				MO_OAuth_Server_Debug::error_log( 'MCP Endpoint - Unknown method: ' . $method );
				return self::rpc_error( $id, self::ERR_METHOD_UNKNOWN, 'Method not found: ' . $method );
		}
	}

	// -------------------------------------------------------------------------
	// JSON-RPC method handlers
	// -------------------------------------------------------------------------

	/**
	 * Handle MCP initialize: return server capabilities and protocol version.
	 *
	 * @param mixed $id     JSON-RPC request id.
	 * @param array $params Request params (may include protocolVersion).
	 * @return WP_REST_Response
	 */
	private static function method_initialize( $id, array $params ) {
		MO_OAuth_Server_Debug::error_log( 'MCP initialize - started.' );

		$client_version   = isset( $params['protocolVersion'] ) ? (string) $params['protocolVersion'] : '';
		$protocol_version = '' !== $client_version ? $client_version : self::MCP_VERSION;

		MO_OAuth_Server_Debug::error_log( 'MCP initialize - client version: "' . $client_version . '", negotiated: "' . $protocol_version . '"' );

		$result = array(
			'protocolVersion' => $protocol_version,
			'capabilities'    => array(
				'tools' => new \stdClass(),
			),
			'serverInfo'      => array(
				'name'    => 'miniOrange OAuth Server MCP',
				'version' => defined( 'MINIORANGE_OAUTH_20_SERVER_VERSION' ) ? MINIORANGE_OAUTH_20_SERVER_VERSION : '1.0.0',
			),
		);

		MO_OAuth_Server_Debug::error_log( 'MCP initialize - done.' );
		MO_OAuth_Server_Debug::error_log( $result );

		return self::rpc_success( $id, $result );
	}

	/**
	 * Handle MCP tools/list: return allowed abilities as MCP tool descriptors.
	 *
	 * @param mixed $id JSON-RPC request id.
	 * @return WP_REST_Response
	 */
	private static function method_tools_list( $id ) {
		MO_OAuth_Server_Debug::error_log( 'MCP tools/list - started.' );

		$tools = self::build_tools_list();

		MO_OAuth_Server_Debug::error_log( 'MCP tools/list - returning ' . count( $tools ) . ' tool(s).' );

		return self::rpc_success( $id, array( 'tools' => array_values( $tools ) ) );
	}

	/**
	 * Handle MCP tools/call: execute a WordPress ability and return its output.
	 *
	 * @param mixed $id     JSON-RPC request id.
	 * @param array $params Request params (name, arguments).
	 * @return WP_REST_Response
	 */
	private static function method_tools_call( $id, array $params ) {
		MO_OAuth_Server_Debug::error_log( 'MCP tools/call - started.' );

		$tool_name = isset( $params['name'] ) && is_string( $params['name'] )
			? sanitize_text_field( wp_unslash( $params['name'] ) )
			: '';

		$arguments = isset( $params['arguments'] ) && is_array( $params['arguments'] )
			? $params['arguments']
			: array();

		if ( '' === $tool_name ) {
			MO_OAuth_Server_Debug::error_log( 'MCP tools/call - failed: "name" parameter missing.' );
			return self::rpc_error( $id, self::ERR_INVALID_PARAMS, 'tools/call: "name" parameter is required.' );
		}

		MO_OAuth_Server_Debug::error_log( 'MCP tools/call - tool: ' . $tool_name );
		MO_OAuth_Server_Debug::error_log( 'MCP tools/call - arguments: ' );
		MO_OAuth_Server_Debug::error_log( $arguments );

		if ( ! function_exists( 'wp_get_abilities' ) ) {
			MO_OAuth_Server_Debug::error_log( 'MCP tools/call - failed: WordPress Abilities API not available.' );
			return self::rpc_error( $id, self::ERR_INTERNAL, 'WordPress Abilities API is unavailable on this server.' );
		}

		// Resolve MCP tool name (underscores) back to WP ability slug (slash-separated).
		$ability_slug = null;
		foreach ( wp_get_abilities() as $ab ) {
			if ( is_object( $ab ) && method_exists( $ab, 'get_name' )
				&& self::ability_slug_to_mcp_name( $ab->get_name() ) === $tool_name
			) {
				$ability_slug = $ab->get_name();
				break;
			}
		}

		if ( null === $ability_slug ) {
			MO_OAuth_Server_Debug::error_log( 'MCP tools/call - failed: no ability found matching tool name "' . $tool_name . '"' );
			return self::rpc_error( $id, self::ERR_METHOD_UNKNOWN, 'Tool not found: ' . esc_html( $tool_name ) );
		}

		MO_OAuth_Server_Debug::error_log( 'MCP tools/call - resolved ability slug: ' . $ability_slug );

		// Enforce admin-configured allowlist.
		$allowed = self::get_allowed_slugs();
		if ( ! in_array( $ability_slug, $allowed, true ) ) {
			MO_OAuth_Server_Debug::error_log( 'MCP tools/call - failed: ability "' . $ability_slug . '" is not in the allowed list.' );
			return self::rpc_error( $id, self::ERR_ACCESS_DENIED, 'This tool is not enabled on this MCP server.' );
		}

		// Verify the ability is currently registered.
		$ability = wp_get_ability( $ability_slug );
		if ( ! $ability ) {
			MO_OAuth_Server_Debug::error_log( 'MCP tools/call - failed: ability "' . $ability_slug . '" is not registered.' );
			return self::rpc_error( $id, self::ERR_METHOD_UNKNOWN, 'Ability not registered: ' . esc_html( $ability_slug ) );
		}

		// Preserve the current WP user across the execute() call in case execute() mutates it.
		$prev_user_id = get_current_user_id();
		$output       = null;
		$is_error     = false;

		MO_OAuth_Server_Debug::error_log( 'MCP tools/call - executing ability "' . $ability_slug . '" as user ID ' . $prev_user_id );

		try {
			$input_schema = $ability->get_input_schema();
			if ( empty( $input_schema ) ) {
				$output = $ability->execute();
			} else {
				$output = $ability->execute( $arguments );
			}

			if ( is_wp_error( $output ) ) {
				$is_error = true;
				$error_message = $output->get_error_message();
				MO_OAuth_Server_Debug::error_log( 'MCP tools/call - ability returned WP_Error: ' . $error_message );
				$output = array( 'error' => $error_message );
			} else {
				MO_OAuth_Server_Debug::error_log( 'MCP tools/call - ability executed successfully.' );
				MO_OAuth_Server_Debug::error_log( $output );
			}
		} catch ( Exception $e ) {
			$is_error = true;
			$output   = array( 'error' => 'Internal server error during ability execution.' );
			MO_OAuth_Server_Debug::error_log( 'MCP tools/call - exception during ability execution: ' . $e->getMessage() );
		} finally {
			wp_set_current_user( $prev_user_id );
		}

		MO_OAuth_Server_Debug::error_log( 'MCP tools/call - done. isError: ' . ( $is_error ? 'true' : 'false' ) );

		return self::rpc_success(
			$id,
			array(
				'content' => array(
					array(
						'type' => 'text',
						'text' => wp_json_encode( $output ),
					),
				),
				'isError' => $is_error,
			)
		);
	}

	// -------------------------------------------------------------------------
	// Internal helpers
	// -------------------------------------------------------------------------

	/**
	 * Build the MCP tools array from the admin-configured allowed abilities.
	 * Caps at MAX_TOOLS to stay within ChatGPT's tool limit.
	 *
	 * @return array MCP tool descriptors.
	 */
	private static function build_tools_list() {
		if ( ! function_exists( 'wp_get_abilities' ) ) {
			MO_OAuth_Server_Debug::error_log( 'MCP tools/list - WordPress Abilities API not available, returning empty list.' );
			return array();
		}

		$allowed = self::get_allowed_slugs();
		MO_OAuth_Server_Debug::error_log( 'MCP tools/list - allowed slugs count: ' . count( $allowed ) );

		$tools = array();

		foreach ( wp_get_abilities() as $ability ) {
			if ( ! is_object( $ability ) || ! method_exists( $ability, 'get_name' ) ) {
				continue;
			}

			$slug = $ability->get_name();

			if ( ! in_array( $slug, $allowed, true ) ) {
				continue;
			}

			$input_schema = $ability->get_input_schema();
			if ( empty( $input_schema ) || ! is_array( $input_schema ) ) {
				$input_schema = array(
					'type'       => 'object',
					'properties' => new \stdClass(),
				);
			}

			$tools[] = array(
				'name'        => self::ability_slug_to_mcp_name( $slug ),
				'description' => method_exists( $ability, 'get_description' ) ? (string) $ability->get_description() : '',
				'inputSchema' => $input_schema,
			);

			if ( count( $tools ) >= self::MAX_TOOLS ) {
				MO_OAuth_Server_Debug::error_log( 'MCP tools/list - tool list capped at MAX_TOOLS (' . self::MAX_TOOLS . ').' );
				break;
			}
		}

		return $tools;
	}

	/**
	 * Resolve the set of ability slugs this MCP server is allowed to expose.
	 * An empty admin configuration means "all registered abilities".
	 *
	 * @return string[] Ability slugs.
	 */
	private static function get_allowed_slugs() {
		if ( ! function_exists( 'wp_get_abilities' ) ) {
			return array();
		}

		$available = array();
		foreach ( wp_get_abilities() as $a ) {
			if ( is_object( $a ) && method_exists( $a, 'get_name' ) ) {
				$available[] = $a->get_name();
			}
		}

		$configured = get_option( 'mo_oauth_server_mcp_allowed_abilities', array() );

		if ( empty( $configured ) || ! is_array( $configured ) ) {
			return $available;
		}

		return array_values( array_intersect( $available, $configured ) );
	}

	/**
	 * Convert a WP ability slug to a valid MCP tool name.
	 *
	 * MCP requires tool names matching ^[a-zA-Z0-9_-]{1,64}$.
	 * WP ability slugs use '/' as a namespace separator (e.g. moaiagent/create-post).
	 * Replacing '/' with '_' gives a compliant name that is trivially reversible.
	 *
	 * @param string $slug WP ability slug.
	 * @return string MCP-compliant tool name.
	 */
	private static function ability_slug_to_mcp_name( $slug ) {
		return str_replace( '/', '_', $slug );
	}

	/**
	 * Validate an OAuth 2.0 Bearer token using the plugin's bshaffer storage.
	 * Mirrors the logic in Miniorange_Oauth_20_Server_Public::mo_oauth_server_resource().
	 *
	 * @return int|false WordPress user ID on success, false on failure.
	 */
	private static function verify_oauth_bearer() {
		MO_OAuth_Server_Debug::error_log( 'MCP OAuth Bearer - verification started.' );

		// Guard: bshaffer classes are loaded by the public class on every request.
		if ( ! class_exists( 'OAuth2\Storage\MoPdo' ) || ! class_exists( 'OAuth2\Server' ) ) {
			MO_OAuth_Server_Debug::error_log( 'MCP OAuth Bearer - failed: bshaffer OAuth2 classes not loaded.' );
			return false;
		}

		$sqlite_file = MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'data' . DIRECTORY_SEPARATOR . 'oauth.sqlite';
		if ( ! file_exists( $sqlite_file ) ) {
			MO_OAuth_Server_Debug::error_log( 'MCP OAuth Bearer - failed: SQLite token store not found at ' . $sqlite_file );
			return false;
		}

		try {
			$storage  = new \OAuth2\Storage\MoPdo( array( 'dsn' => 'sqlite:' . $sqlite_file ) );
			$server   = new \OAuth2\Server(
				$storage,
				array(
					'access_lifetime' => (int) get_option( 'mo_oauth_expiry_time', 3600 ),
				)
			);
			$request  = \OAuth2\Request::createFromGlobals();
			$response = new \OAuth2\Response();

			if ( ! $server->verifyResourceRequest( $request, $response ) ) {
				MO_OAuth_Server_Debug::error_log( 'MCP OAuth Bearer - token verification failed.' );
				MO_OAuth_Server_Debug::error_log( $response->getParameters() );
				return false;
			}

			$token_data = $server->getAccessTokenData( $request, $response );
			MO_OAuth_Server_Debug::error_log( 'MCP OAuth Bearer - token valid. User ID: ' . ( isset( $token_data['user_id'] ) ? $token_data['user_id'] : 'null' ) );

			return ( isset( $token_data['user_id'] ) && $token_data['user_id'] )
				? (int) $token_data['user_id']
				: false;
		} catch ( Exception $e ) {
			MO_OAuth_Server_Debug::error_log( 'MCP OAuth Bearer - exception: ' . $e->getMessage() );
			return false;
		}
	}

	/**
	 * Build a JSON-RPC 2.0 success response.
	 *
	 * @param mixed $id     Request id (null for notifications).
	 * @param mixed $result Result payload.
	 * @return WP_REST_Response
	 */
	private static function rpc_success( $id, $result ) {
		return new WP_REST_Response(
			array(
				'jsonrpc' => '2.0',
				'id'      => $id,
				'result'  => $result,
			),
			200
		);
	}

	/**
	 * Build a JSON-RPC 2.0 error response.
	 *
	 * @param mixed  $id      Request id.
	 * @param int    $code    JSON-RPC error code.
	 * @param string $message Human-readable error message.
	 * @return WP_REST_Response
	 */
	private static function rpc_error( $id, $code, $message ) {
		return new WP_REST_Response(
			array(
				'jsonrpc' => '2.0',
				'id'      => $id,
				'error'   => array(
					'code'    => $code,
					'message' => $message,
				),
			),
			200
		);
	}
}

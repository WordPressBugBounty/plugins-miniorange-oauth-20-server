<?php
/**
 * Class that defines various constants used through out the plugin.
 *
 * @package Miniorange_Oauth_20_Server/admin/helper/constants
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// phpcs:disable Generic.Files.OneObjectStructurePerFile.MultipleFound -- Disabling this to define multiple constant classes in the same file.

/**
 * This class defines various constants used through
 * out the plugin.
 */
final class Miniorange_Oauth_20_Server_Oauth_Constants {
	const QUERY_SUBMITTED    = 'Query submitted.';
	const DENY_AUTHORIZATION = 'Authorization was denied by the user.';
	const PRICING_PLAN_URL   = 'https://plugins.miniorange.com/wp-oauth-server#pricing';
	const ERROR_LOGS_DIR     = 'miniorange-oauth-20-server/error-logs/';
}

/**
 * Defines OAuth Client Types.
 */
class Mo_Oauth_Client_Types {
	const OAUTH2         = 'oauth2';
	const OPENID_CONNECT = 'openidconnect';
	const OAUTH1         = 'oauth1';
}

/**
 * Defines OAuth Client Keys.
 */
class Mo_Oauth_Client_Keys {
	const INVISION_COMMUNITY = 'invisionCommunity';
	const ROCKET_CHAT        = 'rocketChat';
	const HUBSPOT            = 'hubspot';
	const OAUTH2             = 'oauth2';
	const OPENID_CONNECT     = 'openidconnect';
	const ODOO               = 'odoo';
	const WORDPRESS          = 'wordpress';
	const CIRCLE             = 'circle';
	const SERVICE_NOW        = 'serviceNow';
	const AZURE              = 'azure';
	const BUBBLE             = 'bubble';
	const TALENT_LMS         = 'talentLms';
	const REACT              = 'react';
	const SHINY_PROXY        = 'shinyProxy';
	const CANVAS             = 'canvas';
	const CONFERENCES_IO     = 'conferences.io';
	const WICKR              = 'wickr';
	const POWER_SCHOOL       = 'powerSchool';
	const FRESHDESK          = 'freshdesk';
	const SALESFORCE         = 'salesforce';
	const EASY_GENERATOR     = 'easyGenerator';
	const ACADEMY_OF_MINE    = 'academyOfMine';
	const CHURCH_ONLINE      = 'churchOnline';
	const MALTEGO            = 'maltego';
	const ASP_NET            = 'asp.net';
	const AWS_COGNITO        = 'awsCognito';
	const WSO2               = 'wso2';
	const KNACK              = 'knack';
	const MOBILIZE           = 'mobilize';
	const NEXT_CLOUD         = 'nextCloud';
	const TRIBE              = 'tribe';
	const ZAPIER             = 'zapier';
	const OPEN_EDX_EDU_NEXT  = 'openEdxEduNext';
	const VENDASTA           = 'vendasta';
	const MOODLE             = 'moodle';
	const MAGENTO            = 'magento';
	const SHOPIFY            = 'shopify';
	const ZERO_TIER          = 'zeroTier';
	const EVENT_MOBI         = 'eventMobi';
	const PIMCORE            = 'pimcore';
	const HIGHER_LOGIC       = 'higherLogic';
	const LEARNING_360       = '360Learning';
	const SYNOLOGY           = 'synology';
	const BOOKSTACK          = 'bookstack';

	// AI MCP clients.
	const CLAUDE         = 'claude';
	const CHATGPT        = 'chatgpt';
	const CURSOR         = 'cursor';
	const WINDSURF       = 'windsurf';
	const GENERIC_AI_MCP = 'genericAiMcp';
}

/**
 * Defines Field Labels.
 */
class Mo_Oauth_Field_Labels {
	const REDIRECT_URI  = 'redirect_uri';
	const CLIENT_ID     = 'client_id_label';
	const CLIENT_SECRET = 'client_secret_label';
	const AUTHORIZE_URL = 'authorize_url_label';
	const TOKEN_URL     = 'token_url_label';
	const USERINFO_URL  = 'userinfo_url_label';
	const ISSUER_URL    = 'issuer_url_label';
	const DISCOVERY_URL = 'discovery_url_label';
	const JWKS_URL      = 'jwks_url_label';
	const WP_URL        = 'wp_url_label';
	const SCOPES        = 'scopes_label';
}

/**
 * Defines Redirect URI Labels.
 */
class Mo_Oauth_Redirect_Uri_Labels {
	const AUTHORIZED              = 'Authorized Redirect URI';
	const AUTHORIZED_REDIRECT_URL = 'Authorized redirect URL';
	const CALLBACK                = 'Callback URL';
	const REDIRECT                = 'Redirect URI';
	const REDIRECT_CALLBACK_URI   = 'Redirect/Callback URI';
	const REDIRECT_CALLBACK_URL   = 'Redirect/Callback URL';
	const CALLBACK_REDIRECT_URI   = 'Callback/Redirect URI';
	const OAUTH_CALLBACK          = 'OAuth Callback URL';
	const OAUTH_REDIRECT          = 'OAuth Redirect URI';
}

/**
 * Defines Client ID Labels.
 */
class Mo_Oauth_Client_Id_Labels {
	const CLIENT_ID         = 'Client ID';
	const CLIENT_IDENTIFIER = 'Client Identifier';
	const ID                = 'Id';
	const CLIENT_KEY        = 'Client Key';
	const CONSUMER_KEY      = 'Consumer Key';
	const APP_ID            = 'App ID';
	const APPLICATION_ID    = 'Application ID';
	const OIDC_CLIENT_ID    = 'OIDC Client ID';
}

/**
 * Defines Client Secret Labels.
 */
class Mo_Oauth_Client_Secret_Labels {
	const CLIENT_SECRET      = 'Client Secret';
	const SECRET             = 'Secret';
	const CONSUMER_SECRET    = 'Consumer Secret';
	const APP_SECRET         = 'App Secret';
	const APPLICATION_KEY    = 'Application Key';
	const OIDC_CLIENT_SECRET = 'OIDC Client Secret';
}

/**
 * Defines Authorization URL Labels.
 */
class Mo_Oauth_Authorization_Url_Labels {
	const AUTHORIZATION_ENDPOINT       = 'Authorization Endpoint';
	const AUTHORIZE_ENDPOINT           = 'authorize_endpoint';
	const AUTHORIZE_PATH               = 'Authorize Path';
	const AUTHORIZE_ENDPOINT_URL       = 'Authorization Endpoint URL';
	const AUTHORIZE_URL                = 'Authorization URL';
	const OAUTH_AUTHORIZATION_ENDPOINT = 'OAuth Authorization Endpoint';
}

/**
 * Defines Token URL Labels.
 */
class Mo_Oauth_Token_Url_Labels {
	const TOKEN_ENDPOINT           = 'Token Endpoint';
	const TOKEN_ENDPOINT_LOWERCASE = 'token_endpoint';
	const TOKEN_PATH               = 'Token Path';
	const TOKEN_ENDPOINT_URL       = 'Token Endpoint URL';
	const TOKEN_URL                = 'Token URL';
	const ACCESS_TOKEN_ENDPOINT    = 'Access Token Endpoint';
	const ACCESS_TOKEN_URL         = 'Access Token URL';
	const ACCESS_TOKEN_REQUEST     = 'Access Token Request';
	const OAUTH_TOKEN_ENDPOINT     = 'OAuth Token Endpoint';
}

/**
 * Defines Userinfo URL Labels.
 */
class Mo_Oauth_Userinfo_Url_Labels {
	const USERINFO_ENDPOINT            = 'Userinfo Endpoint';
	const USER_INFO_ENDPOINT           = 'User info Endpoint';
	const RESOURCE_ENDPOINT            = 'resource_endpoint';
	const IDENTITY_PATH                = 'Identity Path';
	const USERINFO_ENDPOINT_URL        = 'Userinfo Endpoint URL';
	const USERINFO_URL                 = 'Userinfo URL';
	const GET_USER_INFO_ENDPOINT       = 'Get User Info Endpoint';
	const USER_INFO_URL                = 'User Info URL';
	const USER_INFO_ENDPOINT_URL       = 'User Info Endpoint URL';
	const OAUTH_GET_USER_INFO_ENDPOINT = 'OAuth Get User Info Endpoint';
}

/**
 * Defines Issuer URL Labels.
 */
class Mo_Oauth_Issuer_Url_Labels {
	const ISSUER          = 'Issuer';
	const ISSUER_ENDPOINT = 'issuer_endpoint';
	const ISSUER_URI      = 'Issuer URI';
	const OIDC_ISSUER     = 'OIDC Issuer';
}

/**
 * Defines Discovery URL Labels.
 */
class Mo_Oauth_Discovery_Url_Labels {
	const DISCOVERY_ENDPOINT           = 'Discovery Endpoint';
	const DISCOVERY_ENDPOINT_LOWERCASE = 'discovery_endpoint';
	const WELLKNOWN_URL                = 'Wellknown URL';
}

/**
 * Defines JWKS URL Labels.
 */
class Mo_Oauth_Jwks_Url_Labels {
	const JWKS_ENDPOINT                   = 'JWKS Endpoint';
	const JWKS_ENDPOINT_LOWERCASE         = 'jwks_endpoint';
	const JWKS_URL                        = 'JWKS URL';
	const IDENTITY_PROVIDER_JWKS_ENDPOINT = "Identity Provider's JWKS Endpoint";
}

/**
 * Defines WordPress URL Labels.
 */
class Mo_Oauth_Wp_Url_Labels {
	const WORDPRESS_URL = 'WordPress URL';
}

/**
 * Defines Scopes Labels.
 */
class Mo_Oauth_Scopes_Labels {
	const SCOPE                            = 'Scope';
	const SCOPES                           = 'Scopes';
	const AUTHORIZE_SCOPE                  = 'Authorize scope';
	const AUTHORIZATION_SCOPE              = 'Authorization Scope';
	const SCOPES_INCLUDED_IN_LOGIN_REQUEST = 'Scopes included in a login request';
}

/**
 * Defines OAuth Client Configuration.
 */
class Mo_Oauth_Client_Configuration {
	/**
	 * Get all OAuth client configurations.
	 *
	 * @return array
	 */
	public static function get_all_client_configurations() {
		return array(
			Mo_Oauth_Client_Keys::INVISION_COMMUNITY => array(
				'label'               => 'Invision Community',
				'type'                => Mo_Oauth_Client_Types::OAUTH2,
				'image'               => 'Invision-Community.png',
				'redirect_uri'        => Mo_Oauth_Redirect_Uri_Labels::AUTHORIZED,
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::CLIENT_IDENTIFIER,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::AUTHORIZATION_ENDPOINT,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::TOKEN_ENDPOINT,
				'userinfo_url_label'  => '',
				'issuer_url_label'    => '',
				'discovery_url_label' => '',
				'jwks_url_label'      => '',
				'wp_url_label'        => Mo_Oauth_Wp_Url_Labels::WORDPRESS_URL,
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPE,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::WP_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'doc'                 => 'https://invisioncommunity.com/developers/docs/api/authentication/oauth-r953/',
				'setup_guide'         => 'https://plugins.miniorange.com/guide-to-configure-invision-community-oauth-client',
			),
			Mo_Oauth_Client_Keys::ROCKET_CHAT        => array(
				'label'               => 'Rocket Chat',
				'type'                => Mo_Oauth_Client_Types::OAUTH2,
				'image'               => 'Rocket-Chat.png',
				'redirect_uri'        => Mo_Oauth_Redirect_Uri_Labels::CALLBACK,
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::AUTHORIZE_PATH,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::TOKEN_PATH,
				'userinfo_url_label'  => Mo_Oauth_Userinfo_Url_Labels::IDENTITY_PATH,
				'issuer_url_label'    => '',
				'discovery_url_label' => '',
				'jwks_url_label'      => '',
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPE,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
					Mo_Oauth_Field_Labels::USERINFO_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'additional_settings' => array(
					'Identity Token Sent Via' => 'Header',
					'Server Type'             => 'Custom',
				),
				'doc'                 => 'https://docs.rocket.chat/guides/developer/authentication/oauth',
				'link'                => 'https://docs.rocket.chat/use-rocket.chat/workspace-administration/settings/oauth/wordpress',
				'setup_guide'         => 'https://plugins.miniorange.com/guide-to-configure-rocket-chat-oauth-client',
			),
			Mo_Oauth_Client_Keys::HUBSPOT            => array(
				'label'               => 'HubSpot',
				'type'                => Mo_Oauth_Client_Types::OAUTH2,
				'image'               => 'hubspot.png',
				'redirect_uri'        => Mo_Oauth_Redirect_Uri_Labels::CALLBACK,
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::AUTHORIZATION_ENDPOINT,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::TOKEN_ENDPOINT,
				'userinfo_url_label'  => Mo_Oauth_Userinfo_Url_Labels::USERINFO_ENDPOINT,
				'issuer_url_label'    => '',
				'discovery_url_label' => '',
				'jwks_url_label'      => '',
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPES,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
					Mo_Oauth_Field_Labels::USERINFO_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'setup_guide'         => 'https://plugins.miniorange.com/single-sign-on-into-hubspot-using-wordpress',
			),
			Mo_Oauth_Client_Keys::OAUTH2             => array(
				'label'               => 'Custom OAuth Client',
				'type'                => Mo_Oauth_Client_Types::OAUTH2,
				'image'               => 'oauth2.png',
				'redirect_uri'        => Mo_Oauth_Redirect_Uri_Labels::REDIRECT,
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::AUTHORIZATION_ENDPOINT,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::TOKEN_ENDPOINT,
				'userinfo_url_label'  => Mo_Oauth_Userinfo_Url_Labels::USERINFO_ENDPOINT,
				'issuer_url_label'    => '',
				'discovery_url_label' => '',
				'jwks_url_label'      => '',
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPE,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
					Mo_Oauth_Field_Labels::USERINFO_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'doc'                 => 'https://plugins.miniorange.com/step-by-step-guide-for-wordpress-oauth-server',
				'setup_guide'         => 'https://plugins.miniorange.com/step-by-step-guide-for-wordpress-oauth-server',
			),
			Mo_Oauth_Client_Keys::OPENID_CONNECT     => array(
				'label'               => 'Custom OpenID Connect Client',
				'type'                => Mo_Oauth_Client_Types::OPENID_CONNECT,
				'image'               => 'openid.png',
				'redirect_uri'        => Mo_Oauth_Redirect_Uri_Labels::REDIRECT,
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::AUTHORIZATION_ENDPOINT,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::TOKEN_ENDPOINT,
				'userinfo_url_label'  => Mo_Oauth_Userinfo_Url_Labels::USERINFO_ENDPOINT,
				'issuer_url_label'    => Mo_Oauth_Issuer_Url_Labels::ISSUER,
				'discovery_url_label' => Mo_Oauth_Discovery_Url_Labels::DISCOVERY_ENDPOINT,
				'jwks_url_label'      => Mo_Oauth_Jwks_Url_Labels::JWKS_ENDPOINT,
				'wp_url_label'        => Mo_Oauth_Wp_Url_Labels::WORDPRESS_URL,
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPE,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::ISSUER_URL,
					Mo_Oauth_Field_Labels::DISCOVERY_URL,
					Mo_Oauth_Field_Labels::JWKS_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'doc'                 => 'https://plugins.miniorange.com/step-by-step-guide-for-wordpress-oauth-server',
				'setup_guide'         => 'https://plugins.miniorange.com/step-by-step-guide-for-wordpress-oauth-server',
			),
			Mo_Oauth_Client_Keys::WORDPRESS          => array(
				'label'               => 'WordPress',
				'type'                => Mo_Oauth_Client_Types::OAUTH2,
				'image'               => 'WordPress.png',
				'redirect_uri'        => Mo_Oauth_Redirect_Uri_Labels::REDIRECT,
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::AUTHORIZATION_ENDPOINT,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::TOKEN_ENDPOINT,
				'userinfo_url_label'  => Mo_Oauth_Userinfo_Url_Labels::USERINFO_ENDPOINT,
				'issuer_url_label'    => '',
				'discovery_url_label' => '',
				'jwks_url_label'      => '',
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPES,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
					Mo_Oauth_Field_Labels::USERINFO_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'doc'                 => 'https://developer.wordpress.com/docs/oauth2/',
				'setup_guide'         => 'https://plugins.miniorange.com/guide-to-setup-single-sign-on-between-two-wordpress-sites',
			),
			Mo_Oauth_Client_Keys::ODOO               => array(
				'label'               => 'Odoo',
				'type'                => Mo_Oauth_Client_Types::OAUTH2,
				'image'               => 'Odoo.png',
				'redirect_uri'        => Mo_Oauth_Redirect_Uri_Labels::REDIRECT,
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::AUTHORIZE_ENDPOINT,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::ACCESS_TOKEN_ENDPOINT,
				'userinfo_url_label'  => Mo_Oauth_Userinfo_Url_Labels::GET_USER_INFO_ENDPOINT,
				'issuer_url_label'    => '',
				'discovery_url_label' => '',
				'jwks_url_label'      => '',
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPES,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
					Mo_Oauth_Field_Labels::USERINFO_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'doc'                 => 'https://www.odoo.com/documentation/15.0/howtos/backend-dev/oauth.html',
				'setup_guide'         => 'https://www.miniorange.com/single-sign-on-(sso)-for-odoo',
			),
			Mo_Oauth_Client_Keys::CIRCLE             => array(
				'label'               => 'Circle',
				'type'                => Mo_Oauth_Client_Types::OAUTH2,
				'image'               => 'Circle.png',
				'redirect_uri'        => Mo_Oauth_Redirect_Uri_Labels::REDIRECT,
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::AUTHORIZATION_ENDPOINT,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::TOKEN_ENDPOINT,
				'userinfo_url_label'  => Mo_Oauth_Userinfo_Url_Labels::USERINFO_ENDPOINT,
				'issuer_url_label'    => '',
				'discovery_url_label' => '',
				'jwks_url_label'      => '',
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPES,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
					Mo_Oauth_Field_Labels::USERINFO_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'doc'                 => 'https://circleci.com/docs/api/v2/#tag/Authentication',
				'setup_guide'         => 'https://plugins.miniorange.com/single-sign-on-sso-for-circle-using-wordpress-as-oauth-server',
			),
			Mo_Oauth_Client_Keys::SERVICE_NOW        => array(
				'label'               => 'ServiceNow',
				'type'                => Mo_Oauth_Client_Types::OAUTH2,
				'image'               => 'ServiceNow.png',
				'redirect_uri'        => Mo_Oauth_Redirect_Uri_Labels::REDIRECT,
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::AUTHORIZATION_ENDPOINT,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::TOKEN_ENDPOINT,
				'userinfo_url_label'  => Mo_Oauth_Userinfo_Url_Labels::USERINFO_ENDPOINT,
				'issuer_url_label'    => '',
				'discovery_url_label' => '',
				'jwks_url_label'      => '',
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPES,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
					Mo_Oauth_Field_Labels::USERINFO_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'doc'                 => 'https://developer.servicenow.com/dev.do#!/rest_api_doc?v=newyork&topicurl=oauth2_getting_started',
				'setup_guide'         => 'https://plugins.miniorange.com/single-sign-on-sso-for-servicenow-using-wordpress-as-oauth-server',
			),
			Mo_Oauth_Client_Keys::AZURE              => array(
				'label'               => 'Microsoft Azure B2C',
				'type'                => Mo_Oauth_Client_Types::OAUTH2,
				'image'               => 'Azure.png',
				'redirect_uri'        => Mo_Oauth_Redirect_Uri_Labels::REDIRECT,
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::AUTHORIZATION_ENDPOINT,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::TOKEN_ENDPOINT,
				'userinfo_url_label'  => Mo_Oauth_Userinfo_Url_Labels::USER_INFO_ENDPOINT,
				'issuer_url_label'    => '',
				'discovery_url_label' => '',
				'jwks_url_label'      => '',
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPES,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
				),
				'doc'                 => 'https://docs.microsoft.com/en-us/azure/active-directory/develop/v2-oauth2-auth-code-flow',
				'setup_guide'         => 'https://plugins.miniorange.com/azure-b2c-sso-using-wordpress-as-openid-connect-server',
			),
			Mo_Oauth_Client_Keys::BUBBLE             => array(
				'label'               => 'Bubble.io',
				'type'                => Mo_Oauth_Client_Types::OAUTH2,
				'image'               => 'Bubble.png',
				'redirect_uri'        => Mo_Oauth_Redirect_Uri_Labels::REDIRECT,
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::AUTHORIZATION_ENDPOINT,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::TOKEN_ENDPOINT,
				'userinfo_url_label'  => Mo_Oauth_Userinfo_Url_Labels::USERINFO_ENDPOINT,
				'issuer_url_label'    => '',
				'discovery_url_label' => '',
				'jwks_url_label'      => '',
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPES,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
				),
				'doc'                 => 'https://manual.bubble.io/help-guides/working-with-users/authentication/oauth2-authentication',
				'setup_guide'         => 'https://plugins.miniorange.com/bubble-io-sso-using-wordpress-as-openid-connect-server',
			),
			Mo_Oauth_Client_Keys::TALENT_LMS         => array(
				'label'               => 'TalentLMS',
				'type'                => Mo_Oauth_Client_Types::OPENID_CONNECT,
				'image'               => 'TalentLMS.png',
				'redirect_uri'        => Mo_Oauth_Redirect_Uri_Labels::AUTHORIZED_REDIRECT_URL,
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::AUTHORIZATION_ENDPOINT,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::TOKEN_ENDPOINT,
				'userinfo_url_label'  => Mo_Oauth_Userinfo_Url_Labels::USERINFO_ENDPOINT,
				'issuer_url_label'    => '',
				'discovery_url_label' => '',
				'jwks_url_label'      => '',
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPES,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
					Mo_Oauth_Field_Labels::USERINFO_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'doc'                 => 'https://www.talentlms.com/pages/docs/TalentLMS-Integration-OAuth2/index.html',
				'setup_guide'         => 'https://plugins.miniorange.com/talentlms-sso-using-wordpress-as-openid-connect-server',
			),
			Mo_Oauth_Client_Keys::REACT              => array(
				'label'               => 'React',
				'type'                => Mo_Oauth_Client_Types::OAUTH2,
				'image'               => 'React.png',
				'redirect_uri'        => '{callback_url}',
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::AUTHORIZATION_ENDPOINT,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::TOKEN_ENDPOINT,
				'userinfo_url_label'  => '',
				'issuer_url_label'    => '',
				'discovery_url_label' => '',
				'jwks_url_label'      => '',
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPE,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
				),
				'doc'                 => 'https://auth0.com/docs/protocols/oauth2/oauth-state/react',
				'setup_guide'         => 'https://plugins.miniorange.com/react-js-sso-using-wordpress-as-openid-connect-server',
			),
			Mo_Oauth_Client_Keys::SHINY_PROXY        => array(
				'label'               => 'ShinyProxy',
				'type'                => Mo_Oauth_Client_Types::OAUTH2,
				'image'               => 'ShinyProxy.png',
				'redirect_uri'        => '{callback_url}',
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::AUTHORIZATION_ENDPOINT,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::TOKEN_ENDPOINT,
				'userinfo_url_label'  => '',
				'issuer_url_label'    => '',
				'discovery_url_label' => '',
				'jwks_url_label'      => Mo_Oauth_Jwks_Url_Labels::JWKS_URL,
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPES,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
					Mo_Oauth_Field_Labels::JWKS_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'doc'                 => 'https://www.shinyproxy.io/docs/configure-oauth2/',
				'setup_guide'         => 'https://plugins.miniorange.com/shinyproxy-single-sign-on-sso-with-wordpress-as-oauth-server',
			),
			Mo_Oauth_Client_Keys::CANVAS             => array(
				'label'               => 'Canvas',
				'type'                => Mo_Oauth_Client_Types::OPENID_CONNECT,
				'image'               => 'Canvas.png',
				'redirect_uri'        => Mo_Oauth_Redirect_Uri_Labels::REDIRECT_CALLBACK_URI,
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::AUTHORIZATION_ENDPOINT,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::TOKEN_URL,
				'userinfo_url_label'  => Mo_Oauth_Userinfo_Url_Labels::USERINFO_ENDPOINT,
				'issuer_url_label'    => '',
				'discovery_url_label' => '',
				'jwks_url_label'      => '',
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPE,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'doc'                 => 'https://canvas.instructure.com/doc/api/file.oauth_endpoints.html',
				'setup_guide'         => 'https://plugins.miniorange.com/canvas-single-sign-on-sso-with-wordpress-as-oauth-server',
			),
			Mo_Oauth_Client_Keys::CONFERENCES_IO     => array(
				'label'               => 'Conferences.io',
				'type'                => Mo_Oauth_Client_Types::OAUTH2,
				'image'               => 'Conferences.png',
				'redirect_uri'        => '{callback_url}',
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::AUTHORIZATION_ENDPOINT,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::TOKEN_ENDPOINT,
				'userinfo_url_label'  => '',
				'issuer_url_label'    => '',
				'discovery_url_label' => '',
				'jwks_url_label'      => '',
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPE,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'doc'                 => 'https://conferences.io/docs/api/authentication',
				'setup_guide'         => 'https://plugins.miniorange.com/single-sign-on-for-conferences-io-using-wordpress-oauth-server',
			),
			Mo_Oauth_Client_Keys::WICKR              => array(
				'label'               => 'Wickr',
				'type'                => Mo_Oauth_Client_Types::OAUTH2,
				'image'               => 'Wickr.png',
				'redirect_uri'        => Mo_Oauth_Redirect_Uri_Labels::REDIRECT,
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::AUTHORIZATION_ENDPOINT,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::TOKEN_ENDPOINT,
				'userinfo_url_label'  => '',
				'issuer_url_label'    => '',
				'discovery_url_label' => '',
				'jwks_url_label'      => '',
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPE,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
				),
				'doc'                 => 'https://wickrinc.github.io/wickr-openapi/#section/Authentication',
				'setup_guide'         => 'https://plugins.miniorange.com/single-sign-on-sso-for-wickr-using-wordpress-as-oauth-server',
			),
			Mo_Oauth_Client_Keys::POWER_SCHOOL       => array(
				'label'               => 'PowerSchool OAuth2',
				'type'                => Mo_Oauth_Client_Types::OAUTH2,
				'image'               => 'PowerSchool.png',
				'redirect_uri'        => Mo_Oauth_Redirect_Uri_Labels::REDIRECT,
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::AUTHORIZATION_ENDPOINT,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::TOKEN_ENDPOINT,
				'userinfo_url_label'  => Mo_Oauth_Userinfo_Url_Labels::USERINFO_ENDPOINT,
				'issuer_url_label'    => '',
				'discovery_url_label' => '',
				'jwks_url_label'      => '',
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPE,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
				),
				'doc'                 => 'https://support.powerschool.com/developer/authentication/',
				'setup_guide'         => 'https://plugins.miniorange.com/powerschool-sis-sso-using-wordpress-as-openid-connect-server',
			),
			Mo_Oauth_Client_Keys::FRESHDESK          => array(
				'label'               => 'Freshdesk OAuth2',
				'type'                => Mo_Oauth_Client_Types::OAUTH2,
				'image'               => 'Freshdesk.png',
				'redirect_uri'        => Mo_Oauth_Redirect_Uri_Labels::REDIRECT,
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::AUTHORIZE_URL,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::ACCESS_TOKEN_URL,
				'userinfo_url_label'  => Mo_Oauth_Userinfo_Url_Labels::USERINFO_URL,
				'issuer_url_label'    => '',
				'discovery_url_label' => '',
				'jwks_url_label'      => '',
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPE,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
					Mo_Oauth_Field_Labels::USERINFO_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'doc'                 => 'https://developers.freshdesk.com/docs/api/#authentication',
				'setup_guide'         => 'https://plugins.miniorange.com/single-sign-on-sso-for-freshworks-freshdesk-using-wordpress-as-oauth-server',
			),
			Mo_Oauth_Client_Keys::SALESFORCE         => array(
				'label'               => 'Salesforce',
				'type'                => Mo_Oauth_Client_Types::OPENID_CONNECT,
				'image'               => 'Salesforce.png',
				'redirect_uri'        => Mo_Oauth_Redirect_Uri_Labels::CALLBACK,
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::CONSUMER_KEY,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::CONSUMER_SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::AUTHORIZE_ENDPOINT_URL,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::TOKEN_ENDPOINT_URL,
				'userinfo_url_label'  => Mo_Oauth_Userinfo_Url_Labels::USER_INFO_ENDPOINT_URL,
				'issuer_url_label'    => '',
				'discovery_url_label' => '',
				'jwks_url_label'      => '',
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPE,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
				),
				'doc'                 => 'https://help.salesforce.com/articleView?id=sf.remoteaccess_oauth_web_server_flow.htm&type=5',
				'setup_guide'         => 'https://plugins.miniorange.com/single-sign-on-sso-for-salesforce-using-wordpress-as-oauth-server',
			),
			Mo_Oauth_Client_Keys::EASY_GENERATOR     => array(
				'label'               => 'Easy Generator',
				'type'                => Mo_Oauth_Client_Types::OAUTH2,
				'image'               => 'EasyGenerator.png',
				'redirect_uri'        => Mo_Oauth_Redirect_Uri_Labels::REDIRECT,
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::AUTHORIZATION_ENDPOINT,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::TOKEN_ENDPOINT,
				'userinfo_url_label'  => Mo_Oauth_Userinfo_Url_Labels::GET_USER_INFO_ENDPOINT,
				'issuer_url_label'    => '',
				'discovery_url_label' => '',
				'jwks_url_label'      => '',
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPE,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
					Mo_Oauth_Field_Labels::USERINFO_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'doc'                 => 'https://www.easygenerator.com/en/blog/elearning/oauth2-integration/',
				'setup_guide'         => 'https://plugins.miniorange.com/single-sign-on-sso-for-easygenerator-using-wordpress-as-oauth-server',
			),
			Mo_Oauth_Client_Keys::ACADEMY_OF_MINE    => array(
				'label'               => 'Academy of Mine',
				'type'                => Mo_Oauth_Client_Types::OAUTH2,
				'image'               => 'academy-of-mine.png',
				'redirect_uri'        => Mo_Oauth_Redirect_Uri_Labels::REDIRECT,
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::AUTHORIZATION_ENDPOINT,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::TOKEN_ENDPOINT,
				'userinfo_url_label'  => Mo_Oauth_Userinfo_Url_Labels::USERINFO_ENDPOINT,
				'issuer_url_label'    => '',
				'discovery_url_label' => '',
				'jwks_url_label'      => '',
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPES,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
					Mo_Oauth_Field_Labels::USERINFO_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'doc'                 => 'https://www.academyofmine.com/docs/api/authentication/',
				'setup_guide'         => 'https://plugins.miniorange.com/single-sign-on-sso-for-academyofmine-using-wordpress-as-oauth-server',
			),
			Mo_Oauth_Client_Keys::CHURCH_ONLINE      => array(
				'label'               => 'Church Online',
				'type'                => Mo_Oauth_Client_Types::OAUTH2,
				'image'               => 'ChurchOnline.png',
				'redirect_uri'        => Mo_Oauth_Redirect_Uri_Labels::REDIRECT,
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::AUTHORIZATION_ENDPOINT,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::TOKEN_ENDPOINT,
				'userinfo_url_label'  => Mo_Oauth_Userinfo_Url_Labels::USERINFO_ENDPOINT,
				'issuer_url_label'    => '',
				'discovery_url_label' => '',
				'jwks_url_label'      => '',
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPES,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
					Mo_Oauth_Field_Labels::USERINFO_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'doc'                 => 'https://churchonlineplatform.com/developers/api/oauth2',
				'setup_guide'         => 'https://plugins.miniorange.com/single-sign-on-sso-for-churchonline-using-wordpress-as-oauth-server',
			),
			Mo_Oauth_Client_Keys::MALTEGO            => array(
				'label'               => 'Maltego',
				'type'                => Mo_Oauth_Client_Types::OAUTH2,
				'image'               => 'Maltego.png',
				'redirect_uri'        => Mo_Oauth_Redirect_Uri_Labels::REDIRECT,
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::AUTHORIZATION_ENDPOINT,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::TOKEN_ENDPOINT,
				'userinfo_url_label'  => Mo_Oauth_Userinfo_Url_Labels::USERINFO_ENDPOINT,
				'issuer_url_label'    => '',
				'discovery_url_label' => '',
				'jwks_url_label'      => '',
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPES,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
					Mo_Oauth_Field_Labels::USERINFO_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'doc'                 => '',
				'setup_guide'         => '',
			),
			Mo_Oauth_Client_Keys::ASP_NET            => array(
				'label'               => 'ASP.NET',
				'type'                => Mo_Oauth_Client_Types::OAUTH2,
				'image'               => 'ASPNet.png',
				'redirect_uri'        => Mo_Oauth_Redirect_Uri_Labels::REDIRECT,
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::AUTHORIZATION_ENDPOINT,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::TOKEN_ENDPOINT,
				'userinfo_url_label'  => Mo_Oauth_Userinfo_Url_Labels::USERINFO_ENDPOINT,
				'issuer_url_label'    => '',
				'discovery_url_label' => '',
				'jwks_url_label'      => '',
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPES,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
					Mo_Oauth_Field_Labels::USERINFO_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'doc'                 => 'https://docs.microsoft.com/en-us/aspnet/core/security/authentication/social/',
				'setup_guide'         => 'https://plugins.miniorange.com/aspnet-oauth-sso-using-wordpress-as-oauth-server',
			),
			Mo_Oauth_Client_Keys::AWS_COGNITO        => array(
				'label'               => 'AWS Cognito',
				'type'                => Mo_Oauth_Client_Types::OPENID_CONNECT,
				'image'               => 'AWS-Cognito.png',
				'redirect_uri'        => Mo_Oauth_Redirect_Uri_Labels::REDIRECT,
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label' => '',
				'token_url_label'     => '',
				'userinfo_url_label'  => '',
				'issuer_url_label'    => Mo_Oauth_Issuer_Url_Labels::ISSUER,
				'discovery_url_label' => '',
				'jwks_url_label'      => '',
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::AUTHORIZE_SCOPE,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::ISSUER_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'doc'                 => 'https://docs.aws.amazon.com/cognito/latest/developerguide/cognito-user-pools-app-integration.html',
				'setup_guide'         => 'https://plugins.miniorange.com/single-sign-on-sso-for-aws-cognito-using-wordpress-as-oauth-server',
			),
			Mo_Oauth_Client_Keys::WSO2               => array(
				'label'               => 'WSO2 Identity Server',
				'type'                => Mo_Oauth_Client_Types::OAUTH2,
				'image'               => 'WSO2.png',
				'redirect_uri'        => Mo_Oauth_Redirect_Uri_Labels::CALLBACK,
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::AUTHORIZE_ENDPOINT_URL,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::TOKEN_ENDPOINT_URL,
				'userinfo_url_label'  => Mo_Oauth_Userinfo_Url_Labels::USERINFO_ENDPOINT_URL,
				'issuer_url_label'    => '',
				'discovery_url_label' => '',
				'jwks_url_label'      => Mo_Oauth_Jwks_Url_Labels::IDENTITY_PROVIDER_JWKS_ENDPOINT,
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPE,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
					Mo_Oauth_Field_Labels::USERINFO_URL,
					Mo_Oauth_Field_Labels::JWKS_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'doc'                 => 'https://is.docs.wso2.com/en/latest/learn/obtaining-an-access-token/',
				'setup_guide'         => 'https://plugins.miniorange.com/single-sign-on-sso-for-wso2-using-wordpress-as-oauth-server',
			),
			Mo_Oauth_Client_Keys::KNACK              => array(
				'label'               => 'Knack',
				'type'                => Mo_Oauth_Client_Types::OAUTH2,
				'image'               => 'Knack.png',
				'redirect_uri'        => Mo_Oauth_Redirect_Uri_Labels::REDIRECT,
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::AUTHORIZATION_ENDPOINT,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::TOKEN_ENDPOINT,
				'userinfo_url_label'  => Mo_Oauth_Userinfo_Url_Labels::USERINFO_ENDPOINT,
				'issuer_url_label'    => '',
				'discovery_url_label' => '',
				'jwks_url_label'      => '',
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPE,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
					Mo_Oauth_Field_Labels::USERINFO_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'doc'                 => 'https://www.knack.com/developers/authentication',
				'setup_guide'         => 'https://plugins.miniorange.com/single-sign-on-sso-for-knack-using-wordpress-as-oauth-server',
			),
			Mo_Oauth_Client_Keys::MOBILIZE           => array(
				'label'               => 'Mobilize',
				'type'                => Mo_Oauth_Client_Types::OAUTH2,
				'image'               => 'Mobilize.png',
				'redirect_uri'        => Mo_Oauth_Redirect_Uri_Labels::REDIRECT,
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::AUTHORIZE_URL,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::TOKEN_URL,
				'userinfo_url_label'  => '',
				'issuer_url_label'    => '',
				'discovery_url_label' => '',
				'jwks_url_label'      => '',
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPE,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
				),
				'doc'                 => 'https://developers.mobilize.io/docs/authentication',
				'setup_guide'         => 'https://plugins.miniorange.com/single-sign-on-sso-for-mobilize-using-wordpress-as-oauth-server',
			),
			Mo_Oauth_Client_Keys::NEXT_CLOUD         => array(
				'label'               => 'NextCloud',
				'type'                => Mo_Oauth_Client_Types::OAUTH2,
				'image'               => 'NextCloud.png',
				'redirect_uri'        => Mo_Oauth_Redirect_Uri_Labels::REDIRECT,
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::APP_ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::APP_SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::AUTHORIZATION_ENDPOINT,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::TOKEN_ENDPOINT,
				'userinfo_url_label'  => Mo_Oauth_Userinfo_Url_Labels::GET_USER_INFO_ENDPOINT,
				'issuer_url_label'    => '',
				'discovery_url_label' => '',
				'jwks_url_label'      => '',
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPE,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
					Mo_Oauth_Field_Labels::USERINFO_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'doc'                 => 'https://docs.nextcloud.com/server/18/developer_manual/client_apis/LoginFlow/index.html',
				'setup_guide'         => 'https://plugins.miniorange.com/single-sign-on-sso-for-nextcloud-using-wordpress-as-oauth-server',
			),
			Mo_Oauth_Client_Keys::TRIBE              => array(
				'label'               => 'Tribe Platform',
				'type'                => Mo_Oauth_Client_Types::OAUTH2,
				'image'               => 'Tribe.png',
				'redirect_uri'        => Mo_Oauth_Redirect_Uri_Labels::CALLBACK,
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::AUTHORIZE_URL,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::TOKEN_URL,
				'userinfo_url_label'  => Mo_Oauth_Userinfo_Url_Labels::USER_INFO_URL,
				'issuer_url_label'    => '',
				'discovery_url_label' => '',
				'jwks_url_label'      => '',
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPE,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
					Mo_Oauth_Field_Labels::USERINFO_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'doc'                 => 'https://docs.tribe.so/getting-started/integrations/oauth2-integration',
				'setup_guide'         => 'https://plugins.miniorange.com/single-sign-on-sso-for-tribe-using-wordpress-as-oauth-server',
			),
			Mo_Oauth_Client_Keys::ZAPIER             => array(
				'label'               => 'Zapier',
				'type'                => Mo_Oauth_Client_Types::OAUTH2,
				'image'               => 'Zapier.png',
				'redirect_uri'        => Mo_Oauth_Redirect_Uri_Labels::OAUTH_REDIRECT,
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::AUTHORIZE_URL,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::ACCESS_TOKEN_REQUEST,
				'userinfo_url_label'  => '',
				'issuer_url_label'    => '',
				'discovery_url_label' => '',
				'jwks_url_label'      => '',
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPE,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'doc'                 => 'https://zapier.com/developer/documentation/v2/oauthv2-integration/',
				'setup_guide'         => 'https://plugins.miniorange.com/zapier-integration-with-wordpress-oauth-server',
			),
			Mo_Oauth_Client_Keys::OPEN_EDX_EDU_NEXT  => array(
				'label'               => 'Open edX / EduNext',
				'type'                => Mo_Oauth_Client_Types::OAUTH2,
				'image'               => 'Edunext.png',
				'redirect_uri'        => Mo_Oauth_Redirect_Uri_Labels::CALLBACK_REDIRECT_URI,
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::AUTHORIZATION_ENDPOINT,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::ACCESS_TOKEN_ENDPOINT,
				'userinfo_url_label'  => Mo_Oauth_Userinfo_Url_Labels::GET_USER_INFO_ENDPOINT,
				'issuer_url_label'    => '',
				'discovery_url_label' => '',
				'jwks_url_label'      => '',
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPE,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
					Mo_Oauth_Field_Labels::USERINFO_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'doc'                 => 'https://edx.readthedocs.io/projects/edx-installing-configuring-and-running/en/latest/configuration/security/oauth.html',
				'setup_guide'         => 'https://plugins.miniorange.com/single-sign-on-sso-for-open-edx-edunext-using-wordpress-as-oauth-server',
			),
			Mo_Oauth_Client_Keys::VENDASTA           => array(
				'label'               => 'Vendasta',
				'type'                => Mo_Oauth_Client_Types::OAUTH2,
				'image'               => 'Vendasta.png',
				'redirect_uri'        => 'https://www.vendasta.com/',
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::AUTHORIZATION_ENDPOINT,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::TOKEN_ENDPOINT,
				'userinfo_url_label'  => Mo_Oauth_Userinfo_Url_Labels::USERINFO_ENDPOINT,
				'issuer_url_label'    => '',
				'discovery_url_label' => '',
				'jwks_url_label'      => '',
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPES,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
					Mo_Oauth_Field_Labels::USERINFO_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'doc'                 => 'https://developers.vendasta.com/docs/how-to-use-oauth',
				'setup_guide'         => 'https://plugins.miniorange.com/vendasta-sso-using-wordpress-as-oauth-server',
			),
			Mo_Oauth_Client_Keys::MOODLE             => array(
				'label'               => 'Moodle',
				'type'                => Mo_Oauth_Client_Types::OAUTH2,
				'image'               => 'Moodle.png',
				'redirect_uri'        => 'https://moodle.org/',
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::AUTHORIZE_ENDPOINT,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::TOKEN_ENDPOINT_LOWERCASE,
				'userinfo_url_label'  => Mo_Oauth_Userinfo_Url_Labels::RESOURCE_ENDPOINT,
				'issuer_url_label'    => Mo_Oauth_Issuer_Url_Labels::ISSUER_ENDPOINT,
				'discovery_url_label' => Mo_Oauth_Discovery_Url_Labels::DISCOVERY_ENDPOINT_LOWERCASE,
				'jwks_url_label'      => Mo_Oauth_Jwks_Url_Labels::JWKS_ENDPOINT_LOWERCASE,
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPES_INCLUDED_IN_LOGIN_REQUEST,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
					Mo_Oauth_Field_Labels::USERINFO_URL,
					Mo_Oauth_Field_Labels::ISSUER_URL,
					Mo_Oauth_Field_Labels::DISCOVERY_URL,
					Mo_Oauth_Field_Labels::JWKS_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'doc'                 => 'https://docs.moodle.org/dev/Implementing_OAuth2',
				'setup_guide'         => 'https://plugins.miniorange.com/single-sign-on-sso-for-moodle-using-wordpress-as-oauth-server',
			),
			Mo_Oauth_Client_Keys::MAGENTO            => array(
				'label'               => 'Magento',
				'type'                => Mo_Oauth_Client_Types::OAUTH1,
				'image'               => 'Magento.png',
				'redirect_uri'        => Mo_Oauth_Redirect_Uri_Labels::CALLBACK,
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::CLIENT_KEY,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::AUTHORIZATION_ENDPOINT,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::TOKEN_ENDPOINT,
				'userinfo_url_label'  => Mo_Oauth_Userinfo_Url_Labels::GET_USER_INFO_ENDPOINT,
				'issuer_url_label'    => '',
				'discovery_url_label' => '',
				'jwks_url_label'      => '',
				'wp_url_label'        => '',
				'scopes_label'        => '',
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
					Mo_Oauth_Field_Labels::USERINFO_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'doc'                 => 'https://devdocs.magento.com/guides/v2.4/get-started/authentication/gs-authentication-oauth.html',
				'setup_guide'         => 'https://plugins.miniorange.com/wordpress-single-sign-on-magento-sso-oauth-openid-connect',
			),
			Mo_Oauth_Client_Keys::SHOPIFY            => array(
				'label'               => 'Shopify',
				'type'                => Mo_Oauth_Client_Types::OAUTH2,
				'image'               => 'Shopify.png',
				'redirect_uri'        => Mo_Oauth_Redirect_Uri_Labels::OAUTH_CALLBACK,
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::OAUTH_AUTHORIZATION_ENDPOINT,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::OAUTH_TOKEN_ENDPOINT,
				'userinfo_url_label'  => Mo_Oauth_Userinfo_Url_Labels::OAUTH_GET_USER_INFO_ENDPOINT,
				'issuer_url_label'    => '',
				'discovery_url_label' => '',
				'jwks_url_label'      => '',
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPE,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
					Mo_Oauth_Field_Labels::USERINFO_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'doc'                 => '',
				'setup_guide'         => 'https://plugins.miniorange.com/oauth-single-sign-on-sso-for-shopify-using-wordpress-as-identity-provider',
			),
			Mo_Oauth_Client_Keys::ZERO_TIER          => array(
				'label'               => 'ZeroTier',
				'type'                => Mo_Oauth_Client_Types::OAUTH2,
				'image'               => 'ZeroTier.png',
				'redirect_uri'        => Mo_Oauth_Redirect_Uri_Labels::CALLBACK,
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::AUTHORIZATION_ENDPOINT,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::TOKEN_ENDPOINT,
				'userinfo_url_label'  => Mo_Oauth_Userinfo_Url_Labels::GET_USER_INFO_ENDPOINT,
				'issuer_url_label'    => '',
				'discovery_url_label' => '',
				'jwks_url_label'      => '',
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPES,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
					Mo_Oauth_Field_Labels::USERINFO_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'doc'                 => 'https://docs.zerotier.com/central/sso',
				'setup_guide'         => 'https://plugins.miniorange.com/step-by-step-guide-for-wordpress-oauth-server#step_1',
			),
			Mo_Oauth_Client_Keys::EVENT_MOBI         => array(
				'label'               => 'EventMobi',
				'type'                => Mo_Oauth_Client_Types::OAUTH2,
				'image'               => 'Eventmobi.png',
				'redirect_uri'        => Mo_Oauth_Redirect_Uri_Labels::CALLBACK,
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::AUTHORIZATION_ENDPOINT,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::TOKEN_ENDPOINT,
				'userinfo_url_label'  => Mo_Oauth_Userinfo_Url_Labels::GET_USER_INFO_ENDPOINT,
				'issuer_url_label'    => '',
				'discovery_url_label' => '',
				'jwks_url_label'      => '',
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPES,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
					Mo_Oauth_Field_Labels::USERINFO_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'doc'                 => 'https://help.eventmobi.com/en/knowledge/can-i-set-up-single-sign-on-sso-with-my-identity-provider',
				'setup_guide'         => 'https://plugins.miniorange.com/step-by-step-guide-for-wordpress-oauth-server#step_1',
			),
			Mo_Oauth_Client_Keys::PIMCORE            => array(
				'label'               => 'Pimcore',
				'type'                => Mo_Oauth_Client_Types::OAUTH2,
				'image'               => 'Pimcore.png',
				'redirect_uri'        => Mo_Oauth_Redirect_Uri_Labels::CALLBACK,
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::AUTHORIZATION_ENDPOINT,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::TOKEN_ENDPOINT,
				'userinfo_url_label'  => Mo_Oauth_Userinfo_Url_Labels::GET_USER_INFO_ENDPOINT,
				'issuer_url_label'    => '',
				'discovery_url_label' => '',
				'jwks_url_label'      => '',
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPES,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
					Mo_Oauth_Field_Labels::USERINFO_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'doc'                 => 'https://pimcore.com/docs/customer-management-framework/current/Single_Sign_On.html',
				'setup_guide'         => 'https://plugins.miniorange.com/step-by-step-guide-for-wordpress-oauth-server#step_1',
			),
			Mo_Oauth_Client_Keys::HIGHER_LOGIC       => array(
				'label'               => 'Higher Logic',
				'type'                => Mo_Oauth_Client_Types::OAUTH2,
				'image'               => 'HigherLogic.png',
				'redirect_uri'        => Mo_Oauth_Redirect_Uri_Labels::CALLBACK,
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::AUTHORIZATION_ENDPOINT,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::TOKEN_ENDPOINT,
				'userinfo_url_label'  => Mo_Oauth_Userinfo_Url_Labels::GET_USER_INFO_ENDPOINT,
				'issuer_url_label'    => '',
				'discovery_url_label' => '',
				'jwks_url_label'      => '',
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPES,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
					Mo_Oauth_Field_Labels::USERINFO_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'doc'                 => 'https://support.higherlogic.com/hc/en-us/articles/4402952237844-OAuth-2-0-Code-Flow',
				'setup_guide'         => 'https://plugins.miniorange.com/step-by-step-guide-for-wordpress-oauth-server#step_1',
			),
			Mo_Oauth_Client_Keys::LEARNING_360       => array(
				'label'               => '360Learning',
				'type'                => Mo_Oauth_Client_Types::OAUTH2,
				'image'               => '360Learning.png',
				'redirect_uri'        => Mo_Oauth_Redirect_Uri_Labels::CALLBACK,
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label' => Mo_Oauth_Authorization_Url_Labels::AUTHORIZATION_ENDPOINT,
				'token_url_label'     => Mo_Oauth_Token_Url_Labels::TOKEN_ENDPOINT,
				'userinfo_url_label'  => Mo_Oauth_Userinfo_Url_Labels::GET_USER_INFO_ENDPOINT,
				'issuer_url_label'    => '',
				'discovery_url_label' => '',
				'jwks_url_label'      => '',
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPES,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
					Mo_Oauth_Field_Labels::USERINFO_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'doc'                 => 'https://support.360learning.com/hc/en-us/articles/6966196513684-Technical-Guide-SSO-OpenID',
				'setup_guide'         => 'https://plugins.miniorange.com/step-by-step-guide-for-wordpress-oauth-server#step_1',
			),
			Mo_Oauth_Client_Keys::SYNOLOGY           => array(
				'label'               => 'Synology',
				'type'                => Mo_Oauth_Client_Types::OPENID_CONNECT,
				'image'               => 'Synology.png',
				'redirect_uri'        => Mo_Oauth_Redirect_Uri_Labels::REDIRECT,
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::APPLICATION_ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::APPLICATION_KEY,
				'authorize_url_label' => '',
				'token_url_label'     => '',
				'userinfo_url_label'  => '',
				'issuer_url_label'    => '',
				'discovery_url_label' => Mo_Oauth_Discovery_Url_Labels::WELLKNOWN_URL,
				'jwks_url_label'      => '',
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::AUTHORIZATION_SCOPE,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::DISCOVERY_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'doc'                 => 'https://kb.synology.com/de-de/DSM/help/DSM/AdminCenter/file_directory_service_sso?version=7',
				'setup_guide'         => 'https://plugins.miniorange.com/step-by-step-guide-for-wordpress-oauth-server#step_1',
			),
			Mo_Oauth_Client_Keys::BOOKSTACK          => array(
				'label'               => 'Bookstack',
				'type'                => Mo_Oauth_Client_Types::OPENID_CONNECT,
				'image'               => 'BookStack.png',
				'redirect_uri'        => Mo_Oauth_Redirect_Uri_Labels::REDIRECT,
				'client_id_label'     => Mo_Oauth_Client_Id_Labels::OIDC_CLIENT_ID,
				'client_secret_label' => Mo_Oauth_Client_Secret_Labels::OIDC_CLIENT_SECRET,
				'authorize_url_label' => '',
				'token_url_label'     => '',
				'userinfo_url_label'  => '',
				'issuer_url_label'    => Mo_Oauth_Issuer_Url_Labels::OIDC_ISSUER,
				'discovery_url_label' => '',
				'jwks_url_label'      => '',
				'wp_url_label'        => '',
				'scopes_label'        => Mo_Oauth_Scopes_Labels::SCOPES,
				'endpoints_required'  => array(
					Mo_Oauth_Field_Labels::ISSUER_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'doc'                 => 'https://www.bookstackapp.com/docs/admin/oidc-auth',
				'setup_guide'         => 'https://plugins.miniorange.com/step-by-step-guide-for-wordpress-oauth-server#step_1',
			),
			Mo_Oauth_Client_Keys::CLAUDE             => array(
				'label'                => 'Claude (Anthropic)',
				'type'                 => Mo_Oauth_Client_Types::OAUTH2,
				'image'                => 'claude-ai-icon.svg',
				'redirect_uri'         => Mo_Oauth_Redirect_Uri_Labels::CALLBACK,
				'redirect_uri_prefill' => 'https://claude.ai/api/mcp/auth/callback',
				'client_id_label'      => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label'  => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label'  => Mo_Oauth_Authorization_Url_Labels::AUTHORIZATION_ENDPOINT,
				'token_url_label'      => Mo_Oauth_Token_Url_Labels::TOKEN_ENDPOINT,
				'userinfo_url_label'   => Mo_Oauth_Userinfo_Url_Labels::USERINFO_ENDPOINT,
				'issuer_url_label'     => '',
				'discovery_url_label'  => '',
				'jwks_url_label'       => '',
				'wp_url_label'         => '',
				'scopes_label'         => Mo_Oauth_Scopes_Labels::SCOPE,
				'endpoints_required'   => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
					Mo_Oauth_Field_Labels::USERINFO_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'setup_guide'          => 'https://plugins.miniorange.com/step-by-step-guide-for-wordpress-oauth-server',
			),
			Mo_Oauth_Client_Keys::CHATGPT            => array(
				'label'                => 'ChatGPT (OpenAI)',
				'type'                 => Mo_Oauth_Client_Types::OAUTH2,
				'image'                => 'chatgpt-icon.svg',
				'redirect_uri'         => Mo_Oauth_Redirect_Uri_Labels::CALLBACK,
				'redirect_uri_prefill' => '',
				'client_id_label'      => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label'  => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label'  => Mo_Oauth_Authorization_Url_Labels::AUTHORIZATION_ENDPOINT,
				'token_url_label'      => Mo_Oauth_Token_Url_Labels::TOKEN_ENDPOINT,
				'userinfo_url_label'   => Mo_Oauth_Userinfo_Url_Labels::USERINFO_ENDPOINT,
				'issuer_url_label'     => '',
				'discovery_url_label'  => '',
				'jwks_url_label'       => '',
				'wp_url_label'         => '',
				'scopes_label'         => Mo_Oauth_Scopes_Labels::SCOPE,
				'endpoints_required'   => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
					Mo_Oauth_Field_Labels::USERINFO_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'setup_guide'          => 'https://plugins.miniorange.com/step-by-step-guide-for-wordpress-oauth-server',
			),
			Mo_Oauth_Client_Keys::CURSOR             => array(
				'label'                => 'Cursor',
				'type'                 => Mo_Oauth_Client_Types::OAUTH2,
				'image'                => 'cursor-ai-code-icon.svg',
				'redirect_uri'         => Mo_Oauth_Redirect_Uri_Labels::CALLBACK,
				'redirect_uri_prefill' => '',
				'client_id_label'      => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label'  => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label'  => Mo_Oauth_Authorization_Url_Labels::AUTHORIZATION_ENDPOINT,
				'token_url_label'      => Mo_Oauth_Token_Url_Labels::TOKEN_ENDPOINT,
				'userinfo_url_label'   => Mo_Oauth_Userinfo_Url_Labels::USERINFO_ENDPOINT,
				'issuer_url_label'     => '',
				'discovery_url_label'  => '',
				'jwks_url_label'       => '',
				'wp_url_label'         => '',
				'scopes_label'         => Mo_Oauth_Scopes_Labels::SCOPE,
				'endpoints_required'   => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
					Mo_Oauth_Field_Labels::USERINFO_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'setup_guide'          => 'https://plugins.miniorange.com/step-by-step-guide-for-wordpress-oauth-server',
			),
			Mo_Oauth_Client_Keys::WINDSURF           => array(
				'label'                => 'Windsurf',
				'type'                 => Mo_Oauth_Client_Types::OAUTH2,
				'image'                => 'Windsurf.svg',
				'redirect_uri'         => Mo_Oauth_Redirect_Uri_Labels::CALLBACK,
				'redirect_uri_prefill' => '',
				'client_id_label'      => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label'  => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label'  => Mo_Oauth_Authorization_Url_Labels::AUTHORIZATION_ENDPOINT,
				'token_url_label'      => Mo_Oauth_Token_Url_Labels::TOKEN_ENDPOINT,
				'userinfo_url_label'   => Mo_Oauth_Userinfo_Url_Labels::USERINFO_ENDPOINT,
				'issuer_url_label'     => '',
				'discovery_url_label'  => '',
				'jwks_url_label'       => '',
				'wp_url_label'         => '',
				'scopes_label'         => Mo_Oauth_Scopes_Labels::SCOPE,
				'endpoints_required'   => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
					Mo_Oauth_Field_Labels::USERINFO_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'setup_guide'          => 'https://plugins.miniorange.com/step-by-step-guide-for-wordpress-oauth-server',
			),
			Mo_Oauth_Client_Keys::GENERIC_AI_MCP     => array(
				'label'                => 'Generic AI MCP Client',
				'type'                 => Mo_Oauth_Client_Types::OAUTH2,
				'image'                => 'GenericAI.svg',
				'redirect_uri'         => Mo_Oauth_Redirect_Uri_Labels::CALLBACK,
				'redirect_uri_prefill' => '',
				'client_id_label'      => Mo_Oauth_Client_Id_Labels::CLIENT_ID,
				'client_secret_label'  => Mo_Oauth_Client_Secret_Labels::CLIENT_SECRET,
				'authorize_url_label'  => Mo_Oauth_Authorization_Url_Labels::AUTHORIZATION_ENDPOINT,
				'token_url_label'      => Mo_Oauth_Token_Url_Labels::TOKEN_ENDPOINT,
				'userinfo_url_label'   => Mo_Oauth_Userinfo_Url_Labels::USERINFO_ENDPOINT,
				'issuer_url_label'     => '',
				'discovery_url_label'  => '',
				'jwks_url_label'       => '',
				'wp_url_label'         => '',
				'scopes_label'         => Mo_Oauth_Scopes_Labels::SCOPE,
				'endpoints_required'   => array(
					Mo_Oauth_Field_Labels::AUTHORIZE_URL,
					Mo_Oauth_Field_Labels::TOKEN_URL,
					Mo_Oauth_Field_Labels::USERINFO_URL,
					Mo_Oauth_Field_Labels::SCOPES,
				),
				'setup_guide'          => 'https://plugins.miniorange.com/step-by-step-guide-for-wordpress-oauth-server',
			),
		);
	}
}

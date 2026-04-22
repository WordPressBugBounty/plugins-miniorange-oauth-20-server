<?php

namespace OAuth2\Storage;

use OAuth2\OpenID\Storage\UserClaimsInterface;
use OAuth2\OpenID\Storage\AuthorizationCodeInterface as OpenIDAuthorizationCodeInterface;

require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . DIRECTORY_SEPARATOR . 'errorlogs' . DIRECTORY_SEPARATOR . 'class-mo-oauth-server-debug.php';

/**
 * Simple PDO storage for all storage types
 *
 * NOTE: This class is meant to get users started
 * quickly. If your application requires further
 * customization, extend this class or create your own.
 *
 * NOTE: Passwords are stored in plaintext, which is never
 * a good idea.  Be sure to override this for your application
 *
 * @author Brent Shaffer <bshafs at gmail dot com>
 */
class MoPdo implements
	AuthorizationCodeInterface,
	AccessTokenInterface,
	ClientCredentialsInterface,
	UserCredentialsInterface,
	RefreshTokenInterface,
	JwtBearerInterface,
	ScopeInterface,
	PublicKeyInterface,
	UserClaimsInterface,
	OpenIDAuthorizationCodeInterface {

	/**
	 * Summary of db
	 *
	 * @var mixed
	 */
	protected $db;

	/**
	 * Summary of config
	 *
	 * @var mixed
	 */
	protected $config;

	/**
	 * Summary of __construct
	 *
	 * @param mixed $connection
	 * @param mixed $config
	 */
	public function __construct( $connection, $config = array() ) {
	}

	/* OAuth2\Storage\ClientCredentialsInterface */
	/**
	 * Summary of checkClientCredentials
	 *
	 * @param mixed $client_id
	 * @param mixed $client_secret
	 * @return bool
	 */
	public function checkClientCredentials( $client_id, $client_secret = null ) {
		global $wpdb;
		$result = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->base_prefix . 'moos_oauth_clients where client_id= %s', array( $client_id ) ), ARRAY_A );

		// miniorange oauth server plugin update version 5 onwards
		// storing client secret in encrypted format.

		require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/class-miniorange-oauth-20-server-utils.php';
		$mo_utils = new \Miniorange_Oauth_20_Server_Utils();

		$client_secret_from_db = $mo_utils->mo_oauth_server_decrypt( $result['client_secret'], $result['client_name'] );

		// make this extensible
		// checking with database.
		return $result && $client_secret_from_db === $client_secret;
	}

	/**
	 * Summary of isPublicClient
	 *
	 * @param mixed $client_id
	 * @return bool
	 */
	public function isPublicClient( $client_id ) {
		global $wpdb;
		$result = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->base_prefix . 'moos_oauth_clients where client_id= %s', array( $client_id ) ), ARRAY_A );
		if ( ! $result ) {
			return false;
		}
		return empty( $result['client_secret'] );
	}

	/* OAuth2\Storage\ClientInterface */
	/**
	 * Summary of getClientDetails
	 *
	 * @param mixed $client_id
	 * @return mixed
	 */
	public function getClientDetails( $client_id ) {
		global $wpdb;
		$row = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->base_prefix . 'moos_oauth_clients where client_id= %s', array( $client_id ) ), ARRAY_A );

		return $row;
	}

	/**
	 * Summary of setClientDetails
	 *
	 * @param mixed $client_id
	 * @param mixed $client_secret
	 * @param mixed $redirect_uri
	 * @param mixed $grant_types
	 * @param mixed $scope
	 * @param mixed $user_id
	 * @return mixed
	 */
	public function setClientDetails( $client_id, $client_secret = null, $redirect_uri = null, $grant_types = null, $scope = null, $user_id = null ) {
		global $wpdb;
		// if it exists, update it.
		if ( $this->getClientDetails( $client_id ) ) {
			$wpdb->query( $wpdb->prepare( 'UPDATE ' . $wpdb->base_prefix . 'moos_oauth_clients SET client_secret= %s, redirect_uri= %s, grant_types= %s,  scope= %s, user_id= %d  where client_id= %s', array( $client_secret, $redirect_uri, $grant_types, $scope, $user_id, $client_id ) ) );
		} else {
			return $wpdb->query( $wpdb->prepare( 'INSERT INTO ' . $wpdb->base_prefix . 'moos_oauth_clients (client_id, client_secret, redirect_uri, grant_types, scope, user_id) VALUES (%s, %s, %s, %s, %s, %d)', array( $client_id, $client_secret, $redirect_uri, $grant_types, $scope, $user_id ) ) );
		}
	}

	/**
	 * Summary of checkIfAlreadyAuthorized
	 *
	 * @param mixed $client_id
	 * @param mixed $user_id
	 * @return bool
	 */
	public function checkIfAlreadyAuthorized( $client_id, $user_id ) {
		global $wpdb;
		$result = $wpdb->get_row( $wpdb->prepare( 'SELECT count(*) as count FROM ' . $wpdb->base_prefix . 'moos_oauth_authorized_apps where client_id = %s AND user_id= %d', array( $client_id, $user_id ) ), ARRAY_A );

		if ( $result ) {
			return $result['count'] > 0;
		}
		return false;
	}

	/**
	 * Summary of authorizeClient
	 *
	 * @param mixed $client_id
	 * @param mixed $user_id
	 * @return mixed
	 */
	public function authorizeClient( $client_id, $user_id ) {
		global $wpdb;
		return $wpdb->query( $wpdb->prepare( 'INSERT INTO ' . $wpdb->base_prefix . 'moos_oauth_authorized_apps (client_id, user_id) VALUES (%s,%d)', array( $client_id, $user_id ) ) );
	}

	/**
	 * Summary of checkRestrictedGrantType
	 *
	 * @param mixed $client_id
	 * @param mixed $grant_type
	 * @return bool
	 */
	public function checkRestrictedGrantType( $client_id, $grant_type ) {
		$details = $this->getClientDetails( $client_id );
		if ( isset( $details['grant_types'] ) ) {
			$grant_types = explode( ' ', $details['grant_types'] );

			return in_array( $grant_type, (array) $grant_types );
		}

		// if grant_types are not defined, then none are restricted.
		return true;
	}

	/* OAuth2\Storage\AccessTokenInterface */
	/**
	 * Summary of getAccessToken
	 *
	 * @param mixed $access_token
	 * @return mixed
	 */
	public function getAccessToken( $access_token ) {
		global $wpdb;
		$result = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->base_prefix . 'moos_oauth_access_tokens where access_token = %s', $access_token ), ARRAY_A );

		if ( $result ) {
			$result['expires'] = strtotime( $result['expires'] );
		}
		return $result;
	}

	/**
	 * Summary of setAccessToken
	 *
	 * @param mixed $access_token
	 * @param mixed $client_id
	 * @param mixed $user_id
	 * @param mixed $expires
	 * @param mixed $scope
	 * @return mixed
	 */
	public function setAccessToken( $access_token, $client_id, $user_id, $expires, $scope = null ) {
		$expires = gmdate( 'Y-m-d H:i:s', $expires );
		global $wpdb;
		if ( $this->getAccessToken( $access_token ) ) {
			$wpdb->query( $wpdb->prepare( 'UPDATE ' . $wpdb->base_prefix . 'moos_oauth_access_tokens SET client_id= %s, expires= %s, user_id= %d,  scope= %s where access_token= %s', array( $client_id, $expires, $user_id, $scope, $access_token ) ) );
		} else {
			return $wpdb->query( $wpdb->prepare( 'INSERT INTO ' . $wpdb->base_prefix . 'moos_oauth_access_tokens (access_token, client_id, expires, user_id, scope) VALUES (%s, %s, %s, %d, %s)', array( $access_token, $client_id, $expires, $user_id, $scope ) ) );
		}

	}

	/**
	 * Summary of unsetAccessToken
	 *
	 * @param mixed $access_token
	 * @return mixed
	 */
	public function unsetAccessToken( $access_token ) {
		global $wpdb;
		return $wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $wpdb->base_prefix . 'moos_oauth_access_tokens where access_token = %s', array( $access_token ) ) );
	}

	/* OAuth2\Storage\AuthorizationCodeInterface */
	/**
	 * Summary of getAuthorizationCode
	 *
	 * @param mixed $code
	 * @return mixed
	 */
	public function getAuthorizationCode( $code ) {
		global $wpdb;
		$code = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->base_prefix . 'moos_oauth_authorization_codes where authorization_code = %s', array( $code ) ), ARRAY_A );
		if ( $code ) {
			// convert date string back to timestamp.
			$code['expires'] = strtotime( $code['expires'] );
		}
		return $code;
	}

	/**
	 * Summary of setAuthorizationCode
	 *
	 * @param mixed $code
	 * @param mixed $client_id
	 * @param mixed $user_id
	 * @param mixed $redirect_uri
	 * @param mixed $expires
	 * @param mixed $scope
	 * @param mixed $id_token
	 * @param array $
	 * @return mixed
	 */
	public function setAuthorizationCode( $code, $client_id, $user_id, $redirect_uri, $expires, $scope = null, $id_token = null ) {
		if ( func_num_args() > 6 ) {
			// we are calling with an id token.
			return call_user_func_array( array( $this, 'setAuthorizationCodeWithIdToken' ), func_get_args() );
		}

		// convert expires to datestring.
		$expires = gmdate( 'Y-m-d H:i:s', $expires );
		// if it exists, update it.
		global $wpdb;
		if ( $this->getAuthorizationCode( $code ) ) {
			$wpdb->query( $wpdb->prepare( 'UPDATE ' . $wpdb->base_prefix . 'moos_oauth_authorization_codes SET client_id= %s, user_id= %d, redirect_uri= %s, expires= %s, scope= %s where authorization_code= %s', array( $client_id, $user_id, $redirect_uri, $expires, $scope, $code ) ) );
		} else {
			return $wpdb->query( $wpdb->prepare( 'INSERT INTO ' . $wpdb->base_prefix . 'moos_oauth_authorization_codes (authorization_code, client_id, user_id, redirect_uri, expires, scope) VALUES (%s,%s,%d, %s, %s, %s)', array( $code, $client_id, $user_id, $redirect_uri, $expires, $scope ) ) );
		}

	}

	/**
	 * Summary of setAuthorizationCodeWithIdToken
	 *
	 * @param mixed $code
	 * @param mixed $client_id
	 * @param mixed $user_id
	 * @param mixed $redirect_uri
	 * @param mixed $expires
	 * @param mixed $scope
	 * @param mixed $id_token
	 * @return mixed
	 */
	private function setAuthorizationCodeWithIdToken( $code, $client_id, $user_id, $redirect_uri, $expires, $scope = null, $id_token = null ) {
		// convert expires to datestring.
		$expires = gmdate( 'Y-m-d H:i:s', $expires );
		global $wpdb;
		update_option( 'mo_oauth_server_current_id_token', $id_token, false );

		// if it exists, update it.
		if ( $this->getAuthorizationCode( $code ) ) {
			return $wpdb->query( $wpdb->prepare( 'UPDATE ' . $wpdb->base_prefix . 'moos_oauth_authorization_codes SET client_id= %s, user_id= %d, redirect_uri= %s, expires= %s, scope= %s, id_token = %s where authorization_code= %s', array( $client_id, $user_id, $redirect_uri, $expires, $scope, $id_token, $code ) ) );
		} else {
			return $wpdb->query( $wpdb->prepare( 'INSERT INTO ' . $wpdb->base_prefix . 'moos_oauth_authorization_codes (authorization_code, client_id, user_id, redirect_uri, expires, scope, id_token) VALUES (%s, %s, %d, %s, %s, %s, %s)', array( $code, $client_id, $user_id, $redirect_uri, $expires, $scope, $id_token ) ) );
		}
	}

	/**
	 * Summary of expireAuthorizationCode
	 *
	 * @param mixed $code
	 * @return mixed
	 */
	public function expireAuthorizationCode( $code ) {
		global $wpdb;
		return $wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $wpdb->base_prefix . 'moos_oauth_authorization_codes where authorization_code = %s', array( $code ) ) );
	}

	/* OAuth2\Storage\UserCredentialsInterface */
	/**
	 * Summary of checkUserCredentials
	 *
	 * @param mixed $username
	 * @param mixed $password
	 * @return mixed
	 */
	public function checkUserCredentials( $username, $password ) {
		\MO_OAuth_Server_Debug::error_log( 'Checking User Credentials...' );

		if ( $user = $this->getUser( $username ) ) {
			return $this->checkPassword( $user, $password );
		}

		\MO_OAuth_Server_Debug::error_log( 'User Credentials check failed...' );
		return false;
	}

	/**
	 * Summary of getUserDetails
	 *
	 * @param mixed $username
	 * @return mixed
	 */
	public function getUserDetails( $username ) {
		return $this->getUser( $username );
	}

	/* UserClaimsInterface */
	/**
	 * Summary of getUserClaims
	 *
	 * @param mixed $user_id
	 * @param mixed $claims
	 * @return array|bool
	 */
	public function getUserClaims( $user_id, $claims ) {
		if ( ! $userDetails = $this->getUserDetails( $user_id ) ) {
			return false;
		}

		$claims     = explode( ' ', trim( $claims ) );
		$userClaims = array();

		// for each requested claim, if the user has the claim, set it in the response.
		$validClaims = explode( ' ', self::VALID_CLAIMS );
		foreach ( $validClaims as $validClaim ) {
			if ( in_array( $validClaim, $claims ) ) {
				if ( $validClaim == 'address' ) {
					// address is an object with subfields
					$userClaims['address'] = $this->getUserClaim( $validClaim, $userDetails['address'] ?: $userDetails );
				} else {
					$userClaims = array_merge( $userClaims, $this->getUserClaim( $validClaim, $userDetails ) );
				}
			}
		}

		return $userClaims;
	}

	/**
	 * Summary of getUserClaim
	 *
	 * @param mixed $claim
	 * @param mixed $userDetails
	 * @return array
	 */
	protected function getUserClaim( $claim, $userDetails ) {
		$userClaims        = array();
		$claimValuesString = constant( sprintf( 'self::%s_CLAIM_VALUES', strtoupper( $claim ) ) );
		$claimValues       = explode( ' ', $claimValuesString );

		foreach ( $claimValues as $value ) {
			$userClaims[ $value ] = isset( $userDetails[ $value ] ) ? $userDetails[ $value ] : null;
		}

		return $userClaims;
	}

	/* OAuth2\Storage\RefreshTokenInterface */
	/**
	 * Summary of getRefreshToken
	 *
	 * @param mixed $refresh_token
	 * @return mixed
	 */
	public function getRefreshToken( $refresh_token ) {
		global $wpdb;
		$result = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->base_prefix . 'moos_oauth_refresh_tokens where refresh_token = %s', array( $refresh_token ) ), ARRAY_A );
		if ( $result ) {
			$result['expires'] = strtotime( $result['expires'] );
		}
		return $result;
	}

	/**
	 * Summary of setRefreshToken
	 *
	 * @param mixed $refresh_token
	 * @param mixed $client_id
	 * @param mixed $user_id
	 * @param mixed $expires
	 * @param mixed $scope
	 * @return mixed
	 */
	public function setRefreshToken( $refresh_token, $client_id, $user_id, $expires, $scope = null ) {
		global $wpdb;
		// convert expires to datestring.
		$expires = gmdate( 'Y-m-d H:i:s', $expires );
		return $wpdb->query( $wpdb->prepare( 'INSERT INTO ' . $wpdb->base_prefix . 'moos_oauth_refresh_tokens (refresh_token, client_id, user_id, expires, scope) VALUES (%s, %s, %d, %s, %s)', array( $refresh_token, $client_id, $user_id, $expires, $scope ) ) );
	}

	/**
	 * Summary of unsetRefreshToken
	 *
	 * @param mixed $refresh_token
	 * @return mixed
	 */
	public function unsetRefreshToken( $refresh_token ) {
		$stmt = $this->db->prepare( sprintf( 'DELETE FROM %s WHERE refresh_token = :refresh_token', $this->config['refresh_token_table'] ) );

		return $stmt->execute( compact( 'refresh_token' ) );
	}

	// plaintext passwords are bad!  Override this for your application.
	/**
	 * Summary of checkPassword
	 *
	 * @param mixed $user
	 * @param mixed $password
	 * @return mixed
	 */
	protected function checkPassword( $user, $password ) {
		\MO_OAuth_Server_Debug::error_log( 'Checking for Password...' );

		return wp_check_password( $password, $user['user_pass'], $user['ID'] );
	}

	/**
	 * Summary of getUser
	 *
	 * @param mixed $username
	 * @return mixed
	 */
	public function getUser( $username ) {
		\MO_OAuth_Server_Debug::error_log( 'Getting User...' );

		global $wpdb;
		$result = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->base_prefix . 'users where user_login = %s', array( $username ) ), ARRAY_A );

		if ( ! $result ) {
			$result = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->base_prefix . 'users where user_email = %s', array( $username ) ), ARRAY_A );
		}

		if ( $result ) {
			if ( isset( $result['ID'] ) ) {
				$result['user_id'] = $result['ID'];
			}
			return $result;
		} else {
			return false;
		}
	}

	/**
	 * Summary of setUser
	 *
	 * @param mixed $username
	 * @param mixed $password
	 * @param mixed $firstName
	 * @param mixed $lastName
	 * @return mixed
	 */
	public function setUser( $username, $password, $firstName = null, $lastName = null ) {
		// do not store in plaintext.
		$password = sha1( $password );

		// if it exists, update it.
		if ( $this->getUser( $username ) ) {
			$stmt = $this->db->prepare( $sql = sprintf( 'UPDATE %s SET password=:password, first_name=:firstName, last_name=:lastName where username=:username', $this->config['user_table'] ) );
		} else {
			$stmt = $this->db->prepare( sprintf( 'INSERT INTO %s (username, password, first_name, last_name) VALUES (:username, :password, :firstName, :lastName)', $this->config['user_table'] ) );
		}

		return $stmt->execute( compact( 'username', 'password', 'firstName', 'lastName' ) );
	}

	/* ScopeInterface */
	/**
	 * Summary of scopeExists
	 *
	 * @param mixed $scope
	 * @return bool
	 */
	public function scopeExists( $scope ) {
		if ( empty( $scope ) ) {
			return false;
		}
		$scope    = explode( ' ', $scope );
		$where_in = implode( ',', $scope );
		$where_in = str_replace( ',', '\',\'', $where_in );

		global $wpdb;
		$result = $wpdb->get_row( 'SELECT count(scope) as count  FROM ' . $wpdb->base_prefix . "moos_oauth_scopes where scope IN ('" . $where_in . "');", ARRAY_A );

		if ( $result ) {
			return $result['count'] == count( $scope );
		}

		return false;
	}

	/**
	 * Summary of getDefaultScope
	 *
	 * @param mixed $client_id
	 * @return string
	 */
	public function getDefaultScope( $client_id = null ) {
		return 'profile email';
	}

	/* JWTBearerInterface */
	/**
	 * Summary of getClientKey
	 *
	 * @param mixed $client_id
	 * @param mixed $subject
	 * @return mixed
	 */
	public function getClientKey( $client_id, $subject ) {
		\MO_OAuth_Server_Debug::error_log( 'Getting Client Key...' );

		$stmt = $this->db->prepare( $sql = sprintf( 'SELECT public_key from %s where client_id=:client_id AND subject=:subject', $this->config['jwt_table'] ) );

		$stmt->execute(
			array(
				'client_id' => $client_id,
				'subject'   => $subject,
			)
		);

		return $stmt->fetchColumn();
	}

	/**
	 * Summary of getClientScope
	 *
	 * @param mixed $client_id
	 * @return mixed
	 */
	public function getClientScope( $client_id ) {
		if ( ! $clientDetails = $this->getClientDetails( $client_id ) ) {
			return false;
		}

		if ( isset( $clientDetails['scope'] ) ) {
			return $clientDetails['scope'];
		}

		return null;
	}

	/**
	 * Summary of getJti
	 *
	 * @param mixed $client_id
	 * @param mixed $subject
	 * @param mixed $audience
	 * @param mixed $expires
	 * @param mixed $jti
	 * @return array|null
	 */
	public function getJti( $client_id, $subject, $audience, $expires, $jti ) {
		\MO_OAuth_Server_Debug::error_log( 'Getting Jti...' );

		$stmt = $this->db->prepare( $sql = sprintf( 'SELECT * FROM %s WHERE issuer=:client_id AND subject=:subject AND audience=:audience AND expires=:expires AND jti=:jti', $this->config['jti_table'] ) );

		$stmt->execute( compact( 'client_id', 'subject', 'audience', 'expires', 'jti' ) );

		if ( $result = $stmt->fetch( 2 ) ) { // Replace the value of \PDO::FETCH_ASSOC.
			return array(
				'issuer'   => $result['issuer'],
				'subject'  => $result['subject'],
				'audience' => $result['audience'],
				'expires'  => $result['expires'],
				'jti'      => $result['jti'],
			);
		}

		\MO_OAuth_Server_Debug::error_log( 'Get Jti returned null...' );
		return null;
	}

	/**
	 * Summary of setJti
	 *
	 * @param mixed $client_id
	 * @param mixed $subject
	 * @param mixed $audience
	 * @param mixed $expires
	 * @param mixed $jti
	 * @return mixed
	 */
	public function setJti( $client_id, $subject, $audience, $expires, $jti ) {
		 \MO_OAuth_Server_Debug::error_log( 'Set Jti returned null...' );

		$stmt = $this->db->prepare( sprintf( 'INSERT INTO %s (issuer, subject, audience, expires, jti) VALUES (:client_id, :subject, :audience, :expires, :jti)', $this->config['jti_table'] ) );

		return $stmt->execute( compact( 'client_id', 'subject', 'audience', 'expires', 'jti' ) );
	}

	/* PublicKeyInterface */
	/**
	 * Summary of getPublicKey
	 *
	 * @param mixed $client_id
	 * @return mixed
	 */
	public function getPublicKey( $client_id = null ) {
		 \MO_OAuth_Server_Debug::error_log( 'Getting Public key...' );

		$stmt = $this->db->prepare( $sql = sprintf( 'SELECT public_key FROM %s WHERE client_id=:client_id OR client_id IS NULL ORDER BY client_id IS NOT NULL DESC', $this->config['public_key_table'] ) );

		$stmt->execute( compact( 'client_id' ) );
		if ( $result = $stmt->fetch( 2 ) ) { // Replace the value of \PDO::FETCH_ASSOC.
			return $result['public_key'];
		}
	}

	/**
	 * Summary of getPrivateKey
	 *
	 * @param mixed $client_id
	 * @return mixed
	 */
	public function getPrivateKey( $client_id = null ) {
		\MO_OAuth_Server_Debug::error_log( 'Getting Private key...' );

		$stmt = $this->db->prepare( $sql = sprintf( 'SELECT private_key FROM %s WHERE client_id=:client_id OR client_id IS NULL ORDER BY client_id IS NOT NULL DESC', $this->config['public_key_table'] ) );

		$stmt->execute( compact( 'client_id' ) );
		if ( $result = $stmt->fetch( 2 ) ) { // Replace the value of \PDO::FETCH_ASSOC.
			return $result['private_key'];
		}
	}

	/**
	 * Summary of getEncryptionAlgorithm
	 *
	 * @param mixed $client_id
	 * @return string
	 */
	public function getEncryptionAlgorithm( $client_id = null ) {
		\MO_OAuth_Server_Debug::error_log( 'Getting Encryption Algorithm...' );

		return 'HS256';
	}

}

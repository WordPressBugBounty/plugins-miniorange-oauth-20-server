<?php
/**
 * RSA key generation for JWT signing.
 *
 * @package Miniorange_Oauth_20_Server
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Generates site-unique RSA key pairs for RS256 JWT signing.
 * Keys are stored directly in moos_oauth_public_keys — the single source of truth.
 * The generated flag in wp_options tracks whether this site has moved off the old shared keys.
 */
class Mo_Oauth_Server_Key_Manager {

	const KEYS_GENERATED_FLAG = 'mo_oauth_server_site_keys_generated';

	/**
	 * Generates a fresh 2048-bit RSA key pair and returns it.
	 * Returns false if the PHP OpenSSL extension is unavailable, generation fails, or an exception is thrown.
	 *
	 * @return array{private_key: string, public_key: string}|false
	 */
	public static function generate_key_pair() {
		if ( ! function_exists( 'openssl_pkey_new' ) ) {
			return false;
		}

		try {
			$config = array(
				'digest_alg'       => 'sha256',
				'private_key_bits' => 2048,
				'private_key_type' => OPENSSL_KEYTYPE_RSA,
			);

			$res = openssl_pkey_new( $config );
			if ( false === $res ) {
				return false;
			}

			openssl_pkey_export( $res, $private_key );
			$details = openssl_pkey_get_details( $res );

			if ( empty( $private_key ) || empty( $details['key'] ) ) {
				return false;
			}

			return array(
				'private_key' => $private_key,
				'public_key'  => $details['key'],
			);
		} catch ( \Throwable $e ) {
			error_log( '[MO OAuth Server] Key pair generation failed: ' . $e->getMessage() ); //phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log -- Logs RSA key generation failure for diagnostics.
			return false;
		}
	}

	/**
	 * Returns true if this site has generated its own unique RSA keys.
	 * False on legacy installs that still carry the shared hardcoded keys.
	 *
	 * @return bool
	 */
	public static function site_keys_generated() {
		return (bool) get_option( self::KEYS_GENERATED_FLAG, false );
	}

	/**
	 * Marks that this site now has site-unique RSA keys in the DB.
	 *
	 * @return void
	 */
	public static function mark_keys_generated() {
		update_option( self::KEYS_GENERATED_FLAG, true, false );
	}

	/**
	 * Generates a fresh key pair per client and updates this site's RS256 rows in moos_oauth_public_keys.
	 * Scoped to get_clients() so rotation never touches another site's keys.
	 *
	 * @return bool False if there are no clients to rotate, or if key generation/update fails.
	 */
	public static function rotate_rs256_clients() {
		require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/class-miniorange-oauth-20-server-db.php';
		$mo_oauth_server_db = new Mo_Oauth_Server_Db();
		$clients            = $mo_oauth_server_db->get_clients();

		if ( empty( $clients ) ) {
			return false;
		}

		global $wpdb;
		$rotated = false;

		foreach ( $clients as $client ) {
			$keys = self::generate_key_pair();
			if ( false === $keys ) {
				return false;
			}

			$result = $wpdb->update( // phpcs:ignore WordPress.DB.DirectDatabaseQuery
				$wpdb->base_prefix . 'moos_oauth_public_keys',
				array(
					'public_key'  => $keys['public_key'],
					'private_key' => $keys['private_key'],
				),
				array(
					'client_id'            => $client->client_id,
					'encryption_algorithm' => 'RS256',
				),
				array( '%s', '%s' ),
				array( '%s', '%s' )
			);

			if ( false === $result ) {
				return false;
			}
			$rotated = true;
		}

		if ( $rotated ) {
			self::mark_keys_generated();
		}
		return $rotated;
	}
}

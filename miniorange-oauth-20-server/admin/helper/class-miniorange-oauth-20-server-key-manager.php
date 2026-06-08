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
			error_log( '[MO OAuth Server] Key pair generation failed: ' . $e->getMessage() );
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
	 * Generates a fresh key pair and updates all RS256 client rows in moos_oauth_public_keys.
	 * Used for the admin-triggered "Rotate RSA Keys" action on existing installs.
	 *
	 * @return bool False if key generation failed (e.g. OpenSSL unavailable).
	 */
	public static function rotate_rs256_clients() {
		$keys = self::generate_key_pair();
		if ( false === $keys ) {
			return false;
		}

		global $wpdb;
		//phpcs:ignore WordPress.DB.DirectDatabaseQuery
		$wpdb->query(
			$wpdb->prepare(
				'UPDATE ' . $wpdb->base_prefix . "moos_oauth_public_keys SET public_key = %s, private_key = %s WHERE encryption_algorithm = 'RS256'",
				$keys['public_key'],
				$keys['private_key']
			)
		);

		self::mark_keys_generated();
		return true;
	}
}

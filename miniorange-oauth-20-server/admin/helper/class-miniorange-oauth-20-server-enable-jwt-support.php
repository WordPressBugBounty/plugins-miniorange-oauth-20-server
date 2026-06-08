<?php
/**
 * Class Miniorange_Oauth_20_Server_Enable_JWT_Support
 *
 * @package Miniorange_Oauth_20_Server
 */

/**
 * Class Miniorange_Oauth_20_Server_Enable_JWT_Support
 *
 * This class handles the addition of a new client.
 */
class Miniorange_Oauth_20_Server_Enable_JWT_Support {

	/**
	 * Utils contains some commonly used functions
	 *
	 * @var [object]
	 */
	private $utils;

	/**
	 * Constructor for MiniOrange_Oauth_20_Server_Enable_JWT_Support.
	 */
	public function __construct() {
		require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/class-miniorange-oauth-20-server-db.php';
		require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/class-miniorange-oauth-20-server-utils.php';
		require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/class-miniorange-oauth-20-server-customer.php';

		$this->utils = new Miniorange_Oauth_20_Server_Utils();
	}

	/**
	 * Save JWT settings from the admin form, or enable JWT for a client when invoked from the Abilities API.
	 *
	 * @param array|null $ability_input When an array (Abilities API), nonce checks are skipped. For enable: application_name
	 *                                    and jwt_signing_algo. For disable: application_name and disabled true (or use the
	 *                                    disable-jwt-support ability which sets disabled). Returns success/message.
	 * @return array|null Structured result for ability calls; otherwise execution stops after redirect.
	 */
	public function handle_enable_jwt_support( $ability_input = null ) {

		$from_ability = is_array( $ability_input );

		if ( ! $from_ability ) {
			if ( ! isset( $_POST['mo_oauth_server_jwt_settings_form_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mo_oauth_server_jwt_settings_form_nonce'] ) ), 'mo_oauth_server_jwt_settings_form' ) ) {
				wp_die( 'Failed nonce verification.' );
			}
		}

		$app_display_name   = '';
		$jwt_signing_algo   = null;
		$ability_disabled   = false;

		if ( $from_ability ) {
			if ( isset( $ability_input['application_name'] ) && is_string( $ability_input['application_name'] ) ) {
				$app_display_name = sanitize_text_field( wp_unslash( $ability_input['application_name'] ) );
			}
			if ( isset( $ability_input['disabled'] ) ) {
				$raw_disabled = $ability_input['disabled'];
				$ability_disabled = ( true === $raw_disabled || 1 === $raw_disabled || '1' === (string) $raw_disabled || 'true' === strtolower( (string) $raw_disabled ) );
			}
			if ( ! $ability_disabled ) {
				if ( isset( $ability_input['jwt_signing_algo'] ) && is_string( $ability_input['jwt_signing_algo'] ) ) {
					$jwt_signing_algo = sanitize_text_field( wp_unslash( $ability_input['jwt_signing_algo'] ) );
				}
				if ( '' === trim( $app_display_name ) || null === $jwt_signing_algo || '' === trim( $jwt_signing_algo ) ) {
					return array(
						'success' => false,
						'message' => 'application_name and jwt_signing_algo are required.',
					);
				}
			} elseif ( '' === trim( $app_display_name ) ) {
				return array(
					'success' => false,
					'message' => 'application_name is required.',
				);
			}
		} else {
			$app_display_name = $this->utils->mo_oauth_get_sanitized_post_value( 'mo_oauth_server_appname' );
			if ( null === $app_display_name || '' === $app_display_name ) {
				update_option( 'message', 'There was an error saving configuration, please try again.' );
				$this->utils->mo_oauth_show_success_message();
				wp_safe_redirect( 'admin.php?page=mo_oauth_server_settings&tab=config' );
				exit;
			}
		}

		$client_name = str_replace( ' ', '_', $app_display_name );

		global $wpdb;
		$myrows = array();
		if ( $from_ability ) {
			$myrows = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->base_prefix . 'moos_oauth_clients WHERE client_name = %s and active_oauth_server_id = %d', $app_display_name, get_current_blog_id() ) ); //phpcs:ignore WordPress.DB.DirectDatabaseQuery
			if ( empty( $myrows ) ) {
				return array(
					'success' => false,
					'message' => 'No OAuth client found for the given application name.',
				);
			}
		}

		if ( $from_ability && $ability_disabled ) {
			update_option( 'mo_oauth_server_enable_jwt_support_for_' . $client_name, 'off' );
			return array(
				'success' => true,
				'message' => 'JWT support disabled successfully.',
			);
		}

		if ( $from_ability ) {
			update_option( 'mo_oauth_server_enable_jwt_support_for_' . $client_name, 'on' );
		} elseif ( ! isset( $_POST[ "mo_server_enable_jwt_support_for_$client_name" ] ) ) {
			update_option( 'mo_oauth_server_enable_jwt_support_for_' . $client_name, 'off' );
		} else {
			update_option( 'mo_oauth_server_enable_jwt_support_for_' . $client_name, 'on' );
		}

		$new_algo = null;
		if ( $from_ability ) {
			$new_algo = $jwt_signing_algo;
		} elseif ( isset( $_POST[ 'mo_oauth_server_jwt_signing_algo_for_' . $client_name ] ) ) {
			$new_algo = sanitize_text_field( wp_unslash( $_POST[ 'mo_oauth_server_jwt_signing_algo_for_' . $client_name ] ) );
		}

		if ( null !== $new_algo ) {
			$previous_setting = get_option( 'mo_oauth_server_jwt_signing_algo_for_' . $client_name ) ? get_option( 'mo_oauth_server_jwt_signing_algo_for_' . $client_name ) : false;
			if ( $previous_setting !== $new_algo ) {
				update_option( 'mo_oauth_server_jwt_signing_algo_for_' . $client_name, $new_algo );
				if ( ! $from_ability ) {
					$myrows = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->base_prefix . 'moos_oauth_clients WHERE client_name = %s and active_oauth_server_id = %d', sanitize_text_field( wp_unslash( $_POST['mo_oauth_server_appname'] ) ), get_current_blog_id() ) ); //phpcs:ignore WordPress.DB.DirectDatabaseQuery
				}
				if ( $from_ability || ! empty( $myrows ) ) {
					$current_config = $new_algo;
					$algo           = explode( 'S', $current_config );
					$client_exists  = $wpdb->query( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->base_prefix . 'moos_oauth_public_keys WHERE client_id = %s', $myrows[0]->client_id ) ); //phpcs:ignore WordPress.DB.DirectDatabaseQuery
					if ( ! $client_exists ) {
						$wpdb->query( $wpdb->prepare( 'INSERT INTO ' . $wpdb->base_prefix . "moos_oauth_public_keys (client_id, public_key, private_key, encryption_algorithm) VALUES (%s, '', '', 'RS256')", $myrows[0]->client_id ) ); //phpcs:ignore WordPress.DB.DirectDatabaseQuery
					}
					if ( isset( $algo[0] ) && 'R' === $algo[0] ) {

						require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/class-miniorange-oauth-20-server-key-manager.php';
						$rsa_keys    = Mo_Oauth_Server_Key_Manager::generate_key_pair();
						$private_key = $rsa_keys ? $rsa_keys['private_key'] : '';
						$public_key  = $rsa_keys ? $rsa_keys['public_key'] : '';

						$wpdb->query( $wpdb->prepare( 'UPDATE ' . $wpdb->base_prefix . 'moos_oauth_public_keys SET public_key = %s, private_key = %s, encryption_algorithm = %s WHERE client_id = %s', $public_key, $private_key, $current_config, $myrows[0]->client_id ) ); //phpcs:ignore WordPress.DB.DirectDatabaseQuery
						Mo_Oauth_Server_Key_Manager::mark_keys_generated();
					} else {
						$wpdb->query( $wpdb->prepare( 'UPDATE ' . $wpdb->base_prefix . "moos_oauth_public_keys SET public_key = '', private_key = %s, encryption_algorithm = %s WHERE client_id = %s", $myrows[0]->client_secret, $current_config, $myrows[0]->client_id ) ); //phpcs:ignore WordPress.DB.DirectDatabaseQuery
					}
				}
			}
		}

		if ( $from_ability ) {
			return array(
				'success' => true,
				'message' => 'JWT support enabled and settings saved successfully.',
			);
		}

		update_option( 'message', 'Your settings are saved successfully.' );
		$this->utils->mo_oauth_show_success_message();
		wp_safe_redirect( 'admin.php?page=mo_oauth_server_settings&tab=config&action=update&client=' . str_replace( '_', '+', $client_name ) );
		exit;
	}
}

<?php
/**
 * Abilities API option save and checkbox state.
 *
 * @package Miniorange_Oauth_20_Server
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Miniorange_Oauth_20_Server_Abilities_Api_Settings
 */
class Miniorange_Oauth_20_Server_Abilities_Api_Settings {

	const OPTION_NAME = 'mo_oauth_server_abilities_api';

	/**
	 * Minimum WordPress version required for the built-in Abilities API.
	 */
	const MINIMUM_WORDPRESS_VERSION = '6.9';

	/**
	 * Whether the plugin should register OAuth Server abilities with the Abilities API.
	 *
	 * @return bool
	 */
	public static function is_enabled() {
		return self::are_prerequisites_met() && 'on' === get_option( self::OPTION_NAME, 'off' );
	}

	/**
	 * Checks whether the current site meets the Abilities API prerequisites.
	 *
	 * @return bool
	 */
	public static function are_prerequisites_met() {
		if ( version_compare( self::get_wordpress_version(), self::MINIMUM_WORDPRESS_VERSION, '<' ) ) {
			return false;
		}

		return function_exists( 'wp_register_ability' ) && function_exists( 'wp_unregister_ability' );
	}

	/**
	 * Gets the prerequisite notice shown on the Abilities API tab.
	 *
	 * @return string Empty when prerequisites are met.
	 */
	public static function get_prerequisite_notice() {
		$current_wordpress_version = self::get_wordpress_version();

		if ( version_compare( $current_wordpress_version, self::MINIMUM_WORDPRESS_VERSION, '<' ) ) {
			return sprintf(
				/* translators: 1: minimum WordPress version, 2: current WordPress version */
				__( 'Abilities API cannot be used because your WordPress version does not meet the minimum requirement. Please update WordPress to version %1$s or higher. Current version: %2$s.', 'miniorange-oauth-20-server' ),
				self::MINIMUM_WORDPRESS_VERSION,
				$current_wordpress_version
			);
		}

		if ( ! function_exists( 'wp_register_ability' ) || ! function_exists( 'wp_unregister_ability' ) ) {
			return __( 'Abilities API cannot be used because the required WordPress Abilities API functions are unavailable.', 'miniorange-oauth-20-server' );
		}

		return '';
	}

	/**
	 * Returns pending prerequisite steps for the Abilities API settings UI.
	 *
	 * Each step is an array with a pre-built HTML string (already escaped where needed).
	 *
	 * @param string $mcp_adapter_url URL for the MCP Adapter plugin.
	 * @return array<int, array{html: string}>
	 */
	public static function get_pending_prerequisite_steps() {
		$steps = array();

		if ( version_compare( self::get_wordpress_version(), self::MINIMUM_WORDPRESS_VERSION, '<' ) ) {
			$steps[] = array(
				'html' => sprintf(
					/* translators: 1: minimum WordPress version, 2: current WordPress version */
					esc_html__( 'Update WordPress to version %1$s or higher (current: %2$s).', 'miniorange-oauth-20-server' ),
					esc_html( self::MINIMUM_WORDPRESS_VERSION ),
					esc_html( self::get_wordpress_version() )
				),
			);
		}

		if (
			version_compare( self::get_wordpress_version(), self::MINIMUM_WORDPRESS_VERSION, '>=' )
			&& ( ! function_exists( 'wp_register_ability' ) || ! function_exists( 'wp_unregister_ability' ) )
		) {
			$steps[] = array(
				'html' => esc_html__( 'Ensure the WordPress Abilities API is available (requires WordPress 6.9 or higher).', 'miniorange-oauth-20-server' ),
			);
		}

		return $steps;
	}

	/**
	 * @param object $utils Miniorange_Oauth_20_Server_Utils for admin notices.
	 */
	public static function save_if_posted( $utils ) {
		$abilities_api_form_nonce = $utils->mo_oauth_get_sanitized_post_value( 'mo_oauth_server_abilities_api_form_nonce' );
		if ( null === $abilities_api_form_nonce || ! wp_verify_nonce( $abilities_api_form_nonce, 'mo_oauth_server_abilities_api_form' ) ) {
			wp_die( 'You are not allowed to perform this action' );
		}

		if ( ! self::are_prerequisites_met() ) {
			update_option( self::OPTION_NAME, 'off', false );
			$prerequisite_notice = self::get_prerequisite_notice();
			update_option(
				'message',
				$prerequisite_notice ? $prerequisite_notice : __( 'Abilities API prerequisites are not met.', 'miniorange-oauth-20-server' ),
				false
			);
			$utils->mo_oauth_show_error_message();
			return;
		}

		$value = null !== $utils->mo_oauth_get_sanitized_post_value( 'mo_oauth_server_abilities_api' ) ? 'on' : 'off';

		update_option( self::OPTION_NAME, $value, false );
		update_option( 'message', ( 'on' === $value ) ? 'Abilities API enabled successfully.' : 'Abilities API disabled successfully.', false );
		$utils->mo_oauth_show_success_message();

		// wp_abilities_api_init already ran earlier on init; sync registry when toggling off in this request.
		if ( 'off' === $value && function_exists( 'wp_unregister_ability' ) ) {
			if ( ! class_exists( 'Miniorange_Oauth_20_Server_Register_Abilities', false ) ) {
				require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/handlers/class-miniorange-oauth-20-server-register-abilities.php';
			}
			Miniorange_Oauth_20_Server_Register_Abilities::mo_oauth_server_unregister_all_abilities();
		}
	}

	/** @return string checked or empty (default off). */
	public static function checkbox_checked_attr() {
		if ( ! self::are_prerequisites_met() ) {
			return '';
		}

		return self::is_enabled() ? 'checked' : '';
	}

	/**
	 * Gets the WordPress version using the available WordPress API.
	 *
	 * @return string
	 */
	private static function get_wordpress_version() {
		if ( function_exists( 'wp_get_wp_version' ) ) {
			return wp_get_wp_version();
		}

		return get_bloginfo( 'version' );
	}

}

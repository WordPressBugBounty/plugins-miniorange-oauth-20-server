<?php
/**
 * Abilities API handler: set or clear the custom OAuth login redirect URL.
 *
 * @package    Miniorange_Oauth_20_Server
 * @subpackage Miniorange_Oauth_20_Server/admin/handlers
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Validates input and updates {@see get_option()} key `mo_oauth_server_custom_login_url` (same as the admin form).
 */
class Miniorange_Oauth_20_Server_Handle_Custom_Login_Url_Ability {

	/**
	 * Persist custom login URL or clear it when empty (invalid non-empty URL returns an error).
	 *
	 * @param string $custom_url Raw or pre-sanitized URL string; empty string clears the option.
	 * @return array Array with keys success (bool), message (string), custom_login_url (string).
	 */
	public static function handle_custom_login_url_ability( $custom_url ) {
		$custom_url = is_string( $custom_url ) ? trim( $custom_url ) : '';

		if ( '' === $custom_url ) {
			update_option( 'mo_oauth_server_custom_login_url', '', false );
			return array(
				'success'          => true,
				'message'          => 'Custom Login URL updated successfully.',
				'custom_login_url' => '',
			);
		}

		if ( ! filter_var( $custom_url, FILTER_VALIDATE_URL ) ) {
			$previous = get_option( 'mo_oauth_server_custom_login_url', '' );
			return array(
				'success'          => false,
				'message'          => 'Please enter a valid URL for the Custom Login URL.',
				'custom_login_url' => is_string( $previous ) ? $previous : '',
			);
		}

		$sanitized = sanitize_url( $custom_url );
		update_option( 'mo_oauth_server_custom_login_url', $sanitized, false );

		return array(
			'success'          => true,
			'message'          => 'Custom Login URL updated successfully.',
			'custom_login_url' => $sanitized,
		);
	}
}

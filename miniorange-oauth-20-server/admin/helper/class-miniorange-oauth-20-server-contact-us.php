<?php
/**
 * Class Miniorange_Oauth_20_Server_Contact_Us
 *
 * @package Miniorange_Oauth_20_Server
 */

/**
 * Class Miniorange_Oauth_20_Server_Contact_Us
 *
 * This class handles the contact us form.
 */
class Miniorange_Oauth_20_Server_Contact_Us {

	/**
	 * Utils contains some commonly used functions
	 *
	 * @var [object]
	 */
	private $utils;

	/**
	 * Constructor for Miniorange_Oauth_20_Server_Contact_Us.
	 */
	public function __construct() {
		require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/class-miniorange-oauth-20-server-db.php';
		require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/class-miniorange-oauth-20-server-utils.php';
		require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/class-miniorange-oauth-20-server-customer.php';

		$this->utils = new Miniorange_Oauth_20_Server_Utils();
	}

	/**
	 * This function handles the contact us form and Abilities API support submissions.
	 *
	 * @param string  $email Email.
	 * @param string  $phone Phone.
	 * @param string  $query Query.
	 * @param string  $no_of_users Number of users (or plan label when used from dashboard contact form).
	 * @param bool   $from_ability When true, returns array with success and message instead of admin notices.
	 * @return void|array Void for admin form; array with success and message keys when $from_ability is true.
	 */
	public function handle_contact_us( $email, $phone, $query, $no_of_users, $from_ability = false ) {

		if ( $this->utils->mo_oauth_server_is_curl_installed() === 0 ) {
			if ( $from_ability ) {
				return array(
					'success' => false,
					'message' => 'The PHP cURL extension is not installed or is disabled. Enable cURL to submit a support request.',
				);
			}
			$this->utils->mo_oauth_show_curl_error();
			return;
		}

		if ( ! empty( $no_of_users ) ) {
			$query = 'Number of Users : ' . esc_attr( $no_of_users ) . ', ' . esc_attr( $query );
		}

		$customer = new Mo_Oauth_Server_Customer();
		if ( $this->utils->mo_oauth_check_empty_or_null( $email ) || $this->utils->mo_oauth_check_empty_or_null( $query ) ) {
			if ( $from_ability ) {
				return array(
					'success' => false,
					'message' => 'Please provide a valid email and support request text to submit your query.',
				);
			}
			update_option( 'message', 'Please fill up Email and Query fields to submit your query.', false );
			$this->utils->mo_oauth_show_error_message();
			return;
		}

		$submited = $customer->submit_contact_us( $email, $phone, $query );
		if ( false === $submited ) {
			if ( $from_ability ) {
				return array(
					'success' => false,
					'message' => 'Your query could not be submitted. Please try again.',
				);
			}
			update_option( 'message', 'Your query could not be submitted. Please try again.', false );
			$this->utils->mo_oauth_show_error_message();
			return;
		}

		if ( $from_ability ) {
			return array(
				'success' => true,
				'message' => 'Thanks for getting in touch! We shall get back to you shortly.',
			);
		}

		update_option( 'message', 'Thanks for getting in touch! We shall get back to you shortly.', false );
		$this->utils->mo_oauth_show_success_message();
	}
}

<?php
/**
 * Fired during plugin activation
 *
 * @link       https://www.miniorange.com
 * @since      1.0.0
 *
 * @package    Miniorange_Oauth_20_Server
 * @subpackage Miniorange_Oauth_20_Server/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Miniorange_Oauth_20_Server
 * @subpackage Miniorange_Oauth_20_Server/includes
 * @author     miniOrange <info@xecurify.com>
 */
class Miniorange_Oauth_20_Server_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * Rejects activation with wp_die() so WordPress never marks the plugin active,
	 * avoiding the live window a deactivate-on-admin_init approach would leave open.
	 *
	 * @since    1.0.0
	 *
	 * @param bool $network_wide True if the plugin is being activated network-wide.
	 * @return void
	 */
	public function activate( $network_wide = false ) {

		if ( $network_wide ) {
			wp_die(
				esc_html__( 'miniOrange OAuth 2.0 Server/Provider cannot be activated network-wide, because its data tables are shared across every site on the network. Please activate it individually on a single site instead.', 'miniorange-oauth-20-server' ),
				esc_html__( 'Plugin activation error', 'miniorange-oauth-20-server' ),
				array( 'back_link' => true )
			);
		}

		$conflicting_site = $this->get_conflicting_site();
		if ( $conflicting_site ) {
			wp_die(
				sprintf(
					/* translators: %s: name (or id) of the site where the plugin is already active */
					esc_html__( 'miniOrange OAuth 2.0 Server/Provider could not be activated: it is already active on "%s" in this network. Only one site can run OAuth Server at a time across a multisite network.', 'miniorange-oauth-20-server' ),
					esc_html( $conflicting_site )
				),
				esc_html__( 'Plugin activation error', 'miniorange-oauth-20-server' ),
				array( 'back_link' => true )
			);
		}

		update_option( 'host_name', 'https://login.xecurify.com' );

		require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/class-miniorange-oauth-20-server-db.php';
		$mo_oauth_server_db = new Mo_Oauth_Server_Db();
		$mo_oauth_server_db->mo_oauth_server_check_db_version();
		$mo_oauth_server_db->mo_oauth_server_create_tables();

		// create a new cronjob to delete old debug logs.
		if ( ! wp_next_scheduled( 'mo_oauth_server_debug_delete_cron_job' ) ) {
			wp_schedule_event( time(), 'weekly', 'mo_oauth_server_debug_delete_cron_job' );
		}
	}

	/**
	 * Checks whether this plugin is already active on another site in the network.
	 *
	 * @return string|false The conflicting site's name (or id, if the name is empty), or false if none.
	 */
	private function get_conflicting_site() {
		if ( ! is_multisite() ) {
			return false;
		}

		$current_blog_id = get_current_blog_id();

		foreach ( get_sites( array( 'fields' => 'ids', 'number' => 0 ) ) as $site_id ) {
			if ( (int) $site_id === (int) $current_blog_id ) {
				continue;
			}
			if ( in_array( MOSERVER_BASENAME, (array) get_blog_option( $site_id, 'active_plugins', array() ), true ) ) {
				$site_details = get_blog_details( $site_id );
				$site_name    = $site_details ? (string) $site_details->blogname : '';
				return '' !== $site_name ? $site_name : (string) $site_id;
			}
		}

		return false;
	}

}

<?php
if ( ! defined( 'ABSPATH' ) ) exit;
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Provide a nav bar view for the plugin.
 *
 * This file is used to markup the nav bar of the plugin.
 *
 * @link       https://www.miniorange.com
 * @since      1.0.0
 *
 * @package    Miniorange_Oauth_20_Server
 * @subpackage Miniorange_Oauth_20_Server/admin/views
 */

?>

<?php require MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/views/miniorange-oauth-20-server-nav-header.php'; ?>

<div class="columns my-2 p-0 mx-0">

	<div class="column has-background-white is-three-fifths mr-1 pb-6" id="dashboard">
		<div style="position: sticky; top: 0;">
			<h2 class="is-size-5 has-text-weight-semibold miniorange-oauth-20-server-card-title">Dashboard</h2>
			<div class="columns mr-1 is-multiline">

				<div class="column is-one-third" onclick="location.href='admin.php?page=mo_oauth_server_settings&tab=config';">
					<div class="card is-clickable is-hoverable miniorange-oauth-20-server-card">
						<div class="card-content p-1 mt-1">
							<div class="media">
								<div class="media-left">
									<i class="fa-solid fa-wrench fa-2x"></i>
								</div>
								<div class="media-content">
									<p class="content-title is-size-6 has-text-weight-bold">Configure Application</p>
								</div>
							</div>
							<div class="content">Configure your OAuth / OpenID compliant application for Single Sign-On.</div>
							<footer class="card-footer">
								<p class="card-footer-item">
									<a class="miniorange-oauth-20-server-orange-color is-size-6 has-text-weight-bold">Let's Go <i class="fa-solid fa-arrow-right"></i></a>
								</p>
							</footer>
						</div>
					</div>
				</div>

				<div class="column is-one-third" onclick="location.href='admin.php?page=mo_oauth_server_settings&tab=advance_settings';">
					<div class="card is-clickable is-hoverable miniorange-oauth-20-server-card">
						<div class="card-content p-1 mt-1">
							<div class="media">
								<div class="media-left">
									<i class="fa-solid fa-gear fa-2x"></i>
								</div>
								<div class="media-content">
									<p class="content-title is-size-6 has-text-weight-bold">Advanced Settings</p>
								</div>
							</div>
							<div class="content">Setup OpenID Connect, enable/disable consent screen etc.</div>
							<footer class="card-footer">
								<p class="card-footer-item">
									<a class="miniorange-oauth-20-server-orange-color is-size-6 has-text-weight-bold">Let's Go <i class="fa-solid fa-arrow-right"></i></a>
								</p>
							</footer>
						</div>
					</div>
				</div>

				<div class="column is-one-third" onclick="location.href='admin.php?page=mo_oauth_server_settings&tab=mcp_settings';">
					<div class="card is-clickable is-hoverable miniorange-oauth-20-server-card">
						<div class="card-content p-1 mt-1">
							<div class="media">
								<div class="media-left">
									<i class="fa-solid fa-robot fa-2x"></i>
								</div>
								<div class="media-content">
									<p class="content-title is-size-6 has-text-weight-bold">MCP Settings</p>
								</div>
							</div>
							<div class="content">Enable your WordPress site as an MCP server for AI assistants like ChatGPT and Claude.</div>
							<footer class="card-footer">
								<p class="card-footer-item">
									<a class="miniorange-oauth-20-server-orange-color is-size-6 has-text-weight-bold">Let's Go <i class="fa-solid fa-arrow-right"></i></a>
								</p>
							</footer>
						</div>
					</div>
				</div>

				<div class="column is-one-third" onclick="location.href='admin.php?page=mo_oauth_server_settings&tab=abilities_api';">
					<div class="card is-clickable is-hoverable miniorange-oauth-20-server-card">
						<div class="card-content p-1 mt-1">
							<div class="media">
								<div class="media-left">
									<i class="fa-solid fa-bolt fa-2x"></i>
								</div>
								<div class="media-content">
									<p class="content-title is-size-6 has-text-weight-bold">Abilities API</p>
								</div>
							</div>
							<div class="content">Register OAuth Server actions as WordPress Abilities so AI clients can invoke them via MCP.</div>
							<footer class="card-footer">
								<p class="card-footer-item">
									<a class="miniorange-oauth-20-server-orange-color is-size-6 has-text-weight-bold">Let's Go <i class="fa-solid fa-arrow-right"></i></a>
								</p>
							</footer>
						</div>
					</div>
				</div>

				<div class="column is-one-third" onclick="location.href='admin.php?page=mo_oauth_server_settings&tab=server_response';">
					<div class="card is-clickable is-hoverable miniorange-oauth-20-server-card">
						<div class="card-content p-1 mt-1">
							<div class="media">
								<div class="media-left">
									<i class="fa-solid fa-server fa-2x"></i>
								</div>
								<div class="media-content">
									<p class="content-title is-size-6 has-text-weight-bold">Server Response</p>
								</div>
							</div>
							<div class="content">Map the attributes or roles sent from your Client application.</div>
							<footer class="card-footer">
								<p class="card-footer-item">
									<a class="miniorange-oauth-20-server-orange-color is-size-6 has-text-weight-bold">Let's Go <i class="fa-solid fa-arrow-right"></i></a>
								</p>
							</footer>
						</div>
					</div>
				</div>

				<div class="column is-one-third" onclick="location.href='admin.php?page=mo_oauth_server_settings&tab=premium_features';">
					<div class="card is-clickable is-hoverable miniorange-oauth-20-server-card">
						<div class="card-content p-1 mt-1">
							<div class="media">
								<div class="media-left">
									<i class="fa-solid fa-gem fa-2x"></i>
								</div>
								<div class="media-content">
									<p class="content-title is-size-6 has-text-weight-bold">Premium Features</p>
								</div>
							</div>
							<div class="content">Checkout membership sync, attribute mapping and other features..</div>
							<footer class="card-footer">
								<p class="card-footer-item">
									<a class="miniorange-oauth-20-server-orange-color is-size-6 has-text-weight-bold">Let's Go <i class="fa-solid fa-arrow-right"></i></a>
								</p>
							</footer>
						</div>
					</div>
				</div>

				<div class="column is-one-third" onclick="location.href='admin.php?page=mo_oauth_server_settings&tab=contact_us';">
					<div class="card is-clickable is-hoverable miniorange-oauth-20-server-card">
						<div class="card-content p-1 mt-1">
							<div class="media">
								<div class="media-left">
									<i class="fa-solid fa-headset fa-2x"></i>
								</div>
								<div class="media-content">
									<p class="content-title is-size-6 has-text-weight-bold">Support</p>
								</div>
							</div>
							<div class="content">Are you facing an issue or have a query? Let us know now!.</div>
							<footer class="card-footer">
								<p class="card-footer-item">
									<a class="miniorange-oauth-20-server-orange-color is-size-6 has-text-weight-bold">Let's Go <i class="fa-solid fa-arrow-right"></i></a>
								</p>
							</footer>
						</div>
					</div>
				</div>

				<div class="column is-one-third" onclick="location.href='admin.php?page=mo_oauth_server_settings&tab=trials_available';">
					<div class="card is-clickable is-hoverable miniorange-oauth-20-server-card">
						<div class="card-content p-1 mt-1">
							<div class="media">
								<div class="media-left">
									<i class="fa-solid fa-person-chalkboard fa-2x"></i>
								</div>
								<div class="media-content">
									<p class="content-title is-size-6 has-text-weight-bold">Trials Available</p>
								</div>
							</div>
							<div class="content">Get a cloud or video demo from our software developer.</div>
							<footer class="card-footer">
								<p class="card-footer-item">
									<a class="miniorange-oauth-20-server-orange-color is-size-6 has-text-weight-bold">Let's Go <i class="fa-solid fa-arrow-right"></i></a>
								</p>
							</footer>
						</div>
					</div>
				</div>

				<div class="column is-one-third" onclick="location.href='admin.php?page=mo_oauth_server_settings&tab=troubleshooting';">
					<div class="card is-clickable is-hoverable miniorange-oauth-20-server-card">
						<div class="card-content p-1 mt-1">
							<div class="media">
								<div class="media-left">
									<i class="fa-solid fa-screwdriver-wrench fa-2x"></i>
								</div>
								<div class="media-content">
									<p class="content-title is-size-6 has-text-weight-bold">Troubleshooting</p>
								</div>
							</div>
							<div class="content">Facing an issue with the plugin or the set up? Enable debug logs.</div>
							<footer class="card-footer">
								<p class="card-footer-item">
									<a class="miniorange-oauth-20-server-orange-color is-size-6 has-text-weight-bold">Let's Go <i class="fa-solid fa-arrow-right"></i></a>
								</p>
							</footer>
						</div>
					</div>
				</div>

				<div class="column is-one-third" onclick="location.href='admin.php?page=mo_oauth_server_settings&tab=account_setup';">
					<div class="card is-clickable is-hoverable miniorange-oauth-20-server-card">
						<div class="card-content p-1 mt-1">
							<div class="media">
								<div class="media-left">
									<i class="fa-solid fa-circle-user fa-2x"></i>
								</div>
								<div class="media-content">
									<p class="content-title is-size-6 has-text-weight-bold">Account Setup</p>
								</div>
							</div>
							<div class="content">Signup or login into your miniOrange account here!</div>
							<footer class="card-footer">
								<p class="card-footer-item">
									<a class="miniorange-oauth-20-server-orange-color is-size-6 has-text-weight-bold">Let's Go <i class="fa-solid fa-arrow-right"></i></a>
								</p>
							</footer>
						</div>
					</div>
				</div>

				<div class="column is-one-third" onclick="window.open('<?php echo esc_url( Miniorange_Oauth_20_Server_Oauth_Constants::PRICING_PLAN_URL ); ?>', '_blank');">
					<div class="card is-clickable is-hoverable miniorange-oauth-20-server-card">
						<div class="card-content p-1 mt-1">
							<div class="media">
								<div class="media-left">
									<i class="fa-solid fa-id-badge fa-2x"></i>
								</div>
								<div class="media-content">
									<p class="content-title is-size-6 has-text-weight-bold">Licensing Plans</p>
								</div>
							</div>
							<div class="content">Interested in our premium features? Check out its features!</div>
							<footer class="card-footer">
								<p class="card-footer-item">
									<a class="miniorange-oauth-20-server-orange-color is-size-6 has-text-weight-bold">Let's Go <span class="dashicons dashicons-external"></span></a>
								</p>
							</footer>
						</div>
					</div>
				</div>

				<div class="column is-one-third" onclick="location.href='admin.php?page=mo_oauth_server_settings&tab=integrations';">
					<div class="card is-clickable is-hoverable miniorange-oauth-20-server-card">
						<div class="card-content p-1 mt-1">
							<div class="media">
								<div class="media-left">
									<i class="fa-solid fa-circle-plus fa-2x"></i>
								</div>
								<div class="media-content">
									<p class="content-title is-size-6 has-text-weight-bold">Integrations</p>
								</div>
							</div>
							<div class="content">Find your memberships application to integrate with the plugin.</div>
							<footer class="card-footer">
								<p class="card-footer-item">
									<a class="miniorange-oauth-20-server-orange-color is-size-6 has-text-weight-bold">Let's Go <i class="fa-solid fa-arrow-right"></i></a>
								</p>
							</footer>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="column has-background-white ml-1 mr-5">
		<div class="columns my-2 p-0 mx-0" id="mo-dasboard-side-panel">
			<?php
			require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/class-miniorange-oauth-20-server-db.php';
			$mo_oauth_server_db       = new Mo_Oauth_Server_Db();
			$clientlist               = $mo_oauth_server_db->get_clients();
			$no_of_configured_clients = count( $clientlist );

			// Load constants-based client configurations.
			require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/constants/class-miniorange-oauth-20-server-oauth-constants.php';
			$oauth_client_list_json_data = Mo_Oauth_Client_Configuration::get_all_client_configurations();

			// get the chosen client from the database.
			$chosen_client = get_option( 'mo_oauth_server_client' ) ? get_option( 'mo_oauth_server_client' ) : '';
			// fetch configuration based on chosen client.
			if ( $chosen_client ) {
				$client_settings = $oauth_client_list_json_data[ $chosen_client ];

				$additional_settings = '';
				if ( isset( $client_settings['additional_settings'] ) ) {
					$additional_settings = $client_settings['additional_settings'];
				}
			} else {
				// Show WordPress configurations by default.
				$client_settings = $oauth_client_list_json_data['wordpress'];
			}

			if ( 1 === $no_of_configured_clients ) {
				$client = $clientlist[0];

				require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/class-miniorange-oauth-20-server-utils.php';
				$mo_utils      = new Miniorange_Oauth_20_Server_Utils();
				$client_secret = $mo_utils->mo_oauth_server_decrypt( esc_attr( $client->client_secret ), esc_attr( $client->client_name ) );
				$client_name   = $client->client_name;
				$client_id     = $client->client_id;
				// if not configured show select list.
				require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/views/miniorange-oauth-20-server-settings-clients-short-summary.php';
			} else {
				// else show short summary.
				require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/views/miniorange-oauth-20-server-settings-welcome-page.php';
			}
			?>
		</div>

	</div>

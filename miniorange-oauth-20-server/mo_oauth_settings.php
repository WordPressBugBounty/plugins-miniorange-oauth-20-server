<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.miniorange.com
 * @since             1.0.0
 * @package           Miniorange_Oauth_20_Server
 *
 * @wordpress-plugin
 * Plugin Name:       miniOrange OAuth 2.0 Server/Provider
 * Plugin URI:        https://www.miniorange.com
 * Description:       Setup your site as Identity Server to allow Login with WordPress or WordPress Login to other client application /site using OAuth / OpenID Connect protocols.
 * Version:           6.1.6
 * Requires at least: 4.8
 * Requires PHP:      5.6
 * Author:            miniOrange
 * Author URI:        https://www.miniorange.com
 * License:           Expat
 * License URI:       https://plugins.miniorange.com/mit-license
 * Text Domain:       miniorange-oauth-20-server
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'MINIORANGE_OAUTH_20_SERVER_VERSION', '6.1.6' );
define( 'MOSERVER_BASENAME', plugin_basename( __FILE__ ));
define( 'MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-miniorange-oauth-20-server-activator.php
 */
function mo_oauth_server_activate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-miniorange-oauth-20-server-activator.php';
	$activator = new Miniorange_Oauth_20_Server_Activator();
	$activator->activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-miniorange-oauth-20-server-deactivator.php
 */
function mo_oauth_server_deactivate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-miniorange-oauth-20-server-deactivator.php';

	$deactivator = new Miniorange_Oauth_20_Server_Deactivator();
	$deactivator->deactivate();
}

register_activation_hook( __FILE__, 'mo_oauth_server_activate' );
register_deactivation_hook( __FILE__, 'mo_oauth_server_deactivate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-miniorange-oauth-20-server.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function mo_oauth_server_run() {

	$plugin = new Miniorange_Oauth_20_Server();
	$plugin->run();

}
mo_oauth_server_run();

<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Abilities API settings tab view.
 *
 * @package Miniorange_Oauth_20_Server
 */

require_once MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_PATH . 'admin/helper/class-miniorange-oauth-20-server-abilities-api-settings.php';
$abilities_api_ready   = Miniorange_Oauth_20_Server_Abilities_Api_Settings::are_prerequisites_met();
$abilities_api_switch  = $abilities_api_ready ? Miniorange_Oauth_20_Server_Abilities_Api_Settings::checkbox_checked_attr() : '';
$pending_prerequisites = $abilities_api_ready ? array() : Miniorange_Oauth_20_Server_Abilities_Api_Settings::get_pending_prerequisite_steps();
?>

<div class="column has-background-white mr-5 px-5">
	<div class="mb-4">
		<h2 class="is-size-5 has-text-weight-semibold miniorange-oauth-20-server-card-title"><?php esc_html_e( 'Abilities API Settings', 'miniorange-oauth-20-server' ); ?></h2>
		<p class="is-size-6 mt-2"><?php esc_html_e( 'Register this plugin\'s OAuth Server capabilities as WordPress Abilities so AI clients can discover and call them via MCP.', 'miniorange-oauth-20-server' ); ?></p>
	</div>

	<!-- Enable Abilities API -->
	<h3 class="has-text-weight-semibold is-blue"><?php esc_html_e( 'Enable Abilities API', 'miniorange-oauth-20-server' ); ?></h3>
	<p class="mt-4 is-size-6"><?php esc_html_e( 'When enabled, this plugin\'s OAuth Server actions are registered as WordPress Abilities, making them discoverable and callable by AI clients via MCP.', 'miniorange-oauth-20-server' ); ?></p>

	<?php if ( ! empty( $pending_prerequisites ) ) : ?>
	<div class="notification is-warning mt-3">
		<p class="has-text-weight-bold mb-2"><?php esc_html_e( 'Complete the following to enable the Abilities API:', 'miniorange-oauth-20-server' ); ?></p>
		<ul style="list-style:disc;margin-left:1.25rem;">
			<?php foreach ( $pending_prerequisites as $pending_prerequisite ) : ?>
			<li class="is-size-6"><?php echo $pending_prerequisite['html']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- HTML is escaped in get_pending_prerequisite_steps(). ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php endif; ?>

	<?php if ( $abilities_api_ready ) : ?>
	<form method="post" action="" name="mo_oauth_server_abilities_api_form">
		<?php wp_nonce_field( 'mo_oauth_server_abilities_api_form', 'mo_oauth_server_abilities_api_form_nonce' ); ?>
		<div class="field mt-3">
			<input id="mo_oauth_server_abilities_api" type="checkbox" name="mo_oauth_server_abilities_api" class="switch is-rounded is-success" <?php echo esc_attr( $abilities_api_switch ); ?> onchange="moOsSubmitForm('mo_oauth_server_abilities_api_form')">
			<label for="mo_oauth_server_abilities_api"><?php esc_html_e( 'Enable Abilities API', 'miniorange-oauth-20-server' ); ?></label>
		</div>
	</form>
	<p class="is-size-7 has-text-grey mt-3">
		<strong><?php esc_html_e( 'Note:', 'miniorange-oauth-20-server' ); ?></strong> <?php esc_html_e( 'Enabling this option will make OAuth Server abilities publicly accessible when connected with MCP.', 'miniorange-oauth-20-server' ); ?>
	</p>
	<?php endif; ?>

	<hr />

	<!-- Setup Guides -->
	<h3 class="has-text-weight-semibold is-blue"><?php esc_html_e( 'Setup Guides', 'miniorange-oauth-20-server' ); ?></h3>
	<p class="mt-4 is-size-6">
		<?php
		echo wp_kses(
			sprintf(
				/* translators: %s: MCP Adapter plugin URL */
				__( 'The built-in MCP endpoint (under <strong>MCP Settings</strong>) is all you need for most AI clients. For broader MCP ecosystem integrations, the optional <a href="%s" target="_blank" rel="noopener noreferrer">MCP Adapter</a> plugin can be installed alongside this one.', 'miniorange-oauth-20-server' ),
				'https://github.com/WordPress/mcp-adapter'
			),
			array(
				'strong' => array(),
				'a'      => array(
					'href'   => true,
					'target' => true,
					'rel'    => true,
				),
			)
		);
		?>
	</p>
	<div class="columns is-multiline mt-4">
		<?php
		$mo_oauth_server_abilities_guide_clients = array(
			array(
				'image' => 'claude-ai-icon.svg',
				'label' => __( 'Claude Desktop', 'miniorange-oauth-20-server' ),
				'url'   => 'https://plugins.miniorange.com/connect-wordpress-with-claude-mcp-guide',
			),
			array(
				'image' => 'cursor-ai-code-icon.svg',
				'label' => __( 'Cursor', 'miniorange-oauth-20-server' ),
				'url'   => 'https://plugins.miniorange.com/connect-wordpress-with-cursor-mcp-guide',
			),
			array(
				'image' => 'chatgpt-icon.svg',
				'label' => __( 'ChatGPT', 'miniorange-oauth-20-server' ),
				'url'   => 'https://plugins.miniorange.com/wordpress-chatgpt-integration',
			),
		);
		foreach ( $mo_oauth_server_abilities_guide_clients as $mo_oauth_server_abilities_guide_client ) :
		?>
		<div class="column is-one-third">
			<div class="is-flex is-align-items-center p-3" style="border:1px solid #dbdbdb;border-radius:6px;gap:0.75rem;">
				<img src="<?php echo esc_url( MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_URL . 'assets/' . $mo_oauth_server_abilities_guide_client['image'] ); ?>"
					style="width:36px;height:36px;border-radius:6px;"
					alt="<?php echo esc_attr( $mo_oauth_server_abilities_guide_client['label'] ); ?>">
				<div style="flex:1;min-width:0;">
					<p class="has-text-weight-semibold is-size-6" style="line-height:1.2;"><?php echo esc_html( $mo_oauth_server_abilities_guide_client['label'] ); ?></p>
				</div>
				<a href="<?php echo esc_url( $mo_oauth_server_abilities_guide_client['url'] ); ?>"
					target="_blank" rel="noopener noreferrer"
					class="button is-blue is-small" style="white-space:nowrap;">
					<?php esc_html_e( 'Guide', 'miniorange-oauth-20-server' ); ?> <i class="fa-solid fa-arrow-right ml-1"></i>
				</a>
			</div>
		</div>
		<?php endforeach; ?>
	</div>

</div>

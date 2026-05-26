<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * MCP Settings admin view.
 *
 * Allows the admin to enable/disable the MCP endpoint, choose the auth method,
 * and select which WordPress Abilities to expose (to stay within ChatGPT's 128-tool limit).
 *
 * Variables injected by mo_oauth_server_handle_mcp_settings_page():
 *   $mcp_enabled   — 'checked' or ''
 *   $mcp_auth      — 'application_password' | 'oauth' | 'both'
 *   $mcp_abilities — array of currently selected ability slugs
 *
 * @package    Miniorange_Oauth_20_Server
 * @subpackage Miniorange_Oauth_20_Server/admin/views
 */

$mo_oauth_server_mcp_endpoint_url = rest_url( 'moserver/mcp' );

// Collect all registered abilities for the checkbox list.
$mo_oauth_server_mcp_all_abilities = array();
if ( function_exists( 'wp_get_abilities' ) ) {
	foreach ( wp_get_abilities() as $mo_oauth_server_mcp_ab ) {
		if ( is_object( $mo_oauth_server_mcp_ab ) && method_exists( $mo_oauth_server_mcp_ab, 'get_name' ) ) {
			$mo_oauth_server_mcp_all_abilities[] = array(
				'slug'  => $mo_oauth_server_mcp_ab->get_name(),
				'label' => method_exists( $mo_oauth_server_mcp_ab, 'get_description' ) ? $mo_oauth_server_mcp_ab->get_description() : $mo_oauth_server_mcp_ab->get_name(),
			);
		}
	}
}

$mo_oauth_server_mcp_total_abilities = count( $mo_oauth_server_mcp_all_abilities );
$mo_oauth_server_mcp_selected_count  = empty( $mcp_abilities ) ? $mo_oauth_server_mcp_total_abilities : count( array_intersect( wp_list_pluck( $mo_oauth_server_mcp_all_abilities, 'slug' ), $mcp_abilities ) );
$mo_oauth_server_mcp_over_limit      = $mo_oauth_server_mcp_selected_count > 128;
?>

<div class="column has-background-white mr-5 px-5" style="min-width: 0;">
	<div class="mb-4">
		<h2 class="is-size-5 has-text-weight-semibold miniorange-oauth-20-server-card-title">MCP Settings</h2>
		<p class="is-size-6 mt-2">Enable your WordPress site as an MCP (Model Context Protocol) server so AI assistants like ChatGPT and Claude Code can call WordPress Abilities via a secure, authenticated endpoint.</p>
	</div>

	<!-- Enable / Disable MCP -->
	<form method="post" action="" name="mo_oauth_server_mcp_enable_form">
		<?php wp_nonce_field( 'mo_oauth_server_mcp_enable_form', 'mo_oauth_server_mcp_enable_form_nonce' ); ?>
		<h3 class="has-text-weight-semibold is-blue">Enable MCP Endpoint</h3>
		<p class="mt-4 is-size-6">When enabled, AI agents can connect to this site at the MCP endpoint below.</p>
		<div class="field mt-3">
			<input id="mo_oauth_server_mcp_enabled" type="checkbox" name="mo_oauth_server_mcp_enabled"
				class="switch is-rounded is-success"
				<?php echo esc_attr( $mcp_enabled ); ?>
				onchange="moOsSubmitForm('mo_oauth_server_mcp_enable_form')">
			<label for="mo_oauth_server_mcp_enabled">Enable MCP</label>
		</div>
		<?php if ( 'checked' === $mcp_enabled ) : ?>
		<div class="columns mt-3">
			<div class="column is-one-third">
				<label class="label">MCP Endpoint URL:</label>
			</div>
			<div class="column is-two-thirds">
				<div class="field has-addons">
					<div class="control is-expanded">
						<input class="input" type="text" readonly value="<?php echo esc_attr( $mo_oauth_server_mcp_endpoint_url ); ?>" id="mo_mcp_endpoint_url">
					</div>
					<div class="control">
						<button type="button" class="button is-blue is-outlined"
							onclick="navigator.clipboard.writeText(document.getElementById('mo_mcp_endpoint_url').value)">
							<i class="fa-regular fa-copy"></i>
						</button>
					</div>
				</div>
			</div>
		</div>
		<?php endif; ?>
	</form>

	<hr />

	<!-- Authorization Method -->
	<form method="post" action="">
		<?php wp_nonce_field( 'mo_oauth_server_mcp_auth_form', 'mo_oauth_server_mcp_auth_form_nonce' ); ?>
		<h3 class="has-text-weight-semibold is-blue">Authorization Method</h3>
		<p class="mt-4 is-size-6">Choose how AI agents must authenticate when calling the MCP endpoint.</p>
		<div class="field mt-3">
			<label class="radio">
				<input type="radio" name="mo_oauth_server_mcp_auth_method" value="both"
					<?php checked( $mcp_auth, 'both' ); ?>>
				<strong>Both</strong> &mdash; Accept either OAuth 2.0 Bearer tokens or WordPress Application Passwords
			</label>
		</div>
		<div class="field">
			<label class="radio">
				<input type="radio" name="mo_oauth_server_mcp_auth_method" value="oauth"
					<?php checked( $mcp_auth, 'oauth' ); ?>>
				<strong>OAuth 2.0 Bearer Token</strong> &mdash; Requires a token issued by this plugin's <code>/wp-json/moserver/token</code> endpoint (recommended)
			</label>
		</div>
		<div class="field">
			<label class="radio">
				<input type="radio" name="mo_oauth_server_mcp_auth_method" value="application_password"
					<?php checked( $mcp_auth, 'application_password' ); ?>>
				<strong>WordPress Application Password</strong> &mdash; Use a WP Application Password via HTTP Basic auth
			</label>
		</div>
		<div class="field is-grouped mt-4">
			<div class="control">
				<button class="button is-active is-blue" type="submit">Save Authorization Method</button>
			</div>
		</div>
	</form>

	<hr />

	<!-- AI Client OAuth Setup -->
	<h3 class="has-text-weight-semibold is-blue">Connect an AI Client</h3>
	<p class="mt-4 is-size-6">
		Each AI tool that connects to this MCP endpoint needs an OAuth 2.0 client registered under
		<a href="<?php echo esc_url( admin_url( 'admin.php?page=mo_oauth_server_settings&tab=config' ) ); ?>">Configure your Application</a>.
		Pre-configured templates are available for the clients below.
	</p>

	<?php
	$mo_oauth_server_mcp_client_refs = array(
		array( 'key' => 'claude',       'label' => 'Claude (Anthropic)',    'image' => 'claude-ai-icon.svg' ),
		array( 'key' => 'chatgpt',      'label' => 'ChatGPT (OpenAI)',      'image' => 'chatgpt-icon.svg' ),
		array( 'key' => 'cursor',       'label' => 'Cursor',                'image' => 'cursor-ai-code-icon.svg' ),
		array( 'key' => 'windsurf',     'label' => 'Windsurf',              'image' => 'Windsurf.svg' ),
		array( 'key' => 'genericAiMcp', 'label' => 'Generic AI MCP Client', 'image' => 'GenericAI.svg' ),
	);
	?>

	<div class="columns is-multiline mt-4">
		<?php foreach ( $mo_oauth_server_mcp_client_refs as $mo_oauth_server_mcp_client_ref ) : ?>
		<div class="column is-half">
			<div class="is-flex is-align-items-center p-3" style="border:1px solid #dbdbdb;border-radius:6px;gap:0.75rem;">
				<img src="<?php echo esc_attr( MINIORANGE_OAUTH_20_SERVER_PLUGIN_DIR_URL ) . 'assets/' . esc_attr( $mo_oauth_server_mcp_client_ref['image'] ); ?>"
					style="width:36px;height:36px;border-radius:6px;" alt="<?php echo esc_attr( $mo_oauth_server_mcp_client_ref['label'] ); ?>">
				<p class="has-text-weight-semibold is-size-6"><?php echo esc_html( $mo_oauth_server_mcp_client_ref['label'] ); ?></p>
			</div>
		</div>
		<?php endforeach; ?>
	</div>

	<hr />

	<!-- Allowed Abilities -->
	<form method="post" action="">
		<?php wp_nonce_field( 'mo_oauth_server_mcp_abilities_form', 'mo_oauth_server_mcp_abilities_form_nonce' ); ?>
		<h3 class="has-text-weight-semibold is-blue">Exposed Abilities (Tools)</h3>
		<p class="mt-4 is-size-6">
			Select which WordPress Abilities to expose via MCP. Leave all unchecked to expose every registered ability.
		</p>

		<?php if ( $mo_oauth_server_mcp_over_limit ) : ?>
		<div class="notification is-warning mt-3">
			<strong><i class="fa-solid fa-triangle-exclamation mr-1"></i> Tool count warning:</strong>
			<?php echo esc_html( $mo_oauth_server_mcp_selected_count ); ?> abilities selected.
			ChatGPT supports a maximum of 128 tools — only the first 128 will be returned.
			Uncheck abilities you do not need to stay within the limit.
		</div>
		<?php else : ?>
		<p class="is-size-7 mt-2 has-text-grey">
			<?php
			echo esc_html(
				sprintf(
					/* translators: 1: number of selected tools, 2: total registered abilities */
					'%1$d of %2$d abilities will be exposed.',
					$mo_oauth_server_mcp_selected_count,
					$mo_oauth_server_mcp_total_abilities
				)
			);
			?>
		</p>
		<?php endif; ?>

		<?php if ( empty( $mo_oauth_server_mcp_all_abilities ) ) : ?>
		<div class="notification is-info mt-3">
			No WordPress Abilities are currently registered on this site. Install a plugin that registers abilities
			(such as the miniOrange AI Governance plugin) to use MCP tool calls.
		</div>
		<?php else : ?>
		<div class="columns is-multiline mt-3">
			<?php foreach ( $mo_oauth_server_mcp_all_abilities as $mo_oauth_server_mcp_ability_item ) : ?>
			<div class="column is-half">
				<label class="checkbox">
					<input type="checkbox"
						name="mo_oauth_server_mcp_allowed_abilities[]"
						value="<?php echo esc_attr( $mo_oauth_server_mcp_ability_item['slug'] ); ?>"
						<?php
						if ( empty( $mcp_abilities ) || in_array( $mo_oauth_server_mcp_ability_item['slug'], $mcp_abilities, true ) ) {
							echo 'checked';
						}
						?>
						>
					<strong><?php echo esc_html( $mo_oauth_server_mcp_ability_item['slug'] ); ?></strong><br>
					<span class="is-size-7 has-text-grey"><?php echo esc_html( $mo_oauth_server_mcp_ability_item['label'] ); ?></span>
				</label>
			</div>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>

		<div class="field is-grouped mt-4">
			<div class="control">
				<button class="button is-active is-blue" type="submit">Save Abilities</button>
			</div>
		</div>
	</form>

	<hr />

	<!-- Quick-start Instructions -->
	<h3 class="has-text-weight-semibold is-blue">Quick Start</h3>
	<p class="mt-3 is-size-6">Test your MCP endpoint with curl after enabling it above:</p>
	<pre class="mt-3" style="background:#f5f5f5;padding:1rem;border-radius:4px;overflow-x:auto;font-size:0.85rem"># 1. Get an OAuth 2.0 access token (replace CLIENT_ID, CLIENT_SECRET, AUTH_CODE, REDIRECT_URI)
curl -X POST <?php echo esc_url( rest_url( 'moserver/token' ) ); ?> \
	-d "grant_type=authorization_code&code=AUTH_CODE&client_id=CLIENT_ID&client_secret=CLIENT_SECRET&redirect_uri=REDIRECT_URI"

# 2. Call the MCP initialize method (replace ACCESS_TOKEN)
curl -X POST <?php echo esc_url( $mo_oauth_server_mcp_endpoint_url ); ?> \
	-H "Authorization: Bearer ACCESS_TOKEN" \
	-H "Content-Type: application/json" \
	-d '{"jsonrpc":"2.0","id":1,"method":"initialize","params":{"protocolVersion":"2025-11-25"}}'

# 3. List available tools
curl -X POST <?php echo esc_url( $mo_oauth_server_mcp_endpoint_url ); ?> \
	-H "Authorization: Bearer ACCESS_TOKEN" \
	-H "Content-Type: application/json" \
	-d '{"jsonrpc":"2.0","id":2,"method":"tools/list","params":{}}'</pre>

	<p class="mt-3 is-size-7 has-text-grey">
		<strong>Note:</strong> If you see a 404 on the MCP endpoint after first enabling, go to
		<a href="<?php echo esc_url( admin_url( 'options-permalink.php' ) ); ?>">Settings &rarr; Permalinks</a>
		and click <strong>Save Changes</strong> to flush rewrite rules.
	</p>

</div>
</div>

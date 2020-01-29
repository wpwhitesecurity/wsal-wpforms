<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WSAL_PluginInstallAndActivate' ) ) {
  class WSAL_PluginInstallAndActivate {

		/**
		 * Activates a plugin that is available on the site.
		 *
		 * @method activate
		 * @since  x.x.x
		 * @param  string $plugin_slug [description]
		 * @return [type]
		 */
		 public function is_plugin_installed( $plugin_slug = '' ) {
	 		// bail early if we don't have a slug to work with.
	 		if ( empty( $plugin_slug ) ) {
	 			return;
	 		}
	 		// bail early if this is not in the list of allowed plugins.
	 		// TODO: check if this is in allowed list.
			if ( ! function_exists( 'get_plugins' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}
			$all_plugins = get_plugins();

			if ( ! empty( $all_plugins[ $plugin_slug ] ) ) {
				return true;
			} else {
				return false;
			}
	 	}


		/**
		 * Render the table or list here in the class.
		 *
		 * @method render
		 * @since  1.0.0
		 */
		public function render() {
			$our_plugins = $this->get_installable_plugins();
			?>
			<table id="tab-third-party-plugins" class="form-table wp-list-table wsal-tab widefat fixed"  style="display: table;" cellspacing="0">
				<p><?php esc_html_e( 'To keep a log of changes done in any of the below plugins install the add-on for that plugin by clicking the Install Add-on button.', 'wp-security-audit-log' ); ?></p>
				<tbody>
					<tr>
						<?php
						// Create a nonce to pass through via data attr.
						$nonce = wp_create_nonce( 'wsal-install-addon' );
						// Loop through plugins and output.
						foreach ( $our_plugins as $details ) {
							$disable_button = '';
							if( $this->is_plugin_installed( $details['plugin_slug'] ) && ! is_plugin_active( $details['plugin_slug'] ) || $this->is_plugin_installed( $details['plugin_slug'] ) && is_plugin_active( $details['plugin_slug'] )) {
								$disable_button = 'disabled';
							}
							?>
							<td style="width: 50%;">
								<div class="addon-wrapper">
									<img src="<?php echo esc_url( trailingslashit( WSAL_BASE_URL ) ) . 'img/addons/' . $details['image_filename']; ?>">
									<p><button class="install-addon button button-primary <?php echo esc_attr( $disable_button ); ?>" data-nonce="<?php echo esc_attr( $nonce ); ?>" data-plugin-slug="<?php echo esc_attr( $details['plugin_slug'] ); ?>" data-plugin-download-url="<?php echo esc_url( $details['plugin_url'] ); ?>" data-plugin-event-tab-id="<?php echo esc_attr( $details['event_tab_id'] ); ?>">
									<?php
										if( $this->is_plugin_installed( $details['plugin_slug'] ) && ! is_plugin_active( $details['plugin_slug'] ) ) {
											esc_html_e( 'Addon installed, activate now?', 'wp-security-audit-log' );
										} elseif( $this->is_plugin_installed( $details['plugin_slug'] ) && is_plugin_active( $details['plugin_slug'] ) ) {
											esc_html_e( 'Addon installed', 'wp-security-audit-log' );
										} else {
												esc_html_e( 'Install Add-on', 'wp-security-audit-log' );
										}
									?>
								</button><span class="spinner" style="display: none; visibility: visible; float: none; margin: 0 0 0 8px;"></span></p>
								</div>
							</td>
							<?php
						}
						?>
					</tr>
				</tbody>
			</table>
			<?php
		}

		/**
		 * Get a list of the data for the plugins that are allowable.
		 *
		 * @method get_installable_plugins
		 * @since
		 * @return [type]
		 */
		public static function get_installable_plugins() {
			$plugins = array(
				array(
					'title'          => 'BBPress Add-on',
					'image_filename' => 'bbpress.png',
					'plugin_slug'    => 'wp-bootstrap-blocks/wp-bootstrap-blocks.php',
					'plugin_url'     => 'https://downloads.wordpress.org/plugin/wp-bootstrap-blocks.latest-stable.zip',
					'event_tab_id'   => '#tab-bbpress-forums',
				),
				array(
					'title'          => 'WPForms Add-on',
					'image_filename' => 'wpforms.png',
					'plugin_slug'    => 'google-sitemap-generator/sitemap.php',
					'plugin_url'     => 'https://downloads.wordpress.org/plugin/google-sitemap-generator.latest-stable.zip',
					'event_tab_id'   => '#tab-wpforms',
				),
			);
			return apply_filters( 'wsal_filter_installable_plugins', $plugins );
		}
	}
}

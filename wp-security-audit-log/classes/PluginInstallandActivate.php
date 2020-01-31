<?php
/**
 * Handler to install activate plugins.
 *
 * Provides the allowed plugins data as well as a render method to display the
 * items inside of a table with install/actiavte buttons.
 *
 * @package Wsal
 * @since 4.0.1
 */

if ( ! class_exists( 'WSAL_PluginInstallAndActivate' ) ) {

	/**
	 * Class to handle checking plugin status and rendering data about any that
	 * are installable.
	 *
	 * @since 4.0.1
	 */
	class WSAL_PluginInstallAndActivate {


		/**
		 * Checks if the plugin is already available/installed on the site.
		 *
		 * @method is_plugin_installed
		 * @since  4.0.1
		 * @param  string $plugin_slug installed plugin slug.
		 * @return void|bool
		 */
		public function is_plugin_installed( $plugin_slug = '' ) {
			// bail early if we don't have a slug to work with.
			if ( empty( $plugin_slug ) ) {
				return;
			}

			// check if the slug is in the installable list.
			$is_allowed_slug = false;
			$allowed_plugins = self::get_installable_plugins();
			if ( is_array( $allowed_plugins ) ) {
				foreach ( $allowed_plugins as $allowed_plugin ) {
					// if we alredy found an allowed slug then break.
					if ( true === $is_allowed_slug ) {
						break;
					}
					$is_allowed_slug = ( isset( $allowed_plugin['plugin_slug'] ) && $allowed_plugin['plugin_slug'] === $plugin_slug ) ? true : false;
				}
			}

			// bail early if this is not an allowed plugin slug.
			if ( ! $is_allowed_slug ) {
				return;
			}

			// get core plugin functions if they are not already in runtime.
			if ( ! function_exists( 'get_plugins' ) ) {
				include_once ABSPATH . 'wp-admin/includes/plugin.php';
			}
			$all_plugins = get_plugins();

			if ( ! empty( $all_plugins[ $plugin_slug ] ) ) {
				return true;
			} else {
				return false;
			}
		}


		/**
		 * Renders a table containing info about each of the installable
		 * plugins and a button to install them.
		 *
		 * @method render
		 * @since  4.0.1
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
							if ( is_plugin_active( $details['plugin_slug'] ) ) {
								$disable_button = 'disabled';
							}
							?>
							<td style="width: 50%;">
								<div class="addon-wrapper">
									<img src="<?php echo esc_url( trailingslashit( WSAL_BASE_URL ) . 'img/addons/' . $details['image_filename'] ); ?>">
									<p>
										<button class="install-addon button button-primary <?php echo esc_attr( $disable_button ); ?>" data-nonce="<?php echo esc_attr( $nonce ); ?>" data-plugin-slug="<?php echo esc_attr( $details['plugin_slug'] ); ?>" data-plugin-download-url="<?php echo esc_url( $details['plugin_url'] ); ?>" data-plugin-event-tab-id="<?php echo esc_attr( $details['event_tab_id'] ); ?>">
											<?php
											if ( $this->is_plugin_installed( $details['plugin_slug'] ) && ! is_plugin_active( $details['plugin_slug'] ) ) {
												esc_html_e( 'Addon installed, activate now?', 'wp-security-audit-log' );
											} elseif ( $this->is_plugin_installed( $details['plugin_slug'] ) && is_plugin_active( $details['plugin_slug'] ) ) {
												esc_html_e( 'Addon installed', 'wp-security-audit-log' );
											} else {
												esc_html_e( 'Install Add-on', 'wp-security-audit-log' );
											}
											?>
										</button><span class="spinner" style="display: none; visibility: visible; float: none; margin: 0 0 0 8px;"></span>
									</p>
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
		 * @since  4.0.1
		 */
		public static function get_installable_plugins() {
			$plugins = array(
				array(
					'title'          => 'BBPress Add-on',
					'image_filename' => 'bbpress.png',
					'plugin_slug'    => 'wp-bootstrap-blocks/wp-bootstrap-blocks.php',
					'plugin_url'     => 'https://downloads.wordpress.org/plugin/wp-bootstrap-blocks.latest-stable.zip', // TODO: make this match live url.
					'event_tab_id'   => '#tab-bbpress-forums',
				),
				array(
					'title'          => 'WPForms Add-on',
					'image_filename' => 'wpforms.png',
					'plugin_slug'    => 'google-sitemap-generator/sitemap.php',
					'plugin_url'     => 'https://downloads.wordpress.org/plugin/google-sitemap-generator.latest-stable.zip', // TODO: make this match live URL.
					'event_tab_id'   => '#tab-wpforms',
				),
			);
			// runs through a filter so it can be added to programatically.
			// NOTE: this means when using we need to test it's still an array.
			return apply_filters( 'wsal_filter_installable_plugins', $plugins );
		}
	}
}

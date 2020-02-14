<?php
/**
 * Plugin installer action
 *
 * Class file for installing plugins from the repo.
 *
 * @since   4.0.1
 * @package Wsal
 */

if ( ! class_exists( 'WSAL_PluginInstallerAction' ) ) {

	/**
	 * Class to handle the installtion and activation of plugins.
	 *
	 * @since 4.0.1
	 */
	class WSAL_PluginInstallerAction {

		public function __construct() {
	 		$this->register();
	 	}

		/**
		 * Register the ajax action.
		 *
		 * @method register
		 * @since  4.0.1
		 */
		public function register() {
			add_action( 'wp_ajax_run_addon_install', array( $this, 'run_addon_install' ) );
		}

		/**
		 * Run the installer.
		 *
		 * @method run_addon_install
		 * @since  4.0.1
		 */
		public function run_addon_install() {
			check_ajax_referer( 'wsal-install-addon' );

			$plugin_zip  = ( isset( $_POST['plugin_url'] ) ) ? esc_url_raw( wp_unslash( $_POST['plugin_url'] ) ) : '';
			$plugin_slug = ( isset( $_POST['plugin_slug'] ) ) ? sanitize_textarea_field( wp_unslash( $_POST['plugin_slug'] ) ) : '';

			$valid_plugin_slug = 'wp-security-audit-log/wp-security-audit-log.php';
			$valid_plugin_url = 'https://downloads.wordpress.org/plugin/wp-security-audit-log.latest-stable.zip';

			// validate that the plugin is allowed.
			$valid = false;
			$valid = ( $plugin_zip === $valid_plugin_url && $plugin_slug === $valid_plugin_slug ) ? true : false;

			// bail early if we didn't get a valid url and slug to install.
			if ( ! $valid ) {
				wp_send_json_error(
					array(
						'message' => esc_html__( 'Tried to install a zip or slug that was not in the allowed list', 'wp-security-audit-log' ),
					)
				);
			}

			// Check if the plugin is installed.
			if ( $this->is_plugin_installed( $plugin_slug ) ) {
				// If plugin is installed but not active, activate it.
				if ( ! is_plugin_active( $plugin_slug ) ) {
					$this->activate( $plugin_slug );
					$result = 'activated';
				} else {
					$result = 'already_installed';
				}
			} else {
				// No plugin found or plugin not present to be activated, so lets install it.
				$this->install_plugin( $plugin_zip );
				$this->activate( $plugin_slug );
				$result = 'success';
			}

			wp_send_json( $result );
		}

		/**
		 * Install a plugin given a slug.
		 *
		 * @method install
		 * @since  4.0.1
		 * @param  string $plugin_zip URL to the direct zip file.
		 */
		public function install_plugin( $plugin_zip = '' ) {
			// bail early if we don't have a slug to work with.
			if ( empty( $plugin_zip ) ) {
				return;
			}
			// get the core plugin upgrader if not already in the runtime.
			if ( ! class_exists( 'Plugin_Upgrader' ) ) {
				include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
			}
			// clear the cache so we're using fresh data.
			wp_cache_flush();
			$upgrader       = new Plugin_Upgrader();
			$install_result = $upgrader->install( $plugin_zip );
			if ( ! $install_result || is_wp_error( $install_result ) ) {
				if ( is_wp_error( $install_result ) ) {
					return $install_result->get_error_message();
				}
				die();
			}
		}

		/**
		 * Activates a plugin that is available on the site.
		 *
		 * @method run_activate
		 * @since  4.0.1
		 * @param  string $plugin_slug slug for plugin.
		 */
		public function activate( $plugin_slug = '' ) {
			// bail early if we don't have a slug to work with.
			if ( empty( $plugin_slug ) ) {
				return;
			}

			$current = get_option( 'active_plugins' );
			$plugin  = plugin_basename( trim( $plugin_slug ) );
			if ( is_multisite() ) {
				// confirm flag saying this was on plugins-network was passed.
				if ( filter_input( INPUT_POST, 'is_network', FILTER_VALIDATE_BOOLEAN ) ) {
					// looks like this was passed from the wrong screen.
					return false;
				}
				// before we handle network updates ensure user is allowed.
				if ( ! current_user_can( 'manage_network_plugins' ) ) {
					// fail.
					return false;
				}
				// since no current screen is set fake it via constant.
				if ( ! defined( 'WP_NETWORK_ADMIN' ) ) {
					define( 'WP_NETWORK_ADMIN', true );
				}
				$result = activate_plugin( $plugin_slug, null, WP_NETWORK_ADMIN );

			} else {
				if ( ! in_array( $plugin_slug, $current, true ) ) {
					$current[] = $plugin_slug;
					activate_plugin( $plugin_slug );
				}
			}

			return null;
		}

		/**
		 * Check if a plugin is installed.
		 *
		 * @method is_plugin_installed
		 * @since  4.0.1
		 * @param  string $plugin_slug slug for plugin.
		 */
		public function is_plugin_installed( $plugin_slug = '' ) {
			// bail early if we don't have a slug to work with.
			if ( empty( $plugin_slug ) ) {
				return;
			}

			// get core plugin functions if not already in the runtime.
			if ( ! function_exists( 'get_plugins' ) ) {
				include_once ABSPATH . 'wp-admin/includes/plugin.php';
			}
			$all_plugins = get_plugins();

			// true if plugin is already installed or false if not.
			if ( ! empty( $all_plugins[ $plugin_slug ] ) ) {
				return true;
			} else {
				return false;
			}

		}
	}
}

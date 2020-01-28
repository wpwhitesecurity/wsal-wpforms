<?php

/**
 * An abstract class to be used when creating ajax actions. This ensures a consistent
 * way of using them and invoking them.
 */

if ( ! class_exists( 'PluginInstallerAction' ) ) {
	class PluginInstallerAction {

	/**
	 * Sets up the properties for this ajax endpoint.
	 *
	 * @method __construct
	 * @since  1.0.0
	 */
	public function __construct() {
 		$this->register();
 	}

	/**
	 * Register the ajax action.
	 *
	 * @method register
	 * @since  1.0.0
	 */
	public function register() {
		add_action( 'wp_ajax_run_addon_install', array( $this, 'run_addon_install' ) );
	}

	/**
	 * Run the installer.
	 *
	 * @method run_addon_install
	 * @since  1.0.0
	 */
	public function run_addon_install() {
		check_ajax_referer( 'wsal-install-addon' );

		$plugin_zip = esc_url( wp_unslash( $_POST[ 'plugin_url' ] ) );
		$plugin_slug = sanitize_textarea_field( $_POST[ 'plugin_slug' ] );

		$predefined_plugins = WSAL_PluginInstallAndActivate::get_installable_plugins();
		$valid = false;

		foreach ( $predefined_plugins as $plugin ) {
			if( $plugin_zip !== $plugin[ 'plugin_url' ] || $plugin_slug !== $plugin[ 'plugin_slug' ] ) {
				$valid = true;
			}
		}

		if( ! $valid ) {
			wp_send_json_error();
		}

		// Check if the plugin is installed.
		if ( $this->is_plugin_installed( $plugin_slug ) ) {
			// If plugin is installed but not active, activate it.
			if( ! is_plugin_active( $plugin_zip ) ) {
				$this->run_activate( $plugin_slug );
				$this->activate( $plugin_zip );
				$result = 'activated';
			} else {
				$result = 'already_installed';
			}
		} else {
			// No plugin found or plugin not present to be activated, so lets install it.
			$this->install_plugin( $plugin_zip );
			$this->run_activate( $plugin_slug );
			$this->activate( $plugin_zip );
			$result = 'success';
		}

		wp_send_json( $result );
	}

	/**
	 * Install a plugin given a slug.
	 *
	 * @method install
	 * @since  1.0.0
	 * @param  string $plugin_zip URL to the direct zip file.
	 */
	public function install_plugin( $plugin_zip = '' ) {
		// bail early if we don't have a slug to work with.
		if ( empty( $plugin_zip ) ) {
			return;
		}
		// bail early if this is not in the list of allowed plugins.
		// TODO: check if this is in allowed list.
		include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		wp_cache_flush();
		$upgrader = new Plugin_Upgrader();
		$install_result = $upgrader->install( $plugin_zip );
		if (!$install_result || is_wp_error($install_result)) {
			if ( is_wp_error( $install_result ) ) {
				return $install_result->get_error_message();
			}
			die();
		}
	}

	/**
	 * Activates a plugin that is available on the site.
	 *
	 * @method activate
	 * @since  1.0.0
	 * @param  string $plugin_zip URL to the direct zip file.
	 * @return [type]
	 */
	public function activate( $plugin_zip = '' ) {
		// bail early if we don't have a slug to work with.
		if ( empty( $plugin_zip ) ) {
			return;
		}
		// bail early if this is not in the list of allowed plugins.
		// TODO: check if this is in allowed list.
		if( ! function_exists( 'activate_plugin' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		if( ! is_plugin_active( $plugin_zip ) ) {
			activate_plugin( $plugin_zip );
		}
	}

	/**
	 * Activates a plugin that is available on the site.
	 *
	 * @method run_activate
	 * @since  1.0.0
	 * @param  string $plugin_slug slug for plugin.
	 */
	 public function run_activate( $plugin_slug = '' ) {
 		// bail early if we don't have a slug to work with.
 		if ( empty( $plugin_slug ) ) {
 			return;
 		}
 		// bail early if this is not in the list of allowed plugins.
 		// TODO: check if this is in allowed list.
 		$current = get_option( 'active_plugins' );
 		$plugin = plugin_basename( trim( $plugin_slug ) );

 		if ( !in_array( $plugin_slug, $current ) ) {
 			$current[] = $plugin_slug;
 			sort( $current );
 			do_action( 'activate_plugin', trim( $plugin_slug ) );
 			update_option( 'active_plugins', $current );
 			do_action( 'activate_' . trim( $plugin_slug ) );
 			do_action( 'activated_plugin', trim( $plugin_slug ) );
 		}
 		return null;
 	}

	/**
	 * Check if a plugin is installed.
	 *
	 * @method is_plugin_installed
	 * @since  1.0.0
	 * @param  string $plugin_slug slug for plugin.
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
}
}

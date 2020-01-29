<?php
/**
 * Plugin Name: WP Security Audit Log add-on for WPForms
 * Plugin URI: https://www.wpsecurityauditlog.com/
 * Description: An addon to the WP Security Audit Log Plugin to track events within the WPForms plugin.
 * Text Domain: wp-security-audit-log
 * Author URI: http://www.wpwhitesecurity.com/
 * License: GPL2
 *
 * @package Wsal
 * @subpackage Wsal Custom Events Loader
 */

/*
* Display admin notice if WSAL is not installed.
*/
function wsal_wpforms_install_notice() {
    ?>
    <div class="notice notice-success is-dismissible wsaf-wpforms-notice">
        <p><?php _e( 'This is an add-on for the WP Security Audit Log plugin. Please install it to use this add-on.', 'wp-security-audit-log' ); ?> <button class="install-addon button button-primary" data-plugin-slug="wp-security-audit-log/wp-security-audit-log.php" data-plugin-download-url="https://downloads.wordpress.org/plugin/wp-security-audit-log.latest-stable.zip" data-nonce="<?php echo wp_create_nonce( 'wsal-install-addon' ); ?>"><?php _e( 'Install WP Security Audit Log.', 'wp-security-audit-log' ); ?></button><span class="spinner" style="display: none; visibility: visible; float: none; margin: 0 0 0 8px;"></span></p>
    </div>
    <?php
}

// Check if main plugin is installed.
if ( ! class_exists( 'WpSecurityAuditLog' ) ) {
	// Check if the notice was already dismissed by the user.
	if( get_option( 'wsal_forms_notice_dismissed' ) != true ) {
		if ( ! class_exists( 'WSAL_PluginInstallAndActivate' ) && ! class_exists( 'PluginInstallerAction' ) ) {
			require_once 'wp-security-audit-log/classes/PluginInstallandActivate.php';
			require_once 'wp-security-audit-log/classes/PluginInstallerAction.php';
		}
		$plugin_installer = new PluginInstallerAction();
		add_action( 'admin_notices', 'wsal_wpforms_install_notice' );
	}
} else {
	// Reset the notice if the class is not found.
	delete_option( 'wsal_forms_notice_dismissed' );
}


/*
* Load our js file to handle ajax.
*/
function wsal_wpforms_scripts() {
	wp_enqueue_script(
		'wsal-wpforms-scripts',
		plugins_url( 'assets/js/scripts.js', __FILE__ ),
		array( 'jquery' ),
		'1.0',
		true
	);

	$script_data = array(
		'ajaxURL'           => admin_url( 'admin-ajax.php' ),
		'installing'        => __( 'Installing, please wait', 'wp-security-audit-log' ),
		'already_installed' => __( 'Already installed', 'wp-security-audit-log' ),
		'installed'         => __( 'Addon installed', 'wp-security-audit-log' ),
		'activated'         => __( 'Addon activated', 'wp-security-audit-log' ),
		'failed'            => __( 'Install failed', 'wp-security-audit-log' ),
	);

	// Send ajax url to JS file.
	wp_localize_script( 'wsal-wpforms-scripts', 'WSALWPFormsData', $script_data );
}
add_action( 'admin_enqueue_scripts', 'wsal_wpforms_scripts' );

/*
* Update option if user clicks dismiss.
*/
function wsal_wpforms_dismiss_notice() {
	update_option( 'wsal_forms_notice_dismissed', true );
}
add_action( 'wp_ajax_wsal_wpforms_dismiss_notice', 'wsal_wpforms_dismiss_notice' );

/*
 * Hook into WSAL's action that runs before sensors get loaded.
 */
add_action( 'wsal_before_sensor_load', 'wsal_mu_plugin_add_custom_sensors_and_events_dirs' );

/**
 * Used to hook into the `wsal_before_sensor_load` action to add some filters
 * for including custom sensor and event directories.
 *
 * @method wsal_mu_plugin_add_custom_sensors_and_events_dirs
 */
function wsal_mu_plugin_add_custom_sensors_and_events_dirs( $sensor ) {
	add_filter( 'wsal_custom_sensors_classes_dirs', 'wsal_mu_plugin_custom_sensors_path' );
	add_filter( 'wsal_custom_alerts_dirs', 'wsal_mu_plugin_add_custom_events_path' );
	return $sensor;
}

/**
 * Adds a new path to the sensors directory array which is checked for when the
 * plugin loads the sensors.
 *
 * @method wsal_mu_plugin_custom_sensors_path
 * @since  1.0.0
 * @param  array $paths An array containing paths on the filesystem.
 * @return array
 */
function wsal_mu_plugin_custom_sensors_path( $paths = array() ) {
	$paths   = ( is_array( $paths ) ) ? $paths : array();
	$paths[] = trailingslashit( trailingslashit( dirname( __FILE__ ) ) . 'wp-security-audit-log' . DIRECTORY_SEPARATOR . 'custom-sensors' );
	return $paths;
}

/**
 * Adds a new path to the custom events directory array which is checked for
 * when the plugin loads all of the events.
 *
 * @method wsal_mu_plugin_add_custom_events_path
 * @since  1.0.0
 * @param  array $paths An array containing paths on the filesystem.
 * @return array
 */
function wsal_mu_plugin_add_custom_events_path( $paths ) {
	$paths   = ( is_array( $paths ) ) ? $paths : array();
	$paths[] = trailingslashit( trailingslashit( dirname( __FILE__ ) ) . 'wp-security-audit-log' );
	return $paths;
}

/**
 * Adds new custom event objects for our plugin
 *
 * @method wsal_wpforms_add_custom_event_objects
 * @since  1.0.0
 * @param  array $objects An array of default objects.
 * @return array
 */
function wsal_wpforms_add_custom_event_objects( $objects ) {
	$new_objects = array(
		'wpforms' => __( 'WPForms', 'wp-security-audit-log' ),
	);

	// combine the two arrays.
	$objects = array_merge( $objects, $new_objects );

	return $objects;
}

/**
 * Adds new custom event object text for our plugin
 *
 * @method wsal_wpforms_add_custom_event_object_text
 * @since  1.0.0
 * @param string $display the text to display.
 * @param string $object the current object type.
 * @return string
 */
function wsal_wpforms_add_custom_event_object_text( $display, $object ) {
	if ( 'wpforms' === $object ) {
			$display = __( 'WP Forms', 'wp-security-audit-log' );
	}

	return $display;
}

/**
 * Adds new custom event objects for our plugin
 *
 * @method wsal_wpforms_add_custom_event_objects
 * @since  1.0.0
 * @param  array $types An array of default objects.
 * @return array
 */
function wsal_wpforms_add_custom_event_type_data( $types ) {
	$new_types = array(
		'renamed'    => __( 'Renamed', 'wp-security-audit-log' ),
		'duplicated' => __( 'Duplicated', 'wp-security-audit-log' ),
	);

	// combine the two arrays.
	$types = array_merge( $types, $new_types );

	return $types;
}

/**
 * Adds new custom event type text for our plugin
 *
 * @method wsal_wpforms_add_custom_event_object_text
 * @since  1.0.0
 * @param string $display the text to output.
 * @param string $event_type the current event type.
 * @return string
 */
function wsal_wpforms_add_custom_event_type_text( $display, $event_type ) {
	if ( 'renamed' === $event_type ) {
			$display = __( 'Renamed', 'wp-security-audit-log' );
	} elseif ( 'duplicated' === $event_type ) {
			$display = __( 'Duplicated', 'wp-security-audit-log' );
	}

	return $display;
}

/**
 * Add our filters.
 */
add_filter( 'wsal_event_objects', 'wsal_wpforms_add_custom_event_objects' );
add_filter( 'wsal_event_object_text', 'wsal_wpforms_add_custom_event_object_text', 10, 2 );
add_filter( 'wsal_event_type_data', 'wsal_wpforms_add_custom_event_type_data' );
add_filter( 'wsal_event_type_text', 'wsal_wpforms_add_custom_event_type_text', 10, 2 );
<?php
/**
 * Plugin Name: WP Security Audit Log add-on for wpforms
 * Plugin URI: https://www.wpsecurityauditlog.com/
 * Description: An add-on to the WP Security Audit Log Plugin to track changes within the WPForms plugin.
 * Text Domain: wp-security-audit-log
 * Author: WP White Security
 * Author URI: http://www.wpwhitesecurity.com/
 * Version: 1.0.0
 * License: GPL2
 *
 * @package Wsal
 * @subpackage Wsal Custom Events Loader
 */
 
/*
	Copyright(c) 2020  WP White Security  (email : info@wpwhitesecurity.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*
 * Hook into WSAL's action that runs before sensors get loaded.
 */
add_action( 'wsal_before_sensor_load', 'wsal_mu_plugin_add_custom_sensors_and_events_dirs' );

/**
 * Used to hook into the `wsal_before_sensor_load` action to add some filters
 * for including custom sensor and event directories.
 *
 * @method wsal_mu_plugin_add_custom_sensors_and_events_dirs
 * @since  1.0.0
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

add_filter( 'wsal_event_objects', 'wsal_wpforms_add_custom_event_objects' );
add_filter( 'wsal_event_object_text', 'wsal_wpforms_add_custom_event_object_text', 10, 2 );
add_filter( 'wsal_event_type_data', 'wsal_wpforms_add_custom_event_type_data' );
add_filter( 'wsal_event_type_text', 'wsal_wpforms_add_custom_event_type_text', 10, 2 );

<?php
/**
 * Plugin Name: WP Activity Log for WPForms
 * Plugin URI: https://wpactivitylog.com/extensions/wpforms-activity-log/
 * Description: A WP Activity Log plugin extension to keep a log of changes within WPForms.
 * Text Domain: wsal-wpforms
 * Author: WP White Security
 * Author URI: http://www.wpwhitesecurity.com/
 * Version: 1.2.0
 * License: GPL2
 * Network: true
 *
 * @package Wsal
 * @subpackage Wsal Custom Events Loader
 */

/*
	Copyright(c) 2022  WP White Security  (email : info@wpwhitesecurity.com)

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
REQUIRED. Here we include and fire up the main core class. This will be needed regardless so be sure to leave line 37-39 in tact.
*/
require_once plugin_dir_path( __FILE__ ) . 'core/class-extension-core.php';
$wsal_extension = new WPWhiteSecurity\ActivityLog\Extensions\Common\Core( __FILE__, 'wsal-wpforms' );

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
		'wpforms'               => esc_html__( 'WPForms', 'wsal-wpforms' ),
		'wpforms-notifications' => esc_html__( 'Notifications in WPForms', 'wsal-wpforms' ),
		'wpforms_notifications' => esc_html__( 'Notifications in WPForms', 'wsal-wpforms' ),
		'wpforms-entries'       => esc_html__( 'Entries in WPForms', 'wsal-wpforms' ),
		'wpforms_entries'       => esc_html__( 'Entries in WPForms', 'wsal-wpforms' ),
		'wpforms-fields'        => esc_html__( 'Fields in WPForms', 'wsal-wpforms' ),
		'wpforms_fields'        => esc_html__( 'Fields in WPForms', 'wsal-wpforms' ),
		'wpforms_forms'         => esc_html__( 'Forms in WPForms', 'wsal-wpforms' ),
		'wpforms_confirmations' => esc_html__( 'Confirmations in WPForms', 'wsal-wpforms' ),
	);

	// combine the two arrays.
	$objects = array_merge( $objects, $new_objects );

	return $objects;
}

/**
 * Adds new ignored CPT for our plugin
 *
 * @method wsal_wpforms_add_custom_ignored_cpt
 * @since  1.0.0
 * @param  array $post_types An array of default post_types.
 * @return array
 */
function wsal_wpforms_add_custom_ignored_cpt( $post_types ) {
	$new_post_types = array(
		'wpforms',    // WP Forms CPT.
	);

	// combine the two arrays.
	$post_types = array_merge( $post_types, $new_post_types );
	return $post_types;
}

/**
 * Add our filters.
 */
add_filter( 'wsal_event_objects', 'wsal_wpforms_add_custom_event_objects' );
add_filter( 'wsal_ignored_custom_post_types', 'wsal_wpforms_add_custom_ignored_cpt' );

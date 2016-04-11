<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.thecyberworld.org
 * @since             1.0.0
 * @package           Foursquare_Events_Map
 *
 * @wordpress-plugin
 * Plugin Name:       Foursquare Map with Events by Formal Builder
 * Plugin URI:        http://www.formalbuilder.com
 * Description:       Find all the local places of any area you'd like with FourSquare.
 * Version:           1.0.0
 * Author:            Allene Lewis
 * Author URI:        http://www.thecyberworld.org
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       foursquare-events-map
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-foursquare-events-map-activator.php
 */
function activate_foursquare_events_map() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-foursquare-events-map-activator.php';
	Foursquare_Events_Map_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-foursquare-events-map-deactivator.php
 */
function deactivate_foursquare_events_map() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-foursquare-events-map-deactivator.php';
	Foursquare_Events_Map_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_foursquare_events_map' );
register_deactivation_hook( __FILE__, 'deactivate_foursquare_events_map' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-foursquare-events-map.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_foursquare_events_map() {

	$plugin = new Foursquare_Events_Map();
	$plugin->run();

}
run_foursquare_events_map();

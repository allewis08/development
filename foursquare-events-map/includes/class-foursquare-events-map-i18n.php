<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://www.thecyberworld.org
 * @since      1.0.0
 *
 * @package    Foursquare_Events_Map
 * @subpackage Foursquare_Events_Map/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Foursquare_Events_Map
 * @subpackage Foursquare_Events_Map/includes
 * @author     Allene Lewis <alewis.cyb@gmail.com>
 */
class Foursquare_Events_Map_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'foursquare-events-map',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}

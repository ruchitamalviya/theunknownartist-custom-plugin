<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link         https://www.expresstechsoftwares.com/
 * @since      1.0.0
 *
 * @package    Ets_Development
 * @subpackage Ets_Development/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Ets_Development
 * @subpackage Ets_Development/includes
 * @author     ExpressTech Softwares Solutions Pvt Ltd <www.expresstechsoftwares.com>
 */
class Ets_Development_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'ets-development',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}

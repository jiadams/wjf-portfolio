<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/jiadams/
 * @since      1.0.0
 *
 * @package    Wjf_Portfolio
 * @subpackage Wjf_Portfolio/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wjf_Portfolio
 * @subpackage Wjf_Portfolio/includes
 * @author     Josh Adams <jadams@wjfmakreting.com>
 */
class Wjf_Portfolio_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wjf-portfolio',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}

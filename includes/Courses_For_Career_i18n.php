<?php
namespace C4C\Includes;

/**
 * Define the internationalization functionality. 
 *
 * @since      1.0.0
 * @package    Courses_For_Career
 * @subpackage Courses_For_Career/includes
 * @author     Slobodan <brbaso@gmail.com>
 */
class Courses_For_Career_i18n {

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'courses-for-career',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}
}

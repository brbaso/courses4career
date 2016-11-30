<?php

/**
 * Plugin shortcode class.
 *
 * @since      1.0.0
 * @package    Courses_For_Career
 * @subpackage Courses_For_Career/includes
 * @author     Slobodan <brbaso@gmail.com>
 */
 
class Courses_For_Career_Shortcode {	
	
	public static function courses_for_careershortcode_func( $atts = array(), $content = "" ) {
		
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-courses-for-career.php';
		$plugin = new Courses_For_Career();
		$output = new Courses_For_Career_Public( $plugin -> get_plugin_name(), $plugin -> get_version() );
	
		return $output -> display_public_page();
	}	
}
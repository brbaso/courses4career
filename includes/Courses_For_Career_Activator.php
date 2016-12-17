<?php

namespace C4C\Includes;

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Courses_For_Career
 * @subpackage Courses_For_Career/includes
 * @author     Slobodan <brbaso@gmail.com>
 */
class Courses_For_Career_Activator {
		 
	public static function activate() {
		self::check_dependencies();		
		self::courses_for_career_create_db();
	}
	
	public static function courses_for_career_create_db() {

		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$table_name = $wpdb->prefix . 'courses_for_career';

		$sql = "CREATE TABLE $table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,			
			name varchar(255) NOT NULL,
			description text NOT NULL,
			courses text NOT NULL,
			ordering int(11) NOT NULL,
			time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			UNIQUE KEY id (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}
	
	 /**
	 * Make sure SENSEI exists has or else self-destruct
	 */
	 public static function check_dependencies() {
		// do nothing if SENSEI exists
		if ( !function_exists( 'Sensei' ) ) {			
			die( 'This plugin requires SENSEI Woocommerce extension. Please install and activate SENSEI before activating this plugin.' );
		}
	 }
}

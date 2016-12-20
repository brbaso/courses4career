<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @link       brbaso.com
 * @since      1.0.0
 *
 * @package    Courses_For_Career
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

function courses_for_career_delete_plugin() {
	
	global $wpdb;	
	$table_name = $wpdb->prefix . "courses_for_career";
	$wpdb->query( "DROP TABLE IF EXISTS $table_name" );
	
}

courses_for_career_delete_plugin();
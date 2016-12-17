<?php

namespace Front ;

use Includes\Courses_For_Career_Database;
use Front\Partials\Courses_For_Career_Public_Display;

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Courses_For_Career
 * @subpackage Courses_For_Career/public
 * @author     Slobodan <brbaso@gmail.com>
 */
class Courses_For_Career_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;	
	}	

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {		

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/courses-for-career-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/courses-for-career-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'ajax_url', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	}
	
	/**
	 * display plugin admin  page
	 *
	 * @since    1.0.0
	 */
	public function display_public_page() {
		//require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/courses-for-career-public-display.php';
		//require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-courses-for-career-database.php';
		
		$dbhandle = new Courses_For_Career_Database('courses_for_career');
		$public_display = new Courses_For_Career_Public_Display($dbhandle);
		return  $public_display -> courses_for_career_public_display();		
	}
}

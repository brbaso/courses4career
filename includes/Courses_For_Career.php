<?php
namespace C4C\Includes;

use Includes\Courses_For_Career_Loader ;
use Includes\Courses_For_Career_Database ;
use Includes\Courses_For_Career_Shortcode ;
use Admin\Courses_For_Career_Admin ;
use Front\Courses_For_Career_Public ;
use Front\Ajax\Courses_For_Career_Ajax ;
use Widget\C4C_Widget ;
use Widget\Views\Ajax\Widget_Ajax ;

/**
 * core plugin class
 *
 * @link       brbaso.com
 * @since      1.0.0
 *
 * @package    Courses_For_Career
 * @subpackage Courses_For_Career/includes
 */

class Courses_For_Career {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Courses_For_Career_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version ;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'courses-for-career';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->adding_shortcode();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		//Create an instance of the loader which will be used to register the hooks
		$this->loader = new Courses_For_Career_Loader();
	}

	/**
	 * Adding shortcode.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function adding_shortcode() {

		// add shortcode
		add_shortcode( 'courses4career', array( 'Includes\Courses_For_Career_Shortcode', 'courses_for_careershortcode_func' ) );
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Courses_For_Career_i18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	* If SENSEI deactivated, self-deactivate
	*/
	public function sensei_gone_self_deactivate() {

		if ( !function_exists( 'Sensei' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			deactivate_plugins( 'courses-for-career/courses-for-career.php' );
			add_action( 'admin_notices', array( $this, 'sensei_gone_deactivate_notice' ) );
		}
	}

	/**
	* Display an error message when the plugin deactivates itself.
	*/
	public function sensei_gone_deactivate_notice() {

		echo '<div class="error"><p>'.__( 'Plugin Career4Courses has deactivated itself because SENSEI is no longer active.', 'courses-for-career' ).'</p></div>';
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Courses_For_Career_Admin( $this->get_plugin_name(), $this->get_version() );

		// admin scripts
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		// admin options page
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_options_page' );

		// admin register settings
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_settings' );

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'courses_for_career_admin_menu' );

		// database ajax operations
		$plugin_db = new Courses_For_Career_Database( 'courses_for_career' );

		$this->loader->add_action('wp_ajax_career_save', $plugin_db, 'career_save');
		$this->loader->add_action('wp_ajax_career_delete', $plugin_db, 'career_delete');
		$this->loader->add_action('wp_ajax_career_update', $plugin_db, 'career_update');
		$this->loader->add_action('wp_ajax_item_sort', $plugin_db, 're_order');

		//register C4C_Widget - add admin hook
		add_action('admin_init',function(){
			$dbhandle = new Courses_For_Career_Database('courses_for_career');
			register_widget(new C4C_Widget($dbhandle));
		});

		// deactivate if SENSEI gone
		$plugin_this = $this;

		$this->loader->add_action( 'plugins_loaded', $plugin_this, 'sensei_gone_self_deactivate' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Courses_For_Career_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		// database ajax operations
		$dbhandle = new Courses_For_Career_Database( 'courses_for_career' );
		$plugin_ajax = new Courses_For_Career_Ajax( $dbhandle );

		$this->loader->add_action('wp_ajax_render_courses', $plugin_ajax, 'render_courses');
		$this->loader->add_action("wp_ajax_nopriv_render_courses", $plugin_ajax, 'render_courses');

		//register C4C_Widget - add widget hook
		add_action('widgets_init',function(){
			$dbhandle = new Courses_For_Career_Database('courses_for_career');
			register_widget(new C4C_Widget($dbhandle));
		});

		// add public widget ajax Widget_Ajax
		$plugin_c4c_ajax = new Widget_Ajax( $dbhandle );

		$this->loader->add_action('wp_ajax_widget_render_courses', $plugin_c4c_ajax, 'widget_render_courses');
		$this->loader->add_action('wp_ajax_nopriv_widget_render_courses', $plugin_c4c_ajax, 'widget_render_courses');
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {

		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Courses_For_Career_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
}

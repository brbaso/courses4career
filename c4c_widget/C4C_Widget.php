<?php
namespace Widget ;

use Includes\Courses_For_Career_Database;
use Includes\Courses_For_Career_Loader;
/**
 *
 * @package   C4C_Widget
 * @author    brbaso <brbaso@gmail.com>
 * @wordpress-plugin
 * Plugin Name:       C4C_Widget
 * Version:           1.0.0 
 * Text Domain:       c4c-widget
 * License:           GPL-2.0+
 * GitHub Plugin URI: https://github.com/brbaso/courses4career
 */
 
 // Prevent direct file access
if ( ! defined ( 'ABSPATH' ) ) {
	exit;
}


class C4C_Widget extends \WP_Widget {

    /**     
     *
     * @since    1.0.0
     *
     * @var      string
     */
    protected $widget_slug = 'c4c-widget';
	
	/**
	 * Dependency: Courses_For_Career_Database	  includes/Courses_For_Career_Database.php
	 * @since    1.0.0
	 *	 
	 */
	private $dbhandle;

	/**
	 * Dependency: Courses_For_Career_Loader	  includes/Courses_For_Career_Loader.php
	 * @since    1.0.0
	 *
	 */
	private $loader;

	/**
	 * Initialize widget.
	 *
	 * @since    1.0.0
	 *
	 * @param Courses_For_Career_Database|object $dbhandle Object Courses_For_Career_Database.
	 * @param Courses_For_Career_Loader|object   $loader   Object Courses_For_Career_Loader.
	 */
	public function __construct(Courses_For_Career_Database $dbhandle, Courses_For_Career_Loader $loader ) {

		$this -> dbhandle = $dbhandle;
		$this -> loader = $loader;

		$w_actions_to_add =[
			// load plugin text domain
			'init' => [
				[$this, 'widget_textdomain']
			],
			// Register admin styles and scripts
			'admin_print_styles' =>[
				[$this, 'register_admin_styles']
			],
			'admin_enqueue_scripts' => [
				[$this, 'register_admin_scripts']
			],
			// Register site styles and scripts
			'wp_enqueue_scripts' => [
				[$this, 'register_widget_styles'],
				[$this, 'register_widget_scripts']
			],
			// Refreshing the widget's cached output with each new post
			'save_post' => [
				[$this, 'flush_widget_cache']
			],
			'deleted_post' => [
				[$this, 'flush_widget_cache']
			],
			'switch_theme' => [
				[$this, 'flush_widget_cache']
			]
		];

		$this-> loader -> actions_to_add( $w_actions_to_add );
		$this->loader->run();

		parent::__construct(
			$this->get_widget_slug(),
			__( 'C4C_Widget', $this->get_widget_slug() ),
			array(
				'classname'  => $this->get_widget_slug().'-class',
				'description' => __( 'Shows Career for Courses dropdown search in widget area.', $this->get_widget_slug() )
			)
		);
	}


    /**
     * Return the widget slug.
     *
     * @since    1.0.0
     *
     * @return    Plugin slug variable.
     */
    public function get_widget_slug() {
        return $this->widget_slug;
    }

	/**
	 * @ Outputs the content of the widget.
	 *
	 * @param array args  The array of form elements
	 * @param array instance The current instance of the widget
	 *
	 * @return html
	 */
	public function widget( $args, $instance ) {
		
		// Check if there is a cached output
		$cache = wp_cache_get( $this->get_widget_slug(), 'widget' );

		if ( !is_array( $cache ) )
			$cache = array();

		if ( ! isset ( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset ( $cache[ $args['widget_id'] ] ) )
			return print $cache[ $args['widget_id'] ];
		
		$career_items = $this -> dbhandle -> getAll();
		
		extract( $args, EXTR_SKIP );
		
		// add additional class
		$before_widget = '<div class="widget c4c-widget-2 c4c-widget-class '.$instance['css_class'].'">';		
		$widget_string = $before_widget;		
		
		ob_start();
		include( plugin_dir_path( __FILE__ ) . 'views/widget.php' );
		$widget_string .= ob_get_clean();
		$widget_string .= $after_widget;
		
		$cache[ $args['widget_id'] ] = $widget_string;

		wp_cache_set( $this->get_widget_slug(), $cache, 'widget' );

		print $widget_string;
	}
	
	public function flush_widget_cache() 
	{
    	wp_cache_delete( $this->get_widget_slug(), 'widget' );
	}

	/**
	 * Processes the widget's options to be saved.
	 *
	 * @param array new_instance The new instance of values to be generated via the update.
	 * @param array old_instance The previous instance of values before the update.
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = array();
        if (empty($old_instance)) {
            $old_instance = $new_instance;
        }
		$instance = $old_instance;		
		 foreach ($old_instance as $k => $value) {
            $instance[$k] = trim(strip_tags($new_instance[$k]));
        }		
		
        return $instance;
	} 

	/**
	 * Generates the administration form for the widget.
	 *
	 * @param array instance The array of keys and values for the widget.
	 */
	public function form( $instance ) {

		$default_settings = array(
            'widget_title' => '',
            'description' => '',
            'show_widget_title' => 'Yes',         
            'show_description' => 'Yes',
			'show_image' => 'Yes', 
            'show_meta' => 'Yes',
			'show_title' => 'Yes', 
            'show_excerpt' => 'Yes',           
            'css_class' => '',           
        );
		
		// Define default values for our variables
		$instance = wp_parse_args(
			(array) $instance,
			$default_settings
		);		
        		
		extract($instance);

		// Display the admin form
		include( plugin_dir_path(__FILE__) . 'views/admin.php' );
	}
	
	/**
	 * Loads the Widget's text domain for localization and translation.
	 */
	public function widget_textdomain() {
		
		load_plugin_textdomain( $this->get_widget_slug(), false, plugin_dir_path( __FILE__ ) . 'lang/' );
	} 
	
	/**
	 * Registers and enqueues admin-specific styles.
	 */
	public function register_admin_styles() {

		wp_enqueue_style( $this->get_widget_slug().'-admin-styles', plugins_url( 'css/admin.css', __FILE__ ) );
	} 

	/**
	 * Registers and enqueues admin-specific JavaScript.
	 */
	public function register_admin_scripts() {

		wp_enqueue_script( $this->get_widget_slug().'-admin-script', plugins_url( 'js/admin.js', __FILE__ ), array('jquery') );
	} 

	/**
	 * Registers and enqueues widget-specific styles.
	 */
	public function register_widget_styles() {

		wp_enqueue_style( $this->get_widget_slug().'-widget-styles', plugins_url( 'css/widget.css', __FILE__ ) );
	} 

	/**
	 * Registers and enqueues widget-specific scripts.
	 */
	public function register_widget_scripts() {

		wp_enqueue_script( $this->get_widget_slug().'-script', plugins_url( 'js/widget.js', __FILE__ ), array('jquery') );
	} 
}

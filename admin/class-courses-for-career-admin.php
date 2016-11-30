<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       brbaso.com
 * @since      1.0.0
 *
 * @package    Courses_For_Career
 * @subpackage Courses_For_Career/admin
 */

class Courses_For_Career_Admin {
	
	/**
	 * The options name to be used in this plugin
	 *
	 * @since  	1.0.0
	 * @access 	private
	 * @var  	string 		$option_name 	Option name of this plugin
	 */
	private $option_name = 'courses_for_career';

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/courses-for-career-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'chosencss', plugin_dir_url( __FILE__ ) . 'css/chosen.min.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {		

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/courses-for-career-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'chosenjs', plugin_dir_url( __FILE__ ) . 'js/chosen.jquery.min.js', array( 'jquery' ), $this->version, false );
	}
	
	/**
	 * add admin options page
	 *
	 * @since    1.0.0
	 */
	public function add_options_page() {
	
		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'Courses4Career Settings', 'courses-for-career' ),
			__( 'Courses4Career', 'courses-for-career' ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'display_options_page' )
		);	
	}
	
	/**
	 * display admin options page
	 *
	 * @since    1.0.0
	 */
	public function display_options_page() {
		include_once 'partials/courses-for-career-admin-display.php';
	}
	
	/**
	 * display plugin admin  page
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_page() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-courses-for-career-admin-page.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-courses-for-career-database.php';
		
		$dbhandle = new Courses_For_Career_Database('courses_for_career');		
		return new Courses_For_Career_Admin_Page($dbhandle);		
	}
	
	/**
	 * admin register settings
	 *
	 * @since    1.0.0
	 */
	public function register_settings() {
		// Add a Shortcode section
		add_settings_section(
			$this->option_name . '_shortcode',
			__( 'Shortcode', 'courses-for-career' ),
			array( $this, $this->option_name . '_shortcode_cb' ),
			$this->plugin_name
		);
		
		
		// Add a Image section
		add_settings_section(
			$this->option_name . '_image',
			__( 'Course Image Options', 'courses-for-career' ),
			array( $this, $this->option_name . '_image_cb' ),
			$this->plugin_name
		);
		
		add_settings_field(
			$this->option_name . '_show_image',
			__( 'Show Image', 'courses-for-career' ),
			array( $this, $this->option_name . '_show_image_cb' ),
			$this->plugin_name,
			$this->option_name . '_image',
			array( 'label_for' => $this->option_name . '_show_image' )
		);
		
		add_settings_field(
			$this->option_name . '_image_class',
			__( 'Additional CSS class', 'courses-for-career' ),
			array( $this, $this->option_name . '_image_class_cb' ),
			$this->plugin_name,
			$this->option_name . '_image',
			array( 'label_for' => $this->option_name . '_image_class' )
		);
		
		// Add a Title section
		add_settings_section(
			$this->option_name . '_title',
			__( 'Course Title Options', 'courses-for-career' ),
			array( $this, $this->option_name . '_title_cb' ),
			$this->plugin_name
		);
		
		add_settings_field(
			$this->option_name . '_show_title',
			__( 'Show Title', 'courses-for-career' ),
			array( $this, $this->option_name . '_show_title_cb' ),
			$this->plugin_name,
			$this->option_name . '_title',
			array( 'label_for' => $this->option_name . '_show_title' )
		);
		
		add_settings_field(
			$this->option_name . '_title_class',
			__( 'Additional CSS class', 'courses-for-career' ),
			array( $this, $this->option_name . '_title_class_cb' ),
			$this->plugin_name,
			$this->option_name . '_title',
			array( 'label_for' => $this->option_name . '_title_class' )
		);
		
		// Add a Courses Meta section
		add_settings_section(
			$this->option_name . '_meta',
			__( 'Course Meta Data Options', 'courses-for-career' ),
			array( $this, $this->option_name . '_meta_cb' ),
			$this->plugin_name
		);
		
		add_settings_field(
			$this->option_name . '_show_meta',
			__( 'Show Meta Data', 'courses-for-career' ),
			array( $this, $this->option_name . '_show_meta_cb' ),
			$this->plugin_name,
			$this->option_name . '_meta',
			array( 'label_for' => $this->option_name . '_show_meta' )
		);
		
		add_settings_field(
			$this->option_name . '_meta_class',
			__( 'Additional CSS class', 'courses-for-career' ),
			array( $this, $this->option_name . '_meta_class_cb' ),
			$this->plugin_name,
			$this->option_name . '_meta',
			array( 'label_for' => $this->option_name . '_meta_class' )
		);
		
		// Add a Courses Excerpt section
		add_settings_section(
			$this->option_name . '_excerpt',
			__( 'Course Excerpt Options', 'courses-for-career' ),
			array( $this, $this->option_name . '_excerpt_cb' ),
			$this->plugin_name
		);
		
		add_settings_field(
			$this->option_name . '_show_excerpt',
			__( 'Show Excerpt', 'courses-for-career' ),
			array( $this, $this->option_name . '_show_excerpt_cb' ),
			$this->plugin_name,
			$this->option_name . '_excerpt',
			array( 'label_for' => $this->option_name . '_show_excerpt' )
		);
		
		add_settings_field(
			$this->option_name . '_excerpt_class',
			__( 'Additional Excerpt class', 'courses-for-career' ),
			array( $this, $this->option_name . '_excerpt_class_cb' ),
			$this->plugin_name,
			$this->option_name . '_excerpt',
			array( 'label_for' => $this->option_name . '_excerpt_class' )
		);
		
		// Add a Careers Description section
		add_settings_section(
			$this->option_name . '_career',
			__( 'Careers Options', 'courses-for-career' ),
			array( $this, $this->option_name . '_career_cb' ),
			$this->plugin_name
		);
		
		add_settings_field(
			$this->option_name . '_show_career_title',
			__( 'Show Career Title', 'courses-for-career' ),
			array( $this, $this->option_name . '_show_career_title_cb' ),
			$this->plugin_name,
			$this->option_name . '_career',
			array( 'label_for' => $this->option_name . '_show_career_title' )
		);
		
		add_settings_field(
			$this->option_name . '_career_title_class',
			__( 'Additional Career Title class', 'courses-for-career' ),
			array( $this, $this->option_name . '_career_title_class_cb' ),
			$this->plugin_name,
			$this->option_name . '_career',
			array( 'label_for' => $this->option_name . '_career_title_class' )
		);
		
		add_settings_field(
			$this->option_name . '_show_career',
			__( 'Show Career Description', 'courses-for-career' ),
			array( $this, $this->option_name . '_show_career_cb' ),
			$this->plugin_name,
			$this->option_name . '_career',
			array( 'label_for' => $this->option_name . '_show_career' )
		);
		
		add_settings_field(
			$this->option_name . '_career_class',
			__( 'Additional Career Description class', 'courses-for-career' ),
			array( $this, $this->option_name . '_career_class_cb' ),
			$this->plugin_name,
			$this->option_name . '_career',
			array( 'label_for' => $this->option_name . '_career_class' )
		);
		
		register_setting( $this->plugin_name, $this->option_name . '_shortcode' );
		
		register_setting( $this->plugin_name, $this->option_name . '_show_image' );
		register_setting( $this->plugin_name, $this->option_name . '_image_class');
		
		register_setting( $this->plugin_name, $this->option_name . '_show_title' );
		register_setting( $this->plugin_name, $this->option_name . '_title_class');
		
		register_setting( $this->plugin_name, $this->option_name . '_show_meta' );
		register_setting( $this->plugin_name, $this->option_name . '_meta_class');
		
		register_setting( $this->plugin_name, $this->option_name . '_show_excerpt');
		register_setting( $this->plugin_name, $this->option_name . '_excerpt_class');
		
		register_setting( $this->plugin_name, $this->option_name . '_show_career_title');
		register_setting( $this->plugin_name, $this->option_name . '_career_title_class');
		
		register_setting( $this->plugin_name, $this->option_name . '_show_career');
		register_setting( $this->plugin_name, $this->option_name . '_career_class');
	}
	
	/**
	 * Render the text for section
	 *
	 * @since  1.0.0
	 */
	public function courses_for_career_shortcode_cb() {
		echo '<p>' . __( 'To show the plugin please put the <strong>[courses4career]</strong> shortcode within your pages or posts', 'courses-for-career' ) . '</p>';
	}
	/**
	 * Render the text for section
	 *
	 * @since  1.0.0
	 */
	public function courses_for_career_image_cb() {
		echo '<p>' . __( 'Please change image settings accordingly.', 'courses-for-career' ) . '</p>';
	}	
	
	/**
	 * Render the radio input field  option
	 *
	 * @since  1.0.0
	 */
	public function courses_for_career_show_image_cb() {
		?>
			<fieldset>
				<label>
					<input type="radio" name="<?php echo $this->option_name . '_show_image' ?>" id="<?php echo $this->option_name . '_show_image' ?>" value="Yes" <?php echo (get_option("courses_for_career_show_image") == 'Yes')?'checked="checked"':'';?>>
					<?php _e( 'Yes', 'courses_for_career' ); ?>
				</label>				
				<br>
				<label>
					<input type="radio" name="<?php echo $this->option_name . '_show_image' ?>" value="No" <?php echo (get_option("courses_for_career_show_image") == 'No')?'checked="checked"':'';?>>
					<?php _e( 'No', 'courses_for_career' ); ?>
				</label>				
				
			</fieldset>
		<?php
	}
	
	/**
	 * Render additional class input
	 *
	 * @since  1.0.0
	 */
	public function courses_for_career_image_class_cb() {
		?>
		<input type="text" name="<?php echo  $this->option_name . '_image_class' ?>" id="<?php echo $this->option_name . '_image_class' ?>" value=<?php echo get_option("courses_for_career_image_class") ?>> 
	<?php	
	}
	
	/**
	 * Render the text for section
	 *
	 * @since  1.0.0
	 */
	public function courses_for_career_title_cb() {
		echo '<p>' . __( 'Please change title settings accordingly.', 'courses-for-career' ) . '</p>';
	}
	
	/**
	 * Render the radio input field  option
	 *
	 * @since  1.0.0
	 */
	public function courses_for_career_show_title_cb() {
		?>
			<fieldset>
				<label>
					<input type="radio" name="<?php echo $this->option_name . '_show_title' ?>" id="<?php echo $this->option_name . '_show_title' ?>" value="Yes" <?php echo (get_option("courses_for_career_show_title") == 'Yes')?'checked="checked"':'';?>>
					<?php _e( 'Yes', 'courses_for_career' ); ?>
				</label>				
				<br>
				<label>
					<input type="radio" name="<?php echo $this->option_name . '_show_title' ?>" value="No" <?php echo (get_option("courses_for_career_show_title") == 'No')?'checked="checked"':'';?>>
					<?php _e( 'No', 'courses_for_career' ); ?>
				</label>				
				
			</fieldset>
		<?php
	}
	
	/**
	 * Render additional class input
	 *
	 * @since  1.0.0
	 */
	public function courses_for_career_title_class_cb() {
		?>
		<input type="text" name="<?php echo  $this->option_name . '_title_class' ?>" id="<?php echo $this->option_name . '_title_class' ?>" value=<?php echo get_option("courses_for_career_title_class") ?>> 
	<?php	
	}
	
	/**
	 * Render the text for section
	 *
	 * @since  1.0.0
	 */
	public function courses_for_career_meta_cb() {
		echo '<p>' . __( 'Please change courses meta data settings accordingly.', 'courses-for-career' ) . '</p>';
	}
	
	/**
	 * Render the radio input field  option
	 *
	 * @since  1.0.0
	 */
	public function courses_for_career_show_meta_cb() {
		?>
			<fieldset>
				<label>
					<input type="radio" name="<?php echo $this->option_name . '_show_meta' ?>" id="<?php echo $this->option_name . '_show_meta' ?>" value="Yes" <?php echo (get_option("courses_for_career_show_meta") == 'Yes')?'checked="checked"':'';?>>
					<?php _e( 'Yes', 'courses_for_career' ); ?>
				</label>				
				<br>
				<label>
					<input type="radio" name="<?php echo $this->option_name . '_show_meta' ?>" value="No" <?php echo (get_option("courses_for_career_show_meta") == 'No')?'checked="checked"':'';?>>
					<?php _e( 'No', 'courses_for_career' ); ?>
				</label>				
				
			</fieldset>
		<?php
	}
	
	/**
	 * Render additional class input
	 *
	 * @since  1.0.0
	 */
	public function courses_for_career_meta_class_cb() {
		?>
		<input type="text" name="<?php echo  $this->option_name . '_meta_class' ?>" id="<?php echo $this->option_name . '_meta_class' ?>" value=<?php echo get_option("courses_for_career_meta_class") ?>> 
	<?php	
	}
	
	/**
	 * Render the text for section
	 *
	 * @since  1.0.0
	 */
	public function courses_for_career_excerpt_cb() {
		echo '<p>' . __( 'Please change excerpt settings accordingly.', 'courses-for-career' ) . '</p>';
	}
	
	/**
	 * Render the radio input field  option
	 *
	 * @since  1.0.0
	 */
	public function courses_for_career_show_excerpt_cb() {
		?>
			<fieldset>
				<label>
					<input type="radio" name="<?php echo $this->option_name . '_show_excerpt' ?>" id="<?php echo $this->option_name . '_show_excerpt' ?>" value="Yes" <?php echo (get_option("courses_for_career_show_excerpt") == 'Yes')?'checked="checked"':'';?>>
					<?php _e( 'Yes', 'courses_for_career' ); ?>
				</label>				
				<br>
				<label>
					<input type="radio" name="<?php echo $this->option_name . '_show_excerpt' ?>" value="No" <?php echo (get_option("courses_for_career_show_excerpt") == 'No')?'checked="checked"':'';?>>
					<?php _e( 'No', 'courses_for_career' ); ?>
				</label>				
				
			</fieldset>
		<?php
	}
		
	/**
	 * Render additional class input
	 *
	 * @since  1.0.0
	 */
	public function courses_for_career_excerpt_class_cb() {
		?>
		<input type="text" name="<?php echo  $this->option_name . '_excerpt_class' ?>" id="<?php echo $this->option_name . '_excerpt_class' ?>" value=<?php echo get_option("courses_for_career_excerpt_class") ?>> 
	<?php	
	}
	
	/**
	 * Render the text for section
	 *
	 * @since  1.0.0
	 */
	public function courses_for_career_career_cb() {
		echo '<p>' . __( 'Please change Career descriptions and titles settings accordingly. This applies to descriptions and titles defined in the <a href="admin.php?page=courses-for-career/courses-for-career.php">Courses4Career admin page</a>.', 'courses-for-career' ) . '</p>';		
		
	}
	
	/**
	 * Render the radio input field  option
	 *
	 * @since  1.0.0
	 */
	public function courses_for_career_show_career_cb() {
		?>
			<fieldset>
				<label>
					<input type="radio" name="<?php echo $this->option_name . '_show_career' ?>" id="<?php echo $this->option_name . '_show_career' ?>" value="Yes" <?php echo (get_option("courses_for_career_show_career") == 'Yes')?'checked="checked"':'';?>>
					<?php _e( 'Yes', 'courses_for_career' ); ?>
				</label>				
				<br>
				<label>
					<input type="radio" name="<?php echo $this->option_name . '_show_career' ?>" value="No" <?php echo (get_option("courses_for_career_show_career") == 'No')?'checked="checked"':'';?>>
					<?php _e( 'No', 'courses_for_career' ); ?>
				</label>				
				
			</fieldset>
		<?php
	}
		
	/**
	 * Render additional class input
	 *
	 * @since  1.0.0
	 */
	public function courses_for_career_career_class_cb() {
		?>
		<input type="text" name="<?php echo  $this->option_name . '_career_class' ?>" id="<?php echo $this->option_name . '_career_class' ?>" value=<?php echo get_option("courses_for_career_career_class") ?>> 
		
		
	<?php	
	}
	
		/**
	 * Render the radio input field  option
	 *
	 * @since  1.0.0
	 */
	public function courses_for_career_show_career_title_cb() {
		?>
			<fieldset>
				<label>
					<input type="radio" name="<?php echo $this->option_name . '_show_career_title' ?>" id="<?php echo $this->option_name . '_show_career_title' ?>" value="Yes" <?php echo (get_option("courses_for_career_show_career_title") == 'Yes')?'checked="checked"':'';?>>
					<?php _e( 'Yes', 'courses_for_career' ); ?>
				</label>				
				<br>
				<label>
					<input type="radio" name="<?php echo $this->option_name . '_show_career_title' ?>" value="No" <?php echo (get_option("courses_for_career_show_career_title") == 'No')?'checked="checked"':'';?>>
					<?php _e( 'No', 'courses_for_career' ); ?>
				</label>				
				
			</fieldset>
		<?php
	}
		
	/**
	 * Render additional class input
	 *
	 * @since  1.0.0
	 */
	public function courses_for_career_career_title_class_cb() {
		?>
		<input type="text" name="<?php echo  $this->option_name . '_career_title_class' ?>" id="<?php echo $this->option_name . '_career_title_class' ?>" value=<?php echo get_option("courses_for_career_career_class") ?>> 
		
		
	<?php	
	}
	
	/**
	 * Add an admin menu in the admin page for Courses4Career plugin
	 *
	 * @since  1.0.0
	 */
	public function courses_for_career_admin_menu() {		
		add_menu_page( 'Courses4Career Page', 'Courses4Career', 'manage_options', 'courses-for-career/courses-for-career.php', array($this->display_plugin_page(), "courses_for_career_admin_page"), 'dashicons-filter', 66  );		
	}	
}

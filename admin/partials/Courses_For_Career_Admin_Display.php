<?php
namespace Admin\Partials ;

class Courses_For_Career_Admin_Display {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	public function __construct( $plugin_name ) {

		$this->plugin_name = $plugin_name;
		self::courses_for_career_public_display();
	}

	public function courses_for_career_public_display() {
		?>
		<div class="wrap">
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
			<form action="options.php" method="post">
				<?php
				settings_fields( $this->plugin_name );
				do_settings_sections( $this->plugin_name );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}
}
?>

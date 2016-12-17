<?php

namespace Admin ;

use Includes\Courses_For_Career_Database;

/**
 * The admin page of the plugin.
 *
 * @link       brbaso.com
 * @since      1.0.0
 *
 * @package    Courses_For_Career
 * @subpackage Courses_For_Career/admin
 */

class Courses_For_Career_Admin_Page {
	
	/**
	 * Dependency: Courses_For_Career_Database	  includes/class-courses-for-career-database.php
	 * @since    1.0.0
	 *	 
	 */
	private $dbhandle;

	/**
	 * Initialize the class.
	 *
	 * @since    1.0.0
	 *
	 * @param Courses_For_Career_Database|object $dbhandle Object Courses_For_Career_Database.
	 */
	public function __construct( Courses_For_Career_Database $dbhandle ) {
		$this -> dbhandle = $dbhandle;
	}

	/**
	 * Render the page.
	 *
	 * @since    1.0.0
	 */
	public function courses_for_career_admin_page(){

	// TODO ADD nonce to form !!
        //$retrieved_nonce = $_REQUEST['_wpnonce'];
		//if (!wp_verify_nonce($retrieved_nonce, 'save_action' ) ) die( 'Failed security check' );	
		
		// get all courses to populate the form dropdown multiple
		$courses = $this -> dbhandle -> getCourses();
		
		// get all career items from database
		$career_items = $this -> dbhandle -> getAll();		
		echo
			'<div class="wrap">
				<h2>
					'.__( 'Welcome To Courses4Career Plugin', 'courses-for-career' ).'
				</h2>
			</div>		
			<span>
				'.__( 'You may want to visit', 'courses-for-career' ).' 
				<a href="options-general.php?page=courses-for-career"> 
					'.__( 'Settings page', 'courses-for-career' ).'
				</a> 
				'.__( 'to adjust some options', 'courses-for-career' ).' 
			.</span>'
			;
		
		// now include forms and logic
		?>
		<script type="text/javascript">
		jQuery(document).ready(function($){
			$( '.chzn-select' ).chosen({				
				width: "50%"
			  });
		});
		</script>
		
		<a href="#no-sort" class="c4c_add_career button button-xlarge btn-success"><?php _e('Add New Career', 'courses-for-career'); ?></a>		
		
		<div id="c4c-content">
		
		<!-- clone -->
			<div id="clone" style="display:none">			
			<div id="" data-id="" class="c4c-form cloned">
				<div class="drag-drop-bar"> </div>			
				<form id="0" class="career-form" action="" method="post">
					
					<div class="inputs career">
					<label for="name"><?php echo __( 'Career', 'courses-for-career' ) ?></label>
					<input class="sort-disabled" type="text" name="name" id="name" required value="">
					</div>
					
					<div class="inputs description">
					<label for="description"><?php echo __( 'Description', 'courses-for-career' ) ?></label>
					<textarea class="sort-disabled" name="description" id="description"></textarea>
					</div>
					
					<div class="inputs courses">
					<label for="courses"><?php echo __( 'Sensei Courses', 'courses-for-career' ) ?></label>
					<p>
						<select name="courses[]" class="for-chosen sort-disabled" data-placeholder="Select one or more" multiple="multiple" required>
						<?php
						foreach ( $courses as $course ) {
						?>
						<!--option value="<?php echo $course -> ID; ?>"<?php selected( in_array( $term->term_id, $current_terms ) ); ?>><?php echo $term->name; ?></option-->
						<option value="<?php echo $course -> ID; ?>" ><?php echo $course -> post_title; ?></option>
						<?php
						}
						?>
						</select>
					</p>
					</div>
					
					<!-- loader --->
					<div class="animation_container">
						<div class="action-overlay">
						</div>
						<div class="sampleContainer">
							<div class="loader">
								<span class="dot dot_1"></span>
								<span class="dot dot_2"></span>
								<span class="dot dot_3"></span>
								<span class="dot dot_4"></span>
							</div>
						</div>
					</div>
					
					<!-- / loader -->
					
					<div id="new-courses" class="button-controls">						
						<a href="#" class="save-career action-button button btn-primary button-large" data-action = "career_save"><?php _e('Save', 'courses-for-career'); ?></a>
						<a href="#" class="remove-career  button btn-warning button-large"><?php _e('Remove', 'courses-for-career'); ?></a>
					</div>
					
					<div id="existing-courses" class="button-controls" style="display:none">					
						<a href="#" disabled="false" class="update-career action-button button btn-primary button-large" data-action = "career_update"><?php _e('Update', 'courses-for-career'); ?></a>
						<a href="#" class="delete-career action-button button btn-danger button-large" data-action = "career_delete"><?php _e('Delete', 'courses-for-career'); ?></a>
					</div>
					
				</form>
			</div>
			</div>		
		<!-- /clone -->
		
		<!-- reordering loader -->
			<div class="big_animation_container sort-disabled">
				<div class="action-overlay">
				</div>
				<div class="sampleContainer">
					<div class="loader">
						<span class="dot dot_1"></span>
						<span class="dot dot_2"></span>
						<span class="dot dot_3"></span>
						<span class="dot dot_4"></span>
					</div>
				</div>
			</div>			
			<!-- /reordering loader -->
			
		<div id="active-content">			
			<?php 
			foreach ($career_items as $item){ 
			
				$item_id = ( $item -> id ) ? $item -> id : '';
				$item_name = ( $item -> name ) ? $item -> name : '';
				$item_description = ( $item -> description ) ? $item -> description : '';
			
				// get items courses				
				$item_courses = ( $item -> courses ) ? json_decode( $item -> courses ) : array() ;
			?>
			
		<div id="<?php echo $item_id ?>" data-id="0" class="c4c-form">
			<div class="drag-drop-bar"><div class="wp-menu-image dashicons-before dashicons-move" style="float:right; margin-right:10px;"><br></div> </div>
			
			<form id="<?php echo $item_id ?>" class="career-form" action="" method="post">
				<div class="inputs career">
				<label for="name"><?php echo __( 'Career', 'courses-for-career' ) ?></label>
				<input class="sort-disabled" type="text" name="name" id="name" required value="<?php echo $item_name ?>">
				</div>
				
				<div class="inputs description">
				<label for="description"><?php echo __( 'Description', 'courses-for-career' ) ?></label>
				<textarea class="sort-disabled" name="description" id="description"><?php echo $item_description ?></textarea>
				</div>
				
				<div class="inputs courses">
				<label for="courses"><?php echo __( 'Sensei Courses', 'courses-for-career' ) ?></label>
				<p>
					<select name="courses[]" class="chzn-select sort-disabled" data-placeholder="<?php echo __( 'Select one or more', 'courses-for-career' ) ?>" multiple="multiple" required>
					<?php
					foreach ( $courses as $course ) {
						
					?>
					<option value="<?php echo $course -> ID; ?>"<?php selected( in_array( $course -> ID, $item_courses ) ); ?> ><?php echo $course -> post_title; ?></option>
					<?php
					}				
					?>
					</select>
				</p>
				</div>
				
				<!-- loader -->
				<div class="animation_container sort-disabled">
					<div class="action-overlay">
					</div>
					<div class="sampleContainer">
						<div class="loader">
							<span class="dot dot_1"></span>
							<span class="dot dot_2"></span>
							<span class="dot dot_3"></span>
							<span class="dot dot_4"></span>
						</div>
					</div>
				</div>
				<!-- / loader -->
												
				<div id="existing-courses" class="button-controls">					
					<a href="#" disabled="false" class="update-career action-button button btn-primary button-large" data-action = "career_update"><?php _e('Update', 'courses-for-career'); ?></a>
					<a href="#" class="delete-career action-button button btn-danger button-large" data-action = "career_delete"><?php _e('Delete', 'courses-for-career'); ?></a>
				</div>				
			</form>
		</div>
			<?php
			}
			?>
		</div>
		</div>
	<?php		
	}
}
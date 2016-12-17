<?php

namespace Front\Partials ;

use Includes\Courses_For_Career_Database;

/**
 * The public page of the plugin.
 *
 * @link       brbaso.com
 * @since      1.0.0
 *
 * @package    Courses_For_Career
 * @subpackage Courses_For_Career/public
 */

class Courses_For_Career_Public_Display {
	
	/**
	 * Dependancy: Courses_For_Career_Database	  includes/class-courses-for-career-database.php 
	 * @since    1.0.0
	 *	 
	 */
	private $dbhandle;

	/**
	 * Initialize the class.
	 *
	 * @since    1.0.0
	 * @param      object    $dbhandle      Object Courses_For_Career_Database.
	 */
	public function __construct( Courses_For_Career_Database $dbhandle ) {
		$this -> dbhandle = $dbhandle;
	}
	
	/**
	 * Render the page.
	 *
	 * @since    1.0.0
	 */
	public function courses_for_career_public_display(){
	
		// get all career items from database
		$career_items = $this -> dbhandle -> getAll();
		?>
			<div class="c4c-form search-course-page-search-form-wrap">
				<form action="" method="get" id="searchform" class="search-form-wrap search-for-courses">
					<input name="search-type" value="courses" type="hidden">
					<ul>
						<li>
							<select id="career-select" name="course-category" id="course-category" class="postform" data-wid = "" data-type = "">
								<option value="0" selected="selected">Select Career</option>
								<?php
								foreach( $career_items as $item ){
									if($item -> name){
								?>
								<option class="level-0" value="<?php echo $item -> id; ?>"><?php echo $item -> name; ?></option>
								<?php } } ?>
							</select>
						</li>						
					</ul>
				</form>
			</div>
			<div id="c4c-response" class="course-container" > 
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
			</div> 
		<?php
	}	
}
?>
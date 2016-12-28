<?php
namespace Widget\Views\Ajax;

use Includes\Courses_For_Career_Database;

/**
 * The ajax response - list of courses to render in widget.
 *
 * @link       brbaso.com
 * @since      1.0.0
 *
 */

class Widget_Ajax{
	
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
	 * Render courses by career.
	 *
	 * @since    1.0.0
	 */
	public function widget_render_courses() {
		
		$data = $_POST;
		$career_id = (int) $data['career_id'];
		
		$widget_id = $data['wid'];		
		$woptions = get_option('widget_c4c-widget');
		$options = $woptions[$widget_id];	
	
		if($career_id != 0){
		
			$results = $this -> dbhandle -> courses_by_career($career_id);
			$courses = $results['posts'];
			
		// let's get options eventually
		$image_show = ( $options['show_image'] == 'Yes') ? true : false ;		
		$meta_show = ( $options['show_meta'] == 'Yes') ? true : false ;
		$title_show = ( $options['show_title'] == 'Yes') ? true : false ;		
		$excerpt_show = ( $options['show_excerpt'] == 'Yes') ? true : false ;
			
			$output = '';		
			foreach ($courses as $c ){
				$output .= '<article class="course type-course">';					
					if($image_show) {
						$output .= '<a href="'.$c -> permalink.'" title="'.$c -> post_title.'"  class="">
						<img src="'.$c -> image[0].'" class="wh-course-search-thumb wp-post-image" alt="'.$c -> post_title.'" width="170" height="170">
						</a>';		
					}					
					if($title_show) {
					$output .= '<header><h2 class="widget-course-title"><a href="'.$c -> permalink.'">'.$c -> post_title.'</a></h2></header>';
					}					
					$output .= '<div class="entry">';					
						if($meta_show) {
							$output .= '<p class="widget-sensei-course-meta">';
								foreach ($c -> categories as $cat ){									
									$output .= ' | <span class="course-category"><a href="'.site_url( '/search-courses/?search-type=courses&course-category='.$cat -> term_id.'&status=&s=" rel="tag' ).'" rel="tag">'.$cat -> name.'</a></span>';									
								}								
							$output .= '</p>';
						}
					if($excerpt_show) {
					$output .= '<p class="widget-course-excerpt">'.$c -> post_excerpt.'</p>';
					}
				$output .= '</div>					
				</article>';
			}		
		} else {			
			$output = '';
		}
		echo json_encode($output);
		wp_die();
	}	
}

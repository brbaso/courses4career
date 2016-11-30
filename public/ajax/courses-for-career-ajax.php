<?php

/**
 * The ajax response - list of courses to render.
 *
 * @link       brbaso.com
 * @since      1.0.0
 *
 * @package    Courses_For_Career
 * @subpackage Courses_For_Career/public
 */

class Courses_For_Career_Ajax{
	
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
	 *
	 * @param Courses_For_Career_Database|instance $dbhandle  Courses_For_Career_Database
	 */
	public function __construct( Courses_For_Career_Database $dbhandle ) {
		$this -> dbhandle = $dbhandle;
	}
	
	/**
	 * Render courses by career.
	 *
	 * @since    1.0.0
	 */
	public function render_courses() {
		
		$data = $_POST;
		$career_id = $data['career_id'];
		
		if($career_id != 0){
		
			$results = $this -> dbhandle -> courses_by_career($career_id);
			$courses = $results['posts'];
			$options = $results['options'];
			
			// reindex options by option name
			foreach( $options as $opt => $val){				
				foreach( $val as $o => $v){
					if($o == 'option_name' ){						
						unset($options[$opt]);
						$opt = $v;
						$options[$opt] =$val; 						
					}					
				}
			}
			
			// get the career
			$career = $this -> dbhandle -> career_get( $career_id );
			$career_title = $career -> name;
			$career_desc = $career -> description;
			
			// let's get options evntually
			$career_desc_show = ( $options['courses_for_career_show_career'] -> option_value == 'Yes') ? true : false ;
			$career_desc_class = ( $options['courses_for_career_career_class'] -> option_value ) ? $options['courses_for_career_career_class'] -> option_value : '' ;
				
			$career_title_show = ( $options['courses_for_career_show_career_title'] -> option_value == 'Yes') ? true : false ;
			$career_title_class = ( $options['courses_for_career_career_title_class'] -> option_value ) ? $options['courses_for_career_career_title_class'] -> option_value : '' ;
			
			$image_show = ( $options['courses_for_career_show_image'] -> option_value == 'Yes') ? true : false ;
			$image_class = ( $options['courses_for_career_image_class'] -> option_value ) ? $options['courses_for_career_image_class'] -> option_value : '' ;
			
			$title_show = ( $options['courses_for_career_show_title'] -> option_value == 'Yes') ? true : false ;
			$title_class = ( $options['courses_for_career_title_class'] -> option_value ) ? $options['courses_for_career_title_class'] -> option_value : '' ;
			
			$meta_show = ( $options['courses_for_career_show_meta'] -> option_value == 'Yes') ? true : false ;
			$meta_class = ( $options['courses_for_career_meta_class'] -> option_value ) ? $options['courses_for_career_meta_class'] -> option_value : '' ;
			
			$excerpt_show = ( $options['courses_for_career_show_excerpt'] -> option_value == 'Yes') ? true : false ;
			$excerpt_class = ( $options['courses_for_career_excerpt_class'] -> option_value ) ? $options['courses_for_career_excerpt_class'] -> option_value : '' ;
				
			$output = '';

			$output .= '<article class="career-info">';
			$output .= ( $career_title_show ) ? '<h2 class ="'.$career_title_class.'">'.$career_title.'</h2>' : '' ;
			$output .= ( $career_desc_show ) ? '<div class ="'.$career_desc_class.'">'.$career_desc.'</div>' : '' ;
			$output .= '</article>';
			
			foreach ($courses as $c ){
				$output .= '<article class="course type-course">';					
					if($image_show) {
						$output .= '<a href="'.$c -> permalink.'" title="'.$c -> post_title.'"  class="'.$image_class.'">
						<img src="'.$c -> image[0].'" class="wh-course-search-thumb wp-post-image" alt="'.$c -> post_title.'" width="170" height="170">
						</a>';		
					}					
					if($title_show) {
					$output .= '<header><h2 class="'.$title_class.'"><a href="'.$c -> permalink.'">'.$c -> post_title.'</a></h2></header>';
					}					
					$output .= '<div class="entry">';					
						if($meta_show) {
							$output .= '<p class="sensei-course-meta '.$meta_class.'">
								<span class="course-author">by '.$c -> author.'</span>';								
								foreach ($c -> categories as $cat ){
									//$output .= ' | <span class="course-category"><a href="'.$cat -> cat_permalink.'" rel="tag">'.$cat -> name.'</a></span>';  $url = site_url( '/search-courses/?search-type=courses&course-category='.$cat -> term_id.'&status=&s=" rel="tag' );
									$output .= ' | <span class="course-category"><a href="'.site_url( '/search-courses/?search-type=courses&course-category='.$cat -> term_id.'&status=&s=" rel="tag' ).'" rel="tag">'.$cat -> name.'</a></span>';
									
								}								
							$output .= '</p>';
						}						
						$output .= '<p class="course-excerpt '.$excerpt_class.'">'.$c -> post_excerpt.'</p>						
					</div>					
				</article>';
			}		
		} else {			
			$output = '';
		}
		echo json_encode($output);
		wp_die();
	}	
}

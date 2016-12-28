<?php
namespace Includes;

/**
 * Database functionality 
 *
 * @link       brbaso.com
 * @since      1.0.0
 *
 * @package    Courses_For_Career
 * @subpackage Courses_For_Career/includes
 *
 * @author     Slobodan <brbaso@gmail.com>
 */
 
class Courses_For_Career_Database {
	
	/**
	 * The database table to be used in this plugin
	 *
	 * @since  	1.0.0
	 * @access 	private
	 * @var  	string 		$table 	Table name of this plugin
	 */
	private $table  = 'courses_for_career' ;	

	public function __construct($table) {	
	
		global $wpdb;		
		$this->db = $wpdb;		
		$this -> table = $this->db->prefix . $table;
		$this -> posts_table =  $this->db->prefix . 'posts';	
		$this -> options_table =  $this->db->prefix . 'options';	
	}
	
	/**
	 * Save career
	 *
	 * @since    1.0.0
	 * @param    array     $data    Form data to save
	 *
	 */
	public function career_save(){

		$db = $this ->db;
		$table = $this -> table;
		
		// make refresh ordering befor adding new item
		$this -> refresh_order();
		
		parse_str($_POST['form_data'], $form_data);
		$form_data['courses'] = json_encode($form_data['courses'], true);

		// sanitize
		$form_data = $this -> sanitize( $form_data );

		// nonce check
		if (!wp_verify_nonce( $form_data['_wpnonce'] ) ) die( 'Failed security check' );
		unset($form_data['_wpnonce']);
		unset($form_data['_wp_http_referer']);

		$form_data['time'] = current_time( 'mysql' );

		// get existing max ordering number and increase +1
		$max = $db->get_var( "SELECT MAX( ordering ) AS max FROM $table" );
		$form_data['ordering'] = $max + 1;

		$db ->insert( 
			$table, 
			$form_data
		);

		$new_id = $db -> insert_id;
		echo json_encode($new_id);
		wp_die();
	}
	
	/**
	 * Delete career
	 *
	 * @since    1.0.0
	 * 
	 */
	public function career_delete(){
		
		$db = $this ->db;
		$data = $_POST;
		parse_str($data['form_data'], $form_data);

		// sanitize
		$form_data = $this -> sanitize( $form_data );

		// nonce check
		if (!wp_verify_nonce( $form_data['_wpnonce'] ) ) die( 'Failed security check' );

		$db ->delete(
				$this -> table, 
				array( 'id' => $data['career_id'] ),
				array( '%d' )
			);
			
		// refresh ordering after delete
		$this -> refresh_order();		
	}

	/**
	 * Get career
	 *
	 * @param int $id
	 *
	 * @return object Object      career row
	 * @since    1.0.0
	 */
	public function career_get( $id = 0 ){
		$table = $this -> table ;
		$result = $this -> db -> get_row(
				"
				SELECT *
				FROM $table
				WHERE id = $id
				"
			);

		return $result;		
	}
	
	/**
	 * Refresh ordering
	 *
	 * @since    1.0.0
	 *
	 */
	public function refresh_order(){
		
		// make refresh ordering 
		$items = $this -> getAll();		
		$i=1;
		foreach($items as $item){		
			$this ->db -> update( 
				$this -> table,
				array('ordering' => $i), 	
				array( 'id' => $item -> id )
			);
			$i++;
		}
	}

	/**
	 * Re ordering on sorting 
	 *
	 * @since    1.0.0
	 *
	 */
	public function re_order(){
	
	/* TO DO sanitize post and verify nonce */
		$data = explode(',',$_POST['order']);
		foreach($data as $index => $val){		
			$this -> db -> update( 
				$this -> table,
				array('ordering' => $index + 1 ), 	
				array( 'id' => $val )
			);			
		}		
	}
	
	/**
	 * Update career
	 *
	 * @since    1.0.0
	 * 
	 */
	public function career_update(){

		$db = $this ->db;
		$data = $_POST;

		parse_str($data['form_data'], $form_data);
		$form_data['courses'] = json_encode($form_data['courses'], true);

		// sanitize
		$form_data = $this -> sanitize( $form_data );

		// nonce check
		if (!wp_verify_nonce( $form_data['_wpnonce'] ) ) die( 'Failed security check' );
		unset($form_data['_wpnonce']);
		unset($form_data['_wp_http_referer']);

		$form_data['time'] = current_time( 'mysql' );

		$db -> update(
				$this -> table,
				$form_data,	
				array( 'id' => (int)$data['career_id'] )
			);		
	}
	
	/**
	 * Get all career items
	 *
	 * @since    1.0.0
	 * @return   object     Object list with all items
	 *
	 */
	public function getAll(){

		$table = $this -> table;	
		$results = $this -> db ->get_results( 
			"
			SELECT * 
			FROM $table	
			ORDER BY  ordering ASC
			"
			);

		return $results;
	}
	
	/**
	 * Get courses4career settings options
	 *
	 * @since    1.0.0
	 * @return   object     Object list with all items
	 *
	 */
	public function getOptions( $prefix = 'courses_for_career' ){

		$table = $this -> options_table;	
		$results = $this -> db ->get_results( 
			"
			SELECT * 
			FROM $table	
			WHERE option_name LIKE '%$prefix%'
			"
			);

		return $results;
	}
	
	/**
	 * Get all Sensei courses - post_type = course
	 *
	 * @since    1.0.0
	 * @return   object     Object list with all items
	 *
	 */
	public function getCourses(){

		$table = $this -> posts_table;	
		$results = $this -> db ->get_results( 
			"
			SELECT * 
			FROM $table 
			WHERE post_type = 'course' 
			AND post_status = 'publish'			
			"
		);

		return $results;
	}
	
	/**
	 * Get Sensei Courses posts by ID's defined in Career - post_type = course
	 *
	 * @since    1.0.0
	 * @param	 $post_type		string
	 * @param	 $post_in		array	   Array passed from carrer
	 * @return   $posts			object     Object list with all items
	 *
	 */
	public function getCoursesPosts( $post_type = 'course', $post_in = array() ){		

		$args = array(
                    'post_type' 	=> $post_type,
                    'post__in' 		=> $post_in,
					'post_status' 	=> 'publish'
                );
        $posts = get_posts($args);

		return $posts;
	}
	
	/**
	 * Get Sensei courses by Career - post_type = course
	 *
	 * @since     1.0.0
	 * $param     int        $id  choosen career id
	 * @return    object     Object list with all items
	 *
	 */
	public function courses_by_career( $id ){	

		$career_id = $id;		
	
		$table = $this -> table;	
		$result = $this -> db -> get_row( 
			"
			SELECT * 
			FROM $table 
			WHERE id = $career_id			 
			"
		);
		
		$courses = json_decode($result -> courses);	
		$posts = $this -> getCoursesPosts( 'course', $courses );
		
		foreach($posts as $post){
			
			// get featured image, post meta, permalink, categories, author name and attach to post object
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
			$meta = get_post_meta( $post->ID );
			$permalink = get_permalink( $post->ID );
			$categories =  get_the_terms( $post->ID, 'course-category' );
			
			// get cat permalinks and add to categories
			foreach($categories as $cat){
				$cat_link = get_category_link($cat);
				$cat -> cat_permalink = $cat_link;
			}
			
			$author_data = get_userdata( $post -> post_author );
			$author_name = $author_data -> data -> user_nicename;
			
			$post -> image = $image;
			$post -> permalink = $permalink;
			$post -> author = $author_name;
			$post -> categories = $categories;
			$post -> meta = $meta;		
		}
		
		// get courses4career settings options
		$options = $this -> getOptions();
		$results = [
			'posts' => $posts,
			'options' => $options
		];
		
		return $results;
	}

	/**
	 * Sanitize the input before handing it back to save to the database.
	 *
	 * @since    1.0.0
	 *
	 * @param    array    $input        The input.
	 * @return   array    $new_input    The sanitized input.
	 */
	public function sanitize( $input ) {

		$new_input = array();

		foreach ( $input as $key => $val ) {
			$new_input[ $key ] = ( isset( $input[ $key ] ) ) ?	sanitize_text_field( $val ) : '' ;
		}

		return $new_input;
	}
}

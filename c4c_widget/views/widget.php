<?php
$widget_id_full     = $this->id;  // widget name extended with the id
$widget_id_arr      = explode('-', $widget_id_full); // split in array bits
$widget_id          = $widget_id_arr[ count($widget_id_arr)-1 ]; // get the last one to get the key

if($instance['show_widget_title'] == 'Yes'){
	echo $before_title.esc_attr($instance['widget_title']).$after_title;
}

if($instance['show_description'] == 'Yes'){
	echo '<div class = "widget-description">'.esc_attr($instance['description']).'</div>' ;
}
?>

<div class="c4c-form search-course-page-search-form-wrap">
	<form action="" method="get" id="searchform" class="search-form-wrap search-for-courses">
		<input name="search-type" value="courses" type="hidden">
		<ul>
			<li>
				<select id="career-select" name="course-category" class="postform" data-wid = "<?php echo $widget_id ?>" data-type = "widget">
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
<div id="c4c-response-widget-<?php echo $widget_id ?>" class="course-container widget-response" > 
	<!-- loader --->
	<div class="animation_container widget <?php echo $widget_id ?>">
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

<p>
	<label	for="<?php echo $this->get_field_id('widget_title'); ?>"><?php _e('Widget Title', 'c4c-widget'); ?></label><br/>
	<input class="widefat" name="<?php echo $this->get_field_name('widget_title'); ?>" id="<?php echo $this->get_field_id('widget_title'); ?>" value="<?php echo esc_attr($instance['widget_title']); ?>"/>
</p>

<p>
	<label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('Widget Description', 'c4c-widget'); ?>	</label><br/>
	<textarea name="<?php echo $this->get_field_name('description'); ?>" id="<?php echo $this->get_field_id('description'); ?>" cols="42" rows="2"><?php echo esc_attr($instance['description']); ?></textarea>
</p>


<p>	<label	for="<?php echo $this->get_field_id('show_widget_title'); ?>"><?php _e('Show Widget Title', 'c4c-widget'); ?> </label><br/>	
	<select  id="<?php echo $this->get_field_id('show_widget_title'); ?>"  name="<?php echo $this->get_field_name('show_widget_title'); ?>" >
		<option value="Yes"  <?php selected($instance['show_widget_title'],'Yes'); ?>><?php _e( 'Yes', 'c4c-widget'); ?></option>
		<option value="No" <?php selected($instance['show_widget_title'],'No'); ?> ><?php _e( 'No', 'c4c-widget'); ?></option>
	</select>		
</p>

<p>	<label	for="<?php echo $this->get_field_id('show_description'); ?>"><?php _e('Show Widget Description', 'c4c-widget'); ?> </label><br/>	
	<select  id="<?php echo $this->get_field_id('show_description'); ?>"  name="<?php echo $this->get_field_name('show_description'); ?>" >
		<option value="Yes"  <?php selected($instance['show_description'],'Yes'); ?>><?php _e( 'Yes', 'c4c-widget'); ?></option>
		<option value="No" <?php selected($instance['show_description'],'No'); ?> ><?php _e( 'No', 'c4c-widget'); ?></option>
	</select>		
</p>

<p>	<label	for="<?php echo $this->get_field_id('show_image'); ?>"><?php _e('Show Course Image', 'c4c-widget'); ?> </label><br/>	
	<select  id="<?php echo $this->get_field_id('show_image'); ?>"  name="<?php echo $this->get_field_name('show_image'); ?>" >
		<option value="Yes"  <?php selected($instance['show_image'],'Yes'); ?>><?php _e( 'Yes', 'c4c-widget'); ?></option>
		<option value="No" <?php selected($instance['show_image'],'No'); ?> ><?php _e( 'No', 'c4c-widget'); ?></option>
	</select>		
</p>

<p>	<label	for="<?php echo $this->get_field_id('show_meta'); ?>"><?php _e('Show Course Meta', 'c4c-widget'); ?> </label><br/>	
	<select  id="<?php echo $this->get_field_id('show_meta'); ?>"  name="<?php echo $this->get_field_name('show_meta'); ?>" >
		<option value="Yes"  <?php selected($instance['show_meta'],'Yes'); ?>><?php _e( 'Yes', 'c4c-widget'); ?></option>
		<option value="No" <?php selected($instance['show_meta'],'No'); ?> ><?php _e( 'No', 'c4c-widget'); ?></option>
	</select>		
</p>

<p>	<label	for="<?php echo $this->get_field_id('show_title'); ?>"><?php _e('Show Course Title', 'c4c-widget'); ?> </label><br/>	
	<select  id="<?php echo $this->get_field_id('show_title'); ?>"  name="<?php echo $this->get_field_name('show_title'); ?>" >
		<option value="Yes"  <?php selected($instance['show_title'],'Yes'); ?>><?php _e( 'Yes', 'c4c-widget'); ?></option>
		<option value="No" <?php selected($instance['show_title'],'No'); ?> ><?php _e( 'No', 'c4c-widget'); ?></option>
	</select>		
</p>

<p>	<label	for="<?php echo $this->get_field_id('show_excerpt'); ?>"><?php _e('Show Course Excerpt', 'c4c-widget'); ?> </label><br/>	
	<select  id="<?php echo $this->get_field_id('show_excerpt'); ?>"  name="<?php echo $this->get_field_name('show_excerpt'); ?>" >
		<option value="Yes"  <?php selected($instance['show_excerpt'],'Yes'); ?>><?php _e( 'Yes', 'c4c-widget'); ?></option>
		<option value="No" <?php selected($instance['show_excerpt'],'No'); ?> ><?php _e( 'No', 'c4c-widget'); ?></option>
	</select>		
</p>

<p>
	<label	for="<?php echo $this->get_field_id('css_class'); ?>"><?php _e('Additional CSS class', 'c4c-widget'); ?></label><br/>
	<input class="widefat" name="<?php echo $this->get_field_name('css_class'); ?>" id="<?php echo $this->get_field_id('css_class'); ?>" value="<?php echo esc_attr($instance['css_class']); ?>"/>
</p>
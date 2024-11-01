<?php

//Widget Action
add_action('widgets_init', 'riv_register_widget');

function riv_register_widget() {
	register_widget('riv_widget');
}

class riv_widget extends WP_Widget {
	
	// Process the new widget
	function riv_widget() {
		$widget_ops = array(
			'classname' => 'riv_widget_class',
			'description' => 'Display information on a given USGS Station'
		);
		$this->WP_Widget( 'riv_widget', 'River Data Widget', $widget_ops);
	}
	
	// Build the widget settings form
	function form($instance) {
		$defaults = array(
			'title' => '',
			'id' => '',
			'level' => 'on',
			'gage' => 'on',
			'name' => 'on',
			'url' => 'on',
			'graph' => 'on',
			'gage_graph' => 'on',
			'error' => ''
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		extract($instance);
		
		if(esc_attr($error) != '') {
			echo "<p>" . $error . "</p>";
		}
		
		?>
		<p>Title (overrides Station Name):<input class="widefat" name="<?php echo $this->get_field_name('title'); ?>"
			type="text" value="<?php echo esc_attr($title); ?>" /></p>
		<p>River ID <a href="http://www.jtwventures.com/usgs-river-data-wordpress-plugin/">Need Help?</a> <input class="widefat" name="<?php echo $this->get_field_name('id'); ?>"
			type="text" value="<?php echo esc_attr($id); ?>" /></p>
		<p>Show Station Name: <input name="<?php echo $this->get_field_name( 'name' ); ?>" 
				type="checkbox" <?php checked($name, 'on'); ?> /></p>
		<p>Show Water Level: <input name="<?php echo $this->get_field_name( 'level' ); ?>" 
				type="checkbox" <?php checked($level, 'on'); ?> /></p>
		<p>Show Gage Height: <input name="<?php echo $this->get_field_name( 'gage' ); ?>" 
				type="checkbox" <?php checked($gage, 'on'); ?> /></p>
		<p>Show Station Graph: <input name="<?php echo $this->get_field_name( 'graph' ); ?>" 
				type="checkbox" <?php checked($graph, 'on'); ?> /></p>
		<p>Show Gage Graph: <input name="<?php echo $this->get_field_name( 'gage_graph' ); ?>" 
				type="checkbox" <?php checked($gage_graph, 'on'); ?> /></p>
		<p>Show Station URL: <input name="<?php echo $this->get_field_name( 'url' ); ?>" 
				type="checkbox" <?php checked($url, 'on'); ?> /></p>
		<?php
	}
	
	// Update Widget
	function update($new_instance, $old_instance) {
		$instance 				= $old_instance;
		$instance['title'] 		= esc_attr($new_instance['title']);
		$instance['id'] 		= esc_attr($new_instance['id']);
		$instance['level'] 		= strip_tags($new_instance['level']);
		$instance['gage'] 		= strip_tags($new_instance['gage']);
		$instance['name']		= strip_tags($new_instance['name']);
		$instance['url'] 		= strip_tags($new_instance['url']);
		$instance['graph'] 		= strip_tags($new_instance['graph']);
		$instance['gage_graph'] = strip_tags($new_instance['gage_graph']);
		
		return $instance;
	}
	
	// Display the widget
	function widget($args, $instance) {
		extract($args);
		extract($instance);
		
		// Gather the data
		$river_data = riv_meta_gather( $id ); 
		// var_dump($river_data);
		
		// If the id does not pass the 8 digit validation return error
		if ($river_data == false) {
			echo "<strong>Error:</strong> Must Supply a Valid 8 Digit USGS ID Number";
		}
		else {
			extract($river_data);
			
			// If Title is set use that as Title if not use the River_Name
			if($title == '') 
				$title = $river_name;
			
			if($name == "on")
				$name = "<div id='riv_widget_name'> " . $river_name . "</div>";
			else
				$name = '';
			
			if ($level === "on")
				$level = "<div id='riv_widget_water_level'> Current Level: " . $current_water_level . "</div><br />";
			else
				$level = '';
			
			if($gage == "on")
				$gage = "<div id='riv_widget_gage_level'> Gage Height: " . $current_gage_height . "</div><br />";
			else
				$gage = '';
			
			if ($graph == "on")
				$graph = "<div id='riv_widget_graph'> <a href=". $graph_url . " target='_blank'><img src='" . $graph_url . "'width='95%' alt='Water level Graph for ". $river_name . "' /></a></div><br />";
			else
				$graph = '';
			
			if ($gage_graph == "on")
				$gage_graph = "<div id='riv_widget_gage_graph'> <a href=". $gage_url . " target='_blank'><img src='" . $gage_url . "'width='95%' alt='Water level Graph for ". $river_name . "' /></a></div><br />";
			else
				$gage_graph = '';
			
			if ($url == "on")
				$url = "<div id='riv_widget_station_url'><a href='" . $station_url . "' target='_blank' >USGS Link</a></div>";
			else
				$url = '';
				
			echo $before_widget;
			echo $before_title . $title . $after_title;
			echo $name;
			echo $level;
			echo $graph;
			echo $gage;
			echo $gage_graph;
			echo $url;
			echo $after_widget;
		}

	}
	
} // End Class riv_widget


?>
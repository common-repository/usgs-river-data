<?php
// ShortCode Defaults Function
function shortcode_defaults() {
	$shortcode_defaults = array (
		'id' => false,
		'config' => '4'
	);
	return $shortcode_defaults;
}


// Register Short Code [River #]
add_shortcode( 'river', 'riv_full_display' );

function riv_full_display( $attr ) {
	
	// Retreive and Sanitize $riv_id
	$riv_id = $attr['id'];
	$river_data = riv_meta_gather($riv_id);

	// If the id does not pass the 8 digit validation return error
	if ($river_data == false) {
		return "<strong>Error:</strong> Must Supply a Valid 8 Digit Number";
	}
	
	// Get and Combine $attr with defaults
	$shortcode_defaults = shortcode_defaults();
	$shortcode_values = shortcode_atts( $shortcode_defaults, $attr );
	extract($shortcode_values);
	
	// Get Configuration Settings first from User then Options
	if ($config == 4) {
		$options = get_option( 'riv_options' );
		extract($options);
	}
	else {
		$config_select = "config_" . htmlentities( wp_strip_all_tags( $attr['config'] ));
	}
	
	if ($config_select == 'config_3')
		return riv_config_3($riv_id);
	elseif ($config_select == 'config_2')
		return riv_config_2($riv_id);
	else
		return riv_config_1($riv_id);
	
}

// Register Short Code for River Name [river_name #]
add_shortcode( 'river_name', 'riv_name_display' );

function riv_name_display( $attr ){
	$river_data = riv_meta_gather($attr['id']);
	
	// If the id does not pass the 8 digit validation return error
	if ($river_data == false) {
		return "<strong>Error:</strong> Must Supply a Valid 8 Digit Number";
	}
	else {
		return $river_data['river_name'];
	}
}

// Register Short Code for the Current River Water Level [river_level #]
add_shortcode( 'river_level', 'riv_level_display' );

function riv_level_display( $attr ){
	$river_data = riv_meta_gather($attr['id']);
	
	// If the id does not pass the 8 digit validation return error
	if ($river_data == false) {
		return "<strong>Error:</strong> Must Supply a Valid 8 Digit Number";
	}
	else {
		return $river_data['current_water_level'];
	}
}

// Register Short Code for the Current Gage Level [river_gage #]
add_shortcode( 'river_gage', 'riv_gage_display' );

function riv_gage_display( $attr ){
	$river_data = riv_meta_gather($attr['id']);

	// If the id does not pass the 8 digit validation return error
	if ($river_data == false) {
		return "<strong>Error:</strong> Must Supply a Valid 8 Digit Number";
	}
	else {
		return $river_data['current_gage_height'];
	}
}

// Register Short Code for River Station  URL [river_station #]
add_shortcode( 'river_station', 'riv_url_display' );

function riv_url_display( $attr ){
	$river_data = riv_meta_gather($attr['id']);
	
	// If the id does not pass the 8 digit validation return error
	if ($river_data == false) {
		return "<strong>Error:</strong> Must Supply a Valid 8 Digit Number";
	}
	else {
		return $river_data['station_url'];
	}
}

// Register Short Code for River Level Graph URL [river_graph #]
add_shortcode( 'river_graph', 'riv_graph_display' );

function riv_graph_display( $attr ){
	$river_data = riv_meta_gather($attr['id']);
	
	// If the id does not pass the 8 digit validation return error
	if ($river_data == false) {
		return "<strong>Error:</strong> Must Supply a Valid 8 Digit Number";
	}
	else {
		return $river_data['graph_url'];
	}
}

// Register Short Code for River Level Graph URL [river_gage_graph #]
add_shortcode( 'river_gage_graph', 'riv_gage_graph_display' );

function riv_gage_graph_display( $attr ){
	$river_data = riv_meta_gather($attr['id']);
	
	// If the id does not pass the 8 digit validation return error
	if ($river_data == false) {
		return "<strong>Error:</strong> Must Supply a Valid 8 Digit Number";
	}
	else {
		return $river_data['gage_url'];
	}
}
?>
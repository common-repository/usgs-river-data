<?php
/*
Plugin Name: USGS River Data
Plugin URI: http://jtwventures.com/projects/usgs
Description: This plugin gathers the water level, river name and other data from the USGS website and presents it in a way helpful for river guides and other fisherman to see relavent data. 
Author: J. Tyler Wiest
Version: 1.21
Author URI: http://www.jtwventures.com
License: GPLv2
*/

// Add Custom Meta Box
include 'river_custom_meta.php';

// Create Shortcode Information
include 'river_shortcode.php';

// Include the River Functions
include 'river_functions.php';

// Include Options Page
include 'river_options.php';

// Include Widget Settings
include 'river_widget.php';

// Include Style Sheet
add_action('wp_enqueue_scripts', 'riv_load_css');

function riv_load_css() {

	$myStyleUrl = plugins_url('css/styles.css', __FILE__);
	$myStyleFile = WP_PLUGIN_DIR . '/river_data/css/styles.css';
	
	if ( file_exists($myStyleFile) ) {
		wp_register_style('riv_css', $myStyleUrl);
		wp_enqueue_style( 'riv_css');
	}
}

?>
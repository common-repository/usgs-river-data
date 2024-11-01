<?php

// Add a menu for River Options to the Settings drop down
add_action('admin_menu', 'riv_add_page');

function riv_add_page() {
	add_options_page( 'River Options', 'River Options', 'manage_options', 
		'riv_options_page', 'riv_options_page_display');
}

// River Options Page Display Function
function riv_options_page_display() { ?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2>River Options</h2>
		<form action="options.php" method="post">
				<?php settings_fields('riv_options'); ?>
				<?php do_settings_sections('riv_options_page'); ?>
				<?php do_settings_sections('riv_cache_page'); ?>
				<input name="Submit" type="submit" value="Save Changes" />
		</form>
	</div>
	<?php
}

// Register and define the settings
add_action('admin_init', 'riv_admin_init');

function riv_admin_init() {
	register_setting( 
		'riv_options', 
		'riv_options',
		'riv_validate_options' 
		);
	add_settings_section( 
		'riv_plugin_main', 
		'Default Configuration Style for [River ID#]', 
		'riv_section_text', 
		'riv_options_page'); 
	add_settings_field(
		'riv_options_config_select',
		'Select a Default Configuration',
		'riv_setting_input',
		'riv_options_page',
		'riv_plugin_main'
		);
	add_settings_field(
		'riv_options_cache_config',
		'Set Cache Expiration',
		'riv_cache_input',
		'riv_options_page',
		'riv_plugin_main'
		);
}

// Admin Init Call Back Functions

//Explantion about this section
function riv_section_text() {
	//echo '<p>Choose your configuration style here.</p>';
}

// Display and fill the form field
function riv_setting_input() {
	$options = get_option( 'riv_options' );

	if ($options == false) {
		$options = array();
	}
	
	$defaults = array(
		'config_select' => 'config_1'
	);
	
	$options = wp_parse_args($options, $defaults);
	extract($options);
	
	// Get Config Image Urls
	$config_1_url = plugins_url('images/config_1_image.png', __FILE__);
	$config_2_url = plugins_url('images/config_2_image.png', __FILE__);
	$config_3_url = plugins_url('images/config_3_image.png', __FILE__);

	?>
	<div id="config_options_table">
		<input type="radio" name="riv_options[config_select]" value="config_1" 
			<?php checked( 'config_1' == $config_select ); ?> /> Configuration 1<br />
		<input type="radio" name="riv_options[config_select]" value="config_2" 
			<?php checked( 'config_2' == $config_select ); ?> /> Configuration 2<br />
		<input type="radio" name="riv_options[config_select]" value="config_3" 
			<?php checked( 'config_3' == $config_select ); ?> /> Configuration 3<br />
			
		<h3>Configuration 1</h3>
			<img id="config_1_image" src="<?php echo $config_1_url; ?>" alt="config_1" width="300px" />
		<h3>Configuration 2</h3>
			<img id="config_2_image" src="<?php echo $config_2_url; ?>" alt="config_2" width="300px" />
		<h3>Configuration 3</h3>
			<img id="config_3_image" src="<?php echo $config_3_url; ?>" alt="config_3" width="300px" />
	</div>
	<?php
}

function riv_cache_input(){
	$options = get_option( 'riv_options' );

	if ($options == false) {
		$options = array();
	}
	
	$defaults = array(
		'cache_minutes' => 15,
		'cache_hours' => 0,
		'cache_days' => 0
	);
	
	$options = wp_parse_args($options, $defaults);
	extract($options);
	?>
		<div id="cache_options">
			<label for="cache_minutes">Minutes</label>
			<input type="number" name="riv_options[cache_minutes]" max="59" 
				value="<?php echo $cache_minutes; ?>" /><br />
			
			<label for="cache_minutes">Hours</label>
			<input type="number" name="riv_options[cache_hours]" 
				value="<?php echo $cache_hours; ?>" /><br />
			
			<label for="cache_minutes">Days</label>
			<input type="number" name="riv_options[cache_days]" 
				value="<?php echo $cache_days; ?>" /><br />
		</div>
		
		<em>Note: The USGS updates it's API every 15 minutes.</em>
  <?php
}

// Validate user input
function riv_validate_options( $input ) {

	// Make sure one of the configuartions is set
	if ($input['config_select'] === 'config_1' or 
		$input['config_select'] === 'config_2' or 
		$input['config_select'] === 'config_3') {
		}
	else {
		$input['config_select'] = 'config_1';
	}	

	// Make sure the cache information is valid
	if ( !is_numeric( $input['cache_minutes'] ) or $input['cache_minutes'] > 59 ) $input['cache_minutes'] = 0;
	if ( !is_numeric( $input['cache_hours'] ) ) $input['cache_hours'] = 0;
	if ( !is_numeric( $input['cache_days'] ) ) $input['cache_days'] = 0;
	
	return $input;
}

?>
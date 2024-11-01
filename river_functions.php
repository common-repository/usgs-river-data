<?php

// Gather the Data from the USGS
// Accepts the 8 digit USGS ID Number
function riv_meta_gather( $river_usgs_id ) {
	// Validate the River USGS ID Provided by User
	if (!river_id_validate($river_usgs_id)) {
		return false;
	}

	$riverCache = getRiverCache($river_usgs_id);
	if( $riverCache )
    	return $riverCache;
	
	// Construct the Station URL and Graph URL
	$station_url = "http://waterdata.usgs.gov/nwis/uv?" . $river_usgs_id;
	$graph_url = "http://waterdata.usgs.gov/nwisweb/graph?site_no=" . $river_usgs_id . "&parm_cd=00060";
	$gage_url = "http://waterdata.usgs.gov/nwisweb/graph?site_no=" . $river_usgs_id . "&parm_cd=00065";
	
	// Define USGS Constants and send Get Request
	$api_url = "http://waterservices.usgs.gov/nwis/iv?sites=";
	$api_url_ending = "&parameterCd=00060,00065&format=json";
	$api_response = wp_remote_get($api_url . $river_usgs_id . $api_url_ending);
		
	// Get JSON object
	$json = wp_remote_retrieve_body( $api_response );
	
	// Make sure the request was successful or return false
	if( empty( $json ) )
		return false;
	
	// Decode JSON
	// Return an array with the river name and current water level
	$json = json_decode( $json );

	if (!isset( $json->value->timeSeries[0]->sourceInfo->siteName ))
		return false;
		
	$usgsData = array(
		'river_name' => $json->value->timeSeries[0]->sourceInfo->siteName,
		'river_id' => $river_usgs_id,
		'current_water_level' => $json->value->timeSeries[0]->values[0]->value[0]->value,
		'current_gage_height' => $json->value->timeSeries[1]->values[0]->value[0]->value,
		'station_url' => $station_url,
		'graph_url' => $graph_url,
		'gage_url' => $gage_url
	);
	
	saveRiverCache($usgsData);

	return $usgsData;
}


function getRiverCacheDuration(){
	$options = get_option( 'riv_options' );
	
	$minutes = $options['cache_minutes'];
	$hours = $options['cache_hours'];
	$days = $options['cache_days'];
	
	$duration = $minutes . " minutes " . $hours	. " hours " . $days . " days"; 
	$duration = strtotime($duration) - time();
	
	return $duration;
}


function saveRiverCache($riverData){
	global $post;
	$post_id = $post->ID;
	$riverData['savedAtTimestamp'] = time();
	update_post_meta($post_id, '_riv_cache_' . $riverData['river_id'], serialize($riverData));
}

function getRiverCache($river_id){
	global $post;
	$post_id = $post->ID;
	$riverCache = get_post_meta( $post_id, '_riv_cache_' . $river_id, true);
	$cacheDuration = getRiverCacheDuration();
		
	if($riverCache){	
		$riverCache = unserialize($riverCache);
		if(time() - $riverCache['savedAtTimestamp'] < $cacheDuration) {
			return $riverCache;
		}
	}
	return false;
}

// Print the USGS Data Gathered
function riv_meta_print( $river_usgs_id ) {
	// Gather the USGS Data
	$river_array = riv_meta_gather( $river_usgs_id );
	extract($river_array);
	?>
	<br />
	<div id="riv_meta_data">
		<table>
			<thead>
				<tr>
					<th>Attribute</th>
					<th>Value</th>
					<th>Shortcode</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>All Data</td>
					<td>All information listed below.</td>
					<td>[river id='<?php echo $river_id; ?>']</td>
				</tr>
				<tr>
					<td>Name</td>
					<td><?php echo $river_name; ?></td>
					<td>[river_name id='<?php echo $river_id; ?>']</td>
				</tr>
				<tr>
					<td>Current Water Level</td>
					<td><?php echo $current_water_level; ?></td>
					<td>[river_level id='<?php echo $river_id; ?>']</td>
				</tr>
				<tr>
					<td>Current Gage Height</td>
					<td><?php echo $current_gage_height; ?></td>
					<td>[river_gage id='<?php echo $river_id; ?>']</td>
				</tr>
				<tr>
					<td>Station URL</td>
					<td><?php echo $station_url; ?></td>
					<td>[river_station id='<?php echo $river_id; ?>']</td>
				</tr>
				<tr>
					<td>Graph URL</td>
					<td><?php echo $graph_url; ?></td>
					<td>[river_graph id='<?php echo $river_id; ?>']</td>
				</tr>
				<tr>
					<td>Gage URL</td>
					<td><?php echo $gage_url; ?></td>
					<td>[river_gage_graph id='<?php echo $river_id; ?>']</td>
				</tr>
			</tbody>
		</table>
	</div>
	
	<?php 
}

// Validate the USGS number to ensure it a string of 8 numbers
function river_id_validate( $river_usgs_id ) {

	if( preg_match('/^\d{8}$/', $river_usgs_id)) {
		return true;
	}
	else {
		return false;
	}
}

// Config_1 River Display
function riv_config_1( $riv_id ){
	
	// Gather the USGS Data
	$river_array = riv_meta_gather( $riv_id );
	extract($river_array);
	
	$output = "<div id='config_1'>
		<h2>" . $river_name . "</h2>
		<div>Current Water Level: <?php echo $current_water_level; ?></div>
		<img src='" . $graph_url ."' width='576px' height='400px' alt='Water Level Graph for USGS Station " . $riv_id ."' />
		<a href='" . $station_url ."' target='_blank'>Source</a>
	</div>";
	
	return $output;
}

// Config_2 River Display
function riv_config_2( $riv_id ){
	
	// Gather the USGS Data
	$river_array = riv_meta_gather( $riv_id );
	extract($river_array);
	
	$output = "<div id='config_2'>
		<p>". $river_name . " - " . $current_water_level . "(<a href='" . $station_url . "' target='_blank'>Source</a>)</p>
	</div>";
	
	return $output;
}

// Config_3 River Display
function riv_config_3( $riv_id ){
	
	// Gather the USGS Data
	$river_array = riv_meta_gather( $riv_id );
	extract($river_array);

	$output = "<div id='config_3'>
			<h2>" . $river_name . "</h2>
			<p>Current Water Level: " . $current_water_level . " - 
			<a href='" . $station_url . "' target='_blank'>Source</a></p>
		</div>";

	return $output;
}

// Displays the River Name
function the_river_name( $post_id = null ) {
	if (is_null($post_id)) {
		global $post;
		$post_id = $post->ID;
	}
		
	// Gather the USGS Data
	$riv_id = get_post_meta( $post_id, '_riv_id', true);
	$river_array = riv_meta_gather( $riv_id );
	if ($river_array == false) 
		echo "There has been an error with the provided USGS station ID";
	else {
		extract($river_array);
		echo "<div id='river_name'>" . $river_name . "</div>";
	}
}

function the_water_level( $post_id = null ) {
	if (is_null($post_id)) {
		global $post;
		$post_id = $post->ID;
	}
		
	// Gather the USGS Data
	$riv_id = get_post_meta( $post_id, '_riv_id', true);
	$river_array = riv_meta_gather( $riv_id );
	if ($river_array == false) 
		echo "There has been an error with the provided USGS station ID";
	else {
		extract($river_array);
		echo "<div id='water_level'>" . $current_water_level . "</div>";
	}
}

?>
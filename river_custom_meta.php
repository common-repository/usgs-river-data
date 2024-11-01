<?php

// Hook to create Meta Box
add_action( 'add_meta_boxes', 'river_mbe_create_post');
add_action( 'add_meta_boxes', 'river_mbe_create_page');


// Register Meta Box for Post
function river_mbe_create_post() {
	add_meta_box('riv_id_meta', 'USGS River ID Number', 'riv_id_function', 'post', 'normal', 'high');
}

// Register Meta Box for Page
function river_mbe_create_page() {
	add_meta_box('riv_id_meta', 'USGS River ID Number', 'riv_id_function', 'page', 'normal', 'high');
}

// Format the Meta Box
function riv_id_function( $post ) {
	
	// Retreive meta data if it exists
	$riv_id = get_post_meta( $post->ID, '_riv_id', true);
	?>
	<div id="river_meta_box">
		<p>Please Enter the ID Number Provided by the USGS and then Update the page. </br> <a href="http://jtwventures.com/projects/usgs" target="blank">Need help finding the USGS ID number?</a></p>
	
		<div id="id_text_box">
			USGS ID Number: <input type="text" id="river_usgs_num" name="riv_id" value="<?php echo esc_attr( $riv_id ) ?>" />
		</div>
	</div>
	<?php
	
	// If the value exists display the gatered data
	if ( $riv_id != null ){
		
		// If the river id returns valid data display it
		if (riv_meta_gather( $riv_id ))
			riv_meta_print( $riv_id );
		else
			echo "<p><strong>Error:</strong> Must be a valid 8 digit USGS ID Number</p>";
	}
	
}

// Hook to Save the metabox data
add_action( 'save_post', 'river_mbe_save_meta');

function river_mbe_save_meta( $post_id ) {
	
	// Verify the meta data is set
	if ( isset( $_POST['riv_id'] ) ) {
		
		update_post_meta( $post_id, '_riv_id', strip_tags( $_POST['riv_id']));
		
		}
	}
?>
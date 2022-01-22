<?php

/**
 * Plugin name: WP Simple Query APIs
 * Plugin URI: https://github.com/shannon36
 * Description: Simple plugin meant for external REST APIs
 * Author: Shannon H.
 * Author URI: https://github.com/shannon36
 * version: 0.1.0
 * License: GPL2 or later.
 * text-domain: wp-simple-query-apis
 */

// If this file is access directly, abort!!!
defined( 'ABSPATH' ) or die( 'Unauthorized Access' );

function get_send_data() {

    $url = 'https://jsonplaceholder.typicode.com/users';
    
    $arguments = array(
        'method' => 'GET'
    );

	$response = wp_remote_get( $url, $arguments );

	if ( is_wp_error( $response ) ) {
		$error_message = $response->get_error_message();
		return "Something went wrong: $error_message";
	/*} else {
		echo '<pre>';
		var_dump( wp_remote_retrieve_body( $response ) );
		echo '</pre>';
	}*/
		
	} 
	
//decodes JSON objects and shows as text in Montserrat
        $results = json_decode( wp_remote_retrieve_body( $response ) );
		echo '<p style="font-family: Montserrat;font-weight: bold; font-size: medium;">' . number_format($results) . '</p>';

}	

/**
 * Register a custom menu page to view the information queried.
 */
function register_my_custom_menu_page() {
	add_menu_page(
		__( 'Query API Test Settings', 'query-apis' ),
		'Query API Test',
		'manage_options',
		'api-test.php',
		'techiepress_get_send_data',
		'dashicons-testimonial',
		16
	);
}

add_action( 'admin_menu', 'register_my_custom_menu_page' );

//included a shortcode function
add_shortcode('show_data', 'get_send_data()');

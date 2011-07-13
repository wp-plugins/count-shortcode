<?php
/*
Plugin Name: Count Shortcode
Plugin URI: http://
Description: Shortcode to count number of posts that match a given set of criteria; provides link to query to display list of matching posts
Version: 1.1
Author: The Federal Communications Commission
Author URI: http://fcc.gov/developers
License: GPL2
*/

/**
 * Callback function to process count shortcode
 * @param array $atts attributes passed to the shortcode
 * @returns string count with link to query
 */
function fcc_count_shortcode ( $atts, $content = null) {

	//init array with defaults; tell WP_Query not to run extra querires we dont need
	$defaults = array( 'update_term_cache' => false, 'update_meta_data_cache' => false, 'post_type' => '' );
	
	//get list of all taxonomies; this is the list of possible attributes
	$taxonomies = get_taxonomies();
	
	//loop through the taxonomies and add them to the defaults array as a blank
	foreach ( $taxonomies as $taxonomy ) {
		$defaults[ $taxonomy ] = '';
	}
	
	//Proccess the shortcode arguments relying on our defaults
	//Note, arguments not in the defaults array are removed
	$args = shortcode_atts( $defaults, $atts );
		
	//set up the query with the shortcode arguments
	$query = new WP_Query( $args );
	
	//remove any empty arguments
	$args = array_filter( $args, 'strlen' );
	
	//format the output as a count and link to the query, return
	return '<a href="'. esc_url( add_query_arg( $args, get_bloginfo('url') ) ) .'">' . number_format_i18n( $query->found_posts ) . '</a>';

}

//let WP know about our shortcode
add_shortcode( 'count', 'fcc_count_shortcode' );

?>
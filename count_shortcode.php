<?php
/*
Plugin Name: Count Shortcode
Plugin URI: http://
Description: Shortcode to count number of posts that match a given set of criteria; provides link to query to display list of matching posts
Version: 2.0
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

/** 
 * List all terms in a given taxonomy, or across all taxonomies
 * 
 * Usage: [list-counts taxonomy="tags"]
 * Usage: [list-counts]
 * Usage: [list-counts hide_empty="true"]
 * 
 */
function fcc_list_taxonomy_shortcodes( $atts, $content = null ) {

	$defaults = array( 'taxonomy' => implode( ',', get_taxonomies() ), 'hide_empty' => false );

	$atts = shortcode_atts( $defaults, $atts );

	$taxs = explode( ',', $atts['taxonomy'] );
	
	$output = '<div class="counts-list">';
	
	foreach ( $taxs as $tax ) {

		$tax_obj = get_taxonomy( $tax );
		
		if ( !$tax_obj )
			return false;
			
		if ( !$tax_obj->query_var || !$tax_obj->public )
			continue;
			
		$terms = get_terms( $tax_obj->name );
		if ( sizeof( $terms ) == 0)
			continue;
			
		$output .= '<div class="taxonomy ' . $tax .'">';
		$output .= '<strong>' . $tax_obj->labels->name . '</strong><ul>';
					
		$output .= wp_list_categories( array( 
								'taxonomy' => $tax, 
								'show_count' => true, 
								'echo' => false,
								'title_li' => false,
								'hide_empty' => $atts['hide_empty'],
							) );
		
		$output .= "</div>";

	}
	
	$output .= "</div>";
	
	return $output;

}

add_shortcode( 'list-counts', 'fcc_list_taxonomy_shortcodes' );

?>
<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package dndest
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function dndest_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'dndest_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function dndest_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'dndest_pingback_header' );

// Our custom post type function
function create_npc_posttype() {
 
	register_post_type( 'NPC',
	// CPT Options
			array(
					'labels' => array(
							'name' => __( 'NPCs' ),
							'singular_name' => __( 'NPC' )
					),
					'public' => true,
					'has_archive' => true,
					'rewrite' => array('slug' => 'npc'),
					'show_in_rest' => true,

			)
	);
}
// Hooking up our function to theme setup
add_action( 'init', 'create_npc_posttype' );
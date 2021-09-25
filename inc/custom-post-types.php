<?php
/**
 * Registering Custom Post Types
 *
 * @package dndwp
 */

// NPC custom post type function
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
					'description' => "Non Player Character",
					'public' => true,
					'supports' => array(
						'title', 'revisions', 'custom-fields'
						// 'title', 'comments', 'revisions', 'author', 'page-attributes', 'custom-fields'
					),
			)
	);
}

// Hooking up NPC function to theme setup
add_action( 'init', 'create_npc_posttype' );

// PC custom post type function
function create_pc_posttype() {
	register_post_type( 'PC',
	// CPT Options
			array(
					'labels' => array(
							'name' => __( 'PCs' ),
							'singular_name' => __( 'PC' )
					),
					'public' => true,
					'has_archive' => true,
					'rewrite' => array('slug' => 'pc'),
					'show_in_rest' => true,
					'public' => true,
					'description' => "Player Character",
					'supports' => array(
						'title', 'revisions', 'custom-fields'
						// 'title', 'comments', 'revisions', 'author', 'page-attributes', 'custom-fields'
					),
			)
	);
}

// Hooking up PC function to theme setup
add_action( 'init', 'create_pc_posttype' );

// Player custom post type function
function create_player_posttype() {
 
	register_post_type( 'Player',
	// CPT Options
			array(
					'labels' => array(
							'name' => __( 'Players' ),
							'singular_name' => __( 'Player' )
					),
					'public' => true,
					'has_archive' => true,
					'rewrite' => array('slug' => 'player'),
					'show_in_rest' => true,
					'public' => true,
					'description' => "Players of the game",
					'supports' => array(
						'title', 'revisions', 'custom-fields'
						// 'title', 'comments', 'revisions', 'author', 'page-attributes', 'custom-fields'
					),
			)
	);
}
// Hooking up NPC function to theme setup
add_action( 'init', 'create_player_posttype' );

// Item custom post type function
function create_item_posttype() {
 
	register_post_type( 'Item',
	// CPT Options
			array(
					'labels' => array(
							'name' => __( 'Items' ),
							'singular_name' => __( 'Item' )
					),
					'public' => true,
					'has_archive' => true,
					'rewrite' => array('slug' => 'item'),
					'show_in_rest' => true,
					'public' => true,
					'description' => "In game items",
					'supports' => array(
						'title', 'revisions', 'custom-fields'
						// 'title', 'comments', 'revisions', 'author', 'page-attributes', 'custom-fields'
					),
			)
	);
}
// Hooking up Item function to theme setup
add_action( 'init', 'create_item_posttype' );
<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package dndest
 */

//  @require_once(get_theme_file_path('/inc/options_page.php'));
 @require_once(get_theme_file_path('/inc/wp-queries.php'));

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
					// 'supports' => array(
					// 	'title', 'editor', 'comments', 'revisions', 'author', 'page-attributes', 'custom-fields'
					// ),
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
					'description' => "Player Character",
					// 'supports' => array(
					// 	'title', 'editor', 'comments', 'revisions', 'author', 'page-attributes', 'custom-fields'
					// ),
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
					'description' => "Players of the game",
					// 'supports' => array(
					// 	'title', 'editor', 'comments', 'revisions', 'author', 'page-attributes', 'custom-fields'
					// ),
			)
	);
}
// Hooking up NPC function to theme setup
add_action( 'init', 'create_player_posttype' );


/**
 * Sets field based on visibility options
 * Field is always visible if currently logged in user can edit posts
 * 
 * @param array $field - two field array
 *  $field['visibility'] - visibility of field
 * 	$field['value'] - value of the field
 * 
 */
function setField($field) {
	$is_user_admin = current_user_can( 'edit_posts' );

	if($is_user_admin || $field['visibility'] == 'Visible') {
		return($field['value']);
	}
	else if(!$field['value'] || $field['visibility'] == 'Hidden') {
		return "";
	}
	else if($field['visibility'] == 'Partially visible') {
		return "???";
	}
}

function listCharRelationships($relationshipArray) {
	if($relationshipArray) {
		$list = '<div class="relationships__list">';
		foreach($relationshipArray as $npc_id) {

			$card = getCharCard($npc_id);

			$list .= $card;
		}
		$list .= "</div>";
		return $list;
	}
	else {
		return "";
	}
}

function getCharCard($char_id) {
	$post_type = get_post_type($char_id);

	$char_link = get_permalink($char_id);

	$char_name = setField(get_field($post_type . '_name', $char_id));
	$char_occupation = setField(get_field($post_type . '_occupation', $char_id));

	$char_class = setField(get_field($post_type . '_class', $char_id));
	$char_level = setField(get_field($post_type . '_level', $char_id));
	$char_race = setField(get_field($post_type . '_race', $char_id));

	$has_desc = ($char_class || $char_level || $char_occupation || $char_race);


	$char_image_id = get_field($post_type . '_image', $char_id);
	if($char_image_id) {
		$image = getImageAttachment($char_image_id, 'medium');
		$char_image = "<div class='" . $post_type . "__box__image'>$image</div>";
	}
	else {
		$imagepath = get_template_directory_uri() . "/images/defaults/default-npc-image.jpg";
		$char_image = "<div class='" . $post_type . "__box__image'><img src='$imagepath'></div>";
	}

	$card = "<a href='$char_link' class='" . $post_type . "__box'>
						<div class='" . $post_type . "__box__card'>";
	$card .= ($char_name) ? "<h2 class='entry-title " . $post_type . "__box__name'>$char_name</h2>" : "";
	$card .= ($char_image) ? $char_image : "";
	$card .= ($has_desc) ? "<div class='" . $post_type . "__box__desc'><p>" : "";
	$card .= ($char_level) ? "Level $char_level" : "";
	$card .= ($char_race) ? " $char_race<br>" : "";
	$card .= ($char_class) ? " $char_class" : "";
	$card .= ($has_desc) ? "</p>" : "";
	$card .= ($char_occupation) ? "<p>$char_occupation</p>" : "";
	$card .= ($has_desc) ? "</div>" : "";
	$card .= "</div></a>";

	return $card;
}

/**
 * Get image attribution
 * @param int image_id
 */

 function getImageAttribution($image_id) {
	$image_attribution_type = get_field('attribution_type', $image_id);
		
	if($image_attribution_type == 'Text') {
		$image_attribution = get_field("attribution_text", $image_id);
		$image_attribution = "<p class='attributions__attribution__text'>$image_attribution</p>";
	}
	else if($image_attribution_type == 'Link') {
		$image_attribution = get_field("attribution_link", $image_id);
		$url = $image_attribution['url'];
		$title = $image_attribution['title'];
		$target = $image_attribution['target'];
		$image_attribution = "<p class='attributions__attribution__link'><a href='$url' target='$target'>$title</a></p>";
	}

	return $image_attribution;
 }

 /**
	* stores attribution in global variable
	* 
	* returns image attachment
  */
 function getImageAttachment($image_id, $size) {
	$image = wp_get_attachment_image($image_id, $size);
	$image_attribution = getImageAttribution($image_id);
	$GLOBALS['attributions'][$image_id] = $image_attribution;
	return $image;
 }


/**
 * 
 */
wp_enqueue_script( 'accordions', get_template_directory_uri().'/js/accordions.js', '', '', true );
wp_enqueue_script( 'modals', get_template_directory_uri().'/js/modals.js', '', '', true );
wp_enqueue_script( 'header', get_template_directory_uri().'/js/header.js', '', '', true );
wp_enqueue_script( 'footer', get_template_directory_uri().'/js/footer.js', '', '', true );
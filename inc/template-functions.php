<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package dndest
 */

 @require_once(get_theme_file_path('/inc/options_page.php'));

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


function listNPCRelationships($relationshipArray) {
	if($relationshipArray) {
		$list = '<div class="npc__relationships__list">';
		foreach($relationshipArray as $npc_id) {

			$card = getNPCCard($npc_id);

			$list .= $card;
		}
		$list .= "</div>";
		return $list;
	}
	else {
		return "";
	}
}

function getNPCCard($npc_id) {
	$npc_link = get_permalink($npc_id);

	$npc_name = setField(get_field('npc_name', $npc_id));
	$npc_occupation = setField(get_field('npc_occupation', $npc_id));

	$npc_class = setField(get_field('npc_class', $npc_id));
	$npc_level = setField(get_field('npc_level', $npc_id));
	$npc_race = setField(get_field('npc_race', $npc_id));

	$has_desc = ($npc_class || $npc_level || $npc_occupation || $npc_race);


	$npc_image_id = get_field('npc_image', $npc_id);
	if($npc_image_id) {
		$image = getImageAttachment($npc_image_id, 'medium');
		$npc_image = "<div class='npc__box__image'>$image</div>";
	}

	$card = "<a href='$npc_link' class='npc__box'>
						<div class='npc__box__card'>";
	$card .= ($npc_name) ? "<h2 class='entry-title npc__box__name'>$npc_name</h2>" : "";
	$card .= ($npc_image_id) ? $npc_image : "";
	$card .= ($has_desc) ? "<div class='npc__box__desc'><p>" : "";
	$card .= ($npc_level) ? "Level $npc_level" : "";
	$card .= ($npc_race) ? " $npc_race<br>" : "";
	$card .= ($npc_class) ? " $npc_class" : "";
	$card .= ($has_desc) ? "</p>" : "";
	$card .= ($npc_occupation) ? "<p>$npc_occupation</p>" : "";
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
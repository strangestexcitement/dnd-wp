<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package dndwp
 */

@require_once(get_theme_file_path('/inc/options_page.php'));
@require_once(get_theme_file_path('/inc/wp-queries.php'));
@require_once(get_theme_file_path('/inc/custom-post-types.php'));

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function dndwp_body_classes( $classes ) {
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
add_filter( 'body_class', 'dndwp_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function dndwp_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'dndwp_pingback_header' );




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

function getDefaultCharImage() {
	$options = get_option( 'game_options' ); 
	$image_id = intval($options['game_field_default_character_image']);

	if($image_id) {
		$image = getImageAttachment($image_id, 'medium');
		$character_image = $image;
	}
	else {
		$imagepath = get_template_directory_uri() . "/images/defaults/default-character.jpg";
		$character_image = "<img src='$imagepath' alt='Default character image of person looking at lake and mountains' class='character__image--default'>";
	}

	return $character_image;
}

function getDefaultPlayerImage() {
	$options = get_option( 'game_options' ); 
	$image_id = intval($options['game_field_default_player_image']);

	if($image_id) {
		$image = getImageAttachment($image_id, 'medium');
		$player_image = $image;

	}
	else {
		$imagepath = get_template_directory_uri() . "/images/defaults/default-player.jpg";
		$player_image = "<img src='$imagepath' alt='Default player image of hand throwing dice in the air' class='player__image--default'>";
	}

	return $player_image;
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

function getCharCard($character_id) {
	$post_type = get_post_type($character_id);

	$character_link = get_permalink($character_id);

	$character_name = setField(get_field('character_name', $character_id));
	$character_name = $character_name ? $character_name : get_the_title($character_id);
	$character_occupation = setField(get_field('character_occupation', $character_id));

	$character_class = setField(get_field('character_class', $character_id));
	$character_level = setField(get_field('character_level', $character_id));
	$character_race = setField(get_field('character_race', $character_id));

	$has_desc = ($character_class || $character_level || $character_occupation || $character_race);


	$character_image_id = get_field('character_image', $character_id);
	if($character_image_id) {
		$image = getImageAttachment($character_image_id, 'medium');
		$character_image = "<div class='character__box__image'>$image</div>";
	}
	else {
		$character_image = "<div class='character__box__image'>" . getDefaultCharImage() . "</div>";
	}

	$card = "<a href='$character_link' class='character__box'>
						<div class='character__box__card'>";
	$card .= ($character_name) ? "<h2 class='entry-title character__box__name'>$character_name</h2>" : "";
	$card .= ($character_image) ? $character_image : "";
	$card .= ($has_desc) ? "<div class='character__box__desc'><p class='character__box__desc__lrc'>" : "";
	$card .= ($character_level) ? "Level $character_level" : "";
	$card .= ($character_race) ? " $character_race<br>" : "";
	$card .= ($character_class) ? " $character_class" : "";
	$card .= ($has_desc) ? "</p>" : "";
	$card .= ($character_occupation) ? "<p class='character__box__desc__occupation'>$character_occupation</p>" : "";
	$card .= ($has_desc) ? "</div>" : "";
	$card .= "</div></a>";

	return $card;
}

/**
 * Get image attribution
 * @param int image_id
 */

 function getImageAttribution($image_id) {
	$has_attribution = get_field('has_attribution', $image_id);

	if($has_attribution) {
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
	
	return null;
 }

 /**
	* stores attribution in global variable
	* 
	* returns image attachment
  */
 function getImageAttachment($image_id, $size) {
	$image = wp_get_attachment_image($image_id, $size);
	$image_attribution = getImageAttribution($image_id);
	if($image_attribution) {
		$GLOBALS['attributions'][$image_id] = $image_attribution;
	}
	return $image;
 }

 /**
	* Nav menu fallback
  */
	function nav_menu_fallback() {
		$site_url = get_site_url();
		$ids = [
			'player' 	=> [
				'plural_key'	=> 'Players',
				'group'				=> getIds('player'),
			],
			'npc' 	=> [
				'plural_key'	=> 'NPCs',
				'group'				=> getIds('npc'),
			],
			'pc' 	=> [
				'plural_key'	=> 'PCs',
				'group'				=> getIds('pc'),
			],
			'item' 	=> [
				'plural_key'	=> 'Items',
				'group'				=> getIds('item'),
			],
		];
		?>
		<div>
			<ul id="menu" class="menu">
				<?php
				foreach($ids as $key => $info) {
					if($ids[$key]['group'] && count($ids[$key]['group']) > 0) {
						?>
						<li class="menu-item menu-item-type-post_type_archive menu-item-object-<?= $key ?> menu-item-has-children">
							<a href="<?= $site_url . "/" . $key . "/"?>"><?= $info['plural_key'] ?></a>
								<ul class="sub-menu">
									<?php
										foreach($info['group'] as $el) {
											?>
												<li class="menu-item menu-item-type-post_type menu-item-object-<?= $key ?>">	
													<a href="<?= get_permalink($el)?>"><?= get_the_title($el)?></a>
												</li>
											<?php
										}
									?>
								</ul>
						</li>
						<?php
					}
				}
				?>
			</ul>
		</div>
		<?php
	}

	/**
	* Nav menu fallback
  */
	function footer_menu_fallback() {
		$site_url = get_site_url();
		$ids = [
			'player' 	=> [
				'plural_key'	=> 'Players',
				'group'				=> getIds('player'),
			],
			'npc' 	=> [
				'plural_key'	=> 'NPCs',
				'group'				=> getIds('npc'),
			],
			'pc' 	=> [
				'plural_key'	=> 'PCs',
				'group'				=> getIds('pc'),
			],
			'item' 	=> [
				'plural_key'	=> 'Items',
				'group'				=> getIds('item'),
			],
		];
		?>
		<div>
			<ul id="menu" class="menu">
				<?php
				foreach($ids as $key => $info) {
					if($ids[$key]['group'] && count($ids[$key]['group']) > 0) {
						?>
						<li class="menu-item menu-item-type-post_type_archive menu-item-object-<?= $key ?> menu-item-has-children">
							<a href="<?= $site_url . "/" . $key . "/"?>"><?= $info['plural_key'] ?></a>
						</li>
						<?php
					}
				}
				?>
			</ul>
		</div>
		<?php
	}

/**
 * 
 */
function enqueue_scripts() {
	wp_enqueue_script( 'accordions', get_template_directory_uri().'/js/accordions.js', '', '', true );
	wp_enqueue_script( 'modals', get_template_directory_uri().'/js/modals.js', '', '', true );
	wp_enqueue_script( 'header', get_template_directory_uri().'/js/header.js', '', '', true );
	wp_enqueue_script( 'footer', get_template_directory_uri().'/js/footer.js', array('jquery'), '', true );
}
add_action( 'wp_enqueue_scripts', 'enqueue_scripts' );

function admin_enqueue_scripts() {
	wp_enqueue_script( 'options-page', get_template_directory_uri().'/js/options-page.js', '', '', true );
}
add_action( 'admin_enqueue_scripts', 'admin_enqueue_scripts' );



add_action( 'admin_notices', 'theme_dependencies' );

function theme_dependencies() {
  if( ! function_exists('get_field') )
    echo '<div class="error"><p>' . __( 'Warning: Your current theme (dndwp) requires the <a href="' . get_site_url(null, 'wp-admin/plugin-install.php?tab=plugin-information&plugin=advanced-custom-fields&TB_iframe=true&width=600&height=550') . '">ACF plugin</a> to function', 'dndwp' ) . '</p></div>';
}

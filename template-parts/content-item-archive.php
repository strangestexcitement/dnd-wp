<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package dndwp
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php
			$link = get_permalink();

			// name and image
			$item_name = setField(get_field('item_name'));
			$item_name = $item_name ? $item_name : get_the_title();
			$item_image_id = setField(get_field('item_image'));

			// hero info
			$item_type = setField(get_field('item_type'));
			$item_type = $item_type ? implode(', ', $item_type) : "";
			$item_weapon_type = setField(get_field('item_weapon_type'));
			$item_armor_type = setField(get_field('item_armor_type'));
			$item_description = setField(get_field('item_description'));
			
			if($item_weapon_type) {
				$item_type = str_replace('Weapon', join(', ', $item_weapon_type), $item_type);
			}

			if($item_armor_type) {
				$item_type = str_replace('Armor', join(', ', $item_armor_type), $item_type);
			}

			if($item_image_id) {
				$image = getImageAttachment($item_image_id, "medium");
			}
			else {
				$image = getDefaultPlayerImage();
			}
			$item_image = "<div class='item__image'>$image</div>";
		?>

		<!-- Card -->
	<a href="<?= $link ?>">
		<div class="item__card">
			<div class="item__card__inner">
				<div class="item__card__flip--front">
					<div class="item__card__image">
						<?=  ($item_image) ? $item_image : "" ?>
					</div>
					<?= ($item_name) ? "<h2 class='item__card__name'>$item_name</h2>" : "" ?>
					<?= ($item_type) ? "<div class='item__card__type'><p class='item__field__value'>$item_type</p></div>" : "" ?>
				</div>
				<div class="item__card__flip--back">
					<?= ($item_name) ? "<h2 class='item__card__name--back'>$item_name</h2>" : "" ?>
					<?= ($item_description) ? "<div class='item__card__excerpt'>$item_description</div>" : ""; ?>
				</div>
			</div>
		</div>
	</a>
	<!-- End Card -->

</article><!-- #post-<?php the_ID(); ?> -->

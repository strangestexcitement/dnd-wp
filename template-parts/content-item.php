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
			// name and image
			$item_name = setField(get_field('item_name'));
			$item_name = $item_name ? $item_name : get_the_title();
			$item_image_id = setField(get_field('item_image'));

			// hero info
			$item_description = setField(get_field('item_description'));
			$item_rarity = setField(get_field('item_rarity'));
			$item_type = setField(get_field('item_type'));
			$item_type = $item_type ? implode(', ', $item_type) : "";
			
			$item_weapon_type = setField(get_field('item_weapon_type'));
			$item_armor_type = setField(get_field('item_armor_type'));
			
			if($item_weapon_type) {
				$item_type = str_replace('Weapon', join(', ', $item_weapon_type), $item_type);
			}

			if($item_armor_type) {
				$item_type = str_replace('Armor', join(', ', $item_armor_type), $item_type);
			}

			$item_type_label = (count(explode(', ', $item_type)) > 1) ? 'TYPES' : 'TYPE';

			// basics
			$item_value = setField(get_field('item_value'));
			$item_weight = setField(get_field('item_weight'));
			$item_damage = setField(get_field('item_damage'));
			$item_defense = setField(get_field('item_defense'));
			$item_magic_bonus = setField(get_field('item_magic_bonus'));
			$item_effects = setField(get_field('item_effects'));
			$item_attunement = setField(get_field('item_attunement'));
			$item_has_charges = get_field('item_has_charges');
			$item_charges = setField(get_field('item_charges'));
			$item_creator = setField(get_field('item_creator'));
			$item_origin = setField(get_field('item_origin'));

			// history
			$item_history = setField(get_field('item_history'));

			// $item_dnd_beyond_link;
			// $item_links;
			// $characters_who_have;

			if($item_image_id) {
				$image = getImageAttachment($item_image_id, "medium");
			}
			else {
				$image = getDefaultPlayerImage();
			}
			$item_image = "<div class='player__image'>$image</div>";
		?>

		
	<!-- Hero -->
	<div class="item__hero">
		<div class="item__hero__inner">
			<div class="item__hero__image">
				<?=  ($item_image) ? $item_image : "" ?>
			</div>
			<?php if($item_name || $item_rarity || $item_type) { ?>
				<div class="item__hero__content">
					<?= ($item_name) ? "<h1 class='entry-title item__hero__name'>$item_name</h1>" : "" ?>
					<div class="item__hero__details">
						<?= ($item_rarity) ? "<div class='item__field item__field__rarity'><h3 class='item__field__label'>RARITY:</h3><p class='item__field__value'>$item_rarity</p></div>" : "" ?>
						<?= ($item_type) ? "<div class='item__field item__field__type'><h3 class='item__field__label'>$item_type_label:</h3><p class='item__field__value'>$item_type</p></div>" : "" ?>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
	<!-- End Hero -->

	<!-- Description -->
	<?php if($item_description) { ?>
		<div class="item__description item__module">
			<div class="item__description__inner accordion">
				<h2 tabindex="0" class="item__description__heading accordion__heading">Description</h2>
				<div class="item__description__content accordion__content">
					<?= ($item_description) ? "<div class='item__field item__field__description'><div class='item__field__value'>$item_description</div></div>" : "" ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Description -->

	<!-- Basics -->
	<?php if($item_value || $item_weight || $item_damage || $item_defense || $item_magic_bonus ||
						$item_attunement || $item_creator || $item_origin) { ?>
		<div class="item__basics item__module">
			<div class="item__basics__inner accordion">
				<h2 tabindex="0" class="item__basics__heading accordion__heading">Basics</h2>
				<div class="item__basics__content accordion__content">
					<?= ($item_value) ? "<div class='item__field item__field__value'><h3 class='item__field__label'>VALUE:</h3><p class='item__field__value'>$item_value</p></div>" : "" ?>
					<?= ($item_weight) ? "<div class='item__field item__field__weight'><h3 class='item__field__label'>WEIGHT:</h3><p class='item__field__value'>$item_weight</p></div>" : "" ?>
					<?= ($item_damage) ? "<div class='item__field item__field__damage'><h3 class='item__field__label'>DAMAGE:</h3><p class='item__field__value'>$item_damage</p></div>" : "" ?>
					<?= ($item_defense) ? "<div class='item__field item__field__defense'><h3 class='item__field__label'>DEFENSE:</h3><p class='item__field__value'>$item_defense</p></div>" : "" ?>
					<?= ($item_magic_bonus) ? "<div class='item__field item__field__magic-bonus'><h3 class='item__field__label'>MAGIC BONUS:</h3><p class='item__field__value'>$item_magic_bonus</p></div>" : "" ?>
					<?= ($item_attunement) ? "<div class='item__field item__field__attunement'><h3 class='item__field__label'>ATTUNEMENT:</h3><p class='item__field__value'>$item_attunement</p></div>" : "" ?>
					<?= ($item_has_charges && $item_charges) ? "<div class='item__field item__field__charges'><h3 class='item__field__label'>CHARGES:</h3><p class='item__field__value'>$item_charges</p></div>" : "" ?>
					<?= ($item_origin) ? "<div class='item__field item__field__origin'><h3 class='item__field__label'>ORIGIN:</h3><p class='item__field__value'>$item_origin</p></div>" : "" ?>
					<?= ($item_creator) ? "<div class='item__field item__field__creator'><h3 class='item__field__label'>CREATOR:</h3><p class='item__field__value'>$item_creator</p></div>" : "" ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Basics -->

	<!-- History -->
	<?php if($item_history) { ?>
		<div class="item__history item__module">
			<div class="item__history__inner accordion">
				<h2 tabindex="0" class="item__history__heading accordion__heading">History</h2>
				<div class="item__history__content accordion__content">
					<?= ($item_history) ? "<div class='item__field item__field__history'><div class='item__field__value'>$item_history</div></div>" : "" ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End History -->

</article><!-- #post-<?php the_ID(); ?> -->

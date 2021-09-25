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
			$item_name = setField(get_field('item_name'));
			$item_name = $item_name ? $item_name : get_the_title();
			$item_image_id = setField(get_field('item_image'));

			$item_rarity = setField(get_field('item_rarity'));
			$item_type = setField(get_field('item_type'));
			$item_type_label = (count($item_type) > 1) ? 'TYPES' : 'TYPE';
			$item_type = $item_type ? implode(', ', $item_type) : "";
			$item_value = setField(get_field('item_value'));
			$item_weight = setField(get_field('item_weight'));

			$item_damage = setField(get_field('item_damage'));
			$item_defense = setField(get_field('item_defense'));
			$item_magic_bonus = setField(get_field('item_magic_bonus'));
			$item_effects = setField(get_field('item_effects'));
			$item_attunement = setField(get_field('item_attunement'));
			$item_has_charges = setField(get_field('item_has_charges'));
			$item_charges = setField(get_field('item_charges'));

			$item_weapon_type = setField(get_field('item_weapon_type'));
			$item_armor_type = setField(get_field('item_armor_type'));

			$item_creator = setField(get_field('item_creator'));
			$item_origin = setField(get_field('item_origin'));
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
						<?= ($item_rarity) ? "<div class='item__field item__field__level'><h3 class='item__field__label'>RARITY:</h3><p class='item__field__value'>$item_rarity</p></div>" : "" ?>
						<?= ($item_type) ? "<div class='item__field item__field__race'><h3 class='item__field__label'>$item_type_label:</h3><p class='item__field__value'>$item_type</p></div>" : "" ?>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
	<!-- End Hero -->

	<!-- Description -->
	<?php if($player_description) { ?>
		<div class="player__description player__module">
			<div class="player__description__inner accordion">
				<h2 tabindex="0" class="player__description__heading accordion__heading">About</h2>
				<div class="player__description__content accordion__content">
					<?= ($player_description) ? "<div class='player__field player__field__description'><div class='player__field__value'>$player_description</div></div>" : "" ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Description -->

	<!-- Characters -->
	<?php if($player_characters) { ?>
		<div class="player__characters player__module">
			<div class="player__characters__inner accordion">
				<h2 tabindex="0" class="player__characters__heading accordion__heading"><?= $character_label ?></h2>
				<div class="player__characters__content accordion__content">
					<?= ($player_characters) ? "<div class='player__field player__field__characters'><div class='player__field__value'>$characters</div></div>" : "" ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Characters -->

		<!-- Social Links -->
		<?php if($player_social_links['dndbeyond'] || $player_social_links['roll20'] || $player_social_links['facebook'] || 
							$player_social_links['twitter'] || $player_social_links['instagram'] || $player_social_links['tiktok']) { ?>
		<div class="player__social player__module">
			<div class="player__social__inner accordion">
				<h2 tabindex="0" class="player__social__heading accordion__heading">Social Links</h2>
				<div class="player__social__content accordion__content">
						<?php
							foreach($player_social_links as $site => $link) {
								if($link) {	
									$icon = $social_icons[$site];
									echo "<a href='$link' target='_blank'><span class='$icon'></span></a>";
								}
							}
						?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Social Links -->
</article><!-- #post-<?php the_ID(); ?> -->

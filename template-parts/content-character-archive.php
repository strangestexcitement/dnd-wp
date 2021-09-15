<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package dndwp
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('character__box'); ?>>
		<?php 

			$character_link = get_permalink($post->ID);

			$character_name = setField(get_field('character_name'));
			$character_name = $character_name ? $character_name : get_the_title();
			$character_occupation = setField(get_field('character_occupation'));

			$character_class = setField(get_field('character_class'));
			$character_level = setField(get_field('character_level'));
			$character_race = setField(get_field('character_race'));

			$has_desc = ($character_class || $character_level || $character_occupation || $character_race);

			$character_image_id = get_field('character_image');

			$default_image = getDefaultCharImage();

			if($character_image_id) {
				$image = getImageAttachment($character_image_id, "medium");
			}
			else {
				$image = $default_image;
			}
			$character_image = "<div class='character__box__image'>$image</div>";
		?>

	<a href="<?= $character_link ?>">
		<div class="character__box__card">
			
			<?= ($character_name) ? "<h2 class='entry-title character__box__name'>$character_name</h2>" : "" ?>

			<?= ($character_image) ? $character_image : "" ?>

			<?= ($has_desc) ? "<div class='character__box__desc'><p class='character__box__desc__lrc'>" : "" ?>
				<?= ($character_level) ? "Level $character_level" : "" ?>
				<?= ($character_race) ? " $character_race<br>" : "" ?>
				<?= ($character_class) ? " $character_class" : "" ?>
			<?= ($has_desc) ? "</p>" : "" ?>
				<?= ($character_occupation) ? "<p class='character__box__desc__occupation'>$character_occupation</p>" : "" ?>
			<?= ($has_desc) ? "</div>" : "" ?>

		</div>
	</a>

</article><!-- #post-<?php the_ID(); ?> -->

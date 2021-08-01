<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package dndest
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('npc__box'); ?>>
		<?php 

			$npc_link = get_permalink($post->ID);

			$npc_name = setField(get_field('npc_name'));
			$npc_occupation = setField(get_field('npc_occupation'));

			$npc_class = setField(get_field('npc_class'));
			$npc_level = setField(get_field('npc_level'));
			$npc_race = setField(get_field('npc_race'));

			$has_desc = ($npc_class || $npc_level || $npc_occupation || $npc_race);


			$npc_image_id = get_field('npc_image');
			if($npc_image_id) {
				$image = wp_get_attachment_image($npc_image_id, 'medium');
				$npc_image = "<div class='npc__box__image'>$image</div>";
			}
		?>

	<a href="<?= $npc_link ?>">
		<div class="npc__box__card">
			
			<?= ($npc_name) ? "<h2 class='entry-title npc__box__name'>$npc_name</h2>" : "" ?>

			<?= ($npc_image_id) ? $npc_image : "" ?>

			<?= ($has_desc) ? "<div class='npc__box__desc'><p>" : "" ?>
				<?= ($npc_level) ? "Level $npc_level" : "" ?>
				<?= ($npc_race) ? " $npc_race<br>" : "" ?>
				<?= ($npc_class) ? " $npc_class" : "" ?>
			<?= ($has_desc) ? "</p>" : "" ?>
				<?= ($npc_occupation) ? "<p>$npc_occupation</p>" : "" ?>
			<?= ($has_desc) ? "</div>" : "" ?>



		</div>
	</a>

</article><!-- #post-<?php the_ID(); ?> -->

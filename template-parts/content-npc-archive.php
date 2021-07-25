<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package dndest
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php 

			$npc_name = setField(get_field('npc_name'));
			$npc_occupation = setField(get_field('npc_occupation'));

			$npc_class = setField(get_field('npc_class'));
			$npc_level = setField(get_field('npc_level'));
			$npc_race = setField(get_field('npc_race'));
			$npc_alignment = setField(get_field('npc_alignment'));

			$npc_image_id = get_field('npc_image');
			if($npc_image_id) {
				$image = wp_get_attachment_image($npc_image_id, 'medium');
				$npc_image = "<div class='npc__image'>$image</div>";
			}
		?>

	</header><!-- .entry-header -->

	<?php dndest_post_thumbnail(); ?>

	<div class="npc__card">
		
		<?= ($npc_name) ? "<p class='entry-title npc__name'>$npc_name</p>" : "" ?>

		<?= ($npc_image_id) ? $npc_image : "" ?>


	</div>

	<div class="entry-content npc__content">
</article><!-- #post-<?php the_ID(); ?> -->

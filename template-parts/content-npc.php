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
			$npc_name = get_field('npc_name');
			$npc_description = get_field('npc_description');
			$npc_stats = get_field('stats');
			$npc_birthday = get_field('npc_birthday');
			$npc_age = get_field('npc_age');
			$npc_occupation = get_field('npc_occupation');

			$npc_class = get_field('npc_class');
			$npc_level = get_field('npc_level');
			$npc_race = get_field('npc_race');
			$npc_background = get_field('npc_background');
			// $npc_alignment = get_field('npc_alignment');
			// $npc_personality_traits = get_field('npc_personality_traits');
			// $npc_ideals = get_field('npc_ideals');
			// $npc_bonds = get_field('npc_bonds');
			// $npc_flaws = get_field('npc_flaws');
			// $npc_allies = get_field('npc_allies');
			// $npc_enemies = get_field('npc_enemies');

			$npc_image_id = get_field('npc_image');
			if($npc_image_id) {
				$image = wp_get_attachment_image($npc_image_id, 'medium');
				$npc_image = "<div class='npc__image'>$image</div>";
			}
		?>

	</header><!-- .entry-header -->

	<?php dndest_post_thumbnail(); ?>

	<div class="npc__about">
		
		<?= ($npc_name) ? "<p class='entry-title npc__name'>$npc_name</p>" : "" ?>
		<?= ($npc_image_id) ? $npc_image : "" ?>
		<div class="npc__about__copy">
			<?= ($npc_class) ? "<div class='npc__field'><p class='npc__field__label'>CLASS:</p><p class='npc__class npc__field__value'>$npc_class</p></div>" : "" ?>
			<?= ($npc_level) ? "<div class='npc__field'><p class='npc__field__label'>LEVEL:</p><p class='npc__level npc__field__value'>$npc_level</p></div>" : "" ?>
			<?= ($npc_race) ? "<div class='npc__field'><p class='npc__field__label'>RACE:</p><p class='npc__race npc__field__value'>$npc_race</p></div>" : "" ?>
			<?= ($npc_background) ? "<div class='npc__field'><p class='npc__field__label'>BACKGROUND:</p><p class='npc__background npc__field__value'>$npc_background</p></div>" : "" ?>
			<?= ($npc_age) ? "<div class='npc__field'><p class='npc__field__label'>AGE:</p><p class='npc__age npc__field__value'>$npc_age</p></div>" : "" ?>
			<?= ($npc_birthday) ? "<div class='npc__field'><p class='npc__field__label'>OCCUPATION:</p><p class='npc__birthday npc__field__value'>$npc_birthday</p></div>" : "" ?>
			<?= ($npc_occupation) ? "<div class='npc__field'><p class='npc__field__label'>OCCUPATION:</p><p class='npc__occupation npc__field__value'>$npc_occupation</p></div>" : "" ?>
			<?= ($npc_description) ? "<div class='npc__field'><p class='npc__field__label'>DESCRIPTION:</p><p class='npc__description npc__field__value'>$npc_description</p></div>" : "" ?>
		</div>

	</div>

	<div class="entry-content npc__content">

		

		<div class="npc__stats">
			<?php
				foreach($npc_stats as $stat => $info) {
					?>		
					<div class="npc__stats npc__stats--<?php echo $stat ?>">
						<h2 class="npc__stats__title npc__stats__title--<?php echo $stat ?>"><?php echo $stat ?></h2>
						<p class="npc__stats__value npc__stats__value--<?php echo $stat ?>"><?php echo $info['value'] ?></p>
					</div>
					<?php
				}
			?>
		</div>
		<?php
		// the_content();

		// wp_link_pages(
		// 	array(
		// 		'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'dndest' ),
		// 		'after'  => '</div>',
		// 	)
		// );
		?>
	</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
			// edit_post_link(
			// 	sprintf(
			// 		wp_kses(
			// 			/* translators: %s: Name of current post. Only visible to screen readers */
			// 			__( 'Edit <span class="screen-reader-text">%s</span>', 'dndest' ),
			// 			array(
			// 				'span' => array(
			// 					'class' => array(),
			// 				),
			// 			)
			// 		),
			// 		wp_kses_post( get_the_title() )
			// 	),
			// 	'<span class="edit-link">',
			// 	'</span>'
			// );
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->

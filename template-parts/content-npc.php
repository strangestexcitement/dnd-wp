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
			$npc_aliases = setField(get_field('npc_aliases'));		
			$npc_description = setField(get_field('npc_description'));
			$npc_stats = get_field('stats');
			$npc_birthday = setField(get_field('npc_birthday'));
			$npc_age = setField(get_field('npc_age'));
			$npc_occupation = setField(get_field('npc_occupation'));
			$npc_gender_pronouns = setField(get_field('npc_gender_pronouns'));

			$npc_class = setField(get_field('npc_class'));
			$npc_level = setField(get_field('npc_level'));
			$npc_race = setField(get_field('npc_race'));
			$npc_background = setField(get_field('npc_background'));
			$npc_alignment = setField(get_field('npc_alignment'));
			$npc_goals = setField(get_field('npc_goals'));

			// $npc_personality_traits = setField(get_field('npc_personality_traits'));
			// $npc_ideals = setField(get_field('npc_ideals'));
			// $npc_bonds = setField(get_field('npc_bonds'));
			// $npc_flaws = setField(get_field('npc_flaws'));
			// $npc_allies = setField(get_field('npc_allies'));
			// $npc_enemies = setField(get_field('npc_enemies'));
			// $npc_backstory = setField(get_field('npc_backstory'));
			$npc_hp = setField(get_field('npc_hp'));
			$npc_ac = setField(get_field('npc_ac'));
			$npc_speed = setField(get_field('npc_speed'));
			$npc_inventory = setField(get_field('npc_inventory'));
			// $npc_spells = setField(get_field('npc_spells'));
			// $npc_height = setField(get_field('npc_height'));
			// $npc_weight = setField(get_field('npc_weight'));
			// $npc_body_type = setField(get_field('npc_body_type'));
			// $npc_eyes = setField(get_field('npc_eyes'));
			// $npc_skin = setField(get_field('npc_skin'));
			// $npc_hair = setField(get_field('npc_hair'));
			// $npc_additional_notes = setField(get_field('npc_additional_notes'));

			$npc_image_id = get_field('npc_image');
			if($npc_image_id) {
				$image = wp_get_attachment_image($npc_image_id, 'medium');
				$npc_image = "<div class='npc__image'>$image</div>";
			}

			// $npc_symbol_id = get_field('npc_symbol');
			// if($npc_symbol_id) {
			// 	$symbol_image = wp_get_attachment_image($npc_symbol_id, 'medium');
			// 	$npc_symbol_image = "<div class='npc__symbol-image'>$symbol_image</div>";
			// }
		?>

	</header><!-- .entry-header -->

	<?php dndest_post_thumbnail(); ?>

	<div class="npc__about">
		
		<?= ($npc_name) ? "<h1 class='entry-title npc__name'>$npc_name</h1>" : "" ?>

		<?= ($npc_image_id) ? $npc_image : "" ?>
		<div class="npc__about__copy">
			<?= ($npc_aliases) ? "<div class='npc__field npc__field__aliases'><p class='npc__field__label'>ALIASES:</p><p class='npc__field__value'>$npc_aliases</p></div>" : "" ?>

			<?= ($npc_race) ? "<div class='npc__field npc__field__race'><p class='npc__field__label'>RACE:</p><p class='npc__field__value'>$npc_race</p></div>" : "" ?>

			<?= ($npc_class) ? "<div class='npc__field npc__field__class'><p class='npc__field__label'>CLASS:</p><p class='npc__field__value'>$npc_class</p></div>" : "" ?>
			<?= ($npc_level) ? "<div class='npc__field npc__field__level'><p class='npc__field__label'>LEVEL:</p><p class='npc__field__value'>$npc_level</p></div>" : "" ?>
			<?= ($npc_gender_pronouns) ? "<div class='npc__field npc__field__gender'><p class='npc__field__label'>GENDER/PRONOUNS:</p><p class='npc__field__value'>$npc_gender_pronouns</p></div>" : "" ?>
			<?= ($npc_age) ? "<div class='npc__field npc__field__age'><p class='npc__field__label'>AGE:</p><p class='npc__field__value'>$npc_age</p></div>" : "" ?>
			<?= ($npc_birthday) ? "<div class='npc__field npc__field__birthday'><p class='npc__field__label'>BIRTHDAY:</p><p class='npc__field__value'>$npc_birthday</p></div>" : "" ?>

			<?= ($npc_background) ? "<div class='npc__field npc__field__background'><p class='npc__field__label'>BACKGROUND:</p><p class='npc__field__value'>$npc_background</p></div>" : "" ?>
			<?= ($npc_alignment) ? "<div class='npc__field npc__field__alignment'><p class='npc__field__label'>ALIGNMENT:</p><p class='npc__field__value'>$npc_alignment</p></div>" : "" ?>
			<?= ($npc_occupation) ? "<div class='npc__field npc__field__occupation'><p class='npc__field__label'>OCCUPATION:</p><p class='npc__field__value'>$npc_occupation</p></div>" : "" ?>
			<?= ($npc_goals) ? "<div class='npc__field npc__field__goals'><p class='npc__field__label'>GOALS:</p><p class='npc__field__value'>$npc_goals</p></div>" : "" ?>
			<?= ($npc_description) ? "<div class='npc__field npc__field__description'><p class='npc__field__label'>DESCRIPTION:</p><p class='npc__field__value'>$npc_description</p></div>" : "" ?>

		</div>

	</div>

	<div class="npc__capabilities">
		<h2 class="npc__section-heading">Capabilities:</h2>
		
		<div class="npc__capabilities__content">
			<?= ($npc_hp) ? "<div class='npc__field npc__field__hp'><p class='npc__field__label'>HP:</p><p class='npc__field__value'>$npc_hp</p></div>" : "" ?>
			<?= ($npc_ac) ? "<div class='npc__field npc__field__ac'><p class='npc__field__label'>AC:</p><p class='npc__field__value'>$npc_ac</p></div>" : "" ?>
			<?= ($npc_speed) ? "<div class='npc__field npc__field__speed'><p class='npc__field__label'>SPEED:</p><p class='npc__field__value'>$npc_speed</p></div>" : "" ?>
		</div>
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
	</div>

	<div class="npc__inventory">
		<h2 class="npc__section-heading">Inventory:</h2>
		<?= ($npc_inventory) ? "<div class='npc__field npc__field__inventory'><p class='npc__field__value'>$npc_inventory</p></div>" : "" ?>
	</div>

	<div class="entry-content npc__content">


		

		
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

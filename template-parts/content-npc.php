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
		<?php 

			// general basics
			$npc_name = setField(get_field('npc_name'));
			$npc_aliases = setField(get_field('npc_aliases'));		
			$npc_description = setField(get_field('npc_description'));
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

			// inventory
			$npc_inventory = setField(get_field('npc_inventory'));

			// spells
			$npc_spells = setField(get_field('npc_spells'));

			// capabilities
			$npc_hp = setField(get_field('npc_hp'));
			$npc_ac = setField(get_field('npc_ac'));
			$npc_speed = setField(get_field('npc_speed'));
			$npc_stats = get_field('stats');
			$npc_proficiency_bonus = intval(get_field('npc_proficiency_bonus'));
			$npc_skills = get_field('npc_skills');

			// details
			$npc_height = setField(get_field('npc_height'));
			$npc_weight = setField(get_field('npc_weight'));
			$npc_body_type = setField(get_field('npc_body_type'));
			$npc_eyes = setField(get_field('npc_eyes'));
			$npc_skin = setField(get_field('npc_skin'));
			$npc_hair = setField(get_field('npc_hair'));

			// personality
			$npc_personality_traits = setField(get_field('npc_personality_traits'));
			$npc_ideals = setField(get_field('npc_ideals'));
			$npc_bonds = setField(get_field('npc_bonds'));
			$npc_flaws = setField(get_field('npc_flaws'));

			// relationshipos
			$npc_allies = setField(get_field('npc_allies'));
			$npc_enemies = setField(get_field('npc_enemies'));

			// backstory
			$npc_backstory = setField(get_field('npc_backstory'));

			// extra notes
			$npc_additional_notes = setField(get_field('npc_additional_notes'));
			$npc_links = setField(get_field('npc_links'));

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
			<?= ($npc_goals) ? "<div class='npc__field npc__field__goals'><p class='npc__field__label'>GOALS:</p><div class='npc__field__value'>$npc_goals</div></div>" : "" ?>
			<?= ($npc_description) ? "<div class='npc__field npc__field__description'><p class='npc__field__label'>DESCRIPTION:</p><div class='npc__field__value'>$npc_description</div></div>" : "" ?>

		</div>

	</div>
	<div class="npc__overview">

		<section class="npc__capabilities npc__accordion">
			<h2 class="npc__section-heading npc__accordion__heading">Capabilities</h2>
			<div class="npc__accordion__content">
			
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
				<div class="npc__skills">

					<!-- NEED TO ADD SKILL PROFICIENCIES -->

				</div>
			</div>
		</section>

		<?= ($npc_inventory) ? 
			"<section class='npc__inventory npc__accordion'>
				<h2 class='npc__section-heading npc__accordion__heading'>Inventory</h2>
				<div class='npc__field npc__field__inventory npc__accordion__content'><p class='npc__field__value'>$npc_inventory</p></div>
			</section>"
			: "";
		?>

		<?= ($npc_spells) ? 
			"<section class='npc__spells npc__accordion'>
				<h2 class='npc__section-heading npc__accordion__heading'>Magical Abilities</h2>
				<div class='npc__field npc__field__spells npc__accordion__content'><p class='npc__field__value'>$npc_spells</p></div>
			</section>" 
			: "";
		?>

		<section class="npc__details npc__accordion">
			<h2 class="npc__section-heading npc__accordion__heading">Details</h2>
			<div class="npc__details__container npc__accordion__content">
				<?= ($npc_height) ? "<div class='npc__field npc__field__height'><p class='npc__field__label'>HEIGHT:</p><p class='npc__field__value'>$npc_height</p></div>" : "" ?>
				<?= ($npc_weight) ? "<div class='npc__field npc__field__weight'><p class='npc__field__label'>WEIGHT:</p><p class='npc__field__value'>$npc_weight</p></div>" : "" ?>
				<?= ($npc_body_type) ? "<div class='npc__field npc__field__body_type'><p class='npc__field__label'>BODY TYPE:</p><p class='npc__field__value'>$npc_body_type</p></div>" : "" ?>
				<?= ($npc_eyes) ? "<div class='npc__field npc__field__eyes'><p class='npc__field__label'>EYES:</p><p class='npc__field__value'>$npc_eyes</p></div>" : "" ?>
				<?= ($npc_skin) ? "<div class='npc__field npc__field__skin'><p class='npc__field__label'>SKIN:</p><p class='npc__field__value'>$npc_skin</p></div>" : "" ?>
				<?= ($npc_hair) ? "<div class='npc__field npc__field__hair'><p class='npc__field__label'>HAIR:</p><p class='npc__field__value'>$npc_hair</p></div>" : "" ?>
			</div>
		</section>

		<section class="npc__personality npc__accordion">
			<h2 class="npc__section-heading npc__accordion__heading">Personality</h2>
			<div class="npc__personality__container npc__accordion__content">
				<?= ($npc_personality_traits) ? "<div class='npc__field npc__field__personality-traits'><p class='npc__field__label'>PERSONALITY TRAITS:</p><p class='npc__field__value'>$npc_personality_traits</p></div>" : "" ?>
				<?= ($npc_ideals) ? "<div class='npc__field npc__field__ideals'><p class='npc__field__label'>IDEALS:</p><p class='npc__field__value'>$npc_ideals</p></div>" : "" ?>
				<?= ($npc_bonds) ? "<div class='npc__field npc__field__bonds'><p class='npc__field__label'>BONDS:</p><p class='npc__field__value'>$npc_bonds</p></div>" : "" ?>
				<?= ($npc_flaws) ? "<div class='npc__field npc__field__flaws'><p class='npc__field__label'>FLAWS:</p><p class='npc__field__value'>$npc_flaws</p></div>" : "" ?>
			</div>
		</section>

		<section class="npc__relationships npc__accordion">
			<h2 class="npc__section-heading npc__accordion__heading">Relationships</h2>
			<div class="npc__relationships__container npc__accordion__content">
				<?= ($npc_allies) ? "<div class='npc__field npc__field__allies'><p class='npc__field__label'>ALLIES:</p><p class='npc__field__value'>$npc_allies</p></div>" : "" ?>
				<?= ($npc_enemies) ? "<div class='npc__field npc__field__enemies'><p class='npc__field__label'>ENEMIES:</p><p class='npc__field__value'>$npc_enemies</p></div>" : "" ?>
			</div>
		</section>

		<?= ($npc_backstory) ? 
			"<section class='npc__backstory npc__accordion'>
				<h2 class='npc__section-heading npc__accordion__heading'>Backstory</h2>
				<div class='npc__field npc__field__backstory npc__accordion__content'><p class='npc__field__value'>$npc_backstory</p></div>
			</section>" 
			: "";
		?>

		<section class='npc__additional-notes npc__accordion'>
			<h2 class='npc__section-heading npc__accordion__heading'>Additional Notes</h2>
			<div class="npc__additional-notes__container npc__accordion__content">
				<?= ($npc_additional_notes) ? "<div class='npc__field npc__field__additional-notes'><p class='npc__field__value'>$npc_additional_notes</p></div>" : "" ?>
				<?= ($npc_links) ? "<div class='npc__field npc__field__links'><p class='npc__field__label'>LINKS:</p><p class='npc__field__value'>$npc_links</p></div>" : "" ?>
			</div>
		</section>
	</div>
	<!-- <div class="entry-content npc__content">
	</div> -->
</article><!-- #post-<?php the_ID(); ?> -->

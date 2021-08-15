<?php
/**
 * Template part for displaying page content in page.php
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
			$npc_level_text = $npc_level ? "Level $npc_level" : "";
			$npc_race = setField(get_field('npc_race'));
			$npc_background = setField(get_field('npc_background'));
			$npc_alignment = setField(get_field('npc_alignment'));
			$npc_goals = setField(get_field('npc_goals'));

			// inventory
			$npc_inventory = setField(get_field('npc_inventory'));
			$npc_copper_pieces = setField(get_field('npc_copper_pieces'));
			$npc_silver_pieces = setField(get_field('npc_silver_pieces'));
			$npc_electrum_pieces = setField(get_field('npc_electrum_pieces'));
			$npc_gold_pieces = setField(get_field('npc_gold_pieces'));
			$npc_platinum_pieces = setField(get_field('npc_platinum_pieces'));

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

			// relationships
			$npc_enemies_other = setField(get_field('npc_enemies_other'));
			$npc_enemies_links = setField(get_field('npc_enemies_links'));
			$npc_allies_links = setField(get_field('npc_allies_links'));
			$npc_allies_other = setField(get_field('npc_allies_other'));
			$allies_links = listNPCRelationships($npc_allies_links);
			$enemies_links = listNPCRelationships($npc_enemies_links);

			// backstory
			$npc_backstory = setField(get_field('npc_backstory'));

			// extra notes
			$npc_additional_notes = setField(get_field('npc_additional_notes'));
			$npc_links = setField(get_field('npc_links'));

			$npc_image_id = get_field('npc_image');
			$default_image = get_template_directory_uri() . "/images/defaults/default-npc-image.jpg";

			if($npc_image_id) {
				$image = getImageAttachment($npc_image_id, "medium");
			}
			else {
				$image = "<img src='$default_image' class='npc__image--default'>";
			}
			$npc_image = "<div class='npc__image'>$image</div>";

			$npc_symbol_id = setField(get_field('npc_symbol'));
			if($npc_symbol_id) {
				$symbol_image = getImageAttachment($npc_symbol_id, 'medium');
				$npc_symbol_image = "<div class='npc__symbol-image'>$symbol_image</div>";
			}
		?>

	<!-- Hero -->
	<div class="npc__hero">
		<div class="npc__hero__inner">
			<div class="npc__hero__image">
				<?= ($npc_image) ? $npc_image : "" ?>
			</div>
			<?php if($npc_name || $npc_level || $npc_race || $npc_class || $npc_occupation) { ?>
				<div class="npc__hero__content">
					<?= ($npc_name) ? "<h1 class='entry-title npc__hero__name'>$npc_name</h1>" : "" ?>
					<?php if($npc_level || $npc_race || $npc_class || $npc_occupation) { ?>
						<div class="npc__hero__details">
							<?= ($npc_level) ? "<div class='npc__field npc__field__level'><p class='npc__field__label'>LEVEL:</p><p class='npc__field__value'>$npc_level</p></div>" : "" ?>
							<?= ($npc_race) ? "<div class='npc__field npc__field__race'><p class='npc__field__label'>RACE:</p><p class='npc__field__value'>$npc_race</p></div>" : "" ?>
							<?= ($npc_class) ? "<div class='npc__field npc__field__class'><p class='npc__field__label'>CLASS:</p><p class='npc__field__value'>$npc_class</p></div>" : "" ?>
							<?= ($npc_occupation) ? "<div class='npc__field npc__field__occupation'><p class='npc__field__label'>OCCUPATION:</p><p class='npc__field__value'>$npc_occupation</p></div>" : "" ?>
						</div>
					<?php } ?>
				</div>
			<?php } ?>
		</div>
	</div>
	<!-- End Hero -->

	<!-- Basics -->
	<?php if($npc_background || $npc_aliases || $npc_gender_pronouns || $npc_alignment || $npc_age ||
						$npc_birthday || $npc_height || $npc_weight || $npc_body_type || $npc_eyes || $npc_skin || $npc_hair) { ?>
		<div class="npc__basics npc__module">
			<div class="npc__basics__inner npc__accordion">
				<h2 class="npc__basics__heading npc__accordion__heading">BASICS</h2>
				<div class="npc__basics__content npc__accordion__content">
					<?= ($npc_background) ? "<div class='npc__field npc__field__background'><p class='npc__field__label'>BACKGROUND:</p><p class='npc__field__value'>$npc_background</p></div>" : "" ?>
					<?= ($npc_aliases) ? "<div class='npc__field npc__field__aliases'><p class='npc__field__label'>ALIASES:</p><p class='npc__field__value'>$npc_aliases</p></div>" : "" ?>
					<?= ($npc_gender_pronouns) ? "<div class='npc__field npc__field__gender'><p class='npc__field__label'>GENDER/PRONOUNS:</p><p class='npc__field__value'>$npc_gender_pronouns</p></div>" : "" ?>
					<?= ($npc_alignment) ? "<div class='npc__field npc__field__alignment'><p class='npc__field__label'>ALIGNMENT:</p><p class='npc__field__value'>$npc_alignment</p></div>" : "" ?>
					<?= ($npc_age) ? "<div class='npc__field npc__field__age'><p class='npc__field__label'>AGE:</p><p class='npc__field__value'>$npc_age</p></div>" : "" ?>
					<?= ($npc_birthday) ? "<div class='npc__field npc__field__birthday'><p class='npc__field__label'>BIRTHDAY:</p><p class='npc__field__value'>$npc_birthday</p></div>" : "" ?>
					<?= ($npc_height) ? "<div class='npc__field npc__field__height'><p class='npc__field__label'>HEIGHT:</p><p class='npc__field__value'>$npc_height</p></div>" : "" ?>
					<?= ($npc_weight) ? "<div class='npc__field npc__field__weight'><p class='npc__field__label'>WEIGHT:</p><p class='npc__field__value'>$npc_weight</p></div>" : "" ?>
					<?= ($npc_body_type) ? "<div class='npc__field npc__field__body_type'><p class='npc__field__label'>BODY TYPE:</p><p class='npc__field__value'>$npc_body_type</p></div>" : "" ?>
					<?= ($npc_eyes) ? "<div class='npc__field npc__field__eyes'><p class='npc__field__label'>EYES:</p><p class='npc__field__value'>$npc_eyes</p></div>" : "" ?>
					<?= ($npc_skin) ? "<div class='npc__field npc__field__skin'><p class='npc__field__label'>SKIN:</p><p class='npc__field__value'>$npc_skin</p></div>" : "" ?>
					<?= ($npc_hair) ? "<div class='npc__field npc__field__hair'><p class='npc__field__label'>HAIR:</p><p class='npc__field__value'>$npc_hair</p></div>" : "" ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Basics -->


	<!-- Goals -->
	<?php if($npc_goals) { ?>
		<div class="npc__goals npc__module">
			<div class="npc__goals__inner npc__accordion">
				<h2 class="npc__goals__heading npc__accordion__heading">GOALS</h2>
				<div class="npc__goals__content npc__accordion__content">
					<?= ($npc_goals) ? "<div class='npc__field npc__field__goals'><div class='npc__field__value'>$npc_goals</div></div>" : "" ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Goals -->

	<!-- Description -->
	<?php if($npc_description) { ?>
		<div class="npc__desc npc__module">
			<div class="npc__desc__inner npc__accordion">
				<h2 class="npc__desc__heading npc__accordion__heading">DESCRIPTION</h2>
				<div class="npc__desc__content npc__accordion__content">
					<?= ($npc_description) ? "<div class='npc__field npc__field__desc'><div class='npc__field__value'>$npc_description</div></div>" : "" ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Description -->

	<!-- Personality -->
	<?php if($npc_personality_traits || $npc_ideals || $npc_bonds || $npc_flaws) { ?>
		<div class="npc__personality npc__module">
			<div class="npc__personality__inner npc__accordion">
				<h2 class="npc__personality__heading npc__accordion__heading">PERSONALITY</h2>
				<div class="npc__personality__content npc__accordion__content">
					<?= ($npc_personality_traits) ? "<div class='npc__personality__card'><div class='npc__field npc__field__personality-traits'><p class='npc__field__label'>PERSONALITY TRAITS:</p><div class='npc__field__value'>$npc_personality_traits</div></div></div>" : "" ?>
					<?= ($npc_ideals) ? "<div class='npc__personality__card'><div class='npc__field npc__field__ideals'><p class='npc__field__label'>IDEALS:</p><div class='npc__field__value'>$npc_ideals</div></div></div>" : "" ?>
					<?= ($npc_bonds) ? "<div class='npc__personality__card'><div class='npc__field npc__field__bonds'><p class='npc__field__label'>BONDS:</p><div class='npc__field__value'>$npc_bonds</div></div></div>" : "" ?>
					<?= ($npc_flaws) ? "<div class='npc__personality__card'><div class='npc__field npc__field__flaws'><p class='npc__field__label'>FLAWS:</p><div class='npc__field__value'>$npc_flaws</div></div></div>" : "" ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Personality -->









	<?php if($npc_allies_links || $npc_allies_other || $npc_enemies_links || $npc_enemies_other) { ?>
		<!-- Relationships -->
		<section class="npc__relationships npc__accordion">
			<h2 class="npc__section-heading npc__accordion__heading">Relationships</h2>
			<div class="npc__relationships__container npc__accordion__content">
				<?= ($npc_allies_other || $npc_allies_links) ? "<div class='npc__field npc__field__allies'><p class='npc__field__label'>ALLIES:</p><div class='npc__field__value'>$allies_links $npc_allies_other</div></div>" : "" ?>
				<?= ($npc_enemies_other || $npc_enemies_links) ? "<div class='npc__field npc__field__enemies'><p class='npc__field__label'>ENEMIES:</p><div class='npc__field__value'>$enemies_links $npc_enemies_other</div></div>" : "" ?>
			</div>
		</section>
	<?php } ?>

	<?= ($npc_backstory) ? 
			"<!-- Backstory -->
			<section class='npc__backstory npc__accordion'>
				<h2 class='npc__section-heading npc__accordion__heading'>Backstory</h2>
				<div class='npc__field npc__field__backstory npc__accordion__content'><p class='npc__field__value'>$npc_backstory</p></div>
			</section>" 
			: "";
		?>

	<?= ($npc_symbol_id) ?
		"<!-- Backstory -->
		<section class='npc__symbol'>
			$npc_symbol_image
		</section>" 
		: "";
	?>


	<div class="npc__overview">

		<section class="npc__capabilities npc__accordion">
			<h2 class="npc__section-heading npc__accordion__heading">Capabilities</h2>
			<div class="npc__accordion__content">
			
				<div class="npc__capabilities__content">
					<?= ($npc_hp) ? "<div class='npc__field npc__field__hp'><p class='npc__field__label'>HP:</p><p class='npc__field__value'>$npc_hp</p></div>" : "" ?>
					<?= ($npc_ac) ? "<div class='npc__field npc__field__ac'><p class='npc__field__label'>AC:</p><p class='npc__field__value'>$npc_ac</p></div>" : "" ?>
					<?= ($npc_speed) ? "<div class='npc__field npc__field__speed'><p class='npc__field__label'>SPEED:</p><p class='npc__field__value'>$npc_speed</p></div>" : "" ?>
				</div>
				<!-- <div class="npc__stats"> -->
					<?php
						foreach($npc_stats as $stat => $info) {
							?>		
							<!-- <div class="npc__stats npc__stats--<?php echo $stat ?>">
								<h2 class="npc__stats__title npc__stats__title--<?php echo $stat ?>"><?php echo $stat ?></h2>
								<p class="npc__stats__value npc__stats__value--<?php echo $stat ?>"><?php echo $info['value'] ?></p>
							</div> -->
							<?php
						}
					?>
				<!-- </div> -->
				<div class="npc__skills">

					<!-- NEED TO ADD SKILL PROFICIENCIES -->

				</div>
			</div>
		</section>

	<?= ($npc_inventory || $npc_copper_pieces || $npc_silver_pieces || $npc_electrum_pieces || $npc_gold_pieces || $npc_platinum_pieces || $npc_spells) ?
		'<div class="npc__inventory-spells">' : 
		''; ?>

	<?php if($npc_inventory || $npc_copper_pieces || $npc_silver_pieces || $npc_electrum_pieces || $npc_gold_pieces || $npc_platinum_pieces) { ?>
		<!-- Inventory -->
		<section class="npc__inventory npc__accordion">
			<h2 class="npc__section-heading npc__accordion__heading">Inventory</h2>
			<div class="npc__inventory__container npc__accordion__content">
				<?= ($$npc_copper_pieces || $npc_silver_pieces || $npc_electrum_pieces || $npc_gold_pieces || $npc_platinum_pieces) ? "<div class='npc__field npc__inventory__currency'>" : "" ?>
					<?= ($npc_copper_pieces) ? "<div class='npc__field npc__field__copper'><p class='npc__field__label'>Copper:</p><p class='npc__field__value'>$npc_copper_pieces</p></div>" : "" ?>
					<?= ($npc_silver_pieces) ? "<div class='npc__field npc__field__silver'><p class='npc__field__label'>Silver:</p><p class='npc__field__value'>$npc_silver_pieces</p></div>" : "" ?>
					<?= ($npc_electrum_pieces) ? "<div class='npc__field npc__field__electrum'><p class='npc__field__label'>Electrum:</p><p class='npc__field__value'>$npc_electrum_pieces</p></div>" : "" ?>
					<?= ($npc_gold_pieces) ? "<div class='npc__field npc__field__gold'><p class='npc__field__label'>Gold:</p><p class='npc__field__value'>$npc_gold_pieces</p></div>" : "" ?>
					<?= ($npc_platinum_pieces) ? "<div class='npc__field npc__field__platinum'><p class='npc__field__label'>Platinum:</p><p class='npc__field__value'>$npc_platinum_pieces</p></div>" : "" ?>
				<?= ($$npc_copper_pieces || $npc_silver_pieces || $npc_electrum_pieces || $npc_gold_pieces || $npc_platinum_pieces) ? "</div>" : "" ?>
				<?= ($npc_inventory) ? "<div class='npc__field npc__inventory__items'><div class='npc__field__value'>$npc_inventory</div></div>" : "" ?>
			</div>
		</section>
	<?php } ?>




		<?= ($npc_spells) ? 
			"<section class='npc__spells npc__accordion'>
				<h2 class='npc__section-heading npc__accordion__heading'>Magical Abilities</h2>
				<div class='npc__field npc__field__spells npc__accordion__content'><p class='npc__field__value'>$npc_spells</p></div>
			</section>" 
			: "";
		?>

	<?= ($npc_inventory || $npc_copper_pieces || $npc_silver_pieces || $npc_electrum_pieces || $npc_gold_pieces || $npc_platinum_pieces || $npc_spells) ?
		'</div>' : 
		''; ?>

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

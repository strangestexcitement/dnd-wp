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
			$stats = get_field('stats');
			foreach($stats as $stat => $info) {
				$npc_stats[$stat] = setField($info);
			}
			$npc_stats_exist = false;
			foreach($npc_stats as $stat) {
				if($stat) {
					$npc_stats_exist = true;
					break;
				}
			}
			$npc_proficiency_bonus = intval(get_field('npc_proficiency_bonus'));
			$npc_skills = get_field('npc_skills');
			$npc_languages = setField(get_field('npc_languages'));
			$npc_tool_proficiencies = setField(get_field('npc_tool_proficiencies'));
			$npc_game_proficiencies = setField(get_field('npc_game_proficiencies'));
			$npc_musical_instrument_proficiencies = setField(get_field('npc_musical_instrument_proficiencies'));
			$npc_vehicle_proficiencies = setField(get_field('npc_vehicle_proficiencies'));
			$saving_throws = setField(get_field('npc_saving_throws'));

			if($saving_throws) {
				if($saving_throws != '???') {
					foreach($saving_throws as $throw) {
						$throw_key = strtolower($throw);
						$throw_score = $npc_stats[$throw_key];
						if($throw_score == '') {
							continue;
						}
						else if($throw_score == '???') {
							$npc_saving_throws[$throw] = '???';
						}
						else {
							$npc_saving_throws[$throw] = floor((($throw_score - 10) / 2) + $npc_proficiency_bonus);
						}
					}
				}
				else {
					$npc_saving_throws = '???';
				}
			}

			$base_skills = [
				'charisma' => [
					'deception',
					'intimidation',
					'performance',
					'persuasion'
				],
				'wisdom' => [
					'animal_handling',
					'insight',
					'medicine',
					'perception',
					'survival'
				],
				'intelligence' => [
					'arcana',
					'history',
					'investigation',
					'nature',
					'religion'
				],
				'strength' => [
					'athletics'
				],
				'dexterity' => [
					'acrobatics',
					'sleight_of_hand',
					'stealth'
				]
			];

			foreach($base_skills as $ability => $skills) {
				$ability_score = $npc_stats[$ability];
				$ability_mod = (intval($ability_score) - 10) / 2;
				foreach($skills as $skill) {
					if($ability_score == '') {
						continue;
					}
					else if (	$ability_score == '???') {
						$npc_proficiencies[$skill] = '???';
					}
					else {
						$prof_level = $npc_skills[$skill]['proficiency_level'];
						$manual_value = $npc_skills[$skill]['manual_value'];
						$visibility = $npc_skills[$skill]['visibility'];

						if($visibility == 'Partially visible') {
							$npc_proficiencies[$skill] = '???';
						}
						else if($visibility == 'Hidden') {
							continue;
						}
						else if($manual_value) {
							$skill_mod = (intval($manual_value) >= 0) ? "+$manual_value" : $manual_value;
							$npc_proficiencies[$skill] = $skill_mod;
						}
						else {
							$prof_mod = [
								'Not proficient' => 0,
								'Half proficiency' => 0.5,
								'Proficiency' => 1,
								'Expertise' => 2,
							];
							$skill_mod = floor(($prof_mod[$prof_level] * $npc_proficiency_bonus) + $ability_mod);
							$skill_mod = ($skill_mod >= 0) ? "+$skill_mod" : $skill_mod;
							$npc_proficiencies[$skill] = $skill_mod;
						}
					}
				}
			}
			if($npc_proficiencies) {
				ksort($npc_proficiencies);
			}

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
			$allies_links = listCharRelationships($npc_allies_links);
			$enemies_links = listCharRelationships($npc_enemies_links);

			// backstory
			$npc_backstory = setField(get_field('npc_backstory'));

			// extra notes
			$npc_additional_notes = setField(get_field('npc_additional_notes'));
			$npc_links = setField(get_field('npc_links'));
			$npc_symbol_desc = setField(get_field('npc_symbol_description'));

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
				$npc_symbol_image = "<div class='npc__symbol__image'>$symbol_image</div>";
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

	<!-- Goals -->
	<?php if($npc_goals) { ?>
		<div class="npc__goals npc__module">
			<div class="npc__goals__inner npc__accordion">
				<h2 class="npc__goals__heading npc__accordion__heading">Goals</h2>
				<div class="npc__goals__content npc__accordion__content">
					<?= ($npc_goals) ? "<div class='npc__field npc__field__goals'><div class='npc__field__value'>$npc_goals</div></div>" : "" ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Goals -->

	<!-- Basics -->
	<?php if($npc_background || $npc_aliases || $npc_gender_pronouns || $npc_alignment || $npc_age ||
						$npc_birthday || $npc_height || $npc_weight || $npc_body_type || $npc_eyes || $npc_skin || $npc_hair) { ?>
		<div class="npc__basics npc__module">
			<div class="npc__basics__inner npc__accordion">
				<h2 class="npc__basics__heading npc__accordion__heading">Basics</h2>
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

	<!-- Description -->
	<?php if($npc_description) { ?>
		<div class="npc__desc npc__module">
			<div class="npc__desc__inner npc__accordion">
				<h2 class="npc__desc__heading npc__accordion__heading">Description</h2>
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
				<h2 class="npc__personality__heading npc__accordion__heading">Personality</h2>
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

	<!-- Relationships -->
	<?php if($npc_allies_links || $npc_allies_other || $npc_enemies_links || $npc_enemies_other) { ?>
		<div class="npc__relationships npc__module">
			<div class="npc__relationships__inner npc__accordion">
				<h2 class="npc__relationships__heading npc__accordion__heading">Relationships</h2>
				<div class="npc__relationships__content npc__accordion__content">
					<?= ($npc_allies_other || $npc_allies_links) ? "<div class='npc__field npc__field__allies'><h3 class='npc__field__label npc__relationships__subheading'>ALLIES:</h3><div class='npc__field__value'>$allies_links</div><p class='npc__field__label'>OTHER ALLIES:</p><div class='npc__field__value'>$npc_allies_other</div></div>" : "" ?>
					<?= ($npc_enemies_other || $npc_enemies_links) ? "<div class='npc__field npc__field__enemies'><h3 class='npc__field__label npc__relationships__subheading'>ENEMIES:</h3><div class='npc__field__value'>$enemies_links</div><p class='npc__field__label'>OTHER ENEMIES:</p><div class='npc__field__value'>$npc_enemies_other</div></div>" : "" ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Relationships -->

	<!-- Backstory -->
	<?php if($npc_backstory) { ?>
		<div class="npc__backstory npc__module">
			<div class="npc__backstory__inner npc__accordion">
				<h2 class="npc__backstory__heading npc__accordion__heading">Backstory</h2>
				<div class="npc__backstory__content npc__accordion__content">
					<?= ($npc_backstory) ? "<div class='npc__field npc__field__backstory'><div class='npc__field__value'>$npc_backstory</div></div>" : "" ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Backstory -->

	<!-- Symbol -->
	<?php if($npc_symbol_id) { ?>
		<div class="npc__symbol npc__module">
			<div class="npc__symbol__inner npc__accordion">
				<h2 class="npc__symbol__heading npc__accordion__heading">Symbol</h2>
				<div class="npc__symbol__content npc__accordion__content">
					<?= ($npc_symbol_image) ? $npc_symbol_image : "" ?>
					<?= ($npc_symbol_desc) ? "<div class='npc__field npc__field__symbol__desc'><div class='npc__field__value'>$npc_symbol_desc</div></div>" : "" ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Symbol -->

	<!-- Capabilities -->
	<?php if($npc_hp || $npc_ac || $npc_speed || $npc_stats_exist) { ?>
		<div class="npc__capabilities npc__module">
			<div class="npc__capabilities__inner npc__accordion">
				<h2 class="npc__capabilities__heading npc__accordion__heading">Capabilities</h2>
				<div class="npc__capabilities__content npc__accordion__content">
					<?= ($npc_hp) ? "<div class='npc__field npc__field__hp'><p class='npc__field__label'>HP:</p><p class='npc__field__value'>$npc_hp</p></div>" : "" ?>
					<?= ($npc_ac) ? "<div class='npc__field npc__field__ac'><p class='npc__field__label'>AC:</p><p class='npc__field__value'>$npc_ac</p></div>" : "" ?>
					<?= ($npc_speed) ? "<div class='npc__field npc__field__speed'><p class='npc__field__label'>Speed:</p><p class='npc__field__value'>$npc_speed</p></div>" : "" ?>
					<?php if($npc_stats_exist) { ?>
						<div class="npc__capabilities__stats">
							<? foreach($npc_stats as $stat => $value) {
								if($value) {
									$statname = ucwords($stat);
									if($value == '???') {
										$modifier = '';
									}
									else {
										$modifier = floor((intval($value) - 10) / 2);
										$modifier = ($modifier >= 0) ? "+$modifier" : $modifier;
									}
									echo "<div class='npc__field npc__field__$stat'>";
									echo "<p class='npc__field__label'>$statname:</p>";
									echo "<p class='npc__field__value'>$value</p>";
									echo ($value != '???') ? "<p class='npc__field__subvalue'>$modifier</p>" : "";
									echo "</div>";
								}
							}
							?>
						</div>
					<?php } ?>
					<?php if($npc_saving_throws) { ?>
						<div class="npc__capabilities__saving-throws">
							<h3 class="npc__capabilities__subheading">Saving Throws</h3>
							<?php 
								if($npc_saving_throws == '???') {
									echo "<div class='npc__field npc__field__savings-throw'>";
									echo "<p class='npc__field__value'>???</p>";
									echo "</div>";
								}
								else {
									foreach($npc_saving_throws as $throw => $save) {
										$throw_lower = strtolower($throw);
										echo "<div class='npc__field npc__field__$throw_lower'>";
										echo "<p class='npc__field__label'>$throw:</p>";
										echo "<p class='npc__field__value'>$save</p>";
										echo "</div>";
									}
								}
							?>
						</div>
					<?php } ?>
					<?php if($npc_proficiencies) { ?>
						<div class="npc__capabilities__skills">
							<h3 class="npc__capabilities__subheading">Skill Proficiencies</h3>
							<? foreach($npc_proficiencies as $skill => $mod) {
								$skill_name = str_replace('_', ' ', $skill);
								$skill_name = ucwords($skill_name);
								echo "<div class='npc__field npc__field__$skill'>";
								echo "<p class='npc__field__label'>$skill_name:</p>";
								echo "<p class='npc__field__value'>$mod</p>";
								echo "</div>";
							}
							?>
						</div>
					<?php } ?>
					<?php if($npc_languages || $npc_tool_proficiencies || $npc_game_proficiencies || $npc_musical_instrument_proficiencies || $npc_vehicle_proficiencies) { ?>
						<div class="npc__capabilities__misc">
							<h3 class="npc__capabilities__subheading">Other Proficiencies</h3>
							<?= ($npc_languages) ? "<div class='npc__field npc__field__languages'><p class='npc__field__label'>Languages:</p><div class='npc__field__value'>$npc_languages</div></div>" : "" ?>
							<?= ($npc_tool_proficiencies) ? "<div class='npc__field npc__field__tools'><p class='npc__field__label'>Tools:</p><div class='npc__field__value'>$npc_tool_proficiencies</div></div>" : "" ?>
							<?= ($npc_game_proficiencies) ? "<div class='npc__field npc__field__games'><p class='npc__field__label'>Games:</p><div class='npc__field__value'>$npc_game_proficiencies</div></div>" : "" ?>
							<?= ($npc_musical_instrument_proficiencies) ? "<div class='npc__field npc__field__instruments'><p class='npc__field__label'>Instruments:</p><div class='npc__field__value'>$npc_musical_instrument_proficiencies</div></div>" : "" ?>
							<?= ($npc_vehicle_proficiencies) ? "<div class='npc__field npc__field__vehicles'><p class='npc__field__label'>Vehicles:</p><div class='npc__field__value'>$npc_vehicle_proficiencies</div></div>" : "" ?>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Capabilities -->

	<!-- Inventory -->
	<?php if($npc_inventory || $npc_copper_pieces || $npc_silver_pieces || $npc_electrum_pieces || $npc_gold_pieces || $npc_platinum_pieces) { ?>
		<div class="npc__inventory npc__module">
			<div class="npc__inventory__inner npc__accordion">
				<h2 class="npc__inventory__heading npc__accordion__heading">Inventory</h2>
				<div class="npc__inventory__content npc__accordion__content">
					<?php if($npc_copper_pieces || $npc_silver_pieces || $npc_electrum_pieces || $npc_gold_pieces || $npc_platinum_pieces) { ?>
						<div class='npc__field npc__inventory__currency'>
							<?= ($npc_copper_pieces) ? "<div class='npc__field npc__field__copper'><p class='npc__field__label'>Copper:</p><p class='npc__field__value'>$npc_copper_pieces</p></div>" : "" ?>
							<?= ($npc_silver_pieces) ? "<div class='npc__field npc__field__silver'><p class='npc__field__label'>Silver:</p><p class='npc__field__value'>$npc_silver_pieces</p></div>" : "" ?>
							<?= ($npc_electrum_pieces) ? "<div class='npc__field npc__field__electrum'><p class='npc__field__label'>Electrum:</p><p class='npc__field__value'>$npc_electrum_pieces</p></div>" : "" ?>
							<?= ($npc_gold_pieces) ? "<div class='npc__field npc__field__gold'><p class='npc__field__label'>Gold:</p><p class='npc__field__value'>$npc_gold_pieces</p></div>" : "" ?>
							<?= ($npc_platinum_pieces) ? "<div class='npc__field npc__field__platinum'><p class='npc__field__label'>Platinum:</p><p class='npc__field__value'>$npc_platinum_pieces</p></div>" : "" ?>
						</div>
					<?php } ?>
					<?= ($npc_inventory) ? "<div class='npc__field npc__inventory__items'><div class='npc__field__value'>$npc_inventory</div></div>" : "" ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Inventory -->

	<!-- Magic -->
	<?php if($npc_spells) { ?>
		<div class="npc__magic npc__module">
			<div class="npc__magic__inner npc__accordion">
				<h2 class="npc__magic__heading npc__accordion__heading">Magical Abilities</h2>
				<div class="npc__magic__content npc__accordion__content">
					<?= ($npc_spells) ? "<div class='npc__field npc__field__spells'><p class='npc__field__value'>$npc_spells</p></div>" : "" ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Magic -->

		<!-- Additional Notes -->
		<?php if($npc_additional_notes || $npc_links) { ?>
		<div class="npc__additional-notes npc__module">
			<div class="npc__additional-notes__inner npc__accordion">
				<h2 class="npc__additional-notes__heading npc__accordion__heading">Additional Notes</h2>
				<div class="npc__additional-notes__content npc__accordion__content">
					<?= ($npc_additional_notes) ? "<div class='npc__field npc__field__additional-notes'><p class='npc__field__value'>$npc_additional_notes</p></div>" : "" ?>
					<?= ($npc_links) ? "<div class='npc__field npc__field__links'><p class='npc__field__label'>LINKS:</p><p class='npc__field__value'>$npc_links</p></div>" : "" ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Additional Notes -->

</article><!-- #post-<?php the_ID(); ?> -->

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
			$pc_name = setField(get_field('pc_name'));
			$pc_aliases = setField(get_field('pc_aliases'));		
			$pc_description = setField(get_field('pc_description'));
			$pc_birthday = setField(get_field('pc_birthday'));
			$pc_age = setField(get_field('pc_age'));
			$pc_occupation = setField(get_field('pc_occupation'));
			$pc_gender_pronouns = setField(get_field('pc_gender_pronouns'));
			$pc_class = setField(get_field('pc_class'));
			$pc_level = setField(get_field('pc_level'));
			$pc_level_text = $pc_level ? "Level $pc_level" : "";
			$pc_race = setField(get_field('pc_race'));
			$pc_background = setField(get_field('pc_background'));
			$pc_alignment = setField(get_field('pc_alignment'));
			$pc_goals = setField(get_field('pc_goals'));

			// pc player(s)
			$players = get_posts(array(
				'post_type' => 'player',
				'meta_query' => array(
					array(
						'key' => 'player_characters', // name of custom field
						'value' => '"' . get_the_ID() . '"', // matches exactly "123", not just 123. This prevents a match for "1234"
						'compare' => 'LIKE'
					)
				)
			));
			foreach($players as $player) {
				$id = $player->ID;
				$pc_players[] = get_field('player_name', $id);
			}
			$players_label = count($pc_players) > 1 ? "PLAYERS" : "PLAYER";
			$pc_players = implode(', ', $pc_players);

			// inventory
			$pc_inventory = setField(get_field('pc_inventory'));
			$pc_copper_pieces = setField(get_field('pc_copper_pieces'));
			$pc_silver_pieces = setField(get_field('pc_silver_pieces'));
			$pc_electrum_pieces = setField(get_field('pc_electrum_pieces'));
			$pc_gold_pieces = setField(get_field('pc_gold_pieces'));
			$pc_platinum_pieces = setField(get_field('pc_platinum_pieces'));

			// spells
			$pc_spells = setField(get_field('pc_spells'));

			// capabilities
			$pc_hp = setField(get_field('pc_hp'));
			$pc_ac = setField(get_field('pc_ac'));
			$pc_speed = setField(get_field('pc_speed'));
			$stats = get_field('stats');
			foreach($stats as $stat => $info) {
				$pc_stats[$stat] = setField($info);
			}
			$pc_stats_exist = false;
			foreach($pc_stats as $stat) {
				if($stat) {
					$pc_stats_exist = true;
					break;
				}
			}
			$pc_proficiency_bonus = intval(get_field('pc_proficiency_bonus'));
			$pc_skills = get_field('pc_skills');
			$pc_languages = setField(get_field('pc_languages'));
			$pc_tool_proficiencies = setField(get_field('pc_tool_proficiencies'));
			$pc_game_proficiencies = setField(get_field('pc_game_proficiencies'));
			$pc_musical_instrument_proficiencies = setField(get_field('pc_musical_instrument_proficiencies'));
			$pc_vehicle_proficiencies = setField(get_field('pc_vehicle_proficiencies'));
			$saving_throws = setField(get_field('pc_saving_throws'));

			if($saving_throws) {
				if($saving_throws != '???') {
					foreach($saving_throws as $throw) {
						$throw_key = strtolower($throw);
						$throw_score = $pc_stats[$throw_key];
						if($throw_score == '') {
							continue;
						}
						else if($throw_score == '???') {
							$pc_saving_throws[$throw] = '???';
						}
						else {
							$pc_saving_throws[$throw] = floor((($throw_score - 10) / 2) + $pc_proficiency_bonus);
						}
					}
				}
				else {
					$pc_saving_throws = '???';
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
				$ability_score = $pc_stats[$ability];
				$ability_mod = (intval($ability_score) - 10) / 2;
				foreach($skills as $skill) {
					if($ability_score == '') {
						continue;
					}
					else if (	$ability_score == '???') {
						$pc_proficiencies[$skill] = '???';
					}
					else {
						$prof_level = $pc_skills[$skill]['proficiency_level'];
						$manual_value = $pc_skills[$skill]['manual_value'];
						$visibility = $pc_skills[$skill]['visibility'];

						if($visibility == 'Partially visible') {
							$pc_proficiencies[$skill] = '???';
						}
						else if($visibility == 'Hidden') {
							continue;
						}
						else if($manual_value) {
							$skill_mod = (intval($manual_value) >= 0) ? "+$manual_value" : $manual_value;
							$pc_proficiencies[$skill] = $skill_mod;
						}
						else {
							$prof_mod = [
								'Not proficient' => 0,
								'Half proficiency' => 0.5,
								'Proficiency' => 1,
								'Expertise' => 2,
							];
							$skill_mod = floor(($prof_mod[$prof_level] * $pc_proficiency_bonus) + $ability_mod);
							$skill_mod = ($skill_mod >= 0) ? "+$skill_mod" : $skill_mod;
							$pc_proficiencies[$skill] = $skill_mod;
						}
					}
				}
			}
			if($pc_proficiencies) {
				ksort($pc_proficiencies);
			}

			// details
			$pc_height = setField(get_field('pc_height'));
			$pc_weight = setField(get_field('pc_weight'));
			$pc_body_type = setField(get_field('pc_body_type'));
			$pc_eyes = setField(get_field('pc_eyes'));
			$pc_skin = setField(get_field('pc_skin'));
			$pc_hair = setField(get_field('pc_hair'));

			// personality
			$pc_personality_traits = setField(get_field('pc_personality_traits'));
			$pc_ideals = setField(get_field('pc_ideals'));
			$pc_bonds = setField(get_field('pc_bonds'));
			$pc_flaws = setField(get_field('pc_flaws'));

			// relationships
			$pc_enemies_other = setField(get_field('pc_enemies_other'));
			$pc_enemies_links = setField(get_field('pc_enemies_links'));
			$pc_allies_links = setField(get_field('pc_allies_links'));
			$pc_allies_other = setField(get_field('pc_allies_other'));
			$allies_links = listCharRelationships($pc_allies_links);
			$enemies_links = listCharRelationships($pc_enemies_links);

			// backstory
			$pc_backstory = setField(get_field('pc_backstory'));

			// extra notes
			$pc_additional_notes = setField(get_field('pc_additional_notes'));
			$pc_links = setField(get_field('pc_links'));
			$pc_symbol_desc = setField(get_field('pc_symbol_description'));

			$pc_image_id = get_field('pc_image');
			$default_image = get_template_directory_uri() . "/images/defaults/default-pc-image.jpg";

			if($pc_image_id) {
				$image = getImageAttachment($pc_image_id, "medium");
			}
			else {
				$image = "<img src='$default_image' class='pc__image--default'>";
			}
			$pc_image = "<div class='pc__image'>$image</div>";

			$pc_symbol_id = setField(get_field('pc_symbol'));
			if($pc_symbol_id) {
				$symbol_image = getImageAttachment($pc_symbol_id, 'medium');
				$pc_symbol_image = "<div class='pc__symbol__image'>$symbol_image</div>";
			}
		?>

	<!-- Hero -->
	<div class="pc__hero">
		<div class="pc__hero__inner">
			<div class="pc__hero__image">
				<?= ($pc_image) ? $pc_image : "" ?>
			</div>
			<?php if($pc_name || $pc_level || $pc_race || $pc_class || $pc_occupation || $pc_players) { ?>
				<div class="pc__hero__content">
					<?= ($pc_name) ? "<h1 class='entry-title pc__hero__name'>$pc_name</h1>" : "" ?>
					<?php if($pc_level || $pc_race || $pc_class || $pc_occupation || $pc_players) { ?>
						<div class="pc__hero__details">
							<?= ($pc_players) ? "<div class='pc__field pc__field__players'><p class='pc__field__label'>$players_label:</p><p class='pc__field__value'>$pc_players</p></div>" : "" ?>
							<?= ($pc_level) ? "<div class='pc__field pc__field__level'><p class='pc__field__label'>LEVEL:</p><p class='pc__field__value'>$pc_level</p></div>" : "" ?>
							<?= ($pc_race) ? "<div class='pc__field pc__field__race'><p class='pc__field__label'>RACE:</p><p class='pc__field__value'>$pc_race</p></div>" : "" ?>
							<?= ($pc_class) ? "<div class='pc__field pc__field__class'><p class='pc__field__label'>CLASS:</p><p class='pc__field__value'>$pc_class</p></div>" : "" ?>
							<?= ($pc_occupation) ? "<div class='pc__field pc__field__occupation'><p class='pc__field__label'>OCCUPATION:</p><p class='pc__field__value'>$pc_occupation</p></div>" : "" ?>
						</div>
					<?php } ?>
				</div>
			<?php } ?>
		</div>
	</div>
	<!-- End Hero -->

	<!-- Goals -->
	<?php if($pc_goals) { ?>
		<div class="pc__goals pc__module">
			<div class="pc__goals__inner pc__accordion">
				<h2 class="pc__goals__heading pc__accordion__heading">Goals</h2>
				<div class="pc__goals__content pc__accordion__content">
					<?= ($pc_goals) ? "<div class='pc__field pc__field__goals'><div class='pc__field__value'>$pc_goals</div></div>" : "" ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Goals -->

	<!-- Basics -->
	<?php if($pc_background || $pc_aliases || $pc_gender_pronouns || $pc_alignment || $pc_age ||
						$pc_birthday || $pc_height || $pc_weight || $pc_body_type || $pc_eyes || $pc_skin || $pc_hair) { ?>
		<div class="pc__basics pc__module">
			<div class="pc__basics__inner pc__accordion">
				<h2 class="pc__basics__heading pc__accordion__heading">Basics</h2>
				<div class="pc__basics__content pc__accordion__content">
					<?= ($pc_background) ? "<div class='pc__field pc__field__background'><p class='pc__field__label'>BACKGROUND:</p><p class='pc__field__value'>$pc_background</p></div>" : "" ?>
					<?= ($pc_aliases) ? "<div class='pc__field pc__field__aliases'><p class='pc__field__label'>ALIASES:</p><p class='pc__field__value'>$pc_aliases</p></div>" : "" ?>
					<?= ($pc_gender_pronouns) ? "<div class='pc__field pc__field__gender'><p class='pc__field__label'>GENDER/PRONOUNS:</p><p class='pc__field__value'>$pc_gender_pronouns</p></div>" : "" ?>
					<?= ($pc_alignment) ? "<div class='pc__field pc__field__alignment'><p class='pc__field__label'>ALIGNMENT:</p><p class='pc__field__value'>$pc_alignment</p></div>" : "" ?>
					<?= ($pc_age) ? "<div class='pc__field pc__field__age'><p class='pc__field__label'>AGE:</p><p class='pc__field__value'>$pc_age</p></div>" : "" ?>
					<?= ($pc_birthday) ? "<div class='pc__field pc__field__birthday'><p class='pc__field__label'>BIRTHDAY:</p><p class='pc__field__value'>$pc_birthday</p></div>" : "" ?>
					<?= ($pc_height) ? "<div class='pc__field pc__field__height'><p class='pc__field__label'>HEIGHT:</p><p class='pc__field__value'>$pc_height</p></div>" : "" ?>
					<?= ($pc_weight) ? "<div class='pc__field pc__field__weight'><p class='pc__field__label'>WEIGHT:</p><p class='pc__field__value'>$pc_weight</p></div>" : "" ?>
					<?= ($pc_body_type) ? "<div class='pc__field pc__field__body_type'><p class='pc__field__label'>BODY TYPE:</p><p class='pc__field__value'>$pc_body_type</p></div>" : "" ?>
					<?= ($pc_eyes) ? "<div class='pc__field pc__field__eyes'><p class='pc__field__label'>EYES:</p><p class='pc__field__value'>$pc_eyes</p></div>" : "" ?>
					<?= ($pc_skin) ? "<div class='pc__field pc__field__skin'><p class='pc__field__label'>SKIN:</p><p class='pc__field__value'>$pc_skin</p></div>" : "" ?>
					<?= ($pc_hair) ? "<div class='pc__field pc__field__hair'><p class='pc__field__label'>HAIR:</p><p class='pc__field__value'>$pc_hair</p></div>" : "" ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Basics -->

	<!-- Description -->
	<?php if($pc_description) { ?>
		<div class="pc__desc pc__module">
			<div class="pc__desc__inner pc__accordion">
				<h2 class="pc__desc__heading pc__accordion__heading">Description</h2>
				<div class="pc__desc__content pc__accordion__content">
					<?= ($pc_description) ? "<div class='pc__field pc__field__desc'><div class='pc__field__value'>$pc_description</div></div>" : "" ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Description -->

	<!-- Personality -->
	<?php if($pc_personality_traits || $pc_ideals || $pc_bonds || $pc_flaws) { ?>
		<div class="pc__personality pc__module">
			<div class="pc__personality__inner pc__accordion">
				<h2 class="pc__personality__heading pc__accordion__heading">Personality</h2>
				<div class="pc__personality__content pc__accordion__content">
					<?= ($pc_personality_traits) ? "<div class='pc__personality__card'><div class='pc__field pc__field__personality-traits'><p class='pc__field__label'>PERSONALITY TRAITS:</p><div class='pc__field__value'>$pc_personality_traits</div></div></div>" : "" ?>
					<?= ($pc_ideals) ? "<div class='pc__personality__card'><div class='pc__field pc__field__ideals'><p class='pc__field__label'>IDEALS:</p><div class='pc__field__value'>$pc_ideals</div></div></div>" : "" ?>
					<?= ($pc_bonds) ? "<div class='pc__personality__card'><div class='pc__field pc__field__bonds'><p class='pc__field__label'>BONDS:</p><div class='pc__field__value'>$pc_bonds</div></div></div>" : "" ?>
					<?= ($pc_flaws) ? "<div class='pc__personality__card'><div class='pc__field pc__field__flaws'><p class='pc__field__label'>FLAWS:</p><div class='pc__field__value'>$pc_flaws</div></div></div>" : "" ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Personality -->

	<!-- Relationships -->
	<?php if($pc_allies_links || $pc_allies_other || $pc_enemies_links || $pc_enemies_other) { ?>
		<div class="pc__relationships pc__module">
			<div class="pc__relationships__inner pc__accordion">
				<h2 class="pc__relationships__heading pc__accordion__heading">Relationships</h2>
				<div class="pc__relationships__content pc__accordion__content">
					<?= ($pc_allies_other || $pc_allies_links) ? "<div class='pc__field pc__field__allies'><h3 class='pc__field__label pc__relationships__subheading'>ALLIES:</h3><div class='pc__field__value'>$allies_links</div><p class='pc__field__label'>OTHER ALLIES:</p><div class='pc__field__value'>$pc_allies_other</div></div>" : "" ?>
					<?= ($pc_enemies_other || $pc_enemies_links) ? "<div class='pc__field pc__field__enemies'><h3 class='pc__field__label pc__relationships__subheading'>ENEMIES:</h3><div class='pc__field__value'>$enemies_links</div><p class='pc__field__label'>OTHER ENEMIES:</p><div class='pc__field__value'>$pc_enemies_other</div></div>" : "" ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Relationships -->

	<!-- Backstory -->
	<?php if($pc_backstory) { ?>
		<div class="pc__backstory pc__module">
			<div class="pc__backstory__inner pc__accordion">
				<h2 class="pc__backstory__heading pc__accordion__heading">Backstory</h2>
				<div class="pc__backstory__content pc__accordion__content">
					<?= ($pc_backstory) ? "<div class='pc__field pc__field__backstory'><div class='pc__field__value'>$pc_backstory</div></div>" : "" ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Backstory -->

	<!-- Symbol -->
	<?php if($pc_symbol_id) { ?>
		<div class="pc__symbol pc__module">
			<div class="pc__symbol__inner pc__accordion">
				<h2 class="pc__symbol__heading pc__accordion__heading">Symbol</h2>
				<div class="pc__symbol__content pc__accordion__content">
					<?= ($pc_symbol_image) ? $pc_symbol_image : "" ?>
					<?= ($pc_symbol_desc) ? "<div class='pc__field pc__field__symbol__desc'><div class='pc__field__value'>$pc_symbol_desc</div></div>" : "" ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Symbol -->

	<!-- Capabilities -->
	<?php if($pc_hp || $pc_ac || $pc_speed || $pc_stats_exist) { ?>
		<div class="pc__capabilities pc__module">
			<div class="pc__capabilities__inner pc__accordion">
				<h2 class="pc__capabilities__heading pc__accordion__heading">Capabilities</h2>
				<div class="pc__capabilities__content pc__accordion__content">
					<?= ($pc_hp) ? "<div class='pc__field pc__field__hp'><p class='pc__field__label'>HP:</p><p class='pc__field__value'>$pc_hp</p></div>" : "" ?>
					<?= ($pc_ac) ? "<div class='pc__field pc__field__ac'><p class='pc__field__label'>AC:</p><p class='pc__field__value'>$pc_ac</p></div>" : "" ?>
					<?= ($pc_speed) ? "<div class='pc__field pc__field__speed'><p class='pc__field__label'>Speed:</p><p class='pc__field__value'>$pc_speed</p></div>" : "" ?>
					<?php if($pc_stats_exist) { ?>
						<div class="pc__capabilities__stats">
							<? foreach($pc_stats as $stat => $value) {
								if($value) {
									$statname = ucwords($stat);
									if($value == '???') {
										$modifier = '';
									}
									else {
										$modifier = floor((intval($value) - 10) / 2);
										$modifier = ($modifier >= 0) ? "+$modifier" : $modifier;
									}
									echo "<div class='pc__field pc__field__$stat'>";
									echo "<p class='pc__field__label'>$statname:</p>";
									echo "<p class='pc__field__value'>$value</p>";
									echo ($value != '???') ? "<p class='pc__field__subvalue'>$modifier</p>" : "";
									echo "</div>";
								}
							}
							?>
						</div>
					<?php } ?>
					<?php if($pc_saving_throws) { ?>
						<div class="pc__capabilities__saving-throws">
							<h3 class="pc__capabilities__subheading">Saving Throws</h3>
							<?php 
								if($pc_saving_throws == '???') {
									echo "<div class='pc__field pc__field__savings-throw'>";
									echo "<p class='pc__field__value'>???</p>";
									echo "</div>";
								}
								else {
									foreach($pc_saving_throws as $throw => $save) {
										$throw_lower = strtolower($throw);
										echo "<div class='pc__field pc__field__$throw_lower'>";
										echo "<p class='pc__field__label'>$throw:</p>";
										echo "<p class='pc__field__value'>$save</p>";
										echo "</div>";
									}
								}
							?>
						</div>
					<?php } ?>
					<?php if($pc_proficiencies) { ?>
						<div class="pc__capabilities__skills">
							<h3 class="pc__capabilities__subheading">Skill Proficiencies</h3>
							<? foreach($pc_proficiencies as $skill => $mod) {
								$skill_name = str_replace('_', ' ', $skill);
								$skill_name = ucwords($skill_name);
								echo "<div class='pc__field pc__field__$skill'>";
								echo "<p class='pc__field__label'>$skill_name:</p>";
								echo "<p class='pc__field__value'>$mod</p>";
								echo "</div>";
							}
							?>
						</div>
					<?php } ?>
					<?php if($pc_languages || $pc_tool_proficiencies || $pc_game_proficiencies || $pc_musical_instrument_proficiencies || $pc_vehicle_proficiencies) { ?>
						<div class="pc__capabilities__misc">
							<h3 class="pc__capabilities__subheading">Other Proficiencies</h3>
							<?= ($pc_languages) ? "<div class='pc__field pc__field__languages'><p class='pc__field__label'>Languages:</p><div class='pc__field__value'>$pc_languages</div></div>" : "" ?>
							<?= ($pc_tool_proficiencies) ? "<div class='pc__field pc__field__tools'><p class='pc__field__label'>Tools:</p><div class='pc__field__value'>$pc_tool_proficiencies</div></div>" : "" ?>
							<?= ($pc_game_proficiencies) ? "<div class='pc__field pc__field__games'><p class='pc__field__label'>Games:</p><div class='pc__field__value'>$pc_game_proficiencies</div></div>" : "" ?>
							<?= ($pc_musical_instrument_proficiencies) ? "<div class='pc__field pc__field__instruments'><p class='pc__field__label'>Instruments:</p><div class='pc__field__value'>$pc_musical_instrument_proficiencies</div></div>" : "" ?>
							<?= ($pc_vehicle_proficiencies) ? "<div class='pc__field pc__field__vehicles'><p class='pc__field__label'>Vehicles:</p><div class='pc__field__value'>$pc_vehicle_proficiencies</div></div>" : "" ?>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Capabilities -->

	<!-- Inventory -->
	<?php if($pc_inventory || $pc_copper_pieces || $pc_silver_pieces || $pc_electrum_pieces || $pc_gold_pieces || $pc_platinum_pieces) { ?>
		<div class="pc__inventory pc__module">
			<div class="pc__inventory__inner pc__accordion">
				<h2 class="pc__inventory__heading pc__accordion__heading">Inventory</h2>
				<div class="pc__inventory__content pc__accordion__content">
					<?php if($pc_copper_pieces || $pc_silver_pieces || $pc_electrum_pieces || $pc_gold_pieces || $pc_platinum_pieces) { ?>
						<div class='pc__field pc__inventory__currency'>
							<?= ($pc_copper_pieces) ? "<div class='pc__field pc__field__copper'><p class='pc__field__label'>Copper:</p><p class='pc__field__value'>$pc_copper_pieces</p></div>" : "" ?>
							<?= ($pc_silver_pieces) ? "<div class='pc__field pc__field__silver'><p class='pc__field__label'>Silver:</p><p class='pc__field__value'>$pc_silver_pieces</p></div>" : "" ?>
							<?= ($pc_electrum_pieces) ? "<div class='pc__field pc__field__electrum'><p class='pc__field__label'>Electrum:</p><p class='pc__field__value'>$pc_electrum_pieces</p></div>" : "" ?>
							<?= ($pc_gold_pieces) ? "<div class='pc__field pc__field__gold'><p class='pc__field__label'>Gold:</p><p class='pc__field__value'>$pc_gold_pieces</p></div>" : "" ?>
							<?= ($pc_platinum_pieces) ? "<div class='pc__field pc__field__platinum'><p class='pc__field__label'>Platinum:</p><p class='pc__field__value'>$pc_platinum_pieces</p></div>" : "" ?>
						</div>
					<?php } ?>
					<?= ($pc_inventory) ? "<div class='pc__field pc__inventory__items'><div class='pc__field__value'>$pc_inventory</div></div>" : "" ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Inventory -->

	<!-- Magic -->
	<?php if($pc_spells) { ?>
		<div class="pc__magic pc__module">
			<div class="pc__magic__inner pc__accordion">
				<h2 class="pc__magic__heading pc__accordion__heading">Magical Abilities</h2>
				<div class="pc__magic__content pc__accordion__content">
					<?= ($pc_spells) ? "<div class='pc__field pc__field__spells'><p class='pc__field__value'>$pc_spells</p></div>" : "" ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Magic -->

		<!-- Additional Notes -->
		<?php if($pc_additional_notes || $pc_links) { ?>
		<div class="pc__additional-notes pc__module">
			<div class="pc__additional-notes__inner pc__accordion">
				<h2 class="pc__additional-notes__heading pc__accordion__heading">Additional Notes</h2>
				<div class="pc__additional-notes__content pc__accordion__content">
					<?= ($pc_additional_notes) ? "<div class='pc__field pc__field__additional-notes'><p class='pc__field__value'>$pc_additional_notes</p></div>" : "" ?>
					<?= ($pc_links) ? "<div class='pc__field pc__field__links'><p class='pc__field__label'>LINKS:</p><p class='pc__field__value'>$pc_links</p></div>" : "" ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Additional Notes -->

</article><!-- #post-<?php the_ID(); ?> -->

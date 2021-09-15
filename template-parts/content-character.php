<?php
/**
 * Template part for displaying page content in page.php
 *
 * @package dndwp
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php 

		// faith, religious_practices, armor_proficiencies, weapon_proficiencies

			// general basics
			$character_name = setField(get_field('character_name'));
			$character_name = $character_name ? $character_name : get_the_title();
			$character_aliases = setField(get_field('character_aliases'));		
			$character_description = setField(get_field('character_description'));
			$character_birthday = setField(get_field('character_birthday'));
			$character_age = setField(get_field('character_age'));
			$character_occupation = setField(get_field('character_occupation'));
			$character_gender_pronouns = setField(get_field('character_gender_pronouns'));
			$character_class = setField(get_field('character_class'));
			$character_level = setField(get_field('character_level'));
			$character_level_text = $character_level ? "Level $character_level" : "";
			$character_race = setField(get_field('character_race'));
			$character_background = setField(get_field('character_background'));
			$character_faith = setField(get_field('character_faith'));
			$character_alignment = setField(get_field('character_alignment'));
			$character_goals = setField(get_field('character_goals'));

			// pc player(s)
			if(get_post_type() == 'pc') {
				$players = get_posts(array(
					'post_type' => 'player',
					'meta_query' => array(
						array(
							'key' => 'player_characters', // name of custom field
							'value' => '"' . get_the_ID() . '"', // matches exactly "123", not just 123. This prevents a match for "1234"
							'compare' => 'LIKE'
							)
							)
						)
					);
				foreach($players as $player) {
					$id = $player->ID;
					$character_players[] = get_field('player_name', $id);
				}
				if($character_players) {
					$players_label = count($character_players) > 1 ? "PLAYERS" : "PLAYER";
				}
				if($character_players) {
					$character_players = implode(', ', $character_players);
				}
			}

			// inventory
			$character_inventory = setField(get_field('character_inventory'));
			$character_copper_pieces = setField(get_field('character_copper_pieces'));
			$character_silver_pieces = setField(get_field('character_silver_pieces'));
			$character_electrum_pieces = setField(get_field('character_electrum_pieces'));
			$character_gold_pieces = setField(get_field('character_gold_pieces'));
			$character_platinum_pieces = setField(get_field('character_platinum_pieces'));

			// spells
			$character_spells = setField(get_field('character_spells'));

			// capabilities
			$character_hp = setField(get_field('character_hp'));
			$character_ac = setField(get_field('character_ac'));
			$character_speed = setField(get_field('character_speed'));
			$stats = get_field('stats');
			if($stats) {
				foreach($stats as $stat => $info) {
					$character_stats[$stat] = setField($info);
				}
			}
			$character_stats_exist = false;
			if($character_stats) {
				foreach($character_stats as $stat) {
					if($stat) {
						$character_stats_exist = true;
						break;
					}
				}
			}
			$character_proficiency_bonus = intval(get_field('character_proficiency_bonus'));
			$character_skills = get_field('character_skills');
			$character_languages = setField(get_field('character_languages'));
			$character_tool_proficiencies = setField(get_field('character_tool_proficiencies'));
			$character_game_proficiencies = setField(get_field('character_game_proficiencies'));
			$character_musical_instrument_proficiencies = setField(get_field('character_musical_instrument_proficiencies'));
			$character_vehicle_proficiencies = setField(get_field('character_vehicle_proficiencies'));
			$character_armor_proficiencies = setField(get_field('character_armor_proficiencies'));
			$character_weapon_proficiencies = setField(get_field('character_weapon_proficiencies'));
			$saving_throws = setField(get_field('character_saving_throws'));

			if($saving_throws) {
				if($saving_throws != '???') {
					foreach($saving_throws as $throw) {
						$throw_key = strtolower($throw);
						$throw_score = $character_stats[$throw_key];
						if($throw_score == '') {
							continue;
						}
						else if($throw_score == '???') {
							$character_saving_throws[$throw] = '???';
						}
						else {
							$character_saving_throws[$throw] = floor((($throw_score - 10) / 2) + $character_proficiency_bonus);
						}
					}
				}
				else {
					$character_saving_throws = '???';
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
				$ability_score = $character_stats[$ability];
				$ability_mod = (intval($ability_score) - 10) / 2;
				foreach($skills as $skill) {
					if($ability_score == '') {
						continue;
					}
					else if (	$ability_score == '???') {
						$character_proficiencies[$skill] = '???';
					}
					else {
						$prof_level = $character_skills[$skill]['proficiency_level'];
						$manual_value = $character_skills[$skill]['manual_value'];
						$visibility = $character_skills[$skill]['visibility'];

						if($visibility == 'Partially visible') {
							$character_proficiencies[$skill] = '???';
						}
						else if($visibility == 'Hidden') {
							continue;
						}
						else if($manual_value) {
							$skill_mod = (intval($manual_value) >= 0) ? "+$manual_value" : $manual_value;
							$character_proficiencies[$skill] = $skill_mod;
						}
						else {
							$prof_mod = [
								'Not proficient' => 0,
								'Half proficiency' => 0.5,
								'Proficiency' => 1,
								'Expertise' => 2,
							];
							$skill_mod = floor(($prof_mod[$prof_level] * $character_proficiency_bonus) + $ability_mod);
							$skill_mod = ($skill_mod >= 0) ? "+$skill_mod" : $skill_mod;
							$character_proficiencies[$skill] = $skill_mod;
						}
					}
				}
			}
			if($character_proficiencies) {
				ksort($character_proficiencies);
			}

			function getProfDiv($array, $label) {
					$str = ucwords($label);
					$result = "<div class='character__field character__field__$label'><h3 class='character__field__label'>$str:</h3>";
						foreach($array as $prof) {
							$result .= "<p class='character__field__value'>$prof</p>";
						}
					$result .= "</div>";
					return $result;
			}

			// details
			$character_height = setField(get_field('character_height'));
			$character_weight = setField(get_field('character_weight'));
			$character_body_type = setField(get_field('character_body_type'));
			$character_eyes = setField(get_field('character_eyes'));
			$character_skin = setField(get_field('character_skin'));
			$character_hair = setField(get_field('character_hair'));
			$character_religious_practices = setField(get_field('character_religious_practices'));
			$character_features_and_traits = setField(get_field('character_features_and_traits'));

			// personality
			$character_personality_traits = setField(get_field('character_personality_traits'));
			$character_ideals = setField(get_field('character_ideals'));
			$character_bonds = setField(get_field('character_bonds'));
			$character_flaws = setField(get_field('character_flaws'));

			// relationships
			$character_enemies_other = setField(get_field('character_enemies_other'));
			$character_enemies_links = setField(get_field('character_enemies_links'));
			$character_allies_links = setField(get_field('character_allies_links'));
			$character_allies_other = setField(get_field('character_allies_other'));
			$allies_links = listCharRelationships($character_allies_links);
			$enemies_links = listCharRelationships($character_enemies_links);

			// backstory
			$character_backstory = setField(get_field('character_backstory'));

			// extra notes
			$character_additional_notes = setField(get_field('character_additional_notes'));
			$character_dnd_beyond = setField(get_field('character_dnd_beyond'));
			$character_links = setField(get_field('character_links'));
			$character_symbol_desc = setField(get_field('character_symbol_description'));

			$character_image_id = get_field('character_image');
			$default_image = getDefaultCharImage();

			if($character_image_id) {
				$image = getImageAttachment($character_image_id, "medium");
			}
			else {
				$image = $default_image;
			}
			$character_image = "<div class='character__image'>$image</div>";

			$character_symbol_id = setField(get_field('character_symbol'));
			if($character_symbol_id) {
				$symbol_image = getImageAttachment($character_symbol_id, 'medium');
				$character_symbol_image = "<div class='character__symbol__image'>$symbol_image</div>";
			}
		?>

	<!-- Hero -->
	<div class="character__hero">
		<div class="character__hero__inner">
			<div class="character__hero__image">
				<?= ($character_image) ? $character_image : "" ?>
			</div>
			<?php if($character_name || $character_level || $character_race || $character_class || $character_occupation || $character_players) { ?>
				<div class="character__hero__content">
					<?= ($character_name) ? "<h1 class='entry-title character__hero__name'>$character_name</h1>" : "" ?>
					<?php if($character_level || $character_race || $character_class || $character_occupation || $character_players) { ?>
						<div class="character__hero__details">
							<?= ($character_players) ? "<div class='character__field character__field__players'><h3 class='character__field__label'>$players_label:</h3><p class='character__field__value'>$character_players</p></div>" : "" ?>
							<?= ($character_level) ? "<div class='character__field character__field__level'><h3 class='character__field__label'>LEVEL:</h3><p class='character__field__value'>$character_level</p></div>" : "" ?>
							<?= ($character_race) ? "<div class='character__field character__field__race'><h3 class='character__field__label'>RACE:</h3><p class='character__field__value'>$character_race</p></div>" : "" ?>
							<?= ($character_class) ? "<div class='character__field character__field__class'><h3 class='character__field__label'>CLASS:</h3><p class='character__field__value'>$character_class</p></div>" : "" ?>
							<?= ($character_occupation) ? "<div class='character__field character__field__occupation'><h3 class='character__field__label'>OCCUPATION:</h3><p class='character__field__value'>$character_occupation</p></div>" : "" ?>
						</div>
					<?php } ?>
				</div>
			<?php } ?>
		</div>
	</div>
	<!-- End Hero -->

	<!-- Goals -->
	<?php if($character_goals) { ?>
		<div class="character__goals character__module">
			<div class="character__goals__inner accordion">
				<h2 tabindex="0" class="character__goals__heading accordion__heading">Goals</h2>
				<div class="character__goals__content accordion__content">
					<?= ($character_goals) ? "<div class='character__field character__field__goals'><div class='character__field__value'>$character_goals</div></div>" : "" ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Goals -->

	<!-- Basics -->
	<?php if($character_background || $character_aliases || $character_gender_pronouns || $character_alignment || $character_age ||
						$character_birthday || $character_height || $character_weight || $character_body_type || $character_eyes || $character_skin || $character_hair ||
						$character_faith || $character_religious_practices) { ?>
		<div class="character__basics character__module">
			<div class="character__basics__inner accordion">
				<h2 tabindex="0" class="character__basics__heading accordion__heading">Basics</h2>
				<div class="character__basics__content accordion__content">
					<?= ($character_background) ? "<div class='character__field character__field__background'><h3 class='character__field__label'>BACKGROUND:</h3><p class='character__field__value'>$character_background</p></div>" : "" ?>
					<?= ($character_aliases) ? "<div class='character__field character__field__aliases'><h3 class='character__field__label'>ALIASES:</h3><p class='character__field__value'>$character_aliases</p></div>" : "" ?>
					<?= ($character_gender_pronouns) ? "<div class='character__field character__field__gender'><h3 class='character__field__label'>GENDER/PRONOUNS:</h3><p class='character__field__value'>$character_gender_pronouns</p></div>" : "" ?>
					<?= ($character_alignment) ? "<div class='character__field character__field__alignment'><h3 class='character__field__label'>ALIGNMENT:</h3><p class='character__field__value'>$character_alignment</p></div>" : "" ?>
					<?= ($character_age) ? "<div class='character__field character__field__age'><h3 class='character__field__label'>AGE:</h3><p class='character__field__value'>$character_age</p></div>" : "" ?>
					<?= ($character_birthday) ? "<div class='character__field character__field__birthday'><h3 class='character__field__label'>BIRTHDAY:</h3><p class='character__field__value'>$character_birthday</p></div>" : "" ?>
					<?= ($character_height) ? "<div class='character__field character__field__height'><h3 class='character__field__label'>HEIGHT:</h3><p class='character__field__value'>$character_height</p></div>" : "" ?>
					<?= ($character_weight) ? "<div class='character__field character__field__weight'><h3 class='character__field__label'>WEIGHT:</h3><p class='character__field__value'>$character_weight</p></div>" : "" ?>
					<?= ($character_body_type) ? "<div class='character__field character__field__body_type'><h3 class='character__field__label'>BODY TYPE:</h3><p class='character__field__value'>$character_body_type</p></div>" : "" ?>
					<?= ($character_eyes) ? "<div class='character__field character__field__eyes'><h3 class='character__field__label'>EYES:</h3><p class='character__field__value'>$character_eyes</p></div>" : "" ?>
					<?= ($character_skin) ? "<div class='character__field character__field__skin'><h3 class='character__field__label'>SKIN:</h3><p class='character__field__value'>$character_skin</p></div>" : "" ?>
					<?= ($character_hair) ? "<div class='character__field character__field__hair'><h3 class='character__field__label'>HAIR:</h3><p class='character__field__value'>$character_hair</p></div>" : "" ?>
					<?= ($character_faith) ? "<div class='character__field character__field__faith'><h3 class='character__field__label'>FAITH:</h3><p class='character__field__value'>$character_faith</p></div>" : "" ?>
					<?= ($character_religious_practices) ? "<div class='character__field character__field__religious_practices'><h3 class='character__field__label'>RELIGIOUS PRACTICES:</h3><div class='character__field__value'>$character_religious_practices</div></div>" : "" ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Basics -->

	<!-- Description -->
	<?php if($character_description) { ?>
		<div class="character__desc character__module">
			<div class="character__desc__inner accordion">
				<h2 tabindex="0" class="character__desc__heading accordion__heading">Description</h2>
				<div class="character__desc__content accordion__content">
					<?= ($character_description) ? "<div class='character__field character__field__desc'><div class='character__field__value'>$character_description</div></div>" : "" ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Description -->

	<!-- Personality -->
	<?php if($character_personality_traits || $character_ideals || $character_bonds || $character_flaws) { ?>
		<div class="character__personality character__module">
			<div class="character__personality__inner accordion">
				<h2 tabindex="0" class="character__personality__heading accordion__heading">Personality</h2>
				<div class="character__personality__content accordion__content">
					<?= ($character_personality_traits) ? "<div class='character__personality__card'><div class='character__field character__field__personality-traits'><h3 class='character__field__label'>PERSONALITY TRAITS:</h3><div class='character__field__value'>$character_personality_traits</div></div></div>" : "" ?>
					<?= ($character_ideals) ? "<div class='character__personality__card'><div class='character__field character__field__ideals'><h3 class='character__field__label'>IDEALS:</h3><div class='character__field__value'>$character_ideals</div></div></div>" : "" ?>
					<?= ($character_bonds) ? "<div class='character__personality__card'><div class='character__field character__field__bonds'><h3 class='character__field__label'>BONDS:</h3><div class='character__field__value'>$character_bonds</div></div></div>" : "" ?>
					<?= ($character_flaws) ? "<div class='character__personality__card'><div class='character__field character__field__flaws'><h3 class='character__field__label'>FLAWS:</h3><div class='character__field__value'>$character_flaws</div></div></div>" : "" ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Personality -->

	<!-- Relationships -->
	<?php if($character_allies_links || $character_allies_other || $character_enemies_links || $character_enemies_other) { ?>
		<div class="character__relationships character__module">
			<div class="character__relationships__inner accordion">
				<h2 tabindex="0" class="character__relationships__heading accordion__heading">Relationships</h2>
				<div class="character__relationships__content accordion__content">
					<?= ($character_allies_other || $character_allies_links) ? "<div class='character__field character__field__allies'><h3 class='character__field__label character__relationships__subheading'>ALLIES:</h3><div class='character__field__value'>$allies_links</div><h3 class='character__field__label'>OTHER ALLIES:</h3><div class='character__field__value'>$character_allies_other</div></div>" : "" ?>
					<?= ($character_enemies_other || $character_enemies_links) ? "<div class='character__field character__field__enemies'><h3 class='character__field__label character__relationships__subheading'>ENEMIES:</h3><div class='character__field__value'>$enemies_links</div><h3 class='character__field__label'>OTHER ENEMIES:</h3><div class='character__field__value'>$character_enemies_other</div></div>" : "" ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Relationships -->

	<!-- Backstory -->
	<?php if($character_backstory) { ?>
		<div class="character__backstory character__module">
			<div class="character__backstory__inner accordion">
				<h2 tabindex="0" class="character__backstory__heading accordion__heading">Backstory</h2>
				<div class="character__backstory__content accordion__content">
					<?= ($character_backstory) ? "<div class='character__field character__field__backstory'><div class='character__field__value'>$character_backstory</div></div>" : "" ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Backstory -->

	<!-- Symbol -->
	<?php if($character_symbol_id) { ?>
		<div class="character__symbol character__module">
			<div class="character__symbol__inner accordion">
				<h2 tabindex="0" class="character__symbol__heading accordion__heading">Symbol</h2>
				<div class="character__symbol__content accordion__content">
					<?= ($character_symbol_image) ? $character_symbol_image : "" ?>
					<?= ($character_symbol_desc) ? "<div class='character__field character__field__symbol__desc'><div class='character__field__value'>$character_symbol_desc</div></div>" : "" ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Symbol -->

	<!-- Capabilities -->
	<?php if($character_hp || $character_ac || $character_speed || $character_stats_exist) { ?>
		<div class="character__capabilities character__module">
			<div class="character__capabilities__inner accordion">
				<h2 tabindex="0" class="character__capabilities__heading accordion__heading">Capabilities</h2>
				<div class="character__capabilities__content accordion__content">
					<?= ($character_hp) ? "<div class='character__field character__field__hp'><h3 class='character__field__label'>HP:</h3><p class='character__field__value'>$character_hp</p></div>" : "" ?>
					<?= ($character_ac) ? "<div class='character__field character__field__ac'><h3 class='character__field__label'>AC:</h3><p class='character__field__value'>$character_ac</p></div>" : "" ?>
					<?= ($character_speed) ? "<div class='character__field character__field__speed'><h3 class='character__field__label'>Speed:</h3><p class='character__field__value'>$character_speed</p></div>" : "" ?>
					<?php if($character_stats_exist) { ?>
						<div class="character__capabilities__stats">
							<? foreach($character_stats as $stat => $value) {
								if($value) {
									$statname = ucwords($stat);
									if($value == '???') {
										$modifier = '';
									}
									else {
										$modifier = floor((intval($value) - 10) / 2);
										$modifier = ($modifier >= 0) ? "+$modifier" : $modifier;
									}
									echo "<div class='character__field character__field__$stat'>";
									echo "<h3 class='character__field__label'>$statname:</h3>";
									echo "<p class='character__field__value'>$value</p>";
									echo ($value != '???') ? "<p class='character__field__subvalue'>$modifier</p>" : "";
									echo "</div>";
								}
							}
							?>
						</div>
					<?php } ?>
					<?php if($character_saving_throws) { ?>
						<div class="character__capabilities__saving-throws">
							<h3 class="character__capabilities__subheading">Saving Throws</h3>
							<?php 
								if($character_saving_throws == '???') {
									echo "<div class='character__field character__field__savings-throw'>";
									echo "<p class='character__field__value'>???</p>";
									echo "</div>";
								}
								else {
									foreach($character_saving_throws as $throw => $save) {
										$throw_lower = strtolower($throw);
										echo "<div class='character__field character__field__$throw_lower'>";
										echo "<h3 class='character__field__label'>$throw:</h3>";
										echo "<p class='character__field__value'>$save</p>";
										echo "</div>";
									}
								}
							?>
						</div>
					<?php } ?>
					<?php if($character_proficiencies) { ?>
						<div class="character__capabilities__skills">
							<h3 class="character__capabilities__subheading">Skill Proficiencies</h3>
							<? foreach($character_proficiencies as $skill => $mod) {
								$skill_name = str_replace('_', ' ', $skill);
								$skill_name = ucwords($skill_name);
								echo "<div class='character__field character__field__$skill'>";
								echo "<h3 class='character__field__label'>$skill_name:</h3>";
								echo "<p class='character__field__value'>$mod</p>";
								echo "</div>";
							}
							?>
						</div>
					<?php } ?>
					<?php if($character_languages || $character_tool_proficiencies || $character_game_proficiencies || $character_musical_instrument_proficiencies || $character_vehicle_proficiencies || $character_armor_proficiencies || $character_weapon_proficiencies) { ?>
						<div class="character__capabilities__misc">
							<h3 class="character__capabilities__subheading">Other Proficiencies</h3>
							<?= ($character_languages) ? "<div class='character__field character__field__languages'><h3 class='character__field__label'>Languages:</h3><div class='character__field__value'>$character_languages</div></div>" : "" ?>
							<?= ($character_tool_proficiencies) ? getProfDiv($character_tool_proficiencies, 'tools'): "" ?>
							<?= ($character_weapon_proficiencies) ? getProfDiv($character_weapon_proficiencies, 'weapons'): "" ?>
							<?= ($character_armor_proficiencies) ? getProfDiv($character_armor_proficiencies, 'armor'): "" ?>
							<?= ($character_game_proficiencies) ? getProfDiv($character_game_proficiencies, 'games'): "" ?>
							<?= ($character_musical_instrument_proficiencies) ? getProfDiv($character_musical_instrument_proficiencies, 'musical instruments'): "" ?>
							<?= ($character_vehicle_proficiencies) ? getProfDiv($character_vehicle_proficiencies, 'vehicles'): "" ?>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Capabilities -->

	<!-- Features and Traits -->
		<?php if($character_features_and_traits) { ?>
		<div class="character__features character__module">
			<div class="character__features__inner accordion">
				<h2 tabindex="0" class="character__features__heading accordion__heading">Features and Traits</h2>
				<div class="character__features__content accordion__content">
					<?= ($character_features_and_traits) ? "<div class='character__field character__field__features'><p class='character__field__value'>$character_features_and_traits</p></div>" : "" ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Features and Traits -->

	<!-- Inventory -->
	<?php if($character_inventory || $character_copper_pieces || $character_silver_pieces || $character_electrum_pieces || $character_gold_pieces || $character_platinum_pieces) { ?>
		<div class="character__inventory character__module">
			<div class="character__inventory__inner accordion">
				<h2 tabindex="0" class="character__inventory__heading accordion__heading">Inventory</h2>
				<div class="character__inventory__content accordion__content">
					<?php if($character_copper_pieces || $character_silver_pieces || $character_electrum_pieces || $character_gold_pieces || $character_platinum_pieces) { ?>
						<div class='character__field character__inventory__currency'>
							<?= ($character_copper_pieces) ? "<div class='character__field character__field__copper'><h3 class='character__field__label'>Copper:</h3><p class='character__field__value'>$character_copper_pieces</p></div>" : "" ?>
							<?= ($character_silver_pieces) ? "<div class='character__field character__field__silver'><h3 class='character__field__label'>Silver:</h3><p class='character__field__value'>$character_silver_pieces</p></div>" : "" ?>
							<?= ($character_electrum_pieces) ? "<div class='character__field character__field__electrum'><h3 class='character__field__label'>Electrum:</h3><p class='character__field__value'>$character_electrum_pieces</p></div>" : "" ?>
							<?= ($character_gold_pieces) ? "<div class='character__field character__field__gold'><h3 class='character__field__label'>Gold:</h3><p class='character__field__value'>$character_gold_pieces</p></div>" : "" ?>
							<?= ($character_platinum_pieces) ? "<div class='character__field character__field__platinum'><h3 class='character__field__label'>Platinum:</h3><p class='character__field__value'>$character_platinum_pieces</p></div>" : "" ?>
						</div>
					<?php } ?>
					<?= ($character_inventory) ? "<div class='character__field character__inventory__items'><div class='character__field__value'>$character_inventory</div></div>" : "" ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Inventory -->

	<!-- Magic -->
	<?php if($character_spells) { ?>
		<div class="character__magic character__module">
			<div class="character__magic__inner accordion">
				<h2 tabindex="0" class="character__magic__heading accordion__heading">Magical Abilities</h2>
				<div class="character__magic__content accordion__content">
					<?= ($character_spells) ? "<div class='character__field character__field__spells'><p class='character__field__value'>$character_spells</p></div>" : "" ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Magic -->

		<!-- Additional Notes -->
		<?php if($character_additional_notes || $character_links || $character_dnd_beyond) { ?>
		<div class="character__additional-notes character__module">
			<div class="character__additional-notes__inner accordion">
				<h2 tabindex="0" class="character__additional-notes__heading accordion__heading">Additional Notes</h2>
				<div class="character__additional-notes__content accordion__content">
					<?= ($character_additional_notes) ? "<div class='character__field character__field__additional-notes'><p class='character__field__value'>$character_additional_notes</p></div>" : "" ?>
					<?php if($character_dnd_beyond || $character_links) { ?>
						<div class='character__field character__field__links'><h3 class='character__field__label'>LINKS:</h3>
						<?= ($character_dnd_beyond) ? "<p class='character__field__value'><a href='$character_dnd_beyond' target='_blank'><span class='fab fa-d-and-d'></span></a></p>" : "" ?>
						<?= ($character_links) ? "<div class='character__field__value'>$character_links</div>" : "" ?>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Additional Notes -->

</article><!-- #post-<?php the_ID(); ?> -->

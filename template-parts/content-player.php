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
	<?php dndest_post_thumbnail(); ?>

		<?php
			$player_name = get_field('player_name');
			$player_image_id = get_field('player_image');
			$player_roles = get_field('player_roles');
			$player_description = get_field('player_description');

			$player_characters = get_field('player_characters');
			$default_image = get_template_directory_uri() . "/images/defaults/default-npc-image.jpg";
			if($player_characters) {
				$character_label = (count($player_characters) > 1) ? 'Characters' : 'Character';
				$characters = listCharRelationships($player_characters);
			}

			$player_social_links = get_field('player_social_links');
			$social_icons = [
				'd&d_beyond' => 'fab fa-d-and-d',
				'roll20' => 'fas fa-dice-d20',
				'facebook' => 'fab fa-facebook-f',
				'twitter' => 'fab fa-twitter',
				'instagram' => 'fab fa-instagram',
				'tiktok' => 'fab fa-tiktok'
			];

			if($player_image_id) {
				$image = getImageAttachment($player_image_id, "medium");
			}
			else {
				$image = "<img src='$default_image' class='player__image--default'>";
			}
			$player_image = "<div class='player__image'>$image</div>";
		
		?>

		
	<!-- Hero -->
	<div class="player__hero">
		<div class="player__hero__inner">
			<div class="player__hero__image">
				<?=  ($player_image) ? $player_image : "" ?>
			</div>
			<?php if($player_name || $player_roles) { ?>
				<div class="player__hero__content">
					<?= ($player_name) ? "<h1 class='entry-title player__hero__name'>$player_name</h1>" : "" ?>
					<?php if($player_roles) { ?>
						<div class="player__hero__details">
							<? 
								foreach($player_roles as $role) {
									echo "<p class='player__hero__details__role'>$role</p>";
								}
						 	?>
						</div>
					<?php } ?>
				</div>
			<?php } ?>
		</div>
	</div>
	<!-- End Hero -->

	<!-- Description -->
	<?php if($player_description) { ?>
		<div class="player__description player__module">
			<div class="player__description__inner accordion">
				<h2 tabindex="0" class="player__description__heading accordion__heading">About</h2>
				<div class="player__description__content accordion__content">
					<?= ($player_description) ? "<div class='player__field player__field__description'><div class='player__field__value'>$player_description</div></div>" : "" ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Description -->

	<!-- Characters -->
	<?php if($player_characters) { ?>
		<div class="player__characters player__module">
			<div class="player__characters__inner accordion">
				<h2 tabindex="0" class="player__characters__heading accordion__heading"><?= $character_label ?></h2>
				<div class="player__characters__content accordion__content">
					<?= ($player_characters) ? "<div class='player__field player__field__characters'><div class='player__field__value'>$characters</div></div>" : "" ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Characters -->

		<!-- Social Links -->
		<?php if($player_social_links['dndbeyond'] || $player_social_links['roll20'] || $player_social_links['facebook'] || 
							$player_social_links['twitter'] || $player_social_links['instagram'] || $player_social_links['tiktok']) { ?>
		<div class="player__social player__module">
			<div class="player__social__inner accordion">
				<h2 tabindex="0" class="player__social__heading accordion__heading">Social Links</h2>
				<div class="player__social__content accordion__content">
						<?php
							foreach($player_social_links as $site => $link) {
								if($link) {	
									$icon = $social_icons[$site];
									echo "<a href='$link' target='_blank'><span class='$icon'></span></a>";
								}
							}
						?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Social Links -->
</article><!-- #post-<?php the_ID(); ?> -->

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
			$player_characters = get_field('player_characters');
			$default_image = get_template_directory_uri() . "/images/defaults/default-npc-image.jpg";

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

	<!-- Characters -->
	<?php if($player_characters) { ?>
		<div class="player__characters player__module">
			<div class="player__characters__inner player__accordion">
				<h2 class="player__characters__heading player__accordion__heading">Characters</h2>
				<div class="player__characters__content player__accordion__content">
					<?= ($player_characters) ? "<div class='player__field player__field__characters'><div class='player__field__value'>$player_characters</div></div>" : "" ?>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- End Characters -->
</article><!-- #post-<?php the_ID(); ?> -->

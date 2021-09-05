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
			$player_name = $player_name ? $player_name : get_the_title();
			$player_image_id = get_field('player_image');
			$player_roles = get_field('player_roles');
			$player_excerpt = get_field('player_excerpt');
			$default_image = get_template_directory_uri() . "/images/defaults/default-player.jpg";
			$link = get_permalink();

			if($player_image_id) {
				$image = getImageAttachment($player_image_id, "medium");
			}
			else {
				$image = "<img src='$default_image' class='player__image--default'>";
			}
			$player_image = "<div class='player__image'>$image</div>";
		
		?>

		
	<!-- Card -->
	<a href="<?= $link ?>">
		<div class="player__card">
			<div class="player__card__inner">
				<div class="player__card__flip--front">
					<div class="player__card__image">
						<?=  ($player_image) ? $player_image : "" ?>
					</div>
					<?= ($player_name) ? "<h2 class='player__card__name'>$player_name</h2>" : "" ?>
					<?php if($player_roles) { ?>
						<div class="player__card__roles">
							<? 
								foreach($player_roles as $role) {
									echo "<p class='player__card__role'>$role</p>";
								}
							?>
						</div>
					<?php } ?>
				</div>
				<div class="player__card__flip--back">
					<?= ($player_name) ? "<h2 class='player__card__name--back'>$player_name</h2>" : "" ?>
					<?= ($player_excerpt) ? "<div class='player__card__excerpt'>$player_excerpt</div>" : ""; ?>
				</div>
			</div>
		</div>
	</a>
	<!-- End Card -->
</article><!-- #post-<?php the_ID(); ?> -->

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
			$default_image = get_template_directory_uri() . "/images/defaults/default-npc-image.jpg";
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
		</div>
	</a>
	<!-- End Card -->
</article><!-- #post-<?php the_ID(); ?> -->

<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package dndwp
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
		$page_heading = get_field('page_heading');
		$game_description = get_field('game_description');
		$game_links = get_field('game_links');
		$player_ids = getIds('player');
		$pc_ids = getIds('pc');
		$featured_npcs = get_field('featured_npcs');

		$social_icons = [
			'd&d_beyond' => 'fab fa-d-and-d',
			'roll20' => 'fas fa-dice-d20',
			'facebook' => 'fab fa-facebook-f',
			'twitter' => 'fab fa-twitter',
			'instagram' => 'fab fa-instagram',
			'tiktok' => 'fab fa-tiktok',
			'twitch' => 'fab fa-twitch',
			'podcast' => 'fas fa-podcast'
		];
	// the_content();
	?>

	<div class="home">
		<?php echo ($page_heading) ? "<h1 class='home__heading'>$page_heading</h1>" : the_title( '<h1 class="home__heading">', '</h1>' ); ?>

		<!-- Description -->
		<?php if($game_description) { ?>
			<div class="home__description home__module">
				<div class="home__description__inner accordion">
					<h2 tabindex="0" class="home__description__heading accordion__heading">About the Game</h2>
					<div class="home__description__content accordion__content">
						<?= $game_description ?>
					</div>
				</div>
			</div>
		<?php } ?>
		<!-- End Description -->


		<!-- Players -->
		<?php if($player_ids) { ?>
			<div class="home__players home__module">
				<div class="home__players__inner accordion">
					<h2 tabindex="0" class="home__players__heading accordion__heading">Players</h2>
					<div class="home__players__content accordion__content">
					<?php
						foreach($player_ids as $player) {
							global $post;
							$post = get_post($player);
							setup_postdata($player);
							get_template_part( 'template-parts/content', get_post_type() . "-archive" );
							wp_reset_postdata();
						}
						?>
					</div>
				</div>
			</div>
		<?php } ?>
		<!-- End Players -->

		<!-- PCs -->
		<?php if($pc_ids) { ?>
			<div class="home__pcs home__module">
				<div class="home__pcs__inner accordion">
					<h2 tabindex="0" class="home__pcs__heading accordion__heading">PCs</h2>
					<div class="home__pcs__content accordion__content">
					<?php
						foreach($pc_ids as $pc) {
							global $post;
							$post = get_post($pc);
							setup_postdata($pc);
							get_template_part( 'template-parts/content', "character-archive" );
							wp_reset_postdata();
						}
						?>
					</div>
				</div>
			</div>
		<?php } ?>
		<!-- End PCs -->
		
		<!-- NPCs -->
		<?php if($featured_npcs) { ?>
			<div class="home__featured-npcs home__module">
				<div class="home__featured-npcs__inner accordion">
					<h2 tabindex="0" class="home__featured-npcs__heading accordion__heading">Featured NPCs</h2>
					<div class="home__featured-npcs__content accordion__content">
						<div class="home__featured-npcs__container">
							<?php
								foreach($featured_npcs as $npc) {
									global $post;
									$post = get_post($npc);
									setup_postdata($npc);
									get_template_part( 'template-parts/content', "character-archive" );
									wp_reset_postdata();
								}
								?>
						</div>
						<a href="/npc/" class="button home__featured-npcs__cta">View all NPCs</a>
					</div>
				</div>
			</div>
		<?php } ?>
		<!-- End NPCs -->

		
		<!-- Social Links -->
		<?php if($game_links['d&dbeyond'] || $game_links['roll20'] || $game_links['twitch'] || $game_links['podcast'] || $game_links['others']) { ?>
		<div class="home__links home__module">
			<div class="home__links__inner accordion">
				<h2 tabindex="0" class="home__links__heading accordion__heading">Links</h2>
				<div class="home__links__content accordion__content">
						<?php
							foreach($game_links as $site => $link) {
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
	</div>
</article><!-- #post-<?php the_ID(); ?> -->

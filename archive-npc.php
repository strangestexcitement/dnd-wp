<?php
/**
 * The template for displaying NPC archive pages
 *
 * @package dndwp
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title">NPCs</h1>
			</header><!-- .page-header -->
			<div class="page-content">
			<?php

			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/*
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */
				?>
				
				<?php 
				get_template_part( 'template-parts/content', "character-archive" );
				?>
				<?php
			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>
		</div>

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();

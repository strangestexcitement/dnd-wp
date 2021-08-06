<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package dndest
 */

?>

	<footer id="colophon" class="site-footer">
		<div class="site-info">

		<p class="attributions__trigger">Attributions</p>

			<div class="attributions">
				<div class="attributions__overlay"></div>
				<div class="attributions__container">
					<h2 class="attributions__heading">Attributions</h2>
					<div class="attributions__content">
						<?php
							foreach($GLOBALS['attributions'] as $id => $attribution) {
								if($attribution) {
									?>
									<div class="attributions__attribution">
									<?php
									echo wp_get_attachment_image($id, 'thumbnail', '', array('class' => 'attributions__attribution__thumnbnail'));
									echo $attribution;
									?>
									</div>
									<?php
								}
							}
						?>
					</div>
				</div>
			</div>


			<!-- <a href="<?php echo esc_url( __( 'https://wordpress.org/', 'dndest' ) ); ?>"> -->
				<?php
				/* translators: %s: CMS name, i.e. WordPress. */
				// printf( esc_html__( 'Proudly powered by %s', 'dndest' ), 'WordPress' );
				?>
			<!-- </a> -->
			<!-- <span class="sep"> | </span> -->
				<?php
				/* translators: 1: Theme name, 2: Theme author. */
				// printf( esc_html__( 'Theme: %1$s by %2$s.', 'dndest' ), 'dndest', '<a href="http://underscores.me/">Rachel Schnaubelt</a>' );
				?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.7.1/gsap.min.js"></script>

</body>
</html>

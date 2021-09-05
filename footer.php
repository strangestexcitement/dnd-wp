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
			<?php
				the_custom_logo();
			?>
			<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<nav id="site-navigation" class="footer-navigation">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-2',
						'menu_id'        => 'footer-menu',
						'fallback_cb'		 => false,
					)
				);
				?>
			</nav><!-- #site-navigation -->
			<button class="attributions__trigger"><p>Attributions</p></button>
		</div><!-- .site-info -->
		<div class="attributions">
				<div class="attributions__overlay"></div>
				<div class="attributions__container">
					<h2 class="attributions__heading">Attributions<a tabindex="0" class="attributions__close"></a></h2>
					<div class="attributions__content">
						<?php
							if(empty($GLOBALS['attributions'])) {
								echo "<h3>No content on this page has attributions or credits.</h3>";
							}
							else {
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
							}
						?>
					</div>
				</div>
			</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.7.1/gsap.min.js"></script>

</body>
</html>

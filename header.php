<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package dndwp
 */

 //reset attributions array on each page load
	$GLOBALS['attributions'] = [];
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Benne&display=swap" rel="stylesheet"><!-- fonts -->
	<script src="https://kit.fontawesome.com/37d930f6af.js" crossorigin="anonymous"></script><!-- font awesome -->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'dndwp' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding">
			<?php
			$custom_logo_id = get_theme_mod( 'custom_logo' );
			if($custom_logo_id) {
				$site_url = get_site_url();
				echo "<a href='$site_url' class='custom-logo-link'>";
				echo getImageAttachment($custom_logo_id, 'medium');
				echo "</a>";
			}
			?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php
			$dndwp_description = get_bloginfo( 'description', 'display' );
			if ( $dndwp_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $dndwp_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<?php endif; ?>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle hamburger hamburger--spin" aria-controls="primary-menu" aria-expanded="false">
			<span class="hamburger-box">
				<span class="hamburger-inner"></span>
			</span>
			</button>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
					'fallback_cb'		 => 'nav_menu_fallback',
				)
			);
			?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

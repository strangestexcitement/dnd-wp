<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package dndest
 */

?>

<h1>Settings</h1>
<?php
	var_dump(get_option('game_options')); 
	$game_info = get_option('game_options');
?>


<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<h2>Players</h2>
			<?= ($game_info['game_field_dm']) ?
				"<h3>DM</h3>
				<p>" . $game_info['game_field_dm'] . "</p>" :
				"";
			?>	
			<?= ($game_info['game_field_players']) ?
				"<h3>Players</h3>
				<p>" . $game_info['game_field_players'] . "</p>" :
				"";
			?>
		<?php
		the_content();
		?>
	</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->

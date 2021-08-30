<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package dndest
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('pc__box'); ?>>
		<?php 

			$pc_link = get_permalink($post->ID);

			$pc_name = setField(get_field('pc_name'));
			$pc_occupation = setField(get_field('pc_occupation'));

			$pc_class = setField(get_field('pc_class'));
			$pc_level = setField(get_field('pc_level'));
			$pc_race = setField(get_field('pc_race'));

			$has_desc = ($pc_class || $pc_level || $pc_occupation || $pc_race);


			$pc_image_id = get_field('pc_image');
			// if($pc_image_id) {
			// 	$image = wp_get_attachment_image($pc_image_id, 'medium');
			// 	$pc_image = "<div class='pc__box__image'>$image</div>";
			// }


			$default_image = get_template_directory_uri() . "/images/defaults/default-pc-image.jpg";

			if($pc_image_id) {
				$image = getImageAttachment($pc_image_id, "medium");
			}
			else {
				$image = "<img src='$default_image' class='pc__box__image--default'>";
			}
			$pc_image = "<div class='pc__box__image'>$image</div>";
		?>

	<a href="<?= $pc_link ?>">
		<div class="pc__box__card">
			
			<?= ($pc_name) ? "<h2 class='entry-title pc__box__name'>$pc_name</h2>" : "" ?>

			<?= ($pc_image) ? $pc_image : "" ?>

			<?= ($has_desc) ? "<div class='pc__box__desc'><p>" : "" ?>
				<?= ($pc_level) ? "Level $pc_level" : "" ?>
				<?= ($pc_race) ? " $pc_race<br>" : "" ?>
				<?= ($pc_class) ? " $pc_class" : "" ?>
			<?= ($has_desc) ? "</p>" : "" ?>
				<?= ($pc_occupation) ? "<p>$pc_occupation</p>" : "" ?>
			<?= ($has_desc) ? "</div>" : "" ?>



		</div>
	</a>

</article><!-- #post-<?php the_ID(); ?> -->

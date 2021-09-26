<?php
/**
 * WP Queries
 *
 * @package dndwp
 */

/**
 * Gets array of all CPT IDs
 */
function getIds($cpt) {
	$query = new WP_Query(array(
		'post_type' => $cpt,
		'post_status' => 'publish',
		'posts_per_page' => -1
	));

	while ($query->have_posts()) {
		$query->the_post();
		$post_id = get_the_ID();
		$ids[] = $post_id;
	}

	wp_reset_query();
	return($ids);
}
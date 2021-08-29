<?php
/**
 * WP Queries
 *
 * @package dndest
 */

/**
 * Gets array of all player CPT IDs
 */
function getPlayerIds() {
	$query = new WP_Query(array(
		'post_type' => 'player',
		'post_status' => 'publish',
		'posts_per_page' => -1
	));

	while ($query->have_posts()) {
		$query->the_post();
		$post_id = get_the_ID();
		$player_ids[] = $post_id;
	}

	wp_reset_query();
	return($player_ids);
}

/**
 * Gets array of all NPC CPT IDs
 */
function getNpcIds() {
	$query = new WP_Query(array(
		'post_type' => 'npc',
		'post_status' => 'publish',
		'posts_per_page' => -1
	));

	while ($query->have_posts()) {
		$query->the_post();
		$post_id = get_the_ID();
		$npc_ids[] = $post_id;
	}

	wp_reset_query();
	return($npc_ids);
}
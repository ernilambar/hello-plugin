<?php
/**
 * Custom taxonomy
 *
 * @package hello_plugin
 */

/**
 * Registers the `genre` taxonomy,
 * for use with 'movie'.
 */
function hello_plugin_init() {
	register_taxonomy(
		'genre',
		array( 'movie' ),
		array(
			'hierarchical'          => false,
			'public'                => true,
			'show_in_nav_menus'     => true,
			'show_ui'               => true,
			'show_admin_column'     => false,
			'query_var'             => true,
			'rewrite'               => true,
			'capabilities'          => array(
				'manage_terms' => 'edit_posts',
				'edit_terms'   => 'edit_posts',
				'delete_terms' => 'edit_posts',
				'assign_terms' => 'edit_posts',
			),
			'labels'                => array(
				'name'                       => __( 'Genres', 'hello-plugin' ),
				'singular_name'              => _x( 'Genre', 'taxonomy general name', 'hello-plugin' ),
				'search_items'               => __( 'Search Genres', 'hello-plugin' ),
				'popular_items'              => __( 'Popular Genres', 'hello-plugin' ),
				'all_items'                  => __( 'All Genres', 'hello-plugin' ),
				'parent_item'                => __( 'Parent Genre', 'hello-plugin' ),
				'parent_item_colon'          => __( 'Parent Genre:', 'hello-plugin' ),
				'edit_item'                  => __( 'Edit Genre', 'hello-plugin' ),
				'update_item'                => __( 'Update Genre', 'hello-plugin' ),
				'view_item'                  => __( 'View Genre', 'hello-plugin' ),
				'add_new_item'               => __( 'Add New Genre', 'hello-plugin' ),
				'new_item_name'              => __( 'New Genre', 'hello-plugin' ),
				'separate_items_with_commas' => __( 'Separate genres with commas', 'hello-plugin' ),
				'add_or_remove_items'        => __( 'Add or remove genres', 'hello-plugin' ),
				'choose_from_most_used'      => __( 'Choose from the most used genres', 'hello-plugin' ),
				'not_found'                  => __( 'No genres found.', 'hello-plugin' ),
				'no_terms'                   => __( 'No genres', 'hello-plugin' ),
				'menu_name'                  => __( 'Genres', 'hello-plugin' ),
				'items_list_navigation'      => __( 'Genres list navigation', 'hello-plugin' ),
				'items_list'                 => __( 'Genres list', 'hello-plugin' ),
				'most_used'                  => _x( 'Most Used', 'genre', 'hello-plugin' ),
				'back_to_items'              => __( '&larr; Back to Genres', 'hello-plugin' ),
			),
			'show_in_rest'          => true,
			'rest_base'             => 'genre',
			'rest_controller_class' => 'WP_REST_Terms_Controller',
		)
	);
}

add_action( 'init', 'hello_plugin_init' );

/**
 * Sets the post updated messages for the `genre` taxonomy.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `genre` taxonomy.
 */
function hello_plugin_updated_messages( $messages ) {

	$messages['genre'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => __( 'Genre added.', 'hello-plugin' ),
		2 => __( 'Genre deleted.', 'hello-plugin' ),
		3 => __( 'Genre updated.', 'hello-plugin' ),
		4 => __( 'Genre not added.', 'hello-plugin' ),
		5 => __( 'Genre not updated.', 'hello-plugin' ),
		6 => __( 'Genres deleted.', 'hello-plugin' ),
	);

	return $messages;
}

add_filter( 'term_updated_messages', 'hello_plugin_updated_messages' );

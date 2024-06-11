<?php
/**
 * Custom post type
 *
 * @package hello_plugin
 */

/**
 * Registers the `movie` post type.
 */
function hello_plugin_init() {
	register_post_type(
		'movie',
		array(
			'labels'                => array(
				'name'                  => __( 'Movies', 'hello-plugin' ),
				'singular_name'         => __( 'Movie', 'hello-plugin' ),
				'all_items'             => __( 'All Movies', 'hello-plugin' ),
				'archives'              => __( 'Movie Archives', 'hello-plugin' ),
				'attributes'            => __( 'Movie Attributes', 'hello-plugin' ),
				'insert_into_item'      => __( 'Insert into Movie', 'hello-plugin' ),
				'uploaded_to_this_item' => __( 'Uploaded to this Movie', 'hello-plugin' ),
				'featured_image'        => _x( 'Featured Image', 'movie', 'hello-plugin' ),
				'set_featured_image'    => _x( 'Set featured image', 'movie', 'hello-plugin' ),
				'remove_featured_image' => _x( 'Remove featured image', 'movie', 'hello-plugin' ),
				'use_featured_image'    => _x( 'Use as featured image', 'movie', 'hello-plugin' ),
				'filter_items_list'     => __( 'Filter Movies list', 'hello-plugin' ),
				'items_list_navigation' => __( 'Movies list navigation', 'hello-plugin' ),
				'items_list'            => __( 'Movies list', 'hello-plugin' ),
				'new_item'              => __( 'New Movie', 'hello-plugin' ),
				'add_new'               => __( 'Add New', 'hello-plugin' ),
				'add_new_item'          => __( 'Add New Movie', 'hello-plugin' ),
				'edit_item'             => __( 'Edit Movie', 'hello-plugin' ),
				'view_item'             => __( 'View Movie', 'hello-plugin' ),
				'view_items'            => __( 'View Movies', 'hello-plugin' ),
				'search_items'          => __( 'Search Movies', 'hello-plugin' ),
				'not_found'             => __( 'No Movies found', 'hello-plugin' ),
				'not_found_in_trash'    => __( 'No Movies found in trash', 'hello-plugin' ),
				'parent_item_colon'     => __( 'Parent Movie:', 'hello-plugin' ),
				'menu_name'             => __( 'Movies', 'hello-plugin' ),
			),
			'public'                => true,
			'hierarchical'          => false,
			'show_ui'               => true,
			'show_in_nav_menus'     => true,
			'supports'              => array( 'title', 'editor' ),
			'has_archive'           => true,
			'rewrite'               => true,
			'query_var'             => true,
			'menu_position'         => null,
			'menu_icon'             => 'dashicons-admin-post',
			'show_in_rest'          => true,
			'rest_base'             => 'movie',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		)
	);
}

add_action( 'init', 'hello_plugin_init' );

/**
 * Sets the post updated messages for the `movie` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `movie` post type.
 */
function hello_plugin_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['movie'] = array(
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Movie updated. <a target="_blank" href="%s">View Movie</a>', 'hello-plugin' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'hello-plugin' ),
		3  => __( 'Custom field deleted.', 'hello-plugin' ),
		4  => __( 'Movie updated.', 'hello-plugin' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Movie restored to revision from %s', 'hello-plugin' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Movie published. <a href="%s">View Movie</a>', 'hello-plugin' ), esc_url( $permalink ) ),
		7  => __( 'Movie saved.', 'hello-plugin' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Movie submitted. <a target="_blank" href="%s">Preview Movie</a>', 'hello-plugin' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Movie scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Movie</a>', 'hello-plugin' ), date_i18n( __( 'M j, Y @ G:i', 'hello-plugin' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Movie draft updated. <a target="_blank" href="%s">Preview Movie</a>', 'hello-plugin' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}

add_filter( 'post_updated_messages', 'hello_plugin_updated_messages' );

/**
 * Sets the bulk post updated messages for the `movie` post type.
 *
 * @param  array $bulk_messages Arrays of messages, each keyed by the corresponding post type. Messages are
 *                              keyed with 'updated', 'locked', 'deleted', 'trashed', and 'untrashed'.
 * @param  int[] $bulk_counts   Array of item counts for each message, used to build internationalized strings.
 * @return array Bulk messages for the `movie` post type.
 */
function hello_plugin_bulk_updated_messages( $bulk_messages, $bulk_counts ) {
	global $post;

	$bulk_messages['movie'] = array(
		/* translators: %s: Number of Movies. */
		'updated'   => _n( '%s Movie updated.', '%s Movies updated.', $bulk_counts['updated'], 'hello-plugin' ),
		'locked'    => ( 1 === $bulk_counts['locked'] ) ? __( '1 Movie not updated, somebody is editing it.', 'hello-plugin' ) :
						/* translators: %s: Number of Movies. */
						_n( '%s Movie not updated, somebody is editing it.', '%s Movies not updated, somebody is editing them.', $bulk_counts['locked'], 'hello-plugin' ),
		/* translators: %s: Number of Movies. */
		'deleted'   => _n( '%s Movie permanently deleted.', '%s Movies permanently deleted.', $bulk_counts['deleted'], 'hello-plugin' ),
		/* translators: %s: Number of Movies. */
		'trashed'   => _n( '%s Movie moved to the Trash.', '%s Movies moved to the Trash.', $bulk_counts['trashed'], 'hello-plugin' ),
		/* translators: %s: Number of Movies. */
		'untrashed' => _n( '%s Movie restored from the Trash.', '%s Movies restored from the Trash.', $bulk_counts['untrashed'], 'hello-plugin' ),
	);

	return $bulk_messages;
}

add_filter( 'bulk_post_updated_messages', 'hello_plugin_bulk_updated_messages', 10, 2 );

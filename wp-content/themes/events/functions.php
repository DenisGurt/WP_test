<?php

define('THEME_OPT', 'e-theme', true);

/*------------------------------------*\
	Functions
\*------------------------------------*/

// Load scripts
function header_scripts() {
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {

        wp_register_script('themescripts', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), '1.0.0'); // Custom scripts
        wp_enqueue_script('themescripts');
    }
}

// Load styles
function load_styles() {

    wp_register_style('themestyle', get_template_directory_uri() . '/assets/css/style.css');
    wp_enqueue_style('themestyle');
}

// Register an event post type.
function init_event_post_type() {
	$labels = array(
		'name'               => _x( 'Events', 'post type general name', THEME_OPT ),
		'singular_name'      => _x( 'Event', 'post type singular name', THEME_OPT ),
		'menu_name'          => _x( 'Events', 'admin menu', THEME_OPT ),
		'name_admin_bar'     => _x( 'Event', 'add new on admin bar', THEME_OPT ),
		'add_new'            => _x( 'Add New', 'event', THEME_OPT ),
		'add_new_item'       => __( 'Add New Event', THEME_OPT ),
		'new_item'           => __( 'New Event', THEME_OPT ),
		'edit_item'          => __( 'Edit Event', THEME_OPT ),
		'view_item'          => __( 'View Event', THEME_OPT ),
		'all_items'          => __( 'All Events', THEME_OPT ),
		'search_items'       => __( 'Search Events', THEME_OPT ),
		'parent_item_colon'  => __( 'Parent Events:', THEME_OPT ),
		'not_found'          => __( 'No events found.', THEME_OPT ),
		'not_found_in_trash' => __( 'No events found in Trash.', THEME_OPT )
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'event' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
	);

	register_post_type( 'event', $args );
}

// Custom excerpt length
function new_excerpt_length($length) {
	return 20;
}

// Remove Admin bar
function remove_admin_bar() {
    return false;
}

/*------------------------------------*\
	Actions + Filters
\*------------------------------------*/

// Add Actions
add_action('wp_enqueue_scripts', 'header_scripts'); // Add Custom Scripts to wp_head
add_action('wp_enqueue_scripts', 'load_styles'); // Add Theme Stylesheet
add_action( 'init', 'init_event_post_type' ); // Register an event post type.

// Add Filters
add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
add_filter('excerpt_length', 'new_excerpt_length'); // Custom excerpt length
add_filter('excerpt_more', function($more) {
	return '...';
});
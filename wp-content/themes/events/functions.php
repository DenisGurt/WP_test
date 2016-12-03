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

// Load admin scripts
function admin_scripts() {
	wp_enqueue_script('admin_scripts', get_template_directory_uri() . '/assets/js/admin.js', array('jquery'), '1.0.0' );
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

// Custom pagination function
function get_pagenavi_array(WP_Query $the_query) {
    $big = 999999999;
    if (get_query_var('paged')) {
    	$current = get_query_var('paged');
    } else {
    	$current = get_event_offset()+1;
    }
    $pagenavi = paginate_links(array(
        'base'		=> str_replace($big, '%#%', get_pagenum_link($big)),
        'format'	=> '?paged=%#%',
        'type'		=> 'array',
        'current'	=> $current,
        'total'		=> $the_query->max_num_pages,
        'prev_next'	=> false,
    ));

    return $pagenavi;
}

// Custom Excerpts
function home_excerpt_length($length) // Create 20 Word Callback for Index page Excerpts, call using html5wp_excerpt('html5wp_index');
{
    return 20;
}

function events_excerpt_length($length)
{
    return 100;
}

// Costom Excerpt More
function theme_more($wp_embed_excerpt_more) { 
    return '...'; 
}; 

// Custom excerpt length
function event_theme_excerpt($length_callback = '', $more_callback = '') {
	global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}
// Remove Admin bar
function remove_admin_bar() {
    return false;
}

// Get event offset
function get_event_offset() {
	// Define offset and posts_per_page value
	$today = date('Ymd');
	$posts = get_posts(array(
		'posts_per_page'	=> -1,
		'post_type'			=> 'event',
		'orderby'			=> 'date_start',
		'order'				=> 'DESC',
		'post_status'		=> 'publish',
		'meta_query' => array(
			'relation'		=> 'AND',
			array(
				'key'		=> 'start_date',
				'compare'	=> '<=',
				'value'		=> $today,
			),
			array(
				'key'		=> 'end_date',
				'compare'	=> '<=',
				'value'		=> $today,
			),
		)
	));

	if($posts)
		return count($posts);
}

function counting_from_zero($matches) {
	return $matches[1]-1;
}

/*------------------------------------*\
	Actions + Filters
\*------------------------------------*/

// Add Actions
add_action('wp_enqueue_scripts', 'header_scripts'); // Add Custom Scripts to wp_head
add_action('admin_enqueue_scripts', 'admin_scripts'); // Add Admin Scripts
add_action('wp_enqueue_scripts', 'load_styles'); // Add Theme Stylesheet
add_action('init', 'init_event_post_type'); // Register an event post type.

// Add Filters
add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
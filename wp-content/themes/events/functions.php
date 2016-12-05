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
	wp_enqueue_script('thickbox');
    wp_enqueue_style('thickbox');

    wp_enqueue_script('media-upload');

	// Add the color picker css file       
	wp_enqueue_style( 'wp-color-picker' );

	wp_enqueue_script('admin_scripts', get_template_directory_uri() . '/assets/js/admin.js', array('jquery', 'wp-color-picker'), '1.0.0' );
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

/**
 * Create Admin menu Themes Options
 *
 */

// Default values
function get_default_options() {
    $options = array(
        'main_logo'		=> '',
        'primary-font'	=> '',
        'main_color'	=> '#15607d',
    );
    return $options;
}

function event_options_init() {
    $event_options = get_option( 'event_theme_options' );

    if ( false === $event_options ) {
    	$default_options = get_default_options();
        add_option( 'event_theme_options', $default_options);
    }
}

function add_themes_options() {
	add_menu_page('Theme Options', 'Theme Options', 'manage_options', __FILE__, 'event_theme_page');
}

function event_theme_page() {
	?>
	<div class="wrap">
		<h2><?php echo get_admin_page_title() ?></h2>

		<form action="options.php" method="post" enctype="multipart/form-data">
			<?php settings_errors('event_theme_errors') ?>
			<?php settings_fields('event_theme_options'); ?>
			<?php do_settings_sections('event_theme_options'); ?>
			<p class="submit">
                <input name="event_theme_options[submit]" id="submit_options_form" type="submit" class="button-primary" value="<?php esc_attr_e('Save Settings', THEME_OPT); ?>" />
                <input name="event_theme_options[reset]" type="submit" class="button-secondary" value="<?php esc_attr_e('Reset Defaults', THEME_OPT); ?>" />
            </p>
		</form>
	</div>
	<?php
}

function event_register_settings() {
    register_setting( 'event_theme_options', 'event_theme_options', 'options_validate');

    // Add Main section
    add_settings_section('event_main_section', __('Main Settings', THEME_OPT), null, 'event_theme_options' );

    add_settings_field('main_logo_box', __('Main Logo', THEME_OPT), 'main_logo_display', 'event_theme_options', 'event_main_section');
    add_settings_field('preview_logo_box',  __('Logo Preview', THEME_OPT), 'logo_preview_display', 'event_theme_options', 'event_main_section');
    add_settings_field('primary-font', __('Primary Font', THEME_OPT), 'primary_font_display', 'event_theme_options', 'event_main_section' );
	// Add Background Color Field
	add_settings_field('main_color_box', __('Main Color', THEME_OPT) , 'main_color_display', 'event_theme_options', 'event_main_section' );
}

// Display Main Logo
function main_logo_display()
{
	$event_options = get_option('event_theme_options');
	?>
        <input type="text" id="logo_url" name="event_theme_options[main_logo]" class="img" value="<?php echo esc_url( $event_options['main_logo'] ); ?>" />
        <input id="upload_logo_button" type="button" class="button" value="<?php _e( 'Upload Logo', THEME_OPT ); ?>" />
   <?php
}
function logo_preview_display() {
    $event_options = get_option( 'event_theme_options' );  ?>
    <div id="upload_logo_preview">
        <img style="max-height:80px;" src="<?php echo esc_url( $event_options['main_logo'] ); ?>" />
    </div>
    <?php
}
// Display Fonts
function primary_font_display() {
    $event_options = get_option( 'event_theme_options' );
    $fonts = get_available_fonts();
    $current_font = 'arial';

    if ( isset( $event_options['primary-font'] ) )
        $current_font = $event_options['primary-font'];

    ?>
        <select name="event_theme_options[primary-font]">
        <?php foreach( $fonts as $font_key => $font ): ?>
            <option <?php selected( $font_key == $current_font ); ?> value="<?php echo $font_key; ?>"><?php echo $font['name']; ?></option>
        <?php endforeach; ?>
        </select>
    <?php
}

// Display Main color
function main_color_display() {
	$event_options = get_option( 'event_theme_options' );
	$val = ( isset($event_options['main_color']) ) ? $event_options['main_color'] : '';
    echo '<input type="text" name="event_theme_options[main_color]" value="' . $val . '" class="color-picker" >';
}

// Validate Options
function options_validate($input) {
	$default_options = get_default_options();
    $valid_input = $default_options;
 
    $submit = ! empty($input['submit']) ? true : false;
    $reset = ! empty($input['reset']) ? true : false;
    
    // Validate Background Color
    $main_color = trim( $input['main_color'] );
    $main_color = strip_tags( stripslashes( $main_color ) );

    if ( $submit ) {
		$valid_input['main_logo'] = $input['main_logo'];
		$valid_input['primary-font'] = $input['primary-font'];

		if(check_color($main_color) === false) {
			// Set the error message
        	add_settings_error('event_theme_errors', 'main_color_error', 'Insert a valid color for Main Color', 'error' ); // $setting, $code, $message, $type
		} else {
			$valid_input['main_color'] = $input['main_color'];
		}
    }
    elseif ( $reset ) {
        $valid_input['main_logo'] = $default_options['main_logo'];
        $valid_input['primary-font'] = $default_options['primary-font'];
        $valid_input['main_color'] = $default_options['main_color'];
    }
 
    return $valid_input;
}

// Function that will check if value is a valid HEX color.
function check_color($value) {   
    if ( preg_match( '/^#[a-f0-9]{6}$/i', $value ) ) {
        return true;
    }

	return false;
}

// Register Fonts
function get_available_fonts() {
    $fonts = array(
        'open-sans' => array(
            'name'		=> 'Open Sans',
            'import'	=> '@import url(http://fonts.googleapis.com/css?family=Open+Sans);',
            'css'		=> "font-family: 'Open Sans', sans-serif;"
        ),
        'lato' => array(
            'name'		=> 'Lato',
            'import'	=> '@import url(http://fonts.googleapis.com/css?family=Lato);',
            'css'		=> "font-family: 'Lato', sans-serif;"
        ),
        'arial' => array(
            'name'		=> 'Arial',
            'import'	=> '',
            'css'		=> "font-family: Arial, sans-serif;"
        )
    );

    return apply_filters( 'event_available_fonts', $fonts );
}

// Apply Fonts
function event_wp_head() {
    $event_options = get_option( 'event_theme_options' );
    $fonts = get_available_fonts();
    $current_font = 'arial';

    if (isset($event_options['primary-font']))
        $current_font_key = $event_options['primary-font'];
    ?>
	<style>
    <?php
	    if (isset($fonts[ $current_font_key ])) {
	        $current_font = $fonts[ $current_font_key ];
	        echo $current_font['import'];
	        echo 'body * {'.$current_font['css'].'}';
	    }
	    if (isset($event_options['main_color'])) {
	    	echo '.main-color, a {color:'.$event_options['main_color'].'}';
	    	echo '.main-color-bg, .pagination .current {background-color:'.$event_options['main_color'].'}';
	    }
	?>
    </style>
    <?php
}

/*------------------------------------*\
	Actions + Filters
\*------------------------------------*/

// Add Actions
add_action('wp_enqueue_scripts', 'header_scripts'); // Add Custom Scripts to wp_head
add_action('admin_enqueue_scripts', 'admin_scripts'); // Add Admin Scripts
add_action('wp_enqueue_scripts', 'load_styles'); // Add Theme Stylesheet
add_action('init', 'init_event_post_type'); // Register an event post type.
add_action('wp_head', 'event_wp_head' ); // Apply font

add_action('admin_init', 'event_options_init'); // Initialize Theme options
add_action('admin_menu', 'add_themes_options'); // Adding admin menus
add_action('admin_init', 'event_register_settings'); // Register Admin Settings

// Add Filters
add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
<?php

/*------------------------------------*\
	Functions
\*------------------------------------*/

define('THEME_OPT', 'events-theme', true);
// Load scripts
function header_scripts()
{
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

/*------------------------------------*\
	Actions + Filters
\*------------------------------------*/

// Add Actions
add_action('wp_enqueue_scripts', 'header_scripts'); // Add Custom Scripts to wp_head
add_action('wp_enqueue_scripts', 'load_styles'); // Add Theme Stylesheet
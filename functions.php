<?php 
/**
 * Base Theme Kit
 */



 /**
 * Helper function for prettying up errors
 * @param string $message
 * @param string $subtitle
 * @param string $title
 */
$en_error = function ($message, $subtitle = '', $title = '') {
    $title = $title ?: __('Ecran Noir &rsaquo; Error', 'ecrannoirtwentyone');
    $footer = '<a href="https://ecrannoir.be/">ecrannoir.be</a>';
    $message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p><p>{$footer}</p>";
    wp_die($message, $title);
};

// This theme requires WordPress 5.3 or later.
if ( version_compare( $GLOBALS['wp_version'], '5.3', '<' ) ) {
    $en_error(__('You must be using WordPress 5.3.0 or greater.', 'ecrannoirtwentyone'), __('Invalid WordPress version', 'ecrannoirtwentyone'));
}

define( 'THEME_ROOT_DIR', dirname( __DIR__ ) . DIRECTORY_SEPARATOR );
define( 'THEME_ROOT_DIR_THEME', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define( 'THEME_ROOT_URI', get_theme_root_uri('wp-starter-twenty-one', 'wp-starter-twenty-one') . DIRECTORY_SEPARATOR );
define( 'ECRANNOIR_POST_REVISIONS', 0 );

// Import file
require get_template_directory() . '/inc/theme-helpers.php';

require get_template_directory() . '/classes/EcrannoirTwentyOne.php';
require get_template_directory() . '/classes/EcrannoirTwentyOne-Options.php';
require get_template_directory() . '/classes/EcrannoirTwentyOne-Scripts.php';
require get_template_directory() . '/classes/EcrannoirTwentyOne-Meta.php';

$shared_theme_configuration = ecrannoir_twenty_one_get_config_data();
$theme_configuration = array(
    'theme_content_width' => ecrannoir_twenty_one_get_config_value( 'content_width', $shared_theme_configuration),
    'disable_comment' => true,
    'clean' => true,
    'menus' => array(
        'primary'   => __( 'Header Menu', 'ecrannoirtwentyone' ),
        'mobile'    => __( 'Mobile Menu', 'ecrannoirtwentyone' ),
        'footer'    => __( 'Footer Menu', 'ecrannoirtwentyone' ),
        'social'    => __( 'Social Menu', 'ecrannoirtwentyone' ),
        'menu404'   => __( '404 Menu', 'ecrannoirtwentyone' ),
    ),
    'widgets' => array(
        array(
            'name'          => __('Footer Sidebar 1', 'ecrannoirtwentyone'),
            'id'            => 'sidebar-1',
            'description'   => __( 'Add Widgets here to appear in the footer.', 'ecrannoirtwentyone' ),
        ),
        array(
            'name'          => __('Footer Sidebar 2', 'ecrannoirtwentyone'),
            'id'            => 'sidebar-2',
            'description'   => __( 'Add Widgets here to appear in the footer.', 'ecrannoirtwentyone' ),
        )
    ),
    'theme_json_config' => $shared_theme_configuration
);
// $theme = new EcrannoirTwentyOne($theme_configuration);
$theme = new EcrannoirTwentyOne($theme_configuration);

// Load Utilities
// Enhance the theme by hooking into WordPress.
require get_template_directory() . '/inc/template-functions.php';

// Custom template tags for the theme.
require get_template_directory() . '/inc/template-tags.php';




<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 */

/**
 * Calculate classes for the main <html> element.
 *
 * @since Twenty Twenty-One 1.0
 *
 * @return void
 */
function ecrannoir_twenty_one_the_html_classes() {
	$classes = apply_filters( 'ecrannoirtwentyone_html_classes', '' );
	if ( ! $classes ) {
		return;
	}
	echo 'class="' . esc_attr( $classes ) . '"';
}


/**
 * Adds custom classes to the array of body classes.
 *
 * @since Twenty Twenty-One 1.0
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function ecrannoir_twenty_one_body_classes( $classes ) {

	/** Add page slug if it doesn't exist */
    if (is_single() || is_page() && !is_front_page()) {
        if (!in_array(basename(get_permalink()), $classes)) {
            $classes[] = basename(get_permalink());
        }
    }

	// Helps detect if JS is enabled or not.
	$classes[] = 'no-js';

	// Adds `singular` to singular pages, and `hfeed` to all other pages.
	$classes[] = is_singular() ? 'singular' : 'hfeed';

	// Add a body class if main navigation is active.
	if ( has_nav_menu( 'primary' ) ) {
		$classes[] = 'has-main-navigation';
	}

	// Add a body class if there are no footer widgets.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-widgets';
	}
	// Remove unnecessary classes
	$home_id_class = 'page-id-' . get_option('page_on_front');
	$remove_classes = [
		'page-template-default',
		'page-id-' . get_option('page_on_front')
	];
	$classes = array_diff($classes, $remove_classes);
	return $classes;
}
add_filter( 'body_class', 'ecrannoir_twenty_one_body_classes' );


/**
 * Creates continue reading text
 */
function ecrannoir_twenty_one_continue_reading_text() {
	$continue_reading = sprintf(
		/* translators: %s: Name of current post. */
		esc_html__( 'Continue reading %s', 'ecrannoirtwentyone' ),
		the_title( '<span class="screen-reader-text">', '</span>', false )
	);

	return $continue_reading;
}


/**
 * Create the continue reading link for excerpt.
 */
function ecrannoir_twenty_one_continue_reading_link_excerpt() {
	if ( ! is_admin() ) {
		return '&hellip; <a class="more-link" href="' . esc_url( get_permalink() ) . '">' . ecrannoir_twenty_one_continue_reading_text() . '</a>';
	}
}

// Filter the excerpt more link.
add_filter( 'excerpt_more', 'ecrannoir_twenty_one_continue_reading_link_excerpt' );

/**
 * Create the continue reading link.
 */
function ecrannoir_twenty_one_continue_reading_link() {
	if ( ! is_admin() ) {
		return '<div class="more-link-container"><a class="more-link" href="' . esc_url( get_permalink() ) . '#more-' . esc_attr( get_the_ID() ) . '">' . ecrannoir_twenty_one_continue_reading_text() . '</a></div>';
	}
}


add_filter( 'the_content_more_link', 'ecrannoir_twenty_one_continue_reading_link' );
/**
 * Excerpt Length
 */
function ecrannoir_twenty_one_filter_excerpt_length($length) {
    if ( is_admin() ) {
        return $length;
    }
    return 10;
}
add_filter('excerpt_length', 'ecrannoir_twenty_one_filter_excerpt_length');

<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 */

function ecrannoir_twenty_one_get_icon_svg( $group, $icon, $size = 24 ) {
    return '';
	// return Ecrannoir_Twenty_One_Icons::get_svg( $group, $icon, $size );
}

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

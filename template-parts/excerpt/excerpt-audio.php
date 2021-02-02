<?php
/**
 * Show the appropriate content for the Audio post format.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 */

$content = get_the_content();

if ( has_block( 'core/audio', $content ) ) {
	ecrannoir_twenty_one_print_first_instance_of_block( 'core/audio', $content );
} elseif ( has_block( 'core/embed', $content ) ) {
	ecrannoir_twenty_one_print_first_instance_of_block( 'core/embed', $content );
} else {
	ecrannoir_twenty_one_print_first_instance_of_block( 'core-embed/*', $content );
}

// Add the excerpt.
the_excerpt();

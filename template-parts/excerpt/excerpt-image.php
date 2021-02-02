<?php
/**
 * Show the appropriate content for the Image post format.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 */

// If there is no featured-image, print the first image block found.
if (
	! ecrannoir_twenty_one_can_show_post_thumbnail() &&
	has_block( 'core/image', get_the_content() )
) {

	ecrannoir_twenty_one_print_first_instance_of_block( 'core/image', get_the_content() );
}

the_excerpt();

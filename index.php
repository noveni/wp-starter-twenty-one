<?php
/**
 * The main template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

get_header();

if ( have_posts() ) {

	// Load posts loop.
	while ( have_posts() ) {
		the_post();
        get_template_part( 'template-parts/content/content', ! is_singular() ? 'excerpt' : '' );
	}

    // Previous/next page navigation.
    get_template_part( 'template-parts/pagination/pagination' );

}

get_footer();

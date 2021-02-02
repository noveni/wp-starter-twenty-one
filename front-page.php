<?php
/**
 * The front-page.php template file is used to render your site’s front page, whether the front page displays the blog posts index (mentioned above) or a static page
 * 
 * https://developer.wordpress.org/themes/basics/template-hierarchy/#front-page-display
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

<?php
/**
 * The template file used to render a static page (page post-type)
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-page
 */

get_header();

?>
His
<?php
/* Start the Loop */
while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/content/content-page');

endwhile; // End of the loop.

get_footer();

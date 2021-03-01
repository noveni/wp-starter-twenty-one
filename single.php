<?php
/**
 * The single post template file is used to render a single post
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 */

get_header();


/* Start the Loop */
while ( have_posts() ) :
	the_post();
	
	get_template_part( 'template-parts/content/content-single' );

	if ( is_attachment() ) {
		// Parent post navigation.
		the_post_navigation(
			array(
				/* translators: %s: parent post link. */
				'prev_text' => sprintf( __( '<span class="meta-nav">Published in</span><span class="post-title">%s</span>', 'ecrannoirtwentyone' ), '%title' ),
			)
		);
	}

	// Previous/next post navigation.
	$ecrannoirtwentyone_next = is_rtl() ? ecrannoir_twenty_one_get_icon_svg( 'ui', 'arrow_left', 16 ) : ecrannoir_twenty_one_get_icon_svg( 'ui', 'arrow_right', 16 );
	$ecrannoirtwentyone_prev = is_rtl() ? ecrannoir_twenty_one_get_icon_svg( 'ui', 'arrow_right', 16 ) : ecrannoir_twenty_one_get_icon_svg( 'ui', 'arrow_left', 16 );

	$ecrannoirtwentyone_next_label     = esc_html__( 'Article suivant', 'ecrannoirtwentyone' );
	$ecrannoirtwentyone_previous_label = esc_html__( 'Article précédent', 'ecrannoirtwentyone' );

	the_post_navigation(
		array(
			'next_text' => '<p class="meta-nav">' . $ecrannoirtwentyone_next_label . $ecrannoirtwentyone_next . '</p><p class="post-title">%title</p>',
			'prev_text' => '<p class="meta-nav">' . $ecrannoirtwentyone_prev . $ecrannoirtwentyone_previous_label . '</p><p class="post-title">%title</p>',
		)
	);
endwhile; // End of the loop.

get_footer();

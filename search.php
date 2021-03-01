<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 */

get_header();

if ( have_posts() ) {
	?>
	<header class="page-header alignwide">
		<h1 class="page-title">
			<?php
			printf(
				/* translators: %s: search term. */
				esc_html__( 'Résultats de recherche pour "%s"', 'ecrannoirtwentyone' ),
				'<span class="page-description search-term">' . esc_html( get_search_query() ) . '</span>'
			);
			?>
		</h1>
	</header><!-- .page-header -->

	<div class="search-result-count default-max-width">
		<?php
		printf(
			esc_html(
				/* translators: %d: the number of search results. */
				_n(
					'Nous avons trouvé %d résultat pour votre recherche.',
					'Nous avons trouvé %d résultats pour votre recherche.',
					(int) $wp_query->found_posts,
					'ecrannoirtwentyone'
				)
			),
			(int) $wp_query->found_posts
		);
		?>
	</div><!-- .search-result-count -->
	
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>

		<?php 
		/*
		 * Include the Post-Format-specific template for the content.
		 * If you want to override this in a child theme, then include a file
		 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
		 */
		get_template_part( 'template-parts/content/content-excerpt', get_post_format() ); ?>
	<?php endwhile; ?>

	// Previous/next page navigation.
	<?php get_template_part( 'template-parts/pagination/pagination' );

	// If no content, include the "No posts found" template.
} else {
	get_template_part( 'template-parts/content/content-none' );
}

get_footer();

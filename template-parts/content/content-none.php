<?php
/**
 * Template part for displaying a message that posts cannot be found
 * 
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

?>

<section class="no-results not-found">
    <header class="page-header alignwide">
		<?php if ( is_search() ) : ?>

			<h1 class="page-title">
				<?php
				printf(
					/* translators: %s: search term. */
					esc_html__( 'Results for "%s"', 'ecrannoirtwentyone' ),
					'<span class="page-description search-term">' . esc_html( get_search_query() ) . '</span>'
				);
				?>
			</h1>

		<?php else : ?>

			<h1 class="page-title"><?php esc_html_e( 'Nothing here', 'ecrannoirtwentyone' ); ?></h1>

		<?php endif; ?>
	</header><!-- .page-header -->

    <div class="page-content default-max-width">

        <?php if ( is_search() ) : ?>

            <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'ecrannoirtwentyone' ); ?></p>
			<?php get_search_form(); ?>

        <?php else : ?>

            <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'ecrannoirtwentyone' ); ?></p>
            <?php get_search_form(); ?>
            
        <?php endif; ?>
    </div>
    
</section>

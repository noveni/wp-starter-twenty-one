<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if (ecrannoir_twenty_one_has_title() || has_post_thumbnail()) : ?>
		<header class="entry-header alignwide">
			<?php if(ecrannoir_twenty_one_has_title()): ?>
				<?php get_template_part( 'template-parts/header/entry-header' ); ?>
			<?php endif; ?>
			<?php if(has_post_thumbnail()): ?>
				<?php ecrannoir_twenty_one_post_thumbnail(); ?>
			<?php endif; ?>
		</header>
	<?php endif; ?>

	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before'   => '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'ecrannoirtwentyone' ) . '">',
				'after'    => '</nav>',
				/* translators: %: page number. */
				'pagelink' => esc_html__( 'Page %', 'ecrannoirtwentyone' ),
			)
		);
		?>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->

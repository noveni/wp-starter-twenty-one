<?php
/**
 * Custom template tags for this theme
 *
 */

/**
 * Print the site Logo
 */
function ecrannoir_twenty_one_the_logo() {
    echo ecrannoir_twenty_one_get_the_logo();
}

/**
 * Get the site logo
 */
function ecrannoir_twenty_one_get_the_logo() {
    return EcranNoirTwentyOne_Icons::get_svg('brand', 'logo', false);
}



if ( ! function_exists( 'ecrannoir_twenty_one_posted_on' ) ) {
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 *
	 *
	 * @return void
	 */
	function ecrannoir_twenty_one_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() )
		);
		echo '<span class="posted-on"><strong>';
		printf(
			/* translators: %s: publish date. */
			esc_html__( 'Publié le %s', 'ecrannoirtwentyone' ),
			$time_string // phpcs:ignore WordPress.Security.EscapeOutput
		);
		echo '</strong></span>';
	}
}

if ( ! function_exists( 'ecrannoir_twenty_one_posted_by' ) ) {
	/**
	 * Prints HTML with meta information about theme author.
	 *
	 *
	 * @return void
	 */
	function ecrannoir_twenty_one_posted_by() {
		if ( ! get_the_author_meta( 'description' ) && post_type_supports( get_post_type(), 'author' ) ) {
			echo '<span class="byline">';
			printf(
				/* translators: %s author name. */
				esc_html__( 'Par %s', 'ecrannoirtwentyone' ),
				'<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" rel="author">' . esc_html( get_the_author() ) . '</a>'
			);
			echo '</span>';
		}
	}
}

if ( ! function_exists( 'ecrannoir_twenty_one_entry_meta_footer' ) ) {
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 * Footer entry meta is displayed differently in archives and single posts.
	 *
	 *
	 * @return void
	 */
	function ecrannoir_twenty_one_entry_meta_footer() {

		// Early exit if not a post.
		if ( 'post' !== get_post_type() ) {
			return;
		}

		// Hide meta information on pages.
		if ( ! is_single() ) {

			// if ( is_sticky() ) {
			// 	echo '<p>' . esc_html_x( 'Featured post', 'Label for sticky posts', 'ecrannoirtwentyone' ) . '</p>';
			// }

			$post_format = get_post_format();
			if ( 'aside' === $post_format || 'status' === $post_format ) {
				echo '<p><a href="' . esc_url( get_permalink() ) . '">' . ecrannoir_twenty_one_continue_reading_text() . '</a></p>'; // phpcs:ignore WordPress.Security.EscapeOutput
			}

			// Posted on.
			ecrannoir_twenty_one_posted_on();


			if ( has_category() || has_tag() ) {

				echo '<div class="post-taxonomies">';

				/* translators: used between list items, there is a space after the comma. */
				$categories_list = get_the_category_list(' ');
				if ( $categories_list ) {
					printf(
						/* translators: %s: list of categories. */
						'<span class="cat-links">' . esc_html__( 'Catégories: %s', 'ecrannoirtwentyone' ) . ' </span>',
						$categories_list // phpcs:ignore WordPress.Security.EscapeOutput
					);
				}

				/* translators: used between list items, there is a space after the comma. */
				$tags_list = get_the_tag_list( );
				if ( $tags_list ) {
					printf(
						/* translators: %s: list of tags. */
						'<span class="tags-links">' . esc_html__( 'Tags: %s', 'ecrannoirtwentyone' ) . '</span>',
						$tags_list // phpcs:ignore WordPress.Security.EscapeOutput
					);
				}
				echo '</div>';
			}
		} else {

			echo '<div class="posted-by">';
			// Posted on.
			ecrannoir_twenty_one_posted_on();
			// Posted by.
			ecrannoir_twenty_one_posted_by();

			echo '</div>';

			if ( has_category() || has_tag() ) {

				echo '<div class="post-taxonomies">';

				/* translators: used between list items, there is a space after the comma. */
				$categories_list = get_the_category_list( ' ' );
				if ( $categories_list ) {
					printf(
						/* translators: %s: list of categories. */
						'<span class="cat-links">' . esc_html__( 'Catégories: %s', 'ecrannoirtwentyone' ) . ' </span>',
						$categories_list // phpcs:ignore WordPress.Security.EscapeOutput
					);
				}

				/* translators: used between list items, there is a space after the comma. */
				$tags_list = get_the_tag_list();
				if ( $tags_list ) {
					printf(
						/* translators: %s: list of tags. */
						'<span class="tags-links">' . esc_html__( 'Tags: %s', 'ecrannoirtwentyone' ) . '</span>',
						$tags_list // phpcs:ignore WordPress.Security.EscapeOutput
					);
				}
				echo '</div>';
			}
		}
	}
}

if ( ! function_exists( 'ecrannoir_twenty_one_post_thumbnail' ) ) {
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 *
	 * @return void
	 */
	function ecrannoir_twenty_one_post_thumbnail() {
		if ( ! ecrannoir_twenty_one_can_show_post_thumbnail() ) {
			return;
		}
		?>

		<?php if ( is_singular() ) : ?>

			<figure class="post-thumbnail">
				<?php
				// Lazy-loading attributes should be skipped for thumbnails since they are immediately in the viewport.
				the_post_thumbnail( 'post-thumbnail', array( 'loading' => false ) );
				?>
				<?php if ( wp_get_attachment_caption( get_post_thumbnail_id() ) ) : ?>
					<figcaption class="wp-caption-text"><?php echo wp_kses_post( wp_get_attachment_caption( get_post_thumbnail_id() ) ); ?></figcaption>
				<?php endif; ?>
			</figure><!-- .post-thumbnail -->

		<?php else : ?>

			<figure class="post-thumbnail">
				<a class="post-thumbnail-inner alignwide" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
					<?php the_post_thumbnail( 'post-thumbnail' ); ?>
				</a>
				<?php if ( wp_get_attachment_caption( get_post_thumbnail_id() ) ) : ?>
					<figcaption class="wp-caption-text"><?php echo wp_kses_post( wp_get_attachment_caption( get_post_thumbnail_id() ) ); ?></figcaption>
				<?php endif; ?>
			</figure>

		<?php endif; ?>
		<?php
	}
}

if ( ! function_exists( 'ecrannoir_twenty_one_block_button' ) ) {
	/**
	 * Displays an block button.
	 *
	 * @return void
	 */
	function ecrannoir_twenty_one_block_button($url = false, $label = '', $style = '', $extraClass = '' ) {
		$href = "";
		if ($url) {
			$href = 'href="' . esc_url( $url ) . '"';
		}

		$class = 'wp-block-button';

		if ($style != '') {
			$class .= " is-style-ecrannoirtwentyone-button-$style";
		}

		if ($extraClass != '') {
			$class .= " $extraClass";
		}
		
		?>
		<div class="wp-block-buttons">
			<div class="<?php echo $class ?>"><a class="wp-block-button__link" <?php echo $href; ?>><?php echo $label; ?></a></div>
		</div>
		<?php
	}
}

function ecrannoir_twenty_one_has_title() {
	$title = get_the_title();

	if ( strlen( $title ) == 0 ) {
		return false;
	}

	return true;
}

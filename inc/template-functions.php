<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 */

/**
 * Calculate classes for the main <html> element.
 *
 * @since Twenty Twenty-One 1.0
 *
 * @return void
 */
function ecrannoir_twenty_one_the_html_classes() {
	$classes = apply_filters( 'ecrannoirtwentyone_html_classes', '' );
	if ( ! $classes ) {
		return;
	}
	echo 'class="' . esc_attr( $classes ) . '"';
}


/**
 * Adds custom classes to the array of body classes.
 *
 * @since Twenty Twenty-One 1.0
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function ecrannoir_twenty_one_body_classes( $classes ) {

	/** Add page slug if it doesn't exist */
    if (is_single() || is_page() && !is_front_page()) {
        if (!in_array(basename(get_permalink()), $classes)) {
            $classes[] = basename(get_permalink());
        }
    }

	// Helps detect if JS is enabled or not.
	$classes[] = 'no-js';

	// Adds `singular` to singular pages, and `hfeed` to all other pages.
	$classes[] = is_singular() ? 'singular' : 'hfeed';

	// Add a body class if main navigation is active.
	if ( has_nav_menu( 'primary' ) ) {
		$classes[] = 'has-main-navigation';
	}

	// Add a body class if there are no footer widgets.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-widgets';
	}
	// Remove unnecessary classes
	$home_id_class = 'page-id-' . get_option('page_on_front');
	$remove_classes = [
		'page-template-default',
		'page-id-' . get_option('page_on_front')
	];
	$classes = array_diff($classes, $remove_classes);
	return $classes;
}
add_filter( 'body_class', 'ecrannoir_twenty_one_body_classes' );


/**
 * Determines if post thumbnail can be displayed.
 *
 * @since Twenty Twenty-One 1.0
 *
 * @return bool
 */
function ecrannoir_twenty_one_can_show_post_thumbnail() {
	return apply_filters(
		'ecrannoir_twenty_one_can_show_post_thumbnail',
		! post_password_required() && ! is_attachment() && has_post_thumbnail()
	);
}


/**
 * Creates continue reading text
 */
function ecrannoir_twenty_one_continue_reading_text() {
	$continue_reading = sprintf(
		/* translators: %s: Name of current post. */
		esc_html__( 'Continue reading %s', 'ecrannoirtwentyone' ),
		the_title( '<span class="screen-reader-text">', '</span>', false )
	);

	return $continue_reading;
}

/**
 * Create the continue reading link for excerpt.
 */
function ecrannoir_twenty_one_continue_reading_link_excerpt() {
	if ( ! is_admin() ) {
		return '&hellip; <a class="more-link" href="' . esc_url( get_permalink() ) . '">' . ecrannoir_twenty_one_continue_reading_text() . '</a>';
	}
}

// Filter the excerpt more link.
add_filter( 'excerpt_more', 'ecrannoir_twenty_one_continue_reading_link_excerpt' );

/**
 * Create the continue reading link.
 */
function ecrannoir_twenty_one_continue_reading_link() {
	if ( ! is_admin() ) {
		return '<div class="more-link-container"><a class="more-link" href="' . esc_url( get_permalink() ) . '#more-' . esc_attr( get_the_ID() ) . '">' . ecrannoir_twenty_one_continue_reading_text() . '</a></div>';
	}
}

// Filter the excerpt more link.
add_filter( 'the_content_more_link', 'ecrannoir_twenty_one_continue_reading_link' );

/**
 * Excerpt Length
 */
function ecrannoir_twenty_one_filter_excerpt_length($length) {
    if ( is_admin() ) {
        return $length;
    }
    return 10;
}

// Filter the excerpt length.
add_filter('excerpt_length', 'ecrannoir_twenty_one_filter_excerpt_length');

/**
 * Print the first instance of a block in the content, and then break away.
 *
 * @param string      $block_name The full block type name, or a partial match.
 *                                Example: `core/image`, `core-embed/*`.
 * @param string|null $content    The content to search in. Use null for get_the_content().
 * @param int         $instances  How many instances of the block will be printed (max). Defaults to 1.
 *
 * @return bool Returns true if a block was located & printed, otherwise false.
 */
function ecrannoir_twenty_one_print_first_instance_of_block( $block_name, $content = null, $instances = 1 ) {
	$instances_count = 0;
	$blocks_content  = '';

	if ( ! $content ) {
		$content = get_the_content();
	}

	// Parse blocks in the content.
	$blocks = parse_blocks( $content );

	// Loop blocks.
	foreach ( $blocks as $block ) {

		// Sanity check.
		if ( ! isset( $block['blockName'] ) ) {
			continue;
		}

		// Check if this the block matches the $block_name.
		$is_matching_block = false;

		// If the block ends with *, try to match the first portion.
		if ( '*' === $block_name[-1] ) {
			$is_matching_block = 0 === strpos( $block['blockName'], rtrim( $block_name, '*' ) );
		} else {
			$is_matching_block = $block_name === $block['blockName'];
		}

		if ( $is_matching_block ) {
			// Increment count.
			$instances_count++;

			// Add the block HTML.
			$blocks_content .= render_block( $block );

			// Break the loop if the $instances count was reached.
			if ( $instances_count >= $instances ) {
				break;
			}
		}
	}

	if ( $blocks_content ) {
		echo apply_filters( 'the_content', $blocks_content ); // phpcs:ignore WordPress.Security.EscapeOutput
		return true;
	}

	return false;
}



/**
 * Filters the list of attachment image attributes.
 *
 * @since Twenty Twenty-One 1.0
 *
 * @param array        $attr       Array of attribute values for the image markup, keyed by attribute name.
 *                                 See wp_get_attachment_image().
 * @param WP_Post      $attachment Image attachment post.
 * @param string|array $size       Requested size. Image size or array of width and height values
 *                                 (in that order). Default 'thumbnail'.
 *
 * @return array
 */
function ecrannoir_twenty_one_get_attachment_image_attributes( $attr, $attachment, $size ) {

	if ( isset( $attr['class'] ) && false !== strpos( $attr['class'], 'custom-logo' ) ) {
		return $attr;
	}

	$width  = false;
	$height = false;

	if ( is_array( $size ) ) {
		$width  = (int) $size[0];
		$height = (int) $size[1];
	} elseif ( $attachment && is_object( $attachment ) && $attachment->ID ) {
		$meta = wp_get_attachment_metadata( $attachment->ID );
		if ( $meta['width'] && $meta['height'] ) {
			$width  = (int) $meta['width'];
			$height = (int) $meta['height'];
		}
	}

	if ( $width && $height ) {

		// Add style.
		$attr['style'] = isset( $attr['style'] ) ? $attr['style'] : '';
		$attr['style'] = 'width:100%;height:' . round( 100 * $height / $width, 2 ) . '%;max-width:' . $width . 'px;' . $attr['style'];
	}

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'ecrannoir_twenty_one_get_attachment_image_attributes', 10, 3 );

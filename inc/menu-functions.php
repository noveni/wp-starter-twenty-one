<?php
/**
 * Functions and filters related to the menus.
 *
 * Makes the default WordPress navigation use an HTML structure similar
 * to the Navigation block.
 *
 * @link https://make.wordpress.org/themes/2020/07/06/printing-navigation-block-html-from-a-legacy-menu-in-themes/
 *
 */

/**
 * Add a button to top-level menu items that has sub-menus.
 * An icon is added using CSS depending on the value of aria-expanded.
 *
 * @param string $output Nav menu item start element.
 * @param object $item   Nav menu item.
 * @param int    $depth  Depth.
 * @param object $args   Nav menu args.
 *
 * @return string Nav menu item start element.
 */
function ecrannoir_twenty_one_add_sub_menu_toggle( $output, $item, $depth, $args ) {
	if ( 0 === $depth && in_array( 'menu-item-has-children', $item->classes, true ) ) {

		// Add toggle button.
		$output .= '<button class="sub-menu-toggle" aria-expanded="false">';
		$output .= '<span class="icon-plus">' . ecrannoir_twenty_one_get_icon_svg( 'ui', 'plus', 18 ) . '</span>';
		$output .= '<span class="icon-minus">' . ecrannoir_twenty_one_get_icon_svg( 'ui', 'minus', 18 ) . '</span>';
		$output .= '<span class="screen-reader-text">' . esc_html__( 'Open menu', 'ecrannoirtwentyone' ) . '</span>';
		$output .= '</button>';
	}
	return $output;
}
add_filter( 'walker_nav_menu_start_el', 'ecrannoir_twenty_one_add_sub_menu_toggle', 10, 4 );

/**
 * Detects the social network from a URL and returns the SVG code for its icon.
 *
 *
 * @param string $uri Social link.
 * @param int    $size The icon size in pixels.
 *
 * @return string
 */
function ecrannoir_twenty_one_get_social_link_svg( $uri, $size = 24 ) {
	return EcranNoirTwentyOne_Icons::get_social_link_svg( $uri, $size );
}

/**
 * Displays SVG icons in the footer navigation.
 *
 * @param string   $item_output The menu item's starting HTML output.
 * @param WP_Post  $item        Menu item data object.
 * @param int      $depth       Depth of the menu. Used for padding.
 * @param stdClass $args        An object of wp_nav_menu() arguments.
 * @return string The menu item output with social icon.
 */
function ecrannoir_twenty_one_nav_menu_social_icons( $item_output, $item, $depth, $args ) {
	// Change SVG icon inside social links menu if there is supported URL.
	if ( 'social' === $args->theme_location ) {
		$svg = ecrannoir_twenty_one_get_social_link_svg( $item->url, 24 );
		if ( ! empty( $svg ) ) {
			$item_output = str_replace( $args->link_before, $svg, $item_output );
		}
	}

	return $item_output;
}

add_filter( 'walker_nav_menu_start_el', 'ecrannoir_twenty_one_nav_menu_social_icons', 10, 4 );

/**
 * Filters the arguments for a single nav menu item.
 *
 * @param stdClass $args  An object of wp_nav_menu() arguments.
 * @param WP_Post  $item  Menu item data object.
 * @param int      $depth Depth of menu item. Used for padding.
 *
 * @return stdClass
 */
function ecrannoir_twenty_one_add_menu_description_args( $args, $item, $depth ) {
	$args->link_after = '';
	if ( 0 === $depth && isset( $item->description ) && $item->description ) {
		// The extra <span> element is here for styling purposes: Allows the description to not be underlined on hover.
		$args->link_after = '<p class="menu-item-description"><span>' . $item->description . '</span></p>';
	}
	return $args;
}
add_filter( 'nav_menu_item_args', 'ecrannoir_twenty_one_add_menu_description_args', 10, 3 );


/**
 * Display Logo in place of a menu item if it's a logo
 */
function ecrannoir_twenty_one_get_logo_menu_svg(  ) {
	return EcranNoirTwentyOne_Icons::get_svg('brand', 'logo', false);
}

function ecrannoir_twenty_one_add_menu_logo_args( $args, $item, $depth ) {
	if ( 0 === $depth && 'primary' === $args->theme_location) {
		$args->link_before = '';
		$args->link_after = '';
		$args->before = '';
		$args->after = '';
		if ('logo' === sanitize_title($item->title) ) {
			$blog_info = get_bloginfo( 'name' );
			if (is_front_page() || is_home()) {
				$args->before = '<div class="site-logo-menu">';
				$args->after = '</div>';
				$args->link_before = '<h1 class="site-logo">';
				$args->link_after = '<span class="screen-reader-text">' . $blog_info . '</span></h1>';
	
			} else {
				$args->before = '<div class="site-logo-menu">';
				$args->after = '</div>';
				$args->link_before = '<div class="site-logo">';
				$args->link_after = '<span class="screen-reader-text">' . $blog_info . '</span></div>';
			}
		}
	}
	return $args;
}
add_filter( 'nav_menu_item_args', 'ecrannoir_twenty_one_add_menu_logo_args', 10, 3 );

function ecrannoir_twenty_one_nav_menu_logo( $item_output, $item, $depth, $args ) {
	// Change SVG icon inside social links menu if there is supported URL.
	// if ( 0 === $depth && in_array( 'menu-item-has-children', $item->classes, true ) ) {
	if ( 'primary' === $args->theme_location && 0 === $depth && 'logo' === sanitize_title($item->title) ) {
		$svg = ecrannoir_twenty_one_get_logo_menu_svg();
		if ( ! empty( $svg ) ) {
			$item_output = str_replace( 'Logo<span class="screen-reader-text">', $svg . '<span class="screen-reader-text">', $item_output );
		}
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'ecrannoir_twenty_one_nav_menu_logo', 10, 4 );

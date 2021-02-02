<?php
/**
 * Block Styles
 *
 * @link https://developer.wordpress.org/reference/functions/register_block_style/
 *
 */

if ( function_exists( 'register_block_style' ) ) {
	/**
	 * Register block styles.
	 *
	 */
	function ecrannoir_twenty_one_register_block_styles() {
		// Columns: Overlap.
		register_block_style(
			'core/columns',
			array(
				'name'  => 'ecrannoirtwentyone-columns-overlap',
				'label' => esc_html__( 'Overlap', 'ecrannoirtwentyone' ),
			)
		);

		// Cover: Borders.
		register_block_style(
			'core/cover',
			array(
				'name'  => 'ecrannoirtwentyone-border',
				'label' => esc_html__( 'Borders', 'ecrannoirtwentyone' ),
			)
		);

		// Group: Borders.
		register_block_style(
			'core/group',
			array(
				'name'  => 'ecrannoirtwentyone-border',
				'label' => esc_html__( 'Borders', 'ecrannoirtwentyone' ),
			)
		);

		// Image: Borders.
		register_block_style(
			'core/image',
			array(
				'name'  => 'ecrannoirtwentyone-border',
				'label' => esc_html__( 'Borders', 'ecrannoirtwentyone' ),
			)
		);

		// Image: Frame.
		register_block_style(
			'core/image',
			array(
				'name'  => 'ecrannoirtwentyone-image-frame',
				'label' => esc_html__( 'Frame', 'ecrannoirtwentyone' ),
			)
		);

		// Latest Posts: Dividers.
		register_block_style(
			'core/latest-posts',
			array(
				'name'  => 'ecrannoirtwentyone-latest-posts-dividers',
				'label' => esc_html__( 'Dividers', 'ecrannoirtwentyone' ),
			)
		);

		// Latest Posts: Borders.
		register_block_style(
			'core/latest-posts',
			array(
				'name'  => 'ecrannoirtwentyone-latest-posts-borders',
				'label' => esc_html__( 'Borders', 'ecrannoirtwentyone' ),
			)
		);

		// Media & Text: Borders.
		register_block_style(
			'core/media-text',
			array(
				'name'  => 'ecrannoirtwentyone-border',
				'label' => esc_html__( 'Borders', 'ecrannoirtwentyone' ),
			)
		);

		// Separator: Thick.
		register_block_style(
			'core/separator',
			array(
				'name'  => 'ecrannoirtwentyone-separator-thick',
				'label' => esc_html__( 'Thick', 'ecrannoirtwentyone' ),
			)
		);

		// Social icons: Dark gray color.
		register_block_style(
			'core/social-links',
			array(
				'name'  => 'ecrannoirtwentyone-social-icons-color',
				'label' => esc_html__( 'Dark gray', 'ecrannoirtwentyone' ),
			)
		);
	}
	add_action( 'init', 'ecrannoir_twenty_one_register_block_styles' );
}

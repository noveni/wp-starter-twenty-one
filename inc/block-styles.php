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

		// Social icons: Dark gray color.
		// register_block_style(
		// 	'core/social-links',
		// 	array(
		// 		'name'  => 'ecrannoirtwentyone-social-icons-color',
		// 		'label' => esc_html__( 'Dark gray', 'ecrannoirtwentyone' ),
		// 	)
		// );
	}
	add_action( 'init', 'ecrannoir_twenty_one_register_block_styles' );
}

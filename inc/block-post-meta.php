<?php
/**
 * Register post meta.
 *
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( function_exists( 'register_meta' ) ) {
	/**
	 * Register block styles.
	 *
	 */
	function ecrannoir_twenty_one_register_meta() {

        register_meta(
			'post',
			'_ecrannoirtwentyone_title_hidden',
			array(
				'show_in_rest'  => true,
				'single'        => true,
				'type'          => 'boolean',
				'auth_callback' => function() {
					return current_user_can( 'edit_posts' );
				},
			)
		);
    }
    
    add_filter( 'init', 'ecrannoir_twenty_one_register_meta' );
}

<?php


function ecrannoir_twenty_one_render_cover_slider( $attributes, $content ) {
    if (is_admin()) {
        return;
    }

    $images = [];

    if( !empty($attributes['imageIds'])) {

    }

    $class = 'wp-block-ecrannoirtwentyone-quotes-slider has-green-white-background-color has-background';

    if ( isset( $attributes['align'] ) ) {
		$class .= ' align' . $attributes['align'];
	}

    if ( isset( $attributes['themeApparitionEffect'] ) ) {
		$class .= ' theme-anim-' . $attributes['themeApparitionEffect'];
	}

    
    ob_start(); ?>
    <div class="<?php echo $class; ?>">
    <?php echo $content; ?>
        <div>
        <?php 
        if( !empty($attributes['imageIds'])) :
            foreach ($attributes['imageIds'] as $id): ?>
                <img src="<?php echo wp_get_attachment_url($id); ?>" />
            <?php endforeach;
        endif;
        ?>

        </div>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Registers the `core/latest-posts` block on server.
 */
function ecrannoir_twenty_one_register_block_core_cover_slider() {
	register_block_type(
		'ecrannoirtwentyone/cover-slider',
		array(
            'attributes'      => array(
                'imageIds'                => array(
                    'type'  => 'array',
                ),
                'globalContent'             => array(
                    'type'    => 'string',
                    'default' => '',
                )
            ),
			'render_callback' => 'ecrannoir_twenty_one_render_cover_slider',
		)
	);
}
add_action( 'init', 'ecrannoir_twenty_one_register_block_core_cover_slider' );

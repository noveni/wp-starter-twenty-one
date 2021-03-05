<?php


function ecrannoir_twenty_one_render_cover_slider( $attributes, $content ) {
    if (is_admin()) {
        return;
    }

    $images = [];

    if( !empty($attributes['imageIds'])) {

    }

    $class = 'wp-block-ecrannoirtwentyone-cover-slider';

    if ( isset( $attributes['align'] ) ) {
		$class .= ' align' . $attributes['align'];
	}

    if ( isset( $attributes['themeApparitionEffect'] ) ) {
		$class .= ' theme-anim-' . $attributes['themeApparitionEffect'];
	}

    
    ob_start(); ?>
    <div class="<?php echo $class; ?>">
        <div class="wp-block-cover-slider__inner-container">
            <?php echo $content; ?>
        </div>
        <div class="block-cover-slider-wrapper">
        <?php if( !empty($attributes['imageIds'])) :?>
            <div class="block-cover-slider-gallery">
                <div class="glide__track" data-glide-el="track">
                    <div class="glide__slides">
                        <?php foreach ($attributes['imageIds'] as $id): ?>
                        <div class="glide__slide block-cover-slider-image">
                            <figure>
                                <img src="<?php echo wp_get_attachment_url($id); ?>" />
                            </figure>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div><!-- .glide__track -->
                <div class="glide__arrows" data-glide-el="controls">
                    <button class="glide__arrow glide__arrow--left" data-glide-dir="&gt;"><?php echo ecrannoir_twenty_one_get_icon_svg( 'ui', 'arrow_left'); ?></button>
                    <button class="glide__arrow glide__arrow--right" data-glide-dir="&lt;"><?php echo ecrannoir_twenty_one_get_icon_svg( 'ui', 'arrow_right'); ?></button>
                </div><!-- .glide__arrows -->
            </div>
        <?php endif; ?>
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

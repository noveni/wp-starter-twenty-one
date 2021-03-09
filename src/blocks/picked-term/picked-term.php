<?php

function ecrannoir_twenty_one_render_picked_term( $attributes, $content ) {
    if (!isset($attributes['termId'])) {
        return;
    }

    $term = get_term( $attributes['termId'], $attributes['taxonomy']);


    $style = 'style="';

    $style .= '"';

    $class = 'wp-block-ecrannoirtwentyone-picked-term';

    if ( isset( $attributes['align'] ) ) {
		$class .= ' align' . $attributes['align'];
	}

    if ( isset( $attributes['themeApparitionEffect'] ) ) {
		$class .= ' theme-anim-' . $attributes['themeApparitionEffect'];
	}

    $term_link = esc_url( get_term_link( $term ) );
    $title = $term->name;
        if ( ! $title ) {
            $title = __( '(no title)' );
        }
    
    $term_image = false;
    // if ( $attributes['displayImage'] ) {
    //     if (has_post_thumbnail( $term )) {
    //         $term_image = get_the_post_thumbnail( $term, 'post-thumbnail' );
    //     } else {
    //         $width = 621;
    //         $height = 803;
    //         $style = 'style="width:100%;height:' . round( 100 * $height / $width, 2 ) . '%;max-width:' . $width . 'px;" ';
    //         $url = get_template_directory_uri() . '/assets/img/placeholder.jpg';
    //         $imgClassName = "attachment-post-thumbnail size-post-thumbnail wp-post-image";
    //         $term_image = sprintf('<img src="%1$s" class="%2$s" alt="" %3$s>', $url, $imgClassName, $style );
    //     }
    // }

    ob_start(); ?>
    <div class="<?php echo $class; ?>" <?php echo $style; ?>>
        <?php
            
        ?>
        <article>
            <?php if ( $term_image ) : ?>
                <a href="<?php echo $term_link; ?>"><figure>
                <?php echo $term_image; ?>
                </figure></a>
            <?php endif; ?> 
            <header>
                <h3 class="post-title h2">
                    <a href="<?php echo $term_link; ?>"><?php echo $title; ?></a>
                </h3>
            </header>
            <?php if ($attributes['displayDescription']): ?>
                <?php echo $term->description; ?>
            <?php endif; ?> 
            <?php ecrannoir_twenty_one_block_button($term_link, esc_html__('Je découvre', 'ecrannoirtwentyone')); ?>
        </article>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Registers the `core/latest-posts` block on server.
 */
function ecrannoir_twenty_one_register_block_picked_term_block() {
	register_block_type(
		'ecrannoirtwentyone/picked-term',
		array(
            'attributes' => array(
                'termId' =>                 array(
                    'type'      => 'number'
                ),
                'taxonomy' =>               array(
                    'type'      => 'string',
                    'default'   => 'category'
                ),
                'displayDescription'            => array(
                    'type'      => 'boolean',
                    'default'   => true,
                ),
                'descriptionLength'             => array(
                    'type'      => 'number',
                    'default'   => 55,
                ),
                'displayImage' =>   array(
                    'type'      => 'boolean',
                    'default'   => true
                ),
                'showPostCounts' =>   array(
                    'type'      => 'boolean',
                    'default'   => false
                ),
            ),
			'render_callback' => 'ecrannoir_twenty_one_render_picked_term',
		)
	);
}
add_action( 'init', 'ecrannoir_twenty_one_register_block_picked_term_block' );

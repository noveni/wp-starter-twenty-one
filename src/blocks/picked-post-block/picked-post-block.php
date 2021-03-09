<?php

function ecrannoir_twenty_one_render_picked_post( $attributes, $content ) {
    if (is_admin()) {
        return;
    }

    if (!$attributes['postId']) {
        return;
    }

    $post = get_post( $attributes['postId']);


    $style = 'style="';

    $style .= '"';

    $class = 'wp-block-ecrannoirtwentyone-picked-post';

    if ( isset( $attributes['align'] ) ) {
		$class .= ' align' . $attributes['align'];
	}

    if ( isset( $attributes['themeApparitionEffect'] ) ) {
		$class .= ' theme-anim-' . $attributes['themeApparitionEffect'];
	}

    $post_link = esc_url( get_permalink( $post ) );
    $title = get_the_title( $post );
    if ( ! $title ) {
        $title = __( '(no title)' );
    }
    
    $featured_image = false;
    if ( $attributes['displayFeaturedImage'] ) {
        if (has_post_thumbnail( $post )) {
            $featured_image = get_the_post_thumbnail( $post, 'post-thumbnail' );
        } else {
            $width = 621;
            $height = 803;
            $style = 'style="width:100%;height:' . round( 100 * $height / $width, 2 ) . '%;max-width:' . $width . 'px;" ';
            $url = get_template_directory_uri() . '/assets/img/placeholder.jpg';
            $imgClassName = "attachment-post-thumbnail size-post-thumbnail wp-post-image";
            $featured_image = sprintf('<img src="%1$s" class="%2$s" alt="" %3$s>', $url, $imgClassName, $style );
        }
    }

    ob_start(); ?>
    <div class="<?php echo $class; ?>" <?php echo $style; ?>>
        <?php
            
        ?>
        <article>
            <?php if ( $featured_image ) : ?>
                <a href="<?php echo $post_link; ?>"><figure>
                <?php echo $featured_image; ?>
                </figure></a>
            <?php endif; ?> 
            <header>
                <h3 class="post-title h2">
                    <a href="<?php echo $post_link; ?>"><?php echo $title; ?></a>
                </h3>
            </header>
            <?php ecrannoir_twenty_one_block_button($post_link, esc_html__('Je découvre', 'ecrannoirtwentyone')); ?>
        </article>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Registers the `core/latest-posts` block on server.
 */
function ecrannoir_twenty_one_register_block_picked_post_block() {
	register_block_type(
		'ecrannoirtwentyone/picked-post',
		array(
            'attributes' => array(
                'postId' =>                 array(
                    'type'      => 'number'
                ),
                'postType' =>               array(
                    'type'      => 'string',
                    'default'   => 'post'
                ),
                'displayPostContent' =>     array(
                    'type'      => 'boolean',
                    'default'   => true
                ),
                'excerptLength' =>          array(
                    'type'      => 'number',
                    'default'   => 55
                ),
                'displayAuthor' =>          array(
                    'type'      => 'boolean',
                    'default'   => false
                ),
                'displayPostDate' =>        array(
                    'type'      => 'boolean',
                    'default'   => true
                ),
                'displayFeaturedImage' =>   array(
                    'type'      => 'boolean',
                    'default'   => true
                ),
            ),
			'render_callback' => 'ecrannoir_twenty_one_render_picked_post',
		)
	);
}
add_action( 'init', 'ecrannoir_twenty_one_register_block_picked_post_block' );

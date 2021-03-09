<?php


function ecrannoir_twenty_one_render_term_of_taxonomy( $attributes ) {
    
    // ec_dump($attributes['termsToShow']);
    $terms = get_terms( array(
        'number'            => $attributes['termsToShow'],
        'taxonomy'         => $attributes['taxonomy'],
        'order'            => $attributes['order'],
		'orderby'          => $attributes['orderBy'],
        'hide_empty'       => $attributes['hideEmpty'],
    ));

    $class = 'wp-block-ecrannoirtwentyone-term-of-taxonomy';

    if ( isset( $attributes['align'] ) ) {
		$class .= ' align' . $attributes['align'];
	}
	if ( isset( $attributes['postLayout'] ) && 'grid' === $attributes['postLayout'] ) {
		$class .= ' is-grid';
	}
    if ( isset( $attributes['themeApparitionEffect'] ) ) {
		$class .= ' theme-anim-' . $attributes['themeApparitionEffect'];
	}

    
    ob_start(); ?>
    <div class="<?php echo $class; ?>"> 
    <?php
    foreach ( $terms as $term ) :
        $term_link = esc_url( get_term_link( $term ) );
        $title = $term->name;
        if ( ! $title ) {
            $title = __( '(no title)' );
        }
        $description = $term->description;
        
        // $featured_image = false;
        // if ( $attributes['displayImage'] ) {
        //     if (has_post_thumbnail( $post )) {
        //         $featured_image = get_the_post_thumbnail( $post, 'post-thumbnail' );
        //     } else {
        //         $width = 621;
        //         $height = 803;
        //         $style = 'style="width:100%;height:' . round( 100 * $height / $width, 2 ) . '%;max-width:' . $width . 'px;" ';
        //         $url = get_template_directory_uri() . '/assets/img/placeholder.jpg';
        //         $imgClassName = "attachment-post-thumbnail size-post-thumbnail wp-post-image";
        //         $featured_image = sprintf('<img src="%1$s" class="%2$s" alt="" %3$s>', $url, $imgClassName, $style );
        //     }
        // }
        ?>
        <article>

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
        <?php
    endforeach;
    ?>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Registers the `core/latest-posts` block on server.
 */
function ecrannoir_twenty_one_register_block_term_of_taxonomy() {
	register_block_type(
		'ecrannoirtwentyone/term-of-taxonomy',
		array(
            'attributes'      => array(
                'taxonomy'                      => array(
                    'type'      => 'string',
                    'default'      => 'category',
                ),
                'termsToShow'                   => array(
                    'type'      => 'number',
                    'default'   => 9,
                ),
                'displayDescription'            => array(
                    'type'      => 'boolean',
                    'default'   => true,
                ),
                'descriptionLength'             => array(
                    'type'      => 'number',
                    'default'   => 55,
                ),
                'displayImage'           => array(
                    'type'      => 'boolean',
                    'default'   => false,
                ),
                'showPostCounts'                   => array(
                    'type'      => 'boolean',
                    'default'   => false,
                ),
                'hideEmpty'         => array(
                    'type'    => 'boolean',
                    'default' => false,
                ),
                'postLayout'              => array(
                    'type'    => 'string',
                    'default' => 'list',
                ),
                'order'                   => array(
                    'type'    => 'string',
                    'default' => 'desc',
                ),
                'orderBy'                 => array(
                    'type'    => 'string',
                    'default' => 'date',
                )
            ),
			'render_callback' => 'ecrannoir_twenty_one_render_term_of_taxonomy',
		)
	);
}
add_action( 'init', 'ecrannoir_twenty_one_register_block_term_of_taxonomy' );

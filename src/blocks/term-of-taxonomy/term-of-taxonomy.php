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
        $term_description = $term->description;
        
        $term_image = false;
        if ( $attributes['displayImage'] ) {
            $image_id = get_term_meta( $term->term_id, 'ecrannoirtwentyone-img', true );
            if( $image = wp_get_attachment_image_src( $image_id ) ) {
                $term_image = '<img src="' . $image[0] . '" />';
            } else {
                $term_image = ecrannoir_twenty_one_get_image_placeholder();
            }
        }
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
            <?php if ($term_description): ?>
                <?php echo $term_description; ?>
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

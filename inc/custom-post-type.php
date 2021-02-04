<?php
/**
 * Custom Post Type for theme
 *
 */

function ecrannoir_twenty_one_get_default_post_type_config() {
    $ecrannoir_default_post_type = array(
        'public'                    => true,
        'hierarchical'              => false,
        'exclude_from_search'       => false,
        'publicly_queryable'        => true,
        'show_ui'                   => true,
        'show_in_menu'              => true,
        'show_in_admin_bar'         => true,
        'show_in_rest'              => true,
        'menu_position'             => 5, // 10 - below Media,
        'menu_icon'                 => 'dashicons-admin-post',
        'capability_type'           => 'post',
        'supports'                  => array(
            'title',
            'editor',
            'thumbnail',
            'excerpt',
            'page-attributes',
        ),
        // 'taxonomies'                => array(),
        'has_archive'               => true,
        // 'rewrite'                   => array(
        //     'slug'       => 'custom-post-type',
        //     'with_front' => false,
        // ),
    );

    return $ecrannoir_default_post_type;
}

function ecrannoir_twenty_one_register_example() {
    $post_type_name = 'ec_example';
    
    $labels = array(
        'name'                      => __( 'Examples', 'ecrannoirtwentyone' ),
        'singular_name'             => __( 'Example', 'ecrannoirtwentyone' ),
        'add_new_item'              => __( 'Ajout un nouvel Example', 'ecrannoirtwentyone' ),
        'edit_item'                 => __( 'Modifier l\'Example', 'ecrannoirtwentyone' ),
        'new_item'                  => __( 'Nouvel Example', 'ecrannoirtwentyone' ),
        'view_item'                 => __( 'Voir l\'Example', 'ecrannoirtwentyone' ),
        'view_items'                => __( 'Voir les Examples', 'ecrannoirtwentyone' ),
        'search_items'              => __( 'Rechercher des Examples', 'ecrannoirtwentyone' ),
        'not_found'                 => __( 'Aucun Example trouvée', 'app' ),
        'not_found_in_trash'        => __( 'Aucun Example trouvée dans la corbeille', 'app' ),
        'all_items'                 => __( 'Tous les Examples', 'ecrannoir'),
    );

    $config = array(
        'label'     => 'Examples',
        'labels'    => $labels,
        'rewrite'                   => array(
            'slug'       => 'ec-example',
            'with_front' => false,
        ),
    );

    $post_type_args = wp_parse_args( $config, ecrannoir_twenty_one_get_default_post_type_config() );

    register_post_type( $post_type_name, $post_type_args);
}

function ecrannoir_twenty_one_custom_post_type() {
    ecrannoir_twenty_one_register_example();
}

// ecrannoir_twenty_one_custom_post_type();
add_action('init', 'ecrannoir_twenty_one_custom_post_type');

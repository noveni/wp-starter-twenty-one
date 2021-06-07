<?php

/**
 * Ecrannoir Twenty One Woocommerce
 * 
 * 
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly


class EcranNoirTwentyOne_WooCommerce {

    /**
     * Setup class.
     *
     * @since 1.0
     */
    public function __construct() {

        add_action( 'after_setup_theme', array( $this, 'setup' ) );
        add_filter( 'body_class', array( $this, 'woocommerce_body_class' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'woocommerce_scripts' ), 20 );
        add_filter( 'woocommerce_output_related_products_args', array( $this, 'related_products_args' ) );
        add_filter( 'woocommerce_product_thumbnails_columns', array( $this, 'thumbnail_columns' ) );
        add_filter( 'woocommerce_breadcrumb_defaults', array( $this, 'change_breadcrumb_delimiter' ) );

        // Integrations.
        add_action( 'storefront_woocommerce_setup', array( $this, 'setup_integrations' ) );

        // Instead of loading Core CSS files, we only register the font families.
        add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
        add_filter( 'wp_enqueue_scripts', array( $this, 'add_core_fonts' ), 130 );
    }
    /**
     * Sets up theme defaults and registers support for various WooCommerce features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     *
     * @since 2.4.0
     * @return void
     */
    public function setup() {
        add_theme_support(
            'woocommerce',
            array(
                'single_image_width'    => 416,
                'thumbnail_image_width' => 416,
                'gallery_thumbnail_image_width' => 416,
                'product_grid'          => array(
                    'default_columns' => 4,
                    'default_rows'    => 4,
                    'min_columns'     => 4,
                    'max_columns'     => 4,
                    'min_rows'        => 1,
                ),
            )
        );

        // add_theme_support( 'wc-product-gallery-zoom' );
        // add_theme_support( 'wc-product-gallery-lightbox' );
        add_theme_support( 'wc-product-gallery-slider' );

        /**
         * Add 'ecrannoirtwentyone_woocommerce_setup' action.
         *
         * @since  2.4.0
         */
        do_action( 'ecrannoirtwentyone_woocommerce_setup' );
    }

    /**
     * Add CSS in <head> to register WooCommerce Core fonts.
     *
     * @since 3.4.0
     * @return void
     */
    public function add_core_fonts() {
        $fonts_url = plugins_url( '/woocommerce/assets/fonts/' );
        wp_add_inline_style(
            'ecrannoirtwentyone-woocommerce-styles',
            '@font-face {
            font-family: star;
            src: url(' . $fonts_url . '/star.eot);
            src:
                url(' . $fonts_url . '/star.eot?#iefix) format("embedded-opentype"),
                url(' . $fonts_url . '/star.woff) format("woff"),
                url(' . $fonts_url . '/star.ttf) format("truetype"),
                url(' . $fonts_url . '/star.svg#star) format("svg");
            font-weight: 400;
            font-style: normal;
        }
        @font-face {
            font-family: WooCommerce;
            src: url(' . $fonts_url . '/WooCommerce.eot);
            src:
                url(' . $fonts_url . '/WooCommerce.eot?#iefix) format("embedded-opentype"),
                url(' . $fonts_url . '/WooCommerce.woff) format("woff"),
                url(' . $fonts_url . '/WooCommerce.ttf) format("truetype"),
                url(' . $fonts_url . '/WooCommerce.svg#WooCommerce) format("svg");
            font-weight: 400;
            font-style: normal;
        }'
        );
    }

    /**
     * Add WooCommerce specific classes to the body tag
     *
     * @param  array $classes css classes applied to the body tag.
     * @return array $classes modified to include 'woocommerce-active' class
     */
    public function woocommerce_body_class( $classes ) {
        $classes[] = 'woocommerce-active';

        // Remove `no-wc-breadcrumb` body class.
        $key = array_search( 'no-wc-breadcrumb', $classes, true );

        if ( false !== $key ) {
            unset( $classes[ $key ] );
        }

        return $classes;
    }

    /**
     * WooCommerce specific scripts & stylesheets
     *
     * @since 1.0.0
     */
    public function woocommerce_scripts() {
        global $storefront_version;

        $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

        EcranNoirTwentyOne_Scripts::toEnqueueStyle('woocommerce');
    }

    /**
     * Related Products Args
     *
     * @param  array $args related products args.
     * @since 1.0.0
     * @return  array $args related products args
     */
    public function related_products_args( $args ) {
        $args = array(
            'posts_per_page' => 4,
            'columns'        => 4,
        );

        return $args;
    }

    /**
     * Product gallery thumbnail columns
     *
     * @return integer number of columns
     * @since  1.0.0
     */
    public function thumbnail_columns() {
        $columns = 4;

        return intval( $columns );
    }

    /**
     * Remove the breadcrumb delimiter
     *
     * @param  array $defaults The breadcrumb defaults.
     * @return array           The breadcrumb defaults.
     * @since 2.2.0
     */
    public function change_breadcrumb_delimiter( $defaults ) {
        $defaults['delimiter']   = '<span class="breadcrumb-separator"> / </span>';
        $defaults['wrap_before'] = '<div class="ecrannoirtwentyone-breadcrumb"><div class="col-full"><nav class="woocommerce-breadcrumb" aria-label="' . esc_attr__( 'breadcrumbs', 'ecrannoirtwentyone' ) . '">';
        $defaults['wrap_after']  = '</nav></div></div>';
        return $defaults;
    }

    /*
    |--------------------------------------------------------------------------
    | Integrations.
    |--------------------------------------------------------------------------
    */

    /**
     * Sets up integrations.
     *
     * @since  2.3.4
     *
     * @return void
     */
    public function setup_integrations() {

    }
}

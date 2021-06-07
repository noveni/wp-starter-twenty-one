<?php
/**
 * WooCommerce Template Functions.
 *
 */

if ( ! function_exists( 'ecrannoirtwentyone_woo_cart_available' ) ) {
	/**
	 * Validates whether the Woo Cart instance is available in the request
	 *
	 * @since 2.6.0
	 * @return bool
	 */
	function ecrannoirtwentyone_woo_cart_available() {
		$woo = WC();
		return $woo instanceof \WooCommerce && $woo->cart instanceof \WC_Cart;
	}
}

if ( ! function_exists( 'ecrannoirtwentyone_before_content' ) ) {
	/**
	 * Before Content
	 * Wraps all WooCommerce content in wrappers which match the theme markup
	 *
	 * @since   1.0.0
	 * @return  void
	 */
	function ecrannoirtwentyone_before_content() {
		?>
		<div id="ecrannoirtwentyone-wc-main" class="entry-content">
		<?php
	}
}

if ( ! function_exists( 'ecrannoirtwentyone_after_content' ) ) {
	/**
	 * After Content
	 * Closes the wrapping divs
	 *
	 * @since   1.0.0
	 * @return  void
	 */
	function ecrannoirtwentyone_after_content() {
		?>
		</div><!-- #ecrannoirtwentyone-wc-main -->

		<?php
	}
}



if ( ! function_exists( 'ecrannoirtwentyone_product_loop_start' ) ) {
	function ecrannoirtwentyone_product_loop_start($dd) {
		return '<div class="products-grid-wrapper alignwide"><ul class="products columns">';
	}
}

if ( ! function_exists( 'ecrannoirtwentyone_product_loop_end' ) ) {
	/**
	 * Cart Fragments
	 * Ensure cart contents update when products are added to the cart via AJAX
	 *
	 * @param  array $fragments Fragments to refresh via AJAX.
	 * @return array            Fragments to refresh via AJAX
	 */
	function ecrannoirtwentyone_product_loop_end( $fragments ) {
		return '</ul></div>';
	}
}

if ( ! function_exists( 'ecrannoirtwentyone_woocommerce_post_class' ) ) {
	/**
	 * Cart Fragments
	 * Ensure cart contents update when products are added to the cart via AJAX
	 *
	 * @param  array $fragments Fragments to refresh via AJAX.
	 * @return array            Fragments to refresh via AJAX
	 */
	function ecrannoirtwentyone_woocommerce_post_class( $classes ) {
		$classes[] = 'alignwide';
		return $classes;
	}
}

if ( ! function_exists( 'ecrannoirtwentyone_wrap_product_image_start' ) ) {
	function ecrannoirtwentyone_wrap_product_image_start() {
		?>
		<div class="product-image-wrapper">
		<?php
	}
}

if ( ! function_exists( 'ecrannoirtwentyone_wrap_product_image_end' ) ) {
	function ecrannoirtwentyone_wrap_product_image_end() {
		?>
		</div><!-- .product-image-wrapper -->
		<?php
	}
}

if ( ! function_exists( 'ecrannoirtwentyone_wrap_single_product_top_start' ) ) {
	function ecrannoirtwentyone_wrap_single_product_top_start()
	{
		?>
		<div class="product-top-wrapper">
		<?php
	}
}
if ( ! function_exists( 'ecrannoirtwentyone_wrap_single_product_top_end' ) ) {
	function ecrannoirtwentyone_wrap_single_product_top_end()
	{
		?>
		</div><!-- .product-top-wrapper -->
		<?php
	}
}

// TODO Remove or refactor, JS is actualy doing the job
if ( ! function_exists( 'ecrannoirtwentyone_dropdown_variation_attribute_select_to_radio' ) ) {
	function ecrannoirtwentyone_dropdown_variation_attribute_select_to_radio( $html, $args )
	{

		if ($args['attribute'] !== 'pa_taille') {
			return $html;
		}

		// Get selected value.
		if ( false === $args['selected'] && $args['attribute'] && $args['product'] instanceof WC_Product ) {
			$selected_key = 'attribute_' . sanitize_title( $args['attribute'] );
			// phpcs:disable WordPress.Security.NonceVerification.Recommended
			$args['selected'] = isset( $_REQUEST[ $selected_key ] ) ? wc_clean( wp_unslash( $_REQUEST[ $selected_key ] ) ) : $args['product']->get_variation_default_attribute( $args['attribute'] );
			// phpcs:enable WordPress.Security.NonceVerification.Recommended
		}

		$options               = $args['options'];
		$product               = $args['product'];
		$attribute             = $args['attribute'];
		$name                  = $args['name'] ? $args['name'] : 'attribute_' . sanitize_title( $attribute );
		$id                    = $args['id'] ? $args['id'] : sanitize_title( $attribute );
		$class                 = $args['class'];
		$show_option_none      = false;
		$show_option_none_text = $args['show_option_none'] ? $args['show_option_none'] : __( 'Choose an option', 'woocommerce' ); // We'll do our best to hide the placeholder, but we'll need to show something when resetting options.

		if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
			$attributes = $product->get_variation_attributes();
			$options    = $attributes[ $attribute ];
		}

		$html  = '<div id="' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . '" data-attribute_name="attribute_' . esc_attr( sanitize_title( $attribute ) ) . '" data-show_option_none="' . ( $show_option_none ? 'yes' : 'no' ) . '">';
		$html .= '<div><label>' . esc_html( $show_option_none_text ) . '<input type="radio" value=""></label></div>';

		if ( ! empty( $options ) ) {
			if ( $product && taxonomy_exists( $attribute ) ) {
				// Get terms if this is a taxonomy - ordered. We need the names too.
				$terms = wc_get_product_terms(
					$product->get_id(),
					$attribute,
					array(
						'fields' => 'all',
					)
				);

				foreach ( $terms as $term ) {
					if ( in_array( $term->slug, $options, true ) ) {
						$html .= '<div>';
						$html .= '<label>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name, $term, $attribute, $product ) );
						$html .=  '<input type="radio" data-attribute_name="attribute_' . esc_attr( sanitize_title( $attribute ) ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $term->slug ) . '" ' . checked( sanitize_title( $args['selected'] ), $term->slug, false ) . '>';
						$html .= '</label></div>';
					}
				}
			} else {
				foreach ( $options as $option ) {
					$html .= '<div>';
					$html .= '<label>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option, null, $attribute, $product ) );
					$html .=  '<input type="radio" data-attribute_name="attribute_' . esc_attr( sanitize_title( $attribute ) ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $option ) . '" ' . checked( $args['selected'], sanitize_title( $option ), false ) . '>';
					$html .= '</label></div>';
					// This handles < 2.4.0 bw compatibility where text attributes were not sanitized.
					// $selected = sanitize_title( $args['selected'] ) === $args['selected'] ? selected( $args['selected'], sanitize_title( $option ), false ) : selected( $args['selected'], $option, false );
					// $html    .= '<option value="' . esc_attr( $option ) . '" ' . $selected . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option, null, $attribute, $product ) ) . '</option>';
				}
			}
		}
		$html .= '</div>';

		return $html;
	}
}

if ( ! function_exists( 'ecrannoirtwentyone_add_label_before_single_product_quantity_input' ) ) {
	// Add Label Before Quantity 
	function ecrannoirtwentyone_add_label_before_single_product_quantity_input()
	{
		?>
		<label class="label_quantity">Quantité: </label>
		<?php
	}
}

if ( ! function_exists( 'ecrannoirtwentyone_add_plusminus_button_product_quantity_input' ) ) {
	// Add Minus And Plus sign before quantity input btn
	function ecrannoirtwentyone_add_plusminus_button_product_quantity_input()
	{
		?>
		<button type="button" class="qty-btn-number" onclick="this.parentNode.querySelector('[type=number]').stepDown();">&#8722;</button>
		<button type="button" class="qty-btn-number" onclick="this.parentNode.querySelector('[type=number]').stepUp();">&#43;</button>
		<?php
	}
}

if ( ! function_exists( 'ecrannoirtwentyone_wrap_quantiy_and_add_to_cart_btn_together_before' ) ) {
	function ecrannoirtwentyone_wrap_quantiy_and_add_to_cart_btn_together_before() {
		?>
		<div class="ecrannoirtwentyone_wrap_qty_and_add_to_cart">
		<?php
	}
}
if ( ! function_exists( 'ecrannoirtwentyone_wrap_quantiy_and_add_to_cart_btn_together_after' ) ) {
	function ecrannoirtwentyone_wrap_quantiy_and_add_to_cart_btn_together_after() {
		?>
		</div>
		<?php
	}
}

// Store Data Of Custom Tab
function ecrannoirtwentyone_product_custom_tab_info()
{
	$product_meta_data = array( 
		'ecrannoirtwentyone_product_size_details' => array(
			'tab_title' => 'Les tailles',
			'product_panel_field_description' => 'Informations complémentaires sur les tailles',
			'type' => 'text_area'
		),
		'ecrannoirtwentyone_product_size_entretien' => array(
			'tab_title' => 'L\'entretien',
			'product_panel_field_description' => 'Informations complémentaires sur l\'entretien',
			'type' => 'text_area'
		), 
		'ecrannoirtwentyone_product_livraison' => array(
			'tab_title' => 'La livraison',
			'product_panel_field_description' => 'Informations complémentaires sur la livraison',
			'type' => 'text_area'
		)
	);

	return $product_meta_data;
}

// Admin: Custom fn to display product custom field
function ecrannoir_product_meta_field($field_id, $type, $title, $description = '')
{
	$field = array(
		'id'          => $field_id,
		'value'       => get_post_meta( get_the_ID(), $field_id, true ),
		'label'       => $title,
	);
	if ($description && $description !== '') {
		$field['desc_tip'] = true;
		$field['description'] = $description;
	}

	if ($type === 'textarea' || $type === 'text_area') {
		woocommerce_wp_textarea_input( $field );
	}
}

if ( ! function_exists( 'ecrannoirtwentyone_product_custom_tab' ) ) {

	function ecrannoirtwentyone_product_custom_tab( $tabs )
	{
		// return $tabs;
		// $tabs['ecrannoirtwentyone_panel_product_data_front_tab'] = array(
		// 	'title'    => 'About Misha',
		// 	'callback' => 'ecrannoirtwentyone_product_custom_tab_content', // the function name, which is on line 15
		// 	'priority' => 50,
		// );

		unset( $tabs['description'] );
		unset( $tabs['additional_information'] );
		unset( $tabs['reviews'] );
		$prod_id = get_the_ID();
		foreach(ecrannoirtwentyone_product_custom_tab_info() as $key_field => $field) {

			$content = get_post_meta($prod_id, $key_field, true);
			if ($content !== '') {
				$tabs[$key_field] = array(
					'title'    => $field['tab_title'],
					'callback' => 'ecrannoirtwentyone_product_custom_tab_content', // the function name, which is on line 15
					'priority' => 50,
				);
			}
		}
	 
		return $tabs;
	}
}

if ( ! function_exists( 'ecrannoirtwentyone_product_custom_tab_content' ) ) {
	function ecrannoirtwentyone_product_custom_tab_content( $slug, $tab ) {
	
		$prod_id = get_the_ID();
		foreach(ecrannoirtwentyone_product_custom_tab_info() as $key_field => $field) {
			if ($key_field === $slug) {
				// echo '<h2>' . $field['tab_title'] . '</h2>';
				$content = get_post_meta($prod_id, $key_field, true);
				if ($content !== '') {
					echo '<p>' . $content . '</p>';
				}
			}
		}
	
	}
}

// Admin: Product Panel Group
if ( ! function_exists( 'ecrannoirtwentyone_product_settings_tabs' ) ) {
	function ecrannoirtwentyone_product_settings_tabs( $tabs ) {
		$tabs['ecrannoirtwentyone_panel_product_data'] = array(
			'label'    => 'Paulette Infos ',
			'target'   => 'ecrannoirtwentyone_product_data',
			// 'class'    => array('show_if_virtual'),
			'priority' => 21,
		);
		return $tabs;
	}
}

// Admin: Product Panel fields
if ( ! function_exists( 'ecrannoirtwentyone_product_panels' ) ) {
	function ecrannoirtwentyone_product_panels() {

		echo '<div id="ecrannoirtwentyone_product_data" class="panel woocommerce_options_panel">';

		foreach(ecrannoirtwentyone_product_custom_tab_info() as $key_field => $field) {
			ecrannoir_product_meta_field($key_field, $field['type'], $field['tab_title'], $field['product_panel_field_description']);
		}
		echo '</div>';
	}
}

// Admin: Save Product Meta
function ecrannoirtwentyone_process_product_panels_meta( $id, $post )
{
	$product_meta_ids = ecrannoirtwentyone_product_custom_tab_info();

	foreach ( $product_meta_ids as $meta_key => $data ) {
		if( !empty( $_POST[$meta_key] ) ) {
			update_post_meta( $id, $meta_key, esc_html($_POST[$meta_key]) );
		} else {
			delete_post_meta( $id, $meta_key );
		}
	}
}


	// turn variation dropdowns into radios
if ( ! function_exists( 'variation_radio_buttons' ) ) {
	function variation_radio_buttons($html, $args) {
		$args = wp_parse_args(apply_filters('woocommerce_dropdown_variation_attribute_options_args', $args), array(
		'options'          => false,
		'attribute'        => false,
		'product'          => false,
		'selected'         => false,
		'name'             => '',
		'id'               => '',
		'class'            => '',
		'show_option_none' => __('Choose an option', 'woocommerce'),
		));
		if(false === $args['selected'] && $args['attribute'] && $args['product'] instanceof WC_Product) {
			$selected_key     = 'attribute_'.sanitize_title($args['attribute']);
			$args['selected'] = isset($_REQUEST[$selected_key]) ? wc_clean(wp_unslash($_REQUEST[$selected_key])) : $args['product']->get_variation_default_attribute($args['attribute']);
		}
		$options               = $args['options'];
		$product               = $args['product'];
		$attribute             = $args['attribute'];
		$name                  = $args['name'] ? $args['name'] : 'attribute_'.sanitize_title($attribute);
		$id                    = $args['id'] ? $args['id'] : sanitize_title($attribute);
		$class                 = $args['class'];
		$show_option_none      = (bool)$args['show_option_none'];
		$show_option_none_text = $args['show_option_none'] ? $args['show_option_none'] : __('Choose an option', 'woocommerce');
		if(empty($options) && !empty($product) && !empty($attribute)) {
			$attributes = $product->get_variation_attributes();
			$options    = $attributes[$attribute];
		}
		$radios = '';
		if(!empty($options)) {
			if($product && taxonomy_exists($attribute)) {
				$terms = wc_get_product_terms($product->get_id(), $attribute, array(
					'fields' => 'all',
				));
				foreach($terms as $term) {
					if(in_array($term->slug, $options, true)) {
						$radios .= '
							'.esc_html(apply_filters('woocommerce_variation_option_name', $term->name)).'
						';
					}
				}
			} else {
				foreach($options as $option) {
					$checked    = sanitize_title($args['selected']) === $args['selected'] ? checked($args['selected'], sanitize_title($option), false) : checked($args['selected'], $option, false);
					$radios    .= '
					'.esc_html(apply_filters('woocommerce_variation_option_name', $option)).'
					';
				}
			}
		}
		$radios .= '
		';
		return $html.$radios;
	}
}

if ( ! function_exists( 'variation_check' ) ) {
	function variation_check($active, $variation) {
		if(!$variation->is_in_stock() && !$variation->backorders_allowed()) {
			return false;
		}
		return $active;
	}
}


if ( ! function_exists( 'ecrannoirtwentyone_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments
	 * Ensure cart contents update when products are added to the cart via AJAX
	 *
	 * @param  array $fragments Fragments to refresh via AJAX.
	 * @return array            Fragments to refresh via AJAX
	 */
	function ecrannoirtwentyone_cart_link_fragment( $fragments ) {
		global $woocommerce;

		ob_start();
		ecrannoirtwentyone_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		ob_start();
		ecrannoirtwentyone_handheld_footer_bar_cart_link();
		$fragments['a.footer-cart-contents'] = ob_get_clean();

		return $fragments;
	}
}

if ( ! function_exists( 'ecrannoirtwentyone_mini_cart_fragment_title' ) ) {
	function ecrannoirtwentyone_mini_cart_fragment_title()
	{
		?>
		<h4 class="has-text-align-center"><?php esc_html_e( 'Mon panier', 'storefront' ); ?><span class="count"><?php echo wp_kses_data( sprintf( '&nbsp;(%d)', WC()->cart->get_cart_contents_count() ) ); ?></span></h4>
		<?
	}
}

if ( ! function_exists( 'ecrannoirtwentyone_widget_shopping_cart_subtotal' ) ) {
	/**
	 * Output to view cart subtotal.
	 *
	 * @since 3.7.0
	 */
	function ecrannoirtwentyone_widget_shopping_cart_subtotal() {
		echo '<strong>' . esc_html__( 'Total Articles:&nbsp;', 'woocommerce' ) . WC()->cart->get_cart_subtotal() . '</strong> '; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}


if ( ! function_exists( 'ecrannoirtwentyone_handheld_footer_bar_cart_link' ) ) {
	/**
	 * The cart callback function for the handheld footer bar
	 *
	 * @since 2.0.0
	 */
	function ecrannoirtwentyone_handheld_footer_bar_cart_link() {
		if ( ! ecrannoirtwentyone_woo_cart_available() ) {
			return;
		}
		?>
			<a class="footer-cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>"><?php esc_html_e( 'Cart', 'storefront' ); ?>
				<span class="count"><?php echo wp_kses_data( WC()->cart->get_cart_contents_count() ); ?></span>
			</a>
		<?php
	}
}

if ( ! function_exists( 'ecrannoirtwentyone_cart_link' ) ) {
	/**
	 * Cart Link
	 * Displayed a link to the cart including the number of items present and the cart total
	 *
	 * @return void
	 * @since  1.0.0
	 */
	function ecrannoirtwentyone_cart_link() {
		if ( ! ecrannoirtwentyone_woo_cart_available() ) {
			return;
		}
		?>
			<a class="cart-contents" href="<?php echo esc_url( wc_get_checkout_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'ecrannoirtwentyone' ); ?>">
				<?php /* translators: %d: number of items in cart */ ?>
				<span class="header-wc-menu-icon count"><?php echo wp_kses_data( WC()->cart->get_cart_contents_count() ); ?></span>
				<span class="header-wc-menu-label"><?php _e('Panier', 'ecrannoirtwentyone'); ?></span>
			</a>
		<?php
	}
}


if ( ! function_exists( 'ecrannoirtwentyone_skip_cart_redirect_checkout' ) ) {
	/**
	 * Redirect Cart page to Checkout page
	 * Requires WooCommerce Brands.
	 *
	 */
	function ecrannoirtwentyone_skip_cart_redirect_checkout( $url ) {
		return wc_get_checkout_url();
	}
}

if ( ! function_exists( 'ecrannoirtwentyone_cart_redirect_checkout' ) ) {
	/**
	 * Redirect Cart page to Checkout page
	 * Requires WooCommerce Brands.
	 *
	 */
	function ecrannoirtwentyone_cart_redirect_checkout( ) {
		if ( !is_cart() ) return;

		global $woocommerce;

		if ( $woocommerce->cart->is_empty() ) {
			// If empty cart redirect to home
			wp_redirect( get_home_url() );
			exit();
		} else {
			// Else redirect to check out url
			wp_redirect( wc_get_checkout_url(), 302 );
		}
		
		exit;
	}
}

if ( ! function_exists( 'ecrannoirtwentyone_checkout_wrapper_row_start' ) ) {
	function ecrannoirtwentyone_checkout_wrapper_row_start() {
		?>
		<div class="wrapper-checkout-row">
		<?php
	}
}

if ( ! function_exists( 'ecrannoirtwentyone_checkout_add_next_step_button' ) ) {
	function ecrannoirtwentyone_checkout_add_next_step_button() {
		ecrannoir_twenty_one_block_button("#shipping-step", "Suivant", 'fill', 'order-review-custom-btn');
	}
}

if ( ! function_exists( 'ecrannoirtwentyone_checkout_wrapper_row_end' ) ) {
	function ecrannoirtwentyone_checkout_wrapper_row_end() {
		?>
		</div><!-- .wrapper-checkout-row -->
		<?php
	}
}

if ( ! function_exists( 'ecrannoirtwentyone_checkout_billing_title' ) ) {
	function ecrannoirtwentyone_checkout_billing_title()
	{
		?>
		<h4 class="ecrannoirtwentyone-checkout-numbered-step"><?php esc_html_e( 'Je crée mon compte', 'woocommerce' ); ?></h4>
		<?php
	}
}

if ( ! function_exists( 'ecrannoirtwentyone_wrapper_checkout_order_review_before' ) ) {
	function ecrannoirtwentyone_wrapper_checkout_order_review_before()
	{
		?>
		<div class="wrapper-order-review">
		<?php
	}
}

if ( ! function_exists( 'ecrannoirtwentyone_wrapper_checkout_order_review_after' ) ) {
	function ecrannoirtwentyone_wrapper_checkout_order_review_after()
	{
		?>
		</div><!-- .wrapper-order-review -->
		<?php
	}
}

if ( ! function_exists( 'ecrannoirtwentyone_checkout_order_review_title' ) ) {
	function ecrannoirtwentyone_checkout_order_review_title()
	{
		?>
		<h4><?php esc_html_e( 'Récapitulatif', 'woocommerce' ); ?></h4>
		<?php
	}
}

if ( ! function_exists( 'ecrannoirtwentyone_checkout_order_review_add_order_button' ) ) {
	function ecrannoirtwentyone_checkout_order_review_add_order_button()
	{
		?>
		<tr>
			<td colspan="2">
				<?php	
					ecrannoir_twenty_one_block_button("#payments-step", "Commander", 'fill', 'order-review-custom-btn');
				?>
			</td>
		</tr>
		<?php
	}
}

if ( ! function_exists( 'ecrannoirtwentyone_checkout_step_block_second' ) ) {
	function ecrannoirtwentyone_checkout_step_block_second() {
		?>
		<div class="checkout-step-second">
			<h4 id="shipping-step" class="ecrannoirtwentyone-checkout-numbered-step"><?php esc_html_e( 'Livraison', 'woocommerce' ); ?></h4>
			<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
			<table class="ecrannoirtwentyone-woocommerce-shipping-totals">
			<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

			<?php wc_cart_totals_shipping_html(); ?>

			<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>
			</table>
			<?php endif; ?>
			<?php
				do_action( 'ecrannoirtwentyone_checkout_step_second' );
			?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'ecrannoirtwentyone_checkout_step_block_third' ) ) {
	function ecrannoirtwentyone_checkout_step_block_third() {
		?>
		<div class="checkout-step-third">
			<h4 class="ecrannoirtwentyone-checkout-numbered-step" id="payments-step"><?php esc_html_e( 'Paiement', 'woocommerce' ); ?></h4>
			<?php
				do_action( 'ecrannoirtwentyone_checkout_step_third' );
			?>
		</div>
		<?php
	}
}


if ( ! function_exists( 'ecrannoirtwentyone_popular_products' ) ) {
	/**
	 * Display Featured Products
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @since  1.0.0
	 * @param array $args the product section args.
	 * @return void
	 */
	function ecrannoirtwentyone_popular_products( $args = array() ) {
		$args = apply_filters(
			'ecrannoirtwentyone_popular_products_args',
			array(
				'limit'      => 4,
				'columns'    => 4,
				'orderby'    => 'rating',
				'order'      => 'desc',
				'title'      => __( 'Vous aimerez également', 'ecrannoirtwentyone' ),
			)
		);

		$shortcode_content = ecrannoirtwentyone_do_shortcode(
			'products',
			apply_filters(
				'ecrannoirtwentyone_popular_products_shortcode_args',
				array(
					'per_page'   => intval( $args['limit'] ),
					'columns'    => intval( $args['columns'] ),
					'orderby'    => esc_attr( $args['orderby'] ),
					'order'      => esc_attr( $args['order'] ),
				)
			)
		);

		/**
		 * Only display the section if the shortcode returns products
		 */
		if ( false !== strpos( $shortcode_content, 'product' ) ) {
			?>
			<div class="wp-block-group alignfull is-style-ecrannoirtwentyone-group-horizontal-product-section has-rose-light-background-color has-background">
				<div class="wp-block-group__inner-container">
					<div class="wp-block-columns alignwide">
						<div class="wp-block-column" style="flex-basis:24%">
							<h2 class="section-title"><?php echo wp_kses_post( $args['title'] ); ?></h2>
						</div>
						<div class="wp-block-column" style="flex-basis:73%">
						<?php do_action( 'ecrannoirtwentyone_homepage_before_popular_products' ); ?>
						<?php echo $shortcode_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php do_action( 'ecrannoirtwentyone_homepage_after_popular_products' ); ?>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'ecrannoirtwentyone_add_product_item_link_to_btn' ) ) {
	function ecrannoirtwentyone_add_product_item_link_to_btn() {
		global $product;

		$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
		ecrannoir_twenty_one_block_button(esc_url( $link ), 'Je découvre', is_shop() ? '' : 'line-left', '', array('parent_class' => 'aligncenter'));
	}
}

if ( ! function_exists( 'ecrannoirtwentyone_add_link_to_product_grid_item' ) ) {
	/**
	 * woocommerce_blocks_product_grid_item_html Filter
	 */
	function ecrannoirtwentyone_add_link_to_product_grid_item($product_grid_html, $data, $product) {
		
		$new_product_grid_html = '';
		
		$link = apply_filters( 'woocommerce_loop_product_link', $product->get_permalink(), $product );
		if ($data->button) {
			ob_start();
			ecrannoir_twenty_one_block_button(esc_url( $link ), 'Je découvre', '', '', array('parent_class' => 'aligncenter'));
			$btn = ob_get_clean();
			return str_replace($data->button, $btn, $product_grid_html);
		} else {
			ob_start();
			ecrannoir_twenty_one_block_button(esc_url( $link ), 'Je découvre', 'line-left', '', array('parent_class' => 'aligncenter'));
			$btn = ob_get_clean();
			return str_replace('</li>', $btn . '</li>', $product_grid_html);
		}
	}
}

if ( ! function_exists( 'ecrannoirtwentyone_remove_my_account_links' ) ) {
	function ecrannoirtwentyone_remove_my_account_links($menu_links) {
		unset( $menu_links['dashboard'] ); // Remove Dashboard
		//unset( $menu_links['payment-methods'] ); // Remove Payment Methods
		//unset( $menu_links['orders'] ); // Remove Orders
		unset( $menu_links['downloads'] ); // Disable Downloads
		//unset( $menu_links['edit-account'] ); // Remove Account details tab
		// unset( $menu_links['customer-logout'] ); // Remove Logout link
		// unset( $menu_links['edit-address'] ); // Addresses
		$user = wp_get_current_user();
		if ( isset($menu_links['request-quote']) && !wc_user_has_role($user, 'customer-b2b') ) {
			unset($menu_links['request-quote']);
		}
		
		return $menu_links;
	}
}

if ( ! function_exists( 'ecrannoirtwentyone_rename_my_account_links' ) ) {
	function ecrannoirtwentyone_rename_my_account_links($menu_links) {
		$menu_links['orders'] = 'Mes commandes';
		$menu_links['edit-address'] = 'Mes coordonnées';
		$menu_links['edit-account'] = 'Détails du compte';
		$menu_links['giftcards'] = 'Mes cartes cadeaux';
		$menu_links['customer-logout'] = 'Se déconnecter';
		
		if (isset($menu_links['request-quote'])) {
			$menu_links['request-quote'] = 'Bons de commande';
		}
		return $menu_links;
	}
}



function ecrannoirtwentyone_custom_links( $menu_links ){
 
	// we will hook "anyuniquetext123" later
	$new = array( 'ec-myaccount-faq' => 'Foire aux questions' );
 
	// or in case you need 2 links
	// $new = array( 'link1' => 'Link 1', 'link2' => 'Link 2' );
 
	// array_slice() is good when you want to add an element between the other ones
	$position = 4; // Ex: fourth element => position = 3
	$menu_links = array_slice( $menu_links, 0, $position, true )
	+ $new 
	+ array_slice( $menu_links, $position, NULL, true );
 
 
	return $menu_links;

}

function ecrannoirtwentyone_hook_endpoint( $url, $endpoint, $value, $permalink ) {
 
	if( $endpoint === 'ec-myaccount-faq' ) {

		// ok, here is the place for your custom URL, it could be external
		$page_id   = get_page_by_path( 'faq' );
		$url = get_permalink( $page_id->ID );

	}
	return $url;
}

function ecrannoirtwentyone_myaccount_change_logout_class($classes, $endpoint) {
	if ( 'customer-logout' === $endpoint ) {
		$classes[] = 'button-link-wrapper';
	}
	return $classes;
}

function ecrannoirtwentyone_redirect_to_orders_from_dashboard() {
	global $wp;
	if ( is_account_page()) {

		if (empty( WC()->query->get_current_endpoint()) && !array_key_exists('request-quote', $wp->query_vars) ){
			wp_safe_redirect( wc_get_account_endpoint_url( 'orders' ) );
			exit;
		}
	}
}

function ecrannoirtwentyone_add_hello_msg_on_my_account()
{
	if ( is_account_page() && is_user_logged_in() ) {
		$current_user = get_user_by( 'id', get_current_user_id() );
		$allowed_html = array(
			'a' => array(
				'href' => array(),
			),
			'br' => array(),
		);
		?>
		<div class="ecrannoirtwentyone-align-narrow">
			<p class="has-text-align-center">
				<?php
				printf(
					/* translators: 1: user display name 2: logout url */
					wp_kses( __( 'Bonjour %1$s,<br> (vous n\'êtes pas %1$s? <a href="%2$s">Déconnexion</a>)', 'woocommerce' ), $allowed_html ),
					'<strong>' . esc_html( $current_user->display_name ) . '</strong>',
					esc_url( wc_logout_url() )
				);
				?>
			</p>
		</div>
		<?php
	}
}

function ecrannoirtwentyone_my_account_my_orders_columns_manage( $columns ) {

	$order_date = array('order-date' => $columns['order-date']);
	$order_status = array('order-status' => $columns['order-status']);
	unset($columns['order-date'], $columns['order-status']);
	$columns = $order_date
		+ array_slice( $columns, 0, 2, true)
		+ $order_status
		+ array_slice( $columns, 2, null, true);
 
	return $columns;
}

function ecrannoirtwentyone_my_account_my_orders_column_manage_order_date( $order ) {
	// sprintf(_('Commande du %s', 'ecrannoirtwentyone'), wc_format_datetime( $order->get_date_created() ))
	?>
	<time datetime="<?php echo esc_attr( $order->get_date_created()->date( 'c' ) ); ?>"><?php echo esc_html( sprintf(_('Commande du %s', 'ecrannoirtwentyone'), wc_format_datetime( $order->get_date_created() )) ); ?></time>
	<?php

}
function ecrannoirtwentyone_my_account_my_orders_column_manage_order_number( $order ) {
	?>
	<a href="<?php echo esc_url( $order->get_view_order_url() ); ?>">
		<?php esc_html_e( sprintf('N° de commande %s', $order->get_order_number()), 'ecrannoirtwentyone'); ?>
	</a>
	&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;
	<?php

}
function ecrannoirtwentyone_my_account_my_orders_column_manage_order_total( $order ) {
	$item_count = $order->get_item_count() - $order->get_item_count_refunded();
	?>
	<span>
	<?php
	/* translators: 1: formatted order total 2: total order items */
	echo wp_kses_post( sprintf( _n( 'Total de la commande %1$s pour %2$s article', 'Total de la commande %1$s pour %2$s articles', $item_count, 'woocommerce' ), $order->get_formatted_order_total(), $item_count ) );
	?>
	</span>
	&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;
	<?php

}
function ecrannoirtwentyone_my_account_my_orders_column_manage_order_actions( $order ) {
	?>
	<?php
	$actions = wc_get_account_orders_actions( $order );

	if ( ! empty( $actions ) ) {
		foreach ( $actions as $key => $action ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			if ( 'view' === $key ) {
				echo '<a href="' . esc_url( $action['url'] ) . '" class="woocommerce-button ' . sanitize_html_class( $key ) . '" title="' . esc_html( $action['name'] ) . '"><span class="screen-reader-text">' . esc_html( $action['name'] ) . '</span>' . '</a>';
			} else {
				echo '<a href="' . esc_url( $action['url'] ) . '" class="woocommerce-button ' . sanitize_html_class( $key ) . '" title="' . esc_html( $action['name'] ) . '"><span class="screen-reader-text">' . esc_html( $action['name'] ) . '</span>' . esc_html( $action['name'] ) . '</a>';
			}
		}
	}
	?>
	<?php

}

// Create B2B Customer
function ecrannoirtwentyone_add_b2b_customer() {

	if ( get_option( 'customer_b2b_version' ) < 1 ) {
		add_role( 'customer-b2b', 'B2B Customer', array( 'read' => true ) );
		update_option( 'custom_roles_version', 1 );
	}
}

function ecrannoirtwentyone_wrap_customer_login_form_start() {
	?>
	<div class="ecrannoirtwentyone-login-wrapper alignwide">
	<?php
}
function ecrannoirtwentyone_wrap_customer_login_form_end() {
	?>
	</div> <!-- .woocommerce-login-wrapper -->
	<?php
}

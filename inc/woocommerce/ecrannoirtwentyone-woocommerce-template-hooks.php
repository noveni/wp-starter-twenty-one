<?php
/**
 * Ecrannoir WooCommerce hooks
 *
 */

/**
 * Layout
 *
 * @see  storefront_before_content()
 * @see  storefront_after_content()
 * @see  woocommerce_breadcrumb()
 * @see  storefront_shop_messages()
 */

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
// remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );
// add_action( 'woocommerce_before_main_content', 'ecrannoirtwentyone_before_content', 10 );
// add_action( 'woocommerce_after_main_content', 'ecrannoirtwentyone_after_content', 10 );

// /**
//  * Products
//  *
//  * @see storefront_edit_post_link()
//  * @see storefront_upsell_display()
//  * @see storefront_single_product_pagination()
//  * @see storefront_sticky_single_add_to_cart()
//  */
// remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_upsell_display', 15 );
// add_filter( 'woocommerce_product_loop_start', 'ecrannoirtwentyone_product_loop_start' );
// add_filter( 'woocommerce_product_loop_end', 'ecrannoirtwentyone_product_loop_end' );

// remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
// // Add Je découvre Link
// add_action( 'woocommerce_after_shop_loop_item', 'ecrannoirtwentyone_add_product_item_link_to_btn', 10 );

// add_filter('woocommerce_blocks_product_grid_item_html', 'ecrannoirtwentyone_add_link_to_product_grid_item', 10, 3);

// /**
//  * Single Product Page
//  */
// add_action( 'woocommerce_before_single_product_summary', 'ecrannoirtwentyone_wrap_single_product_top_start', 5 );
// add_action( 'woocommerce_after_single_product_summary', 'ecrannoirtwentyone_wrap_single_product_top_end', 5 );
// add_action( 'woocommerce_before_single_product_summary', 'ecrannoirtwentyone_wrap_product_image_start', 19 );
// add_action( 'woocommerce_before_single_product_summary', 'ecrannoirtwentyone_wrap_product_image_end', 21 );
// remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
// add_filter('woocommerce_reset_variations_link', '__return_empty_string');
// // Add colon to Variation Label
// add_filter( 'woocommerce_attribute_label', function($label) {
// 	return $label . ':';
// });
// remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
// remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
// add_action( 'woocommerce_after_single_product', 'ecrannoirtwentyone_popular_products', 15 );

// // Quantity Label and Plus and Minus Sign
// add_action( 'woocommerce_before_quantity_input_field', 'ecrannoirtwentyone_add_label_before_single_product_quantity_input');
// add_action( 'woocommerce_after_quantity_input_field', 'ecrannoirtwentyone_add_plusminus_button_product_quantity_input' );

// // Wrap Quantity Input and Add To Cart Button on single product page
// add_action( 'woocommerce_before_add_to_cart_quantity', 'ecrannoirtwentyone_wrap_quantiy_and_add_to_cart_btn_together_before');
// add_action( 'woocommerce_after_add_to_cart_button', 'ecrannoirtwentyone_wrap_quantiy_and_add_to_cart_btn_together_after');

// // Product Tab
// add_filter( 'woocommerce_product_tabs', 'ecrannoirtwentyone_product_custom_tab' );
// remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
// remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
// add_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 70 );
// 	// Admin Product Tab
// 	add_filter( 'woocommerce_product_data_tabs', 'ecrannoirtwentyone_product_settings_tabs' );
// 	add_action( 'woocommerce_product_data_panels', 'ecrannoirtwentyone_product_panels' );
// 	add_action( 'woocommerce_process_product_meta', 'ecrannoirtwentyone_process_product_panels_meta', 10, 2 );

// /**
//  * Checkout
//  */

// // Add Btn After shipping address
// add_action( 'woocommerce_checkout_shipping', 'ecrannoirtwentyone_checkout_add_next_step_button', 100 );
// // Wrap Customer Billing and Order Review
// add_action( 'woocommerce_checkout_before_customer_details', 'ecrannoirtwentyone_checkout_wrapper_row_start');
// add_action( 'woocommerce_checkout_after_order_review', 'ecrannoirtwentyone_checkout_wrapper_row_end', 11);
// // Wrap Order Review in Checkout
// add_action( 'woocommerce_checkout_before_order_review_heading', 'ecrannoirtwentyone_wrapper_checkout_order_review_before');
// add_action( 'woocommerce_checkout_after_order_review', 'ecrannoirtwentyone_wrapper_checkout_order_review_after', 10);
// // Add new title to order_review
// add_action( 'woocommerce_checkout_order_review', 'ecrannoirtwentyone_checkout_order_review_title', 5 );
// // Add Button Order
// add_action( 'woocommerce_review_order_after_order_total', 'ecrannoirtwentyone_checkout_order_review_add_order_button' );

// // Make a Step #2 Part For checkout. We Can add Delivery Step
// add_action( 'woocommerce_checkout_after_order_review', 'ecrannoirtwentyone_checkout_step_block_second', 20);
// // Make a Step #3 Part For checkout. We Can add Payment
// add_action( 'woocommerce_checkout_after_order_review', 'ecrannoirtwentyone_checkout_step_block_third', 30);

// // Remove payment position and add it to correct place
// remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
// add_action( 'ecrannoirtwentyone_checkout_step_third', 'woocommerce_checkout_payment'  );

// // Add new title to Billing form
// add_action( 'woocommerce_before_checkout_billing_form', 'ecrannoirtwentyone_checkout_billing_title' );

// // Remove Coupon Code before checkout
// remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );

// if ( class_exists('WC_Gift_Cards') && class_exists('WC_GC_Cart')) {
// 	add_action( 'init', function() {
// 		remove_action( 'woocommerce_review_order_before_payment', array( WC_GC()->cart, 'display_form' ), 9 );
// 		// if ( ! is_ajax() ) {
// 			add_action( 'woocommerce_review_order_after_cart_contents', function() {
// 				?>
// 				<tr>
// 					<td colspan="2"><?php WC_GC()->cart->display_form() ?></td>
// 				</tr>
// 				<?php
// 			});
// 		// }
// 	} );
// }
// /**
//  * Cart fragment
//  *
//  * @see storefront_cart_link_fragment()
//  */
// add_filter( 'woocommerce_add_to_cart_fragments', 'ecrannoirtwentyone_cart_link_fragment' );
// add_action( 'woocommerce_before_mini_cart', 'ecrannoirtwentyone_mini_cart_fragment_title' );
// add_filter( 'woocommerce_cart_item_permalink', '__return_empty_string' );

// remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10 );
// remove_action( 'woocommerce_widget_shopping_cart_total', 'woocommerce_widget_shopping_cart_subtotal', 10 );
// add_action( 'woocommerce_widget_shopping_cart_total', 'ecrannoirtwentyone_widget_shopping_cart_subtotal', 10 );

// // Redirect Cart
// add_filter( 'woocommerce_add_to_cart_redirect', 'ecrannoirtwentyone_skip_cart_redirect_checkout' );
// add_filter( 'template_redirect', 'ecrannoirtwentyone_cart_redirect_checkout' );


// /**
//  * MyAccount
//  */
// // Remove Useless Link
// add_filter( 'woocommerce_account_menu_items', 'ecrannoirtwentyone_remove_my_account_links' );
// add_filter( 'woocommerce_account_menu_items', 'ecrannoirtwentyone_rename_my_account_links' );

// add_filter ( 'woocommerce_account_menu_items', 'ecrannoirtwentyone_custom_links' );
// add_filter( 'woocommerce_get_endpoint_url', 'ecrannoirtwentyone_hook_endpoint', 10, 4 );
// add_filter( 'woocommerce_account_menu_item_classes', 'ecrannoirtwentyone_myaccount_change_logout_class', 10, 2 );

// add_action('template_redirect', 'ecrannoirtwentyone_redirect_to_orders_from_dashboard' );
// add_action('ecrannoirtwentyone_entry_content_before', 'ecrannoirtwentyone_add_hello_msg_on_my_account');

// add_filter( 'woocommerce_my_account_my_orders_columns', 'ecrannoirtwentyone_my_account_my_orders_columns_manage' );
// add_action( 'woocommerce_my_account_my_orders_column_order-date', 'ecrannoirtwentyone_my_account_my_orders_column_manage_order_date' );
// add_action( 'woocommerce_my_account_my_orders_column_order-number', 'ecrannoirtwentyone_my_account_my_orders_column_manage_order_number' );
// add_action( 'woocommerce_my_account_my_orders_column_order-total', 'ecrannoirtwentyone_my_account_my_orders_column_manage_order_total' );
// add_action( 'woocommerce_my_account_my_orders_column_order-actions', 'ecrannoirtwentyone_my_account_my_orders_column_manage_order_actions' );

// // Change Variations Select to Radio
// add_action( 'woocommerce_after_single_product', function() {
// 	// https://codedcommerce.com/product/change-variation-drop-downs-to-radio-buttons/
// 	// Variable Products Only
// 	global $product;
// 	if( ! $product || ! $product->is_type( 'variable' ) ) {
// 		return;
// 	}
 
// 	// Inline jQuery
// 	?>
// 	<script>
// 		jQuery( document ).ready( function( $ ) {
			
// 			$( ".variations_form" )
// 				.on( "wc_variation_form woocommerce_update_variation_values", function() {
// 					var product_attr    =   jQuery.parseJSON( $(".variations_form").attr("data-product_variations") )
// 					$( "label.generatedRadios" ).remove();
// 					$( "table.variations select" ).each( function() {
// 						var selName = $( this ).attr( "name" );
// 						$( "select[name=" + selName + "] option" ).each( function() {
// 							var option = $( this );
// 							var value = option.attr( "value" );
// 							if( value == "" ) { return; }
// 							var label = option.html();
// 							var select = option.parent();
// 							var selected = select.val();
// 							var isSelected = ( selected == value )
// 								? " checked=\"checked\"" : "";
// 							var selClass = ( selected == value )
// 								? " selected" : "";
// 							var radHtml
// 								= `<input name="${selName}" type="radio" value="${value}" />`;
// 							var optionHtml
// 								= `<label class="generatedRadios${selClass}">${radHtml} ${label}</label>`;
// 							select.parent().append(
// 								$( optionHtml ).click( function() {
// 									select.val( value ).trigger( "change" );
// 									$('.woocommerce-variation-price').hide();
// 								} )
// 							)

// 							if (isSelected) {
// 								// Move Variation Price up.
// 								$.each( product_attr, function( index, loop_value ) {
// 									if( value === loop_value.attributes[selName] ){
// 										$('.product_title + .price').html( loop_value.price_html );
// 									}
// 								});

// 								// Hide Old Variation Price
// 								$('.woocommerce-variation-price').hide();
// 							}
// 						} ).parent().hide();
// 					} );
// 				} );
			

// 		} );
// 	</script>
// 	<?php
// } );

// add_action( 'init', 'ecrannoirtwentyone_add_b2b_customer' );

// add_filter( 'the_title', function($title, $id) {
// 	if ( is_account_page() && !is_user_logged_in() && $title == 'Mon compte') {
// 		$title = 'Identification';
// 	}
// 	return $title;
	
// }, 10, 2 );

// add_action( 'woocommerce_before_customer_login_form', 'ecrannoirtwentyone_wrap_customer_login_form_start' );
// add_action( 'woocommerce_after_customer_login_form', 'ecrannoirtwentyone_wrap_customer_login_form_end' );

// remove_action( 'woocommerce_register_form', 'wc_registration_privacy_policy_text', 20 );

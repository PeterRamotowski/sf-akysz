<?php

/**
 * Load translation files
 */
function akysz_theme_setup() {
  load_child_theme_textdomain( 'sf-akysz', get_stylesheet_directory() . '/languages' );
}
add_action('after_setup_theme', 'akysz_theme_setup');


/**
 * Enqueue and dequeue CSS and JS files
 */
function akysz_enqueue() {

  wp_dequeue_style( 'storefront-child-style' );

  wp_enqueue_style( 'akysz-styles', get_theme_file_uri() . '/style.css' );
  wp_enqueue_script( 'akysz-scripts', get_theme_file_uri() . '/scripts.js' );

	wp_deregister_script( 'wp-embed' );
  wp_dequeue_style( 'wp-block-library' );

  if ( is_checkout() ) {
    wp_enqueue_script( 'wc-cart', WP_PLUGIN_DIR.'/woocommerce/assets/js/frontend/cart.min.js' );
  }
}
add_action( 'wp_enqueue_scripts', 'akysz_enqueue', 999 );


/**
 * Product layout
 */
function akysz_single_product_layout() {
  remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
  remove_action( 'woocommerce_single_product_summary', 'storefront_edit_post_link', 60 );
}
add_action( 'woocommerce_before_single_product', 'akysz_single_product_layout' );

add_action( 'woocommerce_product_additional_information', 'woocommerce_template_single_meta', 10 );

add_filter( 'wc_add_to_cart_message_html', '__return_false' );
add_filter( 'wc_add_to_cart_message', '__return_false' );


/**
 * Checkout customize
 */
remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review', 10 );
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
add_action( 'woocommerce_before_checkout_form', 'woocommerce_order_review', 10 );
add_filter( 'woocommerce_terms_is_checked_default', '__return_true' );

function akysz_checkout_fields( $fields ) {
  unset( $fields['billing']['billing_address_2'] );
  unset( $fields['shipping']['shipping_address_2'] );

  $fields['billing']['billing_email']['priority'] = 1;
  $fields['billing']['billing_phone']['priority'] = 2;

  $fields['billing']['billing_phone']['required'] = false;
  
  return $fields;
}
add_filter( 'woocommerce_checkout_fields', 'akysz_checkout_fields', 1001 );

function akysz_address_fields( $fields ) {

  if ( ( $key = array_search( 'form-row-wide', $fields['postcode']['class'] ) ) !== false ) {
    unset( $fields['postcode']['class'][ $key ] );
  }
  if ( ( $key = array_search( 'form-row-wide', $fields['city']['class'] ) ) !== false ) {
    unset( $fields['city']['class'][ $key ] );
  }

  $fields['postcode']['class'][] = 'form-row-first';
  $fields['city']['class'][] = 'form-row-last';

  $fields['country']['priority'] = 110;
  
  return $fields;
}
add_filter( 'woocommerce_default_address_fields', 'akysz_address_fields' );


/**
 * Cart customize
 */
remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10 );


/**
 * Additional information tab always visible
 */
function akysz_customize_tabs( $tabs ) {
  if ( ! isset($tabs['additional_information']) ) {
    $tabs['additional_information'] = array(
      'title'     => __( 'Additional information', 'woocommerce' ),
      'priority'  => '20',
      'callback'  => 'woocommerce_product_additional_information_tab',
    );
  }
	return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'akysz_customize_tabs', 100, 1 );


/**
 * Cart on checkout page
 */
function akysz_cart_on_checkout() {
  if ( is_wc_endpoint_url( 'order-received' ) ) return;
  echo do_shortcode('[woocommerce_cart]');
}
add_action( 'woocommerce_before_checkout_form', 'akysz_cart_on_checkout', 5 );


/**
 * Redirects
 */
function akysz_redirects() {
  // Redirect empty checkout to home page
  if ( is_cart() && WC()->cart->is_empty() && ! is_wc_endpoint_url( 'order-pay' ) && ! is_wc_endpoint_url( 'order-received' ) ) {
    wp_safe_redirect( home_url() );
    exit;
  }
  // Redirect cart to checkout
  if ( is_cart() ) {
    wp_safe_redirect( wc_get_checkout_url() );
  }
}
add_action( 'template_redirect', 'akysz_redirects' );


/**
 * Remove footer Storefront link
 */
add_filter('storefront_credit_link', '__return_false');


/**
 * Add to cart handler.
 */
function akysz_ajax_add_to_cart_handler() {
	WC_Form_Handler::add_to_cart_action();
	WC_AJAX::get_refreshed_fragments();
}
add_action( 'wc_ajax_ace_add_to_cart', 'akysz_ajax_add_to_cart_handler' );
add_action( 'wc_ajax_nopriv_ace_add_to_cart', 'akysz_ajax_add_to_cart_handler' );

// Remove WC Core add to cart handler to prevent double-add
remove_action( 'wp_loaded', array( 'WC_Form_Handler', 'add_to_cart_action' ), 20 );


/**
 * Cart Fragments.
 *
 * Ensure cart contents update when products are added to the cart via AJAX.
 *
 * @param array $fragments Fragments to refresh via AJAX.
 * @return array Fragments to refresh via AJAX.
 */
function akysz_cart_fragments( $fragments ) {
	$all_notices  = WC()->session->get( 'wc_notices', array() );
	$notice_types = apply_filters( 'woocommerce_notice_types', array( 'error', 'success', 'notice' ) );

	ob_start();
	foreach ( $notice_types as $notice_type ) {
		if ( wc_notice_count( $notice_type ) > 0 ) {
			wc_get_template( "notices/{$notice_type}.php", array(
				'messages' => array_filter( $all_notices[ $notice_type ] ),
			) );
		}
	}
	$fragments['notices_html'] = ob_get_clean();
	wc_clear_notices();

	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'akysz_cart_fragments' );

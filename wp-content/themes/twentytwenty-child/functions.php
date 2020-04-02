<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Enqueue child styles. Will be used to data via SESSION
 */
add_action( 'wp_enqueue_scripts', 'child_enqueue_styles' );
function child_enqueue_styles()
{
    $parent_style = 'parent-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style(
        'twentytwenty-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get( 'Version' )
    );
}

/**
 * Start user session for each individual user
 */
add_action( "init", "theme_start_session", 1 );
function theme_start_session()
{
    if ( !session_id() )
        session_start();
}

/** Woo Commerce Hooks */

/**
 * REMOVE Shipping and Billing Fields in Checkout
 */
add_filter( 'woocommerce_checkout_fields', 'custom_override_checkout_fields' );
function custom_override_checkout_fields( $fields )
{
    unset( $fields['billing']['billing_first_name'] );
    unset( $fields['billing']['billing_last_name'] );
    unset( $fields['billing']['billing_company'] );
    unset( $fields['billing']['billing_address_1'] );
    unset( $fields['billing']['billing_address_2'] );
    unset( $fields['billing']['billing_city'] );
    unset( $fields['billing']['billing_postcode'] );
    unset( $fields['billing']['billing_country'] );
    unset( $fields['billing']['billing_state'] );
    unset( $fields['billing']['billing_phone'] );
    unset( $fields['billing']['billing_address_2'] );
    unset( $fields['billing']['billing_postcode'] );
    unset( $fields['billing']['billing_company'] );
    unset( $fields['billing']['billing_last_name'] );
    unset( $fields['billing']['billing_email'] );
    unset( $fields['billing']['billing_city'] );
    return $fields;
}

/**
 * REDIRECT Continue Shopping to "services" page
 */
add_filter( 'woocommerce_continue_shopping_redirect', 'wc_custom_redirect_continue_shopping' );
function wc_custom_redirect_continue_shopping()
{
    //return your desired link here.
    return get_site_url() . '/services';
}


/**
 * CHANGE "Add to Cart" button text to "Add Order"
 */
add_filter( 'woocommerce_product_add_to_cart_text', 'woocommerce_custom_product_add_to_cart_text' );
function woocommerce_custom_product_add_to_cart_text()
{
    return __( 'Add Order', 'woocommerce' );
}


/// HOOKS TO ATTACH ENTRY_ID TO ORDER META DATA
/**
 * PROGRAMMATICALLY add entry_id to Product meta data. GF entry_id should be accessible from SESSIONS (set in plugin)
 */
add_action( 'woocommerce_add_to_cart', 'add_to_cart_with_entry_id', 10, 6 );
function add_to_cart_with_entry_id( $cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data )
{

}

/**
 * ADD the order meta with entry_id
 */
add_action( 'woocommerce_checkout_update_order_meta', 'entry_id_update_order_meta' );
function entry_id_update_order_meta( $order_id )
{
    session_start();
    $entry_id = $_SESSION['entry_id'];
    update_post_meta( $order_id, 'bc_entry_id', $entry_id );
}

/**
 * Display field value on the order edit page with a link to download
 * @TODO - will need to revise in the future. This is for business cards specifically...
 */
add_action( 'woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );
function my_custom_checkout_field_display_admin_order_meta( $order )
{
    $entry_id = get_post_meta( $order->get_id(), 'bc_entry_id', true );
    $uploads = wp_upload_dir();

    echo "<strong style='color: black;'>" . __( 'Entry ID' ) . ":</strong>
          <a href='" . esc_url( $uploads['baseurl'] . '/business_cards/business_card_' . $entry_id . '.pdf') . "'> 
            <span> Business Card $entry_id </span>
          </a>";
}

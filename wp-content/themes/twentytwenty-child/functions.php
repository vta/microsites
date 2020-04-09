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

/** WooCommerce Hooks */

/** USER FRONT-END CHANGES */
/**
 * REMOVE related products output
 *
 * This hook removes the related products on each product page (Standard-Size Printing, Large Format Printing)
 * @see - https://docs.woocommerce.com/document/remove-related-posts-output/
 */
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

/**
 * REDIRECT "Continue Shopping" to "services" page
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

/**
 * OVERRIDE WooCommerce Templates
 */
add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );
function mytheme_add_woocommerce_support()
{
    add_theme_support( 'woocommerce' );
}

/**
 * REMOVE Shipping and Billing Fields in Checkout
 *
 * @param $fields - associative array of checkout fields
 * @return mixed - updated fields with billing section stripped
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

/** BACK-END, METADATA, & WP ADMIN CHANGES  */

/**
 * ADD business card entry_id to cart item.
 *
 * @param array $cart_item_data
 * @param int $product_id
 * @param int $variation_id
 *
 * @return array
 */
add_filter( 'woocommerce_add_cart_item_data', 'add_entry_id_to_cart_item', 10, 3 );
function add_entry_id_to_cart_item( $cart_item_data, $product_id, $variation_id )
{
    $entry_id = $_SESSION['entry_id'];

    // if entry_id for business card was not set in wp-print-preview, then return item as is
    if ( empty( $entry_id ) ) {
        return $cart_item_data;
    }

    // if entry_id was set in $_SESSION, ensure that it can only be added to business card
    if ( $product_id === 39 ) {
        $cart_item_data['bc_entry_id'] = $entry_id;
    }

    return $cart_item_data;
}


/**
 * DISPLAY first + last name text of business card order in the cart.
 *
 * @param array $item_data
 * @param array $cart_item
 *
 * @return array
 */
add_filter( 'woocommerce_get_item_data', 'business_card_display_text_cart', 10, 2 );
function business_card_display_text_cart( $item_data, $cart_item )
{
    if ( empty( $cart_item['bc_entry_id'] ) ) {
        return $item_data;
    }

    // Extract Fullname from GF Entries
    $entry_id = $cart_item['bc_entry_id'];
    $entry = GFAPI::get_entry($entry_id);
    $fullname = $entry['2.3'] . " " . $entry['2.6'];

    // Display Fullname in cart + checkout page
    $item_data[] = array(
        'key' => __( 'Name', 'fullname' ),
        'value' => wc_clean( $fullname ),
        'display' => '',
    );

    return $item_data;
}


/**
 * ADD business card PDF link to "Edit Order" admin page
 *
 * @param WC_Order_Item_Product $item
 * @param string $cart_item_key
 * @param array $values
 * @param WC_Order $order
 */
add_action( 'woocommerce_checkout_create_order_line_item', 'bc_entry_id_text_to_order_items', 10, 4 );
function bc_entry_id_text_to_order_items( $item, $cart_item_key, $values, $order )
{
    if ( empty( $values['bc_entry_id'] ) ) {
        return;
    }

    // get upload directory + entry_id
    $uploads = wp_upload_dir();
    $entry_id = $values['bc_entry_id'];

    // pull name from business_card
    $entry = GFAPI::get_entry($entry_id);
    $firstname = $entry['2.3'];
    $lastname = $entry['2.6'];

    //
    $item->add_meta_data( __( 'Business Card Entry ID', 'bc_entry_id' ),
        "
            <a href='" . esc_url( $uploads['baseurl'] . '/business_cards/business_card_' . $entry_id . '.pdf' ) . "'>
             " . "$firstname" . " " . "$lastname" . "
            </a>
        "
    );
}

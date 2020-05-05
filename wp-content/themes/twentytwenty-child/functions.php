<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Enqueue child styles. Will be used to data via SESSION
 */
add_action( 'wp_enqueue_scripts', 'child_scripts' );
function child_scripts()
{
    $parent_style = 'parent-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style(
        'twentytwenty-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get( 'Version' )
    );

    // jQuery
    wp_enqueue_script( 'jquery' );

    // Our JS Script
    wp_enqueue_script(
        'child-script',
        get_stylesheet_directory_uri() . '/js/scripts.js',
        array( 'jquery' ),
        '1.0.0',
        true
    );
}

/**
 * REGISTER Custom Inner Footer Menu
 */
add_action( 'wp_loaded', 'register_menus' );
function register_menus()
{
    $locations = array(
        'inner_footer' => __( 'Inner Footer Menu', 'twentytwenty' ),
    );

    register_nav_menus( $locations );
}

/**
 * Start user session for each individual user
 * REQUIRED for attaching meta data to business card product
 */
add_action( "wp_loaded", "theme_start_session", 1 );
function theme_start_session()
{
    if ( !session_id() )
        session_start();
}

/**
 * BYPASS Log out confirmation
 * @see - https://gist.github.com/lukecav/9e7775cbe3172ef32b5191f5b56d64fb
 */
add_action( 'check_admin_referer', 'logout_without_confirmation', 1, 2 );
/**
 * Generates custom logout URL
 */
function getLogoutUrl( $redirectUrl = '' )
{
    if ( !$redirectUrl ) $redirectUrl = site_url();
    $return = str_replace( "&amp;", '&', wp_logout_url( $redirectUrl ) );
    return $return;
}

/**
 * Bypass logout confirmation on nonce verification failure
 */
function logout_without_confirmation( $action, $result )
{
    if ( !$result && ($action == 'log-out') ) {

        wp_safe_redirect( getLogoutUrl() );
        exit();
    }
}

/**
 * REMOVES wordpress_logged_in_XXXXXXXXXX cookie
 *
 * In the future, we may want to find a better implementation as to check every run this hook on every page load
 * @see - https://www.sitepoint.com/how-to-set-get-and-delete-cookies-in-wordpress/
 */
add_action( 'wp', 'clear_myaccount_cookie' );
function clear_myaccount_cookie()
{
    global $post;

    // check if we are the "My Account" page
    if ( isset( $post->ID ) && $post->ID == wc_get_page_id( 'myaccount' ) ) {

        // Loop through each cookie
        foreach ( $_COOKIE as $cookie_key => $val ) {

            // TARGET cookie wordpress_logged_in_XXXXXXX
            $login_cookie_regex = '/wordpress_logged_in_[d]+/';

            if ( preg_match( $login_cookie_regex, $cookie_key ) ) {
                // clear the cookie and set ex
                unset( $_COOKIE[$cookie_key] );
                setcookie( $cookie_key, '', time() - (15 * 60) );
            }
        }
    }

}

/**
 * REDIRECT to "My Account" after WooCommerce Login
 */
add_filter( 'woocommerce_login_redirect', 'wc_login_redirect' );
function wc_login_redirect()
{
    return get_permalink( wc_get_page_id( 'myaccount' ) );
}

/**
 * EMPTY cart upon logout
 */
add_action( 'wp_logout', 'clear_cart' );
function clear_cart()
{
    // Clear WooCommerce Cart
    if ( function_exists( 'WC' ) ) {
        WC()->cart->empty_cart();
    }
}

/** WooCommerce Hooks */

/** USER FRONT-END CHANGES */

/**
 * ADD custom WC count to "Cart" menu link
 */
add_filter( 'wp_nav_menu_objects', 'add_cart_number', 9, 2 );
function add_cart_number( $items, $args )
{
    // iterate through all menu items
    foreach ( $items as $item ) {

        // If menu link is "Cart"
        if ( $item->title == 'Cart' ) {
            // add "custom-wc-cart" class
            array_push( $item->classes, 'custom-wc-cart' );

            $item->title = 'Cart' . ' (<span id="count-cart-items">' . WC()->cart->get_cart_contents_count() . '</span>)';
        }
    }

    return $items;
}

/**
 * UPDATE Cart Link item number with AJAX
 * @see - https://stackoverflow.com/questions/53280425/ajax-update-product-count-on-cart-menu-in-woocommerce
 */
add_filter( 'woocommerce_add_to_cart_fragments', 'wc_refresh_cart_fragments', 50, 1 );
function wc_refresh_cart_fragments( $fragments )
{
    $cart_count = WC()->cart->get_cart_contents_count();

    // Normal version
    $count_normal = '<span id="count-cart-items">' . $cart_count . '</span>';
    $fragments['#count-cart-items'] = $count_normal;

    // Mobile version
    $count_mobile = '<span id="count-cart-itemob">' . $cart_count . '</span>';
    $fragments['#count-cart-itemob'] = $count_mobile;

    return $fragments;
}

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
    return __( 'Continue', 'woocommerce' );
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

/**
 * REMOVE Downloads & Address tab from "My Account"
 */
add_filter( 'woocommerce_account_menu_items', 'remove_customer_downloads_addresss' );
function remove_customer_downloads_addresss ($items)
{
    error_log( json_encode($items), JSON_PRETTY_PRINT);

    unset( $items['downloads'] );
    unset( $items['edit-address'] );

    return $items;
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
    $entry = GFAPI::get_entry( $entry_id );
    $fullname = $entry['2.3'] . " " . $entry['2.6'];
    $quantity = $entry['10'];

    // Display Fullname in cart + checkout page
    $item_data[] = array(
        'key' => __( 'Name', 'fullname' ),
        'value' => wc_clean( $fullname ),
        'display' => '',
    );

    // Display Qty in cart + checkout page
    $item_data[] = array(
        'key' => __( 'Quantity', 'qty' ),
        'value' => wc_clean( $quantity ),
        'display' => '',
    );

    return $item_data;
}

add_filter( 'is_vendor_can_see_order_billing_address', false );
add_filter( 'is_vendor_can_see_order_shipping_address', '__return_false' );
add_filter( 'show_cust_billing_address_field', '__return_true' );
add_filter( 'show_cust_shipping_address_field', '__return_false' );


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
    $entry = GFAPI::get_entry( $entry_id );
    $firstname = $entry['2.3'];
    $lastname = $entry['2.6'];
    $quantity = $entry['10'];

    // add business card download link as meta data
    $item->add_meta_data( __( 'Business Card PDF', 'bc_entry_id' ),
        "
            <a href='" . esc_url( $uploads['baseurl'] . '/business_cards/business_card_' . $entry_id . '.pdf' ) . "'>
             " . "$firstname" . " " . "$lastname" . "
            </a>
        "
    );

    // add quantity as meta data
    $item->add_meta_data( __( 'Quantity', 'qty' ), $quantity );

}

/**
 * ::IMPORTANT:: REMOVES PDF download link from emails and user dashboard (basically everyone except admin dashboard)
 */
add_filter( 'woocommerce_order_item_get_formatted_meta_data', 'unset_specific_order_item_meta_data', 10, 2 );
function unset_specific_order_item_meta_data( $formatted_meta, $item )
{

    // If, they are admin, Business Card PDF metadata (link) will be visible
    if ( is_admin() )
        return $formatted_meta;

    foreach ( $formatted_meta as $key => $meta ) {
        if ( in_array( $meta->key, array( 'Business Card PDF' ) ) )
            unset( $formatted_meta[$key] );
    }
    return $formatted_meta;
}

/** CUSTOM ORDER STATUSES (NOT INCLUDED IN WOOCOMMERCE CORE) */

/**
 * REGISTER "Ready for Pick Up" status
 */
add_action( 'wp_loaded', 'register_ready_for_pickup_order_status' );
function register_ready_for_pickup_order_status()
{
    register_post_status( 'wc-ready', array(
        'label' => 'Ready for Pick Up',
        'public' => true,
        'exclude_from_search' => false,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true,
        'label_count' => _n_noop( 'Ready for Pick Up', 'Ready for Pick Up' )    // Shows up under Order's tab / filter
    ) );
}

/**
 * REGISTER "Special" status
 */
add_action( 'wp_loaded', 'register_special_status' );
function register_special_status()
{
    register_post_status( 'wc-special', array(
        'label' => 'Special',
        'public' => true,
        'exclude_from_search' => false,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true,
        'label_count' => _n_noop( 'Special', 'Special' )                        // Shows up under Order's tab / filter
    ) );
}


/**
 * FINISHING "Finishing" status
 */
add_action( 'wp_loaded', 'register_finishing_status' );
function register_finishing_status()
{
    register_post_status( 'wc-finishing', array(
        'label' => 'Finishing',
        'public' => true,
        'exclude_from_search' => false,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true,
        'label_count' => 'Finishing'                                                                // Shows up under Order's tab / filter
    ) );
}

/**
 * ADD newly registered order status to the menu
 *
 * @param $order_statuses - current order status in assoc array
 * @return array - updated order statuses
 */
add_filter( 'wc_order_statuses', 'add_custom_order_statuses' );
function add_custom_order_statuses( $order_statuses )
{

    $new_order_statuses = array();

    // add new order status after processing
    foreach ( $order_statuses as $key => $status ) {

        $new_order_statuses[$key] = $status;

        // place special for pick up after "Processing"
        if ( 'wc-processing' === $key ) {
            $new_order_statuses['wc-special'] = 'Special';
        }

        // place special for pick up after "Finishing"
        if ( 'wc-on-hold' === $key ) {
            $new_order_statuses['wc-finishing'] = 'Finishing';
        }

        // place ready for pick up after "On Hold"
        if ( 'wc-on-hold' === $key ) {
            $new_order_statuses['wc-ready'] = 'Ready for Pick Up';
        }
    }

    return $new_order_statuses;
}

/** GRAVITY FORMS */

/**
 * SSP Date Validation (3 business days - Includes today)
 */
add_filter( 'gform_field_validation_1_29', 'date_validation', 10, 4 );
function date_validation( $result, $value, $form, $field )
{
    // dates in UNIX
    $user_date = strtotime( $value );
    $today = strtotime( 'today' );

    $error_message = 'Must be at least 3 business days.';

    // today's day
    $day = date( 'l', $today );

    error_log( json_encode( $today ), JSON_PRETTY_PRINT );

    // Wednesday, Thursday, Friday, & Saturday add 5 days
    if ( $day === 'Wednesday' || $day === 'Thursday' || $day === 'Friday' || $day === 'Saturday' ) {

        if ( $user_date < strtotime( '+4 days' ) ) {
            $earliest_date = ' Earliest order date is ' . date( 'm/d/Y',  strtotime('+5 days'));
            $result['is_valid'] = false;
            $result['message'] = $error_message . $earliest_date;
        }

    // Add 4 days for Sunday
    } elseif ( $day === 'Sunday' ) {

        if ( $user_date < strtotime( '+3 days' ) ) {
            $earliest_date = ' Earliest order date is ' . date( 'm/d/Y',  strtotime('+4 days'));
            $result['is_valid'] = false;
            $result['message'] = $error_message . $earliest_date;
        }

    // 3 days for the rest
    } else {

        if ( $user_date < strtotime( '+2 days' ) ) {
            $earliest_date = ' Earliest order date is ' . date( 'm/d/Y',  strtotime('+3 days'));
            $result['is_valid'] = false;
            $result['message'] = $error_message . $earliest_date;
        }

    }

    return $result;
}

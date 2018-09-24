<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

// END ENQUEUE PARENT ACTION
/*---Move Product Title*/
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

/**
 * @return array
 *
function child_thumb_size() {
	$sizeinfo = array( 'width' => 240, 'height' => 180, 'crop' => false );
	return $sizeinfo;
}
add_filter( 'tc_thumb_size', 'child_thumb_size');
add_filter( 'tc_thumb_fpc_size', 'child_thumb_size');
 */

/**
 *
function child_theme_setup() {
	add_image_size('tc-thumb', 240, 180, false);
}
add_action( 'after_setup_theme', 'child_theme_setup', 10, 2);
update_option( 'thumbnail_size_w', 240 );
update_option( 'thumbnail_size_h', 180 );
update_option( 'thumbnail_crop', 0 );
 */

/**
 *
add_filter('tc_fp_link_url' , 'my_custom_fp_links', 10 ,2);
//If you are using the featured pages Unlimited Plugin or the Customizr Pro theme, uncomment this line :
add_filter('fpc_link_url' , 'my_custom_fp_links', 10 ,2);

function my_custom_fp_links( $original_link , $fp_id ) {

	//assigns a custom link by page id
	$custom_link = array(
		//page id => 'Custom link'
		59 => 'https://newswheel.vta.org/category/headways/',
		29 => 'https://newswheel.vta.org/category/from-the-hub/',
		129 => 'https://newswheel.vta.org/category/announcements/',
		25 => 'https://newswheel.vta.org/category/safety/'
	);

	foreach ($custom_link as $page_id => $link) {
		if ( get_permalink($page_id) == $original_link )
			return $link;
	}
 */

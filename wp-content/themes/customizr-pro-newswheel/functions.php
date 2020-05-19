<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

// END ENQUEUE PARENT ACTION

add_action('wp_head','move_slider');
if (!function_exists('move_slider')) {
  function move_slider()
  {
    if ( ! is_front_page() )
      return;
    remove_action ('__after_header' , array( CZR_slider::$instance , 'czr_fn_slider_display' ));
//        remove_action  ( '__before_main_container' , array( CZR_featured_pages::$instance , 'tc_fp_block_display'), 10 );

    add_action ('__after_content' , array( CZR_slider::$instance , 'czr_fn_slider_display' ));
//        add_action  ( '__after_header' , array( CZR_featured_pages::$instance , 'tc_fp_block_display'), 10);
  }
}

/**
 *
 * FROM init-base.php for reference
 *
 *
//Default images sizes
$this -> tc_thumb_size      = array( 'width' => 270 , 'height' => 250, 'crop' => true ); //size name : tc-thumb
$this -> slider_full_size   = array( 'width' => 9999 , 'height' => 500, 'crop' => true ); //size name : slider-full

//The actual bootstrap4 container width is 1110, while it was 1170 in bootstrap2
$this -> slider_size        = array( 'width' => CZR_IS_MODERN_STYLE ? 1110 : 1170 , 'height' => 500, 'crop' => true ); //size name : slider

$this -> tc_grid_size       = array( 'width' => 570 , 'height' => 350, 'crop' => true ); //size name : tc-grid
//Default images sizes
$this -> tc_grid_full_size  = array( 'width' => CZR_IS_MODERN_STYLE ? 1110 : 1170 , 'height' => CZR_IS_MODERN_STYLE ? 444 : 350, 'crop' => true ); //size name : tc-grid-full


//slider full width
$slider_full_size = apply_filters( 'tc_slider_full_size' , CZR___::$instance -> slider_full_size );
//add_image_size( 'slider-full' , $slider_full_size['width'] , $slider_full_size['height'], $slider_full_size['crop'] );
add_image_size( 'slider-full' , $slider_full_size['width'] , $slider_full_size['height'], false);

//slider boxed
$slider_size      = apply_filters( 'tc_slider_size' , CZR___::$instance -> slider_size );
//add_image_size( 'slider' , $slider_size['width'] , $slider_size['height'], $slider_size['crop'] );
add_image_size( 'slider' , 640, $slider_size['height'], $slider_size['crop'] );
 *
 **/

function child_thumb_size() {
  $sizeinfo = array( 'width' => 240, 'height' => 180, 'crop' => false );
  return $sizeinfo;
}
add_filter( 'tc_thumb_size', 'child_thumb_size');
add_filter( 'tc_thumb_fpc_size', 'child_thumb_size');
function child_theme_setup() {
  add_image_size('tc-thumb', 240, 180, false);
}
add_action( 'after_setup_theme', 'child_theme_setup', 10, 2);
update_option( 'thumbnail_size_w', 240 );
update_option( 'thumbnail_size_h', 180 );
update_option( 'thumbnail_crop', 0 );

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

  //if no custom title is defined for the current page id, return original
  return $original_link;
}






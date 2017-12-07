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

remove_filter('tc_slider_full_size', CZR___::$instance -> slider_full_size);
add_filter( 'tc_slider_full_size', 'my_slider_full_size');
function my_slider_full_size() {
  $sizeinfo = array( 'width' => 640 , 'height' => 480, 'crop' => false );
  return $sizeinfo;
}

remove_filter('tc_slider_size', array( 'width' => CZR_IS_MODERN_STYLE ? 1110 : 1170 , 'height' => 500, 'crop' => true ));
add_filter( 'tc_slider_size', 'my_slider_size');
function my_slider_size() {
  //The actual bootstrap4 container width is 1110, while it was 1170 in bootstrap2
//  $this -> slider_size        = array( 'width' => CZR_IS_MODERN_STYLE ? 1110 : 1170 , 'height' => 500, 'crop' => true ); //size name : slider
  $slider_size = array( 'width' => 640 , 'height' => 480, 'crop' => false );
  return $slider_size;
}

function child_theme_setup() {
//  add_image_size('tc_rectangular_size', 640, 480, true);
//  remove_image_size('slider_full_size');
  remove_image_size('slider_size');
//  add_image_size('slider_full_size', 640, 480, false);
  add_image_size('slider_size', 640, 480, false);
}
add_action( 'after_setup_theme', 'child_theme_setup', 11 );





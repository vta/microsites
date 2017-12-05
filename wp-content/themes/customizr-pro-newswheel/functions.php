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

<?php
// file: example-me/app/controllers/frontend/class-print-posts-shortcode.php

namespace Demo_Print\App\Controllers\Frontend;

if ( ! class_exists( __NAMESPACE__ . '\\' . 'Print_Posts_Shortcode' ) ) {
	/**
	 * Class that handles `example_me_print_posts` shortcode
	 *
	 * @since      1.0.0
	 * @package    Demo_Print
	 * @subpackage Demo_Print/Controllers/Frontend
	 */
	class Print_Posts_Shortcode extends Base_Controller {

		/**
		 * Registers the `demo_print_print_posts` shortcode
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function register_shortcode() {
			add_shortcode( 'demo_print_print_posts', array( $this, 'print_posts_callback' ) );
		}

		/**
		 * @ignore Blank Method
		 */
		protected function register_hook_callbacks(){}

		/**
		 * Callback to handle `demo_print_print_posts` shortcode
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function print_posts_callback( $atts ) {
			return 	$this->get_view()->render_template(
				'frontend/print-posts-shortcode.php',
				[
					'fetched_posts'	=>	$this->get_model()->get_posts_for_shortcode( 'demo_print_print_posts', $atts )
				]
			);

		}

	}
}

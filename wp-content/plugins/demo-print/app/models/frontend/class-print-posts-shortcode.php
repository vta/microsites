<?php

namespace Demo_Print\App\Models\Frontend;

if ( ! class_exists( __NAMESPACE__ . '\\' . 'Print_Posts_Shortcode' ) ) {
	/**
	 * Class to handle data related operations of `example_me_print_posts` shortcode
	 *
	 * @since      1.0.0
	 * @package    Demo_Print
	 * @subpackage Demo_Print/Models/Frontend
	 */
	class Print_Posts_Shortcode extends Base_Model {
		/**
		 * Fetches posts from database
		 *
		 * @param string $shortcode Shortcode for which posts should be fetched
		 * @param array $atts Arguments passed to shortcode
		 * @return \WP_Query WP_Query Object
		 */
		public function get_posts_for_shortcode( $shortcode, $atts ) {
			$atts = shortcode_atts(
				array(
					'number_of_posts' => '10',
				), $atts, $shortcode
			);

			$args = array(
				'post_type' => 'post',
				'posts_per_page' => is_int( $atts['number_of_posts'] ) ? $atts['number_of_posts'] : 10,
			);

			return new \WP_Query( $args );
		}
	}
}

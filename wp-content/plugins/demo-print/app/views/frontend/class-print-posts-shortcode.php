<?php

namespace Demo_Print\App\Views\Frontend;

use \Demo_Print\Core\View;
use \Demo_Print as Demo_Print;

if (!class_exists(__NAMESPACE__ . '\\' . 'Print_Posts_Shortcode')) {
	/**
	 * Class Responsible for rendering the view of `demo_print_print_posts` shortcode
	 *
	 * @since      1.0.0
	 * @package    Demo_Print
	 * @subpackage Demo_Print/Views/Frontend
	 */
	class Print_Posts_Shortcode extends View
	{
		/**
		 * Method that prints html for the `demo_print_print_posts` shortcode
		 *
		 * @param array $args Arguments passed by controller's get_posts_for_shortcode method.
		 * @return void
		 */
		public function shortcode_html($args)
		{
			return $this->render_template(
				'frontend/print-posts-shortcode.php',
				$args
			);
		}

	}
}

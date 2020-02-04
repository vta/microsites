<?php
namespace Demo_Print\App\Views\Admin;

use Demo_Print\Core\View;
use Demo_Print as Demo_Print;

if ( ! class_exists( __NAMESPACE__ . '\\' . 'Admin_Settings' ) ) {
	/**
	 * View class to load all templates related to Plugin's Admin Settings Page
	 *
	 * @since      1.0.0
	 * @package    Demo_Print
	 * @subpackage Demo_Print/views/admin
	 */
	class Admin_Settings extends View {
		/**
		 * Prints Settings Page.
		 *
		 * @param  array $args Arguments passed by `markup_settings_page` method from `Demo_Print\App\Controllers\Admin\Admin_Settings` controller.
		 * @return void
		 * @since 1.0.0
		 */
		public function admin_settings_page( $args = [] ) {
			echo $this->render_template(
				'admin/page-settings/page-settings.php',
				$args
			); // WPCS: XSS OK.
		}

		/**
		 * Prints Section's Description.
		 *
		 * @param  array $args Arguments passed by `markup_section_headers` method from  `Demo_Print\App\Controllers\Admin\Admin_Settings` controller.
		 * @return void
		 * @since 1.0.0
		 */
		public function section_headers( $args = [] ) {
			echo $this->render_template(
				'admin/page-settings/page-settings-section-headers.php',
				$args
			); // WPCS: XSS OK.
		}

		/**
		 * Prints text field
		 *
		 * @param  array $args Arguments passed by `markup_fields` method from `Demo_Print\App\Controllers\Admin\Admin_Settings` controller.
		 * @return void
		 * @since 1.0.0
		 */
		public function markup_fields( $args = [] ) {
			echo $this->render_template(
				'admin/page-settings/page-settings-fields.php',
				$args
			); // WPCS: XSS OK.
		}
	}
}

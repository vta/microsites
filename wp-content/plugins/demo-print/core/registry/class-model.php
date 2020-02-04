<?php
namespace Demo_Print\Core\Registry;

if ( ! class_exists( __NAMESPACE__ . '\\' . 'Model' ) ) {
	/**
	 * Model Registry
	 *
	 * Maintains the list of all models objects
	 *
	 * @since      1.0.0
	 * @package    Demo_Print
	 * @subpackage Demo_Print/Core/Registry
	 * @author     Your Name <email@example.com>
	 */
	class Model {
		use Base_Registry;
	}
}

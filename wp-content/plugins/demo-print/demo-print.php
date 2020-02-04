<?php
/**
 * Main Plugin File
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Demo_Print
 *
 * @wordpress-plugin
 * Plugin Name:       Demo Print
 * Plugin URI:        http://example.com/demo-print-uri/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Your Name or Your Company
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       demo-print
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Creates/Maintains the object of Requirements Checker Class
 *
 * @return \Demo_Print\Includes\Requirements_Checker
 * @since 1.0.0
 */
function plugin_requirements_checker() {
	static $requirements_checker = null;

	if ( null === $requirements_checker ) {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-requirements-checker.php';
		$requirements_conf = apply_filters( 'demo_print_minimum_requirements', include_once( plugin_dir_path( __FILE__ ) . 'requirements-config.php' ) );
		$requirements_checker = new Demo_Print\Includes\Requirements_Checker( $requirements_conf );
	}

	return $requirements_checker;
}

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function run_demo_print() {

	// If Plugins Requirements are not met.
	if ( ! plugin_requirements_checker()->requirements_met() ) {
		add_action( 'admin_notices', array( plugin_requirements_checker(), 'show_requirements_errors' ) );

		// Deactivate plugin immediately if requirements are not met.
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		deactivate_plugins( plugin_basename( __FILE__ ) );

		return;
	}

	/**
	 * The core plugin class that is used to define internationalization,
	 * admin-specific hooks, and frontend-facing site hooks.
	 */
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-demo-print.php';

	/**
	 * Begins execution of the plugin.
	 *
	 * Since everything within the plugin is registered via hooks,
	 * then kicking off the plugin from this point in the file does
	 * not affect the page life cycle.
	 *
	 * @since    1.0.0
	 */
	$router_class_name = apply_filters( 'demo_print_router_class_name', '\Demo_Print\Core\Router' );
	$routes = apply_filters( 'demo_print_routes_file', plugin_dir_path( __FILE__ ) . 'routes.php' );
	$GLOBALS['demo_print'] = new Demo_Print( $router_class_name, $routes );

	register_activation_hook( __FILE__, array( new Demo_Print\App\Activator(), 'activate' ) );
	register_deactivation_hook( __FILE__, array( new Demo_Print\App\Deactivator(), 'deactivate' ) );
}

run_demo_print();

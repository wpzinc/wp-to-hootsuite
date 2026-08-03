<?php
/**
 * WP to Hootsuite WordPress Plugin.
 *
 * @package WP_To_Hootsuite
 * @author WP Zinc
 *
 * @wordpress-plugin
 * Plugin Name: WP to Hootsuite
 * Plugin URI: http://www.wpzinc.com/plugins/wordpress-to-hootsuite-pro
 * Version: 3.1.0
 * Author: WP Zinc
 * Author URI: http://www.wpzinc.com
 * Description: Send WordPress Pages, Posts or Custom Post Types to your Hootsuite (hootsuite.com) account for scheduled publishing to social networks.
 * Text Domain: wp-to-hootsuite
 * License:     GPLv3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Bail if Plugin is alread loaded.
if ( class_exists( 'WP_To_Hootsuite' ) ) {
	return;
}

// Define Plugin version and build date.
define( 'WP_TO_HOOTSUITE_PLUGIN_VERSION', '3.1.0' );
define( 'WP_TO_HOOTSUITE_PLUGIN_BUILD_DATE', '2026-08-05 18:00:00' );

// Define Plugin paths.
define( 'WP_TO_HOOTSUITE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'WP_TO_HOOTSUITE_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Define the autoloader for this Plugin
 *
 * @since   3.4.7
 *
 * @param   string $class_name     The class to load.
 */
function wp_to_hootsuite_autoloader( $class_name ) {

	// Only handle this vendor's namespaced classes.
	if ( strpos( $class_name, 'WPZinc\\' ) !== 0 ) {
		return;
	}

	// Build the file name from the class' short name.
	// e.g. WPZinc\Social\Log_Table -> class-log-table.php.
	$class_parts = explode( '\\', $class_name );
	$short_name  = end( $class_parts );
	$file_name   = 'class-' . str_replace( '_', '-', strtolower( $short_name ) ) . '.php';

	// Map the sub-namespace to the directories to search.
	$namespace_paths = array(
		'Social' => array(
			WP_TO_HOOTSUITE_PLUGIN_PATH . 'lib/social/includes',
			WP_TO_HOOTSUITE_PLUGIN_PATH . 'includes',
		),
		'Shared' => array(
			WP_TO_HOOTSUITE_PLUGIN_PATH . 'lib/shared',
		),
	);

	$sub_namespace = isset( $class_parts[1] ) ? $class_parts[1] : '';
	if ( ! isset( $namespace_paths[ $sub_namespace ] ) ) {
		return;
	}

	foreach ( $namespace_paths[ $sub_namespace ] as $path ) {
		if ( file_exists( $path . '/' . $file_name ) ) {
			require_once $path . '/' . $file_name;
			return;
		}
	}

}
spl_autoload_register( 'wp_to_hootsuite_autoloader' );

// Load Activation, Cron and Deactivation functions.
require_once WP_TO_HOOTSUITE_PLUGIN_PATH . 'includes/activation.php';
require_once WP_TO_HOOTSUITE_PLUGIN_PATH . 'includes/cron.php';
require_once WP_TO_HOOTSUITE_PLUGIN_PATH . 'includes/functions.php';
require_once WP_TO_HOOTSUITE_PLUGIN_PATH . 'includes/deactivation.php';
register_activation_hook( __FILE__, 'wp_to_hootsuite_activate' );
if ( version_compare( get_bloginfo( 'version' ), '5.1', '>=' ) ) {
	add_action( 'wp_insert_site', 'wp_to_hootsuite_activate_new_site' );
} else {
	add_action( 'wpmu_new_blog', 'wp_to_hootsuite_activate_new_site' );
}
add_action( 'activate_blog', 'wp_to_hootsuite_activate_new_site' );
register_deactivation_hook( __FILE__, 'wp_to_hootsuite_deactivate' );

/**
 * Main function to return Plugin instance.
 *
 * @since   3.8.1
 */
function WP_To_Hootsuite() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName

	return WP_To_Hootsuite::get_instance();

}

// Finally, initialize the Plugin.
require_once WP_TO_HOOTSUITE_PLUGIN_PATH . 'includes/class-wp-to-hootsuite.php';
$wp_to_hootsuite = WP_To_Hootsuite();

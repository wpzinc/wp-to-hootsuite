<?php
/**
 * Defines functions that are called by WordPress' Cron.
 *
 * @package WP_To_Hootsuite
 * @author WP Zinc
 */

/**
 * Define the WP Cron function to perform the log cleanup
 *
 * @since   3.9.8
 */
function wp_to_hootsuite_log_cleanup_cron() {

	// Initialise Plugin.
	$wp_to_hootsuite = WP_To_Hootsuite::get_instance();
	$wp_to_hootsuite->initialize();

	// Call CRON Log Cleanup function.
	$wp_to_hootsuite->get_class( 'cron' )->log_cleanup();

	// Shutdown.
	unset( $wp_to_hootsuite );

}
add_action( 'wp_to_hootsuite_log_cleanup_cron', 'wp_to_hootsuite_log_cleanup_cron' );

/**
 * Define the WP Cron function to refresh access tokens before they expire
 *
 * @since   6.2.0
 */
function wp_to_hootsuite_refresh_token_cron() {

	// Initialise Plugin.
	$wp_to_hootsuite = WP_To_Hootsuite::get_instance();
	$wp_to_hootsuite->initialize();

	// Refresh any access tokens that are due to expire.
	$wp_to_hootsuite->get_class( 'cron' )->refresh_token();

	// Shutdown.
	unset( $wp_to_hootsuite );

}
add_action( 'wp_to_hootsuite_refresh_token_cron', 'wp_to_hootsuite_refresh_token_cron' );

<?php
/**
 * WordPress to Hootsuite Pro general plugin functions.
 *
 * @package WP_To_Hootsuite_Pro
 * @author WP Zinc
 */

/**
 * Saves the new access token, refresh token and its expiry against
 * all accounts that have the existing access token.
 *
 * @since   3.0.1
 *
 * @param   array  $result                  New Access Token, Refresh Token and Expiry timestamp.
 * @param   string $client_id               OAuth Client ID used for the Access and Refresh Tokens.
 * @param   string $existing_access_token   Existing Access Token.
 */
function wp_to_hootsuite_update_credentials( $result, $client_id, $existing_access_token ) {

	// Get Plugin instance.
	$wp_to_hootsuite = WP_To_Hootsuite::get_instance();

	// Get the account ID based on the existing access token.
	$account_ids = $wp_to_hootsuite->get_class( 'settings' )->get_account_ids_by_access_token( $existing_access_token );

	// Bail if no accounts are found.
	if ( count( $account_ids ) === 0 ) {
		return;
	}

	// Update the access and refresh tokens for each account.
	foreach ( $account_ids as $account_id ) {
		$wp_to_hootsuite->get_class( 'settings' )->update_account_credentials(
			$result['access_token'],
			$result['refresh_token'],
			$result['token_expires'],
			$account_id
		);
	}

}

// Update Access Token when refreshed by the API class.
add_action( 'wp_to_hootsuite_pro_api_refresh_token', 'wp_to_hootsuite_update_credentials', 10, 3 );

/**
 * Schedules the WordPress Cron event to refresh the access token before it expires.
 *
 * Runs whenever an access token is refreshed, so that each token schedules the
 * refresh of its successor.
 *
 * @since   6.2.0
 */
function wp_to_hootsuite_schedule_refresh_token_event() {

	WP_To_Hootsuite::get_instance()->get_class( 'cron' )->reschedule_refresh_token_event();

}

// Schedule the next token refresh whenever a token is refreshed.
add_action( 'wp_to_hootsuite_pro_api_refresh_token', 'wp_to_hootsuite_schedule_refresh_token_event', 20 );

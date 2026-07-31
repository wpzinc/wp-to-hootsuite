<?php
/**
 * AJAX class.
 *
 * @package WPZinc\Social
 * @author WP Zinc
 */

namespace WPZinc\Social;

/**
 * Registers AJAX actions for saving statuses, fetching usernames,
 * searching Taxonomy Terms etc.
 *
 * @package WPZinc\Social
 * @author  WP Zinc
 * @version 3.0.0
 */
class Ajax {

	/**
	 * Holds the base class object.
	 *
	 * @since   3.4.7
	 *
	 * @var     object
	 */
	public $base;

	/**
	 * Constructor
	 *
	 * @since   3.0.0
	 *
	 * @param   object $base    Base Plugin Class.
	 */
	public function __construct( $base ) {

		// Store base class.
		$this->base = $base;

		// Actions.
		add_action( 'wp_ajax_' . $this->base->plugin->filter_name . '_username_save_twitter', array( $this, 'username_save_twitter' ) );
		add_action( 'wp_ajax_' . $this->base->plugin->filter_name . '_save_statuses', array( $this, 'save_statuses' ) );
		add_action( 'wp_ajax_' . $this->base->plugin->filter_name . '_get_status_row', array( $this, 'get_status_row' ) );
		add_action( 'wp_ajax_' . $this->base->plugin->filter_name . '_get_log', array( $this, 'get_log' ) );
		add_action( 'wp_ajax_' . $this->base->plugin->filter_name . '_clear_log', array( $this, 'clear_log' ) );

	}

	/**
	 * Saves the given Twitter username and user ID to the API.
	 *
	 * @since   4.1.0
	 */
	public function username_save_twitter() {

		// Run a security check first.
		check_ajax_referer( $this->base->plugin->name . '-username-save-twitter', 'nonce' );

		// Bail if no user ID or username was provided.
		if ( ! isset( $_REQUEST['user_id'] ) ) {
			wp_send_json_error( __( 'No user ID was provided.', 'wp-to-hootsuite' ) );
		}
		if ( ! isset( $_REQUEST['username'] ) ) {
			wp_send_json_error( __( 'No username was provided.', 'wp-to-hootsuite' ) );
		}

		// Sanitize inputs.
		$user_id  = sanitize_text_field( wp_unslash( $_REQUEST['user_id'] ) );
		$username = sanitize_text_field( wp_unslash( $_REQUEST['username'] ) );

		// Save.
		$results = $this->base->get_class( 'twitter_api' )->username_save( $user_id, $username );

		wp_send_json_success( $results );

	}

	/**
	 * Saves statuses for the given Post Type in the Plugin's Settings section.
	 *
	 * @since   4.0.8
	 */
	public function save_statuses() {

		// Run a security check first.
		check_ajax_referer( $this->base->plugin->name . '-save-statuses', 'nonce' );

		// Bail if no post type was provided.
		if ( ! isset( $_REQUEST['post_type'] ) ) {
			wp_send_json_error( __( 'No post type was provided.', 'wp-to-hootsuite' ) );
		}
		if ( ! isset( $_REQUEST['statuses'] ) ) {
			wp_send_json_error( __( 'No statuses were provided.', 'wp-to-hootsuite' ) );
		}

		// Parse request.
		$post_type = sanitize_text_field( wp_unslash( $_REQUEST['post_type'] ) );
		$statuses  = json_decode( wp_unslash( $_REQUEST['statuses'] ), true ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized

		// Get some other information.
		$post_type_object  = get_post_type_object( $post_type );
		$documentation_url = $this->base->plugin->documentation_url . '/status-settings';

		// Save and return.
		$result = $this->base->get_class( 'settings' )->update_settings( $post_type, $statuses );

		// Bail if an error occured.
		if ( is_wp_error( $result ) ) {
			wp_send_json_error( $result->get_error_message() );
		}

		// Return success, with flag denoting if the Post Type is configured to send statuses.
		wp_send_json_success(
			array(
				'post_type_enabled' => $this->base->get_class( 'settings' )->is_post_type_enabled( $post_type ),
			)
		);

	}

	/**
	 * Returns HTML markup that can be injected inside a <tr> to show the status' information
	 *
	 * @since   4.4.0
	 */
	public function get_status_row() {

		// Run a security check first.
		check_ajax_referer( $this->base->plugin->name . '-get-status-row', 'nonce' );

		// Bail if expect parameters were not was provided.
		if ( ! isset( $_REQUEST['status'] ) ) {
			wp_send_json_error( __( 'No status was provided.', 'wp-to-hootsuite' ) );
		}
		if ( ! isset( $_REQUEST['post_type'] ) ) {
			wp_send_json_error( __( 'No post type was provided.', 'wp-to-hootsuite' ) );
		}
		if ( ! isset( $_REQUEST['post_action'] ) ) {
			wp_send_json_error( __( 'No post action was provided.', 'wp-to-hootsuite' ) );
		}

		// Parse request.
		$status    = json_decode( wp_unslash( $_REQUEST['status'] ), true ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		$post_type = sanitize_text_field( wp_unslash( $_REQUEST['post_type'] ) );
		$action    = sanitize_text_field( wp_unslash( $_REQUEST['post_action'] ) );

		// Return array of row data (message, image, schedule).
		wp_send_json_success( $this->base->get_class( 'settings' )->get_status_row( $status, $post_type, $action ) );

	}

	/**
	 * Fetches the plugin log for the given Post ID, in HTML format
	 * compatible for insertion into the Log Table.
	 *
	 * @since   3.0.0
	 */
	public function get_log() {

		// Run a security check first.
		check_ajax_referer( $this->base->plugin->name . '-get-log', 'nonce' );

		// Bail if no post ID was provided.
		if ( ! isset( $_REQUEST['post'] ) ) {
			wp_send_json_error( __( 'No post ID was provided.', 'wp-to-hootsuite' ) );
		}

		// Get Post ID.
		$post_id = absint( $_REQUEST['post'] );

		// Return log table output.
		wp_send_json_success( $this->base->get_class( 'log' )->build_log_table_output( $this->base->get_class( 'log' )->get( $post_id ) ) );

	}

	/**
	 * Clears the plugin log for the given Post ID
	 *
	 * @since   3.0.0
	 */
	public function clear_log() {

		// Run a security check first.
		check_ajax_referer( $this->base->plugin->name . '-clear-log', 'nonce' );

		// Bail if no post ID was provided.
		if ( ! isset( $_REQUEST['post'] ) ) {
			wp_send_json_error( __( 'No post ID was provided.', 'wp-to-hootsuite' ) );
		}

		// Get Post ID.
		$post_id = absint( $_REQUEST['post'] );

		// Clear log.
		$this->base->get_class( 'log' )->delete_by_post_id( $post_id );

		wp_send_json_success();

	}

}

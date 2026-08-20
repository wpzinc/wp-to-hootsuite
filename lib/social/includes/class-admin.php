<?php
/**
 * Administration class.
 *
 * @package WPZinc\Social
 * @author WP Zinc
 */

namespace WPZinc\Social;

/**
 * Plugin settings screen and JS/CSS.
 *
 * @package WPZinc\Social
 * @author  WP Zinc
 * @version 3.0.0
 */
class Admin {

	/**
	 * Holds the base class object.
	 *
	 * @since   3.2.0
	 *
	 * @var     object
	 */
	public $base;

	/**
	 * Holds the success and error messages
	 *
	 * @since   3.2.6
	 *
	 * @var     array
	 */
	public $notices = array(
		'success' => array(),
		'error'   => array(),
	);

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
		add_action( 'init', array( $this, 'maybe_get_access_token' ) );
		add_action( 'init', array( $this, 'oauth' ) );
		add_action( 'init', array( $this, 'check_plugin_setup' ) );
		add_action( 'admin_notices', array( $this, 'admin_notices' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts_css' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_filter( 'plugin_action_links_' . $this->base->plugin->name . '/' . $this->base->plugin->name . '.php', array( $this, 'plugin_action_links_settings_page' ) );

	}

	/**
	 * Exchanges the authorization code for an access token, if included in the request.
	 *
	 * @since   6.0.0
	 */
	public function maybe_get_access_token() {

		// If a code is included in the request, exchange it for an access token.
		if ( ! filter_has_var( INPUT_GET, $this->base->plugin->settingsName . '-code' ) ) {
			return;
		}

		// Bail if nonce is not valid.
		if ( ! isset( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_REQUEST['_wpnonce'] ) ), $this->base->plugin->filter_name . '_oauth' ) ) {
			return;
		}

		// Bail if the current user cannot manage the plugin's settings.
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// Setup notices class.
		$this->base->get_class( 'notices' )->set_key_prefix( $this->base->plugin->filter_name . '_' . wp_get_current_user()->ID );

		// Sanitize token.
		$authorization_code = filter_input( INPUT_GET, $this->base->plugin->settingsName . '-code', FILTER_SANITIZE_FULL_SPECIAL_CHARS );

		// Exchange the authorization code and verifier for an access token.
		$tokens = $this->base->get_class( 'api' )->get_access_token( $authorization_code );

		// If an error occured, add it to the notices.
		if ( is_wp_error( $tokens ) ) {
			$this->base->get_class( 'notices' )->add_error_notice( $tokens->get_error_message() );
			return;
		}

		// Store messages.
		$this->base->get_class( 'notices' )->enable_store();

		// Fetch Organizations.
		$organizations = $this->base->get_class( 'api' )->organizations( true );

		// If an error occured, add it to the notices.
		if ( is_wp_error( $organizations ) ) {
			$this->base->get_class( 'notices' )->add_error_notice( $organizations->get_error_message() );
			return;
		}

		// If an account ID is included in the request, delete that account before adding the account.
		// This handles account re-connection where we're coming from the old API.
		$existing_account_id = false;
		if ( filter_has_var( INPUT_GET, 'account_id' ) ) {
			$existing_account_id = filter_input( INPUT_GET, 'account_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			$this->base->get_class( 'settings' )->delete_account( $existing_account_id );
		}

		// For each organization, fetch the profiles and store the organization as an account in the Plugin.
		foreach ( $organizations as $account ) {
			// If the existing account ID is set, and it matches the current account ID, skip.
			if ( $existing_account_id && $existing_account_id !== 'default' && $existing_account_id !== $account['id'] ) {
				continue;
			}

			// Fetch Profiles.
			$profiles = $this->base->get_class( 'api' )->profiles( true, $account['id'] );

			// If something went wrong, show an error.
			if ( is_wp_error( $profiles ) ) {
				$this->base->get_class( 'notices' )->add_error_notice( $profiles->get_error_message() );
				continue;
			}

			// Update account.
			$this->base->get_class( 'settings' )->update_account(
				$tokens['access_token'],
				$tokens['refresh_token'],
				$tokens['token_expires'],
				$account['id'],
				$account['name'],
				$account['email'],
				$account['channel_limit'],
				$account['plan'],
				array_keys( $profiles )
			);
		}

		// Store success message.
		$this->base->get_class( 'notices' )->add_success_notice(
			sprintf(
				/* translators: %1$s: Social Media Service Name (Buffer, Hootsuite), %2$s: Social Media Service Name (Buffer, Hootsuite) */
				__( 'Thanks! You\'ve connected our Plugin to %1$s. Now select profiles below to enable, and define your statuses to start sending Posts to %2$s', 'wp-to-hootsuite' ),
				$this->base->plugin->account,
				$this->base->plugin->account
			)
		);

		// Redirect to Post tab.
		wp_safe_redirect( 'admin.php?page=' . $this->base->plugin->name . '-settings&tab=post&type=post' );
		die();

	}

	/**
	 * Handles displaying any errors from the OAuth process, and storing the access token if supplied,
	 * when the OAuth gateway exchanges the authorization code for an access token.
	 *
	 * Used by:
	 * - WP to Hootsuite
	 * - WP to Hootsuite Pro
	 *
	 * @since   3.3.3
	 */
	public function oauth() {

		// Setup notices class.
		$this->base->get_class( 'notices' )->set_key_prefix( $this->base->plugin->filter_name . '_' . wp_get_current_user()->ID );

		// Bail if nonce is not valid, to prevent OAuth callback CSRF.
		if ( ! isset( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_REQUEST['_wpnonce'] ) ), $this->base->plugin->filter_name . '_oauth' ) ) {
			return;
		}

		// Bail if the current user cannot manage the plugin's settings.
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		/**
		 * Perform any pre-oAuth actions now, such as starting the oAuth process
		 *
		 * @since   4.2.0
		 */
		do_action( $this->base->plugin->filter_name . '_save_settings_auth' );

		// If we've returned from the oAuth process and an error occured, add it to the notices.
		if ( filter_has_var( INPUT_GET, $this->base->plugin->settingsName . '-oauth-error' ) ) {
			$oauth_error = filter_input( INPUT_GET, $this->base->plugin->settingsName . '-oauth-error', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			switch ( $oauth_error ) {
				/**
				 * Access Denied
				 * - User denied our app access
				 */
				case 'access_denied':
					$this->base->get_class( 'notices' )->add_error_notice(
						sprintf(
							/* translators: %1$s: Social Media Service Name (Buffer, Hootsuite), %2$s: Social Media Service Name (Buffer, Hootsuite) */
							__( 'You did not grant our Plugin access to your %1$s account. We are unable to post to %2$s until you do this. Please click on the Authorize Plugin button.', 'wp-to-hootsuite' ),
							$this->base->plugin->account,
							$this->base->plugin->account
						)
					);
					break;

				/**
				 * Invalid Grant
				 * - A parameter sent by the oAuth gateway is wrong
				 */
				case 'invalid_grant':
					$this->base->get_class( 'notices' )->add_error_notice(
						sprintf(
							'%1$s <a href="%2$s" target="_blank">%3$s</a>',
							sprintf(
								/* translators: Social Media Service Name (Buffer, Hootsuite) */
								__( 'We were unable to complete authentication with %s.  Please try again, or', 'wp-to-hootsuite' ),
								$this->base->plugin->account
							),
							esc_html( $this->base->plugin->support_url ),
							__( 'contact us for support', 'wp-to-hootsuite' )
						)
					);
					break;

				/**
				 * Expired Token
				 * - The oAuth gateway did not exchange the code for an access token within 30 seconds
				 */
				case 'expired_token':
					$this->base->get_class( 'notices' )->add_error_notice(
						sprintf(
							'%1$s <a href="%2$s" target="_blank">%3$s</a> %4$s',
							__( 'The oAuth process has expired.  Please try again, or', 'wp-to-hootsuite' ),
							esc_html( $this->base->plugin->support_url ),
							__( 'contact us for support', 'wp-to-hootsuite' ),
							__( 'if this issue persists.', 'wp-to-hootsuite' )
						)
					);
					break;

				/**
				 * Other Error
				 */
				default:
					$this->base->get_class( 'notices' )->add_error_notice(
						filter_input( INPUT_GET, $this->base->plugin->settingsName . '-oauth-error', FILTER_SANITIZE_FULL_SPECIAL_CHARS )
					);
					break;
			}
		}

		// If an Access Token is included in the request, store it and show a success message.
		if ( filter_has_var( INPUT_GET, $this->base->plugin->settingsName . '-oauth-access-token' ) ) {
			// Define tokens and expiry.
			$access_token  = filter_input( INPUT_GET, $this->base->plugin->settingsName . '-oauth-access-token', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			$refresh_token = filter_input( INPUT_GET, $this->base->plugin->settingsName . '-oauth-refresh-token', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			$expiry        = filter_input( INPUT_GET, $this->base->plugin->settingsName . '-oauth-expires', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			if ( $expiry > 0 ) {
				$expiry = strtotime( '+' . $expiry . ' seconds' );
			}

			// Setup API.
			$this->base->get_class( 'api' )->set_tokens( $access_token, $refresh_token, $expiry );

			// Fetch Account.
			$account = $this->base->get_class( 'api' )->account();

			// If something went wrong, show an error.
			if ( is_wp_error( $account ) ) {
				$this->base->get_class( 'notices' )->add_error_notice( $account->get_error_message() );
				return;
			}

			// Fetch Profiles.
			$profiles = $this->base->get_class( 'api' )->profiles( true, $account['id'] );

			// If something went wrong, show an error.
			if ( is_wp_error( $profiles ) ) {
				$this->base->get_class( 'notices' )->add_error_notice( $profiles->get_error_message() );
				return;
			}

			// Test worked! Save Tokens and Expiry.
			$this->base->get_class( 'settings' )->update_account(
				$access_token,
				$refresh_token,
				$expiry,
				$account['id'],
				$account['name'],
				$account['email'],
				$account['channel_limit'],
				$account['plan'],
				array_keys( $profiles )
			);

			// Store success message.
			$this->base->get_class( 'notices' )->enable_store();
			$this->base->get_class( 'notices' )->add_success_notice(
				sprintf(
					/* translators: %1$s: Social Media Service Name (Buffer, Hootsuite), %2$s: Social Media Service Name (Buffer, Hootsuite) */
					__( 'Thanks! You\'ve connected our Plugin to %1$s. Now select profiles below to enable, and define your statuses to start sending Posts to %2$s', 'wp-to-hootsuite' ),
					$this->base->plugin->account,
					$this->base->plugin->account
				)
			);

			// Redirect to Post tab.
			wp_safe_redirect( 'admin.php?page=' . $this->base->plugin->name . '-settings&tab=post&type=post' );
			die();
		}

	}

	/**
	 * Checks that the oAuth authorization flow has been completed, and that
	 * at least one Post Type with one Social Media account has been enabled.
	 *
	 * Displays a dismissible WordPress notification if this has not been done.
	 *
	 * @since   1.0.0
	 */
	public function check_plugin_setup() {

		// Show an error if cURL hasn't been installed.
		if ( ! function_exists( 'curl_init' ) ) {
			$this->base->get_class( 'notices' )->add_error_notice(
				sprintf(
					/* translators: Plugin Name */
					__( '%s requires the PHP cURL extension to be installed and enabled by your web host.', 'wp-to-hootsuite' ),
					$this->base->plugin->displayName
				)
			);
		}

		// Don't display the notice if this request is for the settings auth screen.
		$screen = $this->base->get_class( 'screen' )->get_current_screen();
		if ( $screen['screen'] === 'settings' && $screen['section'] === 'auth' ) {
			return;
		}

		// Check the API is connected.
		if ( ! $this->base->get_class( 'settings' )->account_connected() ) {
			// Display the notice.
			$this->base->get_class( 'notices' )->add_error_notice(
				sprintf(
					'%1$s <a href="%2$s">%3$s</a>',
					sprintf(
						/* translators: %1$s: Plugin Name, %2$s, %3$s: Social Media Service Name (Buffer, Hootsuite), %4$s: URL to Authorize Plugin Screen, %5$s: URL to Register Account with Service */
						esc_html__( '%1$s needs to be authorized with %2$s before you can start sending Posts to %3$s.', 'wp-to-hootsuite' ),
						$this->base->plugin->displayName,
						$this->base->plugin->account,
						$this->base->plugin->account
					),
					admin_url( 'admin.php?page=' . $this->base->plugin->name . '-settings' ),
					esc_html__( 'Click here to Authorize.', 'wp-to-hootsuite' )
				)
			);
		}

		// Buffer: If an access token begins with '2/', it's from the old API.
		$accounts = $this->base->get_class( 'settings' )->get_accounts();
		foreach ( $accounts as $account ) {
			if ( strpos( $account['access_token'], '2/' ) === 0 ) {
				$this->base->get_class( 'notices' )->add_error_notice(
					sprintf(
						/* translators: %1$s: Plugin Name, %2$s: Social Media Service Name (Buffer, Hootsuite) */
						__( '%1$s uses a new API. Please click the `Reconnect` button at %2$s Settings > Authentication to reconnect your account. You won\'t need to do this again.', 'wp-to-hootsuite' ),
						$this->base->plugin->displayName,
						$this->base->plugin->account
					)
				);
			}
		}
	}

	/**
	 * Checks the transient to see if any admin notices need to be output now.
	 *
	 * @since   3.9.6
	 */
	public function admin_notices() {

		// Output notices.
		$this->base->get_class( 'notices' )->set_key_prefix( $this->base->plugin->filter_name . '_' . wp_get_current_user()->ID );
		$this->base->get_class( 'notices' )->output_notices();

	}

	/**
	 * Register and enqueue any JS and CSS for the WordPress Administration
	 *
	 * @since 1.0.0
	 */
	public function admin_scripts_css() {

		global $id, $post;

		// Get current screen.
		$screen = $this->base->get_class( 'screen' )->get_current_screen();

		// CSS - always load.
		wp_enqueue_style( $this->base->plugin->name, $this->base->plugin->url . 'lib/social/assets/css/admin.css', array(), $this->base->plugin->version );

		// Define CSS variables for design.
		wp_register_style( $this->base->plugin->name . '-vars', false, array(), $this->base->plugin->version );
		wp_enqueue_style( $this->base->plugin->name . '-vars' );
		wp_add_inline_style(
			$this->base->plugin->name . '-vars',
			trim(
				':root {
			--wpzinc-logo: url(\'' . esc_attr( $this->base->plugin->logo ) . '\');
			--wpzinc-header-background-color: ' . esc_attr( $this->base->plugin->header_background_color ) . ';
			--wpzinc-header-primary-text-color: ' . esc_attr( $this->base->plugin->header_primary_text_color ) . ';
			--wpzinc-header-secondary-text-color: ' . esc_attr( $this->base->plugin->header_secondary_text_color ) . ';
			--wpzinc-plugin-display-name: "' . esc_attr( $this->base->plugin->displayName ) . ' ";
		}'
			)
		);

		// Don't load anything else if we're not on a Plugin or Post screen.
		if ( ! $screen['screen'] ) {
			return;
		}

		// Determine whether to load minified versions of JS.
		$minified = $this->base->dashboard->should_load_minified_js();

		// Define JS and localization.
		wp_register_script( $this->base->plugin->name . '-log', $this->base->plugin->url . 'lib/social/assets/js/' . ( $minified ? 'min/' : '' ) . 'log' . ( $minified ? '-min' : '' ) . '.js', array( 'jquery' ), $this->base->plugin->version, true );
		wp_register_script( $this->base->plugin->name . '-statuses', $this->base->plugin->url . 'lib/social/assets/js/' . ( $minified ? 'min/' : '' ) . 'statuses' . ( $minified ? '-min' : '' ) . '.js', array( 'jquery' ), $this->base->plugin->version, true );

		// Define localization for statuses.
		$localization = array(
			'ajax'                     => admin_url( 'admin-ajax.php' ),

			'clear_log_nonce'          => wp_create_nonce( $this->base->plugin->name . '-clear-log' ),
			'clear_log_completed'      => sprintf(
				/* translators: Social Media Service Name (Buffer, Hootsuite) */
				__( 'No log entries exist, or no status updates have been sent to %s.', 'wp-to-hootsuite' ),
				$this->base->plugin->account
			),

			'get_log_nonce'            => wp_create_nonce( $this->base->plugin->name . '-get-log' ),

			'delete_condition_message' => __( 'Are you sure you want to delete this condition?', 'wp-to-hootsuite' ),
			'delete_status_message'    => __( 'Are you sure you want to delete this status?', 'wp-to-hootsuite' ),

			'get_status_row_action'    => $this->base->plugin->filter_name . '_get_status_row',
			'get_status_row_nonce'     => wp_create_nonce( $this->base->plugin->name . '-get-status-row' ),

			'post_id'                  => ( isset( $post->ID ) ? $post->ID : (int) $id ),

			// Plugin specific Status Form Container and Status Form, so statuses.js knows where to look for the form
			// relative to this Plugin.
			'plugin_name'              => $this->base->plugin->name,
			'status_form_container'    => '#' . $this->base->plugin->name . '-status-form-container',
			'status_form'              => '#' . $this->base->plugin->name . '-status-form',

			// status.js appends profile service to this e.g. twitter,facebook.
			'usernames_search_action'  => $this->base->plugin->filter_name . '_usernames_search_',
		);

		// If here, we're on a Plugin or Post screen.
		// Conditionally load scripts and styles depending on which section of the Plugin we're loading.
		switch ( $screen['screen'] ) {
			/**
			 * Post
			 */
			case 'post':
				switch ( $screen['section'] ) {
					/**
					 * WP_List_Table
					 */
					case 'wp_list_table':
						break;

					/**
					 * Add/Edit
					 */
					case 'edit':
						// Plugin JS.
						wp_enqueue_script( $this->base->plugin->name . '-log' );

						// Localize.
						wp_localize_script( $this->base->plugin->name . '-log', 'wpzinc_social', $localization );
						break;
				}
				break;

			/**
			 * Settings
			 */
			case 'settings':
				// JS.
				wp_enqueue_script( 'wpzinc-admin-conditional' );
				wp_enqueue_media();
				wp_enqueue_script( 'wpzinc-admin-tabs' );
				wp_enqueue_script( 'wpzinc-admin' );

				switch ( $screen['section'] ) {
					/**
					 * General
					 */
					case 'auth':
						break;

					/**
					 * Post Type
					 */
					default:
						// JS.
						wp_enqueue_script( 'wpzinc-admin-autocomplete' );
						wp_enqueue_script( 'wpzinc-admin-autosize' );
						wp_enqueue_script( 'wpzinc-admin-modal' );
						wp_enqueue_script( 'jquery-ui-sortable' );

						// Plugin JS.
						wp_enqueue_script( $this->base->plugin->name . '-statuses' );

						// Add Twitter Username Save Action and Nonce.
						$localization['username_save_twitter_action'] = $this->base->plugin->filter_name . '_username_save_twitter';
						$localization['username_save_twitter_nonce']  = wp_create_nonce( $this->base->plugin->name . '-username-save-twitter' );

						// Localize.
						wp_localize_script( $this->base->plugin->name . '-settings', 'wpzinc_social', $localization );

						// Add Post Type, Action and Nonce to allow AJAX saving.
						$localization['post_type']              = $this->get_post_type_tab();
						$localization['prompt_unsaved_changes'] = true;
						$localization['save_statuses_action']   = $this->base->plugin->filter_name . '_save_statuses';
						$localization['save_statuses_modal']    = array(
							'title'         => __( 'Saving', 'wp-to-hootsuite' ),
							'title_success' => __( 'Saved!', 'wp-to-hootsuite' ),
						);
						$localization['save_statuses_nonce']    = wp_create_nonce( $this->base->plugin->name . '-save-statuses' );

						// Localize Statuses.
						wp_localize_script( $this->base->plugin->name . '-statuses', 'wpzinc_social', $localization );

						// Localize Autocomplete.
						wp_localize_script( 'wpzinc-admin-autocomplete', 'wpzinc_autocomplete', $this->get_autocomplete_configuration( $localization['post_type'] ) );
						break;
				}
				break;

			/**
			 * Log
			 */
			case 'log':
				// Plugin JS.
				wp_enqueue_script( $this->base->plugin->name . '-log' );

				// Localize.
				wp_localize_script( $this->base->plugin->name . '-log', 'wpzinc_social', $localization );
				break;
		}

	}

	/**
	 * Returns configuration for tribute.js autocomplete instances for Tags, Facebook Pages and Twitter Username mentions.
	 *
	 * @since   4.5.7
	 *
	 * @param   string $post_type  Post Type.
	 * @return  array               Javascript  Autocomplete Configuration
	 */
	private function get_autocomplete_configuration( $post_type ) {

		$autocomplete_configuration = array(
			// Tags.
			array(
				'fields'   => array(
					'textarea.message',
					'input.url',
				),
				'triggers' => array(
					// Tags.
					array(
						'trigger' => '{',
						'values'  => $this->base->get_class( 'common' )->get_tags_flat( $post_type ),
					),
				),
			),
		);

		/**
		 * Defines configuration for tribute.js autocomplete instances for Tags, Facebook Pages and Twitter Username mentions.
		 *
		 * @since   4.5.7
		 *
		 * @param   array   $autocomplete_configuration     Javascript  Autocomplete Configuration.
		 */
		$autocomplete_configuration = apply_filters( $this->base->plugin->filter_name . '_admin_get_autocomplete_configuration', $autocomplete_configuration );

		// Return.
		return $autocomplete_configuration;

	}

	/**
	 * Add the Plugin to the WordPress Administration Menu
	 *
	 * @since   1.0.0
	 */
	public function admin_menu() {

		// Define the minimum capability required to access settings.
		$minimum_capability = 'manage_options';

		/**
		 * Defines the minimum capability required to access the Plugin's
		 * Menu and Sub Menus
		 *
		 * @since   4.3.6
		 *
		 * @param   string  $capability     Minimum Required Capability.
		 * @return  string                  Minimum Required Capability
		 */
		$minimum_capability = apply_filters( $this->base->plugin->filter_name . '_admin_admin_menu_minimum_capability', $minimum_capability );

		/**
		 * Add settings menus and sub menus for the Plugin's settings.
		 *
		 * @since   5.2.4
		 *
		 * @param   string  $minimum_capability     Minimum capability required.
		 */
		do_action( $this->base->plugin->filter_name . '_admin_admin_menu', $minimum_capability );

	}

	/**
	 * Define links to display below the Plugin Name on the WP_List_Table at in the Plugins screen.
	 *
	 * @since   5.0.2
	 *
	 * @param   array $links      Links.
	 * @return  array               Links
	 */
	public function plugin_action_links_settings_page( $links ) {

		// Add link to Plugin settings screen.
		$links['settings'] = sprintf(
			'<a href="%s">%s</a>',
			add_query_arg(
				array(
					'page' => $this->base->plugin->name . '-settings',
				),
				admin_url( 'admin.php' )
			),
			__( 'Settings', 'wp-to-hootsuite' )
		);

		// Return.
		return $links;

	}

	/**
	 * Upgrade Screen
	 *
	 * @since 3.2.5
	 */
	public function upgrade_screen() {
		// We never reach here, as we redirect earlier in the process.
	}

	/**
	 * Outputs the Settings Screen
	 *
	 * @since   3.0.0
	 */
	public function settings_screen() {

		// Setup notices class.
		$this->base->get_class( 'notices' )->set_key_prefix( $this->base->plugin->filter_name . '_' . wp_get_current_user()->ID );

		// Maybe disconnect an account.
		$this->maybe_disconnect_account();

		// Maybe refresh profiles.
		$this->maybe_refresh_profiles();

		// Maybe save settings.
		$result = $this->save_settings();
		if ( is_wp_error( $result ) ) {
			// Error notice.
			$this->base->get_class( 'notices' )->add_error_notice( $result->get_error_message() );
		} elseif ( $result === true ) {
			// Success notice.
			$this->base->get_class( 'notices' )->add_success_notice( __( 'Settings saved successfully.', 'wp-to-hootsuite' ) );
		}

		// If the Plugin isn't connected an account, show the screen to do this now.
		if ( ! $this->base->get_class( 'settings' )->account_connected() ) {
			$this->auth_screen();
			return;
		}

		// Get Profiles for accounts.
		$profiles = $this->get_cached_profiles();

		// Get Settings Tab and Post Type we're managing settings for.
		$tab                 = $this->get_tab( $profiles );
		$post_type           = $this->get_post_type_tab();
		$disable_save_button = false;

		// Post Types.
		$post_types = $this->base->get_class( 'common' )->get_post_types();

		// Accounts.
		$accounts = $this->base->get_class( 'settings' )->get_accounts();

		// Depending on the screen we're on, load specific options.
		switch ( $tab ) {
			/**
			 * Settings
			 */
			case 'auth':
				// Log Settings.
				$log_levels = $this->base->get_class( 'log' )->get_level_options();

				// Documentation URL.
				$documentation_url = $this->base->plugin->documentation_url . '/authentication-settings';
				break;

			/**
			 * No Profiles
			 */
			case 'profiles-missing':
				// Disable Save button, as there are no settings displayed to save.
				$disable_save_button = true;

				// Documentation URL.
				$documentation_url = $this->base->plugin->documentation_url . '/status-settings';
				break;

			/**
			 * Profiles Error
			 */
			case 'profiles-error':
				// Disable Save button, as there are no settings displayed to save.
				$disable_save_button = true;

				// Documentation URL.
				$documentation_url = $this->base->plugin->documentation_url . '/status-settings';
				break;

			/**
			 * Post Type
			 */
			default:
				// Get original statuses that will be stored in a hidden field so they are preserved if the screen is saved
				// with no changes that trigger an update to the hidden field.
				$original_statuses = $this->base->get_class( 'settings' )->get_settings( $post_type );

				// Get some other information.
				$post_type_object  = get_post_type_object( $post_type );
				$actions_plural    = $this->base->get_class( 'common' )->get_post_actions_past_tense();
				$post_actions      = $this->base->get_class( 'common' )->get_post_actions();
				$documentation_url = $this->base->plugin->documentation_url . '/status-settings';
				$is_post_screen    = false; // Disables the 'specific' schedule option, which can only be used on individual Per-Post Settings.

				// Check if this Post Type is enabled.
				if ( ! $this->base->get_class( 'settings' )->is_post_type_enabled( $post_type ) ) {
					$this->base->get_class( 'notices' )->add_warning_notice(
						sprintf(
							'%1$s <a href="%2$s" target="_blank">%3$s</a>',
							sprintf(
								/* translators: %1$s: Post Type, %2$s: Social Media Service Name (Buffer, Hootsuite), %3$s: Documentation URL */
								__( 'To send %1$s to %2$s, at least one action on the Defaults tab must be enabled with a status defined, and at least one social media profile must be enabled below by clicking the applicable profile name and ticking the "Account Enabled" box.', 'wp-to-hootsuite' ),
								$post_type_object->label,
								$this->base->plugin->account
							),
							$documentation_url,
							__( 'See Documentation', 'wp-to-hootsuite' )
						)
					);
				}
				break;
		}

		// Load View.
		include_once $this->base->plugin->folder . 'lib/social/views/settings.php';

		// Add footer action to output overlay modal markup.
		add_action( 'admin_footer', array( $this, 'output_modal' ) );

	}

	/**
	 * Outputs the auth screen, allowing the user to begin the process of connecting the Plugin
	 * to the API, without showing other settings.
	 *
	 * @since   4.6.4
	 */
	public function auth_screen() {

		// Load View.
		include_once $this->base->plugin->folder . 'lib/social/views/settings-auth-required.php';

	}

	/**
	 * Outputs the hidden Javascript Modal and Overlay in the Footer
	 *
	 * @since   1.0.0
	 */
	public function output_modal() {

		// Load view.
		require_once $this->base->plugin->folder . 'lib/shared/views/modal.php';

	}

	/**
	 * Outputs the Log Screen
	 *
	 * @since   3.9.6
	 */
	public function log_screen() {

		// Init table.
		$table = new \WPZinc\Social\Log_Table( $this->base );
		$table->prepare_items();

		// Load View.
		include_once $this->base->plugin->folder . 'lib/social/views/log.php';

	}

	/**
	 * Helper method to get the setting value from the plugin settings
	 *
	 * @since   3.0.0
	 *
	 * @param   string $type            Setting Type.
	 * @param   string $key             Setting Key.
	 * @param   mixed  $default_value   Default Value if Setting does not exist.
	 * @return  mixed                   Value
	 */
	public function get_setting( $type = '', $key = '', $default_value = '' ) {

		// Post Type Setting or Bulk Setting.
		if ( post_type_exists( $type ) ) {
			return $this->base->get_class( 'settings' )->get_setting( $type, $key, $default_value );
		}

		// Depending on the type, return settings / options.
		switch ( $type ) {
			case 'text_to_image':
			case 'log':
			case 'hide_meta_box_by_roles':
			case 'roles':
			case 'custom_tags':
			case 'repost':
				return $this->base->get_class( 'settings' )->get_setting( $type, $key, $default_value );

			default:
				return $this->base->get_class( 'settings' )->get_option( $key, $default_value );
		}

	}

	/**
	 * Fetches fresh profiles from the API for the given account, if the
	 * user clicks the refresh profiles link. Bypasses the transient cache
	 * and updates the stored profile IDs on the account.
	 *
	 * @since   6.1.2
	 */
	private function maybe_refresh_profiles() {

		// Bail if no nonce.
		if ( ! isset( $_GET['nonce'] ) ) {
			return;
		}

		// Bail if nonce is invalid.
		if ( ! wp_verify_nonce( sanitize_key( $_GET['nonce'] ), $this->base->plugin->name . '-refresh-profiles' ) ) {
			return;
		}

		// Bail if account ID is not set.
		if ( ! isset( $_GET[ $this->base->plugin->name . '-refresh-profiles' ] ) ) {
			return;
		}

		// Get account.
		$account_id = sanitize_text_field( wp_unslash( $_GET[ $this->base->plugin->name . '-refresh-profiles' ] ) );
		$accounts   = $this->base->get_class( 'settings' )->get_accounts();
		if ( ! isset( $accounts[ $account_id ] ) ) {
			return;
		}
		$account = $accounts[ $account_id ];

		// Configure API for this account.
		$this->base->get_class( 'api' )->set_tokens( $account['access_token'], $account['refresh_token'], $account['token_expires'] );

		// Fetch fresh profiles from the API.
		$profiles = $this->base->get_class( 'api' )->profiles( true, $account_id );

		// Display error and bail.
		if ( is_wp_error( $profiles ) ) {
			$this->base->get_class( 'notices' )->add_error_notice( $profiles->get_error_message() );
			return;
		}

		// If the service supports organizations, refresh the stored account
		// information (name, email, channel limit, plan) alongside the profiles.
		$organizations = array();
		$api           = $this->base->get_class( 'api' );
		if ( method_exists( $api, 'organizations' ) ) {
			$organizations = $api->organizations( true );

			// Display error and bail.
			if ( is_wp_error( $organizations ) ) {
				$this->base->get_class( 'notices' )->add_error_notice( $organizations->get_error_message() );
				return;
			}
		}

		// Update the stored account information (where available) and profile IDs.
		if ( isset( $organizations[ $account_id ] ) ) {
			$this->base->get_class( 'settings' )->update_account_information(
				$account_id,
				$organizations[ $account_id ]['name'],
				$organizations[ $account_id ]['email'],
				$organizations[ $account_id ]['channel_limit'],
				$organizations[ $account_id ]['plan'],
				array_keys( $profiles )
			);

			// Schedule the event to refresh this account's access token before it expires.
			$this->base->get_class( 'cron' )->reschedule_refresh_token_event();
		} else {
			$this->base->get_class( 'settings' )->update_account_profile_ids( $account_id, array_keys( $profiles ) );
		}

		$this->base->get_class( 'notices' )->add_success_notice(
			__( 'Profiles refreshed successfully.', 'wp-to-hootsuite' )
		);

	}

	/**
	 * Disconnects an account if the user clicks the disconnect link.
	 *
	 * @since   5.4.0
	 */
	private function maybe_disconnect_account() {

		// Bail if no nonce.
		if ( ! isset( $_GET['nonce'] ) ) {
			return;
		}

		// Bail if nonce is invalid.
		if ( ! wp_verify_nonce( sanitize_key( $_GET['nonce'] ), $this->base->plugin->name . '-disconnect' ) ) {
			return;
		}

		// Bail if account ID is not set.
		if ( ! isset( $_GET[ $this->base->plugin->name . '-disconnect' ] ) ) {
			return;
		}

		// Disconnect account.
		$this->base->get_class( 'settings' )->delete_account( sanitize_text_field( wp_unslash( $_GET[ $this->base->plugin->name . '-disconnect' ] ) ) );
		$this->base->get_class( 'notices' )->add_success_notice(
			sprintf(
				/* translators: Social Media Service Name (Buffer, Hootsuite) */
				__( '%s account disconnected successfully.', 'wp-to-hootsuite' ),
				$this->base->plugin->account
			)
		);

	}

	/**
	 * Helper method to save settings
	 *
	 * @since   3.0.0
	 *
	 * @return  mixed   \WP_Error | bool
	 */
	public function save_settings() {

		// Check if a POST request was made.
		if ( ! isset( $_POST['submit'] ) ) {
			return false;
		}

		// Missing nonce.
		if ( ! isset( $_POST[ $this->base->plugin->name . '_nonce' ] ) ) {
			return new \WP_Error(
				$this->base->plugin->filter_name . '_admin_save_settings_error',
				__( 'Nonce field is missing. Settings NOT saved.', 'wp-to-hootsuite' )
			);
		}

		// Invalid nonce.
		if ( ! wp_verify_nonce( sanitize_key( $_POST[ $this->base->plugin->name . '_nonce' ] ), $this->base->plugin->name ) ) {
			return new \WP_Error(
				$this->base->plugin->filter_name . '_admin_save_settings_error',
				__( 'Invalid nonce specified. Settings NOT saved.', 'wp-to-hootsuite' )
			);
		}

		// Get URL parameters.
		$tab       = $this->get_tab();
		$post_type = $this->get_post_type_tab();

		switch ( $tab ) {
			/**
			 * Authentication
			 */
			case 'auth':
				// oAuth settings are now handled by this class' oauth() function.
				// Save other Settings.
				$settings = map_deep( $_POST, 'sanitize_text_field' );

				// General Settings.
				$this->base->get_class( 'settings' )->update_option( 'test_mode', ( isset( $settings['test_mode'] ) ? 1 : 0 ) );
				$this->base->get_class( 'settings' )->update_option( 'force_trailing_forwardslash', ( isset( $settings['force_trailing_forwardslash'] ) ? 1 : 0 ) );
				$this->base->get_class( 'settings' )->update_option( 'proxy', ( isset( $settings['proxy'] ) ? 1 : 0 ) );

				// Log Settings.
				// Always force errors.
				$log = isset( $settings['log'] ) ? $settings['log'] : array();
				if ( ! isset( $log['log_level'] ) ) {
					$log['log_level'] = array(
						'error',
					);
				} else {
					// 'Error' is disabled on the form and not sent if another option is chosen.
					// We always want errors to be logged so add it to the log levels now.
					$log['log_level'][] = 'error';
				}
				$this->base->get_class( 'settings' )->update_option( 'log', $log );

				// Reschedule CRON events.
				$this->base->get_class( 'cron' )->reschedule_log_cleanup_event();
				$this->base->get_class( 'cron' )->reschedule_media_cleanup_event();

				// Done.
				return true;

			/**
			 * Post Type
			 */
			default:
				if ( ! isset( $_POST[ $this->base->plugin->name ]['statuses'] ) ) {
					return new \WP_Error(
						$this->base->plugin->filter_name . '_admin_save_settings_error',
						__( 'Statuses field is missing. Settings NOT saved.', 'wp-to-hootsuite' )
					);
				}

				// Unslash and decode JSON field.
				$settings = json_decode( wp_unslash( $_POST[ $this->base->plugin->name ]['statuses'] ), true ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized

				// Save Settings for this Post Type.
				return $this->base->get_class( 'settings' )->update_settings( $post_type, $settings );
		}

	}

	/**
	 * Returns the profiles for all accounts from the cache.
	 * Queries the API if the cache is empty.
	 *
	 * @since   6.0.5
	 *
	 * @return  array
	 */
	private function get_cached_profiles() {

		$profiles = array();

		foreach ( $this->base->get_class( 'settings' )->get_accounts() as $account_id => $account ) {
			// Configure API for this account.
			$this->base->get_class( 'api' )->set_tokens( $account['access_token'], $account['refresh_token'], $account['token_expires'] );

			// Get account profiles.
			$account_profiles = $this->base->get_class( 'api' )->profiles( false, $account_id );

			// Display an error.
			if ( is_wp_error( $account_profiles ) ) {
				$this->base->get_class( 'notices' )->add_error_notice( $account_profiles->get_error_message() );
				continue;
			}

			// Merge profiles with existing profiles from other accounts.
			// array_merge() is not used here as it will re-index numeric keys.
			foreach ( $account_profiles as $profile ) {
				$profiles[ $profile['id'] ] = $profile;
			}
		}

		return $profiles;

	}

	/**
	 * Returns the settings tab that the user has selected.
	 *
	 * @since   3.7.2
	 *
	 * @param   mixed $profiles   API Profiles (false|\WP_Error|array).
	 * @return  string  Tab
	 */
	private function get_tab( $profiles = false ) {

		// If no tab, default to auth.
		if ( ! filter_has_var( INPUT_GET, 'tab' ) ) {
			return 'auth';
		}

		// Get current tab.
		$tab = filter_input( INPUT_GET, 'tab', FILTER_SANITIZE_FULL_SPECIAL_CHARS );

		// If Profiles are an error, show error.
		if ( is_wp_error( $profiles ) ) {
			return 'profiles-error';
		}

		// If no Profiles exist, show error.
		if ( is_array( $profiles ) && ! count( $profiles ) ) {
			return 'profiles-missing';
		}

		// Return tab.
		return $tab;

	}

	/**
	 * Returns the Post Type tab that the user has selected.
	 *
	 * @since   3.7.2
	 *
	 * @return  string  Tab
	 */
	private function get_post_type_tab() {

		// If no type, default to empty string.
		if ( ! filter_has_var( INPUT_GET, 'type' ) ) {
			return '';
		}

		// Get supported post types.
		$post_types = array_keys( $this->base->get_class( 'common' )->get_post_types() );
		$post_type  = filter_input( INPUT_GET, 'type', FILTER_SANITIZE_FULL_SPECIAL_CHARS );

		// If the post type is not supported, return empty string.
		if ( ! in_array( $post_type, $post_types, true ) ) {
			return '';
		}

		return $post_type;

	}

}

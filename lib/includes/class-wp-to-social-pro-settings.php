<?php
/**
 * Settings class
 *
 * @package WP_To_Social_Pro
 * @author WP Zinc
 */

/**
 * Handles reading and writing settings.
 *
 * @package WP_To_Social_Pro
 * @author  WP Zinc
 * @version 3.0.0
 */
class WP_To_Social_Pro_Settings {

	/**
	 * Holds the class object.
	 *
	 * @since   3.1.4
	 *
	 * @var     object
	 */
	public static $instance;

	/**
	 * Holds the base object.
	 *
	 * @since   3.4.7
	 *
	 * @var     object
	 */
	public $base;

	/**
	 * Constructor
	 *
	 * @since   3.4.7
	 *
	 * @param   object $base    Base Plugin Class.
	 */
	public function __construct( $base ) {

		// Store base class.
		$this->base = $base;

	}

	/**
	 * Retrieves a setting from the options table.
	 *
	 * Safely checks if the key(s) exist before returning the default
	 * or the value.
	 *
	 * @since   3.0.0
	 *
	 * @param   string $type            Setting Type.
	 * @param   string $key             Setting key value to retrieve.
	 * @param   string $default_value   Default Value.
	 * @return  string                  Value/Default Value
	 */
	public function get_setting( $type, $key, $default_value = '' ) {

		// Get settings.
		$settings = $this->get_settings( $type );

		// Convert string to keys.
		$keys = explode( '][', $key );

		foreach ( $keys as $count => $key ) {
			// Cleanup key.
			$key = trim( $key, '[]' );

			// Check if key exists.
			if ( ! isset( $settings[ $key ] ) ) {
				return $default_value;
			}

			// Key exists - make settings the value (which could be an array or the final value)
			// of this key.
			$settings = $settings[ $key ];
		}

		// If here, setting exists.
		// This will be a non-array value.
		return $settings;

	}

	/**
	 * Returns the settings for the given Post Type
	 *
	 * @since   3.0.0
	 *
	 * @param   string $type   Type.
	 * @return  array           Settings
	 */
	public function get_settings( $type ) {

		// Get current settings.
		$settings = get_option( $this->base->plugin->settingsName . '-' . $type );

		/**
		 * Filters Post Type Settings before they are returned.
		 *
		 * @since   3.0.0
		 *
		 * @param   array   $settings   Settings.
		 * @param   string  $type       Post Type.
		 */
		$settings = apply_filters( $this->base->plugin->filter_name . '_get_settings', $settings, $type );

		// Return result.
		return $settings;

	}

	/**
	 * Stores the given settings for the given Post Type into the options table
	 *
	 * @since   3.0.0
	 *
	 * @param   string $type       Type.
	 * @param   array  $settings   Settings.
	 * @return  mixed               array (error) | bool (success)
	 */
	public function update_settings( $type, $settings ) {

		// Get old settings.
		$existing_settings = $this->get_settings( $type );

		// Iterate through array of Post Type Settings to strip HTML tags.
		$settings = $this->strip_tags_deep( $settings );

		/**
		 * Filters Post Type Settings before they are saved.
		 *
		 * @since   3.0.0
		 *
		 * @param   array   $settings   Settings.
		 * @param   string  $type       Post Type.
		 */
		$settings = apply_filters( $this->base->plugin->filter_name . '_update_settings', $settings, $type );

		// Save.
		$result = $this->update_option( $type, $settings );

		// If update_option failed, either no settings were changed, or they were changeed but the DB collation is wrong.
		if ( ! $result ) {
			// Check if the existing and new settings differ i.e. the user actually made a change.
			if ( md5( maybe_serialize( $existing_settings ) ) !== md5( maybe_serialize( $settings ) ) ) {
				// Settings were changed, but could not be saved using update_option.
				// Check the DB collation.
				if ( ! $this->base->get_class( 'common' )->is_table_charset_and_collation_correct( 'options', 'utf8mb4' ) ) {
					return new WP_Error(
						$this->base->plugin->filter_name . '_settings_update_settings_db_collation_error',
						sprintf(
							/* translators: %1$s: Documentation URL */
							__( 'Unable to save settings due to an invalid database collation and charset on the options table. Please refer to the <a href="%1$s" target="_blank">Documentation</a>.', 'wp-to-social-pro' ),
							'https://www.wpzinc.com/documentation/wordpress-buffer-pro/debugging-issues/#unable-to-save-settings-due-to-an-invalid-database-collation-and-charset-on-the-options-table'
						),
					);
				}

				// No changes were made to the settings.
				return new WP_Error(
					$this->base->plugin->filter_name . '_settings_update_settings_no_changes',
					__( 'Unable to save settings due to an error. Please try again.', 'wp-to-social-pro' )
				);
			}
		}

		// Check for duplicate statuses.
		$duplicates = $this->base->get_class( 'validation' )->check_for_duplicates( $settings );
		if ( is_array( $duplicates ) ) {
			// Fetch Post Type Name, Profile Name and Action Name.
			$post_type_object = get_post_type_object( $type );
			if ( $duplicates['profile_id'] === 'default' ) {
				$profile = __( 'Defaults', 'wp-to-buffer' );
			} elseif ( isset( $profiles[ $profile_id ] ) ) {
				$profile = $profiles[ $profile_id ]['formatted_service'] . ': ' . $profiles[ $profile_id ]['formatted_username'];
			}
			$post_actions = $this->base->get_class( 'common' )->get_post_actions();
			$action       = $post_actions[ $duplicates['action'] ];

			// Return error object.
			return new WP_Error(
				$this->base->plugin->filter_name . '_settings_update_settings_duplicates',
				sprintf(
					/* translators: %1$s: Post Type Name, Plural, %2$s: Social Media Profile Name, %3$s: Action (Publish, Update, Repost, Bulk Publish), %4$s: Social Media Service Name (Buffer, Hootsuite, SocialPilot) */
					__( 'Two or more statuses defined in %1$s > %2$s > %3$s are the same. Please correct this to ensure each status update is unique, otherwise your status updates will NOT publish to %4$s as they will be seen as duplicates, which violate Facebook and Twitter\'s Terms of Service.', 'wp-to-buffer' ),
					$post_type_object->label,
					$profile,
					$action,
					$this->base->plugin->account
				)
			);
		}

		// No duplicate statuses found.
		return true;

	}

	/**
	 * Strip HTML tags from the given array or string.
	 *
	 * @since   4.8.9
	 *
	 * @param   string|array $value  Setting value.
	 * @return  string                  Setting value
	 */
	private function strip_tags_deep( $value ) {

		return is_array( $value ) ? array_map( array( $this, 'strip_tags_deep' ), $value ) : wp_strip_all_tags( $value );

	}

	/**
	 * Returns an array of default settings for a new installation.
	 *
	 * @since   3.4.0
	 *
	 * @param   string $post_type          Post Type.
	 * @return  array                       Settings
	 */
	public function default_installation_settings( $post_type ) {

		// Define default settings.
		$settings = array(
			'default' => array(
				'publish' => array(
					'enabled' => 1,
					'status'  => array(
						$this->get_default_status( $post_type, 'New ' . ucfirst( $post_type ) . ': {title} {url}', $this->base->plugin->default_schedule ),
					),
				),
				'update'  => array(
					'enabled' => 1,
					'status'  => array(
						$this->get_default_status( $post_type, 'Updated ' . ucfirst( $post_type ) . ': {title} {url}', $this->base->plugin->default_schedule ),
					),
				),
			),
		);

		/**
		 * Filters Default Post Type Settings used on Plugin Activation before they are returned.
		 *
		 * @since   3.4.0
		 *
		 * @param   array   $settings   Settings.
		 * @param   string  $type       Post Type.
		 */
		$settings = apply_filters( $this->base->plugin->filter_name . '_default_installation_settings', $settings );

		// Return.
		return $settings;

	}

	/**
	 * Merges the given status array with the default status array,
	 * to ensure that the returned status has all expected keys
	 *
	 * @since   4.4.0
	 *
	 * @param   array  $status                     Status.
	 * @param   string $post_type                  Post Type.
	 * @return  array                               Status
	 */
	public function get_status( $status, $post_type ) {

		return array_merge( $this->get_default_status( $post_type, false, $this->base->plugin->default_schedule ), $status );

	}

	/**
	 * Returns value => label key/value arrays for Authors and Taxonomies,
	 * so that selectize instances can be populated with both labels and their values
	 *
	 * @since   4.4.0
	 *
	 * @param   array  $status                     Status.
	 * @param   string $post_type                  Post Type.
	 * @return  array                               Labels
	 */
	public function get_status_value_labels( $status, $post_type ) {

		$labels = array(
			'authors' => array(),
		);

		// Authors.
		if ( $status['authors'] !== false && $status['authors'] !== '' ) {
			foreach ( $status['authors'] as $index => $user_id ) {
				// Get user.
				$user = get_user_by( 'id', absint( $user_id ) );

				// Remove setting if the user no longer exists.
				if ( ! $user ) {
					unset( $status['authors'][ $index ] );
					continue;
				}

				// Add label.
				$labels['authors'][ $index ] = array(
					'id'   => $user_id,
					'text' => $user->user_login,
				);
			}
		}

		// Taxonomies.
		$taxonomies = $this->base->get_class( 'common' )->get_taxonomies( $post_type );
		if ( is_array( $taxonomies ) && count( $taxonomies ) > 0 ) {
			foreach ( $taxonomies as $taxonomy => $details ) {
				$labels[ $taxonomy ] = array();

				// Skip if conditions don't exist for this Taxonomy.
				if ( ! isset( $status['terms'][ $taxonomy ] ) ) {
					continue;
				}
				if ( ! is_array( $status['terms'][ $taxonomy ] ) ) {
					continue;
				}
				if ( ! count( $status['terms'][ $taxonomy ] ) ) {
					continue;
				}

				// Term(s) exist.
				foreach ( $status['terms'][ $taxonomy ] as $index => $term_id ) {
					// Get Term.
					$term = get_term_by( 'id', absint( $term_id ), $taxonomy );

					// Remove setting if the Term no longer exists.
					if ( ! $term ) {
						unset( $status['terms'][ $taxonomy ][ $index ] );
						continue;
					}

					// Add label.
					$labels[ $taxonomy ][ $index ] = array(
						'id'   => $term_id,
						'text' => $term->name,
					);
				}
			}
		}

		// Return.
		return $labels;

	}

	/**
	 * Returns an array of a status' information that can be output in
	 * the table row cells
	 *
	 * @since   4.4.0
	 *
	 * @param   array  $status     Status.
	 * @param   string $post_type  Post Type.
	 * @param   string $action     Action (publish,update,repost,bulk_publish).
	 * @return  array               Table Row Cell Status (message, image, schedule)
	 */
	public function get_status_row( $status, $post_type, $action ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter

		// Get Options.
		$featured_image_options = $this->base->get_class( 'image' )->get_featured_image_options( $post_type );
		$schedule               = $this->base->get_class( 'common' )->get_schedule_options( $post_type, true );

		// Define row.
		$row = array(
			'message'  => ( ( strlen( $status['message'] ) > 100 ) ? substr( $status['message'], 0, 100 ) . '...' : $status['message'] ),
			'image'    => $featured_image_options[ $status['image'] ],
			'schedule' => '',
		);

		// Define row schedule text.
		$row['schedule'] = $schedule[ $status['schedule'] ];

		return $row;

	}

	/**
	 * Returns a default status array
	 *
	 * @since   4.4.0
	 *
	 * @param   string $post_type          Post Type.
	 * @param   mixed  $default_message    Default Message (if false, uses {title} {url}).
	 * @param   string $default_schedule   Default Schedule.
	 * @return  array                       Status
	 */
	public function get_default_status( $post_type, $default_message = false, $default_schedule = 'queue_bottom' ) {

		// Get Taxonomies supported by this Post Type.
		$conditions = array();
		$terms      = array();
		foreach ( $this->base->get_class( 'common' )->get_taxonomies( $post_type ) as $taxonomy => $object ) {
			$conditions[ $taxonomy ] = '';
			$terms[ $taxonomy ]      = array();
		}

		// Define skeleton status to be used for new statuses.
		$status = array(
			// All Profiles.
			'image'                          => ( $this->base->get_class( 'image' )->is_opengraph_plugin_active() ? 0 : 2 ),
			'message'                        => ( ! $default_message ? '{title} {url}' : $default_message ),
			'schedule'                       => $default_schedule,
			'days'                           => 0,
			'hours'                          => 0,
			'minutes'                        => 0,
			'schedule_relative_day'          => '',
			'schedule_relative_time'         => '00:00:00',
			'schedule_custom_field_name'     => '',
			'schedule_custom_field_relation' => 'after',
			'schedule_specific'              => '',

			// Profiles: Pinterest.
			'sub_profile'                    => 0,

			// Update Type: Instagram.
			'update_type'                    => '',

			// Profiles: Google Business.
			'googlebusiness'                 => array(
				'post_type'         => 'whats_new', // whats_new, offer, event.

				// What's New, Event.
				'cta'               => '', // book,order,shop,learn_more,signup.

				// Offer, Event.
				'start_date_option' => 'custom',
				'start_date'        => '',
				'end_date_option'   => 'custom',
				'end_date'          => '',
				'title'             => '',

				// Offer.
				'code'              => '',
				'terms'             => '',
			),

			// Text to Image.
			'text_to_image'                  => '',

			// Post Conditions.
			'post_title'                     => array(
				'compare' => 0,
				'value'   => '',
			),
			'post_excerpt'                   => array(
				'compare' => 0,
				'value'   => '',
			),
			'post_content'                   => array(
				'compare' => 0,
				'value'   => '',
			),
			'start_date'                     => array(
				'month' => '',
				'day'   => '',
			),
			'end_date'                       => array(
				'month' => '',
				'day'   => '',
			),

			// Author Conditions.
			'authors'                        => false,
			'authors_compare'                => '=',
			'authors_roles'                  => false,
			'authors_roles_compare'          => '=',

			// Taxonomy Conditions.
			'conditions'                     => $conditions,
			'terms'                          => $terms,

			// Custom Field Conditions.
			'custom_fields'                  => array(),
		);

		/**
		 * Returns a skeleton status object for the given action, used when defining new status(es)
		 *
		 * @since   4.4.0
		 *
		 * @param   array   $status     Status.
		 */
		$status = apply_filters( $this->base->plugin->filter_name . '_settings_get_default_status', $status );

		// Return.
		return $status;

	}

	/**
	 * Helper method to determine whether the given Post Type has at least
	 * one social media account enabled, and there is a publish or update
	 * action enabled in the Defaults for the Post Type or the Social Media account.
	 *
	 * @since   3.4.0
	 *
	 * @param   string $post_type  Post Type.
	 * @return  bool                Enabled
	 */
	public function is_post_type_enabled( $post_type ) {

		// Get Settings for Post Type.
		$settings = $this->get_settings( $post_type );

		// If no settings, bail.
		if ( ! $settings ) {
			return false;
		}

		/**
		 * Default Publish or Update enabled
		 * 1+ Profiles enabled without override
		 */
		$default_publish_action_enabled = $this->get_setting( $post_type, '[default][publish][enabled]', 0 );
		$default_update_action_enabled  = $this->get_setting( $post_type, '[default][update][enabled]', 0 );
		if ( $default_publish_action_enabled || $default_update_action_enabled ) {
			foreach ( $settings as $profile_id => $profile_settings ) {
				// Skip defaults.
				if ( $profile_id === 'default' ) {
					continue;
				}

				// Profile enabled, no override.
				if ( isset( $profile_settings['enabled'] ) && $profile_settings['enabled'] ) {
					if ( ! isset( $profile_settings['override'] ) || ! $profile_settings['override'] ) {
						// Post Type is enabled with Defaults + 1+ Profile not using override settings.
						return true;
					}
				}
			}
		}

		/**
		 * 1+ Profiles enabled with override and publish / update enabled
		 */
		foreach ( $settings as $profile_id => $profile_settings ) {
			// Skip defaults.
			if ( $profile_id === 'default' ) {
				continue;
			}

			// Skip if profile not enabled.
			if ( ! isset( $profile_settings['enabled'] ) || ! $profile_settings['enabled'] ) {
				continue;
			}

			// Skip if override not enabled.
			if ( ! isset( $profile_settings['override'] ) || ! $profile_settings['override'] ) {
				continue;
			}

			// Profile action enabled.
			if ( isset( $profile_settings['publish']['enabled'] ) && $profile_settings['publish']['enabled'] == '1' ) {  // phpcs:ignore Universal.Operators.StrictComparisons.LooseEqual
				// Post Type is enabled with 1+ Profile with override and publish enabled.
				return true;
			}
			if ( isset( $profile_settings['update']['enabled'] ) && $profile_settings['update']['enabled'] == '1' ) {  // phpcs:ignore Universal.Operators.StrictComparisons.LooseEqual
				// Post Type is enabled with 1+ Profile with override and update enabled.
				return true;
			}
			if ( isset( $profile_settings['repost']['enabled'] ) && $profile_settings['repost']['enabled'] == '1' ) {  // phpcs:ignore Universal.Operators.StrictComparisons.LooseEqual
				// Post Type is enabled with 1+ Profile with override and repost enabled.
				return true;
			}
			if ( isset( $profile_settings['bulk_publish']['enabled'] ) && $profile_settings['bulk_publish']['enabled'] == '1' ) {  // phpcs:ignore Universal.Operators.StrictComparisons.LooseEqual
				// Post Type is enabled with 1+ Profile with override and bulk publish enabled.
				return true;
			}
		}

		// If here, Post Type can't be sent to the API.
		return false;

	}

	/**
	 * Runs the given individual status settings through validation - for example,
	 * ensuring that a custom time is at least 5 minutes when using Hootsuite,
	 * to ensure compatibility with the API.
	 *
	 * @since   3.7.3
	 *
	 * @param   array $status     Status Message Settings.
	 * @return  array               Status Message Settings
	 */
	private function validate_status( $status ) {

		// If we're using Hootsuite, with a custom time, it must be set to at least 5 minutes.
		if ( class_exists( 'WP_To_Hootsuite' ) || class_exists( 'WP_To_Hootsuite_Pro' ) ) {
			if ( $status['schedule'] === 'custom' && ! $status['days'] && ! $status['hours'] ) {
				if ( $status['minutes'] < 5 ) {
					$status['minutes'] = 5;
				}
			}
		}

		/**
		 * Filters status settings during validation, allowing them to be changed.
		 *
		 * @since   3.7.3
		 *
		 * @param   array   $status     Status.
		 */
		$status = apply_filters( $this->base->plugin->filter_name . '_settings_validate_status', $status );

		// Return.
		return $status;

	}

	/**
	 * Stores the given access token and refresh token into the options table.
	 *
	 * @since   3.5.0
	 *
	 * @param   string $access_token    Access Token.
	 * @param   string $refresh_token   Refresh Token.
	 * @param   mixed  $token_expires   Token Expires (false | timestamp).
	 */
	public function update_tokens( $access_token = '', $refresh_token = '', $token_expires = false ) {

		$this->update_access_token( $access_token );
		$this->update_refresh_token( $refresh_token );
		$this->update_token_expires( $token_expires );

	}

	/**
	 * Deletes the access, refresh and toke expiry values from the options table.
	 *
	 * @since   3.5.0
	 */
	public function delete_tokens() {

		$this->delete_access_token();
		$this->delete_refresh_token();
		$this->delete_token_expires();

	}

	/**
	 * Retrieves the access token from the options table
	 *
	 * @since   3.0.0
	 *
	 * @return  string  Access Token
	 */
	public function get_access_token() {

		return get_option( $this->base->plugin->settingsName . '-access-token' );

	}

	/**
	 * Stores the given access token into the options table
	 *
	 * @since   3.0.0
	 *
	 * @param   string $access_token   Access Token.
	 * @return  bool                    Success
	 */
	public function update_access_token( $access_token ) {

		/**
		 * Filters the API access token before saving.
		 *
		 * @since   3.0.0
		 *
		 * @param   array   $access_token   Access Token.
		 */
		$access_token = apply_filters( $this->base->plugin->filter_name . '_update_access_token', $access_token );

		// Return result.
		return update_option( $this->base->plugin->settingsName . '-access-token', $access_token );

	}

	/**
	 * Deletes the access token from the options table
	 *
	 * @since   3.4.7
	 *
	 * @return  bool    Success
	 */
	public function delete_access_token() {

		// Return result.
		return delete_option( $this->base->plugin->settingsName . '-access-token' );

	}

	/**
	 * Retrieves the refresh token from the options table
	 *
	 * @since   3.0.0
	 *
	 * @return  string  Access Token
	 */
	public function get_refresh_token() {

		return get_option( $this->base->plugin->settingsName . '-refresh-token' );

	}

	/**
	 * Stores the given refresh token into the options table
	 *
	 * @since   3.0.0
	 *
	 * @param   string $refresh_token  Refresh Token.
	 * @return  bool                    Success
	 */
	public function update_refresh_token( $refresh_token ) {

		/**
		 * Filters the API refresh token before saving.
		 *
		 * @since   3.0.0
		 *
		 * @param   array   $refresh_token   Refresh Token.
		 */
		$refresh_token = apply_filters( $this->base->plugin->filter_name . '_update_refresh_token', $refresh_token );

		// Return result.
		return update_option( $this->base->plugin->settingsName . '-refresh-token', $refresh_token );

	}

	/**
	 * Deletes the access token from the options table
	 *
	 * @since   3.4.7
	 *
	 * @return  bool    Success
	 */
	public function delete_refresh_token() {

		// Return result.
		return delete_option( $this->base->plugin->settingsName . '-refresh-token' );

	}

	/**
	 * Retrieves the token expiry timestamp from the options table
	 *
	 * @since   3.5.0
	 *
	 * @return  mixed   false | Token Expiry Timestamp
	 */
	public function get_token_expires() {

		return get_option( $this->base->plugin->settingsName . '-token-expires' );

	}

	/**
	 * Stores the given token expiry timestamp into the options table
	 *
	 * @since   3.5.0
	 *
	 * @param   mixed $token_expires      Token Expires (false | timestamp).
	 * @return  bool                        Success
	 */
	public function update_token_expires( $token_expires ) {

		/**
		 * Filters the API token expiry timestamp token before saving.
		 *
		 * @since   3.0.0
		 *
		 * @param   array   $token_expires  Token Expiry.
		 */
		$token_expires = apply_filters( $this->base->plugin->filter_name . '_update_token_expires', $token_expires );

		// Return result.
		return update_option( $this->base->plugin->settingsName . '-token-expires', $token_expires );

	}

	/**
	 * Deletes the token expiry timestamp from the options table
	 *
	 * @since   3.5.0
	 *
	 * @return  bool    Success
	 */
	public function delete_token_expires() {

		// Return result.
		return delete_option( $this->base->plugin->settingsName . '-token-expires' );

	}

	/**
	 * Helper method to get a value from the options table
	 *
	 * @since   3.0.0
	 *
	 * @param   string $key             Option Key.
	 * @param   string $default_value   Default Value if key does not exist.
	 * @return  string                  Option Value
	 */
	public function get_option( $key, $default_value = '' ) {

		$result = get_option( $this->base->plugin->settingsName . '-' . $key );
		if ( ! $result ) {
			return $default_value;
		}

		return $result;

	}

	/**
	 * Helper method to store a value to the options table
	 *
	 * @since   3.0.0
	 *
	 * @param   string $key    Key.
	 * @param   string $value  Value.
	 * @return  bool            Success
	 */
	public function update_option( $key, $value ) {

		// Depending on the key, perform some validation before saving.
		switch ( $key ) {
			/**
			 * Custom Tags
			 * - Remove duplicate keys.
			 */
			case 'custom_tags':
				// Skip validation if there are no custom field key/values to validate.
				if ( count( $value ) === 0 ) {
					break;
				}

				foreach ( $value as $post_type => $custom_tags ) {
					// Remove duplicate keys.
					$value[ $post_type ]['key'] = array_unique( array_filter( $custom_tags['key'] ) );

					// Iterate through labels, removing them if there is now no key.
					foreach ( $custom_tags['label'] as $label_key => $label ) {
						if ( ! isset( $value[ $post_type ]['key'][ $label_key ] ) ) {
							unset( $value[ $post_type ]['label'][ $label_key ] );
						}
					}
				}
				break;
		}

		/**
		 * Filters the key and value pair before saving to the options table.
		 *
		 * @since   3.0.0
		 *
		 * @param   string  $value  Option Value.
		 * @param   string  $key    Option Key.
		 */
		$value = apply_filters( $this->base->plugin->filter_name . '_update_option', $value, $key );

		// Update.
		update_option( $this->base->plugin->settingsName . '-' . $key, $value );

		return true;

	}

}

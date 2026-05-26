<?php
/**
 * Install class.
 *
 * @package WP_To_Social_Pro
 * @author WP Zinc
 */

/**
 * Runs any steps required on plugin activation and upgrade.
 *
 * @package  WP_To_Social_Pro
 * @author   WP Zinc
 * @version  3.2.5
 */
class WP_To_Social_Pro_Install {

	/**
	 * Holds the base class object.
	 *
	 * @since   3.2.5
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
	 * Runs installation routines for first time users
	 *
	 * @since   3.4.0
	 */
	public function install() {

		// Enable logging by default.
		$this->base->get_class( 'settings' )->update_option(
			'log',
			array(
				'enabled'          => 1,
				'display_on_posts' => 1,
				'preserve_days'    => 30,
				'log_level'        => array(
					'success',
					'test',
					'pending',
					'warning',
					'error',
				),
			)
		);

		// Create logging database table.
		$this->base->get_class( 'log' )->activate();

		// Reschedule the cron events.
		$this->base->get_class( 'cron' )->schedule_log_cleanup_event();
		$this->base->get_class( 'cron' )->schedule_media_cleanup_event();

		// Bail if settings already exist.
		$settings = $this->base->get_class( 'settings' )->get_settings( 'post' );
		if ( $settings !== false ) {
			return;
		}

		// Get default installation settings.
		$settings = $this->base->get_class( 'settings' )->default_installation_settings( 'post' );
		$this->base->get_class( 'settings' )->update_settings( 'post', $settings );

	}

	/**
	 * Runs migrations whenever the Plugin's version is updated.
	 *
	 * @since   3.2.5
	 */
	public function upgrade() {

		// These sit outside of version checks, to ensure they run regardless of version.
		// Otherwise, Free to Free Plugin updates for the multi account result in losing
		// account data because there's also an API version switch.
		// At a later relase, we'll need to remove these so they don't run on every upgrade.

		// Migrate Access Tokens to multi account settings.
		$this->migrate_access_tokens_to_new_multi_account_settings();

		// Migrate Status Settings to new format that supports "Type"
		// instead of a numerical setting for the status' index.
		$this->migrate_status_settings_to_new_format();

		// Get current installed version number.
		// false | 1.1.7.
		$installed_version = get_option( $this->base->plugin->name . '-version' );

		// If the version number matches the plugin version, bail.
		if ( $installed_version === $this->base->plugin->version ) {
			return;
		}

		// Reschedule the cron events.
		$this->base->get_class( 'cron' )->reschedule_log_cleanup_event();
		$this->base->get_class( 'cron' )->reschedule_media_cleanup_event();

		// Update the version number.
		update_option( $this->base->plugin->name . '-version', $this->base->plugin->version );

	}

	/**
	 * Migrates the access token, refresh token and token expiry to the new multi account settings.
	 *
	 * @since   6.0.0
	 *
	 * @return  void
	 */
	private function migrate_access_tokens_to_new_multi_account_settings() {

		// Check if the non-multi account settings exist.
		$access_token  = get_option( $this->base->plugin->settingsName . '-access-token' );
		$refresh_token = get_option( $this->base->plugin->settingsName . '-refresh-token' );
		$token_expires = get_option( $this->base->plugin->settingsName . '-token-expires' );

		// Bail if no access token exists - either the Plugin isn't connected, or it has
		// already been migrated to the new multi account settings.
		if ( empty( $access_token ) ) {
			return;
		}

		// Store tokens in new multi account settings.
		// This will be stored under the ID 'default'.
		$this->base->get_class( 'settings' )->update_account(
			$access_token,
			$refresh_token,
			$token_expires
		);

		// Delete old settings.
		delete_option( $this->base->plugin->settingsName . '-access-token' );
		delete_option( $this->base->plugin->settingsName . '-refresh-token' );
		delete_option( $this->base->plugin->settingsName . '-token-expires' );

		// Delete old transient for profiles, as they're now stored against the account.
		delete_transient( $this->base->plugin->name . '_' . $this->base->plugin->account . '_api_profiles' );

	}

	/**
	 * Migrates Status Settings to the new format that supports
	 * a "Type" selection dropdown.
	 *
	 * @since   6.0.0
	 *
	 * @return  void
	 */
	private function migrate_status_settings_to_new_format() {

		// Define option flags.
		$migrated_status_settings_flag = $this->base->plugin->name . '-migrate-status-settings-completed';

		// Bail if the migration has already run.
		if ( get_option( $migrated_status_settings_flag ) ) {
			return;
		}

		// Get accounts.
		$accounts = $this->base->get_class( 'settings' )->get_accounts();

		// Bail if no accounts exist.
		if ( empty( $accounts ) ) {
			return;
		}

		// Build array of all profiles across all accounts connected to the Plugin.
		$profiles = array();
		foreach ( $accounts as $account_id => $account ) {
			$account_profiles = get_transient( $this->base->plugin->name . '_' . strtolower( $this->base->plugin->account ) . '_api_profiles_' . $account_id );
			if ( ! $account_profiles ) {
				continue;
			}
			$profiles = array_merge( $profiles, $account_profiles );
		}

		// If no profiles exist, bail.
		if ( empty( $profiles ) ) {
			return;
		}

		// Fetch actions (publish, update, repost, bulk publish).
		$actions = $this->base->get_class( 'common' )->get_post_actions();

		// Fetch all Post Type settings.
		$post_types = $this->base->get_class( 'common' )->get_post_types();

		// Iterate through Post Types, migrating their Status Settings.
		foreach ( $post_types as $post_type ) {
			// Get Post Type Settings.
			$settings = $this->base->get_class( 'settings' )->get_settings( $post_type->name );

			// Skip if not an array.
			if ( ! is_array( $settings ) ) {
				continue;
			}

			// Migrate.
			$settings = $this->migrate_status_settings( $settings, $actions, $profiles );

			// Save settings for this Post Type.
			$this->base->get_class( 'settings' )->update_settings( $post_type->name, $settings );
		}

		// Mark the migration as completed.
		update_option( $migrated_status_settings_flag, time(), false );

	}

	/**
	 * Migrates status settings to the new format that supports
	 * a "Type" selection dropdown.
	 *
	 * @since   6.0.0
	 *
	 * @param   array $settings  Post Type or individual Post Settings.
	 * @param   array $actions   Actions.
	 * @param   array $profiles  Profiles.
	 * @return  array            Migrated Settings.
	 */
	public function migrate_status_settings( $settings, $actions, $profiles ) {

		// Iterate through settings.
		foreach ( $settings as $profile_id => $profile ) {
			// Skip if profile isn't an array.
			if ( ! is_array( $profile ) ) {
				continue;
			}

			// Iterate through actions.
			foreach ( $actions as $action => $action_label ) {
				// Skip if the action isn't an array.
				if ( ! array_key_exists( $action, $profile ) || ! is_array( $profile[ $action ] ) ) {
					continue;
				}

				// Iterate through statuses.
				foreach ( $profile[ $action ]['status'] as $status_index => $status ) {
					// Skip if a post_type already exists.
					if ( array_key_exists( 'post_type', $status ) ) {
						continue;
					}

					// Status Type.
					switch ( (string) $status['image'] ) {
						// No Image.
						case '-1':
							$status['post_type'] = 'text';
							$status['image']     = '';
							break;

						// Use Feat. Image, Linked to Post.
						case '1':
							$status['post_type'] = 'image';
							$status['image']     = 'featured_image';
							break;

						// Use Feat. Image, not Linked to Post.
						case '2':
							$status['post_type'] = 'image';
							$status['image']     = 'featured_image';
							break;

						// Use Text to Image, Linked to Post.
						case '3':
							$status['post_type'] = 'image';
							$status['image']     = 'text_to_image';
							break;

						// Use Text to Image, not Linked to Post.
						case '4':
							$status['post_type'] = 'image';
							$status['image']     = 'text_to_image';
							break;

						// OpenGraph / Link Preview.
						case '0':
						case '':
						default:
							if ( array_key_exists( 'link', $this->base->get_class( 'common' )->get_status_post_type_options() ) ) {
								$status['post_type'] = 'link';
								$status['image']     = '';

								// Move the {url} or {url_short} from the message to the URL setting.
								if ( strpos( $status['message'], '{url}' ) !== false ) {
									$status['message'] = str_replace( '{url}', '', $status['message'] );
									$status['url']     = '{url}';
								} elseif ( strpos( $status['message'], '{url_short}' ) !== false ) {
									$status['message'] = str_replace( '{url_short}', '', $status['message'] );
									$status['url']     = '{url_short}';
								} else {
									// Status is OpenGraph but no URL included.
									// Set the URL to the Post's URL.
									$status['url'] = '{url}';
								}
							} else {
								$status['post_type'] = 'text';
								$status['image']     = '';
							}
							break;
					}

					// Schedule.
					switch ( $status['schedule'] ) {
						case 'queue_bottom':
							$status['schedule'] = 'queue_end';
							break;

						case 'queue_top':
							$status['schedule'] = 'queue_start';
							break;

						case 'now':
							$status['schedule'] = 'immediate';
							break;
					}

					// Adjust image_additional setting.
					if ( array_key_exists( 'image_additional', $status ) ) {
						switch ( $status['image_additional'] ) {
							/**
							 * Blank means "Specified in Post settings" < 6.0.0.
							 * 6.0.0 sets blank as 'None'.
							 */
							case '':
								$status['image_additional'] = 'post_settings';
								break;

							/**
							 * 1 means "Auto populate from Post content" < 6.0.0.
							 */
							case '1':
								$status['image_additional'] = 'post_content';
								break;
						}
					}

					// Depending on the Profile Service, the Type may need to be adjusted.
					// Don't do this if the profile_id = default.
					foreach ( $profiles as $api_profile ) {
						if ( $api_profile['id'] !== (string) $profile_id ) {
							continue;
						}

						switch ( $api_profile['service'] ) {
							case 'instagram':
								$status['post_type'] = $status['update_type'] === 'story' ? 'story' : 'image';
								break;

							case 'pinterest':
								$status['post_type'] = 'pin';
								$status['url']       = array_key_exists( 'source_url', $status ) ? $status['source_url'] : '{url}';
								if ( ! array_key_exists( 'pinterest', $status ) ) {
									$status['pinterest'] = array();
								}
								if ( ! is_array( $status['pinterest'] ) ) {
									$status['pinterest'] = array();
								}
								$status['pinterest']['board'] = array_key_exists( 'sub_profile', $status ) ? $status['sub_profile'] : '';
								$status['pinterest']['title'] = array_key_exists( 'title', $status ) ? $status['title'] : '{title}';
								break;

							case 'googlebusiness':
								$status['post_type'] = 'googlebusiness';
								$status['url']       = '{url}';
								break;
						}
						break;
					}

					// Remove unused status settings.
					// update_type: Instagram Story/Post, which is now handled by the post_type setting.
					// title: Pinterest Title, which is now handled by the pinterest array.
					// source_url: Pinterest Source URL, which is now handled by the url setting.
					unset( $status['update_type'], $status['title'], $status['source_url'], $status['sub_profile'] );

					// Assign status back to settings.
					$settings[ $profile_id ][ $action ]['status'][ $status_index ] = $status;
				}
			}
		}

		return $settings;

	}

	/**
	 * Runs uninstallation routines
	 *
	 * @since   3.7.2
	 */
	public function uninstall() {

		// Unschedule any CRON events.
		$this->base->get_class( 'cron' )->unschedule_log_cleanup_event();
		$this->base->get_class( 'cron' )->unschedule_media_cleanup_event();

	}

}

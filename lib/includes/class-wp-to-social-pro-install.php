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
	 * Runs migrations for Pro to Pro version upgrades
	 *
	 * @since   3.2.5
	 */
	public function upgrade() {

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

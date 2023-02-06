<?php
/**
 * WP to Hootsuite class.
 *
 * @package WP_To_Hootsuite
 * @author WP Zinc
 */

/**
 * Main WP to Hootsuite class, used to load the Plugin.
 *
 * @package   WP_To_Hootsuite
 * @author    WP Zinc
 * @version   1.0.0
 */
class WP_To_Hootsuite {

	/**
	 * Holds the class object.
	 *
	 * @since   3.1.4
	 *
	 * @var     object
	 */
	public static $instance;

	/**
	 * Plugin
	 *
	 * @since   3.0.0
	 *
	 * @var     object
	 */
	public $plugin = '';

	/**
	 * Dashboard
	 *
	 * @since   3.1.4
	 *
	 * @var     object
	 */
	public $dashboard = '';

	/**
	 * Classes
	 *
	 * @since   3.4.9
	 *
	 * @var     array
	 */
	public $classes = '';

	/**
	 * Constructor. Acts as a bootstrap to load the rest of the plugin
	 *
	 * @since   1.0.0
	 */
	public function __construct() {

		// Plugin Details.
		$this->plugin              = new stdClass();
		$this->plugin->name        = 'wp-to-hootsuite';
		$this->plugin->filter_name = 'wp_to_hootsuite';
		$this->plugin->displayName = 'WP to Hootsuite';

		$this->plugin->settingsName      = 'wp-to-hootsuite-pro'; // Settings key - used in both Free + Pro, and for oAuth.
		$this->plugin->account           = 'Hootsuite';
		$this->plugin->version           = WP_TO_HOOTSUITE_PLUGIN_VERSION;
		$this->plugin->buildDate         = WP_TO_HOOTSUITE_PLUGIN_BUILD_DATE;
		$this->plugin->requires          = '5.0';
		$this->plugin->tested            = '6.1.1';
		$this->plugin->folder            = WP_TO_HOOTSUITE_PLUGIN_PATH;
		$this->plugin->url               = WP_TO_HOOTSUITE_PLUGIN_URL;
		$this->plugin->documentation_url = 'https://www.wpzinc.com/documentation/wordpress-to-hootsuite-pro';
		$this->plugin->support_url       = 'https://www.wpzinc.com/support';
		$this->plugin->upgrade_url       = 'https://www.wpzinc.com/plugins/wordpress-to-hootsuite-pro';
		$this->plugin->review_name       = 'wp-to-hootsuite';
		$this->plugin->review_notice     = sprintf(
			/* translators: Plugin Name */
			__( 'Thanks for using %s to schedule your social media statuses on Hootsuite!', 'wp-to-hootsuite' ),
			$this->plugin->displayName
		);

		// Default Settings.
		$this->plugin->default_schedule = 'queue_bottom';

		// Dashboard Submodule.
		if ( ! class_exists( 'WPZincDashboardWidget' ) ) {
			require_once $this->plugin->folder . '_modules/dashboard/class-wpzincdashboardwidget.php';
		}
		$this->dashboard = new WPZincDashboardWidget( $this->plugin, 'https://www.wpzinc.com/wp-content/plugins/lum-deactivation' );

		// Defer loading of Plugin Classes.
		add_action( 'init', array( $this, 'initialize' ), 1 );
		add_action( 'init', array( $this, 'upgrade' ), 2 );

		// Localization.
		add_action( 'plugins_loaded', array( $this, 'load_language_files' ) );

	}

	/**
	 * Initializes required classes
	 *
	 * @since   3.4.9
	 */
	public function initialize() {

		$this->classes = new stdClass();

		// Initialize required classes.
		$this->classes->admin         = new WP_To_Social_Pro_Admin( self::$instance );
		$this->classes->ajax          = new WP_To_Social_Pro_AJAX( self::$instance );
		$this->classes->api           = new WP_To_Social_Pro_Hootsuite_API( self::$instance );
		$this->classes->common        = new WP_To_Social_Pro_Common( self::$instance );
		$this->classes->cron          = new WP_To_Social_Pro_Cron( self::$instance );
		$this->classes->date          = new WP_To_Social_Pro_Date( self::$instance );
		$this->classes->image         = new WP_To_Social_Pro_Image( self::$instance );
		$this->classes->install       = new WP_To_Social_Pro_Install( self::$instance );
		$this->classes->log           = new WP_To_Social_Pro_Log( self::$instance );
		$this->classes->media_library = new WP_To_Social_Pro_Media_Library( self::$instance );
		$this->classes->notices       = new WP_To_Social_Pro_Notices( self::$instance );
		$this->classes->post          = new WP_To_Social_Pro_Post( self::$instance );
		$this->classes->publish       = new WP_To_Social_Pro_Publish( self::$instance );
		$this->classes->screen        = new WP_To_Social_Pro_Screen( self::$instance );
		$this->classes->settings      = new WP_To_Social_Pro_Settings( self::$instance );
		$this->classes->twitter_api   = new WP_To_Social_Pro_Twitter_API( self::$instance );
		$this->classes->validation    = new WP_To_Social_Pro_Validation( self::$instance );

		// Run the migration routine from Free + Pro v2.x --> Pro v3.x.
		if ( is_admin() ) {
			$this->classes->settings->migrate_settings();
		}

	}

	/**
	 * Runs the upgrade routine once the plugin has loaded
	 *
	 * @since   3.2.5
	 */
	public function upgrade() {

		// Run upgrade routine.
		$this->get_class( 'install' )->upgrade();

	}

	/**
	 * Loads plugin textdomain
	 *
	 * @since   3.8.4
	 */
	public function load_language_files() {

		load_plugin_textdomain( 'wp-to-hootsuite', false, $this->plugin->name . '/languages/' );

	}

	/**
	 * Returns the given class
	 *
	 * @since   3.4.9
	 *
	 * @param   string $name   Class Name.
	 */
	public function get_class( $name ) {

		// If the class hasn't been loaded, throw a WordPress die screen
		// to avoid a PHP fatal error.
		if ( ! isset( $this->classes->{ $name } ) ) {
			// Define the error.
			$error = new WP_Error(
				'wp_to_hootsuite_get_class',
				sprintf(
					/* translators: %1$s: Plugin Name, %2$s: PHP class name */
					__( '%1$s: Error: Could not load Plugin class %2$s', 'wp-to-hootsuite' ),
					$this->plugin->displayName,
					$name
				)
			);

			// Depending on the request, return or display an error.
			// Admin UI.
			if ( is_admin() ) {
				wp_die(
					esc_html( $error->get_error_message() ),
					sprintf(
						/* translators: Plugin Name */
						esc_html__( '%s: Error', 'wp-to-hootsuite' ),
						esc_html( $this->plugin->displayName )
					),
					array(
						'back_link' => true,
					)
				);
			}

			// Cron / CLI.
			return $error;
		}

		// Return the class object.
		return $this->classes->{ $name };

	}

	/**
	 * Returns the singleton instance of the class.
	 *
	 * @since   3.1.4
	 *
	 * @return  object Class.
	 */
	public static function get_instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) ) {
			self::$instance = new self();
		}

		return self::$instance;

	}

}

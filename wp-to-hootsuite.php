<?php
/**
* Plugin Name: WP to Hootsuite
* Plugin URI: http://www.wpzinc.com/plugins/wordpress-to-hootsuite-pro
* Version: 1.4.7
* Author: WP Zinc
* Author URI: http://www.wpzinc.com
* Description: Send WordPress Pages, Posts or Custom Post Types to your Hootsuite (hootsuite.com) account for scheduled publishing to social networks.
*/

/**
 * WP to Hootsuite Class
 * 
 * @package   WP_To_Hootsuite
 * @author    Tim Carr
 * @version   1.0.0
 * @copyright WP Zinc
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

        // Plugin Details
        $this->plugin                   = new stdClass;
        $this->plugin->name             = 'wp-to-hootsuite';
        $this->plugin->filter_name      = 'wp_to_hootsuite';
        $this->plugin->displayName      = 'WP to Hootsuite';
        
        $this->plugin->settingsName     = 'wp-to-hootsuite-pro'; // Settings key - used in both Free + Pro, and for oAuth
        $this->plugin->account          = 'Hootsuite';
        $this->plugin->version          = '1.4.7';
        $this->plugin->buildDate        = '2022-10-25 12:00:00';
        $this->plugin->requires         = '5.0';
        $this->plugin->tested           = '6.0.3';
        $this->plugin->folder           = plugin_dir_path( __FILE__ );
        $this->plugin->url              = plugin_dir_url( __FILE__ );
        $this->plugin->documentation_url= 'https://www.wpzinc.com/documentation/wordpress-to-hootsuite-pro';
        $this->plugin->support_url      = 'https://www.wpzinc.com/support';
        $this->plugin->upgrade_url      = 'https://www.wpzinc.com/plugins/wordpress-to-hootsuite-pro';
        $this->plugin->review_name      = 'wp-to-hootsuite';
        $this->plugin->review_notice    = sprintf( __( 'Thanks for using %s to schedule your social media statuses on Hootsuite!', $this->plugin->name ), $this->plugin->displayName );

        $this->plugin->default_schedule = 'now';

        // Upgrade Reasons
        $this->plugin->upgrade_reasons = array(
            array(
                __( 'Post to Instagram and Pinterest', $this->plugin->name ), 
                __( 'Post to Instagram (Personal Profiles only, using Reminders) and Pinterest Boards', $this->plugin->name ),
            ),
            array(
                __( 'Multiple, Customisable Status Messages', $this->plugin->name ), 
                __( 'Each Post Type and Social Network can have multiple, unique status message and settings', $this->plugin->name ),
            ),
            array(
                __( 'Conditionally send Status Messages', $this->plugin->name ), 
                __( 'Only send status(es) to Hootsuite based on Post Author(s), Taxonomy Term(s) and/or Custom Field Values', $this->plugin->name ),
            ),
            array(
                __( 'More Scheduling Options', $this->plugin->name ), 
                __( 'Each status update can be added to the start/end of your Hootsuite queue, posted immediately or scheduled at a specific time', $this->plugin->name ),
            ),
            array(
                __( 'Dynamic Status Tags', $this->plugin->name ), 
                __( 'Dynamically build status updates with data from the Post Author and Custom Fields', $this->plugin->name ),
            ),
            array(
                __( 'Separate Statuses per Social Network', $this->plugin->name ), 
                __( 'Define different statuses for each Post Type and Social Network', $this->plugin->name ),
            ),
            array(
                __( 'Per-Post Settings', $this->plugin->name ), 
                __( 'Override Settings on Individual Posts: Each Post can have its own Hootsuite settings', $this->plugin->name ),
            ),
            array(
                __( 'Repost Old Posts', $this->plugin->name ), 
                __( 'Automatically Revive Old Posts that haven\'t been updated in a while, choosing the number of days, weeks or years to re-share content on social media.', $this->plugin->name ),
            ),
            array(
                __( 'Bulk Publish Old Posts', $this->plugin->name ), 
                __( 'Manually re-share evergreen WordPress content and revive old posts with the Bulk Publish option', $this->plugin->name ),
            ),
            array(
                __( 'The Events Calendar and Event Manager Integration', $this->plugin->name ), 
                __( 'Schedule Posts to Hootsuite based on your Event\'s Start or End date, and display Event-specific details in your status updates', $this->plugin->name ),
            ),
            array(
                __( 'SEO Integration', $this->plugin->name ), 
                __( 'Display SEO-specific information in your status updates from All-In-One SEO Pack, Rank Math, SEOPress and Yoast SEO', $this->plugin->name ),
            ),
            array(
                __( 'WooCommerce Integration', $this->plugin->name ), 
                __( 'Display Product-specific information in your status updates', $this->plugin->name ),
            ),
            array(
                __( 'Autoblogging and Frontend Post Submission Integration', $this->plugin->name ), 
                __( 'Pro supports autoblogging and frontend post submission Plugins, including User Submitted Posts, WP Property Feed, WPeMatico and WP Job Manager', $this->plugin->name ),
            ),
            array(
                __( 'Shortcode Support', $this->plugin->name ), 
                __( 'Use shortcodes in status updates', $this->plugin->name ),
            ),
            array(
                __( 'Full Image Control', $this->plugin->name ), 
                __( 'Choose to display the WordPress Featured Image with your status updates, or define up to 4 custom images for each Post.', $this->plugin->name ),
            ),
            array(
                __( 'WP-Cron and WP-CLI Compatible', $this->plugin->name ), 
                __( 'Optionally enable WP-Cron to send status updates via Cron, speeding up UI performance and/or choose to use WP-CLI for reposting old posts', $this->plugin->name ),
            ),
        );
    
        // Dashboard Submodule
        if ( ! class_exists( 'WPZincDashboardWidget' ) ) {
			require_once $this->plugin->folder . '_modules/dashboard/class-wpzincdashboardwidget.php';
		}
        $this->dashboard = new WPZincDashboardWidget( $this->plugin, 'https://www.wpzinc.com/wp-content/plugins/lum-deactivation' );

        // Defer loading of Plugin Classes
        add_action( 'init', array( $this, 'initialize' ), 1 );
        add_action( 'init', array( $this, 'upgrade' ), 2 );

    }

    /**
     * Initializes required and licensed classes
     *
     * @since   3.4.9
     */
    public function initialize() {

        $this->classes = new stdClass;

        // Initialize required classes
        $this->classes->admin         = new WP_To_Social_Pro_Admin( self::$instance );
        $this->classes->ajax          = new WP_To_Social_Pro_AJAX( self::$instance );
        $this->classes->api           = new WP_To_Social_Pro_Hootsuite_API( self::$instance );
        $this->classes->common        = new WP_To_Social_Pro_Common( self::$instance );
        $this->classes->cron          = new WP_To_Social_Pro_Cron( self::$instance );
        $this->classes->image     	= new WP_To_Social_Pro_Image( self::$instance );
        $this->classes->install       = new WP_To_Social_Pro_Install( self::$instance );
        $this->classes->log           = new WP_To_Social_Pro_Log( self::$instance );
        $this->classes->media_library = new WP_To_Social_Pro_Media_Library( self::$instance );
        $this->classes->notices       = new WP_To_Social_Pro_Notices( self::$instance );
        $this->classes->owly_api      = new WP_To_Social_Pro_Owly_API( self::$instance );
        $this->classes->post          = new WP_To_Social_Pro_Post( self::$instance );
        $this->classes->publish       = new WP_To_Social_Pro_Publish( self::$instance );
        $this->classes->screen        = new WP_To_Social_Pro_Screen( self::$instance );
        $this->classes->settings      = new WP_To_Social_Pro_Settings( self::$instance );
        $this->classes->twitter_api   = new WP_To_Social_Pro_Twitter_API( self::$instance );
        $this->classes->validation    = new WP_To_Social_Pro_Validation( self::$instance );

    }

    /**
     * Runs the upgrade routine once the plugin has loaded
     *
     * @since   3.2.5
     */
    public function upgrade() {

        // Run upgrade routine
        $this->get_class( 'install' )->upgrade();

    }

    /**
     * Returns the given class
     *
     * @since   3.4.9
     *
     * @param   string  $name   Class Name
     */
    public function get_class( $name ) {

        // If the class hasn't been loaded, throw a WordPress die screen
        // to avoid a PHP fatal error.
        if ( ! isset( $this->classes->{ $name } ) ) {
            // Define the error
            $error = new WP_Error( 'wp_to_hootsuite_get_class', sprintf( __( '%s: Error: Could not load Plugin class <strong>%s</strong>', $this->plugin->name ), $this->plugin->displayName, $name ) );
             
            // Depending on the request, return or display an error
            // Admin UI
            if ( is_admin() ) {  
                wp_die(
                    $error,
                    sprintf( __( '%s: Error', $this->plugin->name ), $this->plugin->displayName ),
                    array(
                        'back_link' => true,
                    )
                );
            }

            // Cron / CLI
            return $error;
        }

        // Return the class object
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
            self::$instance = new self;
        }

        return self::$instance;

    }

}

/**
 * Define the autoloader for this Plugin
 *
 * @since   3.4.7
 *
 * @param   string  $class_name     The class to load
 */
function WP_To_Hootsuite_Autoloader( $class_name ) {

    // Define the required start of the class name
    $class_start_name = array(
        'WP_To_Social_Pro',
    );

    // Get the number of parts the class start name has
    $class_parts_count = count( explode( '_', $class_start_name[0] ) );

    // Break the class name into an array
    $class_path = explode( '_', $class_name );

    // Bail if it's not a minimum length
    if ( count( $class_path ) < $class_parts_count ) {
        return;
    }

    // Build the base class path for this class
    $base_class_path = '';
    for ( $i = 0; $i < $class_parts_count; $i++ ) {
        $base_class_path .= $class_path[ $i ] . '_';
    }
    $base_class_path = trim( $base_class_path, '_' );

    // Bail if the first parts don't match what we expect
    if ( ! in_array( $base_class_path, $class_start_name ) ) {
        return;
    }

    // Define the file name we need to include
    $file_name = strtolower( implode( '-', array_slice( $class_path, $class_parts_count ) ) ) . '.php';

    // Define the paths with file name we need to include
    $include_paths = array(
        dirname( __FILE__ ) . '/vendor/includes/admin/' . $file_name,
        dirname( __FILE__ ) . '/vendor/includes/global/' . $file_name,
        dirname( __FILE__ ) . '/includes/admin/' . $file_name,
        dirname( __FILE__ ) . '/includes/global/' . $file_name,
    );

    // Iterate through the include paths to find the file
    foreach ( $include_paths as $path_file ) {
        if ( file_exists( $path_file ) ) {
            require_once( $path_file );
            return;
        }
    }

}
spl_autoload_register( 'WP_To_Hootsuite_Autoloader' );

// Load Activation, Cron and Deactivation functions
include_once( dirname( __FILE__ ) . '/includes/admin/activation.php' );
include_once( dirname( __FILE__ ) . '/includes/admin/cron.php' );
include_once( dirname( __FILE__ ) . '/includes/admin/deactivation.php' );
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
 * @since   1.1.4
 */
function WP_To_Hootsuite() {
    
    return WP_To_Hootsuite::get_instance();

}

// Finally, initialize the Plugin.
$wp_to_hootsuite = WP_To_Hootsuite();
<?php
/**
 * Log Table class.
 *
 * @package WPZinc\Social
 * @author WP Zinc
 */

namespace WPZinc\Social;

/**
 * Controls the Log WP_List_Table.
 *
 * @package WPZinc\Social
 * @author  WP Zinc
 * @version 3.9.6
 */
class Log_Table extends \WP_List_Table {

	/**
	 * Holds the base class object.
	 *
	 * @since   3.9.6
	 *
	 * @var     object
	 */
	public $base;

	/**
	 * Holds the bulk actions.
	 *
	 * @since   3.9.6
	 *
	 * @var     array
	 */
	protected $_actions; // phpcs:ignore PSR2.Classes.PropertyDeclaration.Underscore

	/**
	 * Constructor.
	 *
	 * @since   3.9.6
	 *
	 * @param   object $base    Base Plugin Class.
	 */
	public function __construct( $base ) {

		// Store base class.
		$this->base = $base;

		parent::__construct(
			array(
				'singular' => 'wpzinc-social-log',  // Singular label.
				'plural'   => 'wpzinc-social-log',  // plural label, also this well be one of the table css class.
				'ajax'     => false,                // We won't support Ajax for this table.
			)
		);

	}

	/**
	 * Display dropdowns for Bulk Actions and Filtering.
	 *
	 * @since   3.9.6
	 *
	 * @param   string $which  The location of the bulk actions: 'top' or 'bottom'.
	 *                         This is designated as optional for backward compatibility.
	 */
	protected function bulk_actions( $which = '' ) {

		// Get Bulk Actions.
		$this->_actions = $this->get_bulk_actions();

		// Define <select> name.
		$bulk_actions_name = 'bulk_action' . ( $which !== 'top' ? '2' : '' );
		?>
		<label for="bulk-action-selector-<?php echo esc_attr( $which ); ?>" class="screen-reader-text">
			<?php esc_html_e( 'Select bulk action', 'wp-to-hootsuite' ); ?>
		</label>
		<select name="<?php echo esc_attr( $bulk_actions_name ); ?>" id="bulk-action-selector-<?php echo esc_attr( $which ); ?>" size="1">
			<option value="-1"><?php esc_attr_e( 'Bulk Actions', 'wp-to-hootsuite' ); ?></option>

			<?php
			foreach ( $this->_actions as $name => $title ) {
				?>
				<option value="<?php echo esc_attr( $name ); ?>"><?php echo esc_attr( $title ); ?></option>
				<?php
			}
			?>
		</select>

		<?php
		// Output our custom filters to the top only.
		if ( $which === 'top' ) {
			$profiles = $this->base->get_class( 'log' )->get_profile_id_names();
			?>
			<!-- Custom Filters -->
			<select name="action" size="1">
				<option value=""<?php selected( $this->get_action(), '' ); ?>><?php esc_attr_e( 'Filter by Action', 'wp-to-hootsuite' ); ?></option>
				<?php
				foreach ( $this->base->get_class( 'common' )->get_post_actions() as $action => $label ) {
					?>
					<option value="<?php echo esc_attr( $action ); ?>"<?php selected( $this->get_action(), $action ); ?>><?php echo esc_attr( $label ); ?></option>
					<?php
				}
				?>
			</select>
			<select name="profile_id" size="1">
				<option value=""<?php selected( $this->get_profile_id(), '' ); ?>><?php esc_attr_e( 'Filter by Profile', 'wp-to-hootsuite' ); ?></option>
				<?php
				foreach ( $profiles as $profile_id => $label ) {
					?>
					<option value="<?php echo esc_attr( $profile_id ); ?>"<?php selected( $this->get_profile_id(), $profile_id ); ?>><?php echo esc_attr( $label ); ?></option>
					<?php
				}
				?>
			</select>
			<select name="result" size="1">
				<option value=""<?php selected( $this->get_result(), '' ); ?>><?php esc_attr_e( 'Filter by Result', 'wp-to-hootsuite' ); ?></option>
				<?php
				foreach ( $this->base->get_class( 'log' )->get_result_options() as $result_option => $label ) {
					?>
					<option value="<?php echo esc_attr( $result_option ); ?>"<?php selected( $this->get_result(), $result_option ); ?>>
						<?php echo esc_attr( $label ); ?>
					</option>
					<?php
				}
				?>
			</select>

			<input type="date" name="request_sent_start_date" value="<?php echo esc_attr( $this->get_request_sent_start_date() ); ?>" />
			-
			<input type="date" name="request_sent_end_date" value="<?php echo esc_attr( $this->get_request_sent_end_date() ); ?>"/>
			<?php
		}

		submit_button( __( 'Apply', 'wp-to-hootsuite' ), 'action', '', false, array( 'id' => 'doaction' ) );

		$clear_logs_url = add_query_arg(
			array(
				'page'         => $this->base->plugin->name . '-log',
				'bulk_action3' => 'delete_all',
				'_wpnonce'     => wp_create_nonce( 'bulk-wpzinc-social-log' ),
			),
			admin_url( 'admin.php' )
		);
		?>

		<a href="<?php echo esc_url( $clear_logs_url ); ?>" class="<?php echo esc_attr( $this->base->plugin->name ); ?>-clear-log button wpzinc-button-red" data-message="<?php esc_html_e( 'Are you sure you want to clear ALL logs?', 'wp-to-hootsuite' ); ?>">
			<?php esc_html_e( 'Clear Log', 'wp-to-hootsuite' ); ?>
		</a>
		<?php

	}

	/**
	 * Defines the message to display when no items exist in the table
	 *
	 * @since   3.9.6
	 */
	public function no_items() {

		esc_html_e( 'No log entries found based on the given search and filter criteria.', 'wp-to-hootsuite' );

	}

	/**
	 * Displays the search box.
	 *
	 * @since   3.1.0
	 *
	 * @param   string $text        The 'submit' button label.
	 * @param   string $input_id    ID attribute value for the search input field.
	 */
	public function search_box( $text, $input_id ) {

		// Build default values for filters.
		$filters_values = array();
		foreach ( $this->base->get_class( 'common' )->get_log_filters() as $filter ) {
			$filters_values[ $filter ] = false;
		}

		// If a nonce is present, read the request.
		if ( isset( $_REQUEST['_wpnonce'] ) && wp_verify_nonce( sanitize_key( wp_unslash( $_REQUEST['_wpnonce'] ) ), 'bulk-wpzinc-social-log' ) ) {
			foreach ( $this->base->get_class( 'common' )->get_log_filters() as $filter ) {
				if ( ! array_key_exists( $filter, $_REQUEST ) ) {
					continue;
				}
				$filters_values[ $filter ] = sanitize_text_field( wp_unslash( $_REQUEST[ $filter ] ) );
			}
		}

		$input_id = $input_id . '-search-input';

		// Preserve Filters by storing any defined as hidden form values.
		foreach ( $this->base->get_class( 'common' )->get_log_filters() as $filter ) {
			if ( $filters_values[ $filter ] !== false ) {
				?>
				<input type="hidden" name="<?php echo esc_attr( $filter ); ?>" value="<?php echo esc_attr( $filters_values[ $filter ] ); ?>" />
				<?php
			}
		}
		?>
		<p class="search-box">
			<label class="screen-reader-text" for="<?php echo esc_attr( $input_id ); ?>"><?php echo esc_attr( $text ); ?>:</label>
			<input type="search" id="<?php echo esc_attr( $input_id ); ?>" name="s" value="<?php _admin_search_query(); ?>" placeholder="<?php esc_attr_e( 'Post ID or Title', 'wp-to-hootsuite' ); ?>" />
			<?php submit_button( $text, '', '', false, array( 'id' => 'search-submit' ) ); ?>
		</p>
		<?php
	}

	/**
	 * Define the columns that are going to be used in the table
	 *
	 * @since   3.9.6
	 *
	 * @return  array   Columns to use with the table
	 */
	public function get_columns() {

		return array(
			'cb'                => '<input type="checkbox" class="toggle" />',
			'post_id'           => __( 'Post ID', 'wp-to-hootsuite' ),
			'request_sent'      => __( 'Request Sent', 'wp-to-hootsuite' ),
			'action'            => __( 'Action', 'wp-to-hootsuite' ),
			'profile_name'      => __( 'Profile', 'wp-to-hootsuite' ),
			'status_text'       => __( 'Status Text', 'wp-to-hootsuite' ),
			'result'            => __( 'Result', 'wp-to-hootsuite' ),
			'result_message'    => __( 'Response', 'wp-to-hootsuite' ),
			'status_created_at' => sprintf(
				/* translators: Social Media Service Name (Buffer, Hootsuite) */
				__( '%s: Status Created At', 'wp-to-hootsuite' ),
				$this->base->plugin->account
			),
			'status_due_at'     => sprintf(
				/* translators: Social Media Service Name (Buffer, Hootsuite) */
				__( '%s: Status Scheduled For', 'wp-to-hootsuite' ),
				$this->base->plugin->account
			),
		);

	}

	/**
	 * Decide which columns to activate the sorting functionality on
	 *
	 * @since   3.9.6
	 *
	 * @return  array   Columns that can be sorted by the user
	 */
	public function get_sortable_columns() {

		return array(
			'post_id'           => array( 'post_id', true ),
			'request_sent'      => array( 'request_sent', true ),
			'action'            => array( 'action', true ),
			'profile_name'      => array( 'profile_name', true ),
			'status_text'       => array( 'status_text', true ),
			'result'            => array( 'result', true ),
			'result_message'    => array( 'result_message', true ),
			'status_created_at' => array( 'status_created_at', true ),
			'status_due_at'     => array( 'status_due_at', true ),
		);

	}

	/**
	 * Overrides the list of bulk actions in the select dropdowns above and below the table
	 *
	 * @since   3.9.6
	 *
	 * @return  array   Bulk Actions
	 */
	public function get_bulk_actions() {

		return array(
			'delete' => __( 'Delete', 'wp-to-hootsuite' ),
		);

	}

	/**
	 * Prepare the table with different parameters, pagination, columns and table elements
	 *
	 * @since   3.9.6
	 */
	public function prepare_items() {

		global $_wp_column_headers;

		$screen = get_current_screen();

		// Get params.
		$params   = $this->get_search_params();
		$order_by = $this->get_order_by();
		$order    = $this->get_order();
		$page     = $this->get_page();
		$per_page = $this->get_items_per_page( $this->base->plugin->filter_name . '_logs_per_page', 20 );

		// Get total records for this query.
		$total = $this->base->get_class( 'log' )->total( $params );

		// Define pagination.
		$this->set_pagination_args(
			array(
				'total_items' => $total,
				'total_pages' => (int) ceil( $total / $per_page ),
				'per_page'    => $per_page,
			)
		);

		// Set column headers.
		$this->_column_headers = $this->get_column_info();

		// Set rows.
		$this->items = $this->base->get_class( 'log' )->search( $order_by, $order, $page, $per_page, $params );

	}

	/**
	 * Generate the table navigation above or below the table
	 *
	 * @since   3.1.0
	 *
	 * @param   string $which  The location of the bulk actions: 'top' or 'bottom'.
	 *                         This is designated as optional for backward compatibility.
	 */
	protected function display_tablenav( $which ) {

		if ( 'top' === $which ) {
			wp_nonce_field( 'bulk-' . $this->_args['plural'] );
		}
		?>
		<div class="tablenav <?php echo esc_attr( $which ); ?>">
			<div class="alignleft actions bulkactions">
				<?php $this->bulk_actions( $which ); ?>
			</div>
			<?php
			$this->extra_tablenav( $which );
			$this->pagination( $which );
			?>

			<br class="clear" />
		</div>
		<?php

	}

	/**
	 * Display the rows of records in the table
	 *
	 * @since   3.9.6
	 */
	public function display_rows() {

		echo wp_kses(
			$this->base->get_class( 'log' )->build_log_table_output( $this->items, true, $this->_column_headers ),
			array(
				'tr'    => array(
					'class' => array(),
				),
				'th'    => array(
					'scope' => array(),
					'class' => array(),
				),
				'td'    => array(
					'class' => array(),
				),
				'a'     => array(
					'href'   => array(),
					'target' => array(),
				),
				'br'    => array(),
				'input' => array(
					'type'  => array(
						'checkbox',
					),
					'name'  => array(),
					'value' => array(),
				),
			)
		);

	}

	/**
	 * Get search parameters.
	 *
	 * @since   3.9.6
	 *
	 * @return  array   Search Parameters
	 */
	private function get_search_params() {

		// Build search params.
		$params = array(
			'action'                  => $this->get_action(),
			'profile_id'              => $this->get_profile_id(),
			'result'                  => $this->get_result(),
			'request_sent_start_date' => $this->get_request_sent_start_date(),
			'request_sent_end_date'   => $this->get_request_sent_end_date(),
		);

		// Return params if freeform search isn't supplied.
		if ( ! filter_has_var( INPUT_GET, 's' ) ) {
			return $params;
		}

		// Get search.
		$search = filter_input( INPUT_GET, 's', FILTER_SANITIZE_FULL_SPECIAL_CHARS );

		// If search is a number, add it as the Post ID and return.
		if ( is_numeric( $search ) ) {
			$params['post_id'] = absint( $search );
			return $params;
		}

		// Add it as the Post Title and return.
		$params['post_title'] = $search;

		return $params;

	}

	/**
	 * Returns whether a search has been performed on the table.
	 *
	 * @since   3.9.0
	 *
	 * @return  bool    Search has been performed.
	 */
	public function is_search() {

		return filter_has_var( INPUT_GET, 's' );

	}

	/**
	 * Get the Search requested by the user
	 *
	 * @since   3.9.0
	 *
	 * @return  string
	 */
	public function get_search() {

		// Bail if nonce is not valid.
		if ( ! isset( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_REQUEST['_wpnonce'] ) ), 'bulk-wpzinc-social-log' ) ) {
			return '';
		}

		if ( ! array_key_exists( 's', $_REQUEST ) ) {
			return '';
		}

		return urldecode( sanitize_text_field( wp_unslash( $_REQUEST['s'] ) ) );

	}

	/**
	 * Get the Action Filter requested by the user
	 *
	 * @since   3.9.7
	 *
	 * @return  string
	 */
	private function get_action() {

		// Bail if nonce is not valid.
		if ( ! isset( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_REQUEST['_wpnonce'] ) ), 'bulk-wpzinc-social-log' ) ) {
			return '';
		}

		if ( ! array_key_exists( 'action', $_REQUEST ) ) {
			return '';
		}

		return sanitize_text_field( wp_unslash( $_REQUEST['action'] ) );

	}

	/**
	 * Get the Profile ID Filter requested by the user
	 *
	 * @since   3.9.7
	 *
	 * @return  string
	 */
	private function get_profile_id() {

		// Bail if nonce is not valid.
		if ( ! isset( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_REQUEST['_wpnonce'] ) ), 'bulk-wpzinc-social-log' ) ) {
			return '';
		}

		if ( ! array_key_exists( 'profile_id', $_REQUEST ) ) {
			return '';
		}

		return sanitize_text_field( wp_unslash( $_REQUEST['profile_id'] ) );

	}

	/**
	 * Get the Status Result Filter requested by the user
	 *
	 * @since   3.9.7
	 *
	 * @return  string
	 */
	private function get_result() {

		// Bail if nonce is not valid.
		if ( ! isset( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_REQUEST['_wpnonce'] ) ), 'bulk-wpzinc-social-log' ) ) {
			return '';
		}

		if ( ! array_key_exists( 'result', $_REQUEST ) ) {
			return '';
		}

		return sanitize_text_field( wp_unslash( $_REQUEST['result'] ) );

	}

	/**
	 * Get the Request Sent Start Date Filter requested by the user
	 *
	 * @since   3.9.8
	 *
	 * @return  string
	 */
	private function get_request_sent_start_date() {

		// Bail if nonce is not valid.
		if ( ! isset( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_REQUEST['_wpnonce'] ) ), 'bulk-wpzinc-social-log' ) ) {
			return '';
		}

		if ( ! array_key_exists( 'request_sent_start_date', $_REQUEST ) ) {
			return '';
		}

		return sanitize_text_field( wp_unslash( $_REQUEST['request_sent_start_date'] ) );

	}

	/**
	 * Get the Request Sent End Date Filter requested by the user
	 *
	 * @since   3.9.8
	 *
	 * @return  string
	 */
	private function get_request_sent_end_date() {

		// Bail if nonce is not valid.
		if ( ! isset( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_REQUEST['_wpnonce'] ) ), 'bulk-wpzinc-social-log' ) ) {
			return '';
		}

		if ( ! array_key_exists( 'get_request_sent_end_date', $_REQUEST ) ) {
			return '';
		}

		return sanitize_text_field( wp_unslash( $_REQUEST['get_request_sent_end_date'] ) );

	}

	/**
	 * Get the Order By requested by the user
	 *
	 * @since   3.9.7
	 *
	 * @return  string
	 */
	private function get_order_by() {

		// Don't nonce check because order by may not include a nonce if no search performed.
		if ( ! filter_has_var( INPUT_GET, 'orderby' ) ) {
			return 'request_sent';
		}

		return filter_input( INPUT_GET, 'orderby', FILTER_SANITIZE_FULL_SPECIAL_CHARS );

	}

	/**
	 * Get the Order requested by the user
	 *
	 * @since   3.9.7
	 *
	 * @return  string
	 */
	private function get_order() {

		// Don't nonce check because order may not include a nonce if no search performed.
		if ( ! filter_has_var( INPUT_GET, 'order' ) ) {
			return 'DESC';
		}

		return filter_input( INPUT_GET, 'order', FILTER_SANITIZE_FULL_SPECIAL_CHARS );

	}

	/**
	 * Get the Pagination Page requested by the user
	 *
	 * @since   3.9.7
	 *
	 * @return  int
	 */
	private function get_page() {

		// Don't nonce check because pagination may not include a nonce if no search performed.
		if ( ! filter_has_var( INPUT_GET, 'paged' ) ) {
			return 1;
		}

		return absint( filter_input( INPUT_GET, 'paged', FILTER_SANITIZE_FULL_SPECIAL_CHARS ) );

	}

}

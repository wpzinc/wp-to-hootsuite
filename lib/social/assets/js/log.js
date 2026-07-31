/**
 * Handles UI elements for the Plugin Log screen.
 *
 * @since 	3.9.6
 *
 * @package
 * @author WP Zinc
 */

jQuery(document).ready(function ($) {
	/**
	 * Refresh Log
	 *
	 * @since 	4.4.0
	 */
	$('a.' + wpzinc_social.plugin_name + '-refresh-log').on(
		'click',
		function (e) {
			// Prevent default action.
			e.preventDefault();

			// Define button.
			const button = $(this);

			// Send AJAX request to clear log.
			$.post(
				wpzinc_social.ajax,
				{
					action: $(button).data('action'),
					post: wpzinc_social.post_id,
					nonce: wpzinc_social.get_log_nonce,
				},
				function (response) {
					// Replace the table data with the response data.
					$('table.widefat tbody', $($(button).data('target'))).html(
						response.data
					);
				}
			);
		}
	);

	/**
	 * Clear Log
	 *
	 * @since 	3.0.0
	 */
	$('a.' + wpzinc_social.plugin_name + '-clear-log').on(
		'click',
		function (e) {
			// Define button.
			const button = $(this);

			// Bail if the user doesn't want to clear the log.
			const result = confirm($(button).data('message'));
			if (!result) {
				// Prevent default action.
				e.preventDefault();
				return false;
			}

			// If the button doesn't have an action and a target, it's not an AJAX request.
			// Let the request through.
			if (
				typeof $(button).data('action') === 'undefined' ||
				typeof $(button).data('target') === 'undefined'
			) {
				return true;
			}

			// Prevent default action.
			e.preventDefault();

			// Send AJAX request to clear log.
			$.post(
				wpzinc_social.ajax,
				{
					action: $(button).data('action'),
					post: $('input[name=post_ID]').val(),
					nonce: wpzinc_social.clear_log_nonce,
				},
				function () {
					// Clear Log.
					$('table.widefat tbody', $($(button).data('target'))).html(
						'<tr><td colspan="8">' +
							wpzinc_social.clear_log_completed +
							'</td></tr>'
					);
				}
			);
		}
	);
});

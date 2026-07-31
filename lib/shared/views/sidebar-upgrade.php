<?php
/**
 * Outputs settings screen sidebar for free plugins with
 * an email newsletter form.
 *
 * @package WPZinc\Shared
 * @author WP Zinc
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- Keep Updated -->
<div class="postbox">
	<h3 class="hndle">
		<?php esc_html_e( 'Keep Updated', 'wp-to-hootsuite' ); ?>
	</h3>

	<div class="wpzinc-option">
		<p class="description">
			<?php esc_html_e( 'Subscribe to the newsletter and receive updates on our WordPress Plugins.', 'wp-to-hootsuite' ); ?>
		</p>
	</div>

	<script async data-uid="<?php echo esc_attr( $this->base->plugin->convertkit_form_uid ); ?>" src="https://dedicated-crafter-4782.ck.page/<?php echo esc_attr( $this->base->plugin->convertkit_form_uid ); ?>/index.js"></script>
</div>

<?php
/**
 * Outputs an upgrade notice below the table of statuses for an action (publish,update,repost,bulk publish),
 * when the Free version of the Plugin is used.
 *
 * @package WPZinc\Social
 * @author  WP Zinc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="wpzinc-option highlight">
	<div class="full">
		<h4>
			<?php
			echo esc_html(
				sprintf(
				/* translators: Social Media Service Name (Buffer, Hootsuite) */
					__( 'Want to %1$s multiple status updates to %2$s?', 'wp-to-hootsuite' ),
					$post_action,
					$this->base->plugin->displayName
				)
			);
			?>
		</h4>

		<p>
			<?php
			echo esc_html(
				sprintf(
				/* translators: Plugin Name */
					__( 'Define additional unique statuses, each with publishing conditions and custom scheduling, per social network with %s.', 'wp-to-hootsuite' ),
					$this->base->plugin->displayName
				)
			);
			?>
		</p>

		<a href="<?php echo esc_attr( $this->base->dashboard->get_upgrade_url( 'settings_inline_upgrade' ) ); ?>" class="button button-primary" target="_blank"><?php esc_html_e( 'Upgrade', 'wp-to-hootsuite' ); ?></a>
	</div>
</div>

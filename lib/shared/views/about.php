<?php
/**
 * Outputs the About section, comprising of other Plugins.
 *
 * @package WPZinc\Shared
 * @author WP Zinc
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wpzinc-about">
	<h3><?php esc_html_e( 'Our Products', 'wp-to-hootsuite' ); ?></h3>

	<p class="description">
		<?php esc_html_e( 'If you found this Plugin useful, you may also like our other products.', 'wp-to-hootsuite' ); ?>
	</p>

	<br />

	<div class="plugin-install-php">
		<?php
		foreach ( $products as $product ) {
			include $this->dashboard_folder . '/views/about-plugin-card.php';
		}
		?>
	</div>
</div>


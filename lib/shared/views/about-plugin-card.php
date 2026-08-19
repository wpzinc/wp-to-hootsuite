<?php
/**
 * Outputs a Plugin Card.
 *
 * @package WPZinc\Shared
 * @author WP Zinc
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="plugin-card">
	<div class="plugin-card-top">
		<div class="name column-name">
			<h3>
				<a href="<?php echo esc_url( $product['url'] ); ?>" target="_blank">
					<?php echo esc_html( $product['name'] ); ?>
					<img src="<?php echo esc_url( $product['icon'] ); ?>" class="plugin-icon" alt="">
				</a>
			</h3>
		</div>
		<div class="desc column-description">
			<p><?php echo esc_html( $product['description'] ); ?></p>
		</div>
	</div>

	<div class="plugin-card-bottom">
		<div class="vers column-rating">
			<?php esc_html_e( 'from', 'wp-to-hootsuite' ); ?> $<?php echo esc_html( $product['price'] ); ?>/<?php esc_html_e( 'year', 'wp-to-hootsuite' ); ?>
		</div>
		<div class="column-updated">
			<?php
			if ( array_key_exists( 'install_url', $product ) && ! empty( $product['install_url'] ) ) {
				?>
				<a href="<?php echo esc_url( $product['install_url'] ); ?>" class="button button-primary" target="_blank"><?php esc_html_e( 'Install', 'wp-to-hootsuite' ); ?></a>
				<?php
			}
			?>
			<a href="<?php echo esc_url( $product['url'] ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Learn More', 'wp-to-hootsuite' ); ?></a>
		</div>
	</div>
</div>
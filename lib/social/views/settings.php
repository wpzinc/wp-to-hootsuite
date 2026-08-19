<?php
/**
 * Outputs the settings screen.
 *
 * @package WPZinc\Social
 * @author  WP Zinc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<header>
	<h1>
		<?php echo esc_html( $this->base->plugin->displayName ); ?>

		<span>
			<?php esc_html_e( 'Settings', 'wp-to-hootsuite' ); ?>
		</span>
	</h1>
</header>

<div class="wrap">
	<?php
	// Output notices.
	$this->base->get_class( 'notices' )->set_key_prefix( $this->base->plugin->filter_name . '_' . wp_get_current_user()->ID );
	$this->base->get_class( 'notices' )->output_notices();
	?>

	<!-- Container for JS notices -->
	<div class="js-notices"></div>

	<div class="wrap-inner">
		<!-- Notices -->
		<hr class="wp-header-end" />

		<!-- Tabs -->
		<h2 class="nav-tab-wrapper wpzinc-horizontal-tabbed-ui">
			<!-- Settings -->
			<a href="admin.php?page=<?php echo esc_attr( $this->base->plugin->name ); ?>-settings" class="nav-tab<?php echo esc_attr( $tab === 'auth' ? ' nav-tab-active' : '' ) . ( $this->base->get_class( 'settings' )->account_connected() ? ' enabled' : ' error' ); ?>" title="<?php esc_attr_e( 'Settings', 'wp-to-hootsuite' ); ?>">
				<span class="dashicons dashicons-lock"></span> 
				<?php
				if ( $this->base->get_class( 'settings' )->account_connected() ) {
					?>
					<span class="dashicons dashicons-yes"></span>
					<?php
				} else {
					?>
					<span class="dashicons dashicons-warning"></span>
					<?php
				}
				?>
				<span class="text">
					<?php esc_html_e( 'Settings', 'wp-to-hootsuite' ); ?>
				</span>
			</a>

			<!-- Public Post Types -->
			<?php
			// Go through all Post Types, if authenticated.
			if ( $this->base->get_class( 'settings' )->account_connected() ) {
				foreach ( $post_types as $public_post_type => $post_type_obj ) {
					// Work out the icon to display.
					$icon = '';
					if ( ! empty( $post_type_obj->menu_icon ) ) {
						$icon = 'dashicons ' . $post_type_obj->menu_icon;
					} elseif ( $public_post_type === 'post' || $public_post_type === 'page' ) {
							$icon = 'dashicons dashicons-admin-' . $public_post_type;
					}

					// Determine if the Post Type is set to post.
					$is_post_type_enabled = $this->base->get_class( 'settings' )->is_post_type_enabled( $public_post_type );
					?>
					<a href="admin.php?page=<?php echo esc_attr( $this->base->plugin->name ); ?>-settings&amp;tab=post&amp;type=<?php echo esc_attr( $public_post_type ); ?>" class="nav-tab<?php echo esc_attr( $post_type === $public_post_type ? ' nav-tab-active' : '' ) . ( $is_post_type_enabled ? ' enabled' : '' ); ?>" title="<?php echo esc_attr( $post_type_obj->labels->name ); ?>" data-post-type="<?php echo esc_attr( $public_post_type ); ?>">
						<span class="<?php echo esc_attr( $icon ); ?>"></span>
						<span class="dashicons dashicons-yes"></span>
						<span class="text">
							<?php echo esc_attr( $post_type_obj->labels->name ); ?>
						</span>
					</a>
					<?php
				}
			}
			?>

			<!-- Documentation -->
			<a href="<?php echo esc_attr( $documentation_url ); ?>" class="nav-tab last documentation" title="<?php esc_html_e( 'Documentation', 'wp-to-hootsuite' ); ?>" target="_blank">
				<span class="text">
					<?php esc_html_e( 'Documentation', 'wp-to-hootsuite' ); ?>
				</span>
				<span class="text-mobile">
					<?php esc_html_e( 'Docs', 'wp-to-hootsuite' ); ?>
				</span>
				<span class="dashicons dashicons-admin-page"></span>
			</a>
		</h2>

		<!-- Form Start -->
		<?php
		// id is deliberate; to ensure CSS, JS etc. works for all versions.
		?>
		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-2">
				<!-- Content -->
				<form name="post" method="post" action="<?php echo ( isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '' ); ?>" id="<?php echo esc_attr( $this->base->plugin->name ); ?>" class="wpzinc-social">
					<div id="post-body-content">
						<div id="normal-sortables" class="meta-box-sortables ui-sortable publishing-defaults">  
							<?php
							// Load sub view.
							require_once $this->base->plugin->folder . 'lib/social/views/settings-' . $tab . '.php';
							?>
						</div>
						<!-- /normal-sortables -->

						<?php
						if ( ! $disable_save_button ) {
							?>
							<!-- Save -->
							<div>
								<?php wp_nonce_field( $this->base->plugin->name, $this->base->plugin->name . '_nonce' ); ?>
								<input type="submit" name="submit" value="<?php esc_attr_e( 'Save', 'wp-to-hootsuite' ); ?>" class="button button-primary" />
							</div>
							<?php
						}
						?>
					</div>
					<!-- /post-body-content -->
				</form>

				<!-- Sidebar -->
				<div id="postbox-container-1" class="postbox-container">
					<?php
					// Define the default upgrade content.
					$upgrade_title   = __( 'Keep Updated', 'wp-to-hootsuite' );
					$upgrade_content = esc_html__( 'Subscribe to the newsletter and receive updates on our WordPress Plugins.', 'wp-to-hootsuite' ) . '<script async data-uid="' . $this->base->plugin->convertkit_form_uid . '" src="https://dedicated-crafter-4782.ck.page/' . $this->base->plugin->convertkit_form_uid . '/index.js"></script>';

					// If a free Buffer account is connected, show the switch to Social Post Flow upgrade.
					foreach ( $accounts as $account ) {
						if ( $account['plan'] === 'free' ) {
							$upgrade_title       = esc_html__( 'Switch to Social Post Flow', 'wp-to-hootsuite' );
							$upgrade_content     = esc_html__( 'Up to 5 channels for $49/year. Our own scheduling tool replaces Buffer entirely. The same 5 channels on Buffer\'s paid plan would cost around $360/year, so you save over $300 a year and remove the per channel fee for good.', 'wp-to-hootsuite' );
							$upgrade_url         = 'https://www.socialpostflow.com/?utm_source=wp-to-buffer&utm_medium=settings&utm_campaign=sidebar-upgrade';
							$upgrade_button_text = esc_html__( 'Try Social Post Flow', 'wp-to-hootsuite' );
							break;
						}
					}

					require $this->base->plugin->folder . '/lib/shared/views/sidebar-upgrade.php';
					?>
				</div>
				<!-- /Sidebar -->
			</div>
		</div> 

		<!-- Upgrade -->
		<div class="metabox-holder columns-1">
			<div id="post-body-content">
				<?php
				require $this->base->plugin->folder . '/lib/shared/views/footer-upgrade.php';

				do_action( 'wpzinc_settings_footer_upgrade' );
				?>
			</div>
		</div>
	</div><!-- ./wrap-inner -->         
</div>

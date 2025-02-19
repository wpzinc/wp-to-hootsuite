<?php
/**
 * Outputs the Logs WP_List_Table.
 *
 * @package WP_To_Social_Pro
 * @author  WP Zinc
 */

?>
<header style="--wpzinc-logo: url('<?php echo esc_attr( $this->base->plugin->logo ); ?>')">
	<h1>
		<?php echo esc_html( $this->base->plugin->displayName ); ?>

		<span>
			<?php esc_html_e( 'Logs', 'wp-to-hootsuite' ); ?>
		</span>
	</h1>
</header>

<hr class="wp-header-end" />

<div class="wrap">
	<?php
	// Search Subtitle.
	if ( $table->is_search() ) {
		?>
		<span class="subtitle left"><?php esc_html_e( 'Search results for', 'wp-to-hootsuite' ); ?> &#8220;<?php echo esc_html( $table->get_search() ); ?>&#8221;</span>
		<?php
	}
	?>

	<form action="admin.php?page=<?php echo esc_attr( $this->base->plugin->name ); ?>-log" method="post" id="posts-filter">
		<?php
		// Output Search Box.
		$table->search_box( __( 'Search', 'wp-to-hootsuite' ), 'wp-to-social-log' );

		// Output Table.
		$table->display();
		?>
	</form>
</div><!-- /.wrap -->

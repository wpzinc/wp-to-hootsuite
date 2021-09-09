<?php
/**
 * Outputs Settings View when an error occured fetching Profiles from the API
 *
 * @since    4.6.9
 */
?>
    
<div class="postbox">
    <div class="wpzinc-option">
        <p class="description">
            <?php echo $profiles->get_error_message(); ?>
        </p>
        <p class="description">
            <?php
            echo sprintf(
                /* translators: Social Media Service Name (Buffer, Hootsuite, SocialPilot) */
                __( 'Visit your %s account to resolve this error.', 'wp-to-social-pro' ),
                $this->base->plugin->account
            );
            ?>
        </p>
    </div>
    <div class="wpzinc-option">
        <a href="<?php echo $this->base->get_class( 'api' )->get_connect_profiles_url(); ?>" target="_blank" rel="nofollow noopener" class="button button-primary">
            <?php
            echo sprintf(
                /* translators: Social Media Service Name (Buffer, Hootsuite, SocialPilot) */
                __( 'Visit %s', 'wp-to-social-pro' ),
                $this->base->plugin->account
            );
            ?>
        </a>
    </div>
</div>
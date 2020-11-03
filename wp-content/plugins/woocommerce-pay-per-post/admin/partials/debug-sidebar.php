<div class="postbox">
    <h2 class="hndle"><?php esc_attr_e( 'Quick Debug Info', 'wc_pay_per_post' ); ?></h2>

    <div class="inside">
        <?php echo Woocommerce_Pay_Per_Post_Debug::output_debug_stats(); ?>
    </div>

</div>

<div class="postbox">
    <h2 class="hndle"><?php esc_attr_e( 'Need Support?', 'wc_pay_per_post' ); ?></h2>

    <div class="inside">

        <p><?php _e( 'Use the button below to copy all of your Wordpress Details and then visit our <a href="https://pramadillo.com/support/" target="_blank">Support Page</a> to fill out a request.  Make sure to paste in your system report.', 'wc_pay_per_post' ); ?></p>

        <div class="site-health-copy-buttons">
            <div class="copy-button-wrapper">
                <button type="button" class="button copy-button button-primary"
                        data-clipboard-text="<?php echo esc_attr( WP_Debug_Data::format( $info, 'debug' ) ); ?>">
				    <?php _e( 'Copy site info to clipboard' ); ?>
                </button>
                <span class="success" aria-hidden="true"><?php _e( 'Copied!' ); ?></span>
            </div>
        </div>
    </div>

</div>


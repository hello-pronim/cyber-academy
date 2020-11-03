<?php
wp_enqueue_style( 'site-health' );
wp_enqueue_script( 'site-health' );

if ( ! class_exists( 'WP_Debug_Data' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-debug-data.php' );
}

?>
<div class="wrap about-wrap debug wc-ppp-debug full-width-layout">
    <h1><?php _e( 'Pay For Post with WooCommerce Debug' ); ?></h1>
    <div class="pramadillo-badge"><img src="<?php echo plugin_dir_url( __DIR__ ) . 'img/icon.png'; ?>"/></div>
    <p class="about-text"><?php _e( 'This page can show you every detail about the configuration of your WordPress website. This information is incredibly helpful when debugging any issues related to the Pay For Post with WooCommerce plugin.' ); ?></p>

    <div class="wc-ppp-settings-wrap">

        <div id="poststuff">

            <div id="post-body" class="metabox-holder columns-2">
                <div id="post-body-content">

                    <div class="postbox">
                        <h2 class="hndle"><?php esc_attr_e( 'Common Issues', 'wc_pay_per_post' ); ?></h2>

                        <div class="inside">
                            <h4><?php _e( 'Enabling Guest Checkout' ); ?></h4>
                            <p><?php _e( 'You need to make sure that you do <strong>NOT</strong> have guest checkout enabled on your WooCommerce store.  User accounts are necessary to keep track of who purchased what and when. <br><br>If you are not sure, check your WooCommerce settings <a href="/wp-admin/admin.php?page=wc-settings&tab=account">here</a>' ); ?></p>
                            <h4><?php _e( 'Content Still Displaying to Public' ); ?></h4>
                            <p><?php _e( 'Out of the box this plugin works with the standard POSTS and PAGES using the_content filter from Wordpress.  Your theme may not be utilizing the_content filter or may be a different custom post type.  No worries though, you can still utilize this plugin, you just need to look at the <a href="https://pramadillo.com/plugins/woocommerce-pay-per-post/#template-functions" target="_blank">Template Functions</a>.' ); ?></p>

                        </div>

                    </div>
                    <div class="health-wcheck-body health-check-debug-tabs hide-if-no-js">
						<?php
						WP_Debug_Data::check_for_updates();
						$info = WP_Debug_Data::debug_data();
						?>

                        <div id="health-check-debug" class="health-check-accordion">

							<?php

							$sizes_fields = array(
								'uploads_size',
								'themes_size',
								'plugins_size',
								'wordpress_size',
								'database_size',
								'total_size'
							);

							foreach ( $info as $section => $details ) {
								if ( ! isset( $details['fields'] ) || empty( $details['fields'] ) ) {
									continue;
								}

								?>
                                <h3 class="health-check-accordion-heading">
                                    <button aria-expanded="false" class="health-check-accordion-trigger"
                                            aria-controls="health-check-accordion-block-<?php echo esc_attr( $section ); ?>"
                                            type="button">
                                            <span class="title">
                                                <?php echo esc_html( $details['label'] ); ?>
                                                <?php

                                                if ( isset( $details['show_count'] ) && $details['show_count'] ) {
                                                    printf( '(%d)', count( $details['fields'] ) );
                                                }

                                                ?>
                                            </span>
                                            <?php

                                            if ( 'wp-paths-sizesss' === $section ) {
                                                ?>
                                                <span class="health-check-wp-paths-sizes spinner"></span>
                                                <?php
                                            }

                                            ?>
                                            <span class="icon"></span>
                                    </button>
                                </h3>

                                <div id="health-check-accordion-block-<?php echo esc_attr( $section ); ?>"
                                     class="health-check-accordion-panel" hidden="hidden">
									<?php

									if ( isset( $details['description'] ) && ! empty( $details['description'] ) ) {
										printf( '<p>%s</p>', $details['description'] );
									}

									?>
                                    <table class="widefat striped health-check-table" role="presentation">
                                        <tbody>
										<?php

										foreach ( $details['fields'] as $field_name => $field ) {
											if ( is_array( $field['value'] ) ) {
												$values = '<ul>';

												foreach ( $field['value'] as $name => $value ) {
													$values .= sprintf( '<li>%s: %s</li>', esc_html( $name ), esc_html( $value ) );
												}

												$values .= '</ul>';
											} else {
												$values = esc_html( $field['value'] );
											}

											if ( in_array( $field_name, $sizes_fields, true ) ) {
												printf( '<tr><td>%s</td><td class="%s">%s</td></tr>', esc_html( $field['label'] ), esc_attr( $field_name ), $values );
											} else {
												printf( '<tr><td>%s</td><td>%s</td></tr>', esc_html( $field['label'] ), $values );
											}
										}

										?>
                                        </tbody>
                                    </table>
                                </div>
							<?php } ?>
                        </div>
                    </div>
	                <?php if ( $enable_debugging ): ?>
                    <br><br>

                        <div class="postbox">
                            <h2 class="hndle"><?php esc_attr_e( 'Debug Log', 'wc_pay_per_post' ); ?></h2>

                            <div class="inside">
                                <strong><?php esc_attr_e( 'Log File Location', 'wc_pay_per_post' ); ?></strong>: <a href="<?php echo Woocommerce_Pay_Per_Post_Helper::logger_url(); ?>" target="_blank"><?php echo Woocommerce_Pay_Per_Post_Helper::logger_uri(); ?></a> | <a href="<?php echo wp_nonce_url( admin_url( 'admin.php?page=' . WC_PPP_SLUG . '-settings' ), 'delete_log', 'delete_log_nonce' ); ?>" title="Delete Log"><span class="dashicons dashicons-dismiss error-message"></span></a>

                                <?php if(file_exists(Woocommerce_Pay_Per_Post_Helper::logger_uri())): ?>
                                <textarea style="width:100%; height:500px;"><?php include(Woocommerce_Pay_Per_Post_Helper::logger_uri()); ?></textarea>
                            <?php endif; ?>
                            </div>

                        </div>
	                <?php endif; ?>

                </div>
				<?php require_once plugin_dir_path( __FILE__ ) . 'settings-sidebar.php'; ?>
            </div>

        </div>
    </div>
</div>
<?php

use  Carbon\Carbon ;
use  PRAMADILLO\Woocommerce_Pay_Per_Post_Restrict_Content ;
/**
 * Class Woocommerce_Pay_Per_Post_Public
 */
class Woocommerce_Pay_Per_Post_Public
{
    private  $should_track_pageview = true ;
    public function init()
    {
        Woocommerce_Pay_Per_Post_Shortcodes::register_shortcodes();
    }
    
    public function should_disable_comments()
    {
        $turn_off_comments_completely_to_everyone_on_protected_posts = (bool) get_option( WC_PPP_SLUG . '_turn_off_comments_when_protected', true );
        $allow_admins_access_to_protected_posts = get_option( WC_PPP_SLUG . '_allow_admins_access_to_protected_posts', false );
        $is_protected = Woocommerce_Pay_Per_Post_Helper::is_protected( get_the_ID() );
        
        if ( $turn_off_comments_completely_to_everyone_on_protected_posts && $is_protected ) {
            add_filter( 'comments_open', function () {
                return false;
            } );
            add_filter( 'get_comments_number', function () {
                return 0;
            } );
        }
    
    }
    
    /**
     * @param $unfiltered_content
     *
     * @return string
     */
    public function restrict_content( $unfiltered_content )
    {
        Woocommerce_Pay_Per_Post_Helper::logger( 'the_content() called, reached restriction_content function' );
        if ( !Woocommerce_Pay_Per_Post_Helper::is_protected() ) {
            return $unfiltered_content;
        }
        //check and see if inline shortcode exists
        
        if ( has_shortcode( $unfiltered_content, 'wc-pay-for-post-inline' ) ) {
            // Handle shortcode access
            return $unfiltered_content;
        } else {
            $restrict = new Woocommerce_Pay_Per_Post_Restrict_Content();
            $show_paywall = apply_filters( 'wc_pay_per_post_force_bypass_paywall', $restrict->can_user_view_content() );
            if ( $show_paywall == false ) {
                return $restrict->show_content( $unfiltered_content );
            }
            return $restrict->show_paywall( $unfiltered_content );
        }
    
    }
    
    public function set_product_ids()
    {
        global  $product_ids ;
        $product_ids = (array) get_post_meta( get_the_ID(), WC_PPP_SLUG . '_product_ids', true );
    }
    
    protected function show_comments( $has_purchased = false )
    {
        $turn_off_comments_when_protected = get_option( WC_PPP_SLUG . '_turn_off_comments_when_protected', true );
        $allow_admins_access_to_protected_posts = get_option( WC_PPP_SLUG . '_allow_admins_access_to_protected_posts', false );
        if ( $turn_off_comments_when_protected ) {
            add_filter( 'comments_open', array( $this, 'comments_closed' ) );
        }
    }
    
    /**
     * @return bool
     */
    protected function is_admin()
    {
        $current_user = wp_get_current_user();
        if ( user_can( $current_user, 'administrator' ) ) {
            return true;
        }
        return false;
    }

}
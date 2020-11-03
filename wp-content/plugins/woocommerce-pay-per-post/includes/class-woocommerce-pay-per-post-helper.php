<?php

use  Carbon\Carbon ;
use  PRAMADILLO\Woocommerce_Pay_Per_Post_Restrict_Content ;
/**
 * Class Woocommerce_Pay_Per_Post_General
 */
class Woocommerce_Pay_Per_Post_Helper extends Woocommerce_Pay_Per_Post
{
    /**
     * @var array
     */
    public static  $protection_types = array(
        'standard',
        'delay',
        'page-view',
        'expire'
    ) ;
    /**
     * @param $post_id
     *
     * @return bool|string
     */
    public static function is_protected( $post_id = null )
    {
        if ( is_null( $post_id ) ) {
            $post_id = get_the_ID();
        }
        $selected = (array) get_post_meta( $post_id, WC_PPP_SLUG . '_product_ids', true );
        $delay_restriction_enable = (bool) get_post_meta( $post_id, WC_PPP_SLUG . '_delay_restriction_enable', true );
        $page_view_restriction_enable = (bool) get_post_meta( $post_id, WC_PPP_SLUG . '_page_view_restriction_enable', true );
        $expire_restriction_enable = (bool) get_post_meta( $post_id, WC_PPP_SLUG . '_expire_restriction_enable', true );
        
        if ( '' != $selected[0] ) {
            $protection = 'standard';
            if ( $delay_restriction_enable ) {
                $protection = 'delay';
            }
            if ( $page_view_restriction_enable ) {
                $protection = 'page-view';
            }
            if ( $expire_restriction_enable ) {
                $protection = 'expire';
            }
            return $protection;
        } else {
            return false;
        }
    
    }
    
    /**
     * @param null $post_id
     *
     * @return bool
     * The can_user_view_content function returns on whether or not the user should see the paywall.
     * For this that is why we are returning the inverse of the result.
     */
    public static function has_access( $post_id = null )
    {
        $restrict = new Woocommerce_Pay_Per_Post_Restrict_Content( $post_id );
        return !$restrict->can_user_view_content();
    }
    
    /**
     * Checks if the user has purchased a product associated with the post
     *
     * @param null $post_id
     *
     * @return bool
     */
    public static function has_purchased( $post_id = null )
    {
        $restrict = new Woocommerce_Pay_Per_Post_Restrict_Content( $post_id );
        return $restrict->check_if_purchased();
    }
    
    /**
     * @return string
     */
    public static function get_no_access_content()
    {
        $restrict = new Woocommerce_Pay_Per_Post_Restrict_Content();
        return $restrict->show_paywall( get_the_content() );
    }
    
    /**
     * @param $type
     *
     * @return bool|string
     */
    public static function protection_display_icon( $type )
    {
        if ( in_array( $type, self::$protection_types, true ) ) {
            switch ( $type ) {
                case 'standard':
                    return '<span class="dashicons dashicons-post-status" title="Standard Purchase Protection" style="color:green"></span>';
                    break;
                case 'delay':
                    return '<span class="dashicons dashicons-clock" title="Delay Protection" style="color:green"></span>';
                    break;
                case 'page-view':
                    return '<span class="dashicons dashicons-visibility" title="Page View Protection" style="color:green"></span>';
                    break;
                case 'expire':
                    return '<span class="dashicons dashicons-backup" title="Expiry Protection" style="color:green"></span>';
                    break;
            }
        }
        return false;
    }
    
    /**
     * @return Carbon
     */
    public static function current_time()
    {
        return Carbon::createFromTimestamp( current_time( 'timestamp' ) );
    }
    
    public static function logger( $message, $context = array() )
    {
        $logger = new Woocommerce_Pay_Per_Post_Logger();
        $logger->log( $message, $context );
    }
    
    public static function logger_uri()
    {
        $logger = new Woocommerce_Pay_Per_Post_Logger();
        return $logger->get_log_uri();
    }
    
    public static function logger_url()
    {
        $logger = new Woocommerce_Pay_Per_Post_Logger();
        return $logger->get_log_url();
    }
    
    public static function get_protected_posts()
    {
        $custom_post_types = get_option( WC_PPP_SLUG . '_custom_post_types', array() );
        $custom_post_types = ( empty($custom_post_types) ? array() : $custom_post_types );
        if ( !is_array( $custom_post_types ) ) {
            $custom_post_types = explode( ',', $custom_post_types );
        }
        $args = array(
            'orderby'      => 'post_date',
            'order'        => 'DESC',
            'nopaging'     => true,
            'meta_key'     => WC_PPP_SLUG . '_product_ids',
            'meta_value'   => '',
            'meta_compare' => '!=',
            'post_status'  => 'publish',
            'post_type'    => $custom_post_types,
        );
        return get_posts( $args );
    }
    
    public static function get_posts_associated_with_product_id( $product_id )
    {
        $custom_post_types = get_option( WC_PPP_SLUG . '_custom_post_types', array() );
        $custom_post_types = ( empty($custom_post_types) ? array() : $custom_post_types );
        if ( !is_array( $custom_post_types ) ) {
            $custom_post_types = explode( ',', $custom_post_types );
        }
        $args = array(
            'orderby'      => 'post_date',
            'order'        => 'DESC',
            'nopaging'     => true,
            'meta_key'     => WC_PPP_SLUG . '_product_ids',
            'meta_value'   => sprintf( '^%1$s$|s:%2$u:"%1$s";', $product_id, strlen( $product_id ) ),
            'meta_compare' => 'REGEXP',
            'post_status'  => 'publish',
            'post_type'    => $custom_post_types,
        );
        $posts = get_posts( apply_filters( 'wc_pay_per_post_woocommerce_email_args', $args ) );
        $protected_content = array();
        
        if ( $posts ) {
            $interface = 'default';
            switch ( $interface ) {
                case "default":
                default:
                    $protected_content = self::get_posts_associated_with_product_id_interface( $posts );
                    break;
                case "polylang":
                    $protected_content = self::get_posts_associated_with_product_id_interface_polylang__premium_only( $posts );
                    break;
            }
        }
        
        return $protected_content;
    }
    
    public static function can_use_woocommerce_memberships()
    {
        return false;
    }
    
    public static function can_use_woocommerce_subscriptions()
    {
        return false;
    }
    
    public static function can_use_paid_membership_pro()
    {
        return false;
    }
    
    public static function md_array_diff( $arraya, $arrayb )
    {
        foreach ( $arraya as $keya => $valuea ) {
            if ( in_array( $valuea, $arrayb ) ) {
                unset( $arraya[$keya] );
            }
        }
        return $arraya;
    }
    
    public static function move_to_top( &$array, $key )
    {
        $temp = array(
            $key => $array[$key],
        );
        unset( $array[$key] );
        $array = $temp + $array;
    }
    
    public static function get_the_excerpt( $post_id )
    {
        return get_the_excerpt( $post_id );
    }
    
    protected static function get_posts_associated_with_product_id_interface( $posts )
    {
        $protected_content = array();
        foreach ( $posts as $post ) {
            $protected_content[] = array(
                'post_id'    => $post->ID,
                'post_title' => $post->post_title,
                'post_url'   => get_permalink( $post->ID ),
            );
        }
        return $protected_content;
    }
    
    public static function locate_template( $template_name, $template_path = '', $default_path = '' )
    {
        if ( !$template_path ) {
            $template_path = WC_PPP_TEMPLATE_PATH;
        }
        if ( !$default_path ) {
            $default_path = WC_PPP_PATH;
        }
        // Look within passed path within the theme - this is priority.
        $template = locate_template( array( trailingslashit( $template_path ) . $template_name, $template_name ) );
        // Get default template/.
        if ( !$template ) {
            $template = $default_path . $template_name;
        }
        // Return what we found.
        return apply_filters(
            'wc_pay_for_post_locate_template',
            $template,
            $template_name,
            $template_path
        );
    }

}
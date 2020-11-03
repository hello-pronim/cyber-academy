<?php

class Woocommerce_Pay_Per_Post_Debug
{
    /**
     * Returns a table which contains all of the checks, their statuses and actionable items
     * @return string
     */
    public static function output_debug_stats()
    {
        foreach ( self::checks() as $check ) {
            $check_results[$check] = self::$check();
        }
        $output = '<table class="table">';
        foreach ( $check_results as $function => $value ) {
            $output_function = $function . '_output';
            $output .= self::$output_function( $value );
        }
        $output .= '</table>';
        return $output;
    }
    
    /**
     * We loop through this array in the output_debug_stats function and run the function with the same array key name
     * @return array
     */
    private static function checks()
    {
        $checks = [ 'ppp_version', 'ppp_post_count', 'wc_product_count' ];
        return $checks;
    }
    
    //Check Functions that correlate to the keys in the checks function
    protected static function page_view_table()
    {
        return self::does_page_view_table_exist();
    }
    
    protected static function ppp_version()
    {
        return WC_PPP_VERSION;
    }
    
    protected static function ppp_post_count()
    {
        return self::get_number_of_ppp_posts();
    }
    
    protected static function wc_product_count()
    {
        return self::get_number_of_wc_products();
    }
    
    //Output Function that correlate to the keys in the checks function
    protected static function ppp_post_count_output( $data )
    {
        $output = '<tr>';
        $output .= '<td>Number of PPP Posts</td>';
        
        if ( isset( $data[0] ) ) {
            $output .= '<td class="success">' . $data[1] . '</td>';
        } else {
            $output .= '<td class="error">ZERO</td>';
        }
        
        $output .= '</tr>';
        return $output;
    }
    
    protected static function ppp_version_output( $data )
    {
        $output = '<tr>';
        $output .= '<td>Version</td>';
        $output .= '<td>' . $data . '</td>';
        $output .= '</tr>';
        return $output;
    }
    
    protected static function wc_product_count_output( $data )
    {
        $output = '<tr>';
        $output .= '<td>Number of Products</td>';
        
        if ( !isset( $data[0] ) ) {
            $output .= '<td class="success">' . $data[1] . '</td>';
        } else {
            $output .= '<td class="error">' . $data[1] . '</td>';
        }
        
        $output .= '</tr>';
        return $output;
    }
    
    protected static function page_view_table_output( $status )
    {
        $output = '';
        $output .= '<tr>';
        $output .= '<td>Page View Database Present?</td>';
        
        if ( $status ) {
            $output .= '<td class="success">YES</td>';
        } else {
            $output .= '<td class="error">NO!</td>';
            $output .= '</tr>';
            $output .= '<tr>';
            $output .= '<td colspan="2">
							<form id="wc-ppp-create-table" action="" method="post">
							' . wp_nonce_field( "wc_ppp_create_table", "wc_ppp_create_table_nonce" ) . '
			                <input type="submit" name="wc-ppp-upgrade-btn" class="wc-ppp-create-table-btn button action" value="Create Table">
            				</form>
						<br></td>';
        }
        
        $output .= '</tr>';
        return $output;
    }
    
    //Actual logic functions
    private static function get_number_of_ppp_posts()
    {
        $posts = count( Woocommerce_Pay_Per_Post_Helper::get_protected_posts() );
        if ( $posts > 0 ) {
            return [
                true => $posts,
            ];
        }
        return [
            false => 0,
        ];
    }
    
    private static function get_number_of_wc_products()
    {
        $args = array(
            'nopaging'    => true,
            'post_status' => 'publish',
            'post_type'   => 'product',
        );
        $posts = count( get_posts( $args ) );
        if ( $posts > 0 ) {
            return [
                true => $posts,
            ];
        }
        return [
            false => 0,
        ];
    }
    
    private static function does_page_view_table_exist()
    {
        global  $wpdb ;
        $exists = (array) $wpdb->get_results( "SHOW TABLES LIKE '{$wpdb->prefix}woocommerce_pay_per_post_pageviews'", ARRAY_A );
        if ( count( $exists ) > 0 ) {
            return true;
        }
        return false;
    }

}
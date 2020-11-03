<?php

namespace PRAMADILLO\INTEGRATIONS;

use WC_Subscription;
use WC_Subscriptions_Product;
use Woocommerce_Pay_Per_Post_Helper;

class WooCommerceSubscriptions {

	public function generate_subscriptions_dropdown( $subscription_products, $selected = [] ) {
		$drop_down = '<optgroup label="Subscription Products">';
		foreach ( $subscription_products as $product ) {
			$drop_down .= '<option value="' . $product['ID'] . '"';

			if ( in_array( (string) $product['ID'], (array) $selected, true ) ) {
				$drop_down .= ' selected="selected"';
			}

			$drop_down .= '>' . $product['post_title'] . ' - [#' . $product['ID'] . ']</option>';
		}
		$drop_down .= '</optgroup>';

		return $drop_down;

	}

	/**
	 * @param $product_id
	 *
	 * @return bool
	 */
	public function is_subscription_product( $product_id ) {
		if ( WC_Subscriptions_Product::is_subscription( $product_id ) ) {
			return true;
		}

		return false;
	}


	public function post_contains_subscription_products($post_id){
		$product_ids = (array) get_post_meta( $post_id, WC_PPP_SLUG . '_product_ids', true );

		foreach($product_ids as $product_id){
			if($this->is_subscription_product($product_id)){
				return true;
			}
		}

		return false;

	}

	public function filter_subscription_products( $products ) {
		$return = array();
		foreach ( $products as $product ) {
			if ( ! WC_Subscriptions_Product::is_subscription( $product['ID'] ) ) {
				$return[] = $product;
			}
		}

		return $return;
	}

	/**
	 * @param null $post_id
	 *
	 * @return bool
	 */
	public function is_subscriber( $post_id = null ) {
		if ( is_null( $post_id ) ) {
			$post_id = get_the_ID();
		}

		$product_ids = array();
		$product_ids = get_post_meta( $post_id, WC_PPP_SLUG . '_product_ids', true );

		$current_user = wp_get_current_user();
		foreach ( (array) $product_ids as $id ) {

			$subscriptions = wcs_get_users_subscriptions( $current_user->ID );
			Woocommerce_Pay_Per_Post_Helper::logger( 'Looking to see if user has any active subscriptions' );

			if ( count( $subscriptions ) > 0 ) {
				foreach ( $subscriptions as $subscription ) {

					if ( 'active' === $subscription->get_status() ) {

						foreach ( $subscription->get_items() as $item ) {
							Woocommerce_Pay_Per_Post_Helper::logger( 'Looking to see if user is an active subscriber of  - ' . trim( $id ) );

							if ( $item->get_product_id() == $id ) {
								Woocommerce_Pay_Per_Post_Helper::logger( 'IS AN ACTIVE SUBSCRIBER OF  - ' . trim( $id ) );

								return true;
							}

						}

					}

				}
			}
			Woocommerce_Pay_Per_Post_Helper::logger( 'Has no active subscriptions' );

		}

		return false;
	}


}
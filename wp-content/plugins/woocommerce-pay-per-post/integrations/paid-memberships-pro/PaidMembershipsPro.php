<?php

namespace PRAMADILLO\INTEGRATIONS;

use Woocommerce_Pay_Per_Post_Helper;

class PaidMembershipsPro {

	public function get_membership_levels() {
		return pmpro_getAllLevels();

	}

	public function generate_membership_levels_dropdown( $selected = array() ) {
		$selected          = empty( $selected ) ? array() : $selected;
		$drop_down         = '';
		$membership_levels = $this->get_membership_levels();
		$drop_down         .= '<optgroup label="PaidMembershipPro Membership Levels">';

		foreach ( $membership_levels as $level ) {

			$drop_down .= '<option value="' . $level->id . '"';

			if ( in_array( (string) $level->id, $selected, true ) ) {
				$drop_down .= ' selected="selected"';
			}

			$drop_down .= '>' . $level->name . ' - [#' . $level->id . ']</option>';
		}
		$drop_down .= '</optgroup>';

		return $drop_down;

	}

	/**
	 * @param null $post_id
	 *
	 * @return bool
	 */
	public function is_member( $post_id = null ) {
		if ( is_null( $post_id ) ) {
			$post_id = get_the_ID();
		}
		$product_ids  = (array) get_post_meta( $post_id, WC_PPP_SLUG . '_product_ids', true );
		$current_user = wp_get_current_user();

		foreach ( $product_ids as $id ) {
			Woocommerce_Pay_Per_Post_Helper::logger( 'Looking to see if user is an active member of Paid Membership Pro member level - ' . trim( $id ) );

			$membership = pmpro_hasMembershipLevel( $id, $current_user->ID );

			if ( $membership ) {
				Woocommerce_Pay_Per_Post_Helper::logger( 'IS A PAID MEMBERSHIPS PRO MEMBER OF - ' . trim( $id ) );

				return true;
			}

		}
		Woocommerce_Pay_Per_Post_Helper::logger( 'IS NOT A MEMBER OF - ' . trim( $id ) );

		return false;
	}


	public function post_contains_membership_products( $post_id ) {
		$product_ids = (array) get_post_meta( $post_id, WC_PPP_SLUG . '_product_ids', true );

		foreach ( $product_ids as $product_id ) {

				foreach($this->get_membership_levels() as $membership_level){


					if($product_id == $membership_level->id){
						return true;
					}
				}
		}

		return false;

	}

}
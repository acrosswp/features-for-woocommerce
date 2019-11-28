<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


// check if class does not exits
if ( ! class_exists( 'FFW_Remove_Apply_Coupon_Box_From_Cart_Page' ) ) {

	/**
	 * Class FFW_Remove_Apply_Coupon_Box_From_Cart_Page
	 * Feature to Hide the Coupon Code
	 *
	 * @since 1.0.0
	 */
	class FFW_Remove_Apply_Coupon_Box_From_Cart_Page {

		// Constructor
		public function __construct() {
			add_filter( 'woocommerce_coupons_enabled', array( $this, 'disable_coupon_field_on_cart' ) );
		}

		public function disable_coupon_field_on_cart( $enabled ) {
			if ( is_cart() ) {
				$enabled = false;
			}

			return $enabled;
		}
	}

	$GLOBALS['ffw_remove_apply_coupon_box_from_cart_page'] = new FFW_Remove_Apply_Coupon_Box_From_Cart_Page();
}
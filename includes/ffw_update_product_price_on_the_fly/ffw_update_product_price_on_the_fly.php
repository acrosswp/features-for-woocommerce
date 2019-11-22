<?php
// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'FFW_Update_Product_Price_On_The_Fly' ) ) {
	/**
	 * Class FFW_Update_Product_Price_On_The_Fly
	 * Remove product on WooCommerce checkout page or via using WooCommerce Shortcode
	 *
	 */
	class FFW_Update_Product_Price_On_The_Fly {

		public function __construct() {

			add_action( 'woocommerce_before_single_product', array( $this, 'woocommerce_before_single_product' ) );
		}

		public function woocommerce_before_single_product() {
			wp_enqueue_script( 'ffw_frontend' );
		}
	}

	$GLOBALS['ffw_update_product_price_on_the_fly'] = new FFW_Update_Product_Price_On_The_Fly();
}
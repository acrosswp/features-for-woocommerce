<?php
// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'FFW_Remove_Product_On_Checkout' ) ) {
	/**
	 * Class FFW_Remove_Product_On_Checkout
	 * Remove product on WooCommerce checkout page or via using WooCommerce Shortcode
	 *
	 */
	class FFW_Remove_Product_On_Checkout {

		public function __construct() {
			add_action( 'woocommerce_checkout_init', array( $this, 'woocommerce_checkout_init' ), 10 );
			add_filter( 'ffw_change_quantity_on_checkout_dropbox', '__return_true', 10 );
		}

		public function woocommerce_checkout_init() {
			wp_enqueue_script( 'ffw_frontend' );
			add_filter( 'woocommerce_checkout_cart_item_quantity', array( $this, 'remove_product_button' ), 10, 3 );
		}

		/**
		 * Add change quantity dropdown in checkout page
		 *
		 * @param $html
		 * @param $cart_item
		 * @param $cart_item_key
		 *
		 * @return mixed
		 */
		public function remove_product_button( $html, $cart_item, $cart_item_key ) {

			$html = sprintf(
				'<a href="%s" class="remove ffw_remove_product_on_checkout" title="%s">&times;</a>',
				esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
				__( 'Remove this item', 'woocommerce' )
			);

			return $html;
		}
	}

	$GLOBALS['ffw_remove_product_on_checkout'] = new FFW_Remove_Product_On_Checkout();
}
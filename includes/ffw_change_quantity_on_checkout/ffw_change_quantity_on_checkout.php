<?php
// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'FFW_Change_Quantity_On_Checkout' ) ) {
	class FFW_Change_Quantity_On_Checkout {
		public function __construct() {
			add_filter( 'woocommerce_checkout_cart_item_quantity', array( $this, 'quantity_change_dropdown' ), 10, 20 );

			add_action( 'wp_ajax_nopriv_ffw_change_quantity_on_checkout', array( $this, 'update_checkout_order' ) );
			add_action( 'wp_ajax_ffw_change_quantity_on_checkout', array( $this, 'update_checkout_order' ) );
		}

		public function update_checkout_order() {
			$response = array(
				'result'  => 'failure',
				'message' => __( 'Something when wrong kindly try after sometime', 'ffw' ),
			);

			$nonce_value = wc_get_var( $_REQUEST['woocommerce-process-checkout-nonce'], wc_get_var( $_REQUEST['_wpnonce'], '' ) ); // @codingStandardsIgnoreLine.
			if ( empty( $nonce_value ) || ! wp_verify_nonce( $nonce_value, 'woocommerce-process_checkout' ) ) {
				$response['result'] = 'success';
				$values             = array();
				parse_str( $_REQUEST['form_value'], $values );
				$cart = $values['cart'];

				foreach ( $cart as $cart_key => $cart_value ) {
					foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
						if ( $cart_key == $cart_item_key ) {
							$product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
							if ( ! $product->is_sold_individually() ) {
								if ( $product->get_max_purchase_quantity() >= $cart_value['qty'] ) {
									WC()->cart->set_quantity( $cart_key, $cart_value['qty'], false );
									WC()->cart->calculate_totals();
								} else {
									$response['message'] = '';
								}
							} else {
								$response['message'] = '';
							}
						}
					}
				}
				$response['message'] = '';
			}
			wp_send_json( $response );
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
		public function quantity_change_dropdown( $html, $cart_item, $cart_item_key ) {
			/**
			 * Only run on checkout page
			 */
			if ( is_checkout() ) {

				wp_enqueue_script( 'ffw_frontend' );

				$product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				if ( ! $product->is_sold_individually() ) {
					$html = woocommerce_quantity_input(
						array(
							'input_name'   => "cart[{$cart_item_key}][qty]",
							'input_value'  => $cart_item['quantity'],
							'max_value'    => $product->get_max_purchase_quantity(),
							'min_value'    => '0',
							'product_name' => $product->get_name(),
						),
						$product,
						false
					);
				}
			}

			return $html;
		}
	}

	$GLOBALS['ffw_change_quantity_on_checkout'] = new FFW_Change_Quantity_On_Checkout();
}
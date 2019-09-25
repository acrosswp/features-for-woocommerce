<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// check if class does not exits
if ( ! class_exists( 'FFW_Hide_Coupon' ) ) {

	/**
	 * Class FFW_Hide_Coupon
	 *
	 * Feature to Hide the Coupon Code
	 */
	class FFW_Hide_Coupon {

		// Constructor
		public function __construct() {
			add_action( 'woocommerce_helper_loaded', array( $this, 'woocommerce_helper_loaded' ) );
		}

		/**
		 * Load all the files, hooks and Actions
		 *
		 * @since 1.0.0
		 */
		public function woocommerce_helper_loaded() {
			add_action( 'woocommerce_update_coupon', array( $this, 'woocommerce_update_coupon' ), 10 );
			add_action( 'woocommerce_coupon_options', array( $this, 'woocommerce_coupon_options' ), 10, 2 );
			add_filter( 'woocommerce_cart_totals_coupon_label', array(
				$this,
				'woocommerce_cart_totals_coupon_label'
			), 10, 2 );
		}

		/**
		 * Save Coupon code value into the Post meta
		 *
		 * @since 1.0.0
		 *
		 * @param $post_id
		 */
		public function woocommerce_update_coupon( $post_id ) {

			$defer_apply = isset( $_POST['_ffw_hide_coupon'] ) ? sanitize_text_field( $_POST['_ffw_hide_coupon'] ) : '';
			update_post_meta( $post_id, '_ffw_hide_coupon', $defer_apply );

		}

		/**
		 * Display checkbox to show or hide the Coupon code
		 *
		 * @since 1.0.0
		 *
		 * @param null $coupon_id
		 * @param null $coupon
		 */
		function woocommerce_coupon_options( $coupon_id = null, $coupon = null ) {

			$value = get_post_meta( $coupon_id, '_ffw_hide_coupon', true );

			// defer apply option
			woocommerce_wp_checkbox( array(
				'id'          => '_ffw_hide_coupon',
				'label'       => __( 'Hide Coupon', 'ffw' ),
				'description' => __( "Check this box to Hide the Coupon code.", 'ffw' ),
				'value'       => $value,
			) );

		}

		/**
		 * Change the Coupon Code Name
		 *
		 * @since 1.0.0
		 *
		 * @param $text
		 * @param $coupon
		 *
		 * @return string $text
		 */
		function woocommerce_cart_totals_coupon_label( $text, $coupon ) {
			$value = get_post_meta( $coupon->get_id(), '_ffw_hide_coupon', true );
			if ( ! empty( $value ) ) {
				$text = __( 'Discount Applied', 'ffw' );
			}

			return $text;
		}
	}

	$GLOBALS['ffm_hide_coupon'] = new FFW_Hide_Coupon();
}
<?php
/**
 * Plugin Name: Hide Coupon Name for WooCommerce
 * Plugin URI:  https://raftaar1191.com/
 * Description: This plugin provided a setting to hide the each coupon code into the frontend.
 * Author:      raftaar1191
 * Author URI:  https://profiles.wordpress.org/raftaar1191/
 * Version:     1.0.0
 * Text Domain: hcnfw
 * Domain Path: /i18n/languages/
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ========================================================================
 * CONSTANTS
 * ========================================================================
 */

// Codebase version
if ( ! defined( 'HCNFW_PLUGIN_VERSION' ) ) {
	define( 'HCNFW_PLUGIN_VERSION', '1.0.0' );
}

// Directory
if ( ! defined( 'HCNFW_PLUGIN_DIR' ) ) {
	define( 'HCNFW_PLUGIN_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
}

// Plugin Basename
if ( ! defined( 'HCNFW_PLUGIN_BASENAME' ) ) {
	define( 'HCNFW_PLUGIN_BASENAME', plugin_basename( HCNFW_PLUGIN_DIR ) );
}


/**
 * Load all the files, hooks and Actions
 *
 * @since 1.0.0
 */
function hcnfw_woocommerce_helper_loaded_callback() {

	load_plugin_textdomain('hcnfw', false, HCNFW_PLUGIN_BASENAME . '/i18n/languages');

	add_action( 'woocommerce_process_shop_coupon_meta', 'hcnfw_woocommerce_process_shop_coupon_meta_callback', 10, 2 );
	add_action( 'woocommerce_coupon_options', 'hcnfw_woocommerce_coupon_options_callback', 10, 2 );
	add_filter( 'woocommerce_cart_totals_coupon_label', 'hcnfw_woocommerce_cart_totals_coupon_label_callback', 10, 2 );
}

add_action( 'woocommerce_helper_loaded', 'hcnfw_woocommerce_helper_loaded_callback' );

/**
 * Save Coupon code value into the Post meta
 *
 * @since 1.0.0
 *
 * @param $post_id
 * @param $post
 */
function hcnfw_woocommerce_process_shop_coupon_meta_callback( $post_id, $post ) {

	$defer_apply = isset( $_POST['_hcnfw_hide_coupon'] ) ? $_POST['_hcnfw_hide_coupon'] : '';
	update_post_meta( $post_id, '_hcnfw_hide_coupon', $defer_apply );

}

/**
 * Display checkbox to show or hide the Coupon code
 *
 * @since 1.0.0
 *
 * @param null $coupon_id
 * @param null $coupon
 */
function hcnfw_woocommerce_coupon_options_callback( $coupon_id = null, $coupon = null ) {

	$value = get_post_meta( $coupon_id, '_hcnfw_hide_coupon', true );

	// defer apply option
	woocommerce_wp_checkbox( array(
		'id'          => '_hcnfw_hide_coupon',
		'label'       => __( 'Hide Coupon', 'hcnfw' ),
		'description' => __( "Check this box to Hide the Coupon code.", 'hcnfw' ),
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
function hcnfw_woocommerce_cart_totals_coupon_label_callback( $text, $coupon ) {
	$value = get_post_meta( $coupon->get_id(), '_hcnfw_hide_coupon', true );
	if ( ! empty( $value ) ) {
		$text = __( 'Discount Applied', 'hcnfw' );
	}

	return $text;
}
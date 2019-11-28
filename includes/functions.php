<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get setting fields
 *
 * @since 1.0.0
 *
 * @return array
 */
function ffm_settings_fields() {
	return array(
		array(
			'title'    => __( 'Enable Hide Coupon Code', 'ffw' ),
			'desc'     => __( 'Give Admin user option to hide the coupon code', 'ffw' ),
			'id'       => 'ffw_hide_coupon_code',
			'default'  => 'yes',
			'type'     => 'checkbox',
			'desc_tip' => __( 'Give Admin user option to hide the coupon code', 'ffw' ),
		),
		array(
			'title'    => __( 'Change Quantity on Checkout Page', 'ffw' ),
			'desc'     => __( 'Give user option to update quantity on checkout page', 'ffw' ),
			'id'       => 'ffw_change_quantity_on_checkout',
			'default'  => 'yes',
			'type'     => 'checkbox',
			'desc_tip' => __( 'Give users option to update quantity on checkout page', 'ffw' ),
		),
		array(
			'title'    => __( 'Remove Product on Checkout Page', 'ffw' ),
			'desc'     => __( 'Give user option to button to remove product on checkout page', 'ffw' ),
			'id'       => 'ffw_remove_product_on_checkout',
			'default'  => 'yes',
			'type'     => 'checkbox',
			'desc_tip' => __( 'Give users option to remove product on checkout page', 'ffw' ),
		),
		array(
			'title'    => __( 'Update Product price on the fly', 'ffw' ),
			'desc'     => __( 'Update Product price when user change the product quantity', 'ffw' ),
			'id'       => 'ffw_update_product_price_on_the_fly',
			'default'  => 'yes',
			'type'     => 'checkbox',
			'desc_tip' => __( 'Show users exact price when user update product quantity', 'ffw' ),
		),
		array(
			'title'    => __( 'Exclude Product from all the Coupon', 'ffw' ),
			'desc'     => __( 'Create a new tab that give admin user access to add the product that are excluded from all the coupon code', 'ffw' ),
			'id'       => 'ffw_exclude_product_from_coupon_code',
			'default'  => 'yes',
			'type'     => 'checkbox',
			'desc_tip' => __( 'Give Admin user interface to Exclude Product', 'ffw' ),
		),
		array(
			'title'    => __( 'Remove Coupon Option from Cart page', 'ffw' ),
			'desc'     => __( 'Remove apply coupon code boc from cart page', 'ffw' ),
			'id'       => 'ffw_remove_apply_coupon_box_from_cart_page',
			'default'  => 'no',
			'type'     => 'checkbox',
			'desc_tip' => __( 'Hide Apply Coupon from Cart page', 'ffw' ),
		),
		array(
			'title'    => __( 'Remove Coupon Option from Checkout page', 'ffw' ),
			'desc'     => __( 'Remove apply coupon code boc from Checkout page', 'ffw' ),
			'id'       => 'ffw_remove_apply_coupon_box_from_checkout_page',
			'default'  => 'no',
			'type'     => 'checkbox',
			'desc_tip' => __( 'Hide Apply Coupon from Checkout page', 'ffw' ),
		),
		array(
			'title'             => __( 'Enable BuddyPress Account Creation', 'ffw' ),
			'desc'              => __( 'Give Admin user option to enable login like BuddyPress does or you can say Checkout With BuddyPress', 'ffw' ),
			'id'                => 'ffw_checkout_with_buddypress',
			'default'           => 'no',
			'type'              => 'checkbox',
			'desc_tip'          => __( 'Give Admin user option to enable login like BuddyPress does', 'ffw' ),
			'custom_attributes' => array(
				class_exists( 'buddypress' ) ? '' : 'disabled' => '',
			),
		),
	);
}

/**
 * Get setting field ids
 *
 * @since 1.0.0
 *
 * @return array
 */
function ffm_settings_field_ids() {
	return wp_list_pluck( ffm_settings_fields(), 'id' );
}

/**
 * Get setting field ids
 *
 * @since 1.0.0
 *
 * @return array
 */
function ffm_settings_field_ids_value() {
	return wp_list_pluck( ffm_settings_fields(), 'default', 'id' );
}
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
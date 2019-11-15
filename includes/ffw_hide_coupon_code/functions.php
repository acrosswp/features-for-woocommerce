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
			'default'  => $GLOBALS['ffw']->default_options['ffw_hide_coupon_code'],
			'type'     => 'checkbox',
			'desc_tip' => __( 'Give Admin user option to hide the coupon code', 'ffw' ),
		),
		array(
			'title'             => __( 'Enable BuddyPress Account Creation', 'ffw' ),
			'desc'              => __( 'Give Admin user option to enable login like BuddyPress does or you can say Checkout With BuddyPress', 'ffw' ),
			'id'                => 'ffw_checkout_with_buddypress',
			'default'           => $GLOBALS['ffw']->default_options['ffw_checkout_with_buddypress'],
			'type'              => 'checkbox',
			'desc_tip'          => __( 'Give Admin user option to enable login like BuddyPress does', 'ffw' ),
			'custom_attributes' => array(
				empty( $GLOBALS['ffw']->buddypress ) ? 'disabled' : '' => '',
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
	return ffm_settings_fields();
}
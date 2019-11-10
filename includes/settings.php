<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'FFW_Settings', false ) ) {
	return new FFW_Settings();
}


/**
 * WC_Settings_Shipping.
 */
class FFW_Settings extends WC_Settings_Page {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->id    = 'ffw_settings';
		$this->label = __( 'Features for WooCommerce', 'ffw' );

		parent::__construct();
	}

	/**
	 * Get settings array.
	 *
	 * @return array
	 */
	public function get_settings() {

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
	 * Output the settings.
	 */
	public function output() {
		$settings = $this->get_settings();

		WC_Admin_Settings::output_fields( $settings );
	}

	/**
	 * Save settings.
	 */
	public function save() {
		$settings = $this->get_settings();

		WC_Admin_Settings::save_fields( $settings );
	}

}

return new FFW_Settings();

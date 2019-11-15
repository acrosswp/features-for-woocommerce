<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'FFW_Settings', false ) ) {
	return new FFW_Settings();
}

/**
 * FFW_Settings.
 *
 * @since 1.0.0
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

		return ffm_settings_fields();
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

$GLOBALS['ffm_setting'] = new FFW_Settings();

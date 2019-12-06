<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class FFW_Loader
 *
 * @since 1.0.0
 */
class FFW_Loader {

	var $fields       = array();
	var $fields_value = array();
	var $localize_value = array();

	public function __construct() {
		$this->fields       = ffm_settings_field_ids();
		$this->fields_value = ffm_settings_field_ids_value();

		$this->get_fields();
	}

	/**
	 * Include classes
	 */
	public function get_fields() {


		foreach ( $this->fields as $field ) {
			$default = isset( $this->fields_value[ $field ] ) ? $this->fields_value[ $field ] : '';
			$value   = get_option( $field, $default );
			$this->localize_value[ $field ] = $value;
			if ( 'yes' === $value ) {
				$path = sprintf( '%s%s/%s/%s.php', FFW_PLUGIN_DIR, 'includes', $field, $field );
				if ( file_exists( $path ) ) {
					include $path;
				}
			}
		}

		add_filter( 'ffw_frontend_localize_script', array( $this, 'localize_script' ) );
	}

	/**
	 * Add fields value to localize
	 */
	public function localize_script( $localize_value ) {
		return array_merge( $localize_value, $this->localize_value );
	}
}

$GLOBALS['ffm_loader'] = new FFW_Loader();

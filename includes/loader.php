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

	var $fields = array();
	var $fields_value = array();

	public function __construct() {
		$this->fields       = ffm_settings_field_ids();
		$this->fields_value = ffm_settings_field_ids_value();

		$this->get_fields();
	}

	public function get_fields() {

		foreach ( $this->fields as $field ) {
			$default = isset( $this->fields_value[ $field ] ) ? $this->fields_value[ $field ] : '';
			if ( 'yes' === get_option( $field, $default ) ) {
				$path = sprintf( '%s%s/%s/%s.php', FFW_PLUGIN_DIR, 'includes', $field, $field );
				if ( file_exists( $path ) ) {
					include $path;
				}
			}
		}
	}
}

$GLOBALS['ffm_loader'] = new FFW_Loader();
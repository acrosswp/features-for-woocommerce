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

	public function __construct() {
			$this->fields = ffm_settings_fields();
	}

	public function get_fields() {
		var_dump( $this->fields );
	}
}

$GLOBALS['ffm_loader'] = new FFW_Loader();
<?php
/**
 * Plugin Name: Features for WooCommerce
 * Plugin URI:  https://raftaar1191.com/
 * Description: This plugin provided a extra features for WooCommerce
 * Author:      raftaar1191
 * Author URI:  https://profiles.wordpress.org/raftaar1191/
 * Version:     1.0.0
 * Text Domain: ffw
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
if ( ! defined( 'FFW_PLUGIN_VERSION' ) ) {
	define( 'FFW_PLUGIN_VERSION', '1.0.0' );
}

// Directory
if ( ! defined( 'FFW_PLUGIN_DIR' ) ) {
	define( 'FFW_PLUGIN_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
}

// Plugin Basename
if ( ! defined( 'FFW_PLUGIN_BASENAME' ) ) {
	define( 'FFW_PLUGIN_BASENAME', plugin_basename( FFW_PLUGIN_DIR ) );
}

// check if class exists
if ( ! class_exists( 'Feature_For_WooCommeerce' ) ) {
	/**
	 * Class Feature_For_WooCommeerce
	 *
	 * Load the Feature_For_WooCommeerce class
	 */
	class Feature_For_WooCommeerce {
		public function __construct() {
			$this->language();
			$this->hooks();
			$this->loader();
		}

		public function hooks() {

		}

		public function language() {
			load_plugin_textdomain( 'ffw', false, FFW_PLUGIN_BASENAME . '/i18n/languages' );
		}

		public function loader() {
			require_once FFW_PLUGIN_DIR . 'includes/loader.php';
		}
	}

	$GLOBALS['ffm'] = new Feature_For_WooCommeerce();
}
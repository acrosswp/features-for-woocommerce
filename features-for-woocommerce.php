<?php
/**
 * Plugin Name: Features for WooCommerce
 * Plugin URI:  https://raftaar1191.com/
 * Description: This plugin provided a extra features for WooCommerce
 * Author:      raftaar1191
 * Author URI:  https://profiles.wordpress.org/raftaar1191/
 * Version:     2.0.0
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
	 * Load the Feature_For_WooCommeerce class
	 *
	 * Version:     1.0.0
	 */
	class Feature_For_WooCommeerce {

		public $buddypress = '';


		public $default_options = array();

		public function __construct() {
			$this->helper();
			$this->language();
			$this->hooks();
			$this->loader();
		}

		public function helper() {
			$this->buddypress = class_exists( 'buddypress' ) ? true : false;
		}

		public function hooks() {
			add_filter( 'woocommerce_get_settings_pages', array( $this, 'ffm_settings_pages' ) );
		}

		public function ffm_settings_pages( $settings ) {
			$settings[] = include FFW_PLUGIN_DIR . 'includes/settings.php';

			return $settings;
		}

		public function language() {
			load_plugin_textdomain( 'ffw', false, FFW_PLUGIN_BASENAME . '/i18n/languages' );
		}

		public function loader() {
			require_once FFW_PLUGIN_DIR . 'includes/functions.php';
			require_once FFW_PLUGIN_DIR . 'includes/loader.php';
		}
	}

	$GLOBALS['ffw'] = new Feature_For_WooCommeerce();
}
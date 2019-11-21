<?php
/**
 * Plugin Name: Features for WooCommerce
 * Plugin URI:  https://raftaar1191.com/
 * Description: This plugin provided a extra features for WooCommerce
 * Author:      raftaar1191
 * Author URI:  https://profiles.wordpress.org/raftaar1191/
 * Version:     2.0.2
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

// URL
if ( ! defined( 'FFW_PLUGIN_URL' ) ) {
	define( 'FFW_PLUGIN_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
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
			$this->loader();
			$this->hooks();
		}

		public function helper() {
			$this->buddypress = class_exists( 'buddypress' ) ? true : false;
		}

		public function hooks() {
			add_filter( 'woocommerce_get_settings_pages', array( $this, 'ffm_settings_pages' ) );

			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_script' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_script' ) );
		}

		/**
		 * Add script
		 *
		 * @since 2.0.3
		 */
		public function enqueue_script() {

			if ( is_admin() ) {
				wp_register_script( 'ffw_admin', FFW_PLUGIN_URL . 'assets/js/admin.js', 'jquery', FFW_PLUGIN_VERSION, true );

			}

			wp_register_script( 'ffw_frontend', FFW_PLUGIN_URL . 'assets/js/frontend.js', 'jquery', FFW_PLUGIN_VERSION, true );
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
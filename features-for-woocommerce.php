<?php
/**
 * Plugin Name: Features for WooCommerce
 * Plugin URI:  https://raftaar1191.com/
 * Description: This plugin provided a extra features for WooCommerce
 * Author:      raftaar1191
 * Author URI:  https://profiles.wordpress.org/raftaar1191/
 * Version:     2.0.12
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
	define( 'FFW_PLUGIN_VERSION', '2.0.12' );
}

// Plugin Root File.
if ( ! defined( 'FFW_PLUGIN_FILE' ) ) {
	define( 'FFW_PLUGIN_FILE', __FILE__ );
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
	define( 'FFW_PLUGIN_BASENAME', plugin_basename( FFW_PLUGIN_FILE ) );
}

// check if class exists
if ( ! class_exists( 'Feature_For_WooCommerce' ) ) {
	/**
	 * Class Feature_For_WooCommerce
	 * Load the Feature_For_WooCommerce class
	 *
	 * Version:     1.0.0
	 */
	final class Feature_For_WooCommerce {
		/** Singleton *************************************************************/

		/**
		 * The single instance of the class.
		 *
		 * @var Feature_For_WooCommerce
		 * @since 2.0.4
		 */
		protected static $_instance = null;

		public $buddypress = '';

		/**
		 * Main Feature_For_WooCommerce Instance.
		 *
		 * Ensures only one instance of WooCommerce is loaded or can be loaded.
		 *
		 * @since 2.0.4
		 * @static
		 * @see Feature_For_WooCommerce()
		 * @return Feature_For_WooCommerce - Main instance.
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Cloning is forbidden.
		 *
		 * @since 2.1
		 */
		public function __clone() {
			wc_doing_it_wrong( __FUNCTION__, __( 'Cloning is forbidden.', 'woocommerce' ), '2.1' );
		}

		/**
		 * Unserializing instances of this class is forbidden.
		 *
		 * @since 2.1
		 */
		public function __wakeup() {
			wc_doing_it_wrong( __FUNCTION__, __( 'Unserializing instances of this class is forbidden.', 'woocommerce' ), '2.1' );
		}

		public function __construct() {
			$this->helper();
			$this->language();
			$this->loader();
			$this->hooks();

			do_action( 'ffw_loaded' );
		}

		public function helper() {
			$this->buddypress = class_exists( 'buddypress' ) ? true : false;
		}

		public function hooks() {
			/**
			 * Add setting page into the Dashboard > WooCommerce > Setting > Features for WooCommerce
			 */
			add_filter( 'woocommerce_get_settings_pages', array( $this, 'ffm_settings_pages' ) );

			/**
			 * Register Script for plugin
			 */
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_script' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_script' ) );

			/**
			 * Update plugin row
			 */
			add_filter( 'network_admin_plugin_action_links_' . FFW_PLUGIN_BASENAME, array(
				$this,
				'plugin_action_links'
			) );
			add_filter( 'plugin_action_links_' . FFW_PLUGIN_BASENAME, array( $this, 'plugin_action_links' ) );
		}

		/**
		 * Plugins row action links
		 *
		 * @since 2.0.4
		 *
		 * @param array $actions An array of plugin action links.
		 *
		 * @return array An array of updated action links.
		 */
		public function plugin_action_links( $actions ) {
			$new_actions = array(
				'settings' => sprintf(
					'<a href="%1$s">%2$s</a>',
					admin_url( 'admin.php?page=wc-settings&tab=ffw_settings' ),
					__( 'Settings', 'give' )
				),
			);

			return array_merge( $new_actions, $actions );
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


	/**
	 * Start Feature_For_WooCommerce
	 *
	 * The main function responsible for returning the one true Feature_For_WooCommerce instance to functions everywhere.
	 *
	 * Use this function like you would a global variable, except without needing
	 * to declare the global.
	 *
	 * Example: <?php $feature_for_woocommerce = Feature_For_WooCommerce(); ?>
	 *
	 * @since 1.0
	 * @return object|Feature_For_WooCommerce
	 */
	function feature_for_woocommerce() {
		return Feature_For_WooCommerce::instance();
	}

	feature_for_woocommerce();
}
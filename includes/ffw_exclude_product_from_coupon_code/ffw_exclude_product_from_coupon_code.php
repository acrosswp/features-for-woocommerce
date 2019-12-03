<?php
// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'FFW_Exclude_Product_From_Coupon_Code' ) ) {
	class FFW_Exclude_Product_From_Coupon_Code {
		public function __construct() {
			/**
			 * Add submenu in WordPreess
			 */
			add_action( 'admin_menu', array( $this, 'status_menu' ), 20 );

			/**
			 * Register Coupon code settingg
			 */
			add_action( 'admin_init', array( $this, 'settings_init' ) );

			/**
			 * Exclude coupon code from cart page
			 */
			add_filter( 'woocommerce_coupon_get_excluded_product_ids', array( $this, 'excluded_product_ids' ), 1, 2 );

			add_action( 'woocommerce_coupon_options', array( $this, 'ffw_coupon_excluded' ), 10, 2 );

			add_action( 'woocommerce_coupon_options_save', array( $this, 'options_save' ) );
		}

		/**
		 * Save coupon
		 */
		public function options_save( $post_id ) {
			$include_stats = isset( $_POST['ffw_coupon_excluded'] ) ? 'yes' : 'no';
			update_post_meta( $post_id, 'ffw_coupon_excluded', $include_stats );
		}

		/**
		 * Add checkbox so that admin can remove this coupon for FFW excluded product
		 */
		public function ffw_coupon_excluded( $coupon_id ) {
			$ffw_coupon_excluded = get_post_meta( $coupon_id, 'ffw_coupon_excluded', true );
			?>
			<div class="ffw_coupon_excluded">
				<?php
				// Customers.
				// Individual use.
				woocommerce_wp_checkbox(
					array(
						'id'          => 'ffw_coupon_excluded',
						'label'       => __( 'FFM excluded Coupon', 'ffw' ),
						'description' => __( 'Check this box remove this coupon for FFW excluded products list', 'ffw' ),
						'value'       => $ffw_coupon_excluded,
						'default'     => 'no',
					)
				);
				?>
			</div>
			<?php
		}

		/**
		 * Add exclude product to coupon
		 *
		 * @param $ids
		 *
		 * @return array
		 */
		public function excluded_product_ids( $ids, $coupon ) {
			$ffw_coupon_excluded = get_post_meta( $coupon->get_id(), 'ffw_coupon_excluded', true );
			if ( 'yes' !== $ffw_coupon_excluded ) {
				return array_merge( $ids, array_map( 'intval', (array) get_option( 'ffw_exclude_product_from_coupon_code_products' ) ) );
			}
			return $ids;
		}

		/**
		 * Add menu item.
		 */
		public function status_menu() {
			add_submenu_page(
				'woocommerce',
				__( 'Exclude Product From Coupons', 'ffw' ),
				__( 'Exclude Product From Coupons', 'ffw' ),
				'manage_woocommerce',
				'ffw-exclude-product-from-coupon-code',
				array(
					$this,
					'exclude_product_page',
				)
			);
		}

		/**
		 * Init the status page.
		 */
		public function exclude_product_page() {
			wp_enqueue_script( 'wc-enhanced-select' );
			wp_enqueue_style( 'woocommerce_admin_styles' );
			?>
			<div class="wrap">

				<form action='options.php' method='post'>
					<?php
					printf( '<h2>%s</h2>', __( 'FFW: Exclude Product From Coupons', 'ffw' ) );
					?>
					<?php
					settings_fields( 'ffw_exclude_product_from_coupon_code' );
					do_settings_sections( 'ffw_exclude_product_from_coupon_code' );
					submit_button();
					?>
				</form>
			</div>
			<?php
		}

		/**
		 * Register FFW coupon code setting
		 */
		public function settings_init() {

			register_setting( 'ffw_exclude_product_from_coupon_code', 'ffw_exclude_product_from_coupon_code_products' );

			add_settings_section(
				'ffw_exclude_product_from_coupon_code_selected_product_section',
				__( 'Select Product', 'ffw' ),
				array( $this, 'ffw_exclude_product_from_coupon_code_products_section_callback' ),
				'ffw_exclude_product_from_coupon_code'
			);

			add_settings_field(
				'ffw_exclude_product_from_coupon_code_selected_product_section_product',
				__( 'Products', 'ffw' ),
				array( $this, 'ffw_exclude_product_from_coupon_code_selected_product_section_product_render' ),
				'ffw_exclude_product_from_coupon_code',
				'ffw_exclude_product_from_coupon_code_selected_product_section'
			);
		}

		public function ffw_exclude_product_from_coupon_code_products_section_callback() {
			echo __( 'This is an Multiple Dropout select the products that you want to exclusde from all the Coupon code', 'ffw' );
		}

		public function ffw_exclude_product_from_coupon_code_selected_product_section_product_render() {
			$options = get_option( 'ffw_exclude_product_from_coupon_code_products' );
			?>
			<select class="wc-product-search" multiple="multiple" style="width: 50%;"
					name="ffw_exclude_product_from_coupon_code_products[]"
					data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;', 'ffw' ); ?>"
					data-action="woocommerce_json_search_products_and_variations">

				<?php
				$product_ids = empty( $options ) ? array() : (array) $options;
				foreach ( $product_ids as $product_id ) {
					$product = wc_get_product( $product_id );
					if ( is_object( $product ) ) {
						echo '<option value="' . esc_attr( $product_id ) . '"' . selected( true, true, false ) . '>' . wp_kses_post( $product->get_formatted_name() ) . '</option>';
					}
				}
				?>
			</select>
			<?php
		}
	}

	$GLOBALS['ffw_exclude_product_from_coupon_code'] = new FFW_Exclude_Product_From_Coupon_Code();
}

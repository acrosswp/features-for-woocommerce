<?php
// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'FFW_Sorting_Coupons' ) ) {
	/**
	 * Class FFW_Sorting_Coupons
	 * Remove product on WooCommerce checkout page or via using WooCommerce Shortcode
	 */
	class FFW_Sorting_Coupons {

		/**
		 * Call on class load
		 */
		public function __construct() {

			if ( is_admin() ) {
				add_filter( 'manage_edit-shop_coupon_sortable_columns', array( $this, 'sortable_columns' ) );
				add_filter( 'request', array( $this, 'request_query' ), 10000000 );
			}
		}

		/**
		 * Handle any filters.
		 *
		 * @param array $query_vars Query vars.
		 * @return array
		 */
		public function request_query( $query_vars ) {
			global $typenow;
			if ( 'shop_coupon' === $typenow ) {
				return $this->query_filters( $query_vars );
			}

			return $query_vars;
		}

		/**
		 * Handle any custom filters.
		 *
		 * @param array $query_vars Query vars.
		 * @return array
		 */
		public function query_filters( $query_vars ) {

			// Sorting.
			if ( isset( $query_vars['orderby'] ) ) {
				if ( 'coupon_amount' === $query_vars['orderby'] ) {
					$query_vars = array_merge(
						$query_vars,
						array(
							'meta_key' => 'coupon_amount',
							'orderby'  => 'meta_value_num',
						)
					);
				}

				if ( 'discount_type' === $query_vars['orderby'] ) {
					$query_vars = array_merge(
						$query_vars,
						array(
							'meta_key' => 'discount_type',
							'orderby'  => 'meta_value',
						)
					);
				}

				if ( 'usage_limit' === $query_vars['orderby'] ) {
					$query_vars = array_merge(
						$query_vars,
						array(
							'meta_key' => 'usage_limit',
							'orderby'  => 'meta_value_num',
						)
					);
				}

				if ( 'date_expires' === $query_vars['orderby'] ) {
					$query_vars = array_merge(
						$query_vars,
						array(
							'meta_key' => 'date_expires',
							'orderby'  => 'meta_value',
						)
					);
				}
			}
			return $query_vars;
		}

		/**
		 * Define which columns are sortable.
		 *
		 * @param array $columns Existing columns.
		 * @return array
		 */
		public function sortable_columns( $columns ) {
			$custom = array(
				'coupon_code' => 'title',
				'type'        => 'discount_type',
				'amount'      => 'coupon_amount',
				'usage'       => 'usage_limit',
				'expiry_date' => 'date_expires',
			);
			unset( $columns['comments'] );

			return wp_parse_args( $custom, $columns );
		}
	}

	$GLOBALS['ffw_sorting_checkout'] = new FFW_Sorting_Coupons();
}

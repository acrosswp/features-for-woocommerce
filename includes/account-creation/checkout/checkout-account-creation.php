<?php
// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'FFW_WooCommerce_Checkout_With_BuddyPress' ) ) {
	class FFW_WooCommerce_Checkout_With_BuddyPress {
		public function __construct() {

			// check if buddypress or buddyboss platform plugin exists
			if ( class_exists( 'buddypress' ) ) {
				add_action( 'woocommerce_checkout_process', array( $this, 'woocommerce_checkout_process' ) );
				add_filter( 'woocommerce_thankyou_order_received_text', array(
					$this,
					'woocommerce_thankyou_order_received_text'
				), 100, 3 );
			}
		}

		/**
		 * Get called on Checkout page when user is non login
		 *
		 * Support WooCommerce
		 *
		 * @since 1.0.0
		 */
		function woocommerce_thankyou_order_received_text( $text ) {
			if ( ! is_user_logged_in() && is_checkout() && $this->ffm_woocommerce_change_checkout_process() ) {
				$text = __( 'Before you can login, you need to confirm your email address via the email we just sent to you.', 'ffw' );
			}

			return $text;
		}

		/**
		 * Get called on Checkout page when user is non login
		 *
		 * Support WooCommerce
		 *
		 * @since 1.0.0
		 */
		function woocommerce_checkout_process() {

			if ( ! is_user_logged_in() && $this->ffm_woocommerce_change_checkout_process() ) {
				/**
				 * Do not allow user to get login when they create account from checkout page
				 */
				add_filter( 'send_auth_cookies', '__return_false', 100 );

				/**
				 * Unset the User role of the user that is getting create via WooCommerce checkout Page
				 */
				add_filter( 'woocommerce_new_customer_data', array( $this, 'woocommerce_new_customer_data' ) );

				/**
				 * Do not allow the BuddyPress create account function to add nen user just add the Activation key for the user
				 */
				add_filter( 'bp_core_signups_do_not_skip_user_creation', '__return_false', 100 );

				/**
				 * Disable new account creating Email on Checkout page
				 */
				add_filter( 'woocommerce_email_enabled_customer_new_account', '__return_false', 100 );

				/**
				 * Called BuddyPress function to generate and send  user activation key
				 */
				add_action( 'woocommerce_created_customer', array( $this, 'woocommerce_created_customer' ), 100, 3 );
			}
		}

		/**
		 * Add BuddyBoss Platform Login Module when user sing up from WooCommerce Checkout Page
		 *
		 * Support WooCommerce
		 *
		 * @since 1.0.0
		 */
		function woocommerce_created_customer( $user_id, $new_customer_data, $ps_generated ) {
			global $wpdb, $customer_data, $password_generated;
			$customer_data      = $new_customer_data;
			$password_generated = $ps_generated;
			$activation_key     = wp_generate_password( 32, false );

			$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->users} SET user_status = 2 WHERE ID = %d", $user_id ) );

			add_filter( 'bp_email_set_content_html', array( $this, 'bp_email_set_content_html' ), 100 );
			add_filter( 'bp_email_set_content_plaintext', array( $this, 'bp_email_set_content_plaintext' ), 100 );


			BP_Signup::add( array(
				'user_login'     => $new_customer_data['user_login'],
				'user_email'     => $new_customer_data['user_email'],
				'activation_key' => $activation_key,
				'meta'           => array( 'user_id' => $user_id ),
			) );
			bp_core_signup_send_validation_email( $user_id, $new_customer_data['user_email'], $activation_key, $new_customer_data['user_login'] );

			bp_update_user_meta( $user_id, 'activation_key', $activation_key );

			remove_filter( 'bp_email_set_content_plaintext', array( $this, 'bp_email_set_content_plaintext' ), 100 );
			remove_filter( 'bp_email_set_content_html', array( $this, 'bp_email_set_content_html' ), 100 );
		}

		function bp_email_set_content_html( $content ) {
			global $customer_data, $password, $password_generated;

			if ( 'yes' === get_option( 'woocommerce_registration_generate_username', 'yes' ) && ! empty( $customer_data ) ) {
				ob_start();
				echo $content;

				printf( '<p>%s %s</p>',
					__( 'Your username has been automatically generated:', 'ffw' ),
					'<strong>' . $customer_data['user_login'] . '</strong>'
				);

				$content = ob_get_contents();
				ob_end_clean();
			}

			if ( ! empty( $password_generated ) ) {
				ob_start();
				echo $content;

				printf( '<p>%s %s</p>',
					__( 'Your password has been automatically generated:', 'ffw' ),
					'<strong>' . $password . '</strong>'
				);
				$content = ob_get_contents();
				ob_end_clean();
			}

			return $content;
		}

		function bp_email_set_content_plaintext( $content ) {
			global $customer_data, $password, $password_generated;

			if ( 'yes' === get_option( 'woocommerce_registration_generate_username', 'yes' ) && ! empty( $customer_data ) ) {
				ob_start();

				printf( $content . __( '
Your username has been automatically generated: %s', 'ffw' ),
					esc_html( $customer_data['user_login'] )
				);
				$content = ob_get_contents();
				ob_end_clean();
			}

			if ( ! empty( $password_generated ) ) {
				ob_start();

				printf( $content . __( '
Your password has been automatically generated: %s', 'ffw' ),
					$password
				);
				$content = ob_get_contents();
				ob_end_clean();
			}

			return $content;
		}

		/**
		 * Get called on Checkout page to remove the new user role
		 *
		 * Support WooCommerce
		 *
		 * @since 1.0.0
		 */
		function woocommerce_new_customer_data( $args ) {
			global $password;

			if ( $args['role'] ) {
				unset( $args['role'] );
			}

			$password = $args['user_pass'];

			return $args;
		}


		/**
		 * Get called to check if the WooCommerce checkout process should get change
		 *
		 * Support WooCommerce Checkout
		 *
		 * @since 1.0.0
		 */
		public function ffm_woocommerce_change_checkout_process() {
			/**
			 * Filter to alter the WooCommerce checkout process
			 * Support WooCommerce Checkout
			 *
			 * @since 1.0.0
			 *
			 * @param bool True if like BuddyPress Platform or else false
			 *
			 * @return bool True if like BuddyPress Platform or else false
			 */
			return (bool) apply_filters( 'ffw_woocommerce_change_checkout_process', true );
		}
	}

	$GLOBALS['ffm_checkout_buddypress'] = new FFW_WooCommerce_Checkout_With_BuddyPress();
}
<?php
/**
 * WooCommerce Custom Indexes main class
 *
 * @package WooCommerce_Custom_Indexes
 */

defined( 'ABSPATH' ) || exit;

/**
 * Main plugin class.
 */
class WC_Custom_Indexes {

	/**
	 * Initialize plugin and add initialization actions.
	 *
	 * @return void
	 */
	public function init() {
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		if ( class_exists( 'WooCommerce' ) && version_compare( WC_VERSION, '3.0', '>=' ) && is_admin() ) {
			require_once dirname( __FILE__ ) . '/class-wc-custom-indexes-runner.php';
			require_once dirname( __FILE__ ) . '/class-wc-custom-indexes-admin.php';

			$admin = new WC_Custom_Indexes_Admin();
			$admin->init();
		}
	}

	/**
	 * Load text domain for plugin.
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'woocommerce-custom-indexes', false, plugin_basename( dirname( WC_CUSTOM_INDEXES_PLUGIN_FILE ) ) . '/languages' );
	}

	/**
	 * Abort activation if WooCommerce is not installed and active.
	 */
	public function activation_check() {
		if ( ! defined( 'WC_VERSION' ) || ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '3.0', '<' ) ) ) {
			wp_die(
				/* translators: %s: WooCommerce URL */
				'<p>' . wp_kses_post( sprintf( __( 'WooCommerce Custom Indexes requires WooCommerce 3.0+ to be installed and active. You can download %s here.', 'woocommerce-custom-indexes' ), '<a href="https://woocommerce.com/woocommerce/" target="_blank">WooCommerce</a>' ) ) . '</p>'
				. '<p><a href="' . esc_url( admin_url( 'plugins.php' ) ) . '">' . esc_html__( 'Return to admin.', 'woocommerce-custom-indexes' ) . '</a></p>'
			);
		}
	}
}

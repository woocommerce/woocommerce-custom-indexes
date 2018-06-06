<?php
/**
 * WooCommerce Custom Indexes class responsible for adding the indexes.
 *
 * @package WooCommerce_Custom_Indexes
 */

defined( 'ABSPATH' ) || exit;

/**
 * Plugin class to add indexes to the database tables.
 */
class WC_Custom_Indexes_Runner {

	/**
	 * Add custom indexes to the database tables.
	 *
	 * @return void
	 */
	public function add_indexes() {
		global $wpdb;

		// phpcs:ignore WordPress.VIP.DirectDatabaseQuery.NoCaching
		$wpdb->query(
			"ALTER TABLE {$wpdb->postmeta} ADD INDEX wc_meta_key_value (meta_key(191), meta_value(100))" // phpcs:ignore WordPress.VIP.DirectDatabaseQuery.SchemaChange
		);
	}
}

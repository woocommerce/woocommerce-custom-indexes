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
		global $wpdb, $wp_filesystem;

		// Attempt to initialize WP_Filesystem class.
		if ( ! WP_Filesystem() ) {
			wp_die( esc_html__( 'Unable to put site in maintenance mode. Aborting.', 'woocommerce-custom-indexes' ) );
		}

		// Create maintenance file to put WP in maintenance mode while running the queries. Copied from wp-admin/includes/update-core.php.
		$maintenance_string = '<?php $upgrading = ' . time() . '; ?>';
		$maintenance_file = ABSPATH . '.maintenance';
		$wp_filesystem->delete( $maintenance_file );
		$wp_filesystem->put_contents( $maintenance_file, $maintenance_string, FS_CHMOD_FILE );

		// phpcs:ignore WordPress.VIP.DirectDatabaseQuery.NoCaching
		$wpdb->query(
			"ALTER TABLE {$wpdb->postmeta} ADD INDEX wc_meta_key_value (meta_key(191), meta_value(100))" // phpcs:ignore WordPress.VIP.DirectDatabaseQuery.SchemaChange
		);

		// Remove maintenance file.
		$wp_filesystem->delete( $maintenance_file );

		wp_safe_redirect( admin_url( 'admin.php?page=wc-custom-indexes' ) );
		exit;
	}
}

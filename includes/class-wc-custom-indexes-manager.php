<?php
/**
 * WooCommerce Custom Indexes class responsible for managing custom table indexes.
 *
 * @package WooCommerce_Custom_Indexes
 */

defined( 'ABSPATH' ) || exit;

/**
 * Plugin class to manage custom table indexes.
 */
class WC_Custom_Indexes_Manager {

	/**
	 * WC_Custom_Indexes_Manager constructor.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->maintenance_file = ABSPATH . '.maintenance';
	}

	/**
	 * Add custom indexes to the database tables.
	 *
	 * @return void
	 */
	public function add_indexes() {
		global $wpdb;

		// Do nothing if index already exist.
		if ( $this->index_exist( $wpdb->postmeta, 'wc_meta_key_value' ) ) {
			return;
		}

		$this->maintenance_mode_on();

		// phpcs:ignore WordPress.VIP.DirectDatabaseQuery.NoCaching
		$wpdb->query(
			"ALTER TABLE {$wpdb->postmeta} ADD INDEX wc_meta_key_value (meta_key(191), meta_value(100))" // phpcs:ignore WordPress.VIP.DirectDatabaseQuery.SchemaChange
		);

		$this->maintenance_mode_off();
	}

	/**
	 * Add custom indexes to the database tables.
	 *
	 * @return void
	 */
	public function remove_indexes() {
		global $wpdb;

		// Do nothing if index doesn't exist .
		if ( ! $this->index_exist( $wpdb->postmeta, 'wc_meta_key_value' ) ) {
			return;
		}

		$this->maintenance_mode_on();

		// phpcs:ignore WordPress.VIP.DirectDatabaseQuery.NoCaching
		$wpdb->query(
			"ALTER TABLE {$wpdb->postmeta} DROP INDEX wc_meta_key_value" // phpcs:ignore WordPress.VIP.DirectDatabaseQuery.SchemaChange
		);

		$this->maintenance_mode_off();
	}

	/**
	 * Create maintenance file to put WP in maintenance mode while running the queries.
	 *
	 * @return void
	 */
	protected function maintenance_mode_on() {
		global $wp_filesystem;

		// Attempt to initialize WP_Filesystem class.
		if ( ! WP_Filesystem() ) {
			wp_die( esc_html__( 'Unable to put site in maintenance mode. Aborting.', 'woocommerce-custom-indexes' ) );
		}

		// Copied from wp-admin/includes/update-core.php.
		$maintenance_string = '<?php $upgrading = ' . time() . '; ?>';
		$wp_filesystem->delete( $this->maintenance_file );
		$wp_filesystem->put_contents( $this->maintenance_file, $maintenance_string, FS_CHMOD_FILE );
	}

	/**
	 * Remove maintenance file.
	 *
	 * @return void
	 */
	protected function maintenance_mode_off() {
		global $wp_filesystem;

		$wp_filesystem->delete( $this->maintenance_file );
	}

	/**
	 * Check if an index exist in a given table.
	 *
	 * @param string $table_name Table name.
	 * @param string $index_name Index name.
	 *
	 * @return bool
	 */
	public function index_exist( $table_name, $index_name ) {
		global $wpdb;

		// phpcs:ignore WordPress.VIP.DirectDatabaseQuery.NoCaching, WordPress.WP.PreparedSQL.NotPrepared
		$indexes = $wpdb->get_var( "SHOW INDEXES FROM {$table_name} WHERE Key_name = '{$index_name}'" );

		return is_null( $indexes ) ? false : true;
	}
}

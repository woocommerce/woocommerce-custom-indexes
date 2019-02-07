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
	 * Get indexes.
	 *
	 * Returns an array of indexes to add/drop.
	 *
	 * @return array
	 */
	protected function get_indexes() {
		global $wpdb;

		return array(
			'wc_options_autoload'      => (object) array(
				'table'   => $wpdb->options, // phpcs:ignore
				'columns' => 'autoload, option_name',
			),
			'wc_postmeta_id_key_value' => (object) array(
				'table'   => $wpdb->postmeta, // phpcs:ignore
				'columns' => 'meta_key(191), post_id, meta_value(50)',
			),
			'wc_termmeta_id_key_value' => (object) array(
				'table'   => $wpdb->termmeta, // phpcs:ignore
				'columns' => 'meta_key(191), term_id, meta_value(50)',
			),
			'wc_usermeta_id_meta_key'  => (object) array(
				'table'   => $wpdb->usermeta, // phpcs:ignore
				'columns' => 'meta_key(191), user_id, meta_value(50)',
			),
			'wc_posts_id_status_type'  => (object) array(
				'table'   => $wpdb->posts, // phpcs:ignore
				'columns' => 'post_type, post_status, ID',
			),
		);
	}

	/**
	 * Add custom indexes to the database tables.
	 */
	public function add_indexes() {
		global $wpdb;

		$indexes        = $this->get_indexes();
		$create_indexes = array();

		foreach ( $indexes as $name => $index ) {
			if ( ! $this->index_exist( $index->table, $name ) ) {
				$create_indexes[ $name ] = $index;
			}
		}

		// Do nothing if index already exist.
		if ( empty( $create_indexes ) ) {
			return;
		}

		$this->maintenance_mode_on();

		foreach ( $create_indexes as $name => $index ) {
			$wpdb->query( "CREATE INDEX {$name} ON {$index->table}({$index->columns});" ); // phpcs:ignore
		}

		$this->maintenance_mode_off();
	}

	/**
	 * Add custom indexes to the database tables.
	 */
	public function remove_indexes() {
		global $wpdb;

		$indexes        = $this->get_indexes();
		$remove_indexes = array();

		foreach ( $indexes as $name => $index ) {
			if ( $this->index_exist( $index->table, $name ) ) {
				$remove_indexes[ $name ] = $index;
			}
		}

		// Do nothing if index does not exist.
		if ( empty( $remove_indexes ) ) {
			return;
		}

		$this->maintenance_mode_on();

		foreach ( $remove_indexes as $name => $index ) {
			$wpdb->query( "ALTER TABLE {$index->table} DROP INDEX {$name};" ); // phpcs:ignore
		}

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

		$indexes = $wpdb->get_var( "SHOW INDEXES FROM {$table_name} WHERE Key_name = '{$index_name}'" ); // phpcs:ignore

		return is_null( $indexes ) ? false : true;
	}
}

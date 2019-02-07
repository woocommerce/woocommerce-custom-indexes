<?php
/**
 * File for the class that contains WP-CLI commands provided by this plugin.
 *
 * @package WooCommerce_Custom_Indexes/Classes
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Provides woocommerce-custom-indexes WP-CLI commands.
 */
class WC_Custom_Indexes_CLI extends WP_CLI_Command {

	/**
	 * Add indexes.
	 *
	 * @subcommand add
	 */
	public function add() {
		WP_CLI::line( 'Creating indexes...' );
		$manager = new WC_Custom_Indexes_Manager();
		$manager->add_indexes();
		WP_CLI::line( 'Done.' );
	}

	/**
	 * Remove indexes.
	 *
	 * @subcommand remove
	 */
	public function remove() {
		WP_CLI::line( 'Removing indexes...' );
		$manager = new WC_Custom_Indexes_Manager();
		$manager->remove_indexes();
		WP_CLI::line( 'Done.' );
	}

	/**
	 * Recreate indexes.
	 *
	 * @subcommand recreate
	 */
	public function recreate() {
		$this->remove();
		$this->add();
	}
}

WP_CLI::add_command( 'wc-custom-indexes', 'WC_Custom_Indexes_CLI' );

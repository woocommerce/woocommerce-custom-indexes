<?php
/**
 * Test WC_Custom_Indexes_Manager methods.
 *
 * @package Woocommerce_Custom_Indexes
 */

/**
 * WC_Custom_Indexes_Manager test case.
 */
class WC_Custom_Indexes_Manager_Test extends WP_UnitTestCase {

	/**
	 * Test case setup.
	 */
	public function setUp() {
		parent::setUp();

		require_once dirname( dirname( __FILE__ ) ) . '/includes/class-wc-custom-indexes-manager.php';
		$this->manager = new WC_Custom_Indexes_Manager();
	}

	/**
	 * Test WC_Custom_Indexes_Manager::index_exist()
	 */
	public function test_index_exist_should_return_false() {
		global $wpdb;

		$this->assertFalse( $this->manager->index_exist( $wpdb->posts, 'invalid_index' ) );
	}

	/**
	 * Test WC_Custom_Indexes_Manager::index_exist()
	 */
	public function test_index_exist_should_return_true() {
		global $wpdb;

		$this->assertTrue( $this->manager->index_exist( $wpdb->posts, 'type_status_date' ) );
	}

	/**
	 * Test WC_Custom_Indexes_Manager::add_indexes()
	 */
	public function test_add_indexes_should_create_indexes() {
		global $wpdb;

		$this->assertFalse( $this->manager->index_exist( $wpdb->postmeta, 'wc_meta_key_value' ) );
		$this->manager->add_indexes();
		$this->assertTrue( $this->manager->index_exist( $wpdb->postmeta, 'wc_meta_key_value' ) );

		// Clean up.
		$this->manager->remove_indexes();
	}

	/**
	 * Test WC_Custom_Indexes_Manager::remove_indexes()
	 */
	public function test_remove_indexes_should_remove_indexes() {
		global $wpdb;

		// Setup.
		$this->manager->add_indexes();
		$this->assertTrue( $this->manager->index_exist( $wpdb->postmeta, 'wc_meta_key_value' ) );

		$this->manager->remove_indexes();
		$this->assertFalse( $this->manager->index_exist( $wpdb->postmeta, 'wc_meta_key_value' ) );
	}
}

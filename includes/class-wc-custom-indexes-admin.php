<?php
/**
 * WooCommerce Custom Indexes admin class
 *
 * @package WooCommerce_Custom_Indexes
 */

defined( 'ABSPATH' ) || exit;

/**
 * Plugin class to add content to WP admin.
 */
class WC_Custom_Indexes_Admin {

	/**
	 * WC_Custom_Indexes_Manager instance.
	 *
	 * @var WC_Custom_Indexes_Manager
	 */
	protected $manager;

	/**
	 * WC_Custom_Indexes_Admin constructor.
	 *
	 * @param WC_Custom_Indexes_Manager $manager WC_Custom_Indexes_Manager instance.
	 */
	public function __construct( WC_Custom_Indexes_Manager $manager ) {
		$this->manager = $manager;
	}

	/**
	 * Add initialization actions and filters.
	 *
	 * @return void
	 */
	public function init() {
		add_filter( 'plugin_action_links_' . WC_CUSTOM_INDEXES_PLUGIN_BASENAME, array( $this, 'plugin_action_links' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
		add_action( 'admin_menu', array( $this, 'add_menu_entry' ), 99 );
		add_action( 'admin_init', array( $this, 'maybe_change_indexes' ) );
	}

	/**
	 * Display link to add custom indexes to the database.
	 *
	 * @param   mixed $links Plugin Action links.
	 * @return  array
	 */
	public function plugin_action_links( $links ) {
		$action_links = array(
			'add-indexes' => '<a href="' . admin_url( 'admin.php?page=wc-custom-indexes' ) . '" aria-label="' . esc_attr__( 'Add custom indexes', 'woocommerce-custom-indexes' ) . '">' . esc_html__( 'Add custom indexes', 'woocommerce-custom-indexes' ) . '</a>',
		);

		return array_merge( $action_links, $links );
	}

	/**
	 * Enqueue plugin admin scripts.
	 *
	 * @return void
	 */
	public function enqueue_admin_scripts() {
		wp_register_script(
			'wc-custom-indexes-admin',
			plugins_url( 'assets/js/wc-custom-indexes-admin.js', WC_CUSTOM_INDEXES_PLUGIN_FILE ),
			array( 'jquery' )
		);

		wp_enqueue_script( 'wc-custom-indexes-admin' );

		wp_localize_script(
			'wc-custom-indexes-admin',
			'wcCustomIndexesVars',
			array(
				'confirmAction' => __( 'It is strongly recommended that you backup your database before proceeding. Your site will be in maintenance mode while the queries are running. Are you sure you wish to proceed?', 'woocommerce-custom-indexes' ),
			)
		);
	}

	/**
	 * Add sub menu entry to WooCommerce menu in the admin.
	 *
	 * @return void
	 */
	public function add_menu_entry() {
		add_submenu_page(
			'woocommerce',
			__( 'Custom indexes', 'woocommerce-custom-indexes' ),
			__( 'Custom indexes', 'woocommerce-custom-indexes' ),
			'manage_woocommerce',
			'wc-custom-indexes',
			array( $this, 'output_page' )
		);
	}

	/**
	 * Display plugin admin page.
	 *
	 * @return void
	 */
	public function output_page() {
		require dirname( WC_CUSTOM_INDEXES_PLUGIN_FILE ) . '/templates/admin-page.php';
	}

	/**
	 * Maybe start the process that will add or remove custom indexes from the database tables.
	 *
	 * @return void
	 */
	public function maybe_change_indexes() {
		if ( isset( $_GET['page'] ) && 'wc-custom-indexes' === $_GET['page'] && ( ! empty( $_GET['wc-add-custom-indexes'] ) || ! empty( $_GET['wc-remove-custom-indexes'] ) ) ) {
			if ( ! empty( $_GET['wc-add-custom-indexes'] ) ) {
				check_admin_referer( 'wc-add-custom-indexes' );
				$this->manager->add_indexes();
			} elseif ( ! empty( $_GET['wc-remove-custom-indexes'] ) ) {
				check_admin_referer( 'wc-remove-custom-indexes' );
				$this->manager->remove_indexes();
			}

			wp_safe_redirect( admin_url( 'admin.php?page=wc-custom-indexes' ) );
			exit;
		}
	}
}

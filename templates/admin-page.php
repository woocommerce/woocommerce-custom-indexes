<?php
/**
 * Display the plugin admin page.
 *
 * @package WooCommerce_Custom_Indexes
 */

$action_url = wp_nonce_url(
	admin_url( 'admin.php?page=wc-custom-indexes&wc-add-custom-indexes=1' ),
	'wc-add-custom-indexes'
);

?>
<div class="wrap">
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

	<p>
		<?php
		esc_html_e(
			'Click the button bellow to add custom indexes to your WooCommerce/WordPress tables. This process will put your site in maintenance mode while the queries are running. It might take several minutes for this operation to complete depending on your database size. It is highly recommended that you perform a backup of the site before proceeding.',
			'woocommerce-custom-indexes'
		);
		?>
	</p>
	<p class="submit">
		<a href="<?php echo esc_url( $action_url ); ?>" class="button-primary wc-add-custom-indexes">
			<?php esc_html_e( 'Add custom indexes', 'woocommerce-custom-indexes' ); ?>
		</a>
	</p>
</div>

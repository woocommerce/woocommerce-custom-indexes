<?php
/**
 * Display the plugin admin page.
 *
 * @package WooCommerce_Custom_Indexes
 */

global $wpdb;

?>
<div class="wrap">
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

	<?php if ( $this->manager->index_exist( $wpdb->postmeta, 'wc_meta_key_value' ) ) : ?>
		<?php
		$remove_url = wp_nonce_url(
			admin_url( 'admin.php?page=wc-custom-indexes&wc-remove-custom-indexes=1' ),
			'wc-remove-custom-indexes'
		);
		?>
		<p>
			<?php
			esc_html_e(
				'Custom indexes already installed. Click the button bellow to remove them from your WooCommerce/WordPress tables. This process will put your site in maintenance mode while the queries are running. It might take several minutes for this operation to complete depending on your database size. It is highly recommended that you perform a backup of the site before proceeding.',
				'woocommerce-custom-indexes'
			);
			?>
		</p>
		<p class="submit">
			<a href="<?php echo esc_url( $remove_url ); ?>" class="button-primary wc-change-custom-indexes">
				<?php esc_html_e( 'Remove custom indexes', 'woocommerce-custom-indexes' ); ?>
			</a>
		</p>
	<?php else : ?>
		<?php
		$add_url = wp_nonce_url(
			admin_url( 'admin.php?page=wc-custom-indexes&wc-add-custom-indexes=1' ),
			'wc-add-custom-indexes'
		);
		?>
		<p>
			<?php
			esc_html_e(
				'Click the button bellow to add custom indexes to your WooCommerce/WordPress tables. This process will put your site in maintenance mode while the queries are running. It might take several minutes for this operation to complete depending on your database size. It is highly recommended that you perform a backup of the site before proceeding.',
				'woocommerce-custom-indexes'
			);
			?>
		</p>
		<p class="submit">
			<a href="<?php echo esc_url( $add_url ); ?>" class="button-primary wc-change-custom-indexes">
				<?php esc_html_e( 'Add custom indexes', 'woocommerce-custom-indexes' ); ?>
			</a>
		</p>
	<?php endif; ?>
</div>

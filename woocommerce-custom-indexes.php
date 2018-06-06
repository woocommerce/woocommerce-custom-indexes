<?php
/**
 * Plugin Name: WooCommerce Custom Indexes
 * Plugin URI:  https://github.com/woocommerce/woocommerce-custom-indexes
 * Description: Adds custom indexes to WordPress and WooCommerce tables to speed up queries.
 * Author:      WooCommerce
 * Author URI:  https://woocommerce.com
 * Version:     1.0.0
 * License:     GPLv3
 * Text Domain: woocommerce-custom-indexes
 * Domain Path: /languages
 *
 * Copyright (C) 2018 WooCommerce
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package WooCommerce_Custom_Indexes
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'WC_CUSTOM_INDEXES_PLUGIN_FILE' ) ) {
	define( 'WC_CUSTOM_INDEXES_PLUGIN_FILE', __FILE__ );
}

if ( ! defined( 'WC_CUSTOM_INDEXES_PLUGIN_BASENAME' ) ) {
	define( 'WC_CUSTOM_INDEXES_PLUGIN_BASENAME', plugin_basename( WC_CUSTOM_INDEXES_PLUGIN_FILE ) );
}

// Include the main class.
if ( ! class_exists( 'WC_Custom_Indexes' ) ) {
	require dirname( __FILE__ ) . '/includes/class-wc-custom-indexes.php';
}

$wc_custom_indexes = new WC_Custom_Indexes();

add_action( 'plugins_loaded', array( $wc_custom_indexes, 'init' ) );
register_activation_hook( __FILE__, array( $wc_custom_indexes, 'activation_check' ) );

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

// Include the main class.
if ( ! class_exists( 'WC_Custom_Indexes' ) ) {
	include_once dirname( __FILE__ ) . '/includes/class-wc-custom-indexes.php';
}

add_action( 'plugins_loaded', array( 'WC_Product_Type_Column', 'init' ) );
register_activation_hook( __FILE__, array( 'WC_Product_Type_Column', 'activation_check' ) );

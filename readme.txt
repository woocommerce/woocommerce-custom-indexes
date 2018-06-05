=== WooCommerce Custom Indexes ===
Contributors: automattic, rodrigosprimo
Tags: woocommerce, database, performance
Requires at least: 4.7
Tested up to: 4.9.6
Requires PHP: 5.2
Stable tag: 1.0.0
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Adds custom indexes to WordPress and WooCommerce tables to speed up queries.

== Description ==

This plugin adds custom indexes to WordPress and WooCommerce tables to speed up queries. This first version of the plugin only adds a meta_key/meta_value index to wp_postmeta to improve the performance of the WooCommerce queries that search for meta_value. The plan is to add more indexes in the future.

While the query that adds the index is running the site is put in maintenance mode.

= Requirements =

- WooCommerce 3.0 or later.
- WordPress 4.7 or later.
- PHP 5.2 or later.

== Installation ==

= Automatic installation =

Automatic installation is the easiest option as WordPress handles the file transfers itself and you don't need to leave your web browser. To
do an automatic install of, log in to your WordPress dashboard, navigate to the Plugins menu and click Add New.

In the search field type "WooCommerce Custom Indexes" and click "Search Plugins". Then find the plugin in the search results and click "Install Now".

= Manual installation =

The manual installation method involves downloading the plugin and uploading it to your web server via SSH or FTP. The WordPress codex contains [instructions on how to do this here](http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation).

== Changelog ==

= 1.0.0 =

- Initial release.
<?php

/**
 * @link              https://github.com/thatwpdeveloper
 * @since             1.0.0
 * @package           Spark_Products
 *
 * @wordpress-plugin
 * Plugin Name:       Spark Products
 * Plugin URI:        https://github.com/thatwpdeveloper/spark-products
 * Description:       A basic WordPress plugin that will allow you to display products from certain categories.
 * Version:           1.0.0
 * Author:            Dmitri Bostan
 * Author URI:        https://github.com/thatwpdeveloper
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       spark-products
 * Domain Path:       /languages
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


/**
 * Stores the current plugin version.
 *
 * @since 1.0.0
 */
define( 'SPARK_PRODUCTS_VERSION', '1.0.0' );

/**
 * Stores the server path to the plugin.
 *
 * @since 1.0.0
 */
define( 'SPARK_PRODUCTS_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Stores the url path to the plugin.
 *
 * @since 1.0.0
 */
define( 'SPARK_PRODUCTS_URL', plugin_dir_url( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/core/class-spark-products-activator.php
 */
function activate_spark_products() {
	require_once SPARK_PRODUCTS_PATH . 'includes/core/class-spark-products-activator.php';
	Spark_Products_Activator::set_db_tables();
}

register_activation_hook( __FILE__, 'activate_spark_products' );

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/core/class-spark-products-deactivator.php
 */
function deactivate_spark_products() {
	require_once SPARK_PRODUCTS_PATH . 'includes/core/class-spark-products-deactivator.php';
	Spark_Products_Deactivator::remove_db_tables();
}

register_deactivation_hook( __FILE__, 'deactivate_spark_products' );


/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require SPARK_PRODUCTS_PATH . 'includes/core/class-spark-products.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_spark_products() {

	$plugin = new Spark_Products();
	$plugin->run();

}
run_spark_products();
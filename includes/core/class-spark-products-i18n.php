<?php

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Spark_Products
 * @subpackage Spark_Products/includes
 */
class Spark_Products_i18n {


	/**
	 * Loads the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'spark-products',
			false,
			SPARK_PRODUCTS_PATH . '/languages/'
		);

	}

}

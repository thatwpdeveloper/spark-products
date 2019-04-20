<?php

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Spark_Products
 * @subpackage Spark_Products/includes
 */
class Spark_Products_Activator {

	/**
	 * Creates the necessary database entries in wp_options.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public static function set_db_tables() {
		add_option( 'spark-products-options' );
	}

}

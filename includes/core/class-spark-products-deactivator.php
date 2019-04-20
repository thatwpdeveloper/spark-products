<?php

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Spark_Products
 * @subpackage Spark_Products/includes
 */
class Spark_Products_Deactivator {

	/**
	 * Removes the necessary database entries in wp_options.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public static function remove_db_tables() {
		delete_option( 'spark-products-options' );
	}

}

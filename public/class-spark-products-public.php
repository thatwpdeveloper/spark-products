<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/thatwpdeveloper
 * @since      1.0.0
 *
 * @package    Spark_Products
 * @subpackage Spark_Products/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Spark_Products
 * @subpackage Spark_Products/public
 * @author     Dmitri Bostan <thatwpdeveloper>
 */
class Spark_Products_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function add_star_rating_css() {
		wp_enqueue_style(
			$this->plugin_name . '-star-rating',
			SPARK_PRODUCTS_URL . 'public/css/stars.css',
			array(),
			$this->version,
			'screen'
		);
	}

	public function add_target_group_caching() {

		if(is_admin()) {
			return;
		}

		$target_group = new Spark_Products_Target_Group();
		$cookie = Spark_Products_Cookie::get_instance();

		if(!$target_group->is_valid_taxonomy_term()) {
			return;
		}

		if(! $cookie->get_cookie('spark_products_target_group')) {
			$cookie->set_cookie('spark_products_target_group', $target_group->get_term());
		}
	}

}

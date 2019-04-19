<?php

/**
 * The hook-based functionality of the plugin.
 *
 * Defines the plugin name, version as well.
 *
 * @since      1.0.0
 * @package    Spark_Products
 * @subpackage Spark_Products/includes
 */
class Spark_Products_Hook {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	public function add_products_post_type() {

		$products = new Spark_Products_Post_Type(
			array(
				'post_type_name' => 'spark_products',
				'singular'       => 'Product',
				'plural'         => 'Products',
				'slug'           => 'spark_products'
			),
			array(
				'supports'            => array( 'title', 'thumbnail' ),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_position'       => 5,
				'menu_icon'           => 'dashicons-cart',
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => false,
				'can_export'          => true,
				'has_archive'         => false,
				'exclude_from_search' => true,
				'publicly_queryable'  => false,
				'rewrite'             => false,
				'capability_type'     => 'post',
			)
		);

		$products->register_post_type();

	}

	public function add_acf() {

	}

}

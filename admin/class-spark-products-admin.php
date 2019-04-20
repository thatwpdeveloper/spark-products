<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/thatwpdeveloper
 * @since      1.0.0
 *
 * @package    Spark_Products
 * @subpackage Spark_Products/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Spark_Products
 * @subpackage Spark_Products/admin
 * @author     Dmitri Bostan <thatwpdeveloper>
 */
class Spark_Products_Admin {

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

	/**
	 * Adds the Products post type to WordPress and registers the target group taxonomy.
	 *
	 * The key is 'spark-products' in order to avoid name collision if Woocommerce
	 * or any other plugin that uses the 'product' or 'products' keys.
	 *
	 * @since 1.0.0
	 */
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
				'publicly_queryable'  => true,
				'rewrite'             => array(
					'with_front' => true,
					'slug'       => 'spark-products',
				),
				'capability_type'     => 'post',
			)
		);

		$products->register_post_type();

		$products->register_taxonomy(
			array(
				'taxonomy_name' => 'target_groups',
				'singular'      => __( 'Target Group', 'spark_products' ),
				'plural'        => __( 'Target Groups', 'spark_products' ),
				'slug'          => 'target-groups'
			)
		);

		$products->register_taxonomies();

	}

	public function add_cmb2() {

		if ( class_exists( 'CMB2' ) ) {
			return;
		}



	}

	public function add_product_fields() {

		$cmb = new_cmb2_box( array(
			'id'           => 'spark_products_details',
			'title'        => __( 'Product details', 'spark-products' ),
			'object_types' => array( 'spark_products' ),
			'context'      => 'normal',
			'priority'     => 'high',
			'show_names'   => true,
		) );

		$cmb->add_field( array(
			'name'         => __( 'Upload an image', 'spark-products' ),
			'desc'         => __( 'Upload an image for this product', 'spark-products' ),
			'id'           => 'spark_products_image',
			'type'         => 'file',
			'query_args'   => array(
				'type' => array(
					'image/gif',
					'image/jpeg',
					'image/png',
				),
			),
			'text'         => array(
				'add_upload_file_text' => __( 'Upload an image', 'spark-products' )
			),
			'preview_size' => 'medium',
		) );

		$cmb->add_field( array(
			'name'        => __( 'Rating', 'spark-products' ),
			'description' => __( 'Please add a rating to this product, from 0 to 5.', 'spark-products' ),
			'id'          => 'spark_products_rating',
			'type'        => 'text',
			'attributes'  => array(
				'type'     => 'number',
				'min'      => 0,
				'max'      => 5,
				'required' => 'required',
			),
		) );

	}

	public function add_widget() {
		register_widget( 'spark_products_widget' );
	}

	public function add_product_settings() {

		$cmb_options = new_cmb2_box( array(
			'id'           => 'spark_products_options_submenu',
			'title'        => esc_html__( 'Product Options', 'cmb2' ),
			'object_types' => array( 'options-page' ),
			'option_key'   => 'spark-products-options',
			'parent_slug'  => 'edit.php?post_type=spark_products',
		) );

		$cmb_options->add_field(
			array(
				'name'           => __( 'Default Target Group', 'spark-products' ),
				'desc'           => __( 'Please select a default target group.', 'spark-products' ),
				'id'             => 'spark_products_target_groups',
				'taxonomy'       => 'target_groups',
				'type'           => 'taxonomy_select',
				'remove_default' => 'true',
				'query_args'     => array(
					'orderby'    => 'slug',
					'hide_empty' => false,
				),
			)
		);
	}

}

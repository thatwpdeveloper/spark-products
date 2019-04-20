<?php

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Spark_Products
 * @subpackage Spark_Products/includes
 */
class Spark_Products {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Spark_Products_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'SPARK_PRODUCTS_VERSION' ) ) {
			$this->version = SPARK_PRODUCTS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'spark-products';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Spark_Products_Loader. Orchestrates the hooks of the plugin.
	 * - Spark_Products_i18n. Defines internationalization functionality.
	 * - Spark_Products_Image. Defines the handling of the image output.
	 * - Spark_Products_Rating. Defines the handling of the rating output.
	 * - Spark_Products_Post_Type. Defines the generation and modification of post types.
	 * - Spark_Products_Admin. Defines all hooks for the admin area.
	 * - Spark_Products_Public. Defines all hooks for the public area.
	 * - Spark_Products_Target_Group. Defines the target group logic.
	 * - Spark_Products_Cookie. Defines ways to manage cookies in the browser.
	 * - Spark_Products_Query. Defines the products query.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once SPARK_PRODUCTS_PATH . 'includes/core/class-spark-products-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once SPARK_PRODUCTS_PATH . 'includes/core/class-spark-products-i18n.php';

		/**
		 * The class responsible for the handling image output.
		 */
		require_once SPARK_PRODUCTS_PATH . 'includes/helpers/class-spark-products-image.php';

		/**
		 * The class responsible for the handling rating output.
		 */
		require_once SPARK_PRODUCTS_PATH . 'includes/helpers/class-spark-products-rating.php';

		/**
		 * The class responsible for generating and modifying post types.
		 */
		require_once SPARK_PRODUCTS_PATH . 'includes/core/class-spark-products-post-type.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once SPARK_PRODUCTS_PATH . 'admin/class-spark-products-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public area.
		 */
		require_once SPARK_PRODUCTS_PATH . 'public/class-spark-products-public.php';

		/**
		 * The class responsible for the retrieving the target group.
		 */
		require_once SPARK_PRODUCTS_PATH . 'includes/helpers/class-spark-products-target-group.php';

		/**
		 * The class responsible for the caching the target group.
		 */
		require_once SPARK_PRODUCTS_PATH . 'includes/cookies/class-spark-products-cookie.php';

		/**
		 * The class responsible the products query.
		 */
		require_once SPARK_PRODUCTS_PATH . 'includes/queries/class-spark-products-query.php';


		/**
		 * The class responsible for the creating the widget.
		 */
		require_once SPARK_PRODUCTS_PATH . 'includes/widgets/class-spark-products-widget.php';


		$this->loader = new Spark_Products_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Spark_Products_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Spark_Products_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Spark_Products_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'init', $plugin_admin, 'add_products_post_type' , 10 );

		$this->loader->add_action( 'plugins_loaded', $plugin_admin, 'add_cmb2' );

		$this->loader->add_action( 'cmb2_admin_init', $plugin_admin, 'add_product_fields' );

		$this->loader->add_action( 'cmb2_admin_init', $plugin_admin, 'add_product_settings' , 20 );

		$this->loader->add_action( 'widgets_init', $plugin_admin, 'add_widget' );

	}


	/**
	 * Register all of the hooks related to the functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Spark_Products_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'init', $plugin_public, 'add_target_group_caching' , 20 );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'add_star_rating_css' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Spark_Products_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}

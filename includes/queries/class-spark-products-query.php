<?php

/**
 * Manages the products query.
 *
 * @since      1.0.0
 * @package    Spark_Products
 * @subpackage Spark_Products/includes
 */

class Spark_Product_Query {

	/**
	 * Holds the query object.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @type object
	 * @var $query
	 */
	protected $query;

	/**
	 * Holds the query arguments.
	 *
	 * @since 1.0.0
	 * @access public
	 * @type array
	 * @var $query_args
	 */
	public $query_args;

	/**
	 * Holds the queried term.
	 *
	 * @since 1.0.0
	 * @access public
	 * @type string
	 * @var $queried_term
	 */
	public $queried_term;

	/**
	 * Spark_Product_Query constructor.
	 *
	 * @param $query_args
	 * @param $queried_term
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct( $queried_term ) {

		$this->queried_term = $queried_term;

		$this->set_query_args();
		$this->set_query();
	}

	/**
	 * Sets the basic query args.
	 *
	 * The query will display up to 5 products descending, based on their rating.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @return array
	 */
	protected function set_query_args() {
		$this->query_args = array(
			'post_type'      => 'spark_products',
			'posts_per_page' => 5,
			'meta_key'       => 'spark_products_rating',
			'meta_type'      => 'NUMERIC',
			'orderby'        => 'meta_value_num'

		);

		return $this->query_args;
	}

	/**
	 * Sets the custom terms related arguments.
	 * @return mixed
	 */
	protected function set_term_to_query_args() {

		if ( $this->queried_term ) {
			$this->query_args['tax_query'] = array(
				array(
					'taxonomy' => 'target_groups',
					'field'    => 'slug',
					'terms'    => $this->queried_term,
				),
			);
		}

		return $this->query_args;
	}

	/**
	 * Sets the products query with all required arguments.
	 *
	 * @return WP_Query
	 * @since 1.0.0
	 * @access protected
	 */
	protected function set_query() {

		$this->set_term_to_query_args();

		$this->query = new WP_Query( $this->query_args );

		return $this->query;
	}

	/**
	 * Runs the products query and outputs the contents.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function run_loop() {
		while ( $this->query->have_posts() ) {
			$this->query->the_post();
			require SPARK_PRODUCTS_PATH . 'public/partials/product-item.php';
		}
	}

	/**
	 * Runs the query.
	 *
	 * If there is are no products to display, a message will be displayed
	 * and immediately exits the method.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function run_query() {

		if ( ! $this->query->have_posts() ) {

			_e( 'No products found.', 'spark-products' );

			return;
		}

		echo '<div class="spark-products">';

		$this->run_loop();

		echo '</div>';

		wp_reset_postdata();

	}
}
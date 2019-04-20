<?php

/**
 * Manages the retrieving of the target group and passing the correct to the products query.
 *
 * @since      1.0.0
 * @package    Spark_Products
 * @subpackage Spark_Products/includes
 */

class Spark_Products_Target_Group {

	/**
	 * Holds the target group value.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var $target_group
	 */
	protected $target_group;

	/**
	 * Holds the database entries for the plugin.
	 *
	 * All the data is stored under the 'spark-products-options' name in wp_options table.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var $target_group
	 */
	protected $db_options;

	/**
	 * Holds the 'target' url parameter, retrieved from the browser's address bar.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var $url_param
	 */
	protected $url_param = null;

	/**
	 * Holds the default term value, stored in plugin's options.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var $default_term
	 */
	protected $default_term = null;

	/**
	 * Spark_Products_Target_Group constructor.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		$this->db_options = get_option( 'spark-products-options' );
	}

	/**
	 * Sets the url parameter from the address bar in property, if one exists.
	 *
	 * @return string|null
	 * @since 1.0.0
	 * @access protected
	 */
	protected function set_url_param() {
		if ( isset( $_GET['target'] ) && ! empty( $_GET['target'] ) ) {
			$this->url_param = sanitize_key( $_GET['target'] );
		}

		return $this->url_param;
	}

	/**
	 * Checks if the current url in the address bar has a target parameter.
	 *
	 * @return bool
	 * @since 1.0.0
	 * @access protected
	 */
	protected function url_contains_term() {
		if ( isset( $_GET['target'] ) && ! empty( $_GET['target'] ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Sets the default term, that shall be use for the query.
	 *
	 * @return string
	 * @since 1.0.0
	 * @access protected
	 */
	protected function set_default_term() {

		if ( isset( $this->db_options['spark_products_target_groups'] ) ) {
			$this->default_term = $this->db_options['spark_products_target_groups'];
		}

		return $this->default_term;
	}

	/**
	 * Gets the default term.
	 *
	 * @return string|null
	 * @since 1.0.0
	 * @access protected
	 */
	protected function get_default_term() {

		$this->set_default_term();

		return $this->default_term;
	}

	/**
	 * Checks in the database if the url parameter is a valid taxonomy term.
	 *
	 * @return bool
	 * @since 1.0.0
	 * @access public
	 */
	public function is_valid_taxonomy_term() {

		$term = term_exists( $this->set_url_param(), 'target_groups' );

		if ( 0 !== $term && null !== $term ) {
			return true;
		}

		return false;
	}

	/**
	 * Sets the term that we will pass to the widget products query.
	 *
	 * @return string|null
	 * @since 1.0.0
	 * @access public
	 */
	protected function set_term() {

		if ( $this->url_contains_term() && $this->is_valid_taxonomy_term() ) {
			$this->target_group = sanitize_key( $_GET['target'] );
		} else {
			$this->target_group = $this->get_default_term();
		}

		return $this->target_group;
	}

	/**
	 * Gets the term that we will pass to the widget products query.
	 *
	 * @return mixed
	 * @since 1.0.0
	 * @access public
	 */
	public function get_term() {

		$this->set_term();

		return $this->target_group;
	}

}

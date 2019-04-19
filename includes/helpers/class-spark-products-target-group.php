<?php


class Spark_Products_Target_Group {

	protected $target_group;
	protected $db_options;
	protected $url_param = null;

	public function __construct() {
		$this->db_options = get_option( 'spark-products-options' );
	}

	public function set_url_param() {
		if ( isset( $_GET['target'] ) && ! empty( $_GET['target'] ) ) {
			$this->url_param = sanitize_key( $_GET['target'] );
		}

		return $this->url_param;
	}

	public function url_contains_term() {
		if ( isset( $_GET['target'] ) && ! empty( $_GET['target'] ) ) {
			return true;
		}

		return false;
	}

	public function get_default_term() {

		return $this->db_options['spark_products_target_groups'];
	}

	public function is_valid_taxonomy_term() {

		$term = term_exists( $this->set_url_param(), 'target_groups' );

		if ( 0 !== $term && null !== $term ) {
			return true;
		}

		return false;
	}

	public function set_term() {

		if ( $this->url_contains_term() && $this->is_valid_taxonomy_term() ) {
			$this->target_group = sanitize_key( $_GET['target'] );
		} else {
			$this->target_group = $this->get_default_term();
		}


		return $this->target_group;
	}

	public function get_term() {

		$this->set_term();

		return $this->target_group;
	}

}
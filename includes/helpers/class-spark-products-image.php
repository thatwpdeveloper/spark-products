<?php

/**
 * Manages the handling of image output.
 *
 * @since      1.0.0
 * @package    Spark_Products
 * @subpackage Spark_Products/includes
 */

class Spark_Products_Image {

	/**
	 * Returns the image that comes from an non-serialised post_meta field.
	 *
	 * @since 1.0.0
	 * @param $post_id
	 * @param $meta_key
	 * @param $alt_text
	 *
	 * @return string
	 */
	public static function from_post_meta( $post_id, $meta_key, $alt_text ) {
		$src = get_post_meta( $post_id, $meta_key, true );

		if ( empty( $src ) ) {
			$src = SPARK_PRODUCTS_URL . 'public/img/default-image.png';
		}

		$image = '<img src="' . esc_url( $src ) . '" alt="' . sanitize_text_field( $alt_text ) . '">';

		return $image;
	}
}
<?php

// TODO: Documentation!

class Spark_Products_Image {

	public static function from_post_meta( $post_id, $meta_key, $alt_text ) {
		$src = get_post_meta( $post_id, $meta_key, true );

		if ( empty( $src ) ) {
			$src = SPARK_PRODUCTS_URL . 'public/img/default-image.png';
		}

		$image = '<img src="' . esc_url( $src ) . '" alt="' . sanitize_text_field( $alt_text ) . '">';

		return $image;
	}
}
<?php

// TODO: Documentation!

class Spark_Products_Image {

	public static function post_meta( $post_id ) {
		$image = get_post_meta( get_the_ID(), 'spark_products_image', true );

		if ( empty( $image ) ) {
			$image = SPARK_PRODUCTS_URL . 'public/img/default-image.png';
		}

		return $image;
	}
}
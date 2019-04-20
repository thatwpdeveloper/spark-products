<?php

/**
 * Manages the handling of rating output.
 *
 * @since      1.0.0
 * @package    Spark_Products
 * @subpackage Spark_Products/includes
 */

class Spark_Products_Rating {

	/**
	 * Displays the rating in form of stars.
	 *
	 * If rating is 3, it will display 3 full stars and 2 empty stars.
	 *
	 * @since 1.0.0
	 * @param $post_id
	 * @param $meta_key
	 * @return string
	 */
	public static function star_rating( $post_id, $meta_key ) {

		$rating = (int) get_post_meta( $post_id, $meta_key, true );

		$stars = '';

		for ( $star_full = 0; $star_full < $rating; $star_full ++ ) {
			$stars .= '<i class="icon-star"></i>';
		}

		for ( $star_blank = 0; $star_blank < ( 5 - $rating ); $star_blank ++ ) {
			$stars .= '<i class="icon-star-empty"></i>';
		}

		return '<div class="star-rating">' . $stars . '</div>';
	}
}
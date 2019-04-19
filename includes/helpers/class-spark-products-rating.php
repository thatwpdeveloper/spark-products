<?php

// TODO: Documentation!
class Spark_Products_Rating {

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
<?php

// TODO: Documentation!
class Spark_Products_Rating {

	public static function star_rating( $post_id ) {

		$rating = (int) get_post_meta( get_the_ID(), 'spark_products_rating', true );

		$stars = '';

		for ( $star_full = 0; $star_full < $rating; $star_full ++ ) {
			$stars .= '<i class="icon-star"></i>';
		}

		for ( $star_blank; $star_blank < ( 5 - $rating ); $star_blank ++ ) {
			$stars .= '<i class="icon-star-empty"></i>';
		}

		return '<div class="star-rating">' . $stars . '</div>';
	}
}
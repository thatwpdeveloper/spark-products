<article>
    <a href="<?php echo get_permalink() ?>">
		<?php echo Spark_Products_Image::from_post_meta( get_the_ID(), 'spark_products_image', get_the_title() ); ?>
    </a>

    <h4><?php echo get_the_title(); ?></h4>
	<?php echo Spark_Products_Rating::star_rating( get_the_ID(), 'spark_products_rating' ); ?>
</article>
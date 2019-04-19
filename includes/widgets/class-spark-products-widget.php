<?php

// TODO: Documentation and refactor

final class Spark_Products_Widget extends WP_Widget {

	protected $query_args = array();
	protected $output = '';

	function __construct() {
		parent::__construct(
			'spark_products_widget',
			__( 'Spark Products Widget', 'spark_products' )
		);

		$this->set_query_args();
	}

// Creating widget front-end

	public function set_query_args() {
		$this->query_args = array(
			'post_type'      => 'spark_products',
			'posts_per_page' => 5,
			'meta_key'       => 'spark_products_rating',
			'meta_type'      => 'NUMERIC',
			'orderby'        => 'meta_value_num'

		);

		return $this->query_args;
	}

	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );

// before and after widget arguments are defined by themes
		$this->output .= $args['before_widget'];
		if ( ! empty( $title ) ) {
			$this->output .= $args['before_title'] . $title . $args['after_title'];
		}


		$target_group = new Spark_Products_Target_Group();
		$cookie = Spark_Products_Cookie::get_instance();

		$term = $target_group->get_term();


		if ( $cookie->get_cookie( 'spark_products_target_group' ) ) {
            $term = $cookie->get_cookie( 'spark_products_target_group' );
		}


		$this->query_args['tax_query'] = array(
			array(
				'taxonomy' => 'target_groups',
				'field'    => 'slug',
				'terms'    => $term,
			),
		);


		// This is where you run the code and display the output

		$spark_products_query = new WP_Query( $this->query_args );

		if ( $spark_products_query->have_posts() ) {
			$this->output .= '<ul class="spark-products">';
			while ( $spark_products_query->have_posts() ) {
				$spark_products_query->the_post();

				$this->output .= '<li>';
				$this->output .= '<a href="' . get_permalink() . '">';
				$this->output .= Spark_Products_Image::from_post_meta( get_the_ID(), 'spark_products_image', get_the_title() );
				$this->output .= '</a>';

				$this->output .= get_the_title();
				$this->output .= Spark_Products_Rating::star_rating( get_the_ID(), 'spark_products_rating' );
				$this->output .= '</li>';
			}
			$this->output .= '</ul>';

			/* Restore original Post Data */
			wp_reset_postdata();
		} else {
			$this->output .= __( 'No products found.', 'spark-products' );
		}


		$this->output .= $args['after_widget'];

		echo $this->output;
	}

// Widget Backend
	public function form( $instance ) {
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		} else {
			$title = __( 'New title', 'spark_products' );
		}
// Widget admin form
		?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
                   name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
                   value="<?php echo esc_attr( $title ); ?>"/>
        </p>
		<?php
	}

// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}
}
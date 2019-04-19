<?php

// TODO: Documentation and refactor

class Spark_Products_Widget extends WP_Widget {

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

	protected function set_query_args() {
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


// This is where you run the code and display the output


		$spark_products_query = new WP_Query( $this->query_args );

		if ( $spark_products_query->have_posts() ) {
			$this->output .= '<ul>';
			while ( $spark_products_query->have_posts() ) {
				$spark_products_query->the_post();

				$this->output .= '<li>';
				$this->output .= '<img src="' . Spark_Products_Image::post_meta( get_the_ID() ) . '" alt="' . get_the_title() . '">';
				$this->output .= get_the_title();
				$this->output .= get_post_meta( get_the_ID(), 'spark_products_rating', true );
				$this->output .= Spark_Products_Rating::star_rating( get_the_ID() );
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
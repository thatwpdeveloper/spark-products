<?php

/**
 * Manages the widget creation.
 *
 * @since      1.0.0
 * @package    Spark_Products
 * @subpackage Spark_Products/widgets
 */

final class Spark_Products_Widget extends WP_Widget {

	/**
	 * Holds the HTML output of the widget.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @type string
	 * @var $output
	 */
	protected $output = '';

	/**
	 * Spark_Products_Widget constructor.
	 */
	function __construct() {

		/**
		 * Calls the parent WP_Widget constructor.
		 */
		parent::__construct(
			'spark_products_widget',
			__( 'Spark Products Widget', 'spark_products' )
		);

	}

	/**
	 * Handles the widget front-end part.
	 *
	 * @param array $args
	 * @param array $instance
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );

		$this->output .= $args['before_widget'];

		if ( ! empty( $title ) ) {
			$this->output .= $args['before_title'] . $title . $args['after_title'];
		}

		$target_group = new Spark_Products_Target_Group();

		$cookie = Spark_Products_Cookie::get_instance();

		$term = $target_group->get_term();

		/**
		 * If cookie is set and the url fails to provide a valid target group to query against,
		 * then we will try to read the user's cookie file and get the target group from there.
		 */
		if ( $cookie->get_cookie( 'spark_products_target_group' ) && ! $target_group->is_valid_taxonomy_term() ) {
			$term = $cookie->get_cookie( 'spark_products_target_group' );
		}

		$products_query = new Spark_Product_Query( $term );

		/**
		 * Starting the object buffer to avoid output issues on the front-end.
		 */
		ob_start();

		$products_query->run_query();

		/**
		 * Gets the clean output and appends it to the widget HTML output.
		 */
		$this->output .= ob_get_clean();

		$this->output .= $args['after_widget'];

		echo $this->output;
	}

	/**
	 * Handles the widget backend part.
	 *
	 * @param array $instance
	 *
	 * @return string|void
	 * @since 1.0.0
	 * @access public
	 */
	public function form( $instance ) {

		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		} else {
			$title = __( 'New title', 'spark_products' );
		} ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
                   name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
                   value="<?php echo esc_attr( $title ); ?>"/>
        </p>
		<?php

	}

	/**
	 * Updates widget replacing old instances with new one.
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 *
	 * @return array
	 * @since 1.0.0
	 * @access public
	 */
	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}
}
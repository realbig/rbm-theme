<?php
/**
 * The theme's widgets.
 *
 * @since   1.0.0
 * @package RBMTheme
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

add_action( 'widgets_init', function () {
	register_widget( 'RBMThemeWidget_Testimonials' );
	register_widget( 'RBMThemeWidget_Image' );
} );

/**
 * Class RBMThemeWidget_Testimonials
 *
 * Widget for showing Testimonials.
 *
 * @since 1.0.0
 */
class RBMThemeWidget_Testimonials extends WP_Widget {

	public function __construct() {

		// Build the widget
		parent::__construct(
			'kidnichewidget_testimonials',
			'Testimonials',
			array(
				'description' => 'Shows a list of testimonials.',
			)
		);
	}

	public function widget( $args, $instance ) {

		echo $args['before_widget'];

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

		$count = isset( $instance['count'] ) && ! empty( $instance['count'] ) ? (int) $instance['count'] : 3;

		$testimonials = get_posts( array(
			'post_type' => 'testimonial',
			'numberposts' => $count,
		) );

		if ( ! empty( $testimonials ) ) {
			?>

			<div class="testimonials-container">

				<div class="testimonials-prev icon-circle-left" style="display: none;"></div>
				<div class="testimonials-next icon-circle-right" style="display: none;"></div>

				<ul class="testimonials" style="left: 0;">
					<?php
					global $post;
					$i = 0;
					foreach ( $testimonials as $post ) {
						setup_postdata( $post );
						$i++;

						$role = get_post_meta( get_the_ID(), '_testimonial_role', true );
						?>

						<li class="testimonial <?php echo $i === 1 ? 'active' : ''; ?>">

							<div class="testimonial-image">
								<?php the_post_thumbnail( 'thumbnail' ); ?>
							</div>

							<h4 class="testimonial-author">
								<?php the_title(); ?>

								<br/>

								<?php if ( $role ) : ?>
									<span class="testimonial-role">
										<?php echo $role; ?>
									</span>
								<?php endif; ?>
							</h4>

							<div class="testimonial-content">
								<span class="icon-quote icon-quotes-left"></span>
								<?php the_content(); ?>
							</div>

						</li>

						<?php
					}
					wp_reset_postdata();
					?>
				</ul>

			</div>

		<?php
		}
		echo $args['after_widget'];
	}

	public function form( $instance ) {

		$title = ! empty( $instance['title'] ) ? $instance['title'] : 'Testimonials';
		$count = ! empty( $instance['count'] ) ? $instance['count'] : 3;
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
			       name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
			       value="<?php echo esc_attr( $title ); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Count:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>"
			       name="<?php echo $this->get_field_name( 'count' ); ?>" type="text"
			       value="<?php echo esc_attr( $count ); ?>">
		</p>
	<?php
	}
}

/**
 * Class RBMThemeWidget_Image
 *
 * Widget for showing Images.
 *
 * @since 1.0.0
 */
class RBMThemeWidget_Image extends WP_Widget {

	public function __construct() {

		// Build the widget
		parent::__construct(
			'kidnichewidget_image',
			'Image',
			array(
				'description' => 'Shows an image.',
			)
		);
	}

	public function widget( $args, $instance ) {

		echo $args['before_widget'];

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

		$image_ID = isset( $instance['image'] ) && ! empty( $instance['image'] ) ? (int) $instance['image'] : false;
		$link = isset( $instance['link'] ) && ! empty( $instance['link'] ) ? $instance['link'] : false;

		if ( $image_ID !== false ) {
			echo $link !== false ? "<a href=\"$link\">" : '';
			echo wp_get_attachment_image( $image_ID, 'full' );
			echo $link !== false ? '</a>' : '';
		}

		echo $args['after_widget'];
	}

	public function form( $instance ) {

		$title = ! empty( $instance['title'] ) ? $instance['title'] : 'Testimonials';
		$image = ! empty( $instance['image'] ) ? $instance['image'] : false;
		$link = ! empty( $instance['link'] ) ? $instance['link'] : false;

		$image_preview = $image !== false ? wp_get_attachment_image_src( $image, 'full' ) : false;
		$image_preview = $image_preview !== false ? $image_preview[0] : '';
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
			       name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
			       value="<?php echo esc_attr( $title ); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'image' ); ?>">Image:</label>
			<br/>
			<img src="<?php echo $image_preview; ?>" class="image-preview" style="max-width: 100%; height: auto;" />
			<br/>
			<input type="button" class="button image-button" value="Choose / Upload Image" />

			<input class="image-id" id="<?php echo $this->get_field_id( 'image' ); ?>"
			       name="<?php echo $this->get_field_name( 'image' ); ?>" type="hidden"
			       value="<?php echo esc_attr( $image ); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'link' ); ?>">Link:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>"
			       name="<?php echo $this->get_field_name( 'link' ); ?>" type="text"
			       value="<?php echo esc_attr( $link ); ?>">
		</p>
	<?php
	}
}
<?php
/**
 * Feature post type.
 *
 * @since   0.1.0
 * @package RBMTheme
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

add_action( 'init', function () {
	easy_register_post_type( 'testimonial', 'Testimonial', 'Testimonials', array(
		'menu_icon' => 'dashicons-testimonial',
		'supports'  => array( 'title', 'editor', 'thumbnail' ),
		'public'    => false,
	) );
} );

add_action( 'add_meta_boxes', function () {

	add_meta_box(
		'website',
		'Website',
		'_rbm_testimonial_website',
		'testimonial'
	);
} );

/**
 * The form callback for the testimonial website.
 *
 * @since  0.1.0
 * @access Private.
 *
 * @param object $post The current post object.
 */
function _rbm_testimonial_website( $post ) {

	wp_nonce_field( __FILE__, 'testimonial_website_nonce' );

	$website = get_post_meta( $post->ID, '_testimonial_website', true );
	?>
	<p>
		<label>
			Website:
			<br/>
			<input type="text" class="widefat" name="_testimonial_website"
			       value="<?php echo $website; ?>"/>
		</label>
	</p>
<?php
}

add_action( 'save_post', function ( $post_ID ) {

	if ( ! isset( $_POST['testimonial_website_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $_POST['testimonial_website_nonce'], __FILE__ ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_page', $post_ID ) ) {
		return;
	}

	$options = array(
		'_testimonial_website',
	);

	foreach ( $options as $option ) {

		if ( ! isset( $_POST[ $option ] ) || empty( $_POST[ $option ] ) ) {
			delete_post_meta( $post_ID, $option );
		}

		update_post_meta( $post_ID, $option, $_POST[ $option ] );
	}
} );
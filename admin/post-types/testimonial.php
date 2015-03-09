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

//	add_meta_box(
//		'images',
//		'Images',
//		'_rbm_testimonial_images',
//		'testimonial'
//	);
} );

/**
 * The form callback for the testimonial images.
 *
 * @since  0.1.0
 * @access Private.
 *
 * @param object $post The current post object.
 */
function _rbm_testimonial_images( $post ) {

	wp_nonce_field( __FILE__, 'testimonial_images_nonce' );

	$image_full = get_post_meta( $post->ID, '_testimonial_image_full', true );
	$image_full_preview = wp_get_attachment_image_src( $image_full, 'medium' );
	$image_full_preview = $image_full_preview !== false ? $image_full_preview[0] : '';

	$image_mobile = get_post_meta( $post->ID, '_testimonial_image_mobile', true );
	$image_mobile_preview = wp_get_attachment_image_src( $image_mobile, 'medium' );
	$image_mobile_preview = $image_mobile_preview !== false ? $image_mobile_preview[0] : '';
	?>
	<p>
		<label>
			Full Size:
			<br/>
			<img class="image-preview" style="max-width: 100%; max-height: 300px;"
			     src="<?php echo $image_full_preview; ?>"/>
			<input type="hidden" class="image-id" name="_testimonial_image_full"
			       value="<?php echo $image_full; ?>"/>
			<br/>
			<input type="button" class="button image-button"
			       value="Choose or Upload An Image"/>
		</label>
	</p>

	<p>
		<label>
			Mobile Size:
			<br/>
			<img class="image-preview" style="max-width: 100%; max-height: 300px;"
			     src="<?php echo $image_mobile_preview; ?>"/>
			<input type="hidden" class="image-id" name="_testimonial_image_mobile"
			       value="<?php echo $image_mobile; ?>"/>
			<br/>
			<input type="button" class="button image-button"
			       value="Choose or Upload An Image"/>
		</label>
	</p>
<?php
}

add_action( 'save_post', function ( $post_ID ) {

//	if ( ! isset( $_POST['testimonial_images_nonce'] ) ) {
//		return;
//	}
//
//	if ( ! wp_verify_nonce( $_POST['testimonial_images_nonce'], __FILE__ ) ) {
//		return;
//	}
//
//	if ( defined( 'DOING_AUTOSAVE' ) ) {
//		return;
//	}
//
//	if ( ! current_user_can( 'edit_page', $post_ID ) ) {
//		return;
//	}
//
//	$options = array(
//		'_testimonial_image_full',
//		'_testimonial_image_mobile',
//	);
//
//	foreach ( $options as $option ) {
//
//		if ( ! isset( $_POST[ $option ] ) || empty( $_POST[ $option ] ) ) {
//			delete_post_meta( $post_ID, $option );
//		}
//
//		update_post_meta( $post_ID, $option, $_POST[ $option ] );
//	}
} );
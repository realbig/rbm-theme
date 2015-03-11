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
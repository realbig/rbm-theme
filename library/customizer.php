<?php
/**
 * Customizer Additions
 *
 * @since   {{VERSION}}
 * @package RBMTheme
 * @subpackage RBMTheme/library
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

add_action( 'customize_register', function( $wp_customize ) {

    $wp_customize->add_section( 'rbm_customizer_section' , array(
        'title' => __( 'RBM Settings', 'rbm-theme' ),
        'priority' => 30,
    ) );

    $forms = array();

    if ( class_exists( 'RGFormsModel' ) ) {
        $forms = wp_list_pluck( RGFormsModel::get_forms( null, 'title' ), 'title', 'id' );
    }

    $wp_customize->add_setting( 'rbm_overlay_form', array(
        'default' => '',
        'transport' => 'refresh',
    ) );
    $wp_customize->add_control( 'rbm_overlay_form', array(
        'type' => 'select',
        'label' => __( 'Overlay Form', 'rbm-theme' ),
        'section' => 'rbm_customizer_section',
        'settings' => 'rbm_overlay_form',
        'choices' => array( '' => __( 'Select a Form', 'rbm-theme' ) ) + $forms,
    ) );

    $testimonials = array();

    $testimonials_query = new WP_Query( array(
        'post_type' => 'rbm-testimonial',
        'posts_per_page' => -1,
        'fields' => 'ids',
        'orderby' => 'title',
        'order' => 'ASC',
    ) );

    if ( $testimonials_query->have_posts() ) {

        foreach ( $testimonials_query->posts as $post_id ) {
            $testimonials[ $post_id ] = get_the_title( $post_id );
        }

    }

    $wp_customize->add_setting( 'rbm_overlay_testimonial', array(
        'default' => '',
        'transport' => 'refresh',
    ) );
    $wp_customize->add_control( 'rbm_overlay_testimonial', array(
        'type' => 'select',
        'label' => __( 'Overlay Testimonal', 'rbm-theme' ),
        'section' => 'rbm_customizer_section',
        'settings' => 'rbm_overlay_testimonial',
        'choices' => array( '' => __( 'Select a Testimonial', 'rbm-theme' ) ) + $testimonials,
    ) );

} );
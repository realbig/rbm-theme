<?php
/**
 * The theme's functions file that loads on EVERY page, used for uniform functionality.
 *
 * @since   0.1.0
 * @package RBMTheme
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

add_shortcode( 'section', '_rbm_sc_section' );
add_shortcode( 'section_page_content', '_rbm_sc_section_page_content' );
add_shortcode( 'section_content', '_rbm_sc_content' );
add_shortcode( 'staff', '_rbm_sc_staff' );
add_shortcode( 'button', '_rbm_sc_button' );

function _rbm_sc_section( $atts = array(), $content = '' ) {

	$atts = shortcode_atts( array(
		'color'   => 'blue',
		'classes' => '',
		'id'      => 'section',
		'title'   => 'Section',
		'summary' => false,
		'button'  => false,
	), $atts );

	$classes   = array();
	$classes[] = $atts['color'];
	$classes[] = $atts['classes'];
	$classes   = array_filter( $classes );

	$output = '';
	$output .= '<section id="' . $atts['id'] . '" class="section ' . implode( $classes ) . ' columns small-12">';

	$output .= '<div class="section-content">';

	$output .= rbm_get_section_title( $atts['title'], $atts['id'] );

	if ( $atts['summary'] !== false ) {
		$output .= '<div class="section-summary">';
		$output .= $atts['summary'];
		$output .= '</div>';
	}

	if ( $atts['button'] !== false ) {
		$output .= '<a href="#" class="button section-cta">';
		$output .= $atts['button_text'];
		$output .= '</a>';
	}

	$output .= do_shortcode( $content );

	$output .= '</div>';

	//	$output .= '<a href="#" class="scroll-down no-effect"><span class="icon-circle-down"></span></a>';

	$output .= '</section>';

	return $output;
}

function _rbm_sc_section_page_content( $atts, $content = '' ) {

	global $rbm_sectionalized_content;
	$rbm_sectionalized_content = $content;

	return '';
}

function _rbm_sc_content( $atts, $content ) {

	return '<div class="row unexpand text-left"><div class="columns small-12">' . do_shortcode( $content ) . '</div></div>';
}

function _rbm_sc_staff( $atts, $content ) {

	$staff = get_posts( array(
		'post_type'   => 'staff',
		'numberposts' => - 1,
	) );

	$output = '';

	if ( ! empty( $staff ) ) {

		global $post;

		$output .= '<ul class="overlay-grid small-block-grid-' . count( $staff ) . '">';

		foreach ( $staff as $post ) {
			setup_postdata( $post );

			$image = get_avatar( get_the_author_meta( 'ID' ), 800 );

			$extra = '<p class="staff-role">';
			$extra .= get_field( 'staff_title' );
			$extra .= '</p>';

			$output .= rbm_get_overlay_grid_item( false, $image, $extra );
		}

		$output .= '</ul>';

		wp_reset_postdata();
	}

	return $output;
}

function _rbm_sc_button( $atts = array(), $content = '' ) {

	$atts = shortcode_atts( array(
		'size' => '',
		'link' => '#',
		'classes' => '',
	), $atts );

	$classes = array();
	$classes[] = 'button';
	$classes[] = $atts['size'];
	$classes[] = $atts['classes'];
	$classes = array_filter( $classes );

	$output = '<a href="' . $atts['link'] . '" class="' . implode( ' ', $classes ) . '">';
	$output .= do_shortcode( $content );
	$output .= '</a>';

	return $output;
}
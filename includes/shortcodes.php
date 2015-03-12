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
add_shortcode( 'section_button', '_rbm_sc_section_button' );
add_shortcode( 'section_summary', '_rbm_sc_section_summary' );
add_shortcode( 'content_width', '_rbm_sc_column_width' );
add_shortcode( 'staff_list', '_rbm_sc_staff_list' );
add_shortcode( 'button', '_rbm_sc_button' );
add_shortcode( 'page_title', '_rbm_sc_page_title' );

function _rbm_sc_section( $atts = array(), $content = '' ) {

	$atts = shortcode_atts( array(
		'color'   => 'blue',
		'classes' => '',
		'id'      => 'section',
		'title'   => 'Section',
		'summary' => false,
		'show_scroll_nag' => 'no',
		'full_width' => 'no',
	), $atts );

	$classes   = array();
	$classes[] = $atts['color'];
	$classes[] = $atts['classes'];
	$classes   = array_filter( $classes );

	$output = '';
	$output .= '<section id="' . $atts['id'] . '" class="section ' . implode( $classes ) . ' columns small-12">';

	$output .= '<div class="section-content expand">';

	$output .= rbm_get_section_title( $atts['title'], $atts['id'] );

	if ( $atts['full_width'] == 'no' ) {
		$output .= '<div class="row unexpand text-left">';
		$output .= '<div class="columns small-12">';
	}

	$output .= do_shortcode( $content );

	if ( $atts['full_width'] == 'no' ) {
		$output .= '</div>';
		$output .= '</div>';
	}

	if ( $atts['show_scroll_nag'] == 'yes' ) {
		$output .= '<a href="#" class="scroll-down no-effect"><span class="icon-circle-down"></span></a>';
	}

	$output .= '</section>';

	return $output;
}

function _rbm_sc_section_button( $atts = array(), $content = '' ) {

	$atts = shortcode_atts( array(
		'link' => '#'
	), $atts);

	$output = '<p class="text-center">';
	$output .= "<a href=\"$atts[link]\" class=\"button section-cta\">";
	$output .= $content;
	$output .= '</a>';
	$output .= '</p>';

	return $output;
}

function _rbm_sc_section_summary( $atts = array(), $content = '' ) {

	$output = '<div class="section-summary text-center">';
	$output .= do_shortcode( $content );
	$output .= '</div>';

	return $output;

}

function _rbm_sc_column_width( $atts, $content = '' ) {
	return '<div class="row unexpand text-left"><div class="columns small-12">' . do_shortcode( $content ) . '</div></div>';
}

function _rbm_sc_staff_list( $atts, $content ) {

	$staff = get_posts( array(
		'post_type'   => 'staff',
		'numberposts' => - 1,
	) );

	$output = '';

	if ( ! empty( $staff ) ) {

		global $post;

		$output .= '<ul class="overlay-grid small-block-grid-1 medium-block-grid-' . count( $staff ) . '">';

		foreach ( $staff as $post ) {
			setup_postdata( $post );

			$image = get_avatar( get_the_author_meta( 'ID' ), 800 );

			$extra = '<p class="staff-role">';
			$extra .= get_field( 'staff_title' );
			$extra .= '</p>';

			$output .= rbm_get_overlay_grid_item( array(
				'image' => $image,
				'extra' => $extra,
			) );
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

function _rbm_sc_page_title( $atts = array(), $content = '' ) {

	global $post;

	return '<h1 class="page-title">' . get_the_title( $post->ID ) . '</h1>';
}
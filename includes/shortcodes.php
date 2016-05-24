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

        // We're going to build DOM in an Object Buffer, which helps keep things more readable.
        // ...except for the row creation, unfortunately
        ob_start();
        
        ?>

        <svg class="gear-svgdefs" viewBox="0 0 227.37129 225.08964">
            <defs>
                <clipPath id="rbm-gear">
                    <path fill="#FFFFFF" d="m 100.485,0 c -3.194505,0.004 -5.576375,3.992373 -6.392465,8.778518 l -2.75343,15.71625 c -8.57996,2.222535 -16.89505,5.693805 -24.692,10.406603 l -13.26058,-9.300586 c -4.01795,-2.739657 -8.4931,-3.945703 -10.73918,-1.693829 L 23.957226,42.539064 c -2.24608,2.24454 -1.09574,6.7697 1.705429,10.71598 l 9.323789,13.23738 c -4.70905,7.7642 -8.198808,16.066 -10.437539,24.62238 l -15.735589,2.7457 C 4.019716,94.755384 0,97.050804 0,100.24523 c 0,8.19973 0,16.39946 0,24.59918 0,3.19444 4.019716,5.48985 8.813316,6.38473 l 15.735589,2.7457 c 2.238731,8.55639 5.728489,16.85819 10.437539,24.62238 l -9.323789,13.23353 c -2.801169,3.94627 -3.951509,8.4753 -1.705429,10.71983 l 18.690119,18.63211 c 2.24608,2.25187 6.72123,1.04583 10.73918,-1.69381 l 13.26058,-9.3006 c 7.79695,4.7128 16.11204,8.18408 24.692,10.40661 l 2.75343,15.71238 c 0.81609,4.78616 3.19796,8.77871 6.392465,8.78237 l 26.40516,-0.004 c 3.20554,0.0178 5.5071,-4.00684 6.40405,-8.77464 l 2.63356,-15.04723 c 9.03211,-2.06116 17.77883,-5.47945 25.9875,-10.23258 l 12.08496,8.45755 c 3.94075,2.79833 8.48575,3.94956 10.73918,1.69769 l 18.67852,-18.63212 c 2.25344,-2.25187 1.03713,-6.71488 -1.70157,-10.71984 l -7.90067,-11.22248 c 5.43692,-8.47937 9.32137,-17.64751 11.72918,-27.12445 l 13.0363,-2.25844 c 4.77889,-0.81053 8.79746,-3.19436 8.79011,-6.39246 0,-8.19457 0,-16.38914 0,-24.58371 0.008,-3.198096 -4.01121,-5.581926 -8.79011,-6.392466 l -13.0363,-2.25843 c -2.40782,-9.47694 -6.29226,-18.64895 -11.72918,-27.12832 l 7.90067,-11.22258 c 2.7387,-4.00496 3.95501,-8.46797 1.70157,-10.71984 L 184.73941,23.903089 c -2.25342,-2.251874 -6.79843,-1.100642 -10.73917,1.697696 l -12.08497,8.457538 c -8.20866,-4.753141 -16.95538,-8.171415 -25.9875,-10.232577 L 133.29421,8.778518 c -0.89695,-4.76781 -3.19851,-8.792985 -6.40405,-8.77465 z"
                    />
                </clipPath>
                <clipPath id="rbm-gear-tilt">
                    <path fill="#FFFFFF" transform="translate( 65, -40 ) rotate(27.5)" d="m 100.485,0 c -3.194505,0.004 -5.576375,3.992373 -6.392465,8.778518 l -2.75343,15.71625 c -8.57996,2.222535 -16.89505,5.693805 -24.692,10.406603 l -13.26058,-9.300586 c -4.01795,-2.739657 -8.4931,-3.945703 -10.73918,-1.693829 L 23.957226,42.539064 c -2.24608,2.24454 -1.09574,6.7697 1.705429,10.71598 l 9.323789,13.23738 c -4.70905,7.7642 -8.198808,16.066 -10.437539,24.62238 l -15.735589,2.7457 C 4.019716,94.755384 0,97.050804 0,100.24523 c 0,8.19973 0,16.39946 0,24.59918 0,3.19444 4.019716,5.48985 8.813316,6.38473 l 15.735589,2.7457 c 2.238731,8.55639 5.728489,16.85819 10.437539,24.62238 l -9.323789,13.23353 c -2.801169,3.94627 -3.951509,8.4753 -1.705429,10.71983 l 18.690119,18.63211 c 2.24608,2.25187 6.72123,1.04583 10.73918,-1.69381 l 13.26058,-9.3006 c 7.79695,4.7128 16.11204,8.18408 24.692,10.40661 l 2.75343,15.71238 c 0.81609,4.78616 3.19796,8.77871 6.392465,8.78237 l 26.40516,-0.004 c 3.20554,0.0178 5.5071,-4.00684 6.40405,-8.77464 l 2.63356,-15.04723 c 9.03211,-2.06116 17.77883,-5.47945 25.9875,-10.23258 l 12.08496,8.45755 c 3.94075,2.79833 8.48575,3.94956 10.73918,1.69769 l 18.67852,-18.63212 c 2.25344,-2.25187 1.03713,-6.71488 -1.70157,-10.71984 l -7.90067,-11.22248 c 5.43692,-8.47937 9.32137,-17.64751 11.72918,-27.12445 l 13.0363,-2.25844 c 4.77889,-0.81053 8.79746,-3.19436 8.79011,-6.39246 0,-8.19457 0,-16.38914 0,-24.58371 0.008,-3.198096 -4.01121,-5.581926 -8.79011,-6.392466 l -13.0363,-2.25843 c -2.40782,-9.47694 -6.29226,-18.64895 -11.72918,-27.12832 l 7.90067,-11.22258 c 2.7387,-4.00496 3.95501,-8.46797 1.70157,-10.71984 L 184.73941,23.903089 c -2.25342,-2.251874 -6.79843,-1.100642 -10.73917,1.697696 l -12.08497,8.457538 c -8.20866,-4.753141 -16.95538,-8.171415 -25.9875,-10.232577 L 133.29421,8.778518 c -0.89695,-4.76781 -3.19851,-8.792985 -6.40405,-8.77465 z"
                    />
                </clipPath>
            </defs>
        </svg>

        <div class="staff-list">

		<?php

        // Set proper column classes
        // Row Maximum is used to skip to the next row. For 5+ Staff, the Even rows are $row_maximum - 1 to offset nicely
        
        $row_maximum = 0;
        $even_row = false;
        
        if ( ( count( $staff ) == 2 ) || ( count( $staff ) == 4 ) ) :
            $column_class = 'medium-6';
            $row_maximum = 2;
        elseif ( count( $staff ) == 1 ) :
            $column_class = 'medium-12';
        else : 
            $column_class = 'medium-4';
            $row_maximum = 3;
        endif;
        
        // Not 0-indexing since we need its relation to $row_maximum
        $index = 1;
        
        foreach ( $staff as $post ) :
			setup_postdata( $post );
        
            if ( $index == 1 ) : ?>
                <div class="row<?php echo ( $even_row === true ) ? ' gear-shift' : ''; ?>">
        
            <?php endif;

			$image = get_avatar_url( get_the_author_meta( 'ID' ), array( 'size' => 800 ) );
        
			$extra = get_field( 'staff_title' );

			echo rbm_get_overlay_grid_item( array(
				'image' => $image,
				'extra' => $extra,
                'post' => $post,
                'column_class' => $column_class,
                'even_row' => $even_row,
                'even_row_column_class' => 'medium-6',
			) );
        
            // If we've reached the end of an odd or even row
            if ( ( $index == $row_maximum ) || 
                ( ( $even_row === true ) && ( $index == ( $row_maximum - 1 ) ) && ( count( $staff ) !== 4 ) ) ) : ?>
                </div>
            <?php
                // Reset for new row
                $index = 0;
        
                // Toggle Even/Odd Row
                if ( $even_row ) :
                    $even_row = false;
                else : 
                    $even_row = true;
                endif;
        
            endif;
        
            $index++;
        
		endforeach; 
        
        // Ensure the row gets closed out correctly after the loop
        if ( ( count( $staff ) == 1 ) || 
            ( ( $even_row === true ) && ( $index % ( $row_maximum - 1 ) == 0 ) ) ||
            ( ( count( $staff ) % $row_maximum ) == 0 ) ) : ?>
            </div>
        <?php endif; ?>
            
        </div> <!-- end .staff-list -->
        
        <?php
        // Everything gets assigned to $output at once. Much cleaner.
        $output = ob_get_contents();
        ob_end_clean();

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
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

        <svg class="gear-svgdefs">
            <defs>
                <clipPath id="rbm-gear">
                    <path fill="#FFFFFF" d="m 152.25,0 c -4.84016,0.006 -8.44905,6.04905 -9.68555,13.300785 l -4.17187,23.8125 c -12.99993,3.367476 -25.59855,8.626977 -37.41211,15.76758 L 80.888671,38.789067 C 74.800873,34.638072 68.020342,32.81073 64.617187,36.22266 L 36.298828,64.453131 c -3.403152,3.400818 -1.660212,10.257111 2.583984,16.236327 L 53.009764,100.7461 C 45.87484,112.51004 40.587328,125.08852 37.195312,138.05274 L 13.35351,142.21289 C 6.09048,143.56877 0,147.04667 0,151.88672 c 0,12.42383 0,24.84766 0,37.27149 0,4.84005 6.09048,8.31794 13.35351,9.67383 l 23.841802,4.16015 c 3.392016,12.96423 8.679528,25.54271 15.814452,37.30664 l -14.126952,20.05079 c -4.244196,5.97921 -5.987136,12.84137 -2.583984,16.24218 l 28.318359,28.23046 c 3.403155,3.41193 10.183686,1.5846 16.271484,-2.56638 l 20.091799,-14.09181 c 11.81356,7.1406 24.41218,12.40011 37.41211,15.76758 l 4.17187,23.80665 c 1.2365,7.25175 4.84539,13.30107 9.68555,13.30662 l 40.00781,-0.006 c 4.85688,0.027 8.34409,-6.07098 9.70313,-13.29492 l 3.99023,-22.79883 c 13.68502,-3.12297 26.93762,-8.3022 39.375,-15.50391 l 18.31055,12.81447 c 5.97083,4.2399 12.85719,5.98419 16.27148,2.57226 l 28.3008,-28.23048 c 3.4143,-3.41193 1.5714,-10.17406 -2.57814,-16.24219 l -11.97071,-17.00375 c 8.23775,-12.84753 14.12327,-26.73866 17.77148,-41.09766 l 19.75197,-3.42187 c 7.24074,-1.22808 13.32948,-4.83994 13.31835,-9.68555 0,-12.41602 0,-24.83203 0,-37.24805 0.012,-4.8456 -6.07761,-8.45747 -13.31835,-9.68555 l -19.75197,-3.42187 c -3.64821,-14.359 -9.53373,-28.25598 -17.77148,-41.103516 L 305.63086,80.683599 C 309.7804,74.615475 311.6233,67.85334 308.209,64.44141 L 279.9082,36.216801 c -3.41429,-3.41193 -10.30065,-1.66764 -16.27148,2.572266 l -18.31055,12.814452 c -12.43738,-7.201728 -25.68998,-12.380931 -39.375,-15.503904 l -3.99023,-22.79883 C 200.6019,6.07683 197.11469,-0.02192 192.25781,0.00586 Z"
                    />
                </clipPath>
                <clipPath id="rbm-gear-tilt">
                    <path fill="#FFFFFF" transform="translate( 95, -60 ) rotate(27.5)" d="m 152.25,0 c -4.84016,0.006 -8.44905,6.04905 -9.68555,13.300785 l -4.17187,23.8125 c -12.99993,3.367476 -25.59855,8.626977 -37.41211,15.76758 L 80.888671,38.789067 C 74.800873,34.638072 68.020342,32.81073 64.617187,36.22266 L 36.298828,64.453131 c -3.403152,3.400818 -1.660212,10.257111 2.583984,16.236327 L 53.009764,100.7461 C 45.87484,112.51004 40.587328,125.08852 37.195312,138.05274 L 13.35351,142.21289 C 6.09048,143.56877 0,147.04667 0,151.88672 c 0,12.42383 0,24.84766 0,37.27149 0,4.84005 6.09048,8.31794 13.35351,9.67383 l 23.841802,4.16015 c 3.392016,12.96423 8.679528,25.54271 15.814452,37.30664 l -14.126952,20.05079 c -4.244196,5.97921 -5.987136,12.84137 -2.583984,16.24218 l 28.318359,28.23046 c 3.403155,3.41193 10.183686,1.5846 16.271484,-2.56638 l 20.091799,-14.09181 c 11.81356,7.1406 24.41218,12.40011 37.41211,15.76758 l 4.17187,23.80665 c 1.2365,7.25175 4.84539,13.30107 9.68555,13.30662 l 40.00781,-0.006 c 4.85688,0.027 8.34409,-6.07098 9.70313,-13.29492 l 3.99023,-22.79883 c 13.68502,-3.12297 26.93762,-8.3022 39.375,-15.50391 l 18.31055,12.81447 c 5.97083,4.2399 12.85719,5.98419 16.27148,2.57226 l 28.3008,-28.23048 c 3.4143,-3.41193 1.5714,-10.17406 -2.57814,-16.24219 l -11.97071,-17.00375 c 8.23775,-12.84753 14.12327,-26.73866 17.77148,-41.09766 l 19.75197,-3.42187 c 7.24074,-1.22808 13.32948,-4.83994 13.31835,-9.68555 0,-12.41602 0,-24.83203 0,-37.24805 0.012,-4.8456 -6.07761,-8.45747 -13.31835,-9.68555 l -19.75197,-3.42187 c -3.64821,-14.359 -9.53373,-28.25598 -17.77148,-41.103516 L 305.63086,80.683599 C 309.7804,74.615475 311.6233,67.85334 308.209,64.44141 L 279.9082,36.216801 c -3.41429,-3.41193 -10.30065,-1.66764 -16.27148,2.572266 l -18.31055,12.814452 c -12.43738,-7.201728 -25.68998,-12.380931 -39.375,-15.503904 l -3.99023,-22.79883 C 200.6019,6.07683 197.11469,-0.02192 192.25781,0.00586 Z"
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

			$extra = '<p class="staff-role">';
			$extra .= get_field( 'staff_title' );
			$extra .= '</p>';

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
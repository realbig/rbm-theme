<?php
/**
 * Register widget areas
 *
 * @package RBMTheme
 * @since FoundationPress 1.0.0
 */

if ( ! function_exists( 'foundationpress_sidebar_widgets' ) ) :
function foundationpress_sidebar_widgets() {
	register_sidebar(array(
		'id' => 'sidebar-widgets',
		'name' => __( 'Sidebar widgets', 'real-big-marketing' ),
		'description' => __( 'Drag widgets to this sidebar container.', 'real-big-marketing' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h6>',
		'after_title' => '</h6>',
	));
	
}

add_action( 'widgets_init', 'foundationpress_sidebar_widgets' );
endif;

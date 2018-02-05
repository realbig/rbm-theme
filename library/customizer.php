<?php
/**
 * Adds Customizer Functionality
 * 
 * @since   {{VERSION}}
 * @package RBMTheme
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
    die;
}

/**
 * Adds custom Customizer Controls.
 *
 * @since 1.0.0
 */
add_action( 'customize_register', function( $wp_customize ) {
    
    // General Theme Options
    $wp_customize->add_section( 'rbm_theme_customizer_section' , array(
            'title'      => __( 'RBM Theme Settings', 'real-big-marketing' ),
            'priority'   => 30,
        ) 
    );
    
    $wp_customize->add_setting( 'rbm_theme_footer_columns', array(
            'default'     => 4,
            'transport'   => 'refresh',
        )
    );
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'rbm_theme_footer_columns', array(
        'type' => 'number',
        'label'        => __( 'Footer Number of Columns/Widget Areas', 'real-big-marketing' ),
        'section'    => 'rbm_theme_customizer_section',
        'settings'   => 'rbm_theme_footer_columns',
    ) ) );
    
} );
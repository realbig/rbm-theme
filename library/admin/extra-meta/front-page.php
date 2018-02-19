<?php
/**
 * Home extra meta.
 *
 * @since   {{VERSION}}
 * @package RBMTheme
 * @subpackage  RBMTheme/library/admin/extra-meta
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

add_action( 'init', 'rbm_theme_remove_home_supports' );
add_action( 'do_meta_boxes', 'rbm_theme_remove_home_metaboxes' );
add_action( 'add_meta_boxes', 'rbm_theme_add_home_metaboxes' );

/**
 * Determine if we're editing the Home Page
 * 
 * @since       {{VERSION}}
 * @return      boolean Whether we're editing the Home Page or not
 */
function rbm_theme_is_editing_home() {
    
    if ( is_admin() && 
        isset( $_REQUEST['post'] ) && 
        $_REQUEST['post'] == get_option( 'page_on_front' ) ) {
        return true;
    }
    
    return false;
    
}

/**
 * Remove Supports from the Home Page
 * 
 * @since       {{VERSION}}
 * @return      void
 */
function rbm_theme_remove_home_supports() {
    
    if ( rbm_theme_is_editing_home() ) {

        remove_post_type_support( 'page', 'thumbnail' );
        
    }
    
}

/**
 * Needs to be called at do_meta_boxes since it is created at a different time than Supports Metaboxes
 * 
 * @since       {{VERSION}}
 * @return      void
 */
function rbm_theme_remove_home_metaboxes() {
    
    if ( rbm_theme_is_editing_home() ) {
    
        // "Attributes" Meta Box
        remove_meta_box( 'pageparentdiv', 'page', 'side' );
        
    }
    
}

/**
 * Create Metaboxes for the Home Page
 * 
 * @since       {{VERSION}}
 * @return      void
 */
function rbm_theme_add_home_metaboxes() {
    
    if ( rbm_theme_is_editing_home() ) {
		
		add_meta_box(
            'rbm-theme-home-case-studies',
            __( 'Case Studies', 'rbm-theme' ),
            'rbm_theme_home_case_studies_metabox_content',
            'page',
            'normal'
        );
        
    }
    
}

/**
 * Put fields in the Case Studies Metabox
 * 
 * @since       {{VERSION}}
 * @return      void
 */
function rbm_theme_home_case_studies_metabox_content() {
	
	rbm_theme_do_field_textarea( array(
        'name' => 'case_studies_header',
        'wysiwyg' => true,
        'group' => 'rbm_theme_home_case_studies',
    ) );
    
    rbm_theme_init_field_group( 'rbm_theme_home_case_studies' );
    
}
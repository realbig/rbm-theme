<?php
/**
 * Author: Ole Fredrik Lie
 * URL: http://olefredrik.com
 *
 * FoundationPress functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @package RBMTheme
 * @since FoundationPress 1.0.0
 */

$theme_header = wp_get_theme();

define( 'THEME_VER', $theme_header->get( 'Version' ) );
define( 'THEME_URL', get_stylesheet_directory_uri() );
define( 'THEME_DIR', get_stylesheet_directory() );

/** Various clean up functions */
require_once( 'library/cleanup.php' );

/** Required for Foundation to work properly */
require_once( 'library/foundation.php' );

/** Format comments */
require_once( 'library/class-foundationpress-comments.php' );

/** Register all navigation menus */
require_once( 'library/navigation.php' );

/** Add menu walkers for top-bar and off-canvas */
require_once( 'library/class-foundationpress-top-bar-walker.php' );
require_once( 'library/class-foundationpress-mobile-walker.php' );

/** Create widget areas in sidebar and footer */
require_once( 'library/widget-areas.php' );

/** Return entry meta information for posts */
require_once( 'library/entry-meta.php' );

/** Enqueue scripts */
require_once( 'library/enqueue-scripts.php' );

/** Add theme support */
require_once( 'library/theme-support.php' );

/** Add Nav Options to Customer */
require_once( 'library/custom-nav.php' );

/** Change WP's sticky post class */
require_once( 'library/sticky-posts.php' );

/** Configure responsive image sizes */
require_once( 'library/responsive-images.php' );

/** If your site requires protocol relative url's for theme assets, uncomment the line below */
// require_once( 'library/class-foundationpress-protocol-relative-theme-assets.php' );

global $rbm_theme_field_helpers;

require_once( 'library/rbm-field-helpers/rbm-field-helpers.php' );
$rbm_theme_field_helpers = new RBM_FieldHelpers( array(
    'ID'   => 'rbm_theme', // Your Theme/Plugin uses this to differentiate its instance of RBM FH from others when saving/grabbing data
    'l10n' => array(
        'field_table'    => array(
            'delete_row'    => __( 'Delete Row', 'real-big-marketing' ),
            'delete_column' => __( 'Delete Column', 'real-big-marketing' ),
        ),
        'field_select'   => array(
            'no_options'       => __( 'No select options.', 'real-big-marketing' ),
            'error_loading'    => __( 'The results could not be loaded', 'real-big-marketing' ),
            /* translators: %d is number of characters over input limit */
            'input_too_long'   => __( 'Please delete %d character(s)', 'real-big-marketing' ),
            /* translators: %d is number of characters under input limit */
            'input_too_short'  => __( 'Please enter %d or more characters', 'real-big-marketing' ),
            'loading_more'     => __( 'Loading more results...', 'real-big-marketing' ),
            /* translators: %d is maximum number items selectable */
            'maximum_selected' => __( 'You can only select %d item(s)', 'real-big-marketing' ),
            'no_results'       => __( 'No results found', 'real-big-marketing' ),
            'searching'        => __( 'Searching...', 'real-big-marketing' ),
        ),
        'field_repeater' => array(
            'collapsable_title' => __( 'New Row', 'real-big-marketing' ),
            'confirm_delete'    => __( 'Are you sure you want to delete this element?', 'real-big-marketing' ),
            'delete_item'       => __( 'Delete', 'real-big-marketing' ),
            'add_item'          => __( 'Add', 'real-big-marketing' ),
        ),
        'field_media'    => array(
            'button_text'        => __( 'Upload / Choose Media', 'real-big-marketing' ),
            'button_remove_text' => __( 'Remove Media', 'real-big-marketing' ),
            'window_title'       => __( 'Choose Media', 'real-big-marketing' ),
        ),
        'field_checkbox' => array(
            'no_options_text' => __( 'No options available.', 'real-big-marketing' ),
        ),
    ),
) );

require_once( 'library/rbm-field-helpers-functions.php' );

// Front Page Extra Meta
require_once( 'library/admin/extra-meta/front-page.php' );
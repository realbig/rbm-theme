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

/** Change WP's sticky post class */
require_once( 'library/sticky-posts.php' );

/** Configure responsive image sizes */
require_once( 'library/responsive-images.php' );

require_once( 'library/shortcodes/form-overlay-shortcode.php' );

/** If your site requires protocol relative url's for theme assets, uncomment the line below */
// require_once( 'library/class-foundationpress-protocol-relative-theme-assets.php' );

/** Gutenberg editor support */
require_once( 'core/gutenberg/frontend/cover.php' );
require_once( 'core/gutenberg/frontend/columns.php' );
require_once( 'core/gutenberg/frontend/heading.php' );
require_once( 'core/gutenberg/frontend/button.php' );
require_once( 'core/gutenberg/frontend/image.php' );
require_once( 'core/gutenberg/frontend/post-title.php' );

global $rbm_theme_field_helpers;
$rbm_theme_field_helpers = false;

if ( class_exists( 'RBM_FieldHelpers' ) ) {

    $rbm_theme_field_helpers = new RBM_FieldHelpers( array(
        'ID'   => 'rbm_theme', // Your Theme/Plugin uses this to differentiate its instance of RBM FH from others when saving/grabbing data
        'l10n' => array(
            'field_table'    => array(
                'delete_row'    => __( 'Delete Row', 'rbm-theme' ),
                'delete_column' => __( 'Delete Column', 'rbm-theme' ),
            ),
            'field_select'   => array(
                'no_options'       => __( 'No select options.', 'rbm-theme' ),
                'error_loading'    => __( 'The results could not be loaded', 'rbm-theme' ),
                /* translators: %d is number of characters over input limit */
                'input_too_long'   => __( 'Please delete %d character(s)', 'rbm-theme' ),
                /* translators: %d is number of characters under input limit */
                'input_too_short'  => __( 'Please enter %d or more characters', 'rbm-theme' ),
                'loading_more'     => __( 'Loading more results...', 'rbm-theme' ),
                /* translators: %d is maximum number items selectable */
                'maximum_selected' => __( 'You can only select %d item(s)', 'rbm-theme' ),
                'no_results'       => __( 'No results found', 'rbm-theme' ),
                'searching'        => __( 'Searching...', 'rbm-theme' ),
            ),
            'field_repeater' => array(
                'collapsable_title' => __( 'New Row', 'rbm-theme' ),
                'confirm_delete'    => __( 'Are you sure you want to delete this element?', 'rbm-theme' ),
                'delete_item'       => __( 'Delete', 'rbm-theme' ),
                'add_item'          => __( 'Add', 'rbm-theme' ),
            ),
            'field_media'    => array(
                'button_text'        => __( 'Upload / Choose Media', 'rbm-theme' ),
                'button_remove_text' => __( 'Remove Media', 'rbm-theme' ),
                'window_title'       => __( 'Choose Media', 'rbm-theme' ),
            ),
            'field_checkbox' => array(
                'no_options_text' => __( 'No options available.', 'rbm-theme' ),
            ),
        ),
    ) );

}

require_once( 'library/rbm-field-helpers-functions.php' );

// Front Page Extra Meta
require_once( 'library/admin/extra-meta/front-page.php' );

add_action( 'edd_subscription_receipt_before_table', function() {

	add_filter( 'the_title', 'rbm_projects_add_download_link_wrapper', 10, 2 );

} );

add_action( 'edd_subscription_receipt_after_table', function() {

	remove_filter( 'the_title', 'rbm_projects_add_download_link_wrapper', 10, 2 );

} ); 

/**
 * Make Subscriptions table show links for the purchased Products
 *
 * @param   string   $post_title  Post Title
 * @param   integer  $post_id     Post ID
 *
 * @since   1.1.7
 * @return  string                Modified String
 */
function rbm_projects_add_download_link_wrapper( $post_title, $post_id ) {

	return '<a href="' . get_permalink( $post_id ) . '">' . $post_title . '</a>';

}

add_action('wp_head', 'rbm_gtm_head');

/**
 * Adds GMT data to <head>.
 *
 * @since 1.1.8
 */
function rbm_gtm_head() {
    
    ?>

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-5DLM8CQ');</script>
    <!-- End Google Tag Manager -->

    <?php
}

add_action('wp_body_open', 'rbm_gtm_body_open');

/**
 * Adds GTM data after the opening body tag.
 *
 * @since 1.1.8
 */
function rbm_gtm_body_open() {

    ?>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5DLM8CQ"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
 
    <?php
}
    
/**
 * Defers parsing of JS
 * @since v1.1.10
 */

add_filter( 'script_loader_tag', 'rbm_defer_js', 10, 3 );
function rbm_defer_js( $tag, $handle, $src ) {

	if ( is_admin() ) return $tag;

	if ( $handle == 'jquery' ) return $tag;

	// Ensures stuff like `wp` is available
	// Also contains a fix for WooCommerce Square
	if ( strpos( $src, 'wp-includes' ) !== false || strpos( $src, 'woocommerce-square' ) !== false ) return $tag;

	$tag = str_replace( 'src', 'defer="defer" src', $tag );
    return $tag;
}

/**
 * Redirect Subscriber-level users to the home page where applicable
 *
 * @param   string            $redirect_to            The redirect destination URL.
 * @param   string            $requested_redirect_to  The requested redirect destination URL passed as a parameter.
 * @param   WP_User|WP_Error  $user                   WP_User object if login was successful, WP_Error object otherwise.
 *
 * @since   1.3.3
 * @return  string                                    The redirect destination URL.
 */
add_filter( 'login_redirect', function( $redirect_to, $requested_redirect_to, $user ) {

    if ( is_wp_error( $user ) ) return $redirect_to;

    if ( is_super_admin( $user->ID ) ) return $redirect_to;

    if ( ! empty( array_intersect( array( 'administrator', 'editor', 'author' ), $user->roles ) ) ) return $redirect_to;

    if ( strpos( $redirect_to, admin_url() ) === false ) return $redirect_to;

    return home_url();

}, 10, 3 );

/**
 * Hide the Admin Bar for Subscriber-level users
 *
 * @param   boolean  $bool  Hide/Show
 *
 * @since   1.3.3
 * @return  boolean         Hide/Show
 */
add_filter( 'show_admin_bar', function( $bool ) {

    if ( ! is_user_logged_in() ) return $bool;

    $user = wp_get_current_user();

    if ( is_super_admin( $user->ID ) ) return $bool;

    if ( ! empty( array_intersect( array( 'administrator', 'editor', 'author' ), $user->roles ) ) ) return $bool;

    return false;

} );

add_action( 'init', function() {

    remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );

    add_action( 'wp_enqueue_scripts', 'rbm_adjust_global_styles' );

} );

/**
 * More-or-less a copy of wp_enqueue_global_styles() but with extra code to rip out unwanted variables and definitions
 *
 * @since   1.6.0
 * @return  void
 */
function rbm_adjust_global_styles() {

    $global_styles = wp_enqueue_global_styles();

    $stylesheet = rbm_get_global_stylesheet();

	wp_register_style( 'global-styles', false, array(), true, true );
	wp_add_inline_style( 'global-styles', $stylesheet );
	wp_enqueue_style( 'global-styles' );

}

/**
 * Returns the Global Stylesheet but modifies the output
 *
 * @param   array $types   Types of styles to load. Optional. It accepts 'variables', 'styles', 'presets' as values. If empty, it'll load all for themes with theme.json support and only [ 'variables', 'presets' ] for themes without theme.json support.
 *
 * @since   1.6.0
 * @return  string         Stylesheet resulting of merging core, theme, and user data
 */
function rbm_get_global_stylesheet( $types = array() ) {

    if ( ! function_exists( 'wp_get_global_stylesheet' ) ) return '';

    $stylesheet = wp_get_global_stylesheet( $types );

	if ( empty( $stylesheet ) ) {
		return '';
	}

    /**
     * A list of Button Sizes to remove from the Global Stylesheet
     * Ensure to keep updated any time a button font size gets added to theme.json and /src/assets/scss/_settings-overrides.scss
     *
     * @var array
     */
    $button_sizes = apply_filters( 'rbm_button_size_names', array(
        'tiny',
        'small',
        'default',
        'large'
    ) );

    /**
     * A list of Color Names to remove from the Global Stylesheet
     * Ensure to keep updated any time a color gets added to theme.json and /src/assets/scss/_settings-overrides.scss
     *
     * @var array
     */
    $rbm_colors = apply_filters( 'rbm_color_names', array(
        'primary',
        'secondary',
        'success',
        'warning',
        'alert',
        'info',
        'white',
        'body-copy',
    ) );

    // Remove variables
    $stylesheet = preg_replace( '/--wp--preset--font-size--h-[1-6]:[\s\S]*?;/sim', '', $stylesheet );
    $stylesheet = preg_replace( '/--wp--preset--font-size--(?:' . implode( '|', $button_sizes ) . '):[\s\S]*?;/sim', '', $stylesheet );
    $stylesheet = preg_replace( '/--wp--preset--color--(?:' . implode( '|', $rbm_colors ) . '):[\s\S]*?;/sim', '', $stylesheet );

    // Remove definitions
    $stylesheet = preg_replace( '/.has-h-[1-6]-font-size{[\s\S]*?}/', '', $stylesheet );
    $stylesheet = preg_replace( '/.has-(?:' . implode( '|', $button_sizes ) . ')-font-size{[\s\S]*?}/', '', $stylesheet );
    $stylesheet = preg_replace( '/.has-(?:' . implode( '|', $rbm_colors ) . ')-background-color{[\s\S]*?}/', '', $stylesheet );
    $stylesheet = preg_replace( '/.has-(?:' . implode( '|', $rbm_colors ) . ')-color{[\s\S]*?}/', '', $stylesheet );

    $stylesheet = apply_filters( 'rbm_get_global_stylesheet', $stylesheet, $types );

    return $stylesheet;

}
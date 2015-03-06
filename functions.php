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

// Make sure PHP version is correct
if ( ! version_compare( PHP_VERSION, '5.3.0', '>=' ) ) {
	wp_die( 'ERROR in RBMTheme theme: PHP version 5.3 or greater is required.' );
}

// Make sure no theme constants are already defined (realistically, there should be no conflicts)
if ( defined( 'THEME_VERSION' ) || defined( 'THEME_ID' ) || isset( $theme_fonts ) ) {
	wp_die( 'ERROR in RBMTheme theme: There is a conflicting constant. Please either find the conflict or rename the constant.' );
}

/**
 * The theme's current version (make sure to keep this up to date!)
 */
define( 'THEME_VERSION', '0.1.0' );

/**
 * The theme's ID (used in handlers).
 */
define( 'THEME_ID', 'my_theme' );

/**
 * Fonts for the theme. Must be hosted font (Google fonts for example).
 */
$theme_fonts = array(
	'oswald' => 'http://fonts.googleapis.com/css?family=Oswald:700',
	'leckerli one' => 'http://fonts.googleapis.com/css?family=Leckerli+One',
	'open sans' => 'http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700',
);

/**
 * Setup theme properties and stuff.
 *
 * @since 0.1.0
 */
add_action( 'after_theme_setup', function() {

	// Add theme support
	require_once __DIR__ . '/includes/theme-support.php';

	// Allow shortcodes in text widget
	add_filter('widget_text', 'do_shortcode');
});

/**
 * Register theme files.
 *
 * @since 0.1.0
 */
add_action( 'init', function () {

	global $theme_fonts;

	// Theme styles
	wp_register_style(
		THEME_ID,
		get_template_directory_uri() . '/style.css',
		null,
		defined( 'WP_DEBUG' ) && WP_DEBUG ? time() : THEME_VERSION
	);

	// Theme script
	wp_register_script(
		THEME_ID,
		get_template_directory_uri() . '/script.js',
		array( 'jquery' ),
		defined( 'WP_DEBUG' ) && WP_DEBUG ? time() : THEME_VERSION,
		true
	);

	// Theme fonts
	if ( ! empty( $theme_fonts ) ) {
		foreach ( $theme_fonts as $ID => $link ) {
			wp_register_style(
				THEME_ID . "-font-$ID",
				$link
			);
		}
	}
} );

/**
 * Enqueue theme files.
 *
 * @since 0.1.0
 */
add_action( 'wp_enqueue_scripts', function () {

	global $theme_fonts;

	// Theme styles
	wp_enqueue_style( THEME_ID );

	// Theme script
	wp_enqueue_script( THEME_ID );

	// Theme fonts
	if ( ! empty( $theme_fonts ) ) {
		foreach ( $theme_fonts as $ID => $link ) {
			wp_enqueue_style( THEME_ID . "-font-$ID" );
		}
	}
} );

/**
 * Register nav menus.
 *
 * @since 0.1.0
 */
add_action( 'after_setup_theme', function () {

	register_nav_menu( 'primary-right', 'Primary Right' );
	register_nav_menu( 'primary-left', 'Primary Left' );
	register_nav_menu( 'primary-center', 'Primary Circular' );
} );

/**
 * Register sidebars.
 *
 * @since 0.1.0
 */
add_action( 'widgets_init', function () {

	// Footer left
	register_sidebar( array(
		'name' => 'Footer Left',
		'id' => 'footer-left',
		'description' => 'Displays in the left side of the footer.',
		'before_title' => '<h3 class="footer-widget-title">',
		'after_title' => '</h3>',
	));

	// Footer right
	register_sidebar( array(
		'name' => 'Footer Right',
		'id' => 'footer-right',
		'description' => 'Displays in the right side of the footer.',
		'before_title' => '<h3 class="footer-widget-title">',
		'after_title' => '</h3>',
	));

	// Footer copyright
	register_sidebar( array(
		'name' => 'Footer Copyright',
		'id' => 'footer-copyright',
		'description' => 'Displays at the very bottom of the footer.',
		'before_title' => '<h3 class="footer-widget-title">',
		'after_title' => '</h3>',
	));
} );

// Include other static files
require_once __DIR__ . '/shortcodes.php';
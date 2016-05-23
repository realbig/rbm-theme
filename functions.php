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
define( 'THEME_VERSION', '0.1.3' );

/**
 * The theme's ID (used in handlers).
 */
define( 'THEME_ID', 'rbm_theme' );

/**
 * Fonts for the theme. Must be hosted font (Google fonts for example).
 */
$theme_fonts = array(
	'oswald'       => 'http://fonts.googleapis.com/css?family=Oswald:700',
	'leckerli one' => 'http://fonts.googleapis.com/css?family=Leckerli+One',
	'open sans'    => 'http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700',
);

/**
 * Setup theme properties and stuff.
 *
 * @since 0.1.0
 */
add_action( 'after_setup_theme', function () {

	// Add theme support
	require_once __DIR__ . '/includes/theme-support.php';

	// Allow shortcodes in text widget
	add_filter( 'widget_text', 'do_shortcode' );
} );

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

	// Admin script
	wp_register_script(
		THEME_ID . '-admin',
		get_template_directory_uri() . '/admin.js',
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

	// Favicon
	echo '<link rel="shortcut icon" href="' . get_stylesheet_directory_uri() . '/assets/images/favicon.png" />';
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
	register_nav_menu( 'footer', 'Footer' );
} );

/**
 * Register sidebars.
 *
 * @since 0.1.0
 */
add_action( 'widgets_init', function () {

	register_sidebar( array(
		'name'          => 'Main Sidebar',
		'id'            => 'main-sidebar',
		'description'   => 'Used all basic pages.',
	) );
} );

add_action( 'wp_head', function () {

	if ( is_user_logged_in() ) {
		return;
	}
	?>
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-37145568-1', 'auto');
		ga('send', 'pageview');

	</script>
<?php
});

function rbm_section_title( $title = '', $anchor = '' ) {
	echo rbm_get_section_title( $title, $anchor );
}

function rbm_get_section_title( $title = '', $anchor = '' ) {

	static $direction;
	$direction = $direction == 'left' ? 'right' : 'left';

	$output = '';
	$output .= "<h1 class=\"section-title $direction\">";
	$output .= "<a href=\"#$anchor\" class=\"force-color no-effect\">";
	$output .= '<span class="text">';
	$output .= '<span class="icon">';
	$output .= '<span class="icon-flag"></span>';
	$output .= '<span class="icon-link"></span>';
	$output .= '</span>';
	$output .= $title;
	$output .= '</span>';
	$output .= '</a>';
	$output .= '</h1>';

	return $output;
}

function rbm_overlay_grid_item( $args = array() ) {
	echo rbm_get_overlay_grid_item( $args );
}

function rbm_get_overlay_grid_item( $args = array() ) {

	$args = wp_parse_args( $args, array(
		'post' => false,
		'image' => false,
		'extra' => false,
        'column_class' => false,
        'even_row' => false,
	));

	global $post;
	$post = $args['post'] !== false ? get_post( $args['post'] ) : $post;
    
	if ( $args['image'] !== false ) {
		$image = $args['image'];
	} else {
		$image = get_the_post_thumbnail_url( $post->ID );
	}
    
    // We're going to build DOM in an Object Buffer, which helps keep things more readable.
    ob_start(); ?>
    <div class="small-12 <?php echo $args['column_class']; ?> columns">
        <a class="gear-link" href="<?php echo get_permalink( $post->ID ); ?>">
            <?php if ( $args['even_row'] ) : ?>
                <svg class="gear-clip" xxmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="24em" height="24em">
                    <g>
                        <path fill="#000000" transform="translate( 92, -67 ) rotate(27.5)" d="m 156.8175,0 c -4.98536,0.00618 -8.70252,6.2305215 -9.97612,13.699809 l -4.29702,24.526875 c -13.38993,3.4685 -26.36651,8.885786 -38.53448,16.240607 L 83.315331,39.952739 C 77.044899,35.677214 70.060952,33.795052 66.555702,37.30934 L 37.387793,66.386725 c -3.505246,3.502843 -1.710019,10.564824 2.661504,16.723417 l 14.55076,20.658338 c -7.348971,12.11686 -12.79511,25.07269 -16.288886,38.42584 l -24.557056,4.28495 C 6.2731944,147.87583 0,151.45807 0,156.44332 c 0,12.79654 0,25.59309 0,38.38963 0,4.98525 6.2731944,8.56748 13.754115,9.96405 l 24.557056,4.28495 c 3.493776,13.35316 8.939915,26.30899 16.288885,38.42584 l -14.55076,20.65231 c -4.371522,6.15859 -6.16675,13.22662 -2.661504,16.72945 l 29.16791,29.07737 c 3.50525,3.51429 10.489197,1.63214 16.759629,-2.64337 l 20.694549,-14.51456 c 12.16797,7.35482 25.14455,12.77211 38.53448,16.24061 l 4.29702,24.52085 c 1.2736,7.4693 4.99076,13.7001 9.97612,13.70581 l 41.20804,-0.006 c 5.00259,0.0278 8.59442,-6.25311 9.99423,-13.69376 l 4.10994,-23.4828 c 14.09557,-3.21666 27.74574,-8.55126 40.55625,-15.96903 l 18.85986,13.19891 c 6.14996,4.3671 13.24291,6.16371 16.75963,2.64943 l 29.14982,-29.0774 c 3.51673,-3.51429 1.61854,-10.47928 -2.65548,-16.72945 l -12.32984,-17.51387 c 8.48489,-13.23295 14.54697,-27.54082 18.30463,-42.33059 l 20.34453,-3.52452 c 7.45796,-1.26492 13.72936,-4.98514 13.7179,-9.97612 0,-12.7885 0,-25.57699 0,-38.36549 0.0124,-4.99097 -6.25994,-8.71119 -13.7179,-9.97612 l -20.34453,-3.52452 c -3.75766,-14.78977 -9.81974,-29.10366 -18.30463,-42.33662 l 12.32984,-17.514023 c 4.27402,-6.250168 6.17221,-13.215167 2.65548,-16.729454 L 288.30545,37.303305 c -3.51672,-3.514288 -10.60967,-1.717669 -16.75963,2.649434 L 252.68596,53.151625 C 239.87545,45.733845 226.22528,40.399266 212.12971,37.182604 L 208.01977,13.699809 C 206.61996,6.2591349 203.02813,-0.0225776 198.02554,0.0060358 Z"
                        />
                        <image width="24em" height="24em" xlink:href="<?php echo $image; ?>" clip-path="url(#rbm-gear-tilt)" -webkit-clip-path="url(#rbm-gear-tilt)" -webkit-mask="url(#rbm-gear-tilt)" x="0" y="0" />
                        <rect class="gear-overlay" width="100%" height="100%" clip-path="url(#rbm-gear-tilt)" -webkit-clip-path="url(#rbm-gear-tilt)" -webkit-mask="url(#rbm-gear-tilt)" />
                        
                    </g>
                </svg>
            <?php else : ?>
                <svg class="gear-clip" xxmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="24em" height="24em">
                    <g>
                        <path fill="#000000" transform="translate( -5, -5 )" d="m 156.8175,0 c -4.98536,0.00618 -8.70252,6.2305215 -9.97612,13.699809 l -4.29702,24.526875 c -13.38993,3.4685 -26.36651,8.885786 -38.53448,16.240607 L 83.315331,39.952739 C 77.044899,35.677214 70.060952,33.795052 66.555702,37.30934 L 37.387793,66.386725 c -3.505246,3.502843 -1.710019,10.564824 2.661504,16.723417 l 14.55076,20.658338 c -7.348971,12.11686 -12.79511,25.07269 -16.288886,38.42584 l -24.557056,4.28495 C 6.2731944,147.87583 0,151.45807 0,156.44332 c 0,12.79654 0,25.59309 0,38.38963 0,4.98525 6.2731944,8.56748 13.754115,9.96405 l 24.557056,4.28495 c 3.493776,13.35316 8.939915,26.30899 16.288885,38.42584 l -14.55076,20.65231 c -4.371522,6.15859 -6.16675,13.22662 -2.661504,16.72945 l 29.16791,29.07737 c 3.50525,3.51429 10.489197,1.63214 16.759629,-2.64337 l 20.694549,-14.51456 c 12.16797,7.35482 25.14455,12.77211 38.53448,16.24061 l 4.29702,24.52085 c 1.2736,7.4693 4.99076,13.7001 9.97612,13.70581 l 41.20804,-0.006 c 5.00259,0.0278 8.59442,-6.25311 9.99423,-13.69376 l 4.10994,-23.4828 c 14.09557,-3.21666 27.74574,-8.55126 40.55625,-15.96903 l 18.85986,13.19891 c 6.14996,4.3671 13.24291,6.16371 16.75963,2.64943 l 29.14982,-29.0774 c 3.51673,-3.51429 1.61854,-10.47928 -2.65548,-16.72945 l -12.32984,-17.51387 c 8.48489,-13.23295 14.54697,-27.54082 18.30463,-42.33059 l 20.34453,-3.52452 c 7.45796,-1.26492 13.72936,-4.98514 13.7179,-9.97612 0,-12.7885 0,-25.57699 0,-38.36549 0.0124,-4.99097 -6.25994,-8.71119 -13.7179,-9.97612 l -20.34453,-3.52452 c -3.75766,-14.78977 -9.81974,-29.10366 -18.30463,-42.33662 l 12.32984,-17.514023 c 4.27402,-6.250168 6.17221,-13.215167 2.65548,-16.729454 L 288.30545,37.303305 c -3.51672,-3.514288 -10.60967,-1.717669 -16.75963,2.649434 L 252.68596,53.151625 C 239.87545,45.733845 226.22528,40.399266 212.12971,37.182604 L 208.01977,13.699809 C 206.61996,6.2591349 203.02813,-0.0225776 198.02554,0.0060358 Z"
                        />
                        <image width="24em" height="24em" xlink:href="<?php echo $image; ?>" clip-path="url(#rbm-gear)" -webkit-clip-path="url(#rbm-gear)" -webkit-mask="url(#rbm-gear)" x="0" y="0" />
                        <rect class="gear-overlay" width="100%" height="100%" clip-path="url(#rbm-gear)" -webkit-clip-path="url(#rbm-gear)" -webkit-mask="url(#rbm-gear)" />
                    </g>
                </svg>
            <?php endif; ?>
        </a>
    </div>

    <?php
    // Everything gets assigned to $output at once. Much cleaner.
    $output = ob_get_contents();
    ob_end_clean();

	return $output;
    
}

// Include other static files
require_once __DIR__ . '/includes/shortcodes.php';
require_once __DIR__ . '/includes/widgets.php';
require_once __DIR__ . '/includes/limit-posts.php';
require_once __DIR__ . '/includes/class-rbmtheme-walker-circularnav.php';
require_once __DIR__ . '/admin/admin.php';
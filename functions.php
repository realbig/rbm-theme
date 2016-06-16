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
		'load_effect' => false,
	));

	global $post;
	$post = $args['post'] !== false ? get_post( $args['post'] ) : $post;

	$output = '<li class="overlay-grid-item">';

	$output .= '<a href="' . get_permalink( $post->ID ) . '" class="no-effect" data-square>';

	$output .= '<div class="overlay-grid-image">';
	if ( $args['image'] !== false ) {
		$image = $args['image'];
	} else {
		$image = get_the_post_thumbnail( $post->ID );
	}

	if ( $args['load_effect'] ) {

		preg_match( '/src="(.*?)"/', $image, $matches );
		$src = isset( $matches[1] ) ? $matches[1] : false;

		if ( $src !== false ) {
			$output .= "<img class=\"grid-load-effect-image\" src=\"" . get_template_directory_uri() . "/assets/images/blank.png\" data-src=\"$src\" />";
		}

	} else {
		$output .= $image;
	}

	$output .= '</div>';

	$output .= '<div class="overlay-grid-overlay">';

	$output .= '<div class="overlay-grid-meta">';

	$output .= '<p class="overlay-grid-title">';
	$output .= get_the_title( $post->ID );
	$output .= '</p>';

	if ( $args['extra'] !== false ) {
		$output .= $args['extra'];
	}

	$output .= '</div>';

	$output .= '</div>';

	$output .= '</a>';
	$output .= '</li>';

	return $output;
    
}

function rbm_get_gear_item( $args = array() ) {

	$args = wp_parse_args( $args, array(
		'post' => false,
		'image' => false,
		'extra' => false,
        'column_class' => false,
        'is_even_row' => false,
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
            <?php if ( $args['is_even_row'] ) : ?>
                <svg class="gear-clip" xxmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="15em" height="15em" viewBox="0 0 227.37129 225.08964">
                    <g>
                        <image width="265px" height="265px" xlink:href="<?php echo $image; ?>" clip-path="url(#rbm-gear-tilt)" -webkit-clip-path="url(#rbm-gear-tilt)" -webkit-mask="url(#rbm-gear-tilt)" x="0" y="0" />
                    </g>
                    <g class="title-overlay">
                        <rect x="-5" width="105%" height="80px" y="70" />
                        <text class="staff-name" fill="#fff" x="115" y="100" alignment-baseline="baseline" text-anchor="middle"><?php echo $post->post_title; ?></text>
                        <text class="staff-title" fill="#fff" x="115" y="135" alignment-baseline="baseline" text-anchor="middle"><?php echo $args['extra']; ?></text>
                    </g>
                </svg>
            <?php else : ?>
                <svg class="gear-clip" xxmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="15em" height="15em" viewBox="0 0 227.37129 225.08964">
                    <g>
                        <image width="265px" height="265px" xlink:href="<?php echo $image; ?>" clip-path="url(#rbm-gear)" -webkit-clip-path="url(#rbm-gear)" -webkit-mask="url(#rbm-gear)" x="0" y="0" />
                    </g>
                    <g class="title-overlay">
                        <rect x="-5" width="105%" height="80px" y="70" />
                        <text class="staff-name" fill="#fff" x="115" y="100" alignment-baseline="baseline" text-anchor="middle"><?php echo $post->post_title; ?></text>
                        <text class="staff-title" fill="#fff" x="115" y="135" alignment-baseline="baseline" text-anchor="middle"><?php echo $args['extra']; ?></text>
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
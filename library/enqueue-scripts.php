<?php
/**
 * Enqueue all styles and scripts
 *
 * Learn more about enqueue_script: {@link https://codex.wordpress.org/Function_Reference/wp_enqueue_script}
 * Learn more about enqueue_style: {@link https://codex.wordpress.org/Function_Reference/wp_enqueue_style }
 *
 * @package RBMTheme
 * @since FoundationPress 1.0.0
 */


if ( ! function_exists( 'foundationpress_scripts' ) ) :
	function foundationpress_scripts() {

		// Check to see if rev-manifest exists for CSS and JS static asset revisioning
		//https://github.com/sindresorhus/gulp-rev/blob/master/integration.md
		function css_asset_path($filename) {
			$manifest_path = dirname(dirname(__FILE__)) . '/dist/assets/css/rev-manifest.json';

			if (file_exists($manifest_path)) {
				$manifest = json_decode(file_get_contents($manifest_path), TRUE);
			} else {
				$manifest = [];
			}

			if (array_key_exists($filename, $manifest)) {
				return $manifest[$filename];
			}

			return $filename;
		}

		function js_asset_path($filename) {
			$manifest_path = dirname(dirname(__FILE__)) . '/dist/assets/js/rev-manifest.json';

			if (file_exists($manifest_path)) {
				$manifest = json_decode(file_get_contents($manifest_path), TRUE);
			} else {
				$manifest = [];
			}

			if (array_key_exists($filename, $manifest)) {
				return $manifest[$filename];
			}

			return $filename;
		}

		// Enqueue the main Stylesheet.
		wp_enqueue_style(
			'main-stylesheet', 
			get_template_directory_uri() . '/dist/assets/css/' . css_asset_path('app.css'),
			array(),
			defined( 'WP_DEBUG' ) && WP_DEBUG ? time() : THEME_VER,
			'all'
		);

		/*
		// Commented out to fix bug with Gravity Forms
		
		// Deregister the jquery version bundled with WordPress.
		wp_deregister_script( 'jquery' );

		// CDN hosted jQuery placed in the header, as some plugins require that jQuery is loaded in the header.
		wp_enqueue_script(
			'jquery',
			'//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js',
			array(),
			'3.2.1', // jQuery version, not Theme version
			false
		);
		*/

		// Enqueue Founation scripts
		wp_enqueue_script(
			'foundation',
			get_template_directory_uri() . '/dist/assets/js/' . js_asset_path('app.js'),
			array( 'jquery' ),
			defined( 'WP_DEBUG' ) && WP_DEBUG ? time() : THEME_VER,
			true
		);

		// Enqueue FontAwesome from CDN. Uncomment the line below if you don't need FontAwesome.
		wp_enqueue_script(
			'fontawesome',
			'//use.fontawesome.com/releases/v5.0.3/js/all.js',
			array(),
			'5.0.3',
			false
		);

		// Add the comment-reply library on pages where it is necessary
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

	}

	add_action( 'wp_enqueue_scripts', 'foundationpress_scripts' );
endif;

// Load each Gutenberg Block as its own CSS file
add_filter( 'should_load_separate_core_block_assets', '__return_true' );

add_action( 'wp_enqueue_scripts', 'rbm_use_custom_core_block_styles' );

/**
 * For the defined WP Core Blocks, look for a matching CSS file and then load it instead of the one included by WP Core
 * 
 * Base on 
 * https://github.com/WordPress/gutenberg/issues/35848#issuecomment-1030448637
 * and
 * https://kraftner.com/en/blog/building-your-own-wordpress-core-block-css/
 *
 * @since	{{VERSION}}
 * @return  void
 */
function rbm_use_custom_core_block_styles() {

  $blocks = apply_filters( 'rbm_core_blocks_with_custom_styles', array(
    'columns',
  ) );

  foreach ( $blocks as $block ) {

    $file_path = locate_template( "dist/assets/css/{$block}.css", false, false );

    // File doesn't exist in parent or child theme, bail
    if ( ! $file_path ) continue;

    // Generate a relative path to use as a URI
    $relative_path = '/' . ltrim( wp_normalize_path( str_replace( ABSPATH, '', $file_path ) ), '/' );

    wp_deregister_style( "wp-block-{$block}" );

    wp_register_style( 
        "wp-block-{$block}",
        $relative_path,
        array(),
        ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG == true ) ? time() : THEME_VER, 
        'all'
    );

  }

}

add_action( 'enqueue_block_editor_assets', 'extend_block_example_enqueue_block_editor_assets' );

function extend_block_example_enqueue_block_editor_assets() {
    // Enqueue our script
    wp_enqueue_script(
        'rbm-extend-blocks',
        THEME_URL . '/dist/assets/js/gutenberg-extend.js',
        array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ),
        ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG == true ) ? time() : THEME_VER, 
        true
    );
}
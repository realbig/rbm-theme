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

if ( ! function_exists( 'block_editor_assets' ) ) :
	function block_editor_assets() {
		wp_enqueue_style( 'block-editor-styles', get_template_directory_uri() . '/dist/assets/css/app.css' );
	}

	//add_action( 'enqueue_block_editor_assets', 'block_editor_assets' );
endif;
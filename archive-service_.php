<?php
/**
 * Displays latest blog posts.
 *
 * @since   0.1.0
 * @package RBMTheme
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

get_header();

include __DIR__ . '/temp-building.php';

get_footer();
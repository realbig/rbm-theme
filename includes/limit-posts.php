<?php
/**
 * Adds theme support for the theme.
 *
 * Feel free to remove any un-wanted support (most is already commented out)
 *
 * @since   0.1.0
 * @package RBMTheme
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Filters the number of archive posts based on which archive it is.
 */
add_filter('pre_get_posts', function () {

	// Customer Archive
	if ( is_post_type_archive( 'customer' ) ) {
		set_query_var('posts_per_archive_page', -1);
	}
});
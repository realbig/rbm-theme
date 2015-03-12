<?php
/**
 * Displays archive of posts.
 *
 * @since   0.1.0
 * @package RBMTheme
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

get_header();
?>

<aside class="sidebar columns small-12 medium-4">
	<ul class="widgets">
		<?php dynamic_sidebar( 'main-sidebar' ); ?>
	</ul>
</aside>
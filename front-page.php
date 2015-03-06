<?php
/**
 * The theme's front-page file use for displaying the home page.
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

	<section class="home-cta columns small-12">

		<div class="home-cta-message">
			<h1 class="font-special">
				Something cool should be said here.
			</h1>

			<a href="#" class="button">
				Learn More
			</a>
		</div>

		<a href="#" class="icon-circle-down scroll-down"></a>

	</section>

	<section class="page-content columns small-12">

	</section>

<?php
get_footer();
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

		<div class="home-cta-cover"></div>

		<div class="home-cta-message">
			<h1 class="font-special">
				Something cool should be said here.
			</h1>

			<a href="#" class="button">
				Learn More
			</a>
		</div>

		<a href="#" class="scroll-down no-effect"><span class="icon-circle-down"></span></a>

	</section>

	<section id="who-we-are" class="section services columns small-12">

		<h1 class="section-title">
			<a href="#who-we-are" class="force-color no-effect">
				<span class="text">
					<span class="icon-flag"></span>
					Who we are
				</span>
			</a>
		</h1>

		<div class="section-summary">
			We're a marketing firm with an emphasis on top-notch website creation.
		</div>

		<a href="#" class="button dark">
			See what we can do for you!
		</a>

		<p>
			More copy that perhaps should be here but <a href="#">link</a> perhaps shot lunot
		</p>

	</section>

<?php
get_footer();
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
?>

	<div class="page-content top-flush bottom-flush blue row expanded">

		<?php
		the_archive_description( '<div class="taxonomy-description columns small-12">', '</div>' );
		?>

		<?php if ( have_posts() ) : ?>
			<div class="overlay-grid grid-load-effect row small-up-2 medium-up-3 large-up-4">
			<?php
			while ( have_posts() ) :
				the_post();

				rbm_overlay_grid_item( array(
					'load_effect' => true,
				));

			endwhile;
			?>

			</div>

		<?php else: ?>

			<div class="columns small-12">
				Nothing found, sorry!
			</div>

		<?php endif; ?>

	</div>

<?php
get_footer();
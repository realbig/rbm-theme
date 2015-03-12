<?php
/**
 * Template Name: Full Width
 *
 * The theme's page file use for displaying pages.
 *
 * @since   0.1.0
 * @package RBMTheme
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

get_header();

the_post();
?>

	<div class="page-content row expand collapse">

		<article id="page-<?php the_ID(); ?>" <?php post_class( array( 'columns', 'small-12' ) ); ?>>

			<?php the_content(); ?>

		</article>

	</div>

<?php
get_footer();
<?php
/**
 * Template Name: Full Width Sidebar
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

	<div class="page-content row expand">

		<article id="page-<?php the_ID(); ?>" <?php post_class( array( 'columns', 'small-12', 'medium-8' ) ); ?>>

			<h1 class="page-title">
				<?php the_title(); ?>
			</h1>

			<?php the_content(); ?>

		</article>

		<?php get_sidebar(); ?>

	</div>

<?php
get_footer();
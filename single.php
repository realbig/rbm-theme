<?php
/**
 * The theme's single file use for displaying single posts.
 *
 * @since 0.1.0
 * @package RBMTheme
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

get_header();

the_post();
?>

	<div class="page-content row">

		<article id="page-<?php the_ID(); ?>" <?php post_class( array( 'columns', 'small-12' ) ); ?>>

			<h1 class="page-title">
				<?php the_title(); ?>
			</h1>

			<?php the_content(); ?>

		</article>

		<div class="columns small-12">
			<?php comments_template(); ?>
		</div>

	</div>

<?php
get_footer();
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

	<div class="row page-content">

		<?php if ( have_posts() ) : ?>
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( array(
					'page-content',
					'columns',
					'small-12'
				) ); ?>>

					<h1 class="post-title">
						<a href="<?php the_permalink(); ?>" class="force-color">
							<?php the_title(); ?>
						</a>
					</h1>

					<?php the_excerpt(); ?>

					<a href="<?php the_permalink(); ?>" class="button dark">
						Read more
					</a>

				</article>
			<?php endwhile; ?>

		<?php endif; ?>

	</div>

<?php
get_footer();
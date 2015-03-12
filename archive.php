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

	<div class="page-content row">

		<h1 class="page-title columns small-12">
			<?php post_type_archive_title( '' ); ?>
		</h1>

		<?php
		the_archive_description( '<div class="taxonomy-description columns small-12">', '</div>' );
		?>

		<?php if ( have_posts() ) : ?>
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( array(
					'columns',
					'small-12'
				) ); ?>>

					<h2 class="post-title">
						<a href="<?php the_permalink(); ?>" class="force-color">
							<?php the_title(); ?>
						</a>
					</h2>

					<?php the_excerpt(); ?>

					<a href="<?php the_permalink(); ?>" class="button dark">
						Read more
					</a>

				</article>
			<?php endwhile; ?>

			<div class="columns small-12">
				<?php
				the_posts_pagination( array(
					'prev_text'          => 'Previous page',
					'next_text'          => 'Next page',
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . 'Page' . ' </span>',
				) );
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
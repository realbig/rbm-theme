<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package RBMTheme
 * @since FoundationPress 1.0.0
 */

get_header(); ?>

<?php get_template_part( 'template-parts/featured-image' ); ?>

<div class="main-wrap">
	<main class="main-content">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'template-parts/content', '' ); ?>
			<?php //the_post_navigation(); ?>
			<?php comments_template(); ?>
		<?php endwhile;?>
	</main>
<?php get_sidebar(); ?>
</div>
<?php get_footer();

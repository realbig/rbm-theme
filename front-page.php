<?php
/**
 * Frontpage Template
 * @since 1.1.0
 *
 * @package RBMTheme
 */

get_header(); ?>

<div class="main-wrap full-width">
	<main class="main-content">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'template-parts/content', 'editor-only' ); ?>
			<?php comments_template(); ?>
		<?php endwhile;?>
	</main>
</div>
<?php get_footer();
<?php
/*
Template Name: Right Sidebar
*/
get_header(); ?>

<?php get_template_part( 'template-parts/featured-image' ); ?>

<div class="main-wrap sidebar-right">
<?php get_sidebar(); ?>
	<main class="main-content">
		<?php while ( have_posts() ) : the_post(); ?>	
			<?php get_template_part( 'template-parts/content', 'page' ); ?>
			<?php comments_template(); ?>
		<?php endwhile;?>
	 </main>
</div>
<?php get_footer();

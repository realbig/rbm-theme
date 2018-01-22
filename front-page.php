<?php
/**
 * Frontpage Template
 *
 * @package RBMTheme
 */

 get_header(); ?>

<header class="front-hero" role="banner">
	<div class="marketing">
		
		<div class="tagline">
		</div>

		<div class="watch">
		</div>
		
		<div class="image">
			<div class="color-overlay"></div>
		</div>
		
	</div>

</header>

 <div class="main-wrap">
	 <main class="main-content">
		 <?php while ( have_posts() ) : the_post(); ?>
		 	<?php //get_template_part( 'template-parts/content', 'page' ); ?>
			<?php comments_template(); ?>
		 <?php endwhile;?>
	 </main>
 <?php get_sidebar(); ?>
 </div>
 <?php get_footer();

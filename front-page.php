<?php
/**
 * Frontpage Template
 *
 * @package RBMTheme
 */

get_header(); 

while ( have_posts() ) : the_post(); ?>

	<header class="front-hero" role="banner">
		<div class="marketing">

			<div class="image">
				<div class="color-overlay"></div>
			</div>
			
			<div class="row expanded tagline">
				<div class="small-12 medium-6 columns">
					<?php the_content(); ?>
				</div>
			</div>

		</div>

	</header>

	 <div class="main-wrap">
		 <main class="main-content">
			<?php //get_template_part( 'template-parts/content', 'page' ); ?>
			<?php comments_template(); ?>
		 </main>
	 <?php get_sidebar(); ?>
	 </div>

<?php endwhile;

get_footer();
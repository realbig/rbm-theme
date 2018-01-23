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
			
			<div class="expanded row tagline">
				<div class="small-12 medium-6 columns">
					<?php the_content(); ?>
				</div>
			</div>

		</div>

	</header>

	 <div class="main-wrap row">
		 <div class="small-12 columns text-center">
			<?php echo apply_filters( 'the_content', rbm_theme_get_field( 'case_studies_header' ) ); ?>
		 </div>
	 <?php get_sidebar(); ?>
	 </div>

<?php endwhile;

get_footer();
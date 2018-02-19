<?php
/**
 * Frontpage Template
 * @since {{VERSION}}
 *
 * @package RBMTheme
 */

global $post;

get_header(); 

while ( have_posts() ) : the_post(); ?>

	<header class="front-hero" role="banner">
		<div class="marketing main-wrap">

			<div class="image">
				<div class="color-overlay"></div>
			</div>
			
			<div class="expanded row tagline">
				<div class="small-12 columns">
					<?php the_content(); ?>
				</div>
			</div>

		</div>

	</header>

	 <div class="main-wrap row case-studies-header">
		 <div class="small-12 columns text-center">
			<?php echo apply_filters( 'the_content', rbm_theme_get_field( 'case_studies_header' ) ); ?>
		 </div>
	 </div>

	<div class="main-wrap case-studies-slider">
		<div class="small-12 columns">
			
			<div class="orbit" role="region" aria-label="Favorite Space Pictures" data-orbit>
				
				<ul class="orbit-container">
					
					<button class="orbit-previous" aria-label="previous">
						<span class="show-for-sr"><?php _e( 'Previous Slide', 'rbm-theme' ); ?></span>&#9664;
					</button>
					<button class="orbit-next" aria-label="next"><span class="show-for-sr">
						<?php _e( 'Next Slide', 'rbm-theme' ); ?></span>&#9654;
					</button>
					
					<?php
					
						$is_first = true;
					
						$case_studies = new WP_Query( array(
							'post_type' => 'case-studies',
							'posts_per_page' => -1,
						) );
					
						if ( $case_studies->have_posts() ) : 
					
							while ( $case_studies->have_posts() ) : $case_studies->the_post();
					
								include locate_template( 'template-parts/loop/loop-home-case-studies.php' );
					
							endwhile;
					
							wp_reset_postdata();
					
						else : ?>
					
							<li class="is-active orbit-slide">
								<?php _e( 'No Case Studies created yet', 'rbm-theme' ); ?>
							</li>
					
						<?php endif;
					
					?>
					
				</ul>
				
				<nav class="orbit-bullets">
					
					<?php
					
						$is_first = true;
						$index = 0;
					
						$case_studies->rewind_posts();
					
						if ( $case_studies->have_posts() ) : 
					
							while ( $case_studies->have_posts() ) : $case_studies->the_post(); ?>
					
								<button <?php echo ( $is_first ? 'class="is-active" ' : '' ); ?>data-slide="<?php echo $index; ?>">
									<span class="show-for-sr"><?php the_title(); ?></span>
									<?php if ( $is_first ) : ?>
										<span class="show-for-sr"><?php echo __( 'Current Slide', 'rbm-theme' ); ?></span>
									<?php endif; ?>
								</button>
					
							<?php 
					
								$is_first = false;
								$index++;
					
							endwhile;
					
							wp_reset_postdata();
					
						endif;
					
					?>
					
				 </nav>
			
		</div>
	</div>

<?php endwhile;

get_footer();
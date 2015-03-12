<?php
/**
 * The theme's front-page file use for displaying the home page.
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

	<div class="row expand">

		<section class="home-cta columns small-12">

			<?php if ( ! wp_is_mobile() ) : ?>
				<video autoplay loop poster="<?php echo get_template_directory_uri(); ?>/assets/images/home-cta.jpg"
				       class="home-cta-video">
					<source src="<?php echo get_template_directory_uri(); ?>/assets/videos/home-back.mp4" type="video/mp4"/>
				</video>
			<?php endif; ?>

			<div class="home-cta-message">
				<h1 class="font-special">
					Ready for your website to pull its weight?
				</h1>

				<a href="<?php echo get_permalink( 47 ); ?>" class="button">
					Contact Us
				</a>
			</div>

			<div class="home-cta-cover"></div>

			<a href="#" class="scroll-down no-effect"><span class="icon-circle-down"></span></a>

		</section>

		<section id="who-we-are" class="section services blue columns small-12">

			<div class="section-content">

				<?php rbm_section_title( 'Who We Are', 'who-we-are' ); ?>

				<div class="section-summary">
					We're a marketing firm with an emphasis on top-notch website creation.
				</div>

				<a href="<?php echo get_permalink( 24 ); ?>" class="button section-cta">
					Learn more about our company
				</a>

				<div class="services-list row">

					<div class="service-item visible columns small-12 medium-4" data-index="0">
						<h2>
							60% Of Content Managed Sites Use WordPress
						</h2>

						<div class="service-icons">
							<ul class="small-block-grid-12 medium-block-grid-8">
							<?php for ( $i = 0; $i < 40; $i ++ ) : ?>
								<li class="service-icon visible icon-earth <?php echo $i < 24 ? 'dark' : ''; ?>"
								    data-index="<?php echo $i; ?>"></li>
							<?php endfor; ?>
							</ul>
						</div>

						<p class="service-blurb">
							That's why we build on WordPress
						</p>
					</div>

					<div class="service-item visible columns small-12 medium-4" data-index="1">
						<h2>
							80% of Internet Users Own a Smartphone
						</h2>

						<div class="service-icons">
							<ul class="small-block-grid-12 medium-block-grid-8">
							<?php for ( $i = 0; $i < 40; $i ++ ) : ?>
								<li class="service-icon visible icon-mobile <?php echo $i < 32 ? 'dark' : ''; ?>"
								    data-index="<?php echo $i + 40; ?>"></li>
							<?php endfor; ?>
							</ul>
						</div>

						<p class="service-blurb">
							That's why focus on making mobile-friendly websites.
						</p>
					</div>

					<div class="service-item visible columns small-12 medium-4" data-index="2">
						<h2>
							40% of Internet Users Have Purchased Via eCommerce
						</h2>

						<div class="service-icons">
							<ul class="small-block-grid-12 medium-block-grid-8">
							<?php for ( $i = 0; $i < 40; $i ++ ) : ?>
								<li class="service-icon visible icon-cart <?php echo $i < 16 ? 'dark' : ''; ?>"
								    data-index="<?php echo $i + 80; ?>"></li>
							<?php endfor; ?>
							</ul>
						</div>

						<p class="service-blurb">
							That's why we build eCommerce websites
						</p>
					</div>

				</div>

			</div>

			<a href="#" class="scroll-down no-effect"><span class="icon-circle-down"></span></a>

		</section>

		<?php
		$portfolio = get_posts( array(
			'post_type'   => 'portfolio',
			'numberposts' => 3,
		) );
		?>

		<?php if ( ! empty( $portfolio ) ) : ?>

			<section id="what-weve-done" class="section portfolio green columns small-12">

				<div class="section-content">

					<?php rbm_section_title( 'What We\'ve Done', 'what-weve-done' ); ?>

					<div class="section-summary">
						We've built some pretty cool stuff. Take a look!
					</div>

					<a href="<?php echo get_permalink( 464 ); ?>" class="button secondary section-cta">
						We can build you a site like these
					</a>

					<div class="portfolios">

						<div class="portfolios-left icon-circle-left" style="display: none;"></div>

						<ul class="portfolio-list">
							<?php
							foreach ( $portfolio as $post ) :
								setup_postdata( $post );
								?>
								<li class="portfolio-item active no-js row">

									<h2 class="portfolio-title"><?php the_title(); ?></h2>

									<div class="portfolio-preview columns small-12 medium-8 large-8 small-centered">
										<?php the_post_thumbnail( 'full' ); ?>
									</div>
								</li>
							<?php
							endforeach;
							wp_reset_postdata();
							?>
						</ul>

						<div class="portfolios-right icon-circle-right" style="display: none;"></div>

					</div>
				</div>

				<a href="#" class="scroll-down no-effect"><span class="icon-circle-down"></span></a>

			</section>

		<?php endif; ?>

		<?php
		$testimonials = get_posts( array(
			'post_type'   => 'testimonial',
			'numberposts' => 8,
		) );

		// TODO Get testimonials to use
		$testimonials = false;
		?>

		<?php if ( ! empty( $testimonials ) ) : ?>

			<section id="what-people-say" class="section testimonials blue columns small-12">

				<div class="section-content">

					<?php rbm_section_title( 'What People Say', 'what-people-say' ); ?>

					<div class="section-summary">
						People seem to really like us, but don't take our word for it!
					</div>

					<a href="#" class="button section-cta">
						Join the list
					</a>

					<div class="clearfix"></div>

					<div class="testimonial-content">
						<?php
						foreach ( $testimonials as $post ) :
							setup_postdata( $post );
							?>
							<p class="active">
								<span class="testimonial-quote-icon icon-quotes-left"></span>
								<?php echo $post->post_content; ?>
							</p>
						<?php
						endforeach;
						wp_reset_postdata();
						?>
					</div>

					<ul class="testimonials-list small-block-grid-2 medium-block-grid-4">
						<?php
						foreach ( $testimonials as $post ) :
							setup_postdata( $post );
							?>
							<li class="testimonial-item active" data-square>
								<a class="no-effect testimonial-image" href="#">
									<?php the_post_thumbnail( 'full' ); ?>
								</a>
							</li>
						<?php
						endforeach;
						wp_reset_postdata();
						?>
					</ul>
				</div>

			</section>

		<?php endif; ?>

	</div>
<?php
get_footer();

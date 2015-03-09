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

		<div class="home-cta-cover"></div>

		<div class="home-cta-message">
			<h1 class="font-special">
				Something cool should be said here.
			</h1>

			<a href="#" class="button">
				Learn More
			</a>
		</div>

		<a href="#" class="scroll-down no-effect"><span class="icon-circle-down"></span></a>

	</section>

	<section id="who-we-are" class="section services blue columns small-12">

		<div class="section-content">

			<?php kidniche_section_title( 'Who We Are', 'who-we-are' ); ?>

			<div class="section-summary">
				We're a marketing firm with an emphasis on top-notch website creation.
			</div>

			<a href="#" class="button">
				See what we can do for you!
			</a>

			<p>
				More copy that perhaps should be here but <a href="#">link</a> perhaps shot lunot
			</p>
		</div>

		<a href="#" class="scroll-down no-effect"><span class="icon-circle-down"></span></a>

	</section>

<?php
$portfolio = get_posts( array(
	'post_type'   => 'portfolio',
	'numberposts' => 3,
) );
?>

	<section id="what-weve-done" class="section portfolio green columns small-12">

		<div class="section-content">

			<?php kidniche_section_title( 'What We\'ve Done', 'what-weve-done' ); ?>

			<div class="section-summary">
				We've built some pretty cool stuff. Take a look!
			</div>

			<?php if ( ! empty( $portfolio ) ) : ?>
				<ul class="portfolio-list">
					<?php
					foreach ( $portfolio as $post ) :
						setup_postdata( $post );
						?>
						<li class="portfolio-item">

							<h2 class="portfolio-title"><?php the_title(); ?></h2>

							<div class="portfolio-preview">
								<?php
								$image_full   = get_post_meta( $post->ID, '_portfolio_image_full', true );
								$image_mobile = get_post_meta( $post->ID, '_portfolio_image_mobile', true );

								if ( $image_full ) :
									?>
									<div class="portfolio-monitor">
										<?php
										echo wp_get_attachment_image( $image_full, 'full' );
										include __DIR__ . '/assets/images/monitor.php';
										?>
									</div>
								<?php
								endif;

								if ( $image_mobile ) :
									?>
									<div class="portfolio-phone">
										<?php
										echo wp_get_attachment_image( $image_mobile, 'full' );
										include __DIR__ . '/assets/images/phone.php';
										?>
									</div>
								<?php endif; ?>
							</div>
						</li>
					<?php
					endforeach;
					wp_reset_postdata();
					?>
				</ul>
			<?php endif; ?>
		</div>

		<a href="#" class="scroll-down no-effect"><span class="icon-circle-down"></span></a>

	</section>

<?php
$testimonials = get_posts( array(
	'post_type'   => 'testimonial',
	'numberposts' => 8,
) );
?>

	<section id="what-people-say" class="section testimonials blue columns small-12">

		<div class="section-content">

			<?php kidniche_section_title( 'What People Say', 'what-people-say' ); ?>

			<div class="section-summary">
				People seem to really like us. Here's why.
			</div>

			<?php if ( ! empty( $testimonials ) ) : ?>
				<ul class="testimonials-list small-block-grid-2 medium-block-grid-4">
					<?php
					foreach ( $testimonials as $post ) :
						setup_postdata( $post );
						?>
						<li class="testimonial-item">
							<?php the_post_thumbnail( 'full' ); ?>
						</li>
					<?php
					endforeach;
					wp_reset_postdata();
					?>
				</ul>
			<?php endif; ?>
		</div>
		
	</section>

</div>
<?php
get_footer();

function kidniche_section_title( $title = '', $anchor = '' ) {

	static $direction;
	$direction = $direction == 'left' ? 'right' : 'left';
	?>
	<h1 class="section-title <?php echo $direction; ?>">
		<a href="#<?php echo $anchor; ?>" class="force-color no-effect">
			<span class="text">
				<span class="icon">
					<span class="icon-flag"></span>
					<span class="icon-link"></span>
				</span>
				<?php echo $title; ?>
			</span>
		</a>
	</h1>
<?php
}
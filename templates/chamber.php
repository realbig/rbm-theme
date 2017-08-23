<?php
/**
 * Template Name: Chamber of Commerce Form
 *
 * The theme's page file use for displaying pages.
 *
 * @since   0.1.0
 * @package RBMTheme
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

get_header();

the_post();
?>

	<div class="page-content row">

		<article id="page-<?php the_ID(); ?>" <?php post_class( array( 'columns', 'small-12' ) ); ?>>

			<h1 class="page-title">
				<?php the_title(); ?>
			</h1>

			<?php the_content(); ?>

		</article>

	</div>

	<div class="row expand">
		<div id="who-we-are" class="section chamber blue columns small-12">

			<div class="section-go-up button tiny hidden">
				<span class="icon-arrow-up2"></span> Don't Forget!
			</div>

			<div class="section-content">

				<div class="section-summary">
					Did you know?
				</div>

				<div class="row text-left">
					<div class="columns small-12">
						<p>In 2014 web usage by handheld devices overtook laptop and desktop. One of the most important
							conversations you can have about your success is, "How will you engage clients, donors,
							customers, etc. on the devices they want to use.</p>

						<p>For example, business executives have changed how they research products and services but not
							necessarily how they buy from their vendors. Your wide screen presentation is still
							critical to closing, but your handheld presence should facilitate research. Do these
							statistics ring true
							with you?</p>
					</div>
				</div>

				<div class="chamber-list row">

					<?php $grid_count = 24; ?>

					<div class="chamber-item visible columns small-12 medium-6" data-index="0">
						<h2>
							92% Own a Smartphone for Business
						</h2>

						<div class="chamber-icons">
							<ul class="small-block-grid-12 medium-block-grid-8">
								<?php for ( $i = 0; $i < $grid_count; $i ++ ) : ?>
									<li class="chamber-icon visible icon-mobile <?php echo $i < ( 92 / 100 * $grid_count ) ? 'dark' : ''; ?>"
									    data-index="<?php echo $i + ( $grid_count * 0 ); ?>"></li>
								<?php endfor; ?>
							</ul>
						</div>
					</div>

					<div class="chamber-item visible columns small-12 medium-6" data-index="1">
						<h2>
							72% Use Smart Phone for Product / Service Research
						</h2>

						<div class="chamber-icons">
							<ul class="small-block-grid-12 medium-block-grid-8">
								<?php for ( $i = 0; $i < $grid_count; $i ++ ) : ?>
									<li class="chamber-icon visible icon-mobile <?php echo $i < ( 72 / 100 * $grid_count ) ? 'dark' : ''; ?>"
									    data-index="<?php echo $i + ( $grid_count * 1 ); ?>"></li>
								<?php endfor; ?>
							</ul>
						</div>
					</div>

					<div class="chamber-item visible columns small-12 medium-6" data-index="2">
						<h2>
							86% Use Tablet for Product / Service Research
						</h2>

						<div class="chamber-icons">
							<ul class="small-block-grid-12 medium-block-grid-8">
								<?php for ( $i = 0; $i < $grid_count; $i ++ ) : ?>
									<li class="chamber-icon visible icon-tablet <?php echo $i < ( 86 / 100 * $grid_count ) ? 'dark' : ''; ?>"
									    data-index="<?php echo $i + ( $grid_count * 2 ); ?>"></li>
								<?php endfor; ?>
							</ul>
						</div>
					</div>

					<div class="chamber-item visible columns small-12 medium-6" data-index="3">
						<h2>
							93% Use Desktop / Laptop to Purchase Online
						</h2>

						<div class="chamber-icons">
							<ul class="small-block-grid-12 medium-block-grid-8">
								<?php for ( $i = 0; $i < $grid_count; $i ++ ) : ?>
									<li class="chamber-icon visible icon-display <?php echo $i < ( 93 / 100 * $grid_count ) ? 'dark' : ''; ?>"
									    data-index="<?php echo $i + ( $grid_count * 3 ); ?>"></li>
								<?php endfor; ?>
							</ul>
						</div>
					</div>

				</div>

			</div>

		</div>
	</div>

<?php
get_footer();
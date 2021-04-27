<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package RBMTheme
 * @since FoundationPress 1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header>
	<?php if ( is_single() ) {		
		the_title( '<h1 class="entry-title">', '</h1>' );
		} else {
		the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		}
	?>
		<?php foundationpress_entry_meta(); ?>
	</header>
	<div class="entry-content">

		<?php if ( get_post_status() !== 'closed-job-posting' ) : ?>

			<a class="button job" href="/employment-application/?job=<?php echo urlencode( get_the_title() ); ?>">
				<?php _e( 'Apply here', 'rbm-theme' ); ?>
			</a>

		<?php else : ?>

			<?php echo wpautop( __( 'This posting has been closed.', 'rbm-theme' ) ); ?>

		<?php endif; ?>

		<?php the_content(); ?>

		<?php if ( get_post_status() !== 'closed-job-posting' ) : ?>

		<a class="button job" href="/employment-application/?job=<?php echo urlencode( get_the_title() ); ?>">
			<?php _e( 'Apply here', 'rbm-theme' ); ?>
		</a>

		<?php else : ?>

			<?php echo wpautop( __( 'This posting has been closed.', 'rbm-theme' ) ); ?>

		<?php endif; ?>

		<?php

			ob_start();

		?>

		Real Big Marketing, LLC. provides equal employment opportunities (EEO) to all employees and applicants for employment without regard to race, color, religion, sex, national origin, age, disability, or genetics. In addition to federal law requirements, Real Big Marketing. LLC. complies with applicable state and local laws governing nondiscrimination in employment in every location in which the company has facilities. This policy applies to all terms and conditions of employment, including recruiting, hiring, placement, promotion, termination, layoff, recall, transfer, leaves of absence, compensation, and training.

		Real Big Marketing, LLC. expressly prohibits any form of workplace harassment based on race, color, religion, gender, sexual orientation, gender identity or expression, national origin, age, genetic information, disability, or veteran status. Improper interference with the ability of Real Big Marketing, LLC’s employees to perform their job duties may result in discipline up to and including discharge.

		<?php 

			echo wpautop( ob_get_clean() ); ?>

		<?php edit_post_link( __( '(Edit)', 'rbm-theme' ), '<span class="edit-link">', '</span>' ); ?>

	</div>
	<footer>
		<?php
			wp_link_pages(
				array(
					'before' => '<nav id="page-nav"><p>' . __( 'Pages:', 'rbm-theme' ),
					'after'  => '</p></nav>',
				)
			);
		?>
		<?php $tag = get_the_tags(); if ( $tag ) { ?><p><?php the_tags(); ?></p><?php } ?>
	</footer>
</article>

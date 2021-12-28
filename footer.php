<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "off-canvas-wrap" div and all content after.
 *
 * @package RBMTheme
 * @since FoundationPress 1.0.0
 */
?>

</div><!-- Close container -->
<div class="footer-container">
	<footer class="footer">

		<div class="copyright expanded row">
			<div class="small-12 columns text-center">
				<?php echo sprintf( __( 'Copyright &copy; %s %s', 'rbm-theme' ), date( 'Y' ), get_bloginfo( 'name' ) ); ?>
			</div>
		</div>

	</footer>
</div>

</div><!-- Close off-canvas content -->

<?php 

$overlay_form = get_theme_mod( 'rbm_overlay_form' );
$testimonial_id = get_theme_mod( 'rbm_overlay_testimonial', '' );

if ( $overlay_form && function_exists( 'gravity_form' ) ) : ?>

<div class="reveal large" id="overlay-form" data-reveal>

	<div class="reveal-header grid-container">
		<div class="grid-x grid-margin-x grid-margin-y grid-padding-x grid-padding-y">
			<div class="rbm-logo-svg small-12 medium-2 cell">
				<?php echo file_get_contents( THEME_DIR . '/dist/assets/images/rbm-logo-full.svg' ); ?>
			</div>
			<div class="small-12 medium-10 cell">

				<?php $form = RGFormsModel::get_form( $overlay_form ); ?>

				<h2><?php echo esc_html( $form->title ); ?></h2>

			</div>
		</div>
		<button class="close-button" data-close aria-label="<?php _e( 'Close modal', 'rbm-theme' ); ?>" type="button">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>

	<div class="grid-container">
		<div class="grid-x grid-margin-x grid-margin-y grid-padding-x grid-padding-y">

			<div class="small-12 <?php echo ( $testimonial_id ) ? 'medium-7 medium-order-2' : ''; ?> cell">
				<?php gravity_form( $overlay_form, false, true, false, null, true ); ?>
			</div>

			<?php if ( $testimonial_id ) : ?>

				<div class="small-12 medium-5 medium-order-1 cell">

					<?php $testimonial = get_post( $testimonial_id ); ?>

					<div class="grid-container">
						<div class="testimonial grid-x grid-margin-x grid-margin-y grid-padding-x grid-padding-y" data-post_id="<?php echo $testimonial_id; ?>">

							<div class="cell small-12 medium-order-2">

								<?php echo apply_filters( 'the_content', $testimonial->post_content ); ?>

							</div>

							<div class="cell small-12 medium-order-1 text-center">
								<?php echo get_the_post_thumbnail( $testimonial_id, 'medium' ); ?>
							</div>

						</div>
					</div>

				</div>

			<?php endif; ?>

		</div>
	</div>
</div>

<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>

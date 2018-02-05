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
			
			<div class="row">
			
				<?php
				$footer_columns = get_theme_mod( 'rbm_theme_footer_columns', 4 );
				for ( $index = 0; $index < $footer_columns; $index++ ) {
					?>

						<div class = "small-12 medium-<?php echo ( 12 / $footer_columns ); ?> columns">
							<?php dynamic_sidebar( 'footer-' . ( $index + 1 ) ); ?>
						</div>

					<?php
				}
				?>
			
			</div>
			
		</footer>
	</div>

</div><!-- Close off-canvas content -->

<?php wp_footer(); ?>
</body>
</html>

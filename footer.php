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
				<?php echo sprintf( __( 'Copyright &copy; %s %s', 'real-big-marketing' ), date( 'Y' ), get_bloginfo( 'name' ) ); ?>
			</div>
		</div>

	</footer>
</div>

</div><!-- Close off-canvas content -->

<?php wp_footer(); ?>
</body>
</html>

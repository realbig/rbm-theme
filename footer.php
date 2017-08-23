<?php
/**
 * The theme's footer file that appears on EVERY page.
 *
 * @since 0.1.0
 * @package RBMTheme
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}
?>

</div> <!-- #site-content -->

<footer id="site-footer" class="row expanded">

	<hr/>

	<div class="footer-social columns small-12">
		<h2 class="font-special">
			Connect with us.
		</h2>

		<div class="footer-social-list row small-up-2 medium-up-4">
			<div class="column column-block"><a href="http://www.facebook.com/realbigmarketing" class="footer-social-icon force-color"><span class="icon-facebook"></span></a></div>
			<div class="column column-block"><a href="http://twitter.com/gorealbig" class="footer-social-icon force-color"><span class="icon-twitter"></span></a></div>
			<div class="column column-block"><a href="http://www.linkedin.com/company/real-big-marketing" class="footer-social-icon force-color"><span class="icon-linkedin"></span></a></div>
			<div class="column column-block"><a href="https://plus.google.com/+Realbigmarketing/" class="footer-social-icon force-color"><span class="icon-google"></span></a></div>
		</div>

		<p class="footer-phone">
			Call Us:
			<br/>
			<span class="phone-number">
				<?php if ( wp_is_mobile() ) : ?>
					<a href="tel:269-588-0556" class="button">
						(269) 588-0556
					</a>
				<?php else: ?>
					(269) 588-0556
				<?php endif; ?>
			</span>
		</p>
	</div>

<!--	<div class="footer-accreditations columns small-12 medium-6">-->
<!--		<img src="--><?php //echo get_template_directory_uri(); ?><!--/assets/images/chamber.jpg" />-->
<!--		<img src="http://advertise.bingads.microsoft.com/en-us/WWImages/search/en-us/BingAds_Accredited_Badge.png" />-->
<!--	</div>-->

	<div class="footer-search columns small-12">
		<?php get_search_form(); ?>
	</div>

	<div class="footer-menu columns small-12">
		<?php
		wp_nav_menu( array(
			'theme_location' => 'footer',
			'container' => false,
		));
		?>
	</div>

	<div class="footer-copyright columns small-12">
		<small>&copy <?php echo date( 'Y' ); ?> Real Big Marketing</small>
	</div>

</footer>

</div> <!-- #wrapper -->

<?php wp_footer(); ?>

</body>
</html>

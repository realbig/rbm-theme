<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "container" div.
 *
 * @package RBMTheme
 * @since FoundationPress 1.0.0
 */

?>
<!doctype html>
<html class="no-js" <?php language_attributes(); ?> >
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<?php wp_head(); ?>
	</head>
	<body 
		<?php body_class( array(
		'offcanvas',
	)); ?>>

	<?php wp_body_open(); ?>

	<nav class="mobile-off-canvas-menu off-canvas position-right" id="off-canvas-menu" data-off-canvas data-auto-focus="false" role="navigation">
		<?php foundationpress_mobile_nav(); ?>
	</nav>

	<div class="off-canvas-content" data-off-canvas-content>

		<div data-sticky-container>

			<header class="site-header sticky-top-bar<?php echo ( is_admin_bar_showing() ? ' admin-bar' : '' ) ; ?>" data-sticky data-margin-top="<?php echo ( is_admin_bar_showing() ? '0' : '0' ) ; ?>" data-sticky-on="small" role="banner">
				
				<div class="row">
					<div class="small-12 columns">
					
						<div class="site-title-bar title-bar">
							<div class="title-bar-left">
								<span class="site-mobile-title title-bar-title show-for-small-only">
									<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">

										<div class="rbm-logo-svg">
											<?php echo file_get_contents( THEME_DIR . '/dist/assets/images/rbm-logo-full.svg' ); ?>
										</div>

										<div class="rbm-logo-svg small-version">
											<?php echo file_get_contents( THEME_DIR . '/dist/assets/images/rbm-logo-small.svg' ); ?>
										</div>

									</a>
								</span>
								<button class="menu-icon<?php echo ( is_front_page() ? ' dark' : '' ); ?>" type="button" data-toggle="off-canvas-menu"></button>
							</div>
						</div>

						<nav class="site-navigation top-bar" role="navigation">
							<div class="site-desktop-title top-bar-title hide-for-small-only">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">

									<div class="rbm-logo-svg">
										<?php echo file_get_contents( THEME_DIR . '/dist/assets/images/rbm-logo-full.svg' ); ?>
									</div>

								</a>
							</div>
							<div class="top-bar-right">
								<?php foundationpress_top_bar_r(); ?>
							</div>
						</nav>
						
					</div>
				</div>
			
			</header>

		</div>

		<div class="container">

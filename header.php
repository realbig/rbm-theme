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
	<body <?php body_class( array(
		'offcanvas',
	)); ?>>

	<?php get_template_part( 'template-parts/mobile-off-canvas' ); ?>

	<header class="site-header" role="banner">
		<div class="site-title-bar title-bar">
			<div class="title-bar-left">
				<button class="menu-icon<?php echo ( is_front_page() ? ' dark' : '' ); ?>" type="button" data-toggle="off-canvas-menu"></button>
				<span class="site-mobile-title title-bar-title show-for-small-only">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						
						<?php if ( is_front_page() ) : ?>
							<?php echo file_get_contents( THEME_DIR . '/dist/assets/images/RBM-Logo-for-use-on-Black-Background.svg' ); ?>
						<?php else : ?>
							<?php echo file_get_contents( THEME_DIR . '/dist/assets/images/RBM-Logo-for-use-on-Dark-Blue-Background.svg' ); ?>
						<?php endif; ?>
						
					</a>
				</span>
			</div>
		</div>

		<nav class="site-navigation top-bar" role="navigation">
			<div class="site-desktop-title top-bar-title hide-for-small-only">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">

					<?php if ( is_front_page() ) : ?>
						<?php echo file_get_contents( THEME_DIR . '/dist/assets/images/RBM-Logo-for-use-on-Black-Background.svg' ); ?>
					<?php else : ?>
						<?php echo file_get_contents( THEME_DIR . '/dist/assets/images/RBM-Logo-for-use-on-Dark-Blue-Background.svg' ); ?>
					<?php endif; ?>

				</a>
			</div>
			<div class="top-bar-left">
				<?php foundationpress_top_bar_r(); ?>
			</div>
		</nav>
		
	</header>

	<div class="container">

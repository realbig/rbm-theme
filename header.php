<?php
/**
 * The theme's header file that appears on EVERY page.
 *
 * @since   0.1.0
 * @package RBMTheme
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">

	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/vendor/js/html5.js"></script>
	<![endif]-->

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="wrapper">

	<div id="back-cover"></div>

	<header id="site-header">

		<h1 class="site-title">
			<a href="<?php bloginfo( 'url' ); ?>" class="no-effect">
				<span class="color-secondary">Real</span>
				<span class="color-primary" style="font-size: 1.5em;">Big</span>
				<br/>
				<span class="color-secondary">Marketing</span>
			</a>
		</h1>

		<nav class="site-nav-left show-for-medium-up">
			<?php
			wp_nav_menu( array(
				'menu_id'        => 'menu-top-left',
				'theme_location' => 'primary-left',
				'container'      => false,
			) );
			?>
		</nav>

		<nav class="site-nav-mobile hide-for-medium-up">
			<?php
			wp_nav_menu( array(
				'menu_id'        => 'menu-top-left-mobile',
				'theme_location' => 'primary-left',
				'container'      => false,
			) );

			wp_nav_menu( array(
				'menu_id'        => 'menu-top-right-mobile',
				'theme_location' => 'primary-right',
				'container'      => false,
			) );
			?>

			<a href="#menu-top-primary-mobile" class="toggle-mobile-nav" data-toggle-mobile-nav>
				<span class="icon-menu"></span>
			</a>

			<?php
			wp_nav_menu( array(
				'menu_id'        => 'menu-top-primary-mobile',
				'theme_location' => 'primary-center',
				'container'      => false,
			) );
			?>
		</nav>

		<div class="site-logo">
			<?php include __DIR__ . '/assets/images/rbm-logo.php'; ?>
		</div>

		<nav class="site-nav-circular show-for-medium-up">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary-center',
				'container'      => false,
				'walker'         => new RBMTheme_Walker_CircularNav(),
			) );
			?>
		</nav>

		<nav class="site-nav-right show-for-medium-up">
			<?php
			wp_nav_menu( array(
				'menu_id'        => 'menu-top-right',
				'theme_location' => 'primary-right',
				'container'      => false,
			) );
			?>
		</nav>

		<div id="header-tip" style="display: none;">
			<span class="icon-arrow-up"></span>
			<?php echo wp_is_mobile() ? 'Tap' : 'Click'; ?> here to reveal the menu
		</div>

	</header>

	<div id="site-content">
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

	<header id="site-header" class="reveal">

		<h1 class="site-title">
			<a href="<?php bloginfo( 'url' ); ?>">
				<?php bloginfo( 'name' ); ?>
			</a>
		</h1>

		<nav class="site-nav-left">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary-left',
				'container' => false,
			));
			?>
		</nav>

		<div class="site-logo">
				<?php include __DIR__ . '/assets/images/rbm-logo.php'; ?>
		</div>

		<nav class="site-nav-right">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary-right',
				'container' => false,
			));
			?>
		</nav>

	</header>

	<div id="site-content" class="row expand">
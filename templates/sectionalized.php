<?php
/**
 * Template Name: Sectionalized
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

	<div class="page-content row expand">

		<?php the_content(); ?>

	</div>

<?php
global $rbm_sectionalized_content;
if ( ! empty( $rbm_sectionalized_content ) ) :
	?>
	<div class="row">
		<div class="columns small-12">
			<?php echo apply_filters( 'the_content', $rbm_sectionalized_content ); ?>
		</div>
	</div>
<?php endif; ?>

<?php
get_footer();
<?php
/**
 * Created by PhpStorm.
 * User: kylemaurer
 * Date: 3/11/15
 * Time: 8:33 PM
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

get_header();

the_post();
?>

	<div class="row page-content">

		<article id="page-<?php the_ID(); ?>" <?php post_class( array( 'columns', 'small-12' ) ); ?>>

			<h1 class="page-title">
				<?php the_title(); ?>
			</h1>

			<?php echo get_avatar(get_the_author_meta('ID'), 200); ?>

			<?php the_content(); ?>

		</article>

	</div>

<?php
get_footer();
<?php
/**
 * The editor-only template for displaying page content - excludes the header title and page meta in the footer
 *
 *
 * @package RBMTheme
 * @since FoundationPress 1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		<?php the_content(); ?>
		<?php edit_post_link( __( '(Edit)', 'rbm-theme' ), '<span class="edit-link">', '</span>' ); ?>
	</div>
</article>
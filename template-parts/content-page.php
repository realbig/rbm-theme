<?php
/**
 * The default template for displaying page content
 *
 *
 * @package RBMTheme
 * @since FoundationPress 1.0.0
 */

global $has_hero;

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( ! $has_hero ) : ?>
		<header>
			<h1 class="entry-title"><?php the_title(); ?></h1>
		</header>
	<?php endif; ?>
	<div class="entry-content">
		<?php the_content(); ?>
		<?php edit_post_link( __( '(Edit)', 'rbm-theme' ), '<span class="edit-link">', '</span>' ); ?>
	</div>
	<footer>
		<?php
			wp_link_pages(
				array(
					'before' => '<nav id="page-nav"><p>' . __( 'Pages:', 'rbm-theme' ),
					'after'  => '</p></nav>',
				)
			);
		?>
		<?php $tag = get_the_tags(); if ( $tag ) { ?><p><?php the_tags(); ?></p><?php } ?>
	</footer>
</article>
<?php
/**
 * The default template for displaying page content
 *
 *
 * @package RBMTheme
 * @since FoundationPress 1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header>
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header>
	<div class="entry-content">

		<?php the_content(); ?>

        <?php

            $open_positions = new WP_Query( array(
                'post_type' => 'jobs',
                'posts_per_page' => -1,
                'fields' => 'ids',
                'post_status' => 'publish',
                'order' => 'DESC',
                'orderby' => 'date',
            ) );

            $closed_positions = new WP_Query( array(
                'post_type' => 'jobs',
                'posts_per_page' => -1,
                'fields' => 'ids',
                'post_status' => 'closed-job-posting',
                'order' => 'DESC',
                'orderby' => 'date',
            ) );

            if ( $open_positions->have_posts() ) : ?>

                <h2><?php _e( 'Open Positions:', 'rbm-theme' ); ?></h2>

                <ul>

                    <?php foreach ( $open_positions->posts as $post_id ) : ?>

                        <li>
                            <a href="<?php echo get_the_permalink( $post_id ); ?>">
                                <?php echo get_the_title( $post_id ); ?>
                            </a>
                        </li>

                    <?php endforeach; ?>

                </ul>

                <?php

            endif;

            if ( $closed_positions->have_posts() ) : ?>

                <h2><?php _e( 'Closed Positions:', 'rbm-theme' ); ?></h2>

                <ul>

                    <?php foreach ( $closed_positions->posts as $post_id ) : ?>

                        <li>
                            <a href="<?php echo get_the_permalink( $post_id ); ?>">
                                <?php echo get_the_title( $post_id ); ?>
                            </a>
                        </li>

                    <?php endforeach; ?>

                </ul>

                <?php

            endif;

        ?>

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
<?php

add_filter( 'render_block', 'rbm_alter_post_title_block_frontend_output', 10, 2 );

/**
 * Alter output of all core/post-title Blocks to match the Theme
 *
 * @param   string  $block_content  Block HTML
 * @param   array   $block          Block Settings
 *
 * @since   {{VERSION}}
 * @return  string                  Block HTML
 */
function rbm_alter_post_title_block_frontend_output( $block_content, $block ) {

    if ( $block['blockName'] != 'core/post-title') return $block_content;

    $style = array();

    if ( ! isset( $block['attrs']['level'] ) ) {

        $block_content = str_replace( '<h2', '<h1', $block_content );
        $block_content = str_replace( '</h2>', '</h1>', $block_content );

    }

    return $block_content;

}
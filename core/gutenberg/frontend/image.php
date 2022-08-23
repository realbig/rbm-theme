<?php

add_filter( 'render_block', 'rbm_alter_image_block_frontend_output', 10, 2 );

/**
 * Alter output of all core/image Blocks to match the Theme
 *
 * @param   string  $block_content  Block HTML
 * @param   array   $block          Block Settings
 *
 * @since   {{VERSION}}
 * @return  string                  Block HTML
 */
function rbm_alter_image_block_frontend_output( $block_content, $block ) {

    if ( $block['blockName'] != 'core/image') return $block_content;

    $style = array();

    if ( isset( $block['attrs']['height'] ) && $block['attrs']['height'] ) {

        $block_content = preg_replace( '/height="[\s\S]*?"/sim', '', $block_content );

        $style['height'] = "height: {$block['attrs']['height']}px";

    }

    if ( isset( $block['attrs']['width'] ) && $block['attrs']['width'] ) {

        $block_content = preg_replace( '/width="[\s\S]*?"/sim', '', $block_content );

        $style['width'] = "width: {$block['attrs']['width']}px";

    }

    if ( ! empty( $style ) ) {

        $match = preg_match( '/<img[\s\S]*?style="([\s\S]*?)"/sim', $block_content, $matches );

        if ( $match && isset( $matches[1] ) && $matches[1] ) {

            // Append to existing style tag
            $block_content = str_replace( $matches[1], $matches[1] . implode( ';', $style ), $block_content );

        }
        else {

            // Create our own style tag
            $block_content = str_replace( '<img', '<img style="' . implode( ';', $style ) . '"', $block_content );

        }

    }

    return $block_content;

}
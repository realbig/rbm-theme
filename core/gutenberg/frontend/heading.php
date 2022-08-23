<?php

add_filter( 'render_block', 'rbm_alter_heading_block_frontend_output', 10, 2 );

/**
 * Alter output of all core/heading Blocks to match the Theme
 * This allows the block to be inline with other items
 *
 * @param   string  $block_content  Block HTML
 * @param   array   $block          Block Settings
 *
 * @since   {{VERSION}}
 * @return  string                  Block HTML
 */
function rbm_alter_heading_block_frontend_output( $block_content, $block ) {

    if ( $block['blockName'] != 'core/heading') return $block_content;

    if ( ! isset( $block['attrs']['display'] ) || ! $block['attrs']['display'] ) return $block_content; 

    if ( $block['attrs']['display'] == 'block' ) return $block_content;

    $match = preg_match( '/<h[1-6][\s\S].*?>/i', $block_content, $matches );

    if ( ! $match || ! isset( $matches[0] ) || ! $matches[0] ) return $block_content;

    $opening_h_tag = $matches[0];

    $class = "display-{$block['attrs']['display']}";

    $match = preg_match( '/class="([\s\S]*?)"/i', $opening_h_tag, $matches );

    if ( $match && isset( $matches[1] ) && $matches[1] ) {
        $class .= " {$matches[1]}";
        $block_content = str_replace( $matches[1], $class, $block_content );
    }
    else {

        $block_content = str_replace( $opening_h_tag, str_replace( '>', " class=\"{$class}\">", $opening_h_tag ), $block_content );

    }

    return $block_content;

}
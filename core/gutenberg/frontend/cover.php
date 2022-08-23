<?php

add_filter( 'render_block', 'rbm_alter_cover_block_frontend_output', 10, 2 );

/**
 * Alter output of all core/cover Blocks to match the Theme
 * Specifically, this adds some mobile-only controls that surprisingly aren't a part of WP Core
 *
 * @param   string  $block_content  Block HTML
 * @param   array   $block          Block Settings
 *
 * @since   {{VERSION}}
 * @return  string                  Block HTML
 */
function rbm_alter_cover_block_frontend_output( $block_content, $block ) {

    if ( $block['blockName'] != 'core/cover') return $block_content;

    if ( ( ! isset( $block['attrs']['url'] ) || empty( $block['attrs']['url'] ) ) && ( ! isset( $block['attrs']['overlayColor'] ) || empty( $block['attrs']['overlayColor'] ) ) && ( ! isset( $block['attrs']['mobileFocalPoint'] ) || empty( $block['attrs']['mobileFocalPoint'] ) ) && ( isset( $block['attrs']['mobilePadding'] ) && empty( $block['attrs']['mobilePadding'] ) ) && ( isset( $block['attrs']['verticalAlignment'] ) && empty( $block['attrs']['verticalAlignment'] ) ) ) return $block_content;

    $match = preg_match( '/^<div[\s\S]*?>/i', trim( $block_content ), $matches );

    if ( ! $match || ! isset( $matches[0] ) || ! $matches[0] ) return $block_content;

    $opening_div_tag = $matches[0];

    $id = wp_generate_uuid4();

    $match = preg_match( '/id="([\s\S]*?)"/i', $opening_div_tag, $matches );

    if ( $match && isset( $matches[1] ) && $matches[1] ) {
        $id = $matches[1];
    }
    else {

        $block_content = str_replace( $opening_div_tag, str_replace( '<div', "<div id=\"{$id}\"", $opening_div_tag ), $block_content );

    }

    $match = preg_match( '/^<div[\s\S]*?>/i', trim( $block_content ), $matches );

    if ( ! $match || ! isset( $matches[0] ) || ! $matches[0] ) return $block_content;

    // Reassign opening <div> tag for later
    $opening_div_tag = $matches[0];

    $style = "<style type=\"text/css\">
        @media only screen and ( max-width: 639px ) {
    ";

    if ( isset( $block['attrs']['url'] ) && ! empty( $block['attrs']['url'] ) ) {

        $new_opening_div_tag = str_replace( 'wp-block-cover', 'wp-block-cover has-image-background', $opening_div_tag );

        $block_content = str_replace( $opening_div_tag, $new_opening_div_tag, $block_content );

        $opening_div_tag = $new_opening_div_tag;
        unset( $new_opening_div_tag );
        
    }

    if ( isset( $block['attrs']['overlayColor'] ) && ! empty( $block['attrs']['overlayColor'] ) ) {

        $new_opening_div_tag = str_replace( '<div', "<div data-overlayColor=\"{$block['attrs']['overlayColor']}\"", $opening_div_tag );

        $block_content = str_replace( $opening_div_tag, $new_opening_div_tag, $block_content );

        $opening_div_tag = $new_opening_div_tag;
        unset( $new_opening_div_tag );
        
    }

    if ( isset( $block['attrs']['mobileFocalPoint'] ) && ! empty( $block['attrs']['mobileFocalPoint'] ) ) {

        $block['attrs']['mobileFocalPoint'] = array_map( function( $value ) {

            return $value * 100;

        }, $block['attrs']['mobileFocalPoint'] );

        $style .= ".wp-block-cover[id=\"{$id}\"] img {

            object-position: {$block['attrs']['mobileFocalPoint']['x']}% {$block['attrs']['mobileFocalPoint']['y']}% !important;

        }";
        
    }

    if ( isset( $block['attrs']['mobilePadding'] ) && ! empty( $block['attrs']['mobilePadding'] ) ) {

        $style .= ".wp-block-cover[id=\"{$id}\"] {";

            foreach ( $block['attrs']['mobilePadding'] as $position => $value ) {

                $style .= "padding-{$position}: {$value} !important;";

            }

        $style .= "}";
        
    }

    $style .= "}";

    if ( isset( $block['attrs']['verticalAlignment'] ) && ! empty( $block['attrs']['verticalAlignment'] ) ) {

        $style .= ".wp-block-cover[id=\"{$id}\"] .wp-block-cover__inner-container {

            align-self: {$block['attrs']['verticalAlignment']};

        }";
        
    }

    $style .= "</style>";

    $block_content = str_replace( $opening_div_tag, $opening_div_tag . $style, $block_content );

    return $block_content;

}
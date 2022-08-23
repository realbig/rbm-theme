<?php

add_filter( 'render_block', 'rbm_alter_columns_block_frontend_output', 10, 2 );

/**
 * Alter output of all core/columns Blocks to allow reordering on Mobile vs Desktop
 *
 * @param   string  $block_content  Block HTML
 * @param   array   $block          Block Settings
 *
 * @since   {{VERSION}}
 * @return  string                  Block HTML
 */
function rbm_alter_columns_block_frontend_output( $block_content, $block) {

    if ( $block['blockName'] != 'core/columns') return $block_content;

    // Shouldn't really happen, but just in case
    if ( ! isset( $block['innerBlocks'] ) || empty( $block['innerBlocks'] ) ) return $block_content;

    $mobileWidth = false;

    // Ensures that we only run logic if mobile has a set width
    if ( isset( $block['attrs']['mobileScroll'] ) && $block['attrs']['mobileScroll'] ) {
        
        if ( isset( $block['attrs']['mobileWidth'] ) && $block['attrs']['mobileWidth'] ) {

            $mobileWidth = $block['attrs']['mobileWidth'];

        }
        else {

            // Default, 1 column
            $mobileWidth = 80;

        }

    }

    // Ensures that we only run logic if any mobile re-ordering occured
    $with_mobile_order = array_filter( $block['innerBlocks'], function( $column ) {

        return isset( $column['attrs']['mobileOrder'] ) && $column['attrs']['mobileOrder'];

    } );

    if ( ! $mobileWidth && empty( $with_mobile_order ) ) return $block_content;

    // Sort Innerblocks to match re-arranged order
    // This is how the DOM will be output so that by default things are in Mobile-order and then re-arranged via CSS for larger screen sizes
    uasort( $block['innerBlocks'], function( $a, $b ) {

        // Set some defaultss

        $a['attrs'] = wp_parse_args( $a['attrs'], array(
            'mobileOrder' => 0,
        ) );

        $b['attrs'] = wp_parse_args( $b['attrs'], array(
            'mobileOrder' => 0,
        ) );

        if ( $a['attrs']['mobileOrder'] == 'initial' ) $a['attrs']['mobileOrder'] = 0;

        if ( $b['attrs']['mobileOrder'] == 'initial' ) $b['attrs']['mobileOrder'] = 0;

        if ( $a['attrs']['mobileOrder'] == $b['attrs']['mobileOrder'] ) return 0;

        return ( $a['attrs']['mobileOrder'] < $b['attrs']['mobileOrder'] ) ? -1 : 1;

    } );

    try {

        // Generating a valid RegEx to match the immediate children of the Columns Block is not really feasible since <div> elements can exist within a Column, so we've used DOMDocument and DOMXPath to get around this limitation
        $dom = new DOMDocument();
        $dom->loadHTML( $block_content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );

        $xpath = new DOMXPath( $dom );

        // XPath expression to match a CSS class is weird
        // https://devhints.io/xpath#class-check
        $children = $xpath->query( "/*[contains( concat( ' ', normalize-space( @class ), ' ' ), 'wp-block-columns' ) ]/*" );

        $new_inner_block_html = '';

        foreach ( $block['innerBlocks'] as $index => $inner_block ) {

            // Since we used uasort(), the indices were left alone
            // This means we are referencing them in the "old order" to then put into the "new order"
            $child = $children->item( $index );

            if ( ! $child ) continue;

            // Capture full HTML of this Column
            $document = new DOMDocument();
            $document->appendChild( $document->importNode( $child, true ) );
            $html = $document->saveHTML();

            // For tracking changes
            $new_html = $html;

            // Swap in a source-ordering Class based on the mobileOrder Setting and then append the modified HTML to our variable
            if ( isset( $inner_block['attrs']['mobileOrder'] ) && $inner_block['attrs']['mobileOrder'] ) {

                $match = preg_match( '/<div[\s\S]*?class="[\s\S]*?wp-block-column[\s\S].*?>/sim', $html, $matches );

                if ( $match && isset( $matches[0] ) && $matches[0] ) {

                    $opening_tag = $matches[0];

                    $class_name = 'medium-order-' . ( $index + 1 );

                    $new_html = str_replace( 
                        $opening_tag, 
                        str_replace( 'wp-block-column', "wp-block-column {$class_name}", $opening_tag ),
                        $new_html
                    );

                }

            }

            if ( $mobileWidth ) {

                $match = preg_match( '/<div[\s\S]*?class="[\s\S]*?wp-container-(\d+)[\s\S]*?wp-block-column[\s\S]*?>/sim', $html, $matches );

                if ( $match && isset( $matches[1] ) && $matches[1] ) {

                    $container_class = "wp-container-{$matches[1]}";

                    $style = "
                        <style type=\"text/css\">
                            @media only screen and ( max-width: 639px ) {

                                .{$container_class} {

                                    flex-basis: {$mobileWidth}% !important;

                                }

                            }
                        </style>
                    ";

                    $new_html = $style . $new_html;

                }

            }

            if ( $new_html != $html ) {

                $new_inner_block_html .= $new_html;

            }

        }

        if ( empty( $new_inner_block_html ) ) return $block_content;

        // Swap in modified Block content

        $match = preg_match( '/<div[\s\S]*?class="[\s\S]*?wp-block-columns[\s\S].*?>([\s\S]*)<\/div>/sim', $block_content, $matches );

        if ( $match && isset( $matches[1] ) && $matches[1] ) {

            $block_content = str_replace( $matches[1], $new_inner_block_html, $block_content );

        }

    }
    catch ( Exception $exception ) {
        
    }

    return $block_content;

}
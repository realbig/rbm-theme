<?php

add_filter( 'render_block', 'rbm_alter_button_block_frontend_output_queried_post_link', 10, 2 );

/**
 * Alter output of all core/button Blocks to match the Theme
 * This adds the ability to link to the queried post, which is oddly not supportred in WP
 *
 * @param   string  $block_content  Block HTML
 * @param   array   $block          Block Settings
 *
 * @since   {{VERSION}}
 * @return  string                  Block HTML
 */
function rbm_alter_button_block_frontend_output_queried_post_link( $block_content, $block ) {

    if ( $block['blockName'] != 'core/button') return $block_content;

    if ( ! isset( $block['attrs']['linkToQueriedPost'] ) || ! $block['attrs']['linkToQueriedPost'] ) return $block_content;

    $match = preg_match( '/<(?:a).*?>/i', $block_content, $matches );

    if ( ! $match || ! isset( $matches[0] ) || ! $matches[0] ) return $block_content;

    $opening_tag = $matches[0];

    // Remove any existing link. We will add it back later. A bit easier than attempting to account for there or not.
    $new_opening_tag = preg_replace( '/href=".*?"/sim', '', $opening_tag );

    // The loop has already populated $post, so we can grab it nicely here
    $url = get_the_permalink();

    $new_opening_tag = str_replace( '>', "href=\"{$url}\">", $new_opening_tag );

    $block_content = str_replace( $opening_tag, $new_opening_tag, $block_content );

    return $block_content;

}

add_filter( 'render_block', 'rbm_alter_button_block_frontend_output_gravity_forms', 11, 2 );

/**
 * Alter output of all core/button Blocks to match the Theme
 * This adds the ability to use the Buttons for Gravity Forms
 *
 * @param   string  $block_content  Block HTML
 * @param   array   $block          Block Settings
 *
 * @since   {{VERSION}}
 * @return  string                  Block HTML
 */
function rbm_alter_button_block_frontend_output_gravity_forms( $block_content, $block ) {

    if ( $block['blockName'] != 'core/button') return $block_content;

    if ( ! function_exists( 'gravity_form' ) ) return $block_content;

    if ( ! isset( $block['attrs']['gravityForm'] ) || ! $block['attrs']['gravityForm'] ) return $block_content;

    $block['attrs'] = wp_parse_args( $block['attrs'], array(
        'gravityFormShowTitle' => true,
        'gravityFormShowDescription' => false,
    ) );

    $match = preg_match( '/<(?:a|button).*?>/i', $block_content, $matches );

    if ( ! $match || ! isset( $matches[0] ) || ! $matches[0] ) return $block_content;

    $opening_tag = $matches[0];

    $uuid = wp_generate_uuid4();

    $new_opening_tag = str_replace( '>', " data-open=\"reveal-{$uuid}\">", $opening_tag );

    // No longer linking to other items
    $new_opening_tag = preg_replace( '/href=".*?"/sim', '', $new_opening_tag );
    $new_opening_tag = preg_replace( '/target=".*?"/sim', '', $new_opening_tag );
    $new_opening_tag = preg_replace( '/rel=".*?"/sim', '', $new_opening_tag );

    // Convert to a button, which is more appropriate for the use case
    $new_opening_tag = str_replace( '<a', '<button', $new_opening_tag );
    $block_content = str_replace( '</a>', '</button>', $block_content );
    
    // Swap in modified opening tag. Closing tag was already handled above
    $block_content = str_replace( $opening_tag, $new_opening_tag, $block_content );

    $reveal_modal = '';

    ob_start();

    ?>

    <div class="reveal large" id="reveal-<?php echo esc_attr( $uuid ); ?>" data-reveal>

        <?php gravity_form( $block['attrs']['gravityForm'], $display_title = $block['attrs']['gravityFormShowTitle'], $display_description = $block['attrs']['gravityFormShowDescription'], $display_inactive = false, $field_values = null, $ajax = true, $tabindex = 0, $echo = true ); ?>

        <button class="close-button" data-close aria-label="<?php _e( 'Close modal', 'rbm-theme' ); ?>" type="button">
            <span aria-hidden="true">&times;</span>
        </button>

    </div>

    <?php

    $reveal_modal = ob_get_clean();

    return $block_content . $reveal_modal;

}
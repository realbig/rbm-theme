<?php
/**
 * Adds the [rbm_form_overlay] shortcode
 *
 * @since   1.3.0
 * @package RBMTheme
 * @subpackage  RBMTheme/library/shortcodes
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Add Form Overlay Shortcode
 *
 * @since       1.3.0
 * @return      HTML
 */
add_shortcode( 'rbm_form_overlay', 'add_rbm_button_form_overlay_shortcode' );
function add_rbm_button_form_overlay_shortcode( $atts, $content = '' ) {
    
    $atts = shortcode_atts(
        array( // a few default values
			'form_id' => 0,
            'title' => 'true',
            'description' => 'false',
            'color' => 'secondary',
        ),
        $atts,
        'rbm_form_overlay'
    );

    if ( ! $atts['form_id'] ) return '';
    
    ob_start();
	
	// Copy of Foundation's implementation, but in PHP
	// This should prevent collisions as they need to be unique
	// Math.round( Math.pow( 36, 7 ) - Math.random() * Math.pow( 36, 6 ) ).toString( 36 ).slice( 1 ) + '-reveal';
	$uuid = substr( base_convert( round( pow( 36, 7 ) - ( mt_rand() / mt_getrandmax() ) * pow( 36, 6 ) ), 10, 36 ), 1 ) . '-reveal';
	
    $border_radius = esc_attr( $atts['border_radius'] );
    $bg_color = esc_attr( $atts['bg_color'] );
    ?>

	<button data-open="<?php echo $uuid; ?>"
    class="button <?php echo esc_attr( $atts['color'] ); ?>">
		<?php echo ( $content ) ? esc_html( strip_tags( $content ) ) : __( 'Open Form', 'rbm-theme' ); ?>
    </button>

	<div class="reveal" id="<?php echo $uuid; ?>" data-reveal>

        <?php if ( function_exists( 'gravity_form' ) ) : ?>

            <?php gravity_form( $atts['form_id'], false, true, false, null, true ); ?>

        <?php endif; ?>

		<button class="close-button" data-close aria-label="<?php _e( 'Close modal', 'rbm-theme' ); ?>" type="button">
			<span aria-hidden="true">&times;</span>
		</button>

	</div>

    <?php
    
    $output = ob_get_contents();
    ob_end_clean();
    
    return $output;
    
}

/**
 * Add Form Overlay Shortcode to TinyMCE
 *
 * @since       1.3.0
 * @return      void
 */
add_action( 'admin_init', 'add_rbm_form_overlay_tinymce_filters' );
function add_rbm_form_overlay_tinymce_filters() {
    
    if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
        
        add_filter( 'mce_buttons', function( $buttons ) {
            array_push( $buttons, 'rbm_form_overlay_shortcode' );
            return $buttons;
        } );
        
        // Attach script to the button rather than enqueueing it
        add_filter( 'mce_external_plugins', function( $plugin_array ) {
            $plugin_array['rbm_form_overlay_shortcode_script'] = get_stylesheet_directory_uri() . '/dist/assets/js/tinymce/form-overlay-shortcode.js';
            return $plugin_array;
        } );
        
    }
    
}

/**
 * Add Localized Text for our TinyMCE Form Overlay
 *
 * @since       1.3.0
 * @return      Array Localized Text
 */
add_filter( 'rbm_tinymce_l10n', 'rbm_form_overlay_tinymce_l10n' );
function rbm_form_overlay_tinymce_l10n( $l10n ) {

    $gravity_forms = array();

    if ( class_exists( 'RGFormsModel' ) ) {
	
        $gravity_forms = wp_list_pluck( RGFormsModel::get_forms( null, 'title' ), 'title', 'id' );
        
    }
    
    $l10n['rbm_form_overlay_shortcode'] = array(
        'tinymce_title' => __( 'Add Form Overlay', 'rbm-theme' ),
        'button_text' => array(
            'label' => __( 'Button Text', 'rbm-theme' ),
        ),
		'form_id' => array(
			'label' => __( 'Gravity Form', 'rbm-theme' ),
			'choices' => $gravity_forms,
		),
        'title' => array(
            'label' => __( 'Show the form title?', 'rbm-theme' ),
        ),
        'description' => array(
            'label' => __( 'Show the form description?', 'rbm-theme' ),
        ),
        'color' => array(
            'label' => __( 'Button Color', 'rbm-theme' ),
            'choices' => array(
                'secondary' => __( 'Green', 'rbm-theme' ),
                'primary' => __( 'Blue', 'rbm-theme' ),
            ),
            'default' => 'secondary',
        )
    );
    
    return $l10n;
    
}

/**
 * wp_localize_script() doesn't work on non-enqueued scripts like TinyMCE Plugins
 * So we're going to fake it!
 *
 * @since       1.3.0
 * @return      void
 */
add_action( 'before_wp_tiny_mce', 'rbm_localize_tinymce' );
function rbm_localize_tinymce() {
    
    if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) :
    
        $object_name = apply_filters( 'rbm_tinymce_l10n_object_name', 'rbm_tinymce_l10n' );

        $l10n = apply_filters( 'rbm_tinymce_l10n', array() );

        foreach ( $l10n as $key => $value ) {

            if ( ! is_scalar( $value ) )
                continue;

            $l10n[ $key ] = html_entity_decode( (string) $value, ENT_QUOTES, 'UTF-8' );

        }

        $script = "var $object_name = " . wp_json_encode( $l10n ) . ';';

        $script = "/* <![CDATA[ */\n" . $script . "\n/* ]]> */";

        ?>

        <script type="text/javascript"><?php echo $script; ?></script>

        <?php
    
    endif;

}
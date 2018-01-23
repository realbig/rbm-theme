<?php
/**
 * Home extra meta.
 *
 * @since   1.0.0
 * @package RBMTheme
 * @subpackage  RBMTheme/library/admin/extra-meta
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Quick access to plugin field helpers.
 *
 * @since 1.0.0
 *
 * @return RBM_FieldHelpers
 */
function rbm_theme_field_helpers() {

    global $rbm_theme_field_helpers;

	return $rbm_theme_field_helpers;

}

/**
 * Initializes a field group for automatic saving.
 *
 * @since 1.0.0
 *
 * @param $group
 */
function rbm_theme_init_field_group( $group ) {
	rbm_theme_field_helpers()->fields->save->initialize_fields( $group );
}

/**
 * Gets a meta field helpers field.
 *
 * @since 1.0.0
 *
 * @param string $name Field name.
 * @param string|int $post_ID Optional post ID.
 * @param mixed $default Default value if none is retrieved.
 * @param array $args
 *
 * @return mixed Field value
 */
function rbm_theme_get_field( $name, $post_ID = false, $default = '', $args = array() ) {
    $value = rbm_theme_field_helpers()->fields->get_meta_field( $name, $post_ID, $args );
    return $value !== false ? $value : $default;
}

/**
 * Gets a option field helpers field.
 *
 * @since 1.0.0
 *
 * @param string $name Field name.
 * @param mixed $default Default value if none is retrieved.
 * @param array $args
 *
 * @return mixed Field value
 */
function rbm_theme_get_option_field( $name, $default = '', $args = array() ) {
	$value = rbm_theme_field_helpers()->fields->get_option_field( $name, $args );
	return $value !== false ? $value : $default;
}

/**
 * Outputs a text field.
 *
 * @since 1.0.0
 *
 * @param array $args
 */
function rbm_theme_do_field_text( $args = array() ) {
	rbm_theme_field_helpers()->fields->do_field_text( $args['name'], $args );
}

/**
 * Outputs a textarea field.
 *
 * @since 1.0.0
 *
 * @param array $args
 */
function rbm_theme_do_field_textarea( $args = array() ) {
	rbm_theme_field_helpers()->fields->do_field_textarea( $args['name'], $args );
}

/**
 * Outputs a checkbox field.
 *
 * @since 1.0.0
 *
 * @param array $args
 */
function rbm_theme_do_field_checkbox( $args = array() ) {
	rbm_theme_field_helpers()->fields->do_field_checkbox( $args['name'], $args );
}

/**
 * Outputs a toggle field.
 *
 * @since 1.0.0
 *
 * @param array $args
 */
function rbm_theme_do_field_toggle( $args = array() ) {
	rbm_theme_field_helpers()->fields->do_field_toggle( $args['name'], $args );
}

/**
 * Outputs a radio field.
 *
 * @since 1.0.0
 *
 * @param array $args
 */
function rbm_theme_do_field_radio( $args = array() ) {
	rbm_theme_field_helpers()->fields->do_field_radio( $args['name'], $args );
}

/**
 * Outputs a select field.
 *
 * @since 1.0.0
 *
 * @param array $args
 */
function rbm_theme_do_field_select( $args = array() ) {
	rbm_theme_field_helpers()->fields->do_field_select( $args['name'], $args );
}

/**
 * Outputs a number field.
 *
 * @since 1.0.0
 *
 * @param array $args
 */
function rbm_theme_do_field_number( $args = array() ) {
	rbm_theme_field_helpers()->fields->do_field_number( $args['name'], $args );
}

/**
 * Outputs an image field.
 *
 * @since 1.0.0
 *
 * @param array $args
 */
function rbm_theme_do_field_media( $args = array() ) {
	rbm_theme_field_helpers()->fields->do_field_media( $args['name'], $args );
}

/**
 * Outputs a datepicker field.
 *
 * @since 1.0.0
 *
 * @param array $args
 */
function rbm_theme_do_field_datepicker( $args = array() ) {
	rbm_theme_field_helpers()->fields->do_field_datepicker( $args['name'], $args );
}

/**
 * Outputs a timepicker field.
 *
 * @since 1.0.0
 *
 * @param array $args
 */
function rbm_theme_do_field_timepicker( $args = array() ) {
	rbm_theme_field_helpers()->fields->do_field_timepicker( $args['name'], $args );
}

/**
 * Outputs a datetimepicker field.
 *
 * @since 1.0.0
 *
 * @param array $args
 */
function rbm_theme_do_field_datetimepicker( $args = array() ) {
	rbm_theme_field_helpers()->fields->do_field_datetimepicker( $args['name'], $args );
}

/**
 * Outputs a colorpicker field.
 *
 * @since 1.0.0
 *
 * @param array $args
 */
function rbm_theme_do_field_colorpicker( $args = array() ) {
	rbm_theme_field_helpers()->fields->do_field_colorpicker( $args['name'], $args );
}

/**
 * Outputs a list field.
 *
 * @since 1.0.0
 *
 * @param array $args
 */
function rbm_theme_do_field_list( $args = array() ) {
	rbm_theme_field_helpers()->fields->do_field_list( $args['name'], $args );
}

/**
 * Outputs a hidden field.
 *
 * @since 1.0.0
 *
 * @param array $args
 */
function rbm_theme_do_field_hidden( $args = array() ) {
	rbm_theme_field_helpers()->fields->do_field_hidden( $args['name'], $args );
}

/**
 * Outputs a table field.
 *
 * @since 1.0.0
 *
 * @param array $args
 */
function rbm_theme_do_field_table( $args = array() ) {
	rbm_theme_field_helpers()->fields->do_field_table( $args['name'], $args );
}

/**
 * Outputs a HTML field.
 *
 * @since 1.0.0
 *
 * @param array $args
 */
function rbm_theme_do_field_html( $args = array() ) {
	rbm_theme_field_helpers()->fields->do_field_html( $args['name'], $args );
}

/**
 * Outputs a repeater field.
 *
 * @since 1.0.0
 *
 * @param mixed $values
 */
function rbm_theme_do_field_repeater( $args = array() ) {
	rbm_theme_field_helpers()->fields->do_field_repeater( $args['name'], $args );
}

/**
 * Outputs a String if a Callback Function does not exist for an Options Page Field
 *
 * @since 1.0.0
 *
 * @param array $args
 */
function rbm_theme_missing_callback( $args ) {
	
	printf( 
		_x( 'A callback function called "rbm_theme_do_field_%s" does not exist.', '%s is the Field Type', 'real-big-marketing' ),
		$args['type']
	);
		
}
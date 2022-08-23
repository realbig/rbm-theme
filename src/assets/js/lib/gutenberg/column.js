import assign from 'lodash.assign';

const { addFilter } = wp.hooks;
const { __ } = wp.i18n;

/**
 * Add attributes to be saved for the Block
 *
 * @param object settings Current block settings.
 * @param string name Name of block.
 *
 * @returns object Modified block settings.
 */
const addAttributes = ( settings, name ) => {

    // Do nothing if it's another block than our defined ones.
    if ( name != 'core/column' ) return settings;

    // Use Lodash's assign to gracefully handle if attributes are undefined
    settings.attributes = assign( settings.attributes, {
        mobileOrder: {
            type: 'string',
            default: 'initial',
        },
    } );

    return settings;

};

addFilter( 'blocks.registerBlockType', 'rbm/block-customizations/column', addAttributes );

const { createHigherOrderComponent, useState } = wp.compose;
const { Fragment } = wp.element;
const { PanelBody, __experimentalNumberControl } = wp.components;
const { InspectorControls } = wp.blockEditor;

var NumberControl = false;

// Renamed to match documentation and for cleanliness
// This will also hopefully gracefully transition if BoxControl comes out of experimental state
if ( __experimentalNumberControl ) {
    NumberControl = __experimentalNumberControl;
}
else {
    NumberControl = wp.components.NumberControl;
}

/**
 * Add new fields to the Edit screen
 *
 * @param   {[type]}  BlockEdit  [BlockEdit description]
 *
 * @return  {[type]}             [return description]
 */
const addEditPanel = createHigherOrderComponent( ( BlockEdit ) => {

    return ( props ) => {

        // Do nothing if it's another block than our defined ones.
        if ( props.name != 'core/column' ) {
            return (
                <BlockEdit { ...props } />
            );
        }

        const { mobileOrder } = props.attributes;

        const mobileBlockStyle = `

            @media only screen and ( max-width: 639px ) {

                #block-${ props.clientId } {
                    order: ${ mobileOrder };
                }

            }

        `;

        return (
            <Fragment>
                <style>{ mobileBlockStyle }</style>
                <BlockEdit { ...props } />
                <InspectorControls>
                    <PanelBody
                        title={ __( 'Mobile Settings' ) }
                        initialOpen={ true }
                    >
                        <div className="column-mobile-settings">

                            <NumberControl
                                label={ __( 'Priority of the Column on Mobile' ) }
                                labelPosition={ top }
                                min={ 0 }
                                value={ mobileOrder }
                                onChange={ ( newMobileOrder, extra ) => {

                                    if ( extra.event?.target.validity.valid ) {
                                        props.setAttributes( {
                                            mobileOrder: newMobileOrder,
                                        } )
                                    }

                                } }
                            />

                        </div>
                    </PanelBody>
                </InspectorControls>
            </Fragment>
        );
    };

}, 'addEditPanel' );

addFilter( 'editor.BlockEdit', 'rbm/block-customizations/column', addEditPanel );

// Filtering blocks.getSaveElement to rearrange/inject items on Save causes save validation errors, so instead we have to use PHP to filter render_block to output things how they should be
// CSS is used to put the image where it ought to be visually in the editor otherwise.
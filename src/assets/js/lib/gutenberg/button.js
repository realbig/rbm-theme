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
    if ( name != 'core/button' ) return settings;

    // Use Lodash's assign to gracefully handle if attributes are undefined
    settings.attributes = assign( settings.attributes, {
        gravityForm: {
            type: 'string',
            default: '',
        },
        gravityFormShowTitle: {
            type: 'boolean',
            default: true,
        },
        gravityFormShowDescription: {
            type: 'boolean',
            default: false,
        },
        linkToQueriedPost: {
            type: 'boolean',
            default: false
        },
        icon: {
            type: 'string',
            default: ''
        },
        iconColor: {
            type: 'string',
            default: ''
        }
    } );

    return settings;

};

addFilter( 'blocks.registerBlockType', 'rbm/block-customizations/button', addAttributes );

const { createHigherOrderComponent } = wp.compose;
const { Fragment, useEffect } = wp.element;
const { PanelBody, SelectControl, ToggleControl } = wp.components;
const { InspectorControls } = wp.blockEditor;
const { select } = wp.data;

const { apiFetch } = wp;

var forms = [];

getForms();

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
        if ( props.name != 'core/button' ) {
            return (
                <BlockEdit { ...props } />
            );
        }

        const {
            gravityForm,
            gravityFormShowTitle,
            gravityFormShowDescription,
            linkToQueriedPost
        } = props.attributes;

        const parentQueryBlocks = select( 'core/block-editor' ).getBlockParentsByBlockName( props.clientId, 'core/query' );

        return (
            <Fragment>
                <BlockEdit { ...props } />
                <InspectorControls>
                    <PanelBody
                        title={ __( 'Pop-Over Form' ) }
                        initialOpen={ true }
                    >

                        <SelectControl
                            label={ __( 'Gravity Form to open' ) }
                            help={ __( 'When selected, this Button will be used to open a pop-over with the specified Gravity Form inside.' ) }
                            value={ gravityForm }
                            options={ forms }
                            onChange={ ( newGravityForm ) => {

                                props.setAttributes( {
                                    'gravityForm': newGravityForm,
                                } );

                            } }
                        />

                        <ToggleControl
                            label={ __( 'Show Form Title' ) }
                            checked={ gravityFormShowTitle }
                            onChange={ ( newGravityFormShowTitle ) => {

                                props.setAttributes( {
                                    'gravityFormShowTitle': newGravityFormShowTitle,
                                } );

                            } }
                        />

                        <ToggleControl
                            label={ __( 'Show Form Description' ) }
                            checked={ gravityFormShowDescription }
                            onChange={ ( newGravityFormShowDescription ) => {

                                props.setAttributes( {
                                    'gravityFormShowDescription': newGravityFormShowDescription,
                                } );

                            } }
                        />
                        
                    </PanelBody>

                    {
                        ( parentQueryBlocks.length > 0 ) 
                        ? 
                            <PanelBody
                                title={ __( 'Query-based Settings' ) }
                                initialOpen={ true }
                            >

                                <ToggleControl
                                    label={ __( 'Link to the current item' ) }
                                    checked={ linkToQueriedPost }
                                    onChange={ ( newLinkToQueriedPost ) => {

                                        props.setAttributes( {
                                            'linkToQueriedPost': newLinkToQueriedPost,
                                            'gravityForm': ( newLinkToQueriedPost ) ? '' : gravityForm
                                        } );

                                    } }
                                />

                            </PanelBody>
                        : 
                            ''
                    }

                </InspectorControls>
            </Fragment>
        );
    };

}, 'addEditPanel' );

addFilter( 'editor.BlockEdit', 'rbm/block-customizations/button', addEditPanel );

// Filtering blocks.getSaveElement to rearrange/inject items on Save causes save validation errors, so instead we have to use PHP to filter render_block to output things how they should be
// CSS is used to put the image where it ought to be visually in the editor otherwise.

async function getForms() {

    return await apiFetch( {
        path: '/gf/v2/forms',
        method: 'GET',
    } ).then( response => {

        let result = [
            {
                'label': __( 'Select a Form' ),
                'value': ''
            }
        ];

        for ( var index in response ) {

            result.push( {
                'label': response[ index ].title,
                'value': response[ index ].id
            } );

        }

        forms = result;

        return result;

    } ).catch( error => {

        console.error( error );

        forms = [
            {
                'label': __( 'Something went wrong. Please check the JavaScript Console.' ),
                'value': ''
            }
        ];

        return;

    } );

}
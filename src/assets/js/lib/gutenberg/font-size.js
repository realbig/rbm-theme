import assign from 'lodash.assign';

const { addFilter } = wp.hooks;
const { __ } = wp.i18n;

const allowedBlocks = [
    'core/paragraph',
    'core/heading',
    'core/post-title'
];

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
    if ( allowedBlocks.indexOf( name ) < 0 ) return settings;

    // Use Lodash's assign to gracefully handle if attributes are undefined
    settings.attributes = assign( settings.attributes, {
        fontStyle: {
            type: 'string',
            default: '',
        },
    } );

    return settings;

};

addFilter( 'blocks.registerBlockType', 'rbm/block-customizations/font-size', addAttributes );

const { createHigherOrderComponent } = wp.compose;
const { Fragment } = wp.element;
const { PanelBody, FontSizePicker } = wp.components;
const { InspectorControls } = wp.blockEditor;

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
        if ( allowedBlocks.indexOf( props.name ) < 0 ) {
            return (
                <BlockEdit { ...props } />
            );
        }

        const {
            fontStyle
        } = props.attributes;

        const fontStyles = [
            {
                "slug": "h1",
                "size": "h1",
                "name": __( "Heading 1" )
            },
            {
                "slug": "h2",
                "size": "h2",
                "name": __( "Heading 2" )
            },
            {
                "slug": "h3",
                "size": "h3",
                "name": __( "Heading 3" )
            },
            {
                "slug": "h4",
                "size": "h4",
                "name": __( "Heading 4" )
            },
            {
                "slug": "h5",
                "size": "h5",
                "name": __( "Heading 5" )
            },
            {
                "slug": "h6",
                "size": "h6",
                "name": __( "Heading 6" )
            }
        ];

        return (
            <Fragment>
                <BlockEdit { ...props } />
                <InspectorControls>
                    <PanelBody
                        title={ __( 'Font Style' ) }
                        initialOpen={ true }
                    >

                        <FontSizePicker
                            fontSizes={ fontStyles }
                            value={ fontStyle }
                            fallBackFontSize={ '' }
                            disableCustomFontSizes={ true }
                            onChange={ ( newFontStyle ) => {

                                let cssClasses = props.attributes?.className;

                                if ( typeof cssClasses !== 'undefined' ) {

                                    // Convert to Array, removing any booboos in the CSS Class separations
                                    cssClasses = cssClasses.trim().replace( /\s{2,}/g, ' ' ).split( ' ' );

                                    // Remove any matches
                                    cssClasses = cssClasses.filter( cssClass => {

                                        return cssClass !== props.attributes.fontStyle;

                                    } );

                                    cssClasses = cssClasses.join( ' ' );

                                }
                                else {

                                    cssClasses = '';

                                }

                                if ( newFontStyle ) {

                                    cssClasses = cssClasses + ' ' + newFontStyle;
                                
                                }

                                props.setAttributes( {
                                    'fontStyle': newFontStyle,
                                    'className': cssClasses.trim(),
                                } );

                            } }
                        />
                        
                    </PanelBody>
                </InspectorControls>
            </Fragment>
        );
    };

}, 'addEditPanel' );

addFilter( 'editor.BlockEdit', 'rbm/block-customizations/font-size', addEditPanel );

// Filtering blocks.getSaveElement to rearrange/inject items on Save causes save validation errors, so instead we have to use PHP to filter render_block to output things how they should be
// CSS is used to put the image where it ought to be visually in the editor otherwise.
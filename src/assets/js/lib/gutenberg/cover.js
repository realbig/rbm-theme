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
    if ( name != 'core/cover' ) return settings;

    // Use Lodash's assign to gracefully handle if attributes are undefined
    settings.attributes = assign( settings.attributes, {
        verticalAlignment: {
            type: 'string',
            default: 'auto',
        },
        mobileFocalPoint: {
            type: 'object',
            default: {
                x: 0.5,
                y: 0.5
            },
        },
        mobilePadding: {
            type: 'object',
            default: {
                top: '',
                right: '',
                bottom: '',
                left: ''
            }
        }
    } );

    return settings;

};

addFilter( 'blocks.registerBlockType', 'rbm/block-customizations/cover', addAttributes );

const { createHigherOrderComponent } = wp.compose;
const { Fragment, Platform } = wp.element;
const { PanelBody, FocalPointPicker, __experimentalBoxControl, RadioControl } = wp.components;
const { InspectorControls, useSetting, __experimentalUseCustomSides } = wp.blockEditor;

var BoxControl = false;

// Renamed to match documentation and for cleanliness
// This will also hopefully gracefully transition if BoxControl comes out of experimental state
if ( __experimentalBoxControl ) {
    BoxControl = __experimentalBoxControl;
}
else {
    BoxControl = wp.components.BoxControl;
}

var useCustomSides = false;

if ( __experimentalUseCustomSides ) {
    useCustomSides = __experimentalUseCustomSides;
}
else {
    useCustomSides = wp.blockEditor.useCustomSides;
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
        if ( props.name != 'core/cover' ) {
            return (
                <BlockEdit { ...props } />
            );
        }

        const { url, mobileFocalPoint, mobilePadding, verticalAlignment } = props.attributes;

        const mobileFocalPointStyle = {
            backgroundImage: `url(${ url })`,
            backgroundPosition: `${ mobileFocalPoint.x * 100 }% ${ mobileFocalPoint.y * 100 }%`,
        };

        var mobilePaddingCSS = '';

        for ( let side in mobilePadding ) {

            if ( typeof mobilePadding[ side ] == 'undefined' || mobilePadding[ side ].trim() == '' ) continue;

            mobilePaddingCSS = mobilePaddingCSS + 'padding-' + side.toLowerCase() + ': ' + mobilePadding[ side ] + ' !important; ';

        }

        const units = useSetting( 'spacing.units' );

        const mobileBlockStyle = `

            #block-${ props.clientId } .wp-block-cover__inner-container {
                align-self: ${ verticalAlignment };
            }

            @media only screen and ( max-width: 639px ) {

                #block-${ props.clientId } {
                    ${ mobilePaddingCSS }
                }

                #block-${ props.clientId } .wp-block-cover__image-background {

                    object-position: ${ mobileFocalPoint.x * 100 }% ${ mobileFocalPoint.y * 100 }% !important;

                }

            }

        `;

        const sides = useCustomSides( 'core/cover', 'padding' );
        const splitOnAxis =
            sides && sides.some( ( side ) => [ 'vertical', 'horizontal' ].includes( side ) );

        return (
            <Fragment>
                <style>{ mobileBlockStyle }</style>
                <BlockEdit { ...props } />
                <InspectorControls>
                    <PanelBody
                        title={ __( 'Vertical Alignment' ) }
                        initialOpen={ true }
                    >
                        <div className="cover-veritical-alignment">

                            <RadioControl
                                label={ __( "Vertical Alignment of the Cover's content" ) }
                                selected={ verticalAlignment }
                                options={ [
                                    {
                                        label: __( 'Top' ),
                                        value: 'self-start',
                                    },
                                    {
                                        label: __( 'Center' ),
                                        value: 'auto'
                                    },
                                    {
                                        label: __( 'Bottom' ),
                                        value: 'self-end',
                                    }
                                ] }
                                onChange={ ( newVerticalAlignment ) => 
                                    props.setAttributes( {
                                        verticalAlignment: newVerticalAlignment,
                                    } )
                                }
                            />

                        </div>
                    </PanelBody>
                    {
                        ( url || useSetting( 'spacing.padding' ) )
                        ? 
                        <PanelBody
                            title={ __( 'Mobile Settings' ) }
                            initialOpen={ true }
                        >
                            <div className="cover-mobile-settings">
                                
                                {
                                    ( url ) 
                                    ? 
                                    <Fragment>
                                        <FocalPointPicker
                                            label={ __( 'Mobile focal point picker' ) }
                                            url={ url }
                                            value={ mobileFocalPoint }
                                            onChange={ ( newFocalPoint ) =>
                                                props.setAttributes( {
                                                    mobileFocalPoint: newFocalPoint,
                                                } )
                                            }
                                        />
                                        
                                        <div style={ mobileFocalPointStyle } />
                                    </Fragment>
                                    : ''
                                }

                                {

                                    ( useSetting( 'spacing.padding' ) ) ? 

                                        Platform.select( {
                                            web: (
                                                <BoxControl
                                                    label={ __( 'Mobile Padding' ) }
                                                    values={ mobilePadding }
                                                    onChange={ ( newMobilePadding ) => 
                                                        props.setAttributes( {
                                                            mobilePadding: newMobilePadding,
                                                        } )
                                                    }
                                                    allowReset={ false }
                                                    units={ { 
                                                        availableUnits: units || [
                                                            '%',
                                                            'px',
                                                            'em',
                                                            'rem',
                                                            'vw',
                                                        ] 
                                                    } }
                                                    sides={ sides }
                                                    splitOnAxis={ splitOnAxis }
                                                />
                                            ),
                                            native: null,
                                        } )

                                    : '' 
                                
                                }
                                
                            </div>
                        </PanelBody>
                        : ''
                    }
                </InspectorControls>
            </Fragment>
        );
    };

}, 'addEditPanel' );

addFilter( 'editor.BlockEdit', 'rbm/block-customizations/cover', addEditPanel );

// Filtering blocks.getSaveElement to rearrange/inject items on Save causes save validation errors, so instead we have to use PHP to filter render_block to output things how they should be
// CSS is used to put the image where it ought to be visually in the editor otherwise.
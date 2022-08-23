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
    if ( name != 'core/query' ) return settings;

    // Use Lodash's assign to gracefully handle if attributes are undefined
    settings.attributes = assign( settings.attributes, {
        mobileScroll: {
            type: 'boolean',
            default: false,
        },
        mobileColumnCount: {
            type: 'integer',
            default: 1
        }
    } );

    return settings;

};

addFilter( 'blocks.registerBlockType', 'rbm/block-customizations/query', addAttributes );

const { createHigherOrderComponent } = wp.compose;
const { Fragment, useEffect } = wp.element;
const { PanelBody, ToggleControl, RangeControl, Notice } = wp.components;
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
        if ( props.name != 'core/query' ) {
            return (
                <BlockEdit { ...props } />
            );
        }

        const {
            mobileScroll,
            mobileColumnCount
        } = props.attributes;

        // Ensure the CSS Class for 1 column gets instantiated properly
        // Gutenberg likes to treat defaults as "Empty" which isn't actually that useful
        useEffect( () => {

            if ( ! mobileScroll && mobileColumnCount == 1 ) {

                let cssClasses = props.attributes?.className;

                if ( typeof cssClasses !== 'undefined' ) {

                    // Convert to Array, removing any booboos in the CSS Class separations
                    cssClasses = cssClasses.trim().replace( /\s{2,}/g, ' ' ).split( ' ' );

                    // Remove any matches
                    cssClasses = cssClasses.filter( cssClass => {

                        return cssClass.indexOf( 'mobile-columns-' ) < 0;

                    } );

                    cssClasses = cssClasses.join( ' ' );

                }
                else {

                    cssClasses = '';

                }

                cssClasses = cssClasses + ' mobile-columns-1';
    
                props.setAttributes( {
                    mobileColumnCount: 1,
                    className: cssClasses.trim(),
                } );
    
            }
    
        }, [] );

        return (
            <Fragment>
                <BlockEdit { ...props } />
                <InspectorControls>
                    { 
                        ( props?.attributes?.displayLayout?.type == 'flex' ) 
                        ? 
                            <PanelBody
                                title={ __( 'Mobile Settings' ) }
                                initialOpen={ true }
                            >

                                <ToggleControl
                                    label={ __( 'Horizontal Scrolling' ) }
                                    help={ __( 'Should columns continue off-screen, requiring the user to scroll horizontally?' ) }
                                    checked={ mobileScroll }
                                    onChange={ ( newMobileScroll ) => {

                                        let cssClasses = props.attributes?.className;

                                        if ( typeof cssClasses !== 'undefined' ) {

                                            // Convert to Array, removing any booboos in the CSS Class separations
                                            cssClasses = cssClasses.trim().replace( /\s{2,}/g, ' ' ).split( ' ' );

                                            // Remove any matches
                                            cssClasses = cssClasses.filter( cssClass => {

                                                return cssClass !== 'mobile-scroll';

                                            } );

                                            cssClasses = cssClasses.join( ' ' );

                                        }
                                        else {

                                            cssClasses = '';

                                        }

                                        if ( newMobileScroll ) {

                                            cssClasses = cssClasses + ' mobile-scroll';
                                        
                                        }

                                        props.setAttributes( {
                                            'mobileScroll': newMobileScroll,
                                            'className': cssClasses.trim(),
                                        } );

                                    } }
                                />

                                {
                                    ( mobileScroll ) 
                                    ? 
                                        <RangeControl
                                            label={ __( 'Number of Columns to show in their entirety' ) }
                                            help={ __( 'Each column will be the same width.' ) }
                                            value={ mobileColumnCount }
                                            onChange={ ( newMobileColumnCount ) => {

                                                let cssClasses = props.attributes?.className;

                                                if ( typeof cssClasses !== 'undefined' ) {

                                                    // Convert to Array, removing any booboos in the CSS Class separations
                                                    cssClasses = cssClasses.trim().replace( /\s{2,}/g, ' ' ).split( ' ' );

                                                    // Remove any matches
                                                    cssClasses = cssClasses.filter( cssClass => {

                                                        return cssClass.indexOf( 'mobile-columns-' ) < 0;

                                                    } );

                                                    cssClasses = cssClasses.join( ' ' );

                                                }
                                                else {

                                                    cssClasses = '';

                                                }

                                                if ( newMobileColumnCount ) {

                                                    cssClasses = cssClasses + ' mobile-columns-' + newMobileColumnCount;
                                                
                                                }
                                                else {

                                                    cssClasses = cssClasses + ' mobile-columns-1';

                                                }

                                                props.setAttributes( {
                                                    'mobileColumnCount': newMobileColumnCount,
                                                    'className': cssClasses.trim()
                                                } );

                                            } }
                                            min={ 1 }
                                            max={ Math.max( 6, mobileColumnCount ) }
                                        />

                                    :
                                        ''
                                }

                                { mobileColumnCount > 6 && (
                                    <Notice status="warning" isDismissible={ false }>
                                        { __(
                                            'This column count exceeds the recommended amount and may cause visual breakage.'
                                        ) }
                                    </Notice>
                                ) }

                            </PanelBody>
                        :
                            ''
                    }
                </InspectorControls>
            </Fragment>
        );
    };

}, 'addEditPanel' );

addFilter( 'editor.BlockEdit', 'rbm/block-customizations/query', addEditPanel );

// Filtering blocks.getSaveElement to rearrange/inject items on Save causes save validation errors, so instead we have to use PHP to filter render_block to output things how they should be
// CSS is used to put the image where it ought to be visually in the editor otherwise.
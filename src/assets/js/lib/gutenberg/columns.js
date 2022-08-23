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
    if ( name != 'core/columns' ) return settings;

    // Use Lodash's assign to gracefully handle if attributes are undefined
    settings.attributes = assign( settings.attributes, {
        noGap: {
            type: 'boolean',
            default: false,
        },
        mobileScroll: {
            type: 'boolean',
            default: false,
        },
        mobileColumnCount: {
            type: 'integer',
            default: 1,
        },
        mobileWidth: {
            type: 'float',
            default: 80
        }
    } );

    return settings;

};

addFilter( 'blocks.registerBlockType', 'rbm/block-customizations/columns', addAttributes );

const { createHigherOrderComponent } = wp.compose;
const { Fragment } = wp.element;
const { PanelBody, ToggleControl, RangeControl, Notice } = wp.components;
const { InspectorControls } = wp.blockEditor;
const { select } = wp.data;

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
        if ( props.name != 'core/columns' ) {
            return (
                <BlockEdit { ...props } />
            );
        }

        const {
            noGap,
            mobileScroll,
            mobileColumnCount,
            mobileWidth
        } = props.attributes;

        const parentQueryBlocks = select( 'core/block-editor' ).getBlockParentsByBlockName( props.clientId, 'core/query' );

        const mobileBlockStyle = `

            @media only screen and ( max-width: 639px ) {

                #block-${ props.clientId }.wp-block-columns.mobile-scroll > .wp-block-column {
                    flex-basis: ${ mobileWidth }% !important;
                }

            }

        `;

        return (
            <Fragment>
                <style>{ mobileBlockStyle }</style>
                <BlockEdit { ...props } />
                <InspectorControls>
                    <PanelBody
                        title={ __( 'Column Gap Controls' ) }
                        initialOpen={ true }
                    >

                        <ToggleControl
                            label={ __( 'Remove Gap?' ) }
                            help={ __( 'Columns have a gap between each column. This will remove that gap.' ) }
                            checked={ noGap }
                            onChange={ ( newNoGap ) => {

                                let cssClasses = props.attributes?.className;

                                if ( typeof cssClasses !== 'undefined' ) {

                                    // Convert to Array, removing any booboos in the CSS Class separations
                                    cssClasses = cssClasses.trim().replace( /\s{2,}/g, ' ' ).split( ' ' );

                                    // Remove any matches
                                    cssClasses = cssClasses.filter( cssClass => {

                                        return cssClass !== 'no-gap';

                                    } );

                                    cssClasses = cssClasses.join( ' ' );

                                }
                                else {

                                    cssClasses = '';

                                }

                                if ( newNoGap ) {

                                    cssClasses = cssClasses + ' no-gap';
                                
                                }

                                props.setAttributes( {
                                    'noGap': newNoGap,
                                    'className': cssClasses.trim(),
                                } );

                            } }
                        />
                        
                    </PanelBody>

                    { 
                        ( parentQueryBlocks.length <= 0 )
                        ? 
                            <PanelBody
                            title={ __( 'Mobile Settings' ) }
                            initialOpen={ true }
                            >

                                <ToggleControl
                                    label={ __( 'Horizontal Scrolling' ) }
                                    help={ __( 'Should columns continue off-screen, requiring the user to scroll horizontally? This overrides the "Stack on mobile" setting above.' ) }
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

                                        let isStackedOnMobile = props.attributes.isStackedOnMobile;

                                        if ( newMobileScroll ) {

                                            cssClasses = cssClasses + ' mobile-scroll';

                                            if ( isStackedOnMobile ) {
                                                isStackedOnMobile = false;
                                            }
                                        
                                        }

                                        props.setAttributes( {
                                            'mobileScroll': newMobileScroll,
                                            'className': cssClasses.trim(),
                                            'isStackedOnMobile': isStackedOnMobile,
                                        } );

                                    } }
                                />

                                {
                                    ( mobileScroll ) 
                                    ? 
                                        <RangeControl
                                            label={ __( 'Number of Columns to show in their entirety' ) }
                                            help={ __( 'Each column will be the same width' ) }
                                            value={ mobileColumnCount }
                                            onChange={ ( newMobileColumnCount ) => {

                                                props.setAttributes( {
                                                    'mobileColumnCount': newMobileColumnCount,
                                                    'mobileWidth': ( Number.isFinite( 100 / newMobileColumnCount ) ? parseFloat( 100 / newMobileColumnCount ).toFixed( 2 ) : 100.00 ) * .8
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

addFilter( 'editor.BlockEdit', 'rbm/block-customizations/columns', addEditPanel );

// Filtering blocks.getSaveElement to rearrange/inject items on Save causes save validation errors, so instead we have to use PHP to filter render_block to output things how they should be
// CSS is used to put the image where it ought to be visually in the editor otherwise.
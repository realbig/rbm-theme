( function( $ ) {
    
    /**
     * Take our Localized Choices and turn them into something TinyMCE Listbox understands
     * 
     * @param       object choices Choices Object from our Localized JSON
     *                               
     * @since       {{VERSION}}
     * @returns     Array  Array of TinyMCE Listbox Choices
     */
    function rbm_generate_tinymce_listbox( choices ) {

        var result = [];
        
        for ( var key in choices ) {
            
            result.push( {
                text: choices[key],
                value: key
            } );
            
        }
        
        return result;
        
    }

    $( document ).ready( function() {
        
        tinymce.PluginManager.add( 'rbm_form_overlay_shortcode_script', function( editor, url ) {
            editor.addButton( 'rbm_form_overlay_shortcode', {
                text: rbm_tinymce_l10n.rbm_form_overlay_shortcode.tinymce_title,
                icon: false,
                onclick: function() {
                    editor.windowManager.open( {
                        title: rbm_tinymce_l10n.rbm_form_overlay_shortcode.tinymce_title,
                        body: [
                            {
                                type: 'textbox',
                                name: 'text',
                                label: rbm_tinymce_l10n.rbm_form_overlay_shortcode.button_text.label,
                            },
                            {
                                type: 'listbox',
                                name: 'form_id',
                                label: rbm_tinymce_l10n.rbm_form_overlay_shortcode.form_id.label,
                                values: rbm_generate_tinymce_listbox( rbm_tinymce_l10n.rbm_form_overlay_shortcode.form_id.choices ),
                            },
                            {
                                type: 'listbox',
                                name: 'color',
                                label: rbm_tinymce_l10n.rbm_form_overlay_shortcode.color.label,
                                values: rbm_generate_tinymce_listbox( rbm_tinymce_l10n.rbm_form_overlay_shortcode.color.choices ),
                                default: rbm_tinymce_l10n.rbm_form_overlay_shortcode.color.default,
                            },
                            {
                                type: 'checkbox',
                                name: 'title',
                                label: rbm_tinymce_l10n.rbm_form_overlay_shortcode.title.label,
                            },
                            {
                                type: 'checkbox',
                                name: 'description',
                                label: rbm_tinymce_l10n.rbm_form_overlay_shortcode.description.label,
                            },
                        ],
                        onsubmit: function( e ) {
                            editor.insertContent( '[rbm_form_overlay' + 
                            ( e.data.form_id !== undefined ? ' form_id="' + e.data.form_id + '"' : '' ) +
                            ( e.data.color !== undefined ? ' color="' + e.data.color + '"' : '' ) +
                            ( e.data.title !== undefined && e.data.title !== false ? ' title="true"' : ' title="false"' ) + 
                            ( e.data.description !== undefined && e.data.description !== false ? ' description="true"' : ' description="false"' ) + 
                        ']' + 
                            ( e.data.text !== undefined ? "<br />" + e.data.text + "<br />" : "<br /><br />" ) + 
                        '[/rbm_form_overlay]' );
                        }

                    } ); // Editor

                } // onclick

            } ); // addButton

        } ); // Plugin Manager

    } ); // Document Ready

} )( jQuery );
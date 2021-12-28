( function( $ ) {

    $( document ).on( 'click', '.open-overlay-form a, .open-overlay-form button, a.open-overlay-form, button.open-overlay-form', function( event ) {

        event.preventDefault();

        $( '#overlay-form' ).foundation( 'open' );

    } );

} )( jQuery );
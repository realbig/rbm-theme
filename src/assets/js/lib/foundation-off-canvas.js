( function( $ ) {
    
    $( document ).ready( function() {
        
        $( '[data-off-canvas]' ).on( 'opened.zf.offcanvas', function() {
            
            // Once it has opened once, we want to keep this flag set for CSS adjustments when logged in
            $( 'body' ).addClass( 'off-canvas-open' );
            
        } );
        
    } );
    
} )( jQuery );
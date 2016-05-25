/**
 Header functionality.

 @since 0.1.0
 @package RBMTheme
 */

(function ($) {
    'use strict';

    var $wrapper = $('#wrapper'),
        $header = $('#site-header'),
        $logo = $header.find('.site-logo');

    $logo.click(function () {

        if ($wrapper.hasClass('reveal')) {
            $wrapper.removeClass('reveal');
            $logo.find( 'g.gear' ).addClass( 'reverse-spin' );
        } else {
            $logo.find( 'g.gear' ).removeClass( 'reverse-spin' );
            $wrapper.addClass('reveal');
        }
    });

    // Hide when clicking on the back cover
    $('#back-cover').click(function () {
        $wrapper.removeClass('reveal');
        $logo.find( 'g.gear' ).addClass( 'reverse-spin' );
    });

    // Hide when scrolling
    var scrollInit = $( window ).scrollTop();
    $(window).scroll(function () {
        
        // Don't animate on Page Load
        if ( $( window ).scrollTop() !== scrollInit ) {
            scrollInit = 0; // Reset to 0 after any scrolling has happened. A page can be loaded with this value not being 0.
            if ( $wrapper.hasClass( 'reveal' ) ) {
                $wrapper.removeClass('reveal');
                $logo.find( 'g.gear' ).addClass( 'reverse-spin' );
            }
        }
        
    });

    // Only preview the header once per session
    if ($.cookie('rbm-header-preview') === '1') {
        return;
    }

    $(window).load(function () {

        setTimeout(function () {

            $wrapper.addClass('reveal');

            setTimeout(function () {
                $wrapper.removeClass('reveal');
                $logo.find( 'g.gear' ).addClass( 'reverse-spin' );
                $.cookie('rbm-header-preview', '1');
            }, 2000);
        }, 500 );
    });

})(jQuery);
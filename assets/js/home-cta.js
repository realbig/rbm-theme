/**
 Main functions file.

 @since 0.1.0
 @package RBMTheme
 */
(function ($) {
    'use strict';

    var $home_cta = $('.home-cta'),
        $scroll = $home_cta.find('.scroll-down');

    // Bail if not there
    if ($home_cta.length === 0) {
        return;
    }

    var $home_message = $home_cta.find('.home-cta-message');

    // Launch on load and on window resize
    $(resize);
    $(window).resize(resize);

    function resize() {

        var $wpadminbar = $('#wpadminbar'),
            window_height = $(window).height();

        // Subtract wpadminbar height if it exists
        if ($wpadminbar.length !== 0) {
            window_height = window_height - $wpadminbar.height();
        }

        $home_cta.height(window_height);
        $home_message.css('margin-top', $home_message.height() / 2 * -1);
    }

    // Scroll down
    $scroll.click(function () {

        $('body, html').animate({
            scrollTop: $('.section').first().offset().top
        }, 500);

        return false;
    });

})(jQuery);
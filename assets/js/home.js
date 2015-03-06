/**
 Main functions file.

 @since 0.1.0
 @package RBMTheme
 */
(function ($) {
    'use strict';

    /* -------------- *
     * Call To Action *
     * -------------- */

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

    /* -------- *
     * Sections *
     * -------- */

    $(window).scroll(function () {

        $('.section').each(function () {

            var current_scroll = $(window).scrollTop(),
                offset = $(this).offset().top - ($(window).height() / 2);

            if (current_scroll > offset) {
                $(this).addClass('active');
            } else {
                $(this).removeClass('active');
            }
        });
    });

    $('.section').each(function () {

        var $container = $('<div class="background-container" />'),
            height = $(this).outerHeight(),
            total = 0,
            line_height, margin_top, margin_bottom, direction;

        while (total < height) {
            line_height = Math.floor(Math.random() * 100) + 10;
            margin_top = Math.floor(Math.random() * 30) + 2;
            margin_bottom = Math.floor(Math.random() * 30) + 2;
            direction = Math.random() >= 0.5 ? 'left' : 'right';
            total = total + line_height + margin_top + margin_bottom;

            $container.append('<div class="line ' + direction + '" style="height: ' + line_height + 'px; margin-top: ' + margin_top + 'px; margin-bottom: ' + margin_bottom + 'px;" /><div class="clearfix" />');
        }

        $(this).prepend($container);
    });
})(jQuery);
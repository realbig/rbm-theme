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
        $scroll = $('.scroll-down');

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
            scrollTop: $(this).closest('section').next('section').offset().top - $('#site-header').find('.site-nav-left').height()
        }, 500);

        return false;
    });

    /* -------- *
     * Sections *
     * -------- */

    $(window).scroll(function () {

        $('.section').each(function () {

            // Background
            var current_scroll = $(window).scrollTop(),
                offset_top = $(this).offset().top - ($(window).height() / 2),
                offset_bottom = ($(this).offset().top + $(this).height()) - ($(window).height() / 3);

            if (current_scroll > offset_top && current_scroll < offset_bottom) {
                $(this).addClass('active');
            } else {
                $(this).removeClass('active');
            }

            // Title
            var $title = $(this).find('.section-title .text'),
                $logo = $('#site-header').find('.site-logo'),
                logo_height = $logo.outerHeight(),
                left = $title.closest('h1').hasClass('left') ? -1 : 1;

            if (current_scroll > $(this).offset().top - logo_height) {

                if (!$title.hasClass('shift')) {
                    $title.animate({
                        left: (($logo.outerWidth() / 2) + ($title.outerWidth() / 2)) * left
                    }).addClass('shift');
                }
            } else {
                if ($title.hasClass('shift')) {
                    $title.animate({
                        left: 0
                    }).removeClass('shift');
                }
            }
        });
    });

    // Backgrounds
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

        // Buttons
        if ($(this).hasClass('green')) {
            $(this).find('.button').addClass('secondary');
        }
    });
})(jQuery);
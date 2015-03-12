/**
 Main functions file.

 @since 0.1.0
 @package RBMTheme
 */
(function ($) {
    'use strict';

    var $nag = $('.section-go-up'),
        $chamber = $('.section.chamber');

    if (!$chamber.length) {
        return;
    }

    $(window).scroll(function () {

        var scroll = $(window).scrollTop(),
            offset = $('.section.chamber').offset().top;

        if (scroll > offset) {
            $nag.removeClass('hidden');
        } else {
            $nag.addClass('hidden');
        }
    });

    $nag.click(function () {
        $('html, body').animate({
            scrollTop: 0
        }, 500);
    });

})(jQuery);
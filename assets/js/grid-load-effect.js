/**
 Grid Load effect.

 @since 0.1.0
 @package RBMTheme
 */
(function ($) {
    'use strict';

    var $grids = $('.grid-load-effect');

    $grids.find('li').addClass('grid-load-effect-hide');

    $(function () {
        $grids.find('li').each(function () {
            $(this).attr('data-delay', Math.floor(Math.random() * 10));
        });
    });

    $(window).scroll(function () {

        var scroll = $(this).scrollTop() + $(this).height();

        $grids.find('li.grid-load-effect-hide').each(function () {

            var offset = $(this).offset().top;

            if (scroll > offset) {

                var $img = $(this).find('.grid-load-effect-image');
                $(this).removeClass('grid-load-effect-hide ');
                $img.attr('src', $img.data('src'));
            }
        });
    });

})(jQuery);
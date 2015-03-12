/**
 Shortcodes functionality.

 @since 0.1.0
 @package RBMTheme
 */
(function ($) {
    'use strict';

    $('.overlay-grid-item').each(function () {

        var $container_height = $(this).height();

        $('.overlay-grid-meta').each(function () {
            $(this).css('margin-top', $(this).outerHeight() / 2 * -1);
        });
    });

})(jQuery);
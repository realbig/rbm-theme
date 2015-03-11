/**
 Shortcodes functionality.

 @since 0.1.0
 @package RBMTheme
 */
(function ($) {
    'use strict';

    $('.staff-item').each(function () {

        var $container_height = $(this).height();

        $('.staff-meta').each(function () {
            $(this).css('margin-top', $(this).outerHeight() / 2 * -1);
        });
    });

})(jQuery);
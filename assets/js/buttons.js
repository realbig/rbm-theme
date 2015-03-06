/**
 Buttons.

 @since 0.1.0
 @package RBMTheme
 */
(function ($) {
    'use strict';

    $(function () {

        $('button, .button').each(function () {

            $(this).addClass('effect').wrapInner('<span class="button-text" />');
        });
    });

})(jQuery);
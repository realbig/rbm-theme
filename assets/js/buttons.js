/**
 Buttons.

 @since 0.1.0
 @package RBMTheme
 */
(function ($) {
    'use strict';

    $(function () {

        $('button, .button').each(function () {

            if ($(this).prop("tagName") == 'INPUT') {
                return true; // continue $.each
            }
            $(this).addClass('effect').wrapInner('<span class="button-text" />');
        });
    });

})(jQuery);
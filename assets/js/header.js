/**
 Header functionality.

 @since 0.1.0
 @package RBMTheme
 */
(function ($) {
    'use strict';

    var $header = $('#site-header'),
        $logo = $header.find('.site-logo');

    $(function () {

        setTimeout(function () {
            $header.removeClass('reveal');
        }, 1000);

        $logo.click(function () {

            if ($header.hasClass('reveal')) {
                $header.removeClass('reveal');
            } else {
                $header.addClass('reveal');
            }
        });
    });

})(jQuery);
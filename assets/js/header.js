/**
 Header functionality.

 @since 0.1.0
 @package RBMTheme
 */
(function ($) {
    'use strict';

    var $wrapper = $('#wrapper'),
        $header = $('#site-header'),
        $logo = $header.find('.site-logo');

    $logo.click(function () {

        if ($wrapper.hasClass('reveal')) {
            $wrapper.removeClass('reveal');
        } else {
            $wrapper.addClass('reveal');
        }
    });

    // Hide when clicking on the back cover
    $('#back-cover').click(function () {
        $wrapper.removeClass('reveal');
    });

    // Hide when scrolling
    $(window).scroll(function () {
        $wrapper.removeClass('reveal');
    });

    // Only preview the header once per session
    if ($.cookie('rbm-header-preview') === '1') {
        return;
    }

    $(window).load(function () {

        setTimeout(function () {

            $wrapper.addClass('reveal');

            setTimeout(function () {
                $wrapper.removeClass('reveal');
                $.cookie('rbm-header-preview', '1');
            }, 2000);
        }, 500 );
    });

})(jQuery);
/**
 Header functionality.

 @since 0.1.0
 @package RBMTheme
 */
(function ($) {
    'use strict';

    var $wrapper, $header, $logo, $tip;

    function header_init() {

        $wrapper = $('#wrapper');
        $header = $('#site-header');
        $logo = $header.find('.site-logo');
        $tip = $('#header-tip');

        $logo.click(function () {

            if ($wrapper.hasClass('reveal')) {

                hide_header();

            } else {

                reveal_header();
            }
        });

        // Hide when clicking on the back cover
        $('#back-cover').click(function () {

            hide_header();
        });

        // Only preview the header once per session
        if (!$.cookie('rbm-header-preview')) {

            $tip.show();
        }
    }

    function reveal_header() {

        $wrapper.addClass('reveal');
        $logo.find('g.gear').css('transform', 'rotate(360deg)');

        if ($tip.is(':visible')) {

            $.cookie('rbm-header-preview', 1);
            $tip.fadeOut();
        }
    }

    function hide_header() {

        $logo.find('g.gear').css('transform', 'rotate(-360deg)');
        $wrapper.removeClass('reveal');
    }

    $(header_init);

})(jQuery);
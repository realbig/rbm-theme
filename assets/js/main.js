/**
 Main functions file.

 @since 0.1.0
 @package RBMTheme
 */
(function ($) {
    'use strict';

    $(document).foundation({
        abide: {
            validate_on_blur: false,
            focus_on_invalid: false
        }
    });

    window['rbm_clear_cookies'] = function () {
        $.removeCookie('rbm-header-preview');
        return 'success!';
    };

    // Smooth scrolling
    $(function() {

        var $wpadminbar = $('#wpadminbar');

        $('a[href*=#]:not([href=#])').click(function() {
            if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top -
                        $('#site-header').find('.site-nav-left').height() -
                        ($wpadminbar.length ? $wpadminbar.height() : 0)
                    }, 500);
                }
            }
        });
    });


    // Square elements
    $(square);
    $(window).resize(square);
    function square() {
        $('*[data-square]').each(function () {
            $(this).height($(this).width());
        });
    }
})(jQuery);
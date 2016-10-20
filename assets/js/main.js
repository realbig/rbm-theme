/**
 Main functions file.

 @since 0.1.0
 @package RBMTheme
 */
(function ($) {
    'use strict';

    $(function () {
        var $wpadminbar = $('#wpadminbar'),
            header_height = $('#site-header').find('.site-nav-left').height();

        $(document).foundation({
            abide: {
                validate_on_blur: false,
                focus_on_invalid: false
            }
        });

        // Scroll on load to init things
        $(window).load(function () {

            var scroll_top = $(this).scrollTop();

            $(this).scrollTop(scroll_top + 1);
            $(this).scrollTop(scroll_top);
        });

        window['rbm_clear_cookies'] = function () {
            $.removeCookie('rbm-header-preview');
            return 'success!';
        };

        // Smooth scrolling

        $('a[href*=\\#]:not([href=\\#])').click(function () {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top -
                        $('#site-header').find('.site-nav-left').height() -
                        ($wpadminbar.length ? $wpadminbar.height() : 0)
                    }, 500);
                }
            }
        });

        // Square elements
        square();
        $(window).resize(square);
        function square() {
            $('*[data-square]').each(function () {
                $(this).height($(this).width());
            });
        }

        /* -------- *
         * Sections *
         * -------- */

        $(window).scroll(function () {

            $('.section').each(function () {

                // Background
                var current_scroll = $(window).scrollTop(),
                    offset_top = $(this).offset().top - ($(window).height() / 2),
                    offset_bottom = ($(this).offset().top + $(this).height()) - ($(window).height() / 2);

                if (current_scroll > offset_top && current_scroll < offset_bottom) {
                    $(this).addClass('active');
                } else {
                    $(this).removeClass('active');
                }

                // Title
                var $title = $(this).find('.section-title .text'),
                    $logo = $('#site-header').find('.site-logo'),
                    logo_height = $logo.outerHeight(),
                    left = $title.closest('h1').hasClass('left') ? -1 : 1;

                if (current_scroll > $(this).offset().top - logo_height) {

                    if (!$title.hasClass('shift')) {
                        $title.animate({
                            left: (($logo.outerWidth() / 2) + ($title.outerWidth() / 2)) * left
                        }).addClass('shift');
                    }
                } else {
                    if ($title.hasClass('shift')) {
                        $title.animate({
                            left: 0
                        }).removeClass('shift');
                    }
                }
            });
        });

        // Action line and height
        $(window).load(function () {
            $('.section').each(function () {

                // Height
                var section_height = $(window).height() - header_height - ($wpadminbar.length ? $wpadminbar.height() : 0);

                $(this).css('minHeight', section_height);

                // Action line
                var $button = $(this).find('.section-cta');

                if (!$button.length) {
                    return;
                }

                var line_height = $button.outerHeight() + 20,
                    offset = $button.offset().top - $(this).offset().top - 10,
                    direction = 'left';

                $(this).prepend('<div class="section-line ' + direction + '" style="height: ' + line_height + 'px; top: ' + offset + 'px;"" />');
            });
        });

        $(window).resize(function () {

            $('.section').each(function () {

                var $cta = $(this).find('.section-cta'),
                    offset;

                if (!$cta.length) {

                    return;
                }

                offset = $cta.offset().top - $(this).offset().top - 10;

                $(this).find('.section-line').css('top', offset);
            });
        });

        // Scroll down
        $('.scroll-down').click(function () {

            $('body, html').animate({
                scrollTop: $(this).closest('section').next('section').offset().top -
                $('#site-header').find('.site-nav-left').height() -
                ($wpadminbar.length ? $wpadminbar.height() : 0)
            }, 500);

            return false;
        });
    });
})(jQuery);
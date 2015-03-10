/**
 Main functions file.

 @since 0.1.0
 @package RBMTheme
 */
(function ($) {
    'use strict';

    $(function () {
        var $home_cta = $('.home-cta');

        if (!$home_cta.length) {
            return;
        }

        // Define Elements
        var $scroll = $('.scroll-down'),
            $wpadminbar = $('#wpadminbar'),
            header_height = $('#site-header').find('.site-nav-left').height(),
            $home_message = $home_cta.find('.home-cta-message');
        /* -------------- *
         * Call To Action *
         * -------------- */

        // Launch on load and on window resize
        resize();
        $(window).resize(resize);

        function resize() {

            var window_height = $(window).height();

            // Subtract wpadminbar height if it exists
            if ($wpadminbar.length !== 0) {
                window_height = window_height - $wpadminbar.height();
            }

            $home_cta.height(window_height - header_height);
            $home_message.css('margin-top', $home_message.height() / 2 * -1);
        }

        // Scroll down
        $scroll.click(function () {

            $('body, html').animate({
                scrollTop: $(this).closest('section').next('section').offset().top -
                $('#site-header').find('.site-nav-left').height() -
                ($wpadminbar.length ? $wpadminbar.height() : 0)
            }, 500);

            return false;
        });

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
        $('.section').each(function () {

            // Height
            var section_height = $(window).height() - header_height - ($wpadminbar.length ? $wpadminbar.height() : 0);

            $(this).css('minHeight', section_height);

            // Action line
            var $button = $(this).find('.section-cta'),
                line_height = $button.outerHeight() + 20,
                offset = $button.offset().top - $(this).offset().top - 10,
                direction = 'left';

            $(this).prepend('<div class="section-line ' + direction + '" style="height: ' + line_height + 'px; top: ' + offset + 'px;"" />');
        });

        $(window).resize(function () {

            $('.section').each(function () {

                var offset = $(this).find('.section-cta').offset().top - $(this).offset().top - 10;
                $(this).find('.section-line').css('top', offset);
            });
        });

        /* -------- *
         * Services *
         * -------- */

        var $services_list = $('.service-item');

        $(window).scroll(function () {

            //$services_list.first().each(function () {
            //    reveal_service($(this));
            //});

        });

            //$('.services-list').css('opacity', 0);
            $services_list.removeClass('visible');
            $services_list.find('.service-icon').removeClass('visible');

        function reveal_service($e) {

            setTimeout(function () {

                $('.services-list').css('opacity', 1);
                $e.addClass('visible');

                setTimeout(function () {
                    reveal_icon($e.find('.service-icon').first());
                }, 500);

                if ($e.next('.service-item').length) {
                    reveal_service($e.next('.service-item'));
                }
            }, 500);
        }

        function reveal_icon($e) {

            $e.addClass('visible');

            if ($e.next('.service-icon')) {
                setTimeout(function () {
                    reveal_icon($e.next('.service-icon'));
                }, 25);
            }
        }

        /* ---------- *
         * Portfolios *
         * ---------- */

            var $portfolio_containe = $('.portfolio'),
                $portfolios = $portfolio_containe.find('.portfolio-item');

            // Establish defaults on load
            $portfolio_containe.find('.portfolios-left, .portfolios-right').show();
            $portfolios.removeClass('no-js').not(':eq(0)').removeClass('active');
            $portfolio_containe.find('.portfolio-list').height($portfolios.first().outerHeight());

            // Next
            $portfolio_containe.find('.portfolios-right').click(function () {

                var $current = $portfolios.filter('.active'),
                    $next = $current.next();

                $current.removeClass('active');

                if ($current.is(':last-child')) {
                    $next = $portfolios.filter(':first-child');
                }

                $next.addClass('active');
            });

            // Previous
            $portfolio_containe.find('.portfolios-left').click(function () {

                var $current = $portfolios.filter('.active'),
                    $prev = $current.prev();

                $current.removeClass('active');

                if ($current.is(':first-child')) {
                    $prev = $portfolios.filter(':last-child');
                }

                $prev.addClass('active');
            });

        /* ------------ *
         * Testimonials *
         * ------------ */

            var $testimonials = $('.testimonials'),
                $paragraphs = $testimonials.find('.testimonial-content').find('p');

            $paragraphs.not(':eq(0)').removeClass('active');
            $testimonials.find('.testimonial-item').not(':eq(0)').removeClass('active');

            $testimonials.find('.testimonial-item a').click(function () {

                var $parent = $(this).closest('.testimonial-item'),
                    index = $parent.index();

                $parent.addClass('active').siblings('.testimonial-item').removeClass('active');
                $paragraphs.removeClass('active').eq(index).addClass('active');

                return false;
            });
    })

})(jQuery);
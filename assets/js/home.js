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
        var $wpadminbar = $('#wpadminbar'),
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

        /* -------- *
         * Services *
         * -------- */

        var $services_list = $('.service-item');

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

        var $portfolio_container = $('.portfolio'),
            $portfolios = $portfolio_container.find('.portfolio-item');

        // Establish defaults on load
        $portfolio_container.find('.portfolios-left, .portfolios-right').show();
        $portfolios.removeClass('no-js').not(':eq(0)').removeClass('active');

        $(window).load(resize_portfolio_container);
        $(window).resize(resize_portfolio_container);

        function resize_portfolio_container() {
            $('.portfolio').find('.portfolio-list').height($portfolios.first().outerHeight());
        }

        // Next
        $portfolio_container.find('.portfolios-right').click(function () {

            var $current = $portfolios.filter('.active'),
                $next = $current.next();

            $current.removeClass('active');

            $portfolios.addClass('right').removeClass('left');

            if ($current.is(':last-child')) {
                $next = $portfolios.filter(':first-child');
            }

            $next.addClass('active');
        });

        // Previous
        $portfolio_container.find('.portfolios-left').click(function () {

            var $current = $portfolios.filter('.active'),
                $prev = $current.prev();

            $current.removeClass('active');

            $portfolios.addClass('left').removeClass('right');

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
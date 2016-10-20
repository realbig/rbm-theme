/**
 Adds some circle nav functionality, like tips.

 @since {{VERSION}}
 @package RBMTheme
 */
(function ($) {
    'use strict';

    var $circle_nav;

    /**
     * Initializes the nav functions.
     *
     * @since {{VERSION}}
     */
    function circle_nav_init() {

        $circle_nav = $('#menu-top-menu-circular');

        if (!$circle_nav.length) {

            return;
        }

        $circle_nav.find('.menu-item').hover(circle_nav_hover_in, circle_nav_hover_out);
        $(window).mousemove(circle_nav_tip_reposition);
    }

    /**
     * Fires when hovering a nav item.
     *
     * @since {{VERSION}}
     */
    function circle_nav_hover_in(e) {

        var $tip = $('<div class="rbm-nav-tip" />'),
            text = $(this).find('a').attr('title');

        $tip.attr('id', 'rbm-nav-tip-' + $(this).attr('id'))
            .html(text)
            .css({
                top: e.pageY,
                left: e.pageX
            })
            .appendTo('body');
    }

    /**
     * Fires when leaving (un-hovering) a nav item.
     *
     * @since {{VERSION}}
     */
    function circle_nav_hover_out() {

        var $tip = $('#rbm-nav-tip-' + $(this).attr('id'));

        $tip.remove();
    }

    /**
     * Makes the tips follow the mouse.
     *
     * @since {{VERSION}}
     */
    function circle_nav_tip_reposition(e) {

        var $tips = $('.rbm-nav-tip');

        if (!$tips.length) {

            return;
        }

        $tips.css({
            top: e.pageY,
            left: e.pageX
        });
    }

    $(circle_nav_init);

})(jQuery);
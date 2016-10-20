/**
 Header functionality.

 @since 0.1.0
 @package RBMTheme
 */
(function ($) {
    'use strict';

    var $mobile_menu, $mobile_menu_toggle, $header;

    function mobile_menu_init() {

        $header = $('#site-header');
        $mobile_menu = $('#menu-top-primary-mobile');
        $mobile_menu_toggle = $header.find('[data-toggle-mobile-nav]');

        if (!$mobile_menu.length) {

            return;
        }

        // Mobile menu toggle
        $mobile_menu_toggle.click(mobile_menu_toggle);
    }

    function mobile_menu_toggle(e) {

        e.preventDefault();

        if ($mobile_menu.is(':visible')) {

            $mobile_menu_toggle.removeClass('menu-visible');
            $mobile_menu.stop().slideUp();

        } else {

            $mobile_menu_toggle.addClass('menu-visible');
            $mobile_menu.stop().slideDown();
            //$header.css('height', $header.height() + )
        }
    }

    $(mobile_menu_init);

})(jQuery);
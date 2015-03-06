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

    //$('html').addClass('no-csstransforms').removeClass('csstransforms');

})(jQuery);
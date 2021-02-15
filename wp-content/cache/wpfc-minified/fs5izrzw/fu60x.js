// source --> https://training.netrika.com/wp-content/plugins/stm-post-type/theme/assets/stm_lms_lazyload.js?ver=5.5.3 
(function ($) {
    document.addEventListener('lazybeforeunveil', function (e) {
        $(e.target).closest('.stm_lms_lazy_image').addClass('stm_lms_lazy_image__lazyloaded');
    });
})(jQuery);
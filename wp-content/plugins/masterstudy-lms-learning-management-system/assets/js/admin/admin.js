"use strict";

(function ($) {
  $(document).ready(function () {
    $('body').on('click', '[data-field=wpcfto_addon_option_certificate_settings_title]', function () {
      $(this).closest('.stm_lms_group_started').toggleClass('open');
    });
    $('body').on('click', '.certificate_banner a.disabled', function (e) {
      e.preventDefault();
      var url = $(this).attr('href');
      var newUrl = $(this).attr('data-url');
      $.ajax({
        url: url,
        success: function success() {
          window.location.href = newUrl;
        }
      });
    });
  });
})(jQuery);
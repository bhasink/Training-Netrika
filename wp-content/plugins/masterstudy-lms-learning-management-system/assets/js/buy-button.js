"use strict";

(function ($) {
  $(document).ready(function () {
    $('.stm_lms_mixed_button.subscription_enabled > .btn').on('click', function () {
      $('.stm_lms_mixed_button').toggleClass('active');
    });
    var $body = $('body');
    /*Guest checkout*/

    $body.on('click', '[data-guest]', function (e) {
      e.preventDefault();
      var item_id = $(this).data('guest');
      var currentCart = $.cookie('stm_lms_notauth_cart');
      currentCart = typeof currentCart === 'undefined' ? [] : JSON.parse(currentCart);
      if (!currentCart.includes(item_id)) currentCart.push(item_id);
      $.cookie('stm_lms_notauth_cart', JSON.stringify(currentCart), {
        path: '/'
      });
      $.ajax({
        url: stm_lms_ajaxurl,
        dataType: 'json',
        context: this,
        data: {
          item_id: item_id,
          action: 'stm_lms_add_to_cart_guest'
        },
        beforeSend: function beforeSend() {
          $(this).addClass('loading');
        },
        complete: function complete(data) {
          data = data['responseJSON'];
          $(this).removeClass('loading');
          $(this).find('span').text(data['text']);

          if (data['cart_url']) {
            if (data['redirect']) window.location = data['cart_url'];
            $(this).attr('href', data['cart_url']).removeAttr('data-guest').addClass('goToCartUrl');
          }
        }
      });
    });
    $body.on('click', '.goToCartUrl', function () {
      window.location.href = $(this).attr('href');
    });
  });
})(jQuery);
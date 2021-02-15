// source --> https://training.netrika.com/wp-content/plugins/masterstudy-lms-learning-management-system/assets/js/courses.js?ver=1 
"use strict";

(function ($) {
  $(document).ready(function () {
    /**
     *
     * @var courses_view
     */
    var $more = $('.stm_lms_load_more_courses');

    if ($('body').hasClass('stm_lms_infinite')) {
      $(window).on('scroll', function () {
        $more.each(function () {
          if (!$(this).is(":hidden")) {
            var $this = $(this);
            var position = $this.position().top;
            var top = $(document).scrollTop();

            if (position - 100 < top) {
              $more.click();
            }
          }
        });
      });
    }

    $more.on('click', function (e) {
      if ($(this).is(":hidden")) return false;
      if ($(this).hasClass('loading')) return false;
      e.preventDefault();
      var offset = $(this).attr('data-offset');
      var template = $(this).attr('data-template');
      var args = $(this).attr('data-args');
      var $grid = $(this).closest('.stm_lms_courses').find('[data-pages]');
      var total = $grid.attr('data-pages');
      var suburl = $(this).attr('data-url');
      var $sort = $('.courses_filters .stm_lms_courses_grid__sort select');
      var data = {
        offset: offset,
        template: template,
        args: args,
        action: 'stm_lms_load_content'
      };

      if ($sort.length) {
        data['sort'] = $sort.val();
      }

      if (total == offset) return false;
      $.ajax({
        url: stm_lms_ajaxurl + suburl,
        dataType: 'json',
        context: this,
        data: data,
        beforeSend: function beforeSend() {
          $(this).addClass('loading');
        },
        complete: function complete(data) {
          data = data['responseJSON'];
          $(this).removeClass('loading');
          $grid.append(data['content']);
          $(this).attr('data-offset', data['page']);
          hide_button($(this), data['page']);
        }
      });
    });
    $more.each(function () {
      hide_button($(this), 1);
    });

    if (courses_view.type === 'list') {
      $('.courses_filters__switcher .list_view').click();
    }
  });
})(jQuery);

var a = 1;

function hide_button($btn, page) {
  var $container = $btn.closest('.stm_lms_courses').find('[data-pages]');
  var pages = $container.attr('data-pages');
  console.log(pages, page);

  if (parseInt(pages) === page || parseInt(pages) < page || !$container.length) {
    $btn.slideUp();
    $btn.closest('.stm_lms_courses').addClass('all_loaded');
  } else {
    $btn.slideDown();
    $btn.closest('.stm_lms_courses').removeClass('all_loaded');
  }
};
// source --> https://training.netrika.com/wp-content/plugins/masterstudy-lms-learning-management-system/assets/js/courses_filters.js?ver=1 
"use strict";

(function ($) {
  $(document).ready(function () {
    if (!$('.courses_filters').length) return true;
    var $sort = $('.courses_filters .stm_lms_courses_grid__sort select');
    var $container = $sort.closest('.stm_lms_courses_wrapper').find('.stm_lms_courses__archive');
    var $btn = $container.find('.stm_lms_load_more_courses');
    var offset = 0;
    var template = $btn.attr('data-template');
    var args = $btn.attr('data-args');
    $sort.on('change', function (e) {
      var suburl = $btn.attr('data-url');
      var sort_value = $sort.val();
      $btn.attr('data-args', args.replace('}', ',"sort":"' + sort_value + '"}'));
      if ($btn.hasClass('loading')) return false;
      $.ajax({
        url: stm_lms_ajaxurl + suburl,
        dataType: 'json',
        context: this,
        data: {
          offset: offset,
          template: template,
          sort: sort_value,
          args: args,
          action: 'stm_lms_load_content'
        },
        beforeSend: function beforeSend() {
          $btn.addClass('loading');
          $container.addClass('loading');
        },
        complete: function complete(data) {
          data = data['responseJSON'];
          $btn.removeClass('loading');
          $container.removeClass('loading');
          var $pages = $btn.closest('.stm_lms_courses').find('[data-pages]');
          $pages.html(data['content']);
          $pages.attr('data-pages', data['pages']);
          $btn.attr('data-offset', 1);
          hide_button($btn, 1);
        }
      });
    });
    course_switcher();
  });

  function course_switcher() {
    $('.courses_filters__switcher i').on('click', function () {
      var view = $(this).attr('data-view');
      $('.courses_filters__switcher i').removeClass('active');
      $(this).addClass('active');

      if (view === 'grid') {
        $('.stm_lms_courses_wrapper').removeClass('stm_lms_courses_list_view').addClass('stm_lms_courses_grid_view');
      } else {
        $('.stm_lms_courses_wrapper').removeClass('stm_lms_courses_grid_view').addClass('stm_lms_courses_list_view');
      }
    });
  }
})(jQuery);
// source --> https://training.netrika.com/wp-content/plugins/masterstudy-lms-learning-management-system/assets/js/wishlist.js?ver=1 
"use strict";

(function ($) {
  $(document).ready(function () {
    $('body').on('click', '.stm-lms-wishlist', function () {
      var post_id = $(this).attr('data-id');

      if ($('body').hasClass('logged-in')) {
        $.ajax({
          url: stm_lms_ajaxurl,
          dataType: 'json',
          context: this,
          data: {
            action: 'stm_lms_wishlist',
            nonce: stm_lms_nonces['stm_lms_wishlist'],
            post_id: post_id
          },
          beforeSend: function beforeSend() {
            $(this).addClass('loading');
          },
          complete: function complete(data) {
            var data = data['responseJSON'];
            $(this).removeClass('loading');
            $(this).find('i').attr('class', data.icon);
            $(this).find('span').text(data.text);
          }
        });
      } else {
        /*Get cookie*/
        var cookie_name = 'stm_lms_wishlist';
        var wishlist = $.cookie(cookie_name);
        wishlist = typeof wishlist === 'undefined' ? [] : wishlist.split(',');

        if (wishlist.indexOf(post_id) >= 0) {
          /*Remove from cookie*/
          var index = wishlist.indexOf(post_id);
          wishlist.splice(index, 1);
          var icon = $(this).attr('data-add-icon');
          var text = $(this).attr('data-add');
        } else {
          /*Set cookie*/
          wishlist.push(post_id);
          var icon = $(this).attr('data-remove-icon');
          var text = $(this).attr('data-remove');
        }

        $.cookie(cookie_name, wishlist.join(','), {
          path: '/'
        });
        $(this).find('i').attr('class', icon);
        $(this).find('span').text(text);
      }
    });
  });
})(jQuery);
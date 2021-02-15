<div class="stm_lms_course__image">
    <?php
    $img_size = '870-440';
    if (function_exists('stm_get_VC_img')) {
        echo stm_lms_lazyload_image(stm_get_VC_img(get_post_thumbnail_id(get_the_ID()), $img_size));
    } else {
        the_post_thumbnail($img_size);
    }
    ?>
</div>

<div class="stm_lms_course__content">
    <?php the_content(); ?>
</div>
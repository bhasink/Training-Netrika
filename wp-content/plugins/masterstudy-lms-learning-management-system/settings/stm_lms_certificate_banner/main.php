<?php
add_filter('wpcfto_lms_field_stm_lms_certificate_banner', function () {
    return STM_LMS_PATH . '/settings/stm_lms_certificate_banner/stm_lms_certificate_banner.php';
});
<div v-if="course.expiration.length && !course.is_expired" class="stm_lms_expired_notice__wrapper" v-html="course.expiration"></div>

<div class="stm_lms_expired_notice__wrapper" v-else-if="course.expiration.length && course.is_expired">
    <div class="stm_lms_expired_notice warning_expired">
        <i class="far fa-clock"></i>
        <?php esc_html_e('Course has expired', 'masterstudy-lms-learning-management-system'); ?>
    </div>
</div>
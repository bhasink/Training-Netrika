<?php
/**
 * @var $current_user
 */

wp_enqueue_script('vue-resource.js');
stm_lms_register_script('instructor_courses');

$links = STM_LMS_Instructor::instructor_links();
stm_lms_register_style('instructor_courses');

?>

    <div class="stm_lms_instructor_courses__top">
        <h3><?php esc_html_e('Courses', 'masterstudy-lms-learning-management-system'); ?></h3>
        <a href="<?php echo esc_url($links['add_new']); ?>" class="btn btn-default" target="_blank">
            <i class="fa fa-plus"></i>
            <?php esc_html_e('Add New course', 'masterstudy-lms-learning-management-system'); ?>
        </a>
    </div>

    <div class="stm_lms_instructor_courses vue_is_disabled" id="stm_lms_instructor_courses" v-if="courses.length"
         v-bind:class="{'is_vue_loaded' : vue_loaded}">

        <div class="stm_lms_instructor_quota heading_font" v-if="Object.keys(quota).length">
            <div class="stm_lms_instructor_quota__modal">
                <h5>
                    <span class="quota_label"><?php esc_html_e('Available featured Quotes:', 'masterstudy-lms-learning-management-system'); ?></span>
                    <span class="used_quota">{{quota.used_quota}}</span> from <span class="total_quota">{{quota.total_quota}}</span>
                </h5>
                <div class="stm_lms_instructor_quota__buttons">
                    <span class="btn btn-default"
                          @click="quota = {}"><?php esc_html_e('Done', 'masterstudy-lms-learning-management-system'); ?></span>
                    <a href="<?php echo STM_LMS_Subscriptions::level_url(); ?>"
                       v-if="quota.available_quota === 0"
                       class="btn btn-default upgrade">
                        <?php esc_html_e('Upgrade', 'masterstudy-lms-learning-management-system'); ?>
                    </a>
                </div>
            </div>
            <div class="stm_lms_instructor_quota__overlay" @click="quota = {}"></div>
        </div>

        <?php STM_LMS_Templates::show_lms_template('account/private/instructor_parts/grid'); ?>

        <a href="#"
           class="btn btn-default"
           @click.prevent="loadCourses()"
           v-if="!total"
           v-bind:class="{'loading': loading}">
            <span><?php esc_html_e('Load more', 'masterstudy-lms-learning-management-system') ?></span>
        </a>


    </div>

<?php do_action('stm_lms_instructor_courses_end');
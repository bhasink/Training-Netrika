<?php

new STM_LMS_Sequential_Drip_Content;

class STM_LMS_Sequential_Drip_Content
{

    function __construct()
    {

        add_filter('stm_lms_curriculum_item_status', array($this, 'curriculum_item_status'), 10, 4);

        add_action('stm_lms_lesson_manage_settings', array($this, 'lesson_manage_settings'));

        add_filter('stm_lms_lesson_content', array($this, 'lesson_content'), 10, 3);
        add_filter('stm_lms_prev_status', array($this, "prev_status"), 10, 4);

        add_filter('stm_wpcfto_fields', array($this, 'sequential_fields'));
        add_filter('stm_wpcfto_fields', array($this, 'add_lesson_type_admin'), 100, 1);

        add_filter('wpcfto_options_page_setup', array($this, 'stm_lms_settings_page'));

        add_filter('stm_lms_completed_label', array($this, 'show_complete_button'), 100, 3);
    }

    /*Settings*/
    function stm_lms_settings_page($setups)
    {

        $setups[] = array(
            'page' => array(
                'parent_slug' => 'stm-lms-settings',
                'page_title' => 'Sequential Drip Content',
                'menu_title' => 'Sequential Drip Content',
                'menu_slug' => 'sequential_drip_content',
            ),
            'fields' => $this->stm_lms_settings(),
            'option_name' => 'stm_lms_sequential_drip_content_settings'
        );

        return $setups;
    }

    function stm_lms_settings()
    {
        return apply_filters('stm_lms_sequential_drip_content_settings', array(
            'credentials' => array(
                'name' => esc_html__('Credentials', 'masterstudy-lms-learning-management-system-pro'),
                'fields' => array(
                    'locked' => array(
                        'type' => 'checkbox',
                        'label' => esc_html__('Lock lessons sequentially', 'masterstudy-lms-learning-management-system-pro'),
                        'value' => false
                    ),
                    'lock_before_start' => array(
                        'type' => 'checkbox',
                        'label' => esc_html__('Lock lesson before it starts', 'masterstudy-lms-learning-management-system-pro'),
                        'value' => false
                    ),
                )
            ),
        ));
    }

    function stm_lms_get_settings()
    {
        return get_option('stm_lms_sequential_drip_content_settings', array());
    }

    /*Filters*/
    function curriculum_item_status($html, $previous_completed, $course_id, $item_id)
    {

        $settings = self::stm_lms_get_settings();

        if (!empty($settings['locked']) and empty($previous_completed)) {
            $html = '<div class="stm-curriculum-item__completed locked">
                <i class="fa fa-lock"></i>
            </div>';
        }

        $parent_passed = self::is_parent_passed($course_id, $item_id);
        if (!$parent_passed) {
            $html = '<div class="stm-curriculum-item__completed locked">
                <i class="fa fa-lock"></i>
            </div>';
        }

        return $html;
    }

    public static function lesson_manage_settings()
    {
        $settings = get_option('stm_lms_sequential_drip_content_settings', array());

        if (!empty($settings['lock_before_start'])) {
            ?>

            <?php STM_LMS_Templates::show_lms_template('manage_course/forms/js/date'); ?>

            <div class="drip_content_fields">

                <div class="form-group">
                    <div class="stm-lms-admin-checkbox">
                        <label>
                            <h4><?php esc_html_e('Unlock the lesson after a certain time after the purchase', 'masterstudy-lms-learning-management-system-pro'); ?></h4>
                        </label>
                        <div class="stm-lms-admin-checkbox-wrapper"
                             v-bind:class="{'active' : fields['lesson_lock_from_start']}">
                            <div class="stm-lms-checkbox-switcher"></div>
                            <input type="checkbox" name="lesson_lock_from_start"
                                   v-model="fields['lesson_lock_from_start']">
                        </div>
                    </div>
                </div>

                <div class="form-group" v-if="!fields['lesson_lock_from_start']">
                    <label>
                        <h4><?php esc_html_e('Lesson start date', 'masterstudy-lms-learning-management-system-pro'); ?></h4>
                        <stm-date v-bind:current_date="fields['lesson_start_date']"
                                  placeholder=""
                                  v-on:date-changed="dateChanged($event, 'lesson_start_date');" required></stm-date>

                    </label>
                </div>

                <div class="form-group" v-if="!fields['lesson_lock_from_start']">
                    <label>
                        <h4><?php esc_html_e('Lesson start time', 'masterstudy-lms-learning-management-system-pro'); ?></h4>
                        <input class="form-control" type="time" v-model="fields['lesson_start_time']"/>
                    </label>
                </div>

                <div class="form-group" v-if="fields['lesson_lock_from_start']">
                    <label>
                        <h4><?php esc_html_e('Unlock lesson after purchase (days)', 'masterstudy-lms-learning-management-system-pro'); ?></h4>
                        <input class="form-control" type="number" v-model="fields['lesson_lock_start_days']"/>
                    </label>
                </div>

            </div>

        <?php }
    }

    public static function time_offset()
    {
        return get_option('gmt_offset') * 60 * 60;
    }

    public static function lesson_start_time($item_id, $post_id)
    {

        $lock_from_time = get_post_meta($item_id, 'lesson_lock_start_days', true);

        if (!empty($lock_from_time)) {
            $user_course = stm_lms_get_user_course(get_current_user_id(), $post_id, array('start_time'));

            if (!empty($user_course)) $user_course = STM_LMS_Helpers::simplify_db_array($user_course);
            if (!empty($user_course) and !empty($user_course['start_time'])) {
                return strtotime("+{$lock_from_time} days", $user_course['start_time']);
            }
        }

        $start_date = get_post_meta($item_id, 'lesson_start_date', true);
        $start_time = get_post_meta($item_id, 'lesson_start_time', true);

        if (empty($start_date) or empty($start_date)) return '';

        $offset = self::time_offset();

        $stream_start = strtotime('tomorrow', ($start_date / 1000)) - $offset;

        if (!empty($start_time)) {
            $time = explode(':', $start_time);
            if (is_array($time) and count($time) === 2) {
                $stream_start = strtotime("+{$time[0]} hours +{$time[1]} minutes", $stream_start);
            }
        }

        return $stream_start;

    }

    public static function is_lesson_started($item_id, $post_id)
    {

        $stream_start = self::lesson_start_time($item_id, $post_id);

        /*NO TIME - STREAM STARTED*/
        if (empty($stream_start)) return true;

        if ($stream_start > time()) return false;

        return true;

    }

    function show_complete_button($completed_label, $item_id, $post_id)
    {
        $settings = self::stm_lms_get_settings();
        if (!empty($settings['lock_before_start'])) {
            if (!self::is_lesson_started($item_id, $post_id)) {
                $completed_label = array();
            }
        }
        return $completed_label;
    }

    function lesson_content($html, $post_id, $item_id)
    {
        $settings = self::stm_lms_get_settings();

        if (!empty($settings['lock_before_start'])) {
            if (!self::is_lesson_started($item_id, $post_id)) {
                ob_start();
                STM_LMS_Templates::show_lms_template('sequential_drip_content/main', compact('post_id', 'item_id'));
                $html = ob_get_clean();
            }
        }

        if (empty($settings['locked'])) {

            /*Check Deps*/
            $parent_passed = self::is_parent_passed($post_id, $item_id, true);

            if (isset($parent_passed['passed']) and !$parent_passed['passed']) {
                $prev_lesson_url = STM_LMS_Course::item_url($post_id, $parent_passed['parent']);
                wp_safe_redirect($prev_lesson_url);
            }

            return $html;
        }

        $curriculum = get_post_meta($post_id, 'curriculum', true);
        if (!empty($curriculum)) {
            $curriculum = explode(',', $curriculum);
            $curriculum = array_values(array_filter($curriculum, function ($value) {
                return is_numeric($value);
            }));
        }

        $item_order = array_search($item_id, $curriculum);

        /*First item is always allowed to do*/
        if ($item_order === 0) {
            return $html;
        }

        /*Check if prev lesson is passed*/
        $prev_lesson = (!empty($curriculum[$item_order - 1])) ? $curriculum[$item_order - 1] : 0;
        $is_prev_lesson_completed = STM_LMS_Lesson::is_lesson_completed('', $post_id, $prev_lesson);

        if (!$is_prev_lesson_completed) {
            $prev_lesson_url = STM_LMS_Course::item_url($post_id, $prev_lesson);
            wp_safe_redirect($prev_lesson_url);
        } else {
            return $html;
        }

        return $html;

    }

    function prev_status($status, $course_id, $item_id, $user_id)
    {

        $settings = self::stm_lms_get_settings();
        if (empty($settings['locked'])) $status = '';

        /*Check Item Deps*/
        $parent_passed = self::is_parent_passed($course_id, $item_id, false, $user_id);
        $status = (!$parent_passed) ? '' : 'opened';

        return "prev-status-{$status}";
    }

    function sequential_fields($fields)
    {
        $fields['stm_courses_settings']['section_drip_content']['fields']['drip_content'] = array(
            'type' => 'drip_content',
            'post_type' => array('stm-lessons', 'stm-quizzes'),
            'label' => esc_html__('Sequential Drip Content', 'masterstudy-lms-learning-management-system-pro'),
        );


        return $fields;
    }

    public static function add_lesson_type_admin($fields)
    {
        $settings = get_option('stm_lms_sequential_drip_content_settings', array());

        if (!empty($settings['lock_before_start'])) {

            $fields['stm_lesson_settings']['section_lesson_settings']['fields']['lesson_lock_from_start'] = array(
                'type' => 'checkbox',
                'label' => esc_html__('Unlock the lesson after a certain time after the purchase', 'masterstudy-lms-learning-management-system-pro'),
            );

            $fields['stm_lesson_settings']['section_lesson_settings']['fields']['lesson_start_date'] = array(
                'type' => 'date',
                'label' => esc_html__('Lesson Start Date', 'masterstudy-lms-learning-management-system-pro'),
                'value' => '',
                'dependency' => array(
                    'key' => 'lesson_lock_from_start',
                    'value' => 'empty'
                )
            );

            $fields['stm_lesson_settings']['section_lesson_settings']['fields']['lesson_start_time'] = array(
                'type' => 'time',
                'label' => esc_html__('Lesson Start Time', 'masterstudy-lms-learning-management-system-pro'),
                'value' => '',
                'dependency' => array(
                    'key' => 'lesson_lock_from_start',
                    'value' => 'empty'
                )
            );

            $fields['stm_lesson_settings']['section_lesson_settings']['fields']['lesson_lock_start_days'] = array(
                'type' => 'number',
                'label' => esc_html__('Unlock lesson after purchase (days)', 'masterstudy-lms-learning-management-system-pro'),
                'value' => '',
                'dependency' => array(
                    'key' => 'lesson_lock_from_start',
                    'value' => 'not_empty'
                )
            );

        }


        return $fields;
    }

    function is_parent_passed($course_id, $item_id, $get_parent = false, $user_id = '')
    {
        $check_parent_passed = true;

        $item_id = intval($item_id);

        $drip_content = get_post_meta($course_id, 'drip_content', true);

        if (!empty($drip_content)) {
            $drip_content = json_decode($drip_content, true);
            if (!empty($drip_content)) {
                foreach ($drip_content as $drip_content_single) {
                    //wp_send_json($drip_content_single);
                    if (!empty($drip_content_single['childs'])) {
                        foreach ($drip_content_single['childs'] as $drip_content_child) {
                            if ($item_id === $drip_content_child['id']) {
                                $parent = $drip_content_single['parent']['id'];
                                $check_parent_passed = STM_LMS_Lesson::is_lesson_completed($user_id, $course_id, $parent);
                                if ($get_parent) {
                                    $check_parent_passed = array(
                                        'passed' => $check_parent_passed,
                                        'parent' => $parent
                                    );
                                }
                            }
                        }
                    }
                }
            }
        }

        return $check_parent_passed;
    }
}
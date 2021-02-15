<?php

STM_LMS_Instructor::init();

class STM_LMS_Instructor extends STM_LMS_User
{

    public static function init()
    {

        add_filter('map_meta_cap', 'STM_LMS_Instructor::meta_cap', 10, 4);

        add_action('wp_ajax_stm_lms_get_instructor_courses', 'STM_LMS_Instructor::get_courses');

        add_filter('manage_stm-courses_posts_columns', 'STM_LMS_Instructor::columns');
        add_action('manage_stm-courses_posts_custom_column', 'STM_LMS_Instructor::column_fields', 10, 2);

        add_filter('manage_stm-lessons_posts_columns', 'STM_LMS_Instructor::lesson_columns');
        add_action('manage_stm-lessons_posts_custom_column', 'STM_LMS_Instructor::column_fields', 10, 2);

        add_filter('manage_stm-quizzes_posts_columns', 'STM_LMS_Instructor::quiz_columns');
        add_action('manage_stm-quizzes_posts_custom_column', 'STM_LMS_Instructor::column_fields', 10, 2);

        add_action('admin_enqueue_scripts', 'STM_LMS_Instructor::scripts');

        add_action('wp_ajax_stm_lms_change_lms_author', 'STM_LMS_Instructor::change_author');

        add_filter('pre_get_posts', 'STM_LMS_Instructor::posts_for_current_author');

        add_action('stm_lms_after_profile_buttons_all', 'STM_LMS_Instructor::add_student_frame_button');

        add_action('wp_ajax_stm_lms_add_student_manually', 'STM_LMS_Instructor::add_student_manually');

        add_action('wp_ajax_stm_lms_change_course_status', 'STM_LMS_Instructor::change_status');

        add_action('pending_to_publish', 'STM_LMS_Instructor::post_published', 10, 2);

        /*Plug for add student*/
        if (!class_exists('STM_LMS_Enterprise_Courses')) {
            add_action('wp_ajax_stm_lms_get_enterprise_groups', function () {
                return 'ok';
            });
        }

    }

    static function post_published($post)
    {
        $post_id = $post->ID;
        if (get_post_type($post_id) === 'stm-courses') {
            $course_title = get_the_title($post_id);
            $author_id = intval(get_post_field('post_author', $post_id));

            $subject = esc_html__('Course published', 'masterstudy-lms-learning-management-system');
            $message = esc_html__('Your course - {{course_title}} was approved, and now its live on site', 'masterstudy-lms-learning-management-system');
            $user = STM_LMS_User::get_current_user($author_id);

            STM_LMS_Mails::send_email($subject, $message, $user['email'], array(), 'stm_lms_course_published', compact('course_title'));

        }

    }

    static function change_status()
    {

        $statuses = array(
            'draft',
            'publish'
        );

        $user = STM_LMS_User::get_current_user();

        if (empty($user['id'])) die;

        $user_id = $user['id'];

        if (empty($_GET['post_id']) || (empty($_GET['status']) && in_array($_GET['status'], $statuses))) die;

        $course_id = intval($_GET['post_id']);
        $status = sanitize_text_field($_GET['status']);

        if (!STM_LMS_Course::check_course_author($course_id, $user_id)) die;

        if (apply_filters('stm_lms_before_change_course_status', false)) {
            do_action('stm_lms_change_course_status', $status);
            wp_send_json($status);
        }

        if ($status === 'publish') {
            $premoderation = STM_LMS_Options::get_option('course_premoderation', false);
            $status = ($premoderation) ? 'pending' : 'publish';
        }

        wp_update_post(array(
            'ID' => $course_id,
            'post_status' => $status
        ));

        wp_send_json($status);

    }

    static function change_author()
    {

        if (!current_user_can('manage_options')) die;

        $author_id = intval($_GET['author_id']);
        $course_id = intval($_GET['post_id']);

        $arg = array(
            'ID' => $course_id,
            'post_author' => $author_id,
        );

        wp_update_post($arg);

        wp_send_json(get_post_field('post_author', $course_id));

    }

    static function columns($columns)
    {

        $columns['lms_course_students'] = esc_html__('Course Students', 'masterstudy-lms-learning-management-system');

        $columns['lms_author'] = esc_html__('Course Author', 'masterstudy-lms-learning-management-system');

        unset($columns['author']);

        return $columns;
    }

    static function lesson_columns($columns)
    {

        $columns['lms_author'] = esc_html__('Lesson Author', 'masterstudy-lms-learning-management-system');

        unset($columns['author']);

        return $columns;
    }

    static function quiz_columns($columns)
    {

        $columns['lms_author'] = esc_html__('Quiz Author', 'masterstudy-lms-learning-management-system');

        unset($columns['author']);

        return $columns;
    }

    static function column_fields($columns, $post_id)
    {

        switch ($columns) {
            case 'lms_author' :

                $args = array(
                    'role__in' => array('keymaster', 'administrator', 'stm_lms_instructor'),
                    'order' => 'ASC',
                    'orderby' => 'display_name',
                );

                $wp_user_query = new WP_User_Query($args);

                $authors = $wp_user_query->get_results();

                $authors = wp_list_pluck($authors, 'data');

                $post_author_id = get_post_field('post_author', $post_id);

                ?>

                <select name="lms_author" data-post="<?php echo esc_attr($post_id); ?>">
                    <?php foreach ($authors as $author): ?>
                        <option value="<?php echo esc_attr($author->ID); ?>" <?php selected($post_author_id, $author->ID) ?>>
                            <?php echo esc_html($author->user_login); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <a href="<?php echo esc_url(STM_LMS_Helpers::get_current_url()) ?>" class="button action">
                    <?php esc_html_e('Change Author', 'masterstudy-lms-learning-management-system'); ?>
                </a>

                <?php
                break;

            case 'lms_course_students' : ?>

                <a href="<?php echo admin_url("?page=stm-lms-dashboard#/course/{$post_id}"); ?>" class="button action">
                    <?php esc_html_e('Manage students', 'masterstudy-lms-learning-management-system'); ?>
                </a>

                <?php

                break;
        }
    }

    static function posts_for_current_author($query)
    {
        if (is_admin()) {
            global $pagenow;

            if ('edit.php' != $pagenow || !$query->is_admin)
                return $query;

            if (!current_user_can('edit_others_posts')) {
                global $user_ID;
                $query->set('author', $user_ID);
            }
        }
        return $query;
    }

    static function scripts($hook)
    {

        if ((get_post_type() === 'stm-courses' || get_post_type() === 'stm-lessons' || get_post_type() === 'stm-quizzes') && $hook === 'edit.php') {
            stm_lms_register_script('admin/change_lms_author', array('jquery'), true);
            stm_lms_register_style('admin/change_lms_author');
        }
    }

    public static function meta_cap($caps, $cap, $user_id, $args)
    {

        remove_filter('map_meta_cap', 'STM_LMS_Instructor::meta_cap', 10);

        if (!STM_LMS_Instructor::is_instructor()) return $caps;

        if ('edit_stm_lms_post' == $cap || 'delete_stm_lms_post' == $cap || 'read_stm_lms_post' == $cap) {
            $post = get_post($args[0]);
            $post_type = get_post_type_object($post->post_type);

            $caps = array();
        }

        if ('edit_stm_lms_post' == $cap) {
            if ($user_id == $post->post_author)
                $caps[] = $post_type->cap->edit_posts;
            else
                $caps[] = $post_type->cap->edit_others_posts;
        }

        if ('delete_stm_lms_post' == $cap) {
            if ($user_id == $post->post_author)
                $caps[] = $post_type->cap->delete_posts;
            else
                $caps[] = $post_type->cap->delete_others_posts;
        }

        if ('read_stm_lms_post' == $cap) {

            if ('private' != $post->post_status)
                $caps[] = 'read';
            elseif ($user_id == $post->post_author)
                $caps[] = 'read';
            else
                $caps[] = $post_type->cap->read_private_posts;
        }

        add_filter('map_meta_cap', 'STM_LMS_Instructor::meta_cap', 10, 4);

        return $caps;
    }

    public static function instructors_enabled()
    {
        return STM_LMS_Options::get_option('enable_instructors', false);
    }

    public static function role()
    {
        return 'stm_lms_instructor';
    }

    public static function is_instructor($user_id = null)
    {
        $user = parent::get_current_user($user_id, true, false, true);
        if (empty($user['id'])) return false;

        /*If admin*/
        if (in_array('administrator', $user['roles'])) return true;


        return in_array(STM_LMS_Instructor::role(), $user['roles']);
    }

    public static function instructor_links()
    {
        return apply_filters('stm_lms_instructor_links', array(
            'add_new' => admin_url('/post-new.php?post_type=stm-courses')
        ));
    }

    public static function get_courses($args = array(), $return = false, $get_all = false)
    {

        if (!$return) check_ajax_referer('stm_lms_get_instructor_courses', 'nonce');

        $user = STM_LMS_User::get_current_user();
        if (empty($user['id'])) die;
        $user_id = $user['id'];

        $r = array(
            'posts' => array()
        );

        $pp = (empty($_GET['pp'])) ? STM_LMS_Options::get_option('courses_per_page', get_option('posts_per_page')) : sanitize_text_field($_GET['pp']);
        $offset = (!empty($_GET['offset'])) ? intval($_GET['offset']) : 0;

        $get_ids = (!empty($_GET['ids_only']));

        if (!empty($args['posts_per_page'])) $pp = intval($args['posts_per_page']);

        $offset = $offset * $pp;

        $default_args = array(
            'post_type' => 'stm-courses',
            'posts_per_page' => $pp,
            'post_status' => array('publish', 'draft', 'pending'),
            'offset' => $offset,
        );

        if (!$get_all) {
            $default_args['author'] = $user_id;
        }

        $args = wp_parse_args($args, $default_args);

        $q = new WP_Query($args);

        $total = $q->found_posts;
        $r['total'] = $total <= $offset + $pp;
        $r['found'] = $total;
        $r['per_page'] = (int)$pp;
        $r['pages'] = (int)ceil($r['found'] / $r['per_page']);

        if ($q->have_posts()) {
            while ($q->have_posts()) {
                $q->the_post();
                $id = get_the_ID();
                if ($get_ids) {
                    $r['posts'][$id] = get_the_title($id);
                    continue;
                }

                $rating = get_post_meta($id, 'course_marks', true);
                $rates = STM_LMS_Course::course_average_rate($rating);
                $average = $rates['average'];
                $percent = $rates['percent'];

                $status = get_post_status($id);

                $price = get_post_meta($id, 'price', true);
                $sale_price = STM_LMS_Course::get_sale_price($id);

                if (empty($price) and !empty($sale_price)) {
                    $price = $sale_price;
                    $sale_price = '';
                }

                switch ($status) {
                    case 'publish' :
                        $status_label = esc_html__('Published', 'masterstudy-lms-learning-management-system');
                        break;
                    case 'pending' :
                        $status_label = esc_html__('Pending', 'masterstudy-lms-learning-management-system');
                        break;
                    default :
                        $status_label = esc_html__('Draft', 'masterstudy-lms-learning-management-system');
                        break;
                }

                $post_status = STM_LMS_Course::get_post_status($id);

                $image = (function_exists('stm_get_VC_img')) ? html_entity_decode(stm_get_VC_img(get_post_thumbnail_id(), '272x161')) : get_the_post_thumbnail($id, 'img-300-225');
                $image_small = (function_exists('stm_get_VC_img')) ? html_entity_decode(stm_get_VC_img(get_post_thumbnail_id(), '50x50')) : get_the_post_thumbnail($id, 'img-300-225');
                $is_featured = get_post_meta($id, 'featured', true);

                $rating_count = (!empty($rating)) ? count($rating) : '';

                $post = array(
                    'id' => $id,
                    'time' => get_post_time('U', true),
                    'title' => get_the_title(),
                    'updated' => sprintf(esc_html__('Last updated: %s', 'masterstudy-lms-learning-management-system'), stm_lms_time_elapsed_string(get_post($id)->post_modified)),
                    'link' => get_the_permalink(),
                    'image' => $image,
                    'image_small' => $image_small,
                    'terms' => stm_lms_get_terms_array($id, 'stm_lms_course_taxonomy', false, true),
                    'status' => $status,
                    'status_label' => $status_label,
                    'percent' => $percent,
                    'is_featured' => $is_featured,
                    'average' => $average,
                    'total' => $rating_count,
                    'views' => STM_LMS_Course::get_course_views($id),
                    'simple_price' => $price,
                    'price' => STM_LMS_Helpers::display_price($price),
                    'edit_link' => apply_filters('stm_lms_course_edit_link', admin_url("post.php?post={$id}&action=edit"), $id),
                    'post_status' => $post_status
                );

                $post['sale_price'] = (!empty($sale_price)) ? STM_LMS_Helpers::display_price($sale_price) : '';

                $r['posts'][] = $post;
            }
        }

        wp_reset_postdata();

        if ($return) return $r;

        wp_send_json($r);
    }

    public static function transient_name($user_id, $name = '')
    {
        return "stm_lms_instructor_{$user_id}_{$name}";
    }

    public static function my_rating_v2($user = '')
    {
        $user = (!empty($user)) ? $user : STM_LMS_User::get_current_user();
        $user_id = $user['id'];

        $sum_rating_key = 'sum_rating';
        $total_reviews_key = 'total_reviews';

        $sum_rating = (!empty(get_user_meta($user_id, $sum_rating_key, true))) ? get_user_meta($user_id, $sum_rating_key, true) : 0;
        $total_reviews = (!empty(get_user_meta($user_id, $total_reviews_key, true))) ? get_user_meta($user_id, $total_reviews_key, true) : 0;

        if (empty($sum_rating) or empty($total_reviews)) {
            return array(
                'total' => 0,
                'average' => 0,
                'total_marks' => "",
                'percent' => 0,
            );
        }

        $ratings['total'] = intval($sum_rating);
        $ratings['average'] = floatval(number_format($sum_rating / $total_reviews, 2));
        $label = _n('Review', 'Reviews', $total_reviews, 'masterstudy-lms-learning-management-system');
        $ratings['marks_num'] = intval($total_reviews);
        $ratings['total_marks'] = sprintf(_x('%s %s', '"1 Review" or "2 Reviews"', 'masterstudy-lms-learning-management-system'), $total_reviews, $label);

        $ratings['percent'] = intval(($ratings['average'] * 100) / 5);

        return $ratings;
    }

    public static function my_rating($user = '')
    {
        $ratings = array();
        $user = (!empty($user)) ? $user : STM_LMS_User::get_current_user();
        $user_id = $user['id'];

        $transient_name = STM_LMS_Instructor::transient_name($user_id, 'rating');
        if (false === ($ratings = get_transient($transient_name))) {
            $args = array(
                'post_type' => 'stm-courses',
                'posts_per_page' => '-1',
                'author' => $user_id
            );

            $q = new WP_Query($args);

            $ratings = array(
                'total_marks' => "",
                'total' => 0,
                'average' => 0,
                'percent' => 0
            );

            if ($q->have_posts()) {
                while ($q->have_posts()) {
                    $q->the_post();
                    $marks = get_post_meta(get_the_ID(), 'course_marks', true);
                    if (!empty($marks)) {
                        foreach ($marks as $mark) {
                            $ratings['total_marks']++;
                            $ratings['total'] += $mark;
                        }
                    } else {
                        continue;
                    }
                }

                $ratings['average'] = ($ratings['total'] AND $ratings['total_marks']) ? round($ratings['total'] / $ratings['total_marks'], 2) : 0;

                $ratings['marks_num'] = $ratings['total_marks'];

                $ratings['percent'] = ($ratings['average'] * 100) / 5;
            }

            wp_reset_postdata();

            set_transient($transient_name, $ratings, 7 * 24 * 60 * 60);
        }
        if (empty($ratings['marks_num'])) {
            $ratings['marks_num'] = 0;
        }
        $label = _n('Review', 'Reviews', $ratings['marks_num'], 'masterstudy-lms-learning-management-system');
        $ratings['total_marks'] = sprintf(_x('%s %s.', '"1 Review" or "2 Reviews"', 'masterstudy-lms-learning-management-system'), $ratings['marks_num'], $label);
        return $ratings;
    }

    public static function become_instructor($data, $user_id)
    {
        if (!empty($data['become_instructor']) and $data['become_instructor']) {
            $degree = (!empty($data['degree'])) ? sanitize_text_field($data['degree']) : esc_html__('N/A', 'masterstudy-lms-learning-management-system');
            $expertize = (!empty($data['expertize'])) ? sanitize_text_field($data['expertize']) : esc_html__('N/A', 'masterstudy-lms-learning-management-system');

            $subject = esc_html__('New Instructor Application', 'masterstudy-lms-learning-management-system');
            $user = STM_LMS_User::get_current_user($user_id);

            $user_login = $user['login'];

            $disable_instructor_premoderation = STM_LMS_Options::get_option('disable_instructor_premoderation', false);

            $message = sprintf(
                __('User %s with id - %s, wants to become an Instructor. Degree - %s. Expertize - %s', 'masterstudy-lms-learning-management-system'),
                $user_login,
                $user_id,
                $degree,
                $expertize
            );
            if ($disable_instructor_premoderation) {
                $update_user = wp_update_user(array(
                    'ID' => $user_id,
                    'role' => 'stm_lms_instructor'
                ));
                $message = sprintf(
                    __('User %s with id - %s, registered as Instructor. Degree - %s. Expertize - %s', 'masterstudy-lms-learning-management-system'),
                    $user_login,
                    $user_id,
                    $degree,
                    $expertize
                );
            }
            STM_LMS_Helpers::send_email(
                '',
                $subject,
                $message,
                'stm_lms_become_instructor_email',
                compact('user_login', 'user_id', 'degree', 'expertize')
            );

        }
    }

    public static function update_rating($user_id, $mark)
    {
        $sum_rating_key = 'sum_rating';
        $total_reviews_key = 'total_reviews';
        $average_key = 'average_rating';

        $sum_rating = (!empty(get_user_meta($user_id, $sum_rating_key, true))) ? get_user_meta($user_id, $sum_rating_key, true) : 0;
        $total_reviews = (!empty(get_user_meta($user_id, $total_reviews_key, true))) ? get_user_meta($user_id, $total_reviews_key, true) : 0;

        update_user_meta($user_id, $sum_rating_key, $sum_rating + $mark);
        update_user_meta($user_id, $total_reviews_key, $total_reviews + 1);
        update_user_meta($user_id, $average_key, round($sum_rating + $mark / $total_reviews + 1, 2));
    }

    public static function get_instructors_url()
    {
        $page_id = STM_LMS_Options::instructors_page();

        return (!empty($page_id)) ? get_permalink($page_id) : '';
    }

    public static function instructor_can_add_students()
    {
        return STM_LMS_Options::get_option('instructor_can_add_students', false);
    }

    static function instructor_add_students_url()
    {
        return home_url('/') . STM_LMS_WP_Router::route_urls('instructor_add_students');
    }

    public static function add_student_frame_button()
    {

        if (self::instructor_can_add_students() && self::is_instructor()) {
            STM_LMS_Templates::show_lms_template('account/private/add_student/button');
        }

    }

    static function _add_student_to_course($raw_courses, $raw_emails)
    {

        $courses = $emails = array();

        $data = array(
            'error' => false,
            'message' => esc_html__('Student added to course', 'masterstudy-lms-learning-management-system'),
        );

        $instructor_id = get_current_user_id();

        foreach ($raw_emails as $email) {
            if (is_email($email)) $emails[] = $email;
        }

        if (empty($emails)) die;

        foreach ($raw_courses as $course) {
            $course = intval($course);
            if (STM_LMS_Course::check_course_author($course, $instructor_id)) {
                $courses[] = $course;
            }
        }

        /*Now we checked all courses and emails, we can add users to site*/
        $user_ids = self::create_users_from_emails($emails);

        foreach ($courses as $course_id) {
            foreach ($user_ids as $user_id) {
                $user_course = stm_lms_get_user_course($user_id, $course_id, array());

                if (!empty($user_course)) continue;

                STM_LMS_Course::add_user_course(
                    $course_id,
                    $user_id,
                    STM_LMS_Course::get_first_lesson($course_id),
                    0,
                    false,
                    false,
                    false,
                    $instructor_id
                );

            }
        }

        if (count($courses) > 1 || count($emails) > 1) {
            $courses_n = _n('Course', 'Courses', count($courses), 'masterstudy-lms-learning-management-system');
            $students_n = _n('Student', 'Students', count($emails), 'masterstudy-lms-learning-management-system');
            $data['message'] = sprintf(esc_html__('%s added to %s', 'masterstudy-lms-learning-management-system'), $students_n, $courses_n);
        }

        return $data;
    }

    static function add_student_manually()
    {

        $raw_courses = $_POST['courses'];
        $raw_emails = $_POST['emails'];

        $data = self::_add_student_to_course($raw_courses, $raw_emails);

        wp_send_json($data);

    }

    static function create_users_from_emails($emails)
    {

        $users = array();

        foreach ($emails as $email) {
            $user = get_user_by('email', $email);

            if ($user) {
                $users[] = $user->ID;
                continue;
            }

            /*Create User*/
            $username = sanitize_title($email);
            $password = wp_generate_password();

            $user_id = wp_create_user($username, $password, $email);

            $subject = esc_html__('New course available', 'masterstudy-lms-learning-management-system');

            $site_url = get_bloginfo('url');
            $message = sprintf(
                esc_html__('Login: %s; Password: %s; Site URL: %s', 'masterstudy-lms-learning-management-system'),
                $username,
                $password,
                $site_url
            );

            STM_LMS_Mails::send_email($subject, $message, $email, array(), 'stm_lms_new_user_creds', compact('username', 'password', 'site_url'));

            if (!is_wp_error($user_id)) $users[] = $user_id;

        }

        return $users;

    }

}
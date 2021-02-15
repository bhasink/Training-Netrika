<?php

new STM_LMS_User_Manager_Course();

class STM_LMS_User_Manager_Course
{

    public function __construct()
    {

        add_action('wp_ajax_stm_lms_dashboard_get_course_students', array($this, 'students'));

        add_action('wp_ajax_stm_lms_dashboard_delete_user_from_course', array($this, 'delete_user'));
    }

    function students()
    {
        $course_id = intval($_GET['course_id']);

        $data = array_reverse(array_map(array($this, 'map_students'), stm_lms_get_course_users($course_id)));

        $data['students'] = $data;
        $data['origin_title'] = get_the_title($course_id);
        $data['title'] = sprintf(esc_html__('Students of %s', 'masterstudy-lms-learning-management-system'), get_the_title($course_id));

        wp_send_json($data);

    }

    function map_students($student_course)
    {
        $user_id = $student_course['user_id'];

        $student_course['ago'] = stm_lms_time_elapsed_string(gmdate("Y-m-d\TH:i:s\Z", $student_course['start_time']));

        $student_course['student'] = STM_LMS_User::get_current_user($user_id);

        if(empty($student_course['student']['login'])) $student_course['student']['login'] = esc_html__('Deleted user', 'masterstudy-lms-learning-management-system');

        return $student_course;
    }

    function delete_user() {

        $course_id = intval($_GET['course_id']);
        $user_id = intval($_GET['user_id']);

        if(!STM_LMS_Course::check_course_author($course_id, get_current_user_id())) die;

        stm_lms_get_delete_user_course($user_id, $course_id);
    }

}